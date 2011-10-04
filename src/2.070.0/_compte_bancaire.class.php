<?php
// *************************************************************************************************************
// CLASSE REGISSANT LES INFORMATIONS SUR UN COMPTE BANCAIRE 
// *************************************************************************************************************


final class compte_bancaire {
	protected $id_compte_bancaire;

	protected $ref_contact;
	protected $nom_contact;
	protected $lib_compte;

	protected $ref_banque;
	protected $nom_banque;

	protected $code_banque;
	protected $code_guichet;
	protected $numero_compte;
	protected $cle_rib;
	protected $iban;
	protected $swift;
	
	protected $releves_compte;	// liste des relevés du compte
	protected $releves_comptes_loaded;
	
	protected $releves_comptes_exercice;	// liste des relevés du compte par exercice
	protected $releves_comptes_exercice_loaded;
	
	private $defaut_numero_compte;	// numéro de compte comptable par defaut 
	

	protected $actif;
	protected $ordre;
	
	private $code_pdf_modele = "rib_bancaire"; // code pour la class d'impression de rib



public function __construct ($id_compte_bancaire = "") {
	global $bdd;
	
	if (!$id_compte_bancaire) { return false; }
	
	$query = "SELECT c.ref_contact, a1.nom nom_contact, c.lib_compte, c.ref_banque, a2.nom nom_banque, 
									 c.code_banque, c.code_guichet, c.numero_compte, c.cle_rib, c.iban, c.swift, c.actif, c.ordre, c.defaut_numero_compte
						FROM comptes_bancaires c
							LEFT JOIN annuaire a1 ON a1.ref_contact = c.ref_contact
							LEFT JOIN annuaire a2 ON a2.ref_contact = c.ref_banque
						WHERE c.id_compte_bancaire = '".$id_compte_bancaire."' ";
	$resultat = $bdd->query ($query);
	if (!$compte = $resultat->fetchObject()) { return false; }

	$this->id_compte_bancaire	= $id_compte_bancaire;
	$this->ref_contact	= $compte->ref_contact;
	$this->nom_contact	= $compte->nom_contact;
	$this->lib_compte = $compte->lib_compte;
	$this->ref_banque = $compte->ref_banque;
	$this->nom_banque = $compte->nom_banque;
	$this->code_banque 		= $compte->code_banque;
	$this->code_guichet 	= $compte->code_guichet;
	$this->numero_compte 	= $compte->numero_compte;
	$this->cle_rib 				= $compte->cle_rib;
	$this->iban		= $compte->iban;
	$this->swift	= $compte->swift;
	$this->actif	= $compte->actif;
	$this->ordre	= $compte->ordre;
	$this->defaut_numero_compte	= $compte->defaut_numero_compte;
	
	return true;
}





// *************************************************************************************************************
// FONCTIONS LIEES A LA CREATION D'UN COMPTE BANCAIRE
// *************************************************************************************************************

public function create_compte_bancaire ($infos) { 
	global $bdd;
	global $DEFAUT_COMPTE_BANQUES;
	global $REF_CONTACT_ENTREPRISE;
	
	// *************************************************
	// Réception des données
	$this->ref_contact 		= $infos['ref_contact'];
	$query = "SELECT nom nom_contact FROM annuaire WHERE ref_contact = '".$this->ref_contact."' ";
	$resultat = $bdd->query ($query);
	if (!$contact = $resultat->fetchObject()) { 
		$GLOBALS['_ALERTES']['bad_ref_contact'] = 1; 
		return false;
	}
	$this->nom_contact = $contact->nom_contact;

	$this->lib_compte 		= $infos['lib_compte'];
	$this->ref_banque 		= $infos['ref_banque'];
	$this->nom_banque = "";
	$query = "SELECT nom nom_banque FROM annuaire WHERE ref_contact = '".$this->ref_banque."' ";
	$resultat = $bdd->query ($query);
	if ($banque = $resultat->fetchObject()) { 
		$this->nom_banque = $banque->nom_banque;
	}
	
	$this->code_banque		= $infos['code_banque'];
	$this->code_guichet		= $infos['code_guichet'];
	$this->numero_compte	= $infos['numero_compte'];
	$this->cle_rib 				= $infos['cle_rib'];
	$this->iban 	= $infos['iban'];
	$this->swift 	= $infos['swift'];
	$this->actif 	= 1;

	// Ordre d'affichage
	$query = "SELECT MAX(ordre) ordre FROM comptes_bancaires WHERE ref_contact = '".$this->ref_contact."' ";
	$resultat = $bdd->query($query);
	if ($tmp = $resultat->fetchObject()) {
		$this->ordre = $tmp->ordre+1;
	}
	else {
		$this->ordre = 1;
	}
	unset ($query, $resultat, $tmp);
	
	if (!$this->lib_compte) {
		$this->create_lib_compte ();
	}
	$numero_compte_comptable = "";
	if ($REF_CONTACT_ENTREPRISE == $this->ref_contact) {
		// ajout du numéro de compte bancaire incrémenté à partir du compte par defaut
		$numero_compte_comptable = $DEFAUT_COMPTE_BANQUES;
		
		$query = "SELECT numero_compte 
							FROM plan_comptable 
							WHERE numero_compte = '".$numero_compte_comptable."'";
		$resultat = $bdd->query($query);
		if ($tmp = $resultat->fetchObject()) {
			while ($tmp->numero_compte == $numero_compte_comptable) {
				$numero_compte_comptable += 1;
				$query = "SELECT numero_compte 
									FROM plan_comptable 
									WHERE numero_compte = '".$numero_compte_comptable."'";
				$resultat = $bdd->query($query);
				$tmp = $resultat->fetchObject();
				if (!is_object($tmp)) {
					$compte_plan_general = new compta_plan_general ($DEFAUT_COMPTE_BANQUES);
					$new_compte_compta['numero_compte'] = $numero_compte_comptable;
					$new_compte_compta['lib_compte'] = $compte_plan_general->getLib_compte();
					$new_compte_compta['favori'] = 1;
					$compte_plan_general->create_compte_plan_comptable ($new_compte_compta);
					break;
				}
			}
		}
	}
	$this->defaut_numero_compte = $numero_compte_comptable;

	if (count($GLOBALS['_ALERTES'])) {
		return false;
	}

	// *************************************************
	// Insertion dans la bdd
	$query = "INSERT INTO comptes_bancaires 
							(ref_contact, lib_compte, ref_banque, code_banque,code_guichet,numero_compte, cle_rib, iban, swift, actif, ordre, defaut_numero_compte)
						VALUES (".ref_or_null($this->ref_contact).", '".addslashes($this->lib_compte)."', 
										".ref_or_null($this->ref_banque).", 
										'".$this->code_banque."', '".$this->code_guichet."', '".$this->numero_compte."', '".$this->cle_rib."', 
										'".$this->iban."', '".$this->swift."', '".$this->actif."', '".$this->ordre."', '".$this->defaut_numero_compte."')"; 
	$bdd->exec ($query);
	$this->id_compte_bancaire = $bdd->lastInsertId();
	
	return true;
}


private function create_lib_compte () {
	$this->lib_compte = "Compte ".$this->nom_contact." n°".$this->numero_compte;
}



// *************************************************************************************************************
// FONCTIONS DE MISE A JOUR DES DONNEES 
// *************************************************************************************************************
public function maj_compte_bancaire ($infos) {
	global $bdd;

	// *************************************************
	// Réception des données
	if ($this->ref_contact != $infos['ref_contact']) {
		$this->ref_contact 		= $infos['ref_contact'];
		$query = "SELECT nom nom_contact FROM annuaire WHERE ref_contact = '".$this->ref_contact."' ";
		$resultat = $bdd->query ($query);
		if (!$contact = $resultat->fetchObject()) { 
			$GLOBALS['_ALERTES']['bad_ref_contact'] = 1; 
			return false;
		}
	}

	$this->lib_compte 		= $infos['lib_compte'];

	if ($this->ref_banque != $infos['ref_banque']) {
		$this->ref_banque 		= $infos['ref_banque'];
		$query = "SELECT nom nom_banque FROM annuaire WHERE ref_contact = '".$this->ref_banque."' ";
		$resultat = $bdd->query ($query);
		if ($banque = $resultat->fetchObject()) { 
			$this->nom_banque = $banque->nom_banque;
		}
	}

	$this->code_banque		= $infos['code_banque'];
	$this->code_guichet		= $infos['code_guichet'];
	$this->numero_compte	= $infos['numero_compte'];
	$this->cle_rib 				= $infos['cle_rib'];
	$this->iban 	= $infos['iban'];
	$this->swift 	= $infos['swift'];
	
	if (!$this->lib_compte) {
		$this->create_lib_compte ();
	}

	if (count($GLOBALS['_ALERTES'])) {
		return false;
	}

	// *************************************************
	// MAJ de la bdd
	$query = "UPDATE comptes_bancaires 
						SET ref_contact = ".ref_or_null($this->ref_contact).", lib_compte = '".addslashes($this->lib_compte)."', 
								ref_banque = ".ref_or_null($this->ref_banque).", 
								code_banque = '".$this->code_banque."', code_guichet = '".$this->code_guichet."', 
								numero_compte = '".$this->numero_compte."', cle_rib = '".$this->cle_rib."', 
								iban = '".$this->iban."', swift = '".$this->swift."'
						WHERE id_compte_bancaire = '".$this->id_compte_bancaire."' "; 
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
	$query = "UPDATE comptes_bancaires 
						SET defaut_numero_compte = '".addslashes($this->defaut_numero_compte)."'
						WHERE id_compte_bancaire = '".$this->id_compte_bancaire."' ";
	$bdd->exec ($query);
	
	return true;
}


// Active un compte
function active_compte () {
	global $bdd;

	if ($this->actif) { return false; }

	// *************************************************
	// MAJ de la base de donnée
	$query = "UPDATE comptes_bancaires 
						SET actif = 1
						WHERE id_compte_bancaire = '".$this->id_compte_bancaire."' "; 
	$bdd->exec ($query);

	$this->actif = 1;
	return true;
}

// Désactive un compte
function desactive_compte () {
	global $bdd;

	if (!$this->actif) { return false; }

	// *************************************************
	// Controle de la possibilité de désactiver ce compte (TPE, etc ?)


	// *************************************************
	// MAJ de la base de donnée
	$query = "UPDATE comptes_bancaires 
						SET actif = 0
						WHERE id_compte_bancaire = '".$this->id_compte_bancaire."' "; 
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
	$query = "UPDATE comptes_bancaires
						SET ordre = ordre ".$variation." 1
						WHERE ref_contact = '".$this->ref_contact."' && 
									ordre ".$symbole1." '".$this->ordre."' && ordre ".$symbole2." '".$new_ordre."' ";
	$bdd->exec ($query);

	// Mise à jour de ce compte bancaire
	$query = "UPDATE comptes_bancaires
						SET ordre = '".$new_ordre."'
						WHERE id_compte_bancaire = '".$this->id_compte_bancaire."'  ";
	$bdd->exec ($query);
	
	$bdd->commit();	

	$this->ordre = $new_ordre;

	// *************************************************
	// Résultat positif de la modification
	return true;
}


// Suppression d'un compte bancaire
public function suppression () {
	global $bdd;

	// *************************************************
	// Controle de la possibilité de supprimer le compte bancaire


	// Suppression dans la BDD
	$query = "DELETE FROM comptes_bancaires WHERE id_compte_bancaire = '".$this->id_compte_bancaire."' ";
	$bdd->exec ($query);

	unset ($this);
	return true;
}

// *************************************************************************************************************
// FONCTIONS DE GESTION DES RELEVES DU COMPTE
// *************************************************************************************************************
//fonction de chargement des relevés du compte
public function charger_releves_compte () {
	global $bdd;
	
	$this->releves_comptes = array();
	$query = "SELECT id_compte_bancaire_releve, id_compte_bancaire, date_releve, solde_calcule, solde_reel
						FROM comptes_bancaires_releves
						WHERE id_compte_bancaire = '".$this->id_compte_bancaire."' 
						ORDER BY date_releve DESC";
	$resultat = $bdd->query ($query);
	while ($tmp = $resultat->fetchObject()) { $this->releves_comptes[] = $tmp; }
	
	$this->releves_comptes_loaded = true;
	return true;
}
//chargement des relevés de compte par exercice
static function charger_releves_compte_exercices ($id_exercice, $id_compte_bancaire) {
	global $bdd;
	
	$releves_comptes_exercices = array();
	$compta_tmp = new compta_exercices ($id_exercice);
	
	//chargement des relevés
	$compte_bancaire	= new compte_bancaire($id_compte_bancaire);
	$releves = $compte_bancaire->getReleves_compte();
	if (count($releves)) {
		for ($i = 0 ;$i < count($releves); $i++) {
			if ($releves[$i]->date_releve < $compta_tmp->getDate_fin () && !count($releves_comptes_exercices) && isset($releves[$i-1])  ) {$releves_comptes_exercices[] = $releves[$i-1];}
			
			if ($releves[$i]->date_releve < $compta_tmp->getDate_fin () && $releves[$i]->date_releve >= $compta_tmp->getDate_debut () ) {$releves_comptes_exercices[] = $releves[$i];}
		}
		if (!count($releves_comptes_exercices)) {
			$releves_comptes_exercices[] = $releves[count($releves)-1];
		}
	}
	return $releves_comptes_exercices;
}

//fonction de chargement des informations d'un relevé du compte
public function charger_compte_bancaire_releve ($id_compte_bancaire_releve) {
	global $bdd;
	
	$releve_compte = "";
	$query = "SELECT id_compte_bancaire_releve, id_compte_bancaire, date_releve, solde_calcule, solde_reel
						FROM comptes_bancaires_releves
						WHERE id_compte_bancaire = '".$this->id_compte_bancaire."' && id_compte_bancaire_releve = '".$id_compte_bancaire_releve."'
						ORDER BY date_releve DESC";
	$resultat = $bdd->query ($query);
	while ($tmp = $resultat->fetchObject()) { $releve_compte = $tmp; }
	
	return $releve_compte;
}

//fonction d'ajout d'un relevé
public function add_releve_compte ($date_releve, $solde_reel) {
	global $bdd;
	
	$solde_reel = convert_numeric($solde_reel);
	if (!is_numeric($solde_reel)) {
		$GLOBALS['_ALERTES']['bad_releve_solde_reel'] = 1;
	}
	
	if ($_SESSION['date_compta_closed'] > $date_releve ) {
		$GLOBALS['_ALERTES']['releve_in_closed_exercice'] = 1;
	}
	if (!checkdate ((int)substr($date_releve, 5, 2)   ,(int)substr($date_releve, 8, 2)  ,(int)substr($date_releve, 0, 4) ) &&$date_releve ) {
		$GLOBALS['_ALERTES']['bad_date_releve'] = 1;
	} 
	// *************************************************
	// Si les valeurs reçues sont incorrectes
	if (count($GLOBALS['_ALERTES'])) {
		return false;
	}
	
	//calcul du solde
	$solde_calcule = $this->solde_calcule_releve ($date_releve);
	
	//insertion dans la base de données
	$query = "INSERT INTO comptes_bancaires_releves 
							(id_compte_bancaire, date_releve, solde_calcule, solde_reel)
						VALUES ('".$this->id_compte_bancaire."' , '".$date_releve." 23:59:59', 
										'".$solde_calcule."', '".$solde_reel."'
						)";
	$bdd->exec ($query);
	$this->check_calcul_releve ($date_releve);
	return true;
	
}


//fonction d'edition d'un relevé
public function maj_compte_bancaire_releve ($id_compte_bancaire_releve, $date_releve, $solde_reel) {
	global $bdd;
	
	$solde_reel = convert_numeric($solde_reel);
	if (!is_numeric($solde_reel)) {
		$GLOBALS['_ALERTES']['bad_releve_solde_reel'] = 1;
	}
	
	if ($_SESSION['date_compta_closed'] > $date_releve ) {
		$GLOBALS['_ALERTES']['releve_in_closed_exercice'] = 1;
	}
	
	// *************************************************
	// Si les valeurs reçues sont incorrectes
	if (count($GLOBALS['_ALERTES'])) {
		return false;
	}
	
	
	//calcul du solde
	$solde_calcule = $this->solde_calcule_releve ($date_releve);
	
	//insertion dans la base de données
	$query = "UPDATE comptes_bancaires_releves 
						SET	date_releve = '".$date_releve." 23:59:59', solde_calcule = '".$solde_calcule."', solde_reel = '".$solde_reel."' 
						WHERE id_compte_bancaire_releve	= '".$id_compte_bancaire_releve."' 
						";
	$bdd->exec ($query);
	$this->check_calcul_releve ($date_releve);
	return true;
	
}

//fonction de supressiond'un relevé
public function del_compte_bancaire_releve ($id_compte_bancaire_releve) {
	global $bdd;
	
	$query = "SELECT date_releve
						FROM comptes_bancaires_releves
						WHERE id_compte_bancaire_releve = '".$id_compte_bancaire_releve."'
						";
	$resultat = $bdd->query ($query);
	if ($tmp = $resultat->fetchObject()) { $date_releve = $tmp->date_releve; }
	
	if ($_SESSION['date_compta_closed'] >= $date_releve ) {
		$GLOBALS['_ALERTES']['releve_in_closed_exercice'] = 1;
	}
	
	// *************************************************
	// Si les valeurs reçues sont incorrectes
	if (count($GLOBALS['_ALERTES'])) {
		return false;
	}
	//suppression dans la base de données
	$query = "DELETE FROM comptes_bancaires_releves 
						WHERE id_compte_bancaire_releve	= '".$id_compte_bancaire_releve."' 
						";
	$bdd->exec ($query);
	
	$this->check_calcul_releve ($date_releve);
	return true;
	
}

//fonction de calcul du solde_calcule d'un relevé
public function solde_calcule_releve ($date_releve) {
	global $bdd;
	
	$date_debut = "";
	$solde_calcule = 0;
	//on recherche le relevé précédent
	$query = "SELECT date_releve, solde_reel
						FROM comptes_bancaires_releves
						WHERE id_compte_bancaire = '".$this->id_compte_bancaire."'  && date_releve < '".$date_releve." 23:59:59'
						ORDER BY date_releve DESC
						LIMIT 1
						";
	$resultat = $bdd->query ($query);
	if ($tmp = $resultat->fetchObject()) {
		$date_debut = " &&  date_move > '".$tmp->date_releve."' "; 
		$solde_calcule += $tmp->solde_reel;
	}
	unset ($query, $resultat, $tmp);
	
	//on calcul le solde depuis ce relevé
	$query = "SELECT SUM(montant_move) as solde
							FROM comptes_bancaires_moves 
						WHERE  id_compte_bancaire = '".$this->id_compte_bancaire."' && date_move < '".$date_releve." 23:59:59' ".$date_debut." 
					";
	$resultat = $bdd->query($query);
	if ($tmp = $resultat->fetchObject()) { $solde_calcule += $tmp->solde;}
	return $solde_calcule;
}

//fonction de recalcul des relevés
public function check_calcul_releve ($date_debut) {
	global $bdd;
	
	$query = "SELECT id_compte_bancaire_releve, id_compte_bancaire, date_releve, solde_reel, solde_calcule
						FROM comptes_bancaires_releves
						WHERE id_compte_bancaire = '".$this->id_compte_bancaire."'  && date_releve > '".$date_debut."'
						ORDER BY date_releve ASC
						";
	$resultat = $bdd->query ($query);
	while ($tmp = $resultat->fetchObject()) {
		$query2 = "UPDATE comptes_bancaires_releves
								SET solde_calcule = '".$this->solde_calcule_releve (date ("Y-m-d", mktime(0, 0, 0, date ("m", strtotime($tmp->date_releve)) , date ("d", strtotime($tmp->date_releve)), date ("Y", strtotime($tmp->date_releve)) )))."' 
							WHERE id_compte_bancaire_releve = '".$tmp->id_compte_bancaire_releve."' ";
		$bdd->exec ($query2);
	}
	
	return true;
}

//fonction renvoyant le solde réél à partir d'une date
public function solde_reel_releve ($date_releve) {
	global $bdd;
	
	$date_debut = "";
	$solde_reel = 0;
	//on recherche le relevé précédent
	$query = "SELECT date_releve, solde_reel
						FROM comptes_bancaires_releves
						WHERE id_compte_bancaire = '".$this->id_compte_bancaire."'  && date_releve <= '".$date_releve."'
						ORDER BY date_releve DESC
						LIMIT 1
						";
	$resultat = $bdd->query ($query);
	if ($tmp = $resultat->fetchObject()) {
		$solde_reel += $tmp->solde_reel;
	}
	return $solde_reel;
}

// *************************************************************************************************************
// FONCTIONS DE GESTION DES OPÉRATIONS DU COMPTE
// *************************************************************************************************************
//chargement d'une opération
public function charger_compte_bancaire_move ($id_compte_bancaire_move) {
	global $bdd;
	
	$operation = "";
	$query = "SELECT 	id_compte_bancaire_move, id_compte_bancaire, date_move, lib_move, montant_move, 
										commentaire_move, fitid, trntype, trninfo 
							FROM comptes_bancaires_moves 
						WHERE id_compte_bancaire_move = '".$id_compte_bancaire_move."' 
						";
	$resultat = $bdd->query ($query);
	while ($tmp = $resultat->fetchObject()) { $operation = $tmp; }
	
	return $operation;
}

//ajout d'une opération
public function add_compte_bancaire_move ($date_move, $lib_move, $montant_move, $commentaire_move = "", $fitid = "", $trntype = "", $trninfo = "") {
	global $bdd;
	
	$montant_move = convert_numeric($montant_move);
	if ($_SESSION['date_compta_closed'] > $date_move ) {
		$GLOBALS['_ALERTES']['operation_in_closed_exercice'] = 1;
	}
	if (!is_numeric(trim($montant_move))) {
		$GLOBALS['_ALERTES']['bad_operation_montant_move'] = 1;
	}
	if (!checkdate ((int)substr($date_move, 5, 2)   ,(int)substr($date_move, 8, 2)  ,(int)substr($date_move, 0, 4) ) && $date_move) {
		$GLOBALS['_ALERTES']['bad_date_move'] = 1;
	} 
	
	if ($fitid) {
		$query = "SELECT 	id_compte_bancaire, fitid 
								FROM comptes_bancaires_moves 
							WHERE id_compte_bancaire = '".$this->id_compte_bancaire."' && fitid LIKE '".$fitid."' 
							";
		$resultat = $bdd->query ($query);
		if ($tmp = $resultat->fetchObject()) {
			$GLOBALS['_ALERTES']['exist_fitid'] = 1;
		}
	}
	
	// *************************************************
	// Si les valeurs reçues sont incorrectes
	if (count($GLOBALS['_ALERTES'])) {
		return false;
	}
	
	//insertion dans la base de données
	$query = "INSERT INTO comptes_bancaires_moves 
							(id_compte_bancaire, date_move, lib_move, montant_move, commentaire_move, fitid, trntype, trninfo)
						VALUES ('".$this->id_compte_bancaire."' , '".$date_move."', 
										'".addslashes($lib_move)."', 
										'".$montant_move."', '".addslashes($commentaire_move)."', '".$fitid."', '".$trntype."', 
										'".$trninfo."' 
						)";
	$bdd->exec ($query);
	
	return true;
}

//mise à jour des infos d'une opération
public function maj_compte_bancaire_move ($id_compte_bancaire_move, $date_move, $lib_move, $montant_move, $commentaire_move = "", $fitid = "", $trntype = "", $trninfo = "") {
	global $bdd;
	
	$montant_move = convert_numeric($montant_move);
	if ($_SESSION['date_compta_closed'] > $date_move ) {
		$GLOBALS['_ALERTES']['operation_in_closed_exercice'] = 1;
	}
	if (!is_numeric($montant_move)) {
		$GLOBALS['_ALERTES']['bad_operation_montant_move'] = 1;
	}
	if ($fitid) {
		$query = "SELECT 	id_compte_bancaire,	id_compte_bancaire_move, fitid 
								FROM comptes_bancaires_moves 
							WHERE id_compte_bancaire = '".$this->id_compte_bancaire."' 
										&& id_compte_bancaire_move != '".$id_compte_bancaire_move."' && fitid = '".$fitid."' 
							";
		$resultat = $bdd->query ($query);
		if ($tmp = $resultat->fetchObject()) {
			$GLOBALS['_ALERTES']['exist_fitid'] = 1;
		}
	}
	
	// *************************************************
	// Si les valeurs reçues sont incorrectes
	if (count($GLOBALS['_ALERTES'])) {
		return false;
	}
	
	$add_query = "";
	if ($commentaire_move){$add_query .= ", commentaire_move = '".addslashes($commentaire_move)."' ";}
	if ($fitid) 					{$add_query .= ", fitid = '".$fitid."' ";}
	if ($trntype) 				{$add_query .= ", trntype = '".$trntype."' ";}
	if ($trninfo) 				{$add_query .= ", trninfo = '".$trninfo."' ";}
	
	$query = "UPDATE comptes_bancaires_moves 
						SET id_compte_bancaire = '".$this->id_compte_bancaire."' , date_move = '".$date_move."', 
										lib_move = '".addslashes($lib_move)."', montant_move = '".$montant_move."'
										".$add_query."
						WHERE id_compte_bancaire_move = '".$id_compte_bancaire_move."' 
						";
	$bdd->exec ($query);
	
	return true;
}

//suppression d'une opération
public function del_compte_bancaire_move ($id_compte_bancaire_move, $date_move) {
	global $bdd;
	
	if ($_SESSION['date_compta_closed'] > $date_move ) {
		$GLOBALS['_ALERTES']['operation_in_closed_exercice'] = 1;
	}
	// *************************************************
	// Si les valeurs reçues sont incorrectes
	if (count($GLOBALS['_ALERTES'])) {
		return false;
	}
	
	$query = "DELETE FROM comptes_bancaires_moves WHERE id_compte_bancaire_move = '".$id_compte_bancaire_move."' ";
	$bdd->exec ($query);
	
	return true;

}
//ajout d'un rapprochement
public function add_compte_bancaire_rapprochement ($id_compte_bancaire_move, $id_operation, $date_move) {
	global $bdd;
	
	if ($_SESSION['date_compta_closed'] > $date_move ) {
		$GLOBALS['_ALERTES']['operation_in_closed_exercice'] = 1;
	}
	// *************************************************
	// Si les valeurs reçues sont incorrectes
	if (count($GLOBALS['_ALERTES'])) {
		return false;
	}
	// on récupère les informations de rapprochement existantes
	$query_2 = "SELECT 	cbm.montant_move, cbor.id_operation, cbor.montant_rapproche, cjo.montant
							FROM comptes_bancaires_moves cbm
								LEFT JOIN comptes_bancaires_ope_rapp cbor ON cbor.id_operation = ".$id_operation."
								LEFT JOIN compta_journaux_opes cjo ON cjo.id_operation = cbor.id_operation
							WHERE id_compte_bancaire_move = '".$id_compte_bancaire_move."' 
							";
	$resultat_2 = $bdd->query ($query_2);
	
	// on met à jour le mouvement
	$query = "UPDATE comptes_bancaires_moves
						SET id_operation = '".$id_operation."'  
						WHERE id_compte_bancaire_move = '".$id_compte_bancaire_move."' ";
	$bdd->exec ($query);
	
	if (!$tmp_2 = $resultat_2->fetchObject()) { return false;}
	//on vérifi que id_ope est utilié 
	if ($tmp_2->id_operation) {
		//si l'opé est déjà rapprochée, on met à jour
		$rapp_complet = 0;
		if ((abs($tmp_2->montant)-0.01 )<= ($tmp_2->montant_rapproche+abs($tmp_2->montant_move))) {$rapp_complet = 1;}
		$query = "UPDATE comptes_bancaires_ope_rapp 
							SET montant_rapproche = '".($tmp_2->montant_rapproche+abs($tmp_2->montant_move))."', complet = ".$rapp_complet."
							WHERE id_operation  = '".$id_operation."' ";
		$bdd->exec ($query);
		return true;
	}
	//sinon on charge le montant ope et on insère 
	$query_3 = "SELECT cjo.montant
							FROM compta_journaux_opes cjo
							WHERE cjo.id_operation = '".$id_operation."' 
							";
	$resultat_3 = $bdd->query ($query_3);
	if ($tmp_3 = $resultat_3->fetchObject()) {
		$rapp_complet = 0;
		if ((abs($tmp_3->montant)-0.01) <= abs($tmp_2->montant_move)) {$rapp_complet = 1;}
		$query = "INSERT INTO comptes_bancaires_ope_rapp (id_operation, montant_rapproche, complet )
							VALUES ( '".$id_operation."', '".abs($tmp_2->montant_move)."', ".$rapp_complet.")";
		$bdd->exec ($query);
	}
	return true;

}
//suppression d'un rapprochement
public function del_compte_bancaire_rapprochement ($id_compte_bancaire_move, $date_move) {
	global $bdd;
	
	if ($_SESSION['date_compta_closed'] > $date_move ) {
		$GLOBALS['_ALERTES']['operation_in_closed_exercice'] = 1;
	}
	// *************************************************
	// Si les valeurs reçues sont incorrectes
	if (count($GLOBALS['_ALERTES'])) {
		return false;
	}
	//on récupère les informations de rapprochement existant
	$query_2 = "SELECT 	cbm.montant_move, cbm.id_operation, cbor.montant_rapproche, cjo.montant
							FROM comptes_bancaires_moves cbm
								LEFT JOIN comptes_bancaires_ope_rapp cbor ON cbor.id_operation = cbm.id_operation
								LEFT JOIN compta_journaux_opes cjo ON cjo.id_operation = cbor.id_operation
							WHERE id_compte_bancaire_move = '".$id_compte_bancaire_move."' 
							";
	$resultat_2 = $bdd->query ($query_2);
	
	//on supprime le rapprochement
	$query = "UPDATE comptes_bancaires_moves
						SET id_operation = NULL
						WHERE id_compte_bancaire_move = '".$id_compte_bancaire_move."' ";
	$bdd->exec ($query);
	
	
	if ($tmp_2 = $resultat_2->fetchObject()) {
		$id_operation = $tmp_2->id_operation;
		//si on est retourné à zéro on supprime le récap du rapprochement pour l'opé
		if ( ($tmp_2->montant_rapproche-abs($tmp_2->montant_move)) <= 0.01 ) {
			$query = "DELETE FROM comptes_bancaires_ope_rapp 
								WHERE id_operation  = '".$id_operation."' ";
			$bdd->exec ($query);
		return true;
		}
		//sinon on met à jour
		$rapp_complet = 0;
		$query = "UPDATE comptes_bancaires_ope_rapp 
							SET montant_rapproche = '".($tmp_2->montant_rapproche-abs($tmp_2->montant_move))."', complet = ".$rapp_complet."
							WHERE id_operation  = '".$id_operation."' ";
		$bdd->exec ($query);
		return true;
	}
		
		

}


//fonction d'impression du rib bancaire
public function imprimer_rib_bancaire ($print = 0) {
	global $bdd;
	global $PDF_MODELES_DIR;
	// Affichage du pdf
	// Préférences et options
	$GLOBALS['PDF_OPTIONS']['HideToolbar'] = 0;
	$GLOBALS['PDF_OPTIONS']['AutoPrint'] = $print;
	
	include_once ($PDF_MODELES_DIR.$this->code_pdf_modele.".class.php");
	$class = "pdf_".$this->code_pdf_modele;
	$pdf = new $class;
	
	// Création
	$pdf->create_pdf($this);
	
	// Sortie
	$pdf->Output();

}
// *************************************************************************************************************
// FONCTIONS EXTERNES 
// *************************************************************************************************************


// Fonction permettant de charger tous les comptes bancaires
static function charger_comptes_bancaires ($ref_contact = "", $actif = "", $seulement_avec_autorisation = false) {
	global $bdd;
	global $REF_CONTACT_ENTREPRISE;

	if (!$ref_contact) { $ref_contact = $REF_CONTACT_ENTREPRISE; }
	
        $query_autorisation = "";
        if ($seulement_avec_autorisation){
            $query_autorisation = " INNER JOIN comptes_bancaires_autorisations cba ON c.id_compte_bancaire = cba.id_compte_bancaire_src ";
        }

	$query_actif = "";
	if ($actif) { $query_actif = " && c.actif = ".$actif; }

	$comptes = array();
	$query = "SELECT c.id_compte_bancaire, c.ref_contact, a1.nom nom_contact, c.lib_compte, c.ref_banque, a2.nom nom_banque, 
									 c.code_banque, c.code_guichet, c.numero_compte, c.cle_rib, c.iban, c.swift, c.actif, c.ordre, c.defaut_numero_compte, 
									  pc.lib_compte as lib_compte_compta, 
									 (SELECT 	MAX(cbm.date_move) 
										FROM comptes_bancaires_moves cbm
										WHERE cbm.id_compte_bancaire = c.id_compte_bancaire) as last_date_move , 
									 (SELECT 	COUNT(id_compte_bancaire_move) 
										FROM comptes_bancaires_moves cbm
										WHERE cbm.id_compte_bancaire = c.id_compte_bancaire && ISNULL(cbm.id_operation) ) as a_rapprocher 
						FROM comptes_bancaires c".$query_autorisation."
							LEFT JOIN annuaire a1 ON a1.ref_contact = c.ref_contact
							LEFT JOIN annuaire a2 ON a2.ref_contact = c.ref_banque
							LEFT JOIN plan_comptable pc ON pc.numero_compte = c.defaut_numero_compte
						WHERE c.ref_contact = '".$ref_contact."' ".$query_actif." 
						ORDER BY ordre ASC";
	$resultat = $bdd->query ($query);
	while ($tmp = $resultat->fetchObject()) { $comptes[] = $tmp; }
	
	return $comptes;
}


static function charger_last_releve ($id_compte_bancaire) {
	global $bdd;
	
	$query = "SELECT 	MAX(cbm.date_move) as last_date_move 
										FROM comptes_bancaires_moves cbm
										WHERE cbm.id_compte_bancaire = '".$id_compte_bancaire."'  ";
	$resultat = $bdd->query ($query);
	if ($tmp = $resultat->fetchObject()) { return $tmp->last_date_move; }
	
	return $comptes;
}

// *************************************************************************************************************
// FONCTIONS DE RESTITUTION DES DONNEES 
// *************************************************************************************************************

function getId_compte_bancaire () {
	return $this->id_compte_bancaire;
}

function getRef_contact () {
	return $this->ref_contact;
}

function getNom_contact () {
	return $this->nom_contact;
}

function getLib_compte () {
	return $this->lib_compte;
}

function getRef_banque () {
	return $this->ref_banque;
}

function getNom_banque () {
	return $this->nom_banque;
}

function getCode_banque () {
	return $this->code_banque;
}

function getCode_guichet () {
	return $this->code_guichet;
}

function getNumero_compte () {
	return $this->numero_compte;
}

function getCle_rib () {
	return $this->cle_rib;
}

function getIban () {
	return $this->iban;
}

function getSwift () {
	return $this->swift;
}

function getActif () {
	return $this->actif;
}

function getOrdre () {
	return $this->ordre;
}

function getReleves_compte () {
	if (!$this->releves_comptes_loaded) {$this->charger_releves_compte ();}
	return $this->releves_comptes;
}

function getDefaut_numero_compte () {
	return $this->defaut_numero_compte;
}



}





?>