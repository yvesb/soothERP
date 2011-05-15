<?php
// *************************************************************************************************************
// CLASSE REGISSANT LES INFORMATIONS SUR UN COMPTE CAISSE 
// *************************************************************************************************************


final class compte_caisse {
	protected $id_compte_caisse;

	protected $lib_caisse;
	protected $id_magasin;
	
	protected $id_compte_tpe;
	
	protected $actif;
	protected $ordre;

	protected $last_id_compte_caisse_controle;
	protected $last_date_controle;	
	protected $last_montant_especes;
	
	private $code_pdf_modele_controle = "controle_caisse"; // code pour la class d'impression d'un controle
	private $code_pdf_modele_transfert = "transfert_caisse"; // code pour la class d'impression d'un transfert
	private $code_pdf_modele_depot = "depot_caisse"; // code pour la class d'impression d'un depot
	private $code_pdf_modele_retrait = "retrait_caisse"; // code pour la class d'impression d'un retrait (banque vers caisse)
	
	private $defaut_numero_compte;	// numéro de compte comptable par defaut 


public function __construct ($id_compte_caisse = "") {
	global $bdd;
	global $DEFAUT_COMPTE_CAISSES; // "531";
	
	if (!$id_compte_caisse) { return false; }
	
	$query = "SELECT c.lib_caisse, c.id_magasin, id_compte_tpe, c.ordre, c.actif, defaut_numero_compte
						FROM comptes_caisses c
						WHERE c.id_compte_caisse = '".$id_compte_caisse."' ";
	$resultat = $bdd->query ($query);
	if (!$compte = $resultat->fetchObject()) { return false; }

	$this->id_compte_caisse			= $id_compte_caisse;
	$this->lib_caisse 					= $compte->lib_caisse;
	$this->id_magasin 					= $compte->id_magasin;
	$this->id_compte_tpe 				= $compte->id_compte_tpe;
	$this->actif 								= $compte->actif;
	$this->ordre								= $compte->ordre;
	$this->defaut_numero_compte	= $compte->defaut_numero_compte;
	if (!$this->defaut_numero_compte) {	$this->defaut_numero_compte	= $DEFAUT_COMPTE_CAISSES;}

	return true;
}





// *************************************************************************************************************
// FONCTIONS LIEES A LA CREATION D'UN COMPTE CAISSE
// *************************************************************************************************************

public function create_compte_caisse ($infos) { 
	global $bdd;

	// *************************************************
	// Réception des données
	$this->lib_caisse 		= $infos['lib_caisse'];
	$this->id_magasin			= $infos['id_magasin'];
	$this->id_compte_tpe 	= $infos['id_compte_tpe'];

	// Ordre d'affichage
	$query = "SELECT MAX(ordre) ordre FROM comptes_caisses WHERE id_magasin = '".$this->id_magasin."' ";
	$resultat = $bdd->query($query);
	if ($tmp = $resultat->fetchObject()) {
		$this->ordre = $tmp->ordre+1;
	}
	else {
		$this->ordre = 1;
	}
	unset ($query, $resultat, $tmp);

	if (!$this->lib_caisse) {
		$this->create_lib_caisse ();
	}
	if (!$this->id_magasin) {
		$GLOBALS['_ALERTES']["bad_id_magasin"] = 1;
	}

	if (count($GLOBALS['_ALERTES'])) {
		return false;
	}

	// *************************************************
	// Insertion dans la bdd
	$query = "INSERT INTO comptes_caisses 
							(lib_caisse, id_magasin, id_compte_tpe, ordre, actif)
						VALUES ('".addslashes($this->lib_caisse)."', '".$this->id_magasin."', ".num_or_null($this->id_compte_tpe).", '".$this->ordre."', '1')"; 
	$bdd->exec ($query);
	$this->id_compte_caisse = $bdd->lastInsertId();
	
	return true;
}


private function create_lib_caisse () {
	$this->lib_caisse = "Caisse ".$_SESSION['magasins'][$this->id_magasin]->getLib_magasin()." n°".$this->ordre;
}



// *************************************************************************************************************
// FONCTIONS DE MISE A JOUR DES DONNEES 
// *************************************************************************************************************
public function maj_compte_caisse ($infos) {
	global $bdd;

	// *************************************************
	// Réception des données
	$this->lib_caisse 		= $infos['lib_caisse'];
	if ($this->id_magasin != $infos['id_magasin'] && isset($_SESSION['magasins'][$infos['id_magasin']]) ) { 
		$this->id_magasin = $infos['id_magasin'];
	}
	
	$this->id_compte_tpe 	= $infos['id_compte_tpe'];

	if (!$this->lib_caisse) {
		$this->create_lib_caisse ();
	}

	if (count($GLOBALS['_ALERTES'])) {
		return false;
	}

	// *************************************************
	// MAJ de la bdd
	$query = "UPDATE comptes_caisses 
						SET lib_caisse = '".addslashes($this->lib_caisse)."', id_magasin = '".$this->id_magasin."', id_compte_tpe = ".num_or_null($this->id_compte_tpe)."
						WHERE id_compte_caisse = '".$this->id_compte_caisse."' "; 
	$bdd->exec ($query);

	return true;
}

//mise à jour du numéro de compte par défaut
public function maj_defaut_numero_compte ($defaut_numero_compte) {
	global $bdd;
	
	// *************************************************
	// Controle des données transmises
	if ($defaut_numero_compte == $this->defaut_numero_compte ) {
		return false;
	}
	$this->defaut_numero_compte		= $defaut_numero_compte;

	// *************************************************
	// Si les valeurs reçues sont incorrectes
	if (count($GLOBALS['_ALERTES'])) {
		return false;
	}

	// *************************************************
	// Mise a jour de la base
	$query = "UPDATE comptes_caisses 
						SET defaut_numero_compte = '".addslashes($this->defaut_numero_compte)."'
						WHERE id_compte_caisse = '".$this->id_compte_caisse."' ";
	$bdd->exec ($query);
	
	return true;
}

// Active un compte
function active_compte () {
	global $bdd;

	if ($this->actif) { return false; }

	// *************************************************
	// MAJ de la base de donnée
	$query = "UPDATE comptes_caisses 
						SET actif = 1
						WHERE id_compte_caisse = '".$this->id_compte_caisse."' "; 
	$bdd->exec ($query);

	$this->actif = 1;
	return true;
}

// Désactive un compte
function desactive_compte () {
	global $bdd;

	if (!$this->actif) { return false; }

	// *************************************************
	// Controle de la possibilité de désactiver ce compte 
// Controle si Inactivation de la  caisse elle ne dois pas contenir de fonds
	if ($this->actif) {
		$query = "SELECT SUM(montant_contenu) montant FROM comptes_caisses_contenu WHERE id_compte_caisse = '".$this->id_compte_caisse."' ";
		$resultat	=	$bdd->query ($query);
		$caisses = $resultat->fetchObject();
		if ($caisses->montant != 0) {
			$GLOBALS['_ALERTES']['caisse_fonds_present'] = 1;
			return false;
		}
	}

	// *************************************************
	// MAJ de la base de donnée
	$query = "UPDATE comptes_caisses 
						SET actif = 0
						WHERE id_compte_caisse = '".$this->id_compte_caisse."' "; 
	$bdd->exec ($query);

	$this->actif = 0;
	return true;
}


public function modifier_ordre ($new_ordre) {
	global $bdd;
	if ($new_ordre == $this->ordre) { return false; }

	if (!is_numeric($new_ordre)) {
		$GLOBALS['_ALERTES']['bad_ordre'] = 1;
	}
	
	// *************************************************
	// Si les valeurs reçues sont incorrectes
	if (count($GLOBALS['_ALERTES'])) {
		return false;
	}

	if ($new_ordre < $this->ordre) {
		$variation = "+";
		$symbole1 = "<";
		$symbole2 = ">=";
	}
	else {
		$variation = "-";
		$symbole1 = ">";
		$symbole2 = "<=";
	}

	$bdd->beginTransaction();

	// Mise à jour des autres comptes caisses
	$query = "UPDATE comptes_caisses
						SET ordre = ordre ".$variation." 1
						WHERE id_magasin = '".$this->id_magasin."' && 
									ordre ".$symbole1." '".$this->ordre."' && ordre ".$symbole2." '".$new_ordre."' ";
	$bdd->exec ($query);

	// Mise à jour de ce compte caisse
	$query = "UPDATE comptes_caisses
						SET ordre = '".$new_ordre."'
						WHERE id_compte_caisse = '".$this->id_compte_caisse."'  ";
	$bdd->exec ($query);
	
	$bdd->commit();	

	$this->ordre = $new_ordre;

	// *************************************************
	// Résultat positif de la modification
	return true;
}


// Suppression d'un compte caisse
public function suppression () {
	global $bdd;

	// *************************************************
	// Controle de la possibilité de supprimer la caisse

// Controle si supprimer de la  caisse elle ne dois pas contenir de fonds
	if ($this->actif) {
		$query = "SELECT SUM(montant_contenu) montant FROM comptes_caisses_contenu WHERE id_compte_caisse = '".$this->id_compte_caisse."' ";
		$resultat	=	$bdd->query ($query);
		$caisses = $resultat->fetchObject();
		if ($caisses->montant != 0) {
			$GLOBALS['_ALERTES']['caisse_fonds_present'] = 1;
			return false;
		}
	}

	// Suppression dans la BDD
	$query = "DELETE FROM comptes_caisses WHERE id_compte_caisse = '".$this->id_compte_caisse."' ";
	$bdd->exec ($query);

	unset ($this);
	return true;
}

//*********************************************************************************************
// FONCTIONS DE GESTION DES CAISSES
//*********************************************************************************************

// fonction de création d'un controle de caisse
public function create_controle_caisse ($info) {
	global $bdd;
	global $ESP_E_ID_REGMT_MODE;
	global $CHQ_E_ID_REGMT_MODE;
	global $CB_E_ID_REGMT_MODE;
	

	// *************************************************
	// Insertion dans la bdd
	$query = "INSERT INTO comptes_caisses_controles 
							(id_compte_caisse, ref_user, date_controle, montant_theorique, montant_controle, commentaire)
						VALUES ('".$this->id_compte_caisse."', '".$_SESSION['user']->getRef_user ()."', NOW(), '".$info["montant_theorique"]."', '".$info["montant_controle"]."', '".addslashes($info["commentaire"])."' )";
	$bdd->exec ($query);
	
	$id_compte_caisse_controle = $bdd->lastInsertId();
	//insertion du controle des espèces
	$query = "INSERT INTO comptes_caisses_controles_montants 
							(id_compte_caisse_controle, id_reglement_mode, controle, montant_theorique, montant_controle, infos_theorique, infos_controle)
						VALUES ('".$id_compte_caisse_controle."', '".$ESP_E_ID_REGMT_MODE."', '".$info["ESP"]["controle"]."', '".$info["ESP"]["montant_theorique"]."', '".$info["ESP"]["montant_controle"]."', '".$info["ESP"]["infos_theorique"]."', '".$info["ESP"]["infos_controle"]."')";
	$bdd->exec ($query);
	
	//insertion du controle des chèques
	$query = "INSERT INTO comptes_caisses_controles_montants 
							(id_compte_caisse_controle, id_reglement_mode, controle, montant_theorique, montant_controle, infos_theorique, infos_controle)
						VALUES ('".$id_compte_caisse_controle."', '".$CHQ_E_ID_REGMT_MODE."', '".$info["CHQ"]["controle"]."', '".$info["CHQ"]["montant_theorique"]."', '".$info["CHQ"]["montant_controle"]."', '".$info["CHQ"]["infos_theorique"]."', '".$info["CHQ"]["infos_controle"]."')";
	$bdd->exec ($query);
		
	//insertion du controle des CB
	$query = "INSERT INTO comptes_caisses_controles_montants 
							(id_compte_caisse_controle, id_reglement_mode, controle, montant_theorique, montant_controle, infos_theorique, infos_controle)
						VALUES ('".$id_compte_caisse_controle."', '".$CB_E_ID_REGMT_MODE."', '".$info["CB"]["controle"]."', '".$info["CB"]["montant_theorique"]."', '".$info["CB"]["montant_controle"]."', '".$info["CB"]["infos_theorique"]."', '".$info["CB"]["infos_controle"]."')";
	$bdd->exec ($query);
	
	//si le controle à été effectué, mettre à jour les infos du contenu de caisse
	$infos_contenu = array();
	if ($info["ESP"]["controle"]) {
		$this->del_compte_caisse_contenu ($this->id_compte_caisse, $ESP_E_ID_REGMT_MODE);
		$infos_contenu[] = array("id_compte_caisse"=>$this->id_compte_caisse, "id_reglement_mode"=>$ESP_E_ID_REGMT_MODE, "montant_contenu"=>$info["ESP"]["montant_controle"], "infos_supp"=>"", "controle"=>1);
	}
	if ($info["CHQ"]["controle"]) {
		$this->del_compte_caisse_contenu ($this->id_compte_caisse, $CHQ_E_ID_REGMT_MODE);
		$split_array_CHQ = explode("\n", $info["CHQ"]["infos_controle"]);
		foreach ($split_array_CHQ as $line_chq) {
			$tmp_chq = explode(";", $line_chq);
			if (isset($tmp_chq[0]) && isset($tmp_chq[1])) {
				$infos_contenu[] = array("id_compte_caisse"=>$this->id_compte_caisse, "id_reglement_mode"=>$CHQ_E_ID_REGMT_MODE, "montant_contenu"=>$tmp_chq[0], "infos_supp"=>$tmp_chq[1], "controle"=>1);
			}
		}
	}
	if ($info["CB"]["controle"] && $this->id_compte_tpe) {
		$infos_tp_contenu = array();
		compte_tpe::del_compte_tp_contenu ($this->id_compte_caisse, $this->id_compte_tpe, "TPE");
		$split_array_CB = explode("\n", $info["CB"]["infos_controle"]);
		foreach ($split_array_CB as $line_cb) {
			$tmp_cb = explode(";", $line_cb);
			if (isset($tmp_cb[0]) && isset($tmp_cb[1])) {
				$infos_tp_contenu[] = array("id_compte_tp"=>$this->id_compte_tpe, "tp_type"=>"TPE", "montant_contenu"=>$tmp_cb[0], "id_compte_caisse"=>$this->id_compte_caisse, "infos_supp"=>$tmp_cb[1], "controle"=>1);
			}
		}
		compte_tpe::add_compte_tp_contenu ($infos_tp_contenu);
	}
	
	$this->add_compte_caisse_contenu ($infos_contenu);
	
	
	$this->create_compte_caisse_move ($this->id_compte_caisse, "6", "", ($info["montant_controle"]-$info["montant_theorique"]),$id_compte_caisse_controle);
	return $id_compte_caisse_controle;
	
}

//chargement des infos d'un controle

public function charger_controle_caisse ($id_compte_caisse_controle) {
	global $bdd;
	global $ESP_E_ID_REGMT_MODE;
	global $CHQ_E_ID_REGMT_MODE;
	global $CB_E_ID_REGMT_MODE;


	$controle_caisse = array();
	$query = "SELECT id_compte_caisse_controle, ccc.id_compte_caisse, ref_user, date_controle, montant_theorique, montant_controle, commentaire,
						cc.lib_caisse
						FROM comptes_caisses_controles ccc
						LEFT JOIN comptes_caisses cc  ON cc.id_compte_caisse = ccc.id_compte_caisse
						WHERE id_compte_caisse_controle = '".$id_compte_caisse_controle."' 
						";
	$resultat = $bdd->query ($query);
	if ($tmp = $resultat->fetchObject()) { 
				
		$query_esp = "SELECT id_compte_caisse_controle, id_reglement_mode, controle, montant_theorique, montant_controle, infos_theorique, infos_controle
									FROM comptes_caisses_controles_montants
									WHERE id_reglement_mode = '".$ESP_E_ID_REGMT_MODE."' && id_compte_caisse_controle = '".$id_compte_caisse_controle."' 
									";
		$resultat_esp = $bdd->query ($query_esp);
		if ($tmp_esp = $resultat_esp->fetchObject()) { $tmp->ESP =  $tmp_esp;}
	
		$query_chq = "SELECT id_compte_caisse_controle, id_reglement_mode, controle, montant_theorique, montant_controle, infos_theorique, infos_controle
									FROM comptes_caisses_controles_montants
									WHERE id_reglement_mode = '".$CHQ_E_ID_REGMT_MODE."' && id_compte_caisse_controle = '".$id_compte_caisse_controle."' 
									";
		$resultat_chq = $bdd->query ($query_chq);
		if ($tmp_chq = $resultat_chq->fetchObject()) { $tmp->CHQ =  $tmp_chq;}
	
		$query_cb = "SELECT id_compte_caisse_controle, id_reglement_mode, controle, montant_theorique, montant_controle, infos_theorique, infos_controle
									FROM comptes_caisses_controles_montants
									WHERE id_reglement_mode = '".$CB_E_ID_REGMT_MODE."' && id_compte_caisse_controle = '".$id_compte_caisse_controle."' 
									";
		$resultat_cb = $bdd->query ($query_cb);
		if ($tmp_cb = $resultat_cb->fetchObject()) { $tmp->CB =  $tmp_cb;}
							
	
		$controle_caisse = $tmp; 
		
	}
	
	return $controle_caisse;

}


//fonction d'impression du controle de caisse
public function imprimer_controle_caisse ($print = 0, $id_compte_caisse_controle) {
	global $bdd;
	global $PDF_MODELES_DIR;
	
	// Affichage du pdf
	// Préférences et options
	$GLOBALS['PDF_OPTIONS']['HideToolbar'] = 0;
	$GLOBALS['PDF_OPTIONS']['AutoPrint'] = $print;
	
	include_once ($PDF_MODELES_DIR.$this->code_pdf_modele_controle.".class.php");
	$class = "pdf_".$this->code_pdf_modele_controle;
	$pdf = new $class;
	
	// Création
	$pdf->create_pdf($this, $id_compte_caisse_controle);
	
	// Sortie
	$pdf->Output();

}


// fonction de création d'un transfert de caisse
public function create_transfert_caisse ($info) {
	global $bdd;
	global $ESP_E_ID_REGMT_MODE;
	global $CHQ_E_ID_REGMT_MODE;
	
	
	global $DEFAUT_COMPTE_CAISSES; // "531";
	global $DEFAUT_COMPTE_BANQUES; // "512101";
	global $DEFAUT_COMPTE_VIREMENTS_INTERNES; // "58";
	global $DEFAUT_ID_JOURNAL_BANQUES; // "9";
	global $DEFAUT_ID_JOURNAL_CAISSES; // "10";
	
	
	// *************************************************
	// Insertion dans la bdd
	$query = "INSERT INTO comptes_caisses_transferts 
							(id_compte_caisse_source, id_compte_caisse_destination, ref_user, date_transfert, montant_theorique, montant_transfert, commentaire)
						VALUES ('".$this->id_compte_caisse."', '".$info["id_compte_caisse_destination"]."', '".$_SESSION['user']->getRef_user ()."', NOW(), '".$info["montant_theorique"]."', '".$info["montant_transfert"]."', '".addslashes($info["commentaire"])."' )";
	$bdd->exec ($query);
	
	$id_compte_caisse_transfert = $bdd->lastInsertId();
	
	
	//insertion du transfert des espèces
	$query = "INSERT INTO comptes_caisses_transferts_montants 
							(id_compte_caisse_transfert, id_reglement_mode, montant_theorique, montant_transfert, infos_transfert)
						VALUES ('".$id_compte_caisse_transfert."', '".$ESP_E_ID_REGMT_MODE."', '".$info["ESP"]["montant_theorique"]."', '".$info["ESP"]["montant_transfert"]."', '".$info["ESP"]["infos_transfert"]."')";
	$bdd->exec ($query);
	
	$chq_infos_transfert = "";
	if ($info["CHQ"]["infos_transfert"]) {$chq_infos_transfert .= $info["CHQ"]["infos_transfert"];}
	if ($info["CHQ"]["infos_transfert_add"]) {$chq_infos_transfert .= $info["CHQ"]["infos_transfert_add"];}
	
	//insertion du transfert des chèques
	$query = "INSERT INTO comptes_caisses_transferts_montants 
							(id_compte_caisse_transfert, id_reglement_mode, montant_theorique, montant_transfert, infos_transfert)
						VALUES ('".$id_compte_caisse_transfert."', '".$CHQ_E_ID_REGMT_MODE."', '".$info["CHQ"]["montant_theorique"]."', '".$info["CHQ"]["montant_transfert"]."', '".addslashes($chq_infos_transfert)."')";
	$bdd->exec ($query);
		
		
	// mettre à jour les infos du contenu de caisse
	$infos_contenu = array();
	
	//mise à jour du contenu des caisses
	$this->maj_esp_compte_caisse_contenu ($this->id_compte_caisse, $ESP_E_ID_REGMT_MODE, -$info["ESP"]["montant_transfert"]) ;
	$this->maj_esp_compte_caisse_contenu ($info["id_compte_caisse_destination"], $ESP_E_ID_REGMT_MODE, $info["ESP"]["montant_transfert"]) ;
	
	
	
	//mise à jour du contenu de caisses
	$split_array_CHQ = explode("\n", $info["CHQ"]["infos_transfert"]);
	foreach ($split_array_CHQ as $line_chq) {
		$tmp_chq = explode(";", $line_chq);
		if (isset($tmp_chq[0]) && isset($tmp_chq[1])) {
			$tmp_inf = array();			
			$tmp_inf["id_compte_caisse_destination"] = $info["id_compte_caisse_destination"];
			$tmp_inf["id_compte_caisse_source"] = $this->id_compte_caisse;
			$tmp_inf["id_reglement_mode"] = $CHQ_E_ID_REGMT_MODE;
			$tmp_inf["montant_contenu"] = $tmp_chq[0];
			$tmp_inf["infos_supp"] = $tmp_chq[1];
			$this->update_compte_caisse_contenu ($tmp_inf);
			
		}
	}
	
	$infos_contenu = array();
	$split_array_CHQ_add = explode("\n", $info["CHQ"]["infos_transfert_add"]);
	foreach ($split_array_CHQ_add as $line_chq_add) {
		$tmp_chq_add = explode(";", $line_chq_add);
		if (isset($tmp_chq_add[0]) && isset($tmp_chq_add[1])) {
			$infos_contenu[] = array("id_compte_caisse"=>$info["id_compte_caisse_destination"], "id_reglement_mode"=>$CHQ_E_ID_REGMT_MODE, "montant_contenu"=>$tmp_chq_add[0], "infos_supp"=>$tmp_chq_add[1], "controle"=>1);
		}
	}

	$this->add_compte_caisse_contenu ($infos_contenu);
	
	
	//création des mouvements de caisse
	$this->create_compte_caisse_move ($this->id_compte_caisse, 2, "", -$info["montant_transfert"], $id_compte_caisse_transfert);
	$this->create_compte_caisse_move ($info["id_compte_caisse_destination"], 2, "", $info["montant_transfert"], $id_compte_caisse_transfert);
	
	
	//verification du besoin de créer une opération dans les journaux des caisses
	$caisse_cible = new compte_caisse ($info["id_compte_caisse_destination"]);
	if ($this->defaut_numero_compte != $caisse_cible->getDefaut_numero_compte ()) {
		//les deux caisses ont des comptes comptables différents alors on traite le transfert dans les journaux de caisse
		//vérificaation des journaux correspondant au comptes
		$journal_caisse_depart = compta_journaux::check_exist_journaux ($DEFAUT_ID_JOURNAL_CAISSES, $this->defaut_numero_compte);
		$journal_caisse_arrivee = compta_journaux::check_exist_journaux ($DEFAUT_ID_JOURNAL_CAISSES, $caisse_cible->getDefaut_numero_compte ());
		
		//création des opérations de journaux
		$journal_caisse_depart->create_operation ($DEFAUT_COMPTE_VIREMENTS_INTERNES, -$info["montant_transfert"], $id_compte_caisse_transfert, date("Y-m-d H:i:s"), 9); 
		
		$journal_caisse_arrivee->create_operation ($DEFAUT_COMPTE_VIREMENTS_INTERNES, $info["montant_transfert"], $id_compte_caisse_transfert, date("Y-m-d H:i:s"), 10); 
		
	}
	
	return $id_compte_caisse_transfert;
	
}


//chargement des infos d'un transfert

public function charger_transfert_caisse ($id_compte_caisse_transfert) {
	global $bdd;
	global $ESP_E_ID_REGMT_MODE;
	global $CHQ_E_ID_REGMT_MODE;

	$transfert_caisse = array();
	$query = "SELECT cct.id_compte_caisse_transfert, cct.id_compte_caisse_source, cct.id_compte_caisse_destination, cct.ref_user, cct.date_transfert, cct.montant_theorique, cct.montant_transfert, cct.commentaire, 
						cc.lib_caisse as lib_caisse_source,
						cc2.lib_caisse as lib_caisse_dest
						FROM comptes_caisses_transferts cct
						LEFT JOIN comptes_caisses cc  ON cc.id_compte_caisse = cct.id_compte_caisse_source
						LEFT JOIN comptes_caisses cc2  ON cc2.id_compte_caisse = cct.id_compte_caisse_destination
						WHERE id_compte_caisse_transfert = '".$id_compte_caisse_transfert."' 
						";
	$resultat = $bdd->query ($query);
	if ($tmp = $resultat->fetchObject()) { 
				
		$query_esp = "SELECT id_compte_caisse_transfert, id_reglement_mode, montant_theorique, montant_transfert, infos_transfert
									FROM comptes_caisses_transferts_montants
									WHERE id_reglement_mode = '".$ESP_E_ID_REGMT_MODE."' && id_compte_caisse_transfert = '".$id_compte_caisse_transfert."' 
									";
		$resultat_esp = $bdd->query ($query_esp);
		if ($tmp_esp = $resultat_esp->fetchObject()) { $tmp->ESP =  $tmp_esp;}
	
		$query_chq = "SELECT id_compte_caisse_transfert, id_reglement_mode, montant_theorique, montant_transfert, infos_transfert
									FROM comptes_caisses_transferts_montants
									WHERE id_reglement_mode = '".$CHQ_E_ID_REGMT_MODE."' && id_compte_caisse_transfert = '".$id_compte_caisse_transfert."' 
									";
		$resultat_chq = $bdd->query ($query_chq);
		if ($tmp_chq = $resultat_chq->fetchObject()) { $tmp->CHQ =  $tmp_chq;}
	

	
		$transfert_caisse = $tmp; 
		
	}
	
	return $transfert_caisse;

}


//fonction d'impression du controle de caisse
public function imprimer_transfert_caisse ($print = 0, $id_compte_caisse_transfert) {
	global $bdd;
	global $PDF_MODELES_DIR;
	
	// Affichage du pdf
	// Préférences et options
	$GLOBALS['PDF_OPTIONS']['HideToolbar'] = 0;
	$GLOBALS['PDF_OPTIONS']['AutoPrint'] = $print;
	
	include_once ($PDF_MODELES_DIR.$this->code_pdf_modele_transfert.".class.php");
	$class = "pdf_".$this->code_pdf_modele_transfert;
	$pdf = new $class;
	
	// Création
	$pdf->create_pdf($this, $id_compte_caisse_transfert);
	
	// Sortie
	$pdf->Output();

}

// fonction de création d'un dépot de caisse vers la banque
public function create_depot_caisse ($info) {
	global $bdd;
	global $ESP_E_ID_REGMT_MODE;
	global $CHQ_E_ID_REGMT_MODE;
	global $LC_E_ID_REGMT_MODE;
	
	global $DEFAUT_COMPTE_CAISSES; // "531";
	global $DEFAUT_COMPTE_BANQUES; // "512101";
	global $DEFAUT_COMPTE_VIREMENTS_INTERNES; // "58";
	global $DEFAUT_ID_JOURNAL_BANQUES; // "9";
	global $DEFAUT_ID_JOURNAL_CAISSES; // "10";
	
	
	// *************************************************
	// Insertion dans la bdd
	$query = "INSERT INTO comptes_caisses_depots 
							(id_compte_caisse_source, id_compte_bancaire_destination, ref_user, date_depot, montant_depot, num_remise, commentaire)
						VALUES ('".$this->id_compte_caisse."', '".$info["id_compte_bancaire_destination"]."', '".$_SESSION['user']->getRef_user ()."', NOW(), '".$info["montant_depot"]."', '".$info["num_remise"]."', '".addslashes($info["commentaire"])."' )";
	$bdd->exec ($query);
	
	$id_compte_caisse_depot = $bdd->lastInsertId();
	

	if (isset($info["ESP"])) {
		//insertion du depot des espèces
		$query = "INSERT INTO comptes_caisses_depots_montants 
								(id_compte_caisse_depot, id_reglement_mode, montant_depot, infos_depot)
							VALUES ('".$id_compte_caisse_depot."', '".$ESP_E_ID_REGMT_MODE."', '".$info["ESP"]["montant_depot"]."', '".$info["ESP"]["infos_depot"]."')";
		$bdd->exec ($query);
		
		//mise à jour du contenu des caisses
		$this->maj_esp_compte_caisse_contenu ($this->id_compte_caisse, $ESP_E_ID_REGMT_MODE, -$info["ESP"]["montant_depot"]) ;
	}

	if (isset($info["CHQ"])) {
		//insertion des depots des chèques
		foreach ($info["CHQ"]["liste_cheques"] as $line_chq) {
			$query = "INSERT INTO comptes_caisses_depots_montants 
									(id_compte_caisse_depot, id_reglement_mode, montant_depot, infos_depot)
								VALUES ('".$id_compte_caisse_depot."', '".$CHQ_E_ID_REGMT_MODE."', '".$line_chq["montant_depot"]."', '".addslashes($line_chq["infos_depot"])."')";
			$bdd->exec ($query);
			
			$tmp_inf = array();			
			$tmp_inf["id_compte_caisse_source"] = $this->id_compte_caisse;
			$tmp_inf["id_reglement_mode"] = $CHQ_E_ID_REGMT_MODE;
			$tmp_inf["montant_contenu"] = $line_chq["montant_depot"];
			//découpe ligne info depot pour récupérer une ref
			$tmp_inf["infos_supp"] = "";
			$tmp_chq = explode(";", $line_chq["infos_depot"]);
			if (isset($tmp_chq[0])) {
				$tmp_inf["infos_supp"] = $tmp_chq[0];
			}
			$this->del_line_compte_caisse_contenu ($tmp_inf);
		}
		
		foreach ($info["CHQ"]["liste_cheques_add"] as $line_chq_add) {
			$query = "INSERT INTO comptes_caisses_depots_montants 
									(id_compte_caisse_depot, id_reglement_mode, montant_depot, infos_depot)
								VALUES ('".$id_compte_caisse_depot."', '".$CHQ_E_ID_REGMT_MODE."', '".$line_chq_add["montant_depot"]."', '".addslashes($line_chq_add["infos_depot"])."')";
			$bdd->exec ($query);
		}
	}
		if (isset($info["LC"])) {
		//insertion des depots des chèques
		foreach ($info["LC"]["liste_cheques"] as $line_chq) {
			$query = "INSERT INTO comptes_caisses_depots_montants 
									(id_compte_caisse_depot, id_reglement_mode, montant_depot, infos_depot)
								VALUES ('".$id_compte_caisse_depot."', '".$LC_E_ID_REGMT_MODE."', '".$line_chq["montant_depot"]."', '".addslashes($line_chq["infos_depot"])."')";
			$bdd->exec ($query);
			
			$tmp_inf = array();			
			$tmp_inf["id_compte_caisse_source"] = $this->id_compte_caisse;
			$tmp_inf["id_reglement_mode"] = $LC_E_ID_REGMT_MODE;
			$tmp_inf["montant_contenu"] = $line_chq["montant_depot"];
			//découpe ligne info depot pour récupérer une ref
			$tmp_inf["infos_supp"] = "";
			$tmp_chq = explode(";", $line_chq["infos_depot"]);
			if (isset($tmp_chq[0])) {
				$tmp_inf["infos_supp"] = $tmp_chq[0];
			}
			$this->del_line_compte_caisse_contenu ($tmp_inf);
		}
	}
	//création du mouvements de caisse
	$this->create_compte_caisse_move ($this->id_compte_caisse, 4, "", -$info["montant_depot"], $id_compte_caisse_depot);


	//création des opérations dans le journal de caisse et de banque correspondant
	$compte_bancaire_cible = new compte_bancaire ($info["id_compte_bancaire_destination"]);
		//vérification des journaux correspondant au comptes
		$journal_caisse_depart = compta_journaux::check_exist_journaux ($DEFAUT_ID_JOURNAL_CAISSES, $this->defaut_numero_compte);
		$journal_banque_arrivee = compta_journaux::check_exist_journaux ($DEFAUT_ID_JOURNAL_BANQUES, $compte_bancaire_cible->getDefaut_numero_compte ());
		
		//création des opérations de journaux
		$journal_caisse_depart->create_operation ($DEFAUT_COMPTE_VIREMENTS_INTERNES, -$info["montant_depot"], $id_compte_caisse_depot, date("Y-m-d H:i:s"), 1); 
		
		$journal_banque_arrivee->create_operation ($DEFAUT_COMPTE_VIREMENTS_INTERNES, $info["montant_depot"], $id_compte_caisse_depot, date("Y-m-d H:i:s"), 2); 
		
	
	return $id_compte_caisse_depot;
	
}



//chargement des infos d'un depot

public function charger_depot_caisse ($id_compte_caisse_depot) {
	global $bdd;
	global $ESP_E_ID_REGMT_MODE;
	global $CHQ_E_ID_REGMT_MODE;

	$depot_caisse = array();
	$query = "SELECT ccd.id_compte_caisse_depot, ccd.id_compte_caisse_source, ccd.id_compte_bancaire_destination, ccd.ref_user, ccd.date_depot, ccd.montant_depot, ccd.num_remise, ccd.commentaire,
						cc.lib_caisse ,
						cc2.lib_compte, cc2.numero_compte, a.nom
						FROM comptes_caisses_depots ccd
						LEFT JOIN comptes_caisses cc  ON cc.id_compte_caisse = ccd.id_compte_caisse_source
						LEFT JOIN comptes_bancaires cc2  ON cc2.id_compte_bancaire = ccd.id_compte_bancaire_destination
						LEFT JOIN annuaire a  ON cc2.ref_contact = a.ref_contact
						WHERE id_compte_caisse_depot = '".$id_compte_caisse_depot."' 
						";
	$resultat = $bdd->query ($query);
	if ($tmp = $resultat->fetchObject()) { 

		$tmp->ESP = new stdclass;
		$query_esp = "SELECT id_compte_caisse_depot, id_reglement_mode, montant_depot, infos_depot
									FROM comptes_caisses_depots_montants
									WHERE id_reglement_mode = '".$ESP_E_ID_REGMT_MODE."' && id_compte_caisse_depot = '".$id_compte_caisse_depot."' 
									";
		$resultat_esp = $bdd->query ($query_esp);
		if ($tmp_esp = $resultat_esp->fetchObject()) { $tmp->ESP =  $tmp_esp;}
	
		$tmp->CHQ = array();
		$query_chq = "SELECT id_compte_caisse_depot, id_reglement_mode, montant_depot, infos_depot
									FROM comptes_caisses_depots_montants
									WHERE id_reglement_mode = '".$CHQ_E_ID_REGMT_MODE."' && id_compte_caisse_depot = '".$id_compte_caisse_depot."' 
									";
		$resultat_chq = $bdd->query ($query_chq);
		while ($tmp_chq = $resultat_chq->fetchObject()) { $tmp->CHQ[] =  $tmp_chq;}
	

	
		$depot_caisse = $tmp; 
		
	}
	
	return $depot_caisse;

}


//fonction d'impression du depot de caisse
public function imprimer_depot_caisse ($print = 0, $id_compte_caisse_depot) {
	global $bdd;
	global $PDF_MODELES_DIR;
	
	// Affichage du pdf
	// Préférences et options
	$GLOBALS['PDF_OPTIONS']['HideToolbar'] = 0;
	$GLOBALS['PDF_OPTIONS']['AutoPrint'] = $print;
	
	include_once ($PDF_MODELES_DIR.$this->code_pdf_modele_depot.".class.php");
	$class = "pdf_".$this->code_pdf_modele_depot;
	$pdf = new $class;
	
	// Création
	$pdf->create_pdf($this, $id_compte_caisse_depot);
	
	// Sortie
	$pdf->Output();

}

// fonction de création d'un retrait de la banque vers la caisse 
public function create_retrait_caisse ($info) {
	global $bdd;
	global $ESP_E_ID_REGMT_MODE;
	
	
	global $DEFAUT_COMPTE_CAISSES; // "531";
	global $DEFAUT_COMPTE_BANQUES; // "512101";
	global $DEFAUT_COMPTE_VIREMENTS_INTERNES; // "58";
	global $DEFAUT_ID_JOURNAL_BANQUES; // "9";
	global $DEFAUT_ID_JOURNAL_CAISSES; // "10";


		
	// *************************************************
	// Insertion dans la bdd
	$query = "INSERT INTO comptes_caisses_retraits 
							(id_compte_caisse_destination, id_compte_bancaire_source, ref_user, date_retrait, montant_retrait, commentaire)
						VALUES ('".$this->id_compte_caisse."', '".$info["id_compte_bancaire_source"]."', '".$_SESSION['user']->getRef_user ()."', NOW(), '".$info["montant_retrait"]."', '".addslashes($info["commentaire"])."' )";
	$bdd->exec ($query);
	
	$id_compte_caisse_retrait = $bdd->lastInsertId();
	
	
	
	//insertion du depot des espèces
	$query = "INSERT INTO comptes_caisses_retraits_montants 
							(id_compte_caisse_retrait, id_reglement_mode, montant_retrait, infos_retrait)
						VALUES ('".$id_compte_caisse_retrait."', '".$ESP_E_ID_REGMT_MODE."', '".$info["ESP"]["montant_retrait"]."', '".$info["ESP"]["infos_retrait"]."')";
	$bdd->exec ($query);
	
	
	//mise à jour du contenu des caisses
	$this->maj_esp_compte_caisse_contenu ($this->id_compte_caisse, $ESP_E_ID_REGMT_MODE, $info["ESP"]["montant_retrait"]) ;
	//création du mouvements de caisse
	$this->create_compte_caisse_move ($this->id_compte_caisse, 3, "", $info["montant_retrait"], $id_compte_caisse_retrait);

	//création des opérations dans le journal de caisse et de banque correspondant
	$compte_bancaire_source = new compte_bancaire ($info["id_compte_bancaire_source"]);
		//vérification des journaux correspondant au comptes
		$journal_banque_depart = compta_journaux::check_exist_journaux ($DEFAUT_ID_JOURNAL_BANQUES, $compte_bancaire_source->getDefaut_numero_compte ());
		
		$journal_caisse_arrivee = compta_journaux::check_exist_journaux ($DEFAUT_ID_JOURNAL_CAISSES, $this->defaut_numero_compte);
		
		//création des opérations de journaux
		$journal_banque_depart->create_operation ($DEFAUT_COMPTE_VIREMENTS_INTERNES, -$info["montant_retrait"], $id_compte_caisse_retrait, date("Y-m-d H:i:s"), 3); 
		
		$journal_caisse_arrivee->create_operation ($DEFAUT_COMPTE_VIREMENTS_INTERNES, $info["montant_retrait"], $id_compte_caisse_retrait, date("Y-m-d H:i:s"), 4); 
		
		
	
	return $id_compte_caisse_retrait;
	
}



//chargement des infos d'un retrait

public function charger_retrait_caisse ($id_compte_caisse_retrait) {
	global $bdd;
	global $ESP_E_ID_REGMT_MODE;
	global $CHQ_E_ID_REGMT_MODE;

	$retrait_caisse = array();
	$query = "SELECT ccr.id_compte_caisse_retrait, ccr.id_compte_caisse_destination, ccr.id_compte_bancaire_source, ccr.ref_user, ccr.date_retrait, ccr.montant_retrait, ccr.commentaire,
						cc.lib_caisse ,
						cc2.lib_compte, cc2.numero_compte, a.nom
						FROM comptes_caisses_retraits ccr
						LEFT JOIN comptes_caisses cc  ON cc.id_compte_caisse = ccr.id_compte_caisse_destination
						LEFT JOIN comptes_bancaires cc2  ON cc2.id_compte_bancaire = ccr.id_compte_bancaire_source
						LEFT JOIN annuaire a  ON cc2.ref_contact = a.ref_contact
						WHERE id_compte_caisse_retrait = '".$id_compte_caisse_retrait."' 
						";
	$resultat = $bdd->query ($query);
	if ($tmp = $resultat->fetchObject()) { 
				
		$query_esp = "SELECT id_compte_caisse_retrait, id_reglement_mode, montant_retrait, infos_retrait
									FROM comptes_caisses_retraits_montants
									WHERE id_reglement_mode = '".$ESP_E_ID_REGMT_MODE."' && id_compte_caisse_retrait = '".$id_compte_caisse_retrait."' 
									";
		$resultat_esp = $bdd->query ($query_esp);
		if ($tmp_esp = $resultat_esp->fetchObject()) { $tmp->ESP =  $tmp_esp;}
	
		$retrait_caisse = $tmp; 
		
	}
	
	return $retrait_caisse;

}


//fonction d'impression du depot de caisse
public function imprimer_retrait_caisse ($print = 0, $id_compte_caisse_retrait) {
	global $bdd;
	global $PDF_MODELES_DIR;
	
	// Affichage du pdf
	// Préférences et options
	$GLOBALS['PDF_OPTIONS']['HideToolbar'] = 0;
	$GLOBALS['PDF_OPTIONS']['AutoPrint'] = $print;
	
	include_once ($PDF_MODELES_DIR.$this->code_pdf_modele_retrait.".class.php");
	$class = "pdf_".$this->code_pdf_modele_retrait;
	$pdf = new $class;
	
	// Création
	$pdf->create_pdf($this, $id_compte_caisse_retrait);
	
	// Sortie
	$pdf->Output();

}

// fonction de création d'un mouvement de fonds (entrant ou sortant sans source ou cible définie)
public function create_ar_fonds_caisse ($info) {
	global $bdd;
	global $ESP_E_ID_REGMT_MODE;
	

	// *************************************************
	// Insertion dans la bdd
	$query = "INSERT INTO comptes_caisses_ar_fonds 
							(id_compte_caisse, ref_user, date_ar, montant_ar, commentaire)
						VALUES ('".$this->id_compte_caisse."', '".$_SESSION['user']->getRef_user ()."', NOW(), '".$info["montant_ar"]."', '".addslashes($info["commentaire"])."' )";
	$bdd->exec ($query);
	
	$id_compte_caisse_ar = $bdd->lastInsertId();
	
	
	//mise à jour du contenu des caisses
	$this->maj_esp_compte_caisse_contenu ($this->id_compte_caisse, $ESP_E_ID_REGMT_MODE, $info["montant_ar"]) ;
	//création du mouvements de caisse
	$this->create_compte_caisse_move ($this->id_compte_caisse, 7, "", $info["montant_ar"], $id_compte_caisse_ar);

	return $id_compte_caisse_ar;
	
}
public function charger_ar_caisse ($id_compte_ar) {
	global $bdd;
	global $ESP_E_ID_REGMT_MODE;
	global $CHQ_E_ID_REGMT_MODE;

	$caisse_ar = array();
	$query = "SELECT ccr.id_compte_caisse_ar, ccr.id_compte_caisse, ccr.ref_user, ccr.date_ar, ccr.montant_ar, ccr.commentaire, 
						cc.lib_caisse 
						FROM comptes_caisses_ar_fonds ccr
						LEFT JOIN comptes_caisses cc  ON cc.id_compte_caisse = ccr.id_compte_caisse
						WHERE id_compte_caisse_ar = '".$id_compte_ar."' 
						";
	$resultat = $bdd->query ($query);
	if ($tmp = $resultat->fetchObject()) { 
			
		$caisse_ar = $tmp; 
		
	}
	
	return $caisse_ar;

}


//chargement du dernier controle
public function charger_last_controle() {
	global $bdd;
	
	$query = "SELECT MAX(id_compte_caisse_controle) id_compte_caisse_controle FROM comptes_caisses_controles WHERE id_compte_caisse = '".$this->id_compte_caisse."' ";
	$resultat = $bdd->query($query);
	if ($tmp = $resultat->fetchObject()) {
		$this->last_id_compte_caisse_controle = $tmp->id_compte_caisse_controle;
	}
	// date du dernier controle
	$query = "SELECT date_controle, montant_controle, montant_theorique FROM comptes_caisses_controles WHERE id_compte_caisse_controle = '".$this->last_id_compte_caisse_controle."' ";
	$resultat = $bdd->query($query);
	if ($tmp = $resultat->fetchObject()) {
		$this->last_date_controle = $tmp->date_controle;
		$this->last_montant_controle = $tmp->montant_controle;
	}
	

}



// fonction de récupération des totals des mouvements depuis le dernier controle de caisse
public function controle_total_caisse_move () {
	global $bdd;
	global $ESP_E_ID_REGMT_MODE;
	global $CHQ_E_ID_REGMT_MODE;
	global $CB_E_ID_REGMT_MODE;
	
	
	//récupération des totaux des différents modes de règlement
	$total_theorique = array();
	$total_theorique[$ESP_E_ID_REGMT_MODE] = 0;
	$total_theorique[$CHQ_E_ID_REGMT_MODE] = 0;
	$total_theorique[$CB_E_ID_REGMT_MODE] = 0;
	
	$query = "SELECT SUM(montant_contenu) solde, id_reglement_mode FROM comptes_caisses_contenu WHERE id_compte_caisse='".$this->id_compte_caisse."' GROUP BY id_reglement_mode
						";
	$resultat = $bdd->query($query);
	while ($total = $resultat->fetchObject()) { $total_theorique[$total->id_reglement_mode] = $total->solde;}
	
	$query2 = "SELECT SUM(montant_contenu) solde FROM comptes_tp_contenu WHERE id_compte_caisse='".$this->id_compte_caisse."' ";
	$resultat2 = $bdd->query($query2);
	while ($total2 = $resultat2->fetchObject()) { $total_theorique[$CB_E_ID_REGMT_MODE] = $total2->solde;}
	
	return $total_theorique;
	
}


// fonction de récupération du nombre d'opérations par mode de reglement
public function count_caisse_contenu ($id_reglement_mode) {
	global $bdd;
	
	
	global $ESP_E_ID_REGMT_MODE;
	global $CHQ_E_ID_REGMT_MODE;
	global $CB_E_ID_REGMT_MODE;
	
	
	
	//récupération des totaux des différents modes de règlement
	$count_theorique = array();
	
	if ($id_reglement_mode != $CB_E_ID_REGMT_MODE) {
		$query = "SELECT id_compte_caisse, id_reglement_mode, montant_contenu, infos_supp, controle FROM comptes_caisses_contenu WHERE id_compte_caisse='".$this->id_compte_caisse."' && id_reglement_mode = '".$id_reglement_mode."' 
							";
		$resultat = $bdd->query($query);
		while ($total = $resultat->fetchObject()) { $count_theorique[] = $total;}
	} else {
		$query = "SELECT id_compte_tp, tp_type, montant_contenu, id_compte_caisse, infos_supp, controle FROM comptes_tp_contenu WHERE id_compte_caisse='".$this->id_compte_caisse."'  
							";
		$resultat = $bdd->query($query);
		while ($total = $resultat->fetchObject()) { $count_theorique[] = $total;}
	}
	
	return $count_theorique;
	
}

// *************************************************************************************************************
// FONCTIONS EXTERNES 
// *************************************************************************************************************

// fonction de création d'un compte_caisse_move
static function create_compte_caisse_move ($id_compte_caisse, $id_move_type, $id_reglement_mode = "", $montant_move = "", $info_supp = "") { 
	global $bdd;


	if (count($GLOBALS['_ALERTES'])) {
		return false;
	}

	// *************************************************
	// Insertion dans la bdd
	$query = "INSERT INTO comptes_caisses_moves 
							(id_compte_caisse, id_move_type, id_reglement_mode, date_move, ref_user, montant_move, Info_supp)
						VALUES ('".$id_compte_caisse."', '".$id_move_type."', ".num_or_null($id_reglement_mode).", NOW(), '".$_SESSION['user']->getRef_user ()."', '".$montant_move."', '".$info_supp."')"; 
	$bdd->exec ($query);
	
	$GLOBALS['_INFOS']['create_id_comptes_caisses_moves'] = $bdd->lastInsertId();
	return true;
}


//mise à jour du contenu de la caisse pour les especes
static function maj_esp_compte_caisse_contenu ($id_compte_caisse, $id_reglement_mode, $montant_contenu, $infos_supp = "", $controle = 0) {
	global $bdd;
	
	$query = "SELECT id_compte_caisse, id_reglement_mode, montant_contenu, infos_supp, controle
						FROM comptes_caisses_contenu ccc
						WHERE  ccc.id_compte_caisse = '".$id_compte_caisse."' && ccc.id_reglement_mode = ".$id_reglement_mode."
						";
	$resultat = $bdd->query($query);
	if ($tmp = $resultat->fetchObject()) {
		//ligne espèces pour cette caisse existe, on met à jour
		$query2 = "UPDATE comptes_caisses_contenu
							SET montant_contenu = '".($tmp->montant_contenu + $montant_contenu)."' 
							WHERE id_compte_caisse = '".$id_compte_caisse."' && id_reglement_mode = '".$id_reglement_mode."' ";

		$bdd->exec ($query2);
	} else {
		//sinon on la crée
		compte_caisse::add_compte_caisse_contenu (array(array("id_compte_caisse"=>$id_compte_caisse, "id_reglement_mode"=>$id_reglement_mode, "montant_contenu"=>$montant_contenu, "infos_supp"=>$infos_supp, "controle"=>0)));
	}
	
	return true;
}

//ajout de lignes de contenu de caisse
static function add_compte_caisse_contenu ($infos) {
	global $bdd;
	
	$valeurs = "";
	foreach ($infos as $info) {
		if ($valeurs) {$valeurs .= ", ";}
		$valeurs .= "('".$info["id_compte_caisse"]."', ".num_or_null($info["id_reglement_mode"]).", '".($info["montant_contenu"])."', '".$info["infos_supp"]."', '".$info["controle"]."')";
	}
	if (!$valeurs) { return false;}
	$query = "INSERT INTO comptes_caisses_contenu 
						(id_compte_caisse, id_reglement_mode, montant_contenu, infos_supp, controle)
						VALUES ".$valeurs; 
	$bdd->exec ($query);
	
	return true;
}


//modification d'attribution de caisse pour une ligne de contenu de caisse
static function update_compte_caisse_contenu ($info) {
	global $bdd;
	$query = "UPDATE comptes_caisses_contenu
							SET id_compte_caisse = '".($info["id_compte_caisse_destination"])."' , controle = '0' 
							WHERE id_compte_caisse = '".$info["id_compte_caisse_source"]."' && id_reglement_mode = '".$info["id_reglement_mode"]."' && montant_contenu LIKE '".$info["montant_contenu"]."' && infos_supp = '".addslashes($info["infos_supp"])."'
							LIMIT 1
							";

		$bdd->exec ($query);
	return true;
}

//supression de la caisse pour une ligne de contenu de caisse
static function del_line_compte_caisse_contenu ($info) {
	global $bdd;
	
	if (substr_count($info["montant_contenu"] , ".")) {
		$info["montant_contenu"] = rtrim($info["montant_contenu"], "0");
		if (strpos($info["montant_contenu"], ".") == strlen($info["montant_contenu"])-1) {
			$info["montant_contenu"] = str_replace("." , "", $info["montant_contenu"]);
		}
	}
	
	$query = "DELETE FROM comptes_caisses_contenu
						WHERE id_compte_caisse = '".$info["id_compte_caisse_source"]."' && id_reglement_mode = '".$info["id_reglement_mode"]."' && montant_contenu LIKE '".$info["montant_contenu"]."' && infos_supp = '".addslashes($info["infos_supp"])."'
						LIMIT 1
						";
				
		$bdd->exec ($query);
	return true;
}

//suppression de lignes de contenu de caisse
static function del_compte_caisse_contenu ($id_compte_caisse, $id_reglement_mode) {
	global $bdd;
	
	$query = "DELETE FROM comptes_caisses_contenu 
						WHERE  id_compte_caisse = '".$id_compte_caisse."' && id_reglement_mode = '".$id_reglement_mode."' 
						";
	$bdd->exec ($query);
	
	return true;
}


// Fonction permettant de charger tous les comptes caisses
static function charger_comptes_caisses ($id_magasin = "", $actif = "") {
	global $bdd;
	
	$where = "";
	if ($id_magasin) {
		if (!$where) {$where .= "WHERE";}
		$where .= " c.id_magasin = '".$id_magasin."' " ;
	}
	
	if ($actif) {
		if ($where) {$where .= " && ";}
		if (!$where) {$where .= "WHERE";}
		$where .= "  c.actif = ".$actif;
	}

	$caisses = array();
	$query = "SELECT c.id_compte_caisse, c.lib_caisse, c.id_magasin, c.id_compte_tpe, c.actif, c.ordre, c.defaut_numero_compte, pc.lib_compte, 
									 ct.lib_tpe
						FROM comptes_caisses c
							LEFT JOIN comptes_tpes ct ON ct.id_compte_tpe = c.id_compte_tpe
							LEFT JOIN plan_comptable pc ON pc.numero_compte = c.defaut_numero_compte
						".$where."  
						ORDER BY c.id_magasin ASC, ordre ASC";
	$resultat = $bdd->query ($query);
	while ($tmp = $resultat->fetchObject()) { $caisses[] = $tmp; }
	
	return $caisses;
}


//chargement d'un controle_compte_caisse
static function charge_controle_compte_caisse( $id_compte_caisse_controle = "") {
	global $bdd;
	global $CHQ_E_ID_REGMT_MODE;
	global $CB_E_ID_REGMT_MODE;
	
	if (!$id_compte_caisse_controle) {return false;}
	
	// chargment du controle de caisse
	$controle_caisse = array ();
	$query = "SELECT date_controle, montant_controle, montant_theorique, ccc.ref_user, id_compte_caisse, commentaire , 
									 u.pseudo
						FROM comptes_caisses_controles ccc
							LEFT JOIN users u ON u.ref_user = ccc.ref_user
						WHERE id_compte_caisse_controle = '".$id_compte_caisse_controle."'
						GROUP BY ccc.id_compte_caisse_controle  ";
	$resultat = $bdd->query($query);
	if ($tmp = $resultat->fetchObject()) {
		//chargement des especes correspondant au controle
		$tmp->montant_ESP = array();
		$query = "SELECT id_caisse_controle, id_reglement_mode, controle, montant_theorique, montant_controle, infos_theorique, infos_controle
							FROM comptes_caisses_controles_montants 
							WHERE id_compte_caisse_controle = '".$id_compte_caisse_controle."' && id_reglement_mode = '".$ESP_E_ID_REGMT_MODE."' ";
		$resultat_chq = $bdd->query($query);
		while ($especes = $resultat_chq->fetchObject()) {	$tmp->ESP[] = $especes; }
		
		//chargement des cheques correspondant au controle
		$tmp->montant_CHQ = array();
		$query = "SELECT id_caisse_controle, id_reglement_mode, controle, montant_theorique, montant_controle, infos_theorique, infos_controle
							FROM comptes_caisses_controles_montants 
							WHERE id_compte_caisse_controle = '".$id_compte_caisse_controle."' && id_reglement_mode = '".$CHQ_E_ID_REGMT_MODE."' ";
		$resultat_chq = $bdd->query($query);
		while ($cheques = $resultat_chq->fetchObject()) {	$tmp->CHQ[] = $cheques; }
		
		//chargement des CB correspondant au controle
		$tmp->montant_CB = array();
		$query = "SELECT id_caisse_controle, id_reglement_mode, controle, montant_theorique, montant_controle, infos_theorique, infos_controle
							FROM comptes_caisses_controles_content 
							WHERE id_compte_caisse_controle = '".$id_compte_caisse_controle."' && id_reglement_mode = '".$CB_E_ID_REGMT_MODE."' ";
		$resultat_cb = $bdd->query($query);
		while ($cb = $resultat_cb->fetchObject()) {	$tmp->CB[] = $cb; }
	
	
		$controle_caisse = $tmp;
	}
	
	return $controle_caisse;

}

// *************************************************************************************************************
// FONCTIONS DE RESTITUTION DES DONNEES 
// *************************************************************************************************************

function getId_compte_caisse () {
	return $this->id_compte_caisse;
}

function getLib_caisse () {
	return $this->lib_caisse;
}

function getId_magasin () {
	return $this->id_magasin;
}

function getId_compte_tpe () {
	return $this->id_compte_tpe;
}

function getOrdre () {
	return $this->ordre;
}

function getLast_date_controle () {
	if (!$this->last_date_controle) {
		$this->charger_last_controle();
	}
	return $this->last_date_controle;
}


function getDefaut_numero_compte () {
	return $this->defaut_numero_compte;
}

}


function load_caisse_move ($id_compte_caisse_move) {
	global $bdd;
	global $ESP_E_ID_REGMT_MODE;
	global $CHQ_E_ID_REGMT_MODE;
	global $CB_E_ID_REGMT_MODE;
	
	
	//récupération des totaux des différents modes de règlement
	$infos_compte_caisse_move = "";
	
	$query = "SELECT id_compte_caisse FROM comptes_caisses_moves WHERE id_compte_caisse_move='".$id_compte_caisse_move."' 
						";
	$resultat = $bdd->query($query);
	if ($tmp = $resultat->fetchObject()) { $infos_compte_caisse_move = $tmp->id_compte_caisse;}
	
	
	return $infos_compte_caisse_move;
	
}


?>