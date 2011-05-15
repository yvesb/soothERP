<?php
// *************************************************************************************************************
// CLASSE REGISSANT LES INFORMATIONS SUR UNE TACHE D'UN ADMINISTRATEUR 
// *************************************************************************************************************


final class tache_admin {
	private $id_tache;

	private $lib_tache_admin;
	private $description;
	private $url_action;
	private $date_creation;
	private $date_execution;


function __construct($id_tache_admin = 0) {
	global $bdd;

	// Controle si la id_tache est précisée
	if (!$id_tache_admin) { return false; }
	// Sélection des informations générales
	$query = "SELECT lib_tache_admin, description, url_action, date_creation, date_execution 
						FROM taches_admin t
						WHERE id_tache_admin = '".$id_tache_admin."' ";
	$resultat = $bdd->query ($query);

	// Controle si la id_tache est trouvée
	if (!$tache = $resultat->fetchObject()) { return false; }

	// Attribution des informations à l'objet
	$this->id_tache_admin 	= $id_tache_admin;
	$this->lib_tache_admin	= $tache->lib_tache_admin;
	$this->description			= $tache->description;
	$this->url_action				= $tache->url_action;
	$this->date_creation		= $tache->date_creation;
	$this->date_execution 	= $tache->date_execution;

	return true;
}



// *************************************************************************************************************
// FONCTIONS LIEES A LA CREATION D'UNE TACHE 
// *************************************************************************************************************

public function create_tache ($lib_tache_admin, $description, $url_action) {
	global $bdd;

	// *************************************************
	// Controle des données transmises
	$this->lib_tache_admin 	= trim($lib_tache_admin);
	$this->description = $description;
	$this->url_action = $url_action;
	
	// *************************************************
	// Si les valeurs reçues sont incorrectes
	if (count($GLOBALS['_ALERTES'])) {
		return false;
	}

	// *************************************************
	// Insertion dans la base
	$query = "INSERT INTO taches_admin 
							(lib_tache_admin, description, url_action, date_creation)
						VALUES ('".addslashes($this->lib_tache_admin)."', '".addslashes($this->description)."', 
										'".$this->url_action."', NOW()) ";
	$bdd->query($query);
	$this->id_tache_admin = $bdd->lastInsertId();

	// *************************************************
	// Résultat positif de la création
	$GLOBALS['_INFOS']['Création_tache'] = $this->id_tache_admin;

	return true;
}


// *************************************************************************************************************
// FONCTIONS LIEES A L'EXECUTION DE LA TACHE
// *************************************************************************************************************

public function exec_tache () {
	global $bdd;
	
	// *************************************************
	// Controle des données transmises

	// *************************************************
	// Si les valeurs reçues sont incorrectes
	if (count($GLOBALS['_ALERTES'])) {
		return false;
	}

	// *************************************************
	// Mise a jour de la base
	$query = "UPDATE taches_admin 
						SET date_execution = NOW()
						WHERE id_tache_admin = '".$this->id_tache_admin."' ";
	$bdd->exec ($query);

	// *************************************************
	// Résultat positif de la modification
	return true;
}

// *************************************************************************************************************
// FONCTIONS DE CHARGEMENT DES TACHES
// *************************************************************************************************************
//chargement des taches non executées
static function charger_taches_todo () {
	global $bdd;
	
	$taches = array();
	
	$query = "SELECT id_tache_admin, lib_tache_admin, description, url_action, date_creation, date_execution 
						FROM taches_admin t
						WHERE date_execution = '0000-00-00 00:00:00'";
	$resultat = $bdd->query ($query);
	while ($tmp = $resultat->fetchObject()) { $taches[] = $tmp; }

	return $taches;
}
//chargement des taches executées de moins de 7 jours
static function charger_taches_done () {
	global $bdd;
	
	$taches = array();
	
	$query = "SELECT id_tache_admin, lib_tache_admin, description, url_action, date_creation, date_execution 
						FROM taches_admin t
						WHERE TO_DAYS(NOW()) - TO_DAYS(date_execution) <= 7
						ORDER BY date_execution DESC
						LIMIT 0,2
						";
	$resultat = $bdd->query ($query);
	while ($tmp = $resultat->fetchObject()) { $taches[] = $tmp; }

	return $taches;
}

// *************************************************************************************************************
// FONCTIONS DE LECTURE DES DONNEES 
// *************************************************************************************************************
function getId_tache_admin () {
	return $this->id_tache_admin;
}

function getLib_tache_admin () {
	return $this->lib_tache_admin;
}

function getDescription () {
 return $this->description;
}

function getUrl_action () {
	return $this->url_action;
}


function getDate_creation () {
	return $this->date_creation;
}

function getDate_execution () {
	return $this->date_execution;
}

}

?>