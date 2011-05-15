<?php
// *************************************************************************************************************
// CLASSE PERMETTANT LA GESTION D'UN CONTACT AYANT LE PROFIL [COMMERCIAL]  
// *************************************************************************************************************

class contact_commercial extends contact_profil {

	private $ref_contact; 						// Référence du contact
  private $id_commercial_categ; 		// Identifiant de la catégorie du commercial
  private $id_commission_regle;			// id de régle de commissionnement

  private $lib_comm;								// libellé de régle de commissionnement
  private $formule_comm;						// formule de régle de commissionnement
  private $lib_commercial_categ;		// libellé de la catégorie du commercial


function __construct ($ref_contact = "", $action = "open") {
	global $bdd;

	// Controle si la ref_contact est précisée
	if (!$ref_contact) { return false; }
	$this->ref_contact = $ref_contact;
	
	if ($action == "create") {
		return false;
	}

	$query = "SELECT ac.ref_contact, ac.id_commercial_categ, ac.id_commission_regle,
									 cr.lib_comm, cr.formule_comm,
									 cc.lib_commercial_categ				
					FROM  annu_commercial ac
						LEFT JOIN commissions_regles cr ON cr.id_commission_regle = ac.id_commission_regle
						LEFT JOIN commerciaux_categories cc ON cc.id_commercial_categ = ac.id_commercial_categ
						WHERE ref_contact = '".$this->ref_contact."' ";	
	$resultat = $bdd->query ($query);

	// Controle si la ref_contact (commercial) est trouvée
	if (!$contact_commercial = $resultat->fetchObject()) { return false; }
	
	$this->ref_contact 					= $contact_commercial->ref_contact;
	$this->id_commercial_categ	= $contact_commercial->id_commercial_categ;
	$this->id_commission_regle 	= $contact_commercial->id_commission_regle;
	$this->lib_comm 			= $contact_commercial->lib_comm;
	$this->formule_comm 				= $contact_commercial->formule_comm;
  $this->lib_commercial_categ	= $contact_commercial->lib_commercial_categ;
	$this->profil_loaded 	= true;
	
}



// *************************************************************************************************************
// CREATION DES INFORMATIONS DU PROFIL [commercial]  
// *************************************************************************************************************
function create_infos ($infos) {
	global $DIR, $CONFIG_DIR;
	global $bdd;
	global $DEFAUT_ID_COMMERCIAL_CATEG;

	// Controle si ces informations sont déjà existantes
	if ($this->profil_loaded) {
		return false;
	}

	// Fichier de configuration de ce profil
	include_once ($CONFIG_DIR."profil_commercial.config.php");
		
	// *************************************************
	// Controle des informations
	$this->id_commercial_categ = $DEFAUT_ID_COMMERCIAL_CATEG; 
	if (isset($infos['id_commercial_categ']) && $infos['id_commercial_categ']) {	
		$this->id_commercial_categ = $infos['id_commercial_categ']; 
	}

	$this->id_commission_regle = NULL;
	if (isset($infos['id_commission_regle']) && $infos['id_commission_regle']) { 
		$this->id_commission_regle = $infos['id_commission_regle'];
	}
	if (!$this->id_commission_regle) {
		$query_comm = "SELECT id_commercial_categ , lib_commercial_categ, cc.id_commission_regle
										
									FROM commerciaux_categories cc
									WHERE id_commercial_categ = '".$this->id_commercial_categ."'
									ORDER BY lib_commercial_categ ";
		$resultat_defaut = $bdd->query ($query_comm);
		if ($commission_defaut = $resultat_defaut->fetchObject()) { $this->id_commission_regle = $commission_defaut->id_commission_regle; }
	}
	
	// *************************************************
	// Arret en cas d'erreur
	if (count($GLOBALS['_ALERTES'])) {
		return false;
	}
	
	// *************************************************
	// Insertion des données
	$query = "INSERT INTO annu_commercial 
							(ref_contact, id_commercial_categ, id_commission_regle)
						VALUES ('".$this->ref_contact."', ".num_or_null($this->id_commercial_categ).",
						 				".num_or_null($this->id_commission_regle).")"; 
	$bdd->exec($query);

	return true;
}



// *************************************************************************************************************
// MODIFICATION DES INFORMATIONS DU PROFIL [commercial]  
// *************************************************************************************************************
function maj_infos ($infos) {
	global $bdd;
	global $DEFAUT_ID_COMMERCIAL_CATEG;

	if (!$this->profil_loaded) {
		$GLOBALS['_ALERTES']['profil_non_chargé'] = 1;
	}

	// *************************************************
	// Controle des informations
	if (isset($infos['id_commission_regle']) && $infos['id_commission_regle']) { 
		$this->id_commission_regle = $infos['id_commission_regle'];
	}
	//la categ à changé on attribu la grille correspondant à la categ
	if ($this->id_commercial_categ != $infos['id_commercial_categ']) {
		$query_comm = "SELECT id_commercial_categ , lib_commercial_categ, cc.id_commission_regle
										
									FROM commerciaux_categories cc
									WHERE id_commercial_categ = '".$infos['id_commercial_categ']."'
									ORDER BY lib_commercial_categ ";
		$resultat_defaut = $bdd->query ($query_comm);
		if ($commission_defaut = $resultat_defaut->fetchObject()) { $this->id_commission_regle = $commission_defaut->id_commission_regle; }
	}
	
	if (isset($infos['id_commercial_categ']) && $infos['id_commercial_categ']) {	
		$this->id_commercial_categ = $infos['id_commercial_categ']; 
	}


	// *************************************************
	// Arret en cas d'erreur
	if (count($GLOBALS['_ALERTES'])) {
		return false;
	}


	// *************************************************
	// Mise à jour des données
	$query = "UPDATE annu_commercial 
						SET id_commercial_categ = ".num_or_null($this->id_commercial_categ).", 
								id_commission_regle = ".num_or_null($this->id_commission_regle)."
						WHERE ref_contact = '".$this->ref_contact."' ";
	$bdd->exec($query);

	return true;
}


// *************************************************************************************************************
// SUPPRESSION DES INFORMATIONS DU PROFIL [commercial]  
// *************************************************************************************************************
function delete_infos () {
	global $bdd;

	// Vérifie si la suppression de ces informations est possible.

	// Supprime les informations
	$query = "DELETE FROM annu_commercial WHERE ref_contact = '".$this->ref_contact."' ";
	$bdd->exec($query); 


	if (count($GLOBALS['_ALERTES'])) {
		return false;
	}

	return true;
}



// *************************************************************************************************************
// TRANSFERT DES INFORMATIONS DU PROFIL [commercial]  
// *************************************************************************************************************
function transfert_infos ($new_contact, $is_already_profiled) {
	global $bdd;

	// Vérifie si le transfert de ces informations est possible.
	if (!$is_already_profiled) {
		// TRANSFERT les informations
		$query = "UPDATE annu_commercial SET ref_contact = '".$new_contact->getRef_contact()."' 
							WHERE ref_contact = '".$this->ref_contact."'";
		$bdd->exec($query); 
	}

	// *************************************************
	// Arret en cas d'erreur
	if (count($GLOBALS['_ALERTES'])) {
		return false;
	}

	return true;
}


// *************************************************************************************************************
// FONCTIONS DIVERSES 
// *************************************************************************************************************


// *************************************************************************************************************
// FONCTIONS DE GESTION DES CATEGORIES DE commercial
// *************************************************************************************************************
static public function charger_commerciaux_categories  () {
	global $bdd;
	
	$commerciaux_categories = array();
	$query = "SELECT id_commercial_categ , lib_commercial_categ, cc.id_commission_regle,
									 cr.lib_comm, cr.formule_comm
						FROM commerciaux_categories cc
						LEFT JOIN commissions_regles cr ON cr.id_commission_regle = cc.id_commission_regle
						ORDER BY lib_commercial_categ ";
	$resultat = $bdd->query ($query);
	while ($var = $resultat->fetchObject()) { $commerciaux_categories[] = $var; }

	return $commerciaux_categories;
}

static public function charger_commissions_regles  () {
	global $bdd;
	
	$commerciaux_categories = array();
	$query = "SELECT cr.id_commission_regle,
									 cr.lib_comm, cr.formule_comm, defaut,
									 (SELECT COUNT(ac.ref_contact) FROM annu_commercial ac WHERE ac.id_commission_regle = cr.id_commission_regle ) as nb_comm
						FROM commissions_regles cr 
						ORDER BY lib_comm ";
	$resultat = $bdd->query ($query);
	while ($var = $resultat->fetchObject()) { $commerciaux_categories[] = $var; }

	return $commerciaux_categories;
}


static public function create_commerciaux_categories ($infos) {
	global $bdd;

	// *************************************************
	// Insertion des données
	$query = "INSERT INTO commerciaux_categories (lib_commercial_categ, id_commission_regle) 
						VALUES ('".addslashes($infos['lib_commercial_categ'])."', ".num_or_null($infos['id_commission_regle']).")"; 
	$bdd->exec($query);

	return true;
}


static public function maj_infos_commerciaux_categories  ($infos) {
	global $bdd;
	
	// *************************************************
	// Mise à jour des données
	$query = "UPDATE commerciaux_categories  
						SET lib_commercial_categ = '".addslashes($infos['lib_commercial_categ'])."', 
						id_commission_regle = ".num_or_null($infos['id_commission_regle'])."
						WHERE id_commercial_categ = '".$infos['id_commercial_categ']."' ";
	$bdd->exec($query);
	
	return true;
}

static public function delete_infos_commerciaux_categories  ($id_commercial_categ) {
	global $bdd;
	global $DEFAUT_ID_COMMERCIAL_CATEG;
	
	if ($id_commercial_categ == $DEFAUT_ID_COMMERCIAL_CATEG) {
		$GLOBALS['_ALERTES']['last_id_commercial_categ'] = 1;
	}
	// Vérifie si la suppression de ces informations est possible.
	if (count($GLOBALS['_ALERTES'])) {
		return false;
	}
	// *************************************************
	// Mise à jour des données
	$query = "DELETE FROM commerciaux_categories WHERE id_commercial_categ = '".$id_commercial_categ."' ";
	$bdd->exec($query);
	
	return true;
}



// *************************************************************************************************************
// FONCTIONS DE LECTURE DES DONNEES 
// *************************************************************************************************************
function getref_contact () {
	return $this->ref_contact;
}

function getId_commercial_categ () {
	return $this->id_commercial_categ;
}

function getId_commission_regle () {
	return $this->id_commission_regle;
}


}

?>