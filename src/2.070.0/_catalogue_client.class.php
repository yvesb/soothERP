<?php
// *************************************************************************************************************
// CLASSE REGISSANT LES INFORMATIONS SUR UN CATALOGUE CLIENT
// *************************************************************************************************************


final class catalogue_client {
	private $id_catalogue_client;			// Identifiant de la catégorie client
	private $lib_catalogue_client;
	private $id_catalogue_client_dir;		//
	private $lib_catalogue_client_dir;		
	private $ref_art_categ;
	private $id_catalogue_dir_parent;	// Identifiant de la categorie client parent, permettant de créer une hierarchie

	private $catalogue_client_dirs_childs; //liste des dirs enfant d'une catégorie

	private $catalogue_client_dirs_parents; //liste des dirs parents d'une catégorie

function __construct($id_catalogue_client = "") {
	global $bdd;

	// Controle si la id_catalogue_client est précisée
	if (!$id_catalogue_client) { return false; }

	// Sélection des informations générales
	$query = "SELECT id_catalogue_client, lib_catalogue_client
						FROM catalogues_clients 
						WHERE id_catalogue_client = '".$id_catalogue_client."' ";
	$resultat = $bdd->query ($query);

	// Controle si l' id_catalogue_client est trouvée
	if (!$catalogue_client = $resultat->fetchObject()) { return false; }

	// Attribution des informations à l'objet
	$this->id_catalogue_client 		= $id_catalogue_client;
	$this->lib_catalogue_client		= $catalogue_client->lib_catalogue_client;

	return true;
}



// *************************************************************************************************************
// FONCTIONS LIEES A LA CREATION D'UN CATALOGUE CLIENT
// *************************************************************************************************************

final public function create ($lib_catalogue_client) {
	global $bdd;

	// *************************************************
	// Controle des données transmises
	$this->lib_catalogue_client		= $lib_catalogue_client;

	// *************************************************
	// Si les valeurs reçues sont incorrectes
	if (count($GLOBALS['_ALERTES'])) {
		return false;
	}


	// *************************************************
	// Insertion dans la base
	$query = "INSERT INTO catalogues_clients (lib_catalogue_client)
						VALUES ('".addslashes($this->lib_catalogue_client)."' ) ";
	$bdd->exec ($query);
	$this->id_catalogue_client = $bdd->lastInsertId();

	
	// *************************************************
	// Résultat positif de la création
	return true;
}



// *************************************************************************************************************
// FONCTIONS LIEES A LA MODIFICATION D'UN CATALOGUE CLIENT
// *************************************************************************************************************

final public function modification ($lib_catalogue_client) {
	global $bdd;
	
	// *************************************************
	// Controle des données transmises
	$this->lib_catalogue_client		= $lib_catalogue_client;
	

	// *************************************************
	// Si les valeurs reçues sont incorrectes
	if (count($GLOBALS['_ALERTES'])) {
		return false;
	}

	// *************************************************
	// Mise a jour de la base
	$query = "UPDATE catalogues_clients 
						SET lib_catalogue_client = '".addslashes($this->lib_catalogue_client)."' 
						WHERE id_catalogue_client = '".$this->id_catalogue_client."' ";
	$bdd->exec ($query);

}



// *************************************************************************************************************
// FONCTIONS LIEES A LA SUPPRESSION D'UN CATALOGUE CLIENT
// *************************************************************************************************************
final public function suppression () {
	global $bdd;

	// *************************************************
	// Controle de l'existance d'un article de cette catégorie
	$query = "SELECT id_catalogue_client FROM magasins WHERE !ISNULL(id_catalogue_client)";
	$resultat = $bdd->query ($query);
	if ($catalogue_client = $resultat->fetchObject()) {
		$GLOBALS['_ALERTES']['used_catalogue_client'] = 1;
	}

	// *************************************************
	// Si les valeurs reçues sont incorrectes
	if (count($GLOBALS['_ALERTES'])) {
		return false;
	}

	// *************************************************
	// Suppression du catalogue
	$query = "DELETE FROM catalogues_clients 
						WHERE id_catalogue_client = '".$this->id_catalogue_client."' ";
	$bdd->exec ($query);
	
	$bdd->commit();

	unset ($this);
}



// *************************************************************************************************************
// FONCTIONS LIEES A LA GESTION DES CATÉGORIES DU CATALOGUE CLIENT
// *************************************************************************************************************
//fonction d'ajout  d'une catalogue_client_dir (depuis la création "simple" du catalogue)
final public function add_catalogue_client_dir ($ref_art_categ =  "", $ref_art_categ_parent = "") {
	global $bdd;
	
	if (!$ref_art_categ) {$GLOBALS['_ALERTES']['bad_ref_art_categ'] = 1;}
	
	// *************************************************
	// Si les valeurs reçues sont incorrectes
	if (count($GLOBALS['_ALERTES'])) {
		return false;
	}
	
	//récupération des informations depuis l'art_categ
	$this->ref_art_categ = $ref_art_categ;
	$this->lib_catalogue_client_dir = "";
	
	if ($ref_art_categ) {	
		$query = "SELECT lib_art_categ 
							FROM art_categs  
							WHERE ref_art_categ = '".$ref_art_categ."' ";
		$resultat = $bdd->query ($query);
		if ($art_categ = $resultat->fetchObject()) {
			$this->lib_catalogue_client_dir = 	$art_categ->lib_art_categ;
		}
	}
	
	//récupération de l'id_catalogue_client_dir si existant
	$this->id_catalogue_dir_parent =	NULL;
	
	if ($ref_art_categ_parent) {
		$query = "SELECT id_catalogue_client_dir 
							FROM catalogues_clients_dirs 
							WHERE ref_art_categ = '".$ref_art_categ_parent."' ";
		$resultat = $bdd->query ($query);
		if ($catalogue_client_dir = $resultat->fetchObject()) {
			$this->id_catalogue_dir_parent = 	$catalogue_client_dir->id_catalogue_client_dir;
		}
	}
	
	// *************************************************
	// Insertion dans la base
	$query = "INSERT INTO catalogues_clients_dirs (id_catalogue_client, lib_catalogue_client_dir, ref_art_categ, id_catalogue_dir_parent)
						VALUES ('".$this->id_catalogue_client."', '".addslashes($this->lib_catalogue_client_dir)."', '".$this->ref_art_categ."', ".num_or_null($this->id_catalogue_dir_parent)." ) ";
	$bdd->exec ($query);

	//liaison EDI
        /*$query = "SHOW TABLES LIKE 'edi_canaux';";
            if ($result = $bdd->query($query)){
                if ($table = $result->fetchObject()){
                    $query = "SELECT id_catalogue ".
                                    "FROM edi_canaux ".
                                    "WHERE id_catalogue = '".$this->id_catalogue_client."' AND actif = '1'";
                    $res = $bdd->query($query);
                    if(is_object($res) && $canal = $res->fetchObject()){
                            edi_event(101, $ref_art_categ, $this->id_catalogue_client);
                    }
                    $res->closeCursor();
                }
        }*/
        edi_event(101, $ref_art_categ, $this->id_catalogue_client);
	
	// *************************************************
	// Résultat positif de la création
	return true;
	
}

//fonction de suppression  d'une catalogue_client_dir (depuis la création "simple" du catalogue)
final public function del_catalogue_client_dir ($ref_art_categ =  "") {
	global $bdd;
	
	if (!$ref_art_categ) {$GLOBALS['_ALERTES']['bad_ref_art_categ'] = 1;}
	
	// *************************************************
	// Si les valeurs reçues sont incorrectes
	if (count($GLOBALS['_ALERTES'])) {
		return false;
	}
	
	//liaison EDI
        $query = "SHOW TABLES LIKE 'edi_canaux';";
            if ($result = $bdd->query($query)){
                if ($table = $result->fetchObject()){
                    $query = "SELECT ID_CATALOGUE ".
                                                            "FROM edi_canaux ".
                                                            "WHERE id_catalogue = '".$this->id_catalogue_client."'  AND actif = '1'";
                    $res = $bdd->query($query);
                    if(is_object($res) && $canal = $res->fetchObject()){
                            edi_event(109, $ref_art_categ, $this->id_catalogue_client);
                    }
                    $res->closeCursor();
                }
        }
	
	// *************************************************
	// Suppression dans la base	
	$query = "DELETE FROM catalogues_clients_dirs 
						WHERE id_catalogue_client = '".$this->id_catalogue_client."' && ref_art_categ = '".$ref_art_categ."' ";
	$bdd->exec ($query);
	
	// *************************************************
	// Résultat positif de la suppression
	return true;
	
}

//fonction d'ajout de toutes les art_categ dans un catalogue client
final public function add_all_catalogue_client_dir () {
	global $bdd;
	
	//liste des catégories d'articles
	$list_art_categ =	get_articles_categories();
	
	// *************************************************
	// Suppression dans la base	de tout les catalogue_client_dir
	$query = "DELETE FROM catalogues_clients_dirs 
						WHERE id_catalogue_client = '".$this->id_catalogue_client."' ";
	$bdd->exec ($query);
	
	// *************************************************
	// Insertion dans la base
	foreach ($list_art_categ as $art_categ) {
		$this->add_catalogue_client_dir ($art_categ->ref_art_categ, $art_categ->ref_art_categ_parent);
	}
	
	// *************************************************
	// Résultat positif de la création
	return true;

}

//fonction de suppression de toutes les art_categ dans un catalogue client
final public function del_all_catalogue_client_dir () {
	global $bdd;

	// *************************************************
	// Suppression dans la base	de tout les catalogue_client_dir
	$query = "DELETE FROM catalogues_clients_dirs 
						WHERE id_catalogue_client = '".$this->id_catalogue_client."' ";
	$bdd->exec ($query);

	// *************************************************
	// Résultat positif de la suppression
	return true;

}
//fonction de creation d'une catalogue_client_dir (depuis la création "avancée" du catalogue)
final public function create_catalogue_client_dir ($lib_catalogue_client_dir, $ref_art_categ ,$id_catalogue_dir_parent) {
	global $bdd;
	
	if ($lib_catalogue_client_dir == "") {$GLOBALS['_ALERTES']['bad_lib_catalogue_client_dir'] = 1;}
	if (!$ref_art_categ) {$GLOBALS['_ALERTES']['bad_ref_art_categ'] = 1;}
	
	// *************************************************
	// Si les valeurs reçues sont incorrectes
	if (count($GLOBALS['_ALERTES'])) {
		return false;
	}
	
	$this->ref_art_categ = $ref_art_categ;
	$this->lib_catalogue_client_dir = $lib_catalogue_client_dir;
	$this->id_catalogue_dir_parent =	$id_catalogue_dir_parent;
	
	
	// *************************************************
	// Insertion dans la base
	$query = "INSERT INTO catalogues_clients_dirs (id_catalogue_client, lib_catalogue_client_dir, ref_art_categ, id_catalogue_dir_parent)
						VALUES ('".$this->id_catalogue_client."', '".addslashes($this->lib_catalogue_client_dir)."', '".$this->ref_art_categ."', ".num_or_null($this->id_catalogue_dir_parent)." ) ";
	$bdd->exec ($query);

	
	// *************************************************
	// Résultat positif de la création
	return true;
	
}

//fonction de modification d'une catalogue_client_dir (depuis la création "avancée" du catalogue)
final public function modification_catalogue_client_dir ($id_catalogue_client_dir, $lib_catalogue_client_dir, $ref_art_categ ,$id_catalogue_dir_parent) {
	global $bdd;
	
	if ($lib_catalogue_client_dir == "") {$GLOBALS['_ALERTES']['bad_lib_catalogue_client_dir'] = 1;}
	if (!$ref_art_categ) {$GLOBALS['_ALERTES']['bad_ref_art_categ'] = 1;}
	
	// *************************************************
	// Si les valeurs reçues sont incorrectes
	if (count($GLOBALS['_ALERTES'])) {
		return false;
	}
	
	$this->id_catalogue_client_dir = $id_catalogue_client_dir;
	$this->ref_art_categ = $ref_art_categ;
	$this->lib_catalogue_client_dir = $lib_catalogue_client_dir;
	$this->id_catalogue_dir_parent =	$id_catalogue_dir_parent;
	
	
	// *************************************************
	// Modification dans la base
	$query = "UPDATE catalogues_clients_dirs 
						SET lib_catalogue_client_dir = '".addslashes($this->lib_catalogue_client_dir)."', ref_art_categ = '".$this->ref_art_categ."', id_catalogue_dir_parent = ".num_or_null($this->id_catalogue_dir_parent)."
						WHERE id_catalogue_client_dir = '".$this->id_catalogue_client_dir."' ";
	$bdd->exec ($query);
	
	edi_event(105,	$this->ref_art_categ);
	
	
	// *************************************************
	// Résultat positif de la création
	return true;
	
}


//fonction de suppression d'une catalogue_client_dir (depuis la création "avancée" du catalogue)
final public function suppression_catalogue_client_dir ($id_catalogue_client_dir, $new_id_catalogue_dir_parent = "") {
	global $bdd;
	

	// Controle de l'existance d'une catégorie d'article enfant
	$query = "SELECT id_catalogue_client_dir FROM catalogues_clients_dirs
						WHERE id_catalogue_dir_parent = '".$id_catalogue_client_dir."' LIMIT 0,1";
	$resultat = $bdd->query ($query);
	if ($catalogue_client_dir = $resultat->fetchObject()) { 
		// Controle de la id_catalogue_dir_parent de remplacement pour les enfants
		$query = "SELECT id_catalogue_client_dir FROM catalogues_clients_dirs
							WHERE id_catalogue_client_dir = '".$new_id_catalogue_dir_parent."' LIMIT 0,1";
		$resultat = $bdd->query ($query);
		if (!($catalogue_client_dir = $resultat->fetchObject())) { 
			$GLOBALS['_ALERTES']['bad_new_id_catalogue_dir_parent'] = 1;
		}
	}
	// *************************************************
	// Si les valeurs reçues sont incorrectes
	if (count($GLOBALS['_ALERTES'])) {
		return false;
	}
	
	// *************************************************
	// Suppression de la catégorie
	
	$bdd->beginTransaction();
	
	// Changement des catégories enfants
	$query = "UPDATE catalogues_clients_dirs SET id_catalogue_dir_parent = '".$new_id_catalogue_dir_parent."'  
						WHERE id_catalogue_dir_parent = '".$id_catalogue_client_dir."' ";
	$bdd->exec ($query);
	
	// Suppression de la catégorie
	$query = "DELETE FROM catalogues_clients_dirs 
						WHERE id_catalogue_client_dir = '".$id_catalogue_client_dir."' ";
	$bdd->exec ($query);
	
	$bdd->commit();
	
	
}

//fonction qui retourne la liste des parents
function return_catalogue_client_dirs_parents ( $id_catalogue_client_dir = "") {
	global $bdd;
  if (!$id_catalogue_client_dir) {return false;}
	$query = "SELECT id_catalogue_client_dir, lib_catalogue_client_dir, id_catalogue_dir_parent, id_catalogue_client, ref_art_categ
						FROM catalogues_clients_dirs
						WHERE id_catalogue_client_dir = '".$id_catalogue_client_dir."' ";
	$resultat = $bdd->query ($query);
	while ($var = $resultat->fetchObject()) { 
		$this->catalogue_client_dirs_parents[] = $var; 
		$this->return_catalogue_client_dirs_parents ($var->id_catalogue_dir_parent) ;
	}
	
	return true;	
	
}

//fonction qui renvois les infos du id_catalogue_client_dir choisi et appel la liste des catalogue_client_dir_parent
function charger_catalogue_client_dirs_parents ( $id_catalogue_client_dir = "") {
	global $bdd;

	$this->catalogue_client_dirs_parents = array();
	$query = "SELECT id_catalogue_client_dir, lib_catalogue_client_dir, id_catalogue_dir_parent, id_catalogue_client, ref_art_categ
						FROM catalogues_clients_dirs
						WHERE id_catalogue_client_dir = '".$id_catalogue_client_dir."' ";
	$resultat = $bdd->query ($query);
	while ($var = $resultat->fetchObject()) { 
		$this->catalogue_client_dirs_parents[] = $var; 
		$this->return_catalogue_client_dirs_parents ($var->id_catalogue_dir_parent);

	}
	
	return $this->catalogue_client_dirs_parents;
	
}

//fonction qui renvois la liste des catalogue_client_dir enfant 
function charger_catalogue_client_dirs_childs ( $id_catalogue_dir_parent = "") {
	global $bdd;

	$catalogue_tmp = array();
	$query = "SELECT id_catalogue_client_dir, lib_catalogue_client_dir, id_catalogue_dir_parent, id_catalogue_client, ref_art_categ
						FROM catalogues_clients_dirs
						WHERE id_catalogue_client = '".$this->id_catalogue_client."' && id_catalogue_dir_parent = '".$id_catalogue_dir_parent."' 
						ORDER BY lib_catalogue_client_dir ASC";
	$resultat = $bdd->query ($query);
	while ($var = $resultat->fetchObject()) { $catalogue_tmp[] = $var; }
	$this->catalogue_client_dirs_childs = $catalogue_tmp;
	
	return $this->catalogue_client_dirs_childs;
}



// *************************************************************************************************************
// FONCTIONS DE CHARGEMENT DES DONNEES 
// *************************************************************************************************************
//Chargement de la liste des catalogues clients
static function charger_liste_catalogues_clients () {
	global $bdd;

	$catalogues_clients = array();
	// Sélection des informations générales
	$query = "SELECT id_catalogue_client, lib_catalogue_client
						FROM catalogues_clients ";
	$resultat = $bdd->query ($query);
	while ($var = $resultat->fetchObject()) { $catalogues_clients[] = $var; }

	return $catalogues_clients;
}

//retourne un tableau d'objets des catalogues contenant la categorie passée en paramètre
static function &getListe_catalogue_client($ref_art_categ){
	global $bdd;

	$catalogues_clients = array();
	// Sélection des informations générales
	$query = "SELECT id_catalogue_client
						FROM catalogues_clients_dirs
						WHERE ref_art_categ = '".$ref_art_categ."'";
	$resultat = $bdd->query ($query);
	while ($var = $resultat->fetchObject()) { $catalogues_clients[] = new catalogue_client($var->id_catalogue_client); }

	return $catalogues_clients;
}



//Chargement de la liste des catalogues_clients_dir 
static function charger_liste_catalogues_clients_dir () {
	global $bdd;

	$catalogue_client_dir = array();
	$query = "SELECT id_catalogue_client , ref_art_categ
						FROM catalogues_clients_dirs";
	$resultat = $bdd->query ($query);
	while ($var = $resultat->fetchObject()) {
		if (!isset($catalogue_client_dir[$var->id_catalogue_client])) {
			$catalogue_client_dir[$var->id_catalogue_client] = array();
		}
		array_push($catalogue_client_dir[$var->id_catalogue_client], $var->ref_art_categ); 
	}
	
	return $catalogue_client_dir;
}

//Chargement des informations d'une catégorie d'un catalogue client
static function charger_catalogue_client_dir ($id_catalogue_client_dir) {
	global $bdd;

	$catalogue_client_dir = array();
	$query = "SELECT id_catalogue_client_dir, lib_catalogue_client_dir, id_catalogue_dir_parent, id_catalogue_client, ref_art_categ
						FROM catalogues_clients_dirs
						WHERE id_catalogue_client_dir = '".$id_catalogue_client_dir."' ";
	$resultat = $bdd->query ($query);
	while ($var = $resultat->fetchObject()) { $catalogue_client_dir = $var; }

	return $catalogue_client_dir;
	
}

// *************************************************************************************************************
// FONCTIONS DE LECTURE DES DONNEES 
// *************************************************************************************************************
function getId_catalogue_client () {
	return $this->id_catalogue_client;
}

function getLib_catalogue_client () {
	return $this->lib_catalogue_client;
}

}
// fin de class

