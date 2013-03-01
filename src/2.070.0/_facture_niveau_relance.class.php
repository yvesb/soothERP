<?php
// *************************************************************************************************************
// CLASSE REGISSANT LES INFORMATIONS SUR UN NIVEAU DE RELANCE D'UNE FACTURE
// *************************************************************************************************************


class facture_niveau_relance {

	private $id_niveau_relance;
	private $niveau_relance;
	private $id_relance_modele;
	private $lib_etat_relance;
	private $delai_before_next;
	private $id_edition_mode;
	private $impression;
	private $montant_mini;
	private $suite_avant_echeance;
	private $actif;


public function __construct ($id_niveau_relance = 0) {
	global $bdd;

	if ( !$id_niveau_relance || is_null($id_niveau_relance) ) { return false; }

	$this->id_niveau_relance = $id_niveau_relance;

	// *************************************************
	// Sélection dans la base
	$query = "SELECT niveau_relance, id_relance_modele, lib_niveau_relance, delai_before_next, id_edition_mode, impression, montant_mini, suite_avant_echeance, actif
						FROM factures_relances_niveaux
						WHERE id_niveau_relance = '".$this->id_niveau_relance."' ";
	$resultat = $bdd->query ($query);
	if (!$niv = $resultat->fetchObject()) { return false; }

	$this->niveau_relance		= $niv->niveau_relance;
	$this->id_relance_modele	= $niv->id_relance_modele;
	$this->lib_niveau_relance	= $niv->lib_niveau_relance;
	$this->delai_before_next	= $niv->delai_before_next;
	$this->id_edition_mode		= $niv->id_edition_mode;
	$this->impression			= $niv->impression;
	$this->montant_mini			= $niv->montant_mini;
	$this->suite_avant_echeance = $niv->suite_avant_echeance;
	$this->actif				= $niv->actif;
	return true;
}

public static function _create_modele($lib_modele){
	
	global $bdd;
	
	if ( !is_string($lib_modele) || $lib_modele = "") {return false;}
	
	$query = "INSERT INTO factures_relances_modeles(lib_relance_modele) VALUES ('$lib_modele')";
	$bdd->exec ($query);
	$id_relance_modele = $bdd->lastInsertId();
	
	$query = "INSERT INTO factures_relances_niveaux
      (niveau_relance, id_relance_modele, lib_niveau_relance, delai_before_next, id_edition_mode, id_courrier_joint, impression, montant_mini, suite_avant_echeance, actif)
SELECT niveau_relance, ".intval($id_relance_modele).", lib_niveau_relance, delai_before_next, id_edition_mode, id_courrier_joint, impression, montant_mini, suite_avant_echeance, actif
FROM factures_relances_niveaux
WHERE id_relance_modele is null;";
	$bdd->exec ($query);
	
	return $id_relance_modele;	
}

// *************************************************************************************************************
// FONCTIONS LIEES A CREATION D'UN NIVEAU DE RELANCE
// *************************************************************************************************************
function create_niveau_relance($id_relance_modele, $lib_niveau_relance, $delai_before_next, $id_edition_mode, $impression = 0){
	global $bdd;

	if (!is_numeric($id_relance_modele)) {
		$GLOBALS['_ALERTES']['bad_id_client_categ'] = 1;
	}
	if (!is_numeric($delai_before_next)) {
		$GLOBALS['_ALERTES']['bad_delai_before_next'] = 1;
	}
	if (!is_numeric($id_edition_mode)) {
		$GLOBALS['_ALERTES']['bad_id_edition_mode'] = 1;
	}
	if (!is_numeric($id_courrier_joint)) {
		$GLOBALS['_ALERTES']['bad_id_courrier_joint'] = 1;
	}
	$this->id_relance_modele 		= $id_relance_modele;
	$this->lib_niveau_relance = $lib_niveau_relance;
	$this->delai_before_next 	= $delai_before_next;
	$this->id_edition_mode 		= $id_edition_mode;
	$this->id_courrier_joint	= $id_courrier_joint;
	$this->impression			= $impression;

	if (count($GLOBALS['_ALERTES'])) {
		return false;
	}

	// *************************************************
	// Sélection du niveau de relance
	$query = "SELECT MAX(niveau_relance) niveau_relance 
						FROM factures_relances_niveaux
						WHERE id_relance_modele = '".$this->id_relance_modele."' ";
	$resultat = $bdd->query ($query);
	if (!$niv = $resultat->fetchObject()) { $this->niveau_relance = 0; }
	else { $this->niveau_relance = $niv->niveau_relance +1; }

	// *************************************************
	// Insertion dans la base
	$query = "INSERT INTO factures_relances_niveaux 
							(niveau_relance, id_relance_modele, lib_niveau_relance, delai_before_next, id_edition_mode, id_courrier_joint, impression)
						VALUES ('".$this->niveau_relance."', '".$this->id_relance_modele."', '".addslashes($this->lib_niveau_relance)."', 
										'".$this->delai_before_next."', '".$this->id_edition_mode."', '".$this->id_courrier_joint."', '".$this->impression."') ";
	$bdd->exec ($query);
	$this->id_niveau_relance = $bdd->lastInsertId();

	$GLOBALS['_INFOS']['create_id_niveau_relance'] = $this->id_niveau_relance;
	return true;
}


// *************************************************************************************************************
// FONCTIONS LIEES A MODIFICATION D'UN NIVEAU DE RELANCE
// *************************************************************************************************************
function maj_relance ($lib_niveau_relance, $delai_before_next, $id_edition_mode, $actif, $impression = 0) {
	global $bdd;

	if (!is_numeric($delai_before_next)) {
		$GLOBALS['_ALERTES']['bad_delai_before_next'] = 1;
	}
	if (!is_numeric($id_edition_mode)) {
		$GLOBALS['_ALERTES']['bad_id_edition_mode'] = 1;
	}
	if (!is_numeric($id_courrier_joint)) {
		$GLOBALS['_ALERTES']['bad_id_courrier_joint'] = 1;
	}
	$this->lib_niveau_relance 	= $lib_niveau_relance;
	$this->delai_before_next 	= $delai_before_next;
	$this->id_edition_mode 		= $id_edition_mode;
	$this->id_courrier_joint	= $id_courrier_joint;
	$this->impression			= $impression;
	$this->actif				= $actif;

	if (count($GLOBALS['_ALERTES'])) {
		return false;
	}

	// *************************************************
	// Insertion dans la base
	$query = "UPDATE factures_relances_niveaux 
						SET lib_niveau_relance = '".addslashes($this->lib_niveau_relance)."', 
								delai_before_next = '".$this->delai_before_next."', 
								id_edition_mode = '".$this->id_edition_mode."', impression = '".$this->impression."', actif = '".$this->actif."'
						WHERE id_niveau_relance = '".$this->id_niveau_relance."' ";
	$bdd->exec ($query);

	return true;
}


// Modifie le niveau de ce niveau de relance
function maj_niveau ($new_niveau) {
	global $bdd;

	if (!is_numeric($new_niveau) || $new_niveau < 0 || ($new_niveau == 10 || $new_niveau == 11)) {
		$GLOBALS['_ALERTES']['bad_niveau'] = 1;
	}
	
	// *************************************************
	// Si les valeurs reçues sont incorrectes
	if (count($GLOBALS['_ALERTES'])) {
		return false;
	}

	if ($new_niveau == $this->niveau_relance) { return false; }
	elseif ($new_niveau < $this->niveau_relance) {
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

	// Mise à jour des autres adresses
	$query = "UPDATE factures_relances_niveaux
						SET niveau_relance = niveau_relance ".$variation." 1
						WHERE id_relance_modele = '".$this->id_relance_modele."' && 
									niveau_relance ".$symbole1." '".$this->niveau_relance."' && niveau_relance ".$symbole2." '".$new_niveau."' ";
	$bdd->exec ($query);

	// Mise à jour de cette adresse
	$query = "UPDATE factures_relances_niveaux
						SET niveau_relance = '".$new_niveau."'
						WHERE id_niveau_relance = '".$this->id_niveau_relance."'  ";
	$bdd->exec ($query);

	$bdd->commit();	

	$this->niveau_relance = $new_niveau;

	// *************************************************
	// Résultat positif de la modification
	return true;
}


public function suppression () {
	global $bdd;

	// *************************************************
	// Controle à effectuer le cas échéant

	// *************************************************
	// Suppression du niveau
	$query = "DELETE FROM factures_relances_niveaux 
						WHERE id_niveau_relance = '".$this->id_niveau_relance."' ";
	$bdd->exec ($query);

	// Changement des niveaux suivants
	$query = "UPDATE factures_relances_niveaux 
						SET  niveau_relance = niveau_relance -1
						WHERE id_relance_modele = '".$this->id_relance_modele."' && niveau_relance > '".$this->niveau_relance."'";
	$bdd->exec ($query);

	unset ($this);
	return true;
}



// *************************************************************************************************************
// FONCTIONS DE RESTITUTION DES DONNEES 
// *************************************************************************************************************
function getId_niveau_relance () {
	return $this->id_niveau_relance;
}

function getNiveau_relance () {
	return $this->niveau_relance;
}

function getId_client_categ () {
	return $this->id_relance_modele;
}

function getLib_niveau_relance () {
 return $this->lib_niveau_relance;
}

function getLib_etat_relance () {
	return $this->lib_etat_relance;
}

function getDelai_before_next () {
	return $this->delai_before_next;
}

function getId_edition_mode () {
	return $this->id_edition_mode;
}

function getMontant_mini () {
	return $this->montant_mini;
}

function getSuite_avant_echeance () {
	return $this->suite_avant_echeance;
}

function getActif () {
	return $this->actif;
}

function getImpression () {
	return $this->impression;
}



}



// *************************************************************************************************************
// FONCTION DE GESTION DES NIVEAUX DE RELANCE DES FACTURES
// *************************************************************************************************************


function getNiveaux_relance ($id_relance_modele, $null = false) {
	global $bdd;

	$niveaux_relances = array();

        if ($null){
            $null_relance = new stdClass();
            $null_relance->id_niveau_relance = null;
            $null_relance->niveau_relance = null;
            $null_relance->id_relance_modele = $id_relance_modele;
            $null_relance->lib_niveau_relance = "Non defini";
            $null_relance->delai_before_next = 0;
            $null_relance->id_edition_mode = "";
            $null_relance->impression = 0;
            $null_relance->montant_mini = 0;
            $null_relance->suite_avant_echeance = 1;
            $null_relance->actif = 1;
            $niveaux_relances[] = $null_relance;
        }

	$query = "SELECT id_niveau_relance, niveau_relance, id_relance_modele, lib_niveau_relance, delai_before_next, 
									 id_edition_mode, impression, montant_mini, suite_avant_echeance, actif
						FROM factures_relances_niveaux";
	if($id_relance_modele != 0 ){
	$query =$query."			WHERE id_relance_modele = '".$id_relance_modele."' 
						ORDER BY niveau_relance ASC";
	}
	else{
	$query =$query."			WHERE id_relance_modele IS NULL 
						ORDER BY niveau_relance ASC";
	}
	$resultat = $bdd->query ($query);
	while ($niveau = $resultat->fetchObject()) { $niveaux_relances[] = $niveau; }

	return $niveaux_relances;
}

?>