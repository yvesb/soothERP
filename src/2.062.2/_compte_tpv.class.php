<?php
// *************************************************************************************************************
// CLASSE REGISSANT LES INFORMATIONS SUR UN TERMINAL DE PAIEMENT ÉLECTRONIQUE
// *************************************************************************************************************


final class compte_tpv {
	protected $id_compte_tpv;

	protected $id_compte_bancaire;
	protected $lib_compte_bancaire;

	protected $lib_tpv;
	protected $module_name;
	
	protected $com_ope; // commission fixe bancaire par opération
	protected $com_var;		// commission fixe bancaire par opération

	protected $actif;
	protected $ordre;

	protected $last_date_telecollecte;
	protected $last_montant_telecollecte;
	protected $last_montant_commission;
	
	private $defaut_numero_compte;	// numéro de compte comptable par defaut 
	
	private $code_pdf_modele_telecollecte = "tp_telecollecte"; // code pour la class d'impression d'une telecollecte


public function __construct ($id_compte_tpv = "") {
	global $bdd;
	global $DEFAUT_COMPTE_CAISSES; // "531";
	
	if (!$id_compte_tpv) { return false; }
	
	$query = "SELECT c.id_compte_bancaire, cb.lib_compte lib_compte_bancaire, c.lib_tpv, c.module_name, c.com_ope, c.com_var,   c.actif, c.ordre, c.defaut_numero_compte
						FROM comptes_tpv c
							LEFT JOIN comptes_bancaires cb ON c.id_compte_bancaire = cb.id_compte_bancaire
						WHERE c.id_compte_tpv = '".$id_compte_tpv."' ";
	$resultat = $bdd->query ($query);
	if (!$compte = $resultat->fetchObject()) { return false; }

	$this->id_compte_tpv				= $id_compte_tpv;
	$this->id_compte_bancaire		= $compte->id_compte_bancaire;
	$this->lib_compte_bancaire	= $compte->lib_compte_bancaire;
	$this->lib_tpv							= $compte->lib_tpv;
	$this->module_name					= $compte->module_name;
	$this->com_ope							= $compte->com_ope;
	$this->com_var							= $compte->com_var;
	$this->actif								= $compte->actif;
	$this->ordre								= $compte->ordre;
	$this->defaut_numero_compte	= $compte->defaut_numero_compte;
	if (!$this->defaut_numero_compte) {	$this->defaut_numero_compte	= $DEFAUT_COMPTE_CAISSES;}
	
	return true;
}





// *************************************************************************************************************
// FONCTIONS LIEES A LA CREATION D'UN TPV
// *************************************************************************************************************

public function create_compte_tpv ($infos) { 
	global $bdd;
	
	// *************************************************
	// Réception des données

	$this->id_compte_bancaire = $infos['id_compte_bancaire'];
	if (!is_numeric($this->id_compte_bancaire)) { 
		$GLOBALS['_ALERTES']['bad_id_compte_bancaire'] = 1; 
		return false;
	}
	$query = "SELECT lib_compte lib_compte_bancaire 
						FROM comptes_bancaires 
						WHERE id_compte_bancaire = '".$this->id_compte_bancaire."' && actif = 1";
	$resultat = $bdd->query($query);
	if (!$tmp = $resultat->fetchObject()) {
		$GLOBALS['_ALERTES']['bad_id_compte_bancaire'] = 1; 
	}

	$this->lib_tpv = $infos['lib_tpv'];
	$this->actif 	= 1;

	// Ordre d'affichage
	$query = "SELECT MAX(ordre) ordre FROM comptes_tpv  ";
	$resultat = $bdd->query($query);
	if ($tmp = $resultat->fetchObject()) {
		$this->ordre = $tmp->ordre+1;
	}
	else {
		$this->ordre = 1;
	}
	unset ($query, $resultat, $tmp);
	
	if (!$this->lib_tpv) {
		$this->create_lib_tpv ();
	}
	
	
	$this->com_ope	= $infos['com_ope'];
	if (!is_numeric($this->com_ope)) { 
			$this->com_ope	= 0;
	}
	
	$this->com_var	= $infos['com_var'];
	if (!is_numeric($this->com_var)) { 
			$this->com_var	= 0;
	}
	
	$this->module_name = $infos['module_name'];

	if (!$this->module_name) {
		$GLOBALS['_ALERTES']['no_module'] = 1; 
	}
	
	if (count($GLOBALS['_ALERTES'])) {
		return false;
	}

	// *************************************************
	// Insertion dans la bdd
	$query = "INSERT INTO comptes_tpv (id_compte_bancaire, lib_tpv, module_name, com_ope, com_var, ordre, actif)
						VALUES ('".$this->id_compte_bancaire."', '".addslashes($this->lib_tpv)."', '".addslashes($this->module_name)."', 
										'".$this->com_ope."' ,'".$this->com_var."' ,'".$this->ordre."', '".$this->actif."')"; 
	$bdd->exec ($query);
	$this->id_compte_tpv = $bdd->lastInsertId();
	
	return true;
}


private function create_lib_tpv () {
	$this->lib_tpv = "TPV  n°".$this->ordre;
}



// *************************************************************************************************************
// FONCTIONS DE MISE A JOUR DES DONNEES 
// *************************************************************************************************************
public function maj_compte_tpv ($infos) {
	global $bdd;

	// *************************************************
	// Réception des données

	if ($this->id_compte_bancaire != $infos['id_compte_bancaire']) {
		$this->id_compte_bancaire = $infos['id_compte_bancaire'];
		if (!is_numeric($this->id_compte_bancaire)) { 
			$GLOBALS['_ALERTES']['bad_id_compte_bancaire'] = 1; 
			return false;
		}
		$query = "SELECT lib_compte lib_compte_bancaire 
							FROM comptes_bancaires 
							WHERE id_compte_bancaire = '".$this->id_compte_bancaire."' && actif = 1";
		$resultat = $bdd->query($query);
		if (!$tmp = $resultat->fetchObject()) {
			$GLOBALS['_ALERTES']['bad_id_compte_bancaire'] = 1; 
		}
	}

	$this->lib_tpv = $infos['lib_tpv'];
	if (!$this->lib_tpv) {
		$this->create_lib_tpv ();
	}
	
	$this->com_ope	= $infos['com_ope'];
	if (!is_numeric($this->com_ope)) { 
			$this->com_ope	= 0;
	}
	
	$this->com_var	= $infos['com_var'];
	if (!is_numeric($this->com_var)) { 
			$this->com_var	= 0;
	}
	
	$this->module_name = $infos['module_name'];
	if (!$this->module_name) {
		$GLOBALS['_ALERTES']['no_module'] = 1; 
	}

	if (count($GLOBALS['_ALERTES'])) {
		return false;
	}

	// *************************************************
	// MAJ de la bdd
	$query = "UPDATE comptes_tpv 
						SET id_compte_bancaire = '".$this->id_compte_bancaire."', 
								lib_tpv = '".addslashes($this->lib_tpv)."',
								com_ope = '".$this->com_ope."',
								com_var = '".$this->com_var."',
								module_name = '".addslashes($this->module_name)."' 
						WHERE id_compte_tpv = '".$this->id_compte_tpv."' "; 
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
	$query = "UPDATE comptes_tpv 
						SET defaut_numero_compte = '".addslashes($this->defaut_numero_compte)."'
						WHERE id_compte_tpv = '".$this->id_compte_tpv."' ";
	$bdd->exec ($query);
	
	return true;
}


// Active un compte
function active_compte () {
	global $bdd;

	if ($this->actif) { return false; }

	// *************************************************
	// MAJ de la base de donnée
	$query = "UPDATE comptes_tpv 
						SET actif = 1
						WHERE id_compte_tpv = '".$this->id_compte_tpv."' "; 
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


	// *************************************************
	// MAJ de la base de donnée
	$query = "UPDATE comptes_tpv 
						SET actif = 0
						WHERE id_compte_tpv = '".$this->id_compte_tpv."' "; 
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

	// Mise à jour des autres comptes bancaires
	$query = "UPDATE comptes_tpv
						SET ordre = ordre ".$variation." 1
						WHERE ordre ".$symbole1." '".$this->ordre."' && ordre ".$symbole2." '".$new_ordre."' ";
	$bdd->exec ($query);

	// Mise à jour de ce compte bancaire
	$query = "UPDATE comptes_tpv
						SET ordre = '".$new_ordre."'
						WHERE id_compte_tpv = '".$this->id_compte_tpv."'  ";
	$bdd->exec ($query);
	
	$bdd->commit();	

	$this->ordre = $new_ordre;

	// *************************************************
	// Résultat positif de la modification
	return true;
}


// Suppression d'un TPV
public function suppression () {
	global $bdd;

	// *************************************************
	// Controle de la possibilité de supprimer le TPV

	$query = "SELECT id_compte_tpv_dest
						FROM regmt_e_tpv 
						WHERE id_compte_tpv_dest = '".$this->id_compte_tpv."' ";
	$resultat = $bdd->query($query);
	if ($tmp = $resultat->fetchObject()) {
		$GLOBALS['_ALERTES']['exist_reglements'] = 1; 
	}
	
	if (count($GLOBALS['_ALERTES'])) {
		return false;
	}


	// Suppression dans la BDD
	$query = "DELETE FROM comptes_tpv WHERE id_compte_tpv = '".$this->id_compte_tpv."' ";
	$bdd->exec ($query);

	unset ($this);
	return true;
}


//chargement du derniere télécollecte
public function charger_last_telecollecte() {
	global $bdd;
	
	$query = "SELECT MAX(id_compte_tp_telecollecte) id_compte_tp_telecollecte FROM comptes_tp_telecollecte WHERE id_compte_tp = '".$this->id_compte_tpv."' && tp_type = 'TPV' ";
	$resultat = $bdd->query($query);
	if ($tmp = $resultat->fetchObject()) {
		$this->last_id_compte_tp_telecollecte = $tmp->id_compte_tp_telecollecte;
	}
	// date de la derniere telecollecte
	$query = "SELECT date_telecollecte, montant_telecollecte, montant_commission FROM comptes_tp_telecollecte WHERE id_compte_tp_telecollecte = '".$this->last_id_compte_tp_telecollecte."' ";
	$resultat = $bdd->query($query);
	if ($tmp = $resultat->fetchObject()) {
		$this->last_date_telecollecte 		= $tmp->date_telecollecte;
		$this->last_montant_telecollecte 	= $tmp->montant_telecollecte;
		$this->last_montant_commission 		= $tmp->montant_commission;
	}
	

}

public function collecte_total (){
	global $bdd;
	
	$total_theorique = 0;
	
	$query2 = "SELECT SUM(montant_contenu) solde FROM comptes_tp_contenu WHERE id_compte_tp='".$this->id_compte_tpv."' && tp_type = 'TPV' ";
	$resultat2 = $bdd->query($query2);
	if ($total2 = $resultat2->fetchObject()) { $total_theorique = $total2->solde;}
	
	return $total_theorique;
}


// fonction de création d'une telecollect
public function create_telecollecte ($info) {
	global $bdd;
	
	global $DEFAUT_COMPTE_CAISSES; // "531";
	global $DEFAUT_COMPTE_BANQUES; // "512101";
	global $DEFAUT_COMPTE_VIREMENTS_INTERNES; // "58";
	global $DEFAUT_ID_JOURNAL_BANQUES; // "9";
	global $DEFAUT_ID_JOURNAL_CAISSES; // "10";
	
	
	// *************************************************
	// Insertion dans la bdd
	$query = "INSERT INTO comptes_tp_telecollecte 
							(id_compte_tp, tp_type, ref_user, date_telecollecte, montant_telecollecte, montant_commission, montant_transfere, commentaire)
						VALUES ('".$this->id_compte_tpv."', 'TPV', '".$_SESSION['user']->getRef_user ()."', '".$info["date_telecollecte"]."', '".$info["montant_telecollecte"]."', '".$info["montant_commission"]."', '".$info["montant_transfere"]."', '".addslashes($info["commentaire"])."' )";
	$bdd->exec ($query);
	
	$id_compte_tp_telecollecte = $bdd->lastInsertId();
	
	//insertion des CB
	
	if ($info["CB"]["infos_telecollecte"] ) {
		$valeurs = "";
		$infos_tp_contenu = array();
		$split_array_CB = explode("\n", $info["CB"]["infos_telecollecte"]);
		foreach ($split_array_CB as $line_cb) {
			$tmp_cb = explode(";", $line_cb);
			if (isset($tmp_cb[0]) && isset($tmp_cb[1])) {
				//supprimer les lignes du contenu
				$query = "DELETE FROM comptes_tp_contenu
									WHERE id_compte_tp = '".$this->id_compte_tpv."' && montant_contenu LIKE '".$tmp_cb[0]."' && infos_supp = '".addslashes($tmp_cb[1])."' && tp_type = 'TPV'
									LIMIT 1
									";
				
				$bdd->exec ($query);
				
			}
			$tmp_montant = 0;
			$tmp_info = "";
			$tmp_date = "";
			if (isset($tmp_cb[0])&& is_numeric($tmp_cb[0])) {$tmp_montant = $tmp_cb[0];}
			if (isset($tmp_cb[1])) {$tmp_info = $tmp_cb[1];}
			if (isset($tmp_cb[2])) {$tmp_date = $tmp_cb[2];}
			if ($tmp_montant) {
				if ($valeurs) {$valeurs .= ", ";}
				$valeurs .= "( '".$id_compte_tp_telecollecte."',  '".$tmp_montant."', '".$tmp_date."', '".$tmp_info."')";
			}
		}
		if ($valeurs) { 
		$query = "INSERT INTO comptes_tp_telecollecte_montant 
							(id_compte_tp_telecollecte, montant, date_reglement, infos_supp)
							VALUES ".$valeurs; 
		$bdd->exec ($query);
		}
	}
	
	//création des opérations dans le journal de caisse et de banque correspondant
	$compte_bancaire_cible = new compte_bancaire ($this->id_compte_bancaire);
		//vérification des journaux correspondant au comptes
		$journal_caisse_depart = compta_journaux::check_exist_journaux ($DEFAUT_ID_JOURNAL_CAISSES, $this->defaut_numero_compte);
		$journal_banque_arrivee = compta_journaux::check_exist_journaux ($DEFAUT_ID_JOURNAL_BANQUES, $compte_bancaire_cible->getDefaut_numero_compte ());
		
		//création des opérations de journaux
		$journal_caisse_depart->create_operation ($DEFAUT_COMPTE_VIREMENTS_INTERNES, -$info["montant_telecollecte"], $id_compte_tp_telecollecte, $info["date_telecollecte"], 8); 
		
		$journal_banque_arrivee->create_operation ($DEFAUT_COMPTE_VIREMENTS_INTERNES, $info["montant_telecollecte"], $id_compte_tp_telecollecte, $info["date_telecollecte"], 7); 
	
	return $id_compte_tp_telecollecte;
	
}

//chargement des infos d'une télécollecte
public function charger_telecollecte ($id_compte_tp_telecollecte) {
	global $bdd;


	$telecollecte = array();
	$query = "SELECT id_compte_tp_telecollecte, id_compte_tp, tp_type, ref_user, date_telecollecte, montant_telecollecte, montant_commission, montant_transfere, commentaire
						FROM comptes_tp_telecollecte ctt
						WHERE id_compte_tp_telecollecte = '".$id_compte_tp_telecollecte."' 
						";
	$resultat = $bdd->query ($query);
	if ($tmp = $resultat->fetchObject()) { 
		$tmp->contenu = array();
		$query_montant = "SELECT id_compte_tp_telecollecte, montant, date_reglement, infos_supp
									FROM comptes_tp_telecollecte_montant
									WHERE id_compte_tp_telecollecte = '".$id_compte_tp_telecollecte."'
									";
		$resultat_montant = $bdd->query ($query_montant);
		while ($tmp_montant = $resultat_montant->fetchObject()) { $tmp->contenu[] =  $tmp_montant;}
	
							
	
		$telecollecte = $tmp; 
		
	}
	
	return $telecollecte;

}


//fonction d'impression de la télécollect
public function imprimer_telecollecte ($print = 0, $id_compte_tp_telecollecte) {
	global $bdd;
	global $PDF_MODELES_DIR;
	
	// Affichage du pdf
	// Préférences et options
	$GLOBALS['PDF_OPTIONS']['HideToolbar'] = 0;
	$GLOBALS['PDF_OPTIONS']['AutoPrint'] = $print;
	
	include_once ($PDF_MODELES_DIR.$this->code_pdf_modele_telecollecte.".class.php");
	$class = "pdf_".$this->code_pdf_modele_telecollecte;
	$pdf = new $class;
	
	// Création
	$pdf->create_pdf($this, $id_compte_tp_telecollecte);
	
	// Sortie
	$pdf->Output();

}

//suppression du contenu du tp
public function raz_tp_contenu () {
	global $bdd;
	
	$query = "DELETE FROM comptes_tp_contenu 
						WHERE id_compte_tp = '".$this->id_compte_tpv."' && tp_type = 'TPV' 
						";
	$bdd->exec ($query);
	
	return true;
}
// *************************************************************************************************************
// FONCTIONS EXTERNES 
// *************************************************************************************************************

//chargement de lignes de contenu de tp
public function charger_compte_tp_contenu () {
	global $bdd;
	
	$contenu_tp = array();
	$query = "SELECT ctc.id_compte_tp, ctc.tp_type, ctc.montant_contenu, ctc.id_compte_caisse, ctc.infos_supp, ctc.controle,
										r.date_reglement
						FROM comptes_tp_contenu ctc
							LEFT JOIN reglements r ON r.ref_reglement = ctc.infos_supp
						WHERE id_compte_tp = '".$this->id_compte_tpv."' && tp_type = 'TPV'
						ORDER BY r.date_reglement DESC
						 ";
	$resultat = $bdd->query ($query);
	while ($tmp = $resultat->fetchObject()) { $contenu_tp[] = $tmp; }
	
	return $contenu_tp;
}

//ajout de lignes de contenu de tp
static function add_compte_tp_contenu ($infos) {
	global $bdd;
	
	$valeurs = "";
	foreach ($infos as $info) {
		if ($valeurs) {$valeurs .= ", ";}
		$valeurs .= "( '".$info["id_compte_tp"]."',  '".$info["tp_type"]."', '".($info["montant_contenu"])."', ".num_or_null($info["id_compte_caisse"]).", '".$info["infos_supp"]."', '".$info["controle"]."')";
	}
	if (!$valeurs) { return false;}
	$query = "INSERT INTO comptes_tp_contenu 
						(id_compte_tp, tp_type, montant_contenu, id_compte_caisse, infos_supp, controle)
						VALUES ".$valeurs; 
	$bdd->exec ($query);
	
	return true;
}

//supression du tp pour une ligne de contenu 
static function del_line_compte_tp_contenu ($info) {
	global $bdd;
	
	if (substr_count($info["montant_contenu"] , ".")) {
		$info["montant_contenu"] = rtrim($info["montant_contenu"], "0");
		if (strpos($info["montant_contenu"], ".") == strlen($info["montant_contenu"])-1) {
			$info["montant_contenu"] = str_replace("." , "", $info["montant_contenu"]);
		}
	}
	
	$query = "DELETE FROM comptes_tp_contenu
							WHERE ISNULL(id_compte_caisse) && montant_contenu LIKE '".($info["montant_contenu"])."' && infos_supp = '".addslashes($info["infos_supp"])."' && tp_type = 'TPV'
							LIMIT 1
							";
		
	$bdd->exec ($query);
	return true;
}

//suppression de lignes de contenu de tp
static function del_compte_tp_contenu ( $id_compte_tp, $tp_type) {
	global $bdd;
	
	$query = "DELETE FROM comptes_tp_contenu 
						WHERE id_compte_tp = '".$id_compte_tp."' && tp_type = '".$tp_type."' 
						";
	$bdd->exec ($query);
	
	return true;
}



// Fonction permettant de charger tous les comptes bancaires
static function charger_comptes_tpv ($actif = "") {
	global $bdd;

	$query_where = "";
	if ($actif) { $query_where = "WHERE c.actif = ".$actif; }
	
	$comptes = array();
	$query = "SELECT c.id_compte_tpv, c.id_compte_bancaire, c.lib_tpv, c.module_name, c.com_ope, c.com_var, c.actif, c.ordre, c.defaut_numero_compte, pc.lib_compte
						FROM comptes_tpv c
							LEFT JOIN plan_comptable pc ON pc.numero_compte = c.defaut_numero_compte
						".$query_where." 
						ORDER BY ordre ASC";
	$resultat = $bdd->query ($query);
	while ($tmp = $resultat->fetchObject()) { $comptes[] = $tmp; }
	
	return $comptes;
}



// *************************************************************************************************************
// FONCTIONS DE RESTITUTION DES DONNEES 
// *************************************************************************************************************

function getid_compte_tpv () {
	return $this->id_compte_tpv;
}

function getlib_tpv () {
	return $this->lib_tpv;
}

function getmodule_name () {
	return $this->module_name;
}

function getcom_ope () {
	return $this->com_ope;
}

function getcom_var () {
	return $this->com_var;
}


function getActif () {
	return $this->actif;
}

function getOrdre () {
	return $this->ordre;
}

function getId_compte_tp () {
	return $this->id_compte_tpv;
}

function getLib_tp () {
	return $this->lib_tpv;
}

function getTp_type () {
	return "TPV";
}

function getLast_date_telecollecte () {
	if (!$this->last_date_telecollecte) {
		$this->charger_last_telecollecte();
	}
	return $this->last_date_telecollecte;
}

function getDefaut_numero_compte () {
	return $this->defaut_numero_compte;
}

function getLib_compte_bancaire () {
	return $this->lib_compte_bancaire;
}



}





?>