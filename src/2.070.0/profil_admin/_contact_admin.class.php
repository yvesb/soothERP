<?php
// *************************************************************************************************************
// CLASSE PERMETTANT LA GESTION D'UN CONTACT AYANT LE PROFIL [ADMIN]  
// *************************************************************************************************************

class contact_admin extends contact_profil {
	private $type_admin;
	

function __construct ($ref_contact, $action = "open") {
	global $bdd;
	global $DIR, $CONFIG_DIR;
	global $BDD_TYPE_ADMIN;

	include_once ($CONFIG_DIR."profil_admin.config.php");

	$this->ref_contact = $ref_contact;
	
	if ($action == "create") {
		return false;
	}
	
	$query = "SELECT type_admin FROM annu_admin
						WHERE ref_contact = '".$this->ref_contact."' ";	
	$resultat = $bdd->query ($query);

	// Controle si la ref_contact est trouvée
	if (!$contact_admin = $resultat->fetchObject()) { return false; }
	
	$this->type_admin = $contact_admin->type_admin;

	$this->profil_loaded = true;
}



// *************************************************************************************************************
// CREATION DES INFORMATIONS DU PROFIL [ADMIN]  
// *************************************************************************************************************
function create_infos ($infos) {
	global $BDD_TYPE_ADMIN;
	global $DIR, $CONFIG_DIR;
	global $bdd;

	// Controle si ces informations sont déjà existantes
	if ($this->profil_loaded) {
		return false;
	}

	// Fichier de configuration de ce profil
	include ($CONFIG_DIR."profil_admin.config.php");

	// Controle des informations
	if (isset($infos['type_admin']) && in_array($infos['type_admin'], $BDD_TYPE_ADMIN)) {
		$this->type_admin = $infos['type_admin'];
	}
	else {
		$this->type_admin = $DEFAUT_TYPE_ADMIN;
	}

	// *************************************************
	// Arret en cas d'erreur
	if (count($GLOBALS['_ALERTES'])) {
		return false;
	}

	// *************************************************
	// Insertion des données
	$query = "INSERT INTO annu_admin (ref_contact, type_admin) 
						VALUES ('".$this->ref_contact."', '".$this->type_admin."')"; 
	$bdd->exec($query);

	return true;
}



// *************************************************************************************************************
// MODIFICATION DES INFORMATIONS DU PROFIL [ADMIN]  
// *************************************************************************************************************
function maj_infos ($infos) {
	global $BDD_TYPE_ADMIN;
	
	global $bdd;

	if (!$this->profil_loaded) {
		$GLOBALS['_ALERTES']['profil_non_chargé'] = 1;
	}
	
	// *************************************************
	// Controle des informations
	if (isset($infos['type_admin']) && in_array($infos['type_admin'], $BDD_TYPE_ADMIN)) {
		$this->type_admin = $infos['type_admin'];
	}
	else {
		$GLOBALS['_ALERTES']['bad_type_admin'] = 1;
	}

	// *************************************************
	// Arret en cas d'erreur
	if (count($GLOBALS['_ALERTES'])) {
		return false;
	}

	// *************************************************
	// Mise à jour des données
	$query = "UPDATE annu_admin SET type_admin = '".$this->type_admin."'
						WHERE ref_contact = '".$this->ref_contact."' "; 
	$bdd->exec($query);

	return true;
}



// *************************************************************************************************************
// SUPPRESSION DES INFORMATIONS DU PROFIL [ADMIN]  
// *************************************************************************************************************
function delete_infos () {
	global $bdd;
	
	
	// Vérifie si la suppression de ces informations est possible.
	
	// Supprime les informations
	$query = "DELETE FROM annu_admin WHERE ref_contact = '".$this->ref_contact."' ";
	$bdd->exec($query); 

	// *************************************************
	// Arret en cas d'erreur
	if (count($GLOBALS['_ALERTES'])) {
		return false;
	}

	return true;
}

// *************************************************************************************************************
// FONCTIONS DE LECTURE DES DONNEES 
// *************************************************************************************************************
function getType_admin () {
	return $this->type_admin;
}

}




?>