// Renvoie un tableau des catégories d'articles disponibles
function get_catalogue_client_dirs ($id_catalogue_client, $id_cle_ignored = "") {
	global $bdd;

	$catalogue_tmp = array();
	$query = "SELECT id_catalogue_client_dir, lib_catalogue_client_dir, id_catalogue_dir_parent, id_catalogue_client, ref_art_categ
						FROM catalogues_clients_dirs
						WHERE id_catalogue_client = '".$id_catalogue_client."' 
						ORDER BY lib_catalogue_client_dir ASC";
	$resultat = $bdd->query ($query);
	while ($var = $resultat->fetchObject()) { $catalogue_tmp[] = $var; }

	$catalogues_clients_dir = order_by_parent ($catalogues_clients_dir, $catalogue_tmp, "id_catalogue_client_dir", "id_catalogue_dir_parent", "", $id_cle_ignored);

	return $catalogues_clients_dir;
}


function get_idCatalogueClientDir_of_ref_art_categ($ref_art_categ, $id_catalogue_client){
	global $bdd;

	$query = "SELECT 	id_catalogue_client_dir
						FROM 		catalogues_clients_dirs
						WHERE ref_art_categ				= '".$ref_art_categ."'
						&&		id_catalogue_client	= '".$id_catalogue_client."' ";

	$resultat = $bdd->query ($query);
	if($catalogue_client_dir = $resultat->fetchObject())
		return $catalogue_client_dir->id_catalogue_client_dir;
	else
		return false;
}
?>
