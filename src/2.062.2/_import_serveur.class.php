<?php
// *************************************************************************************************************
// CLASSE REGISSANT LES IMPORTS DEPUIS D'AUTRES SERVEURS
// *************************************************************************************************************


final class import_serveur {
	private $ref_serveur_import;			// Serveur d'import
	private $lib_serveur_import;			// Libellé du serveur d'import
	private $url_serveur_import;			// URL du serveur d'import
	
	private $import_serveurs;	//liste des serveurs d'import
	private $import_serveurs_loaded;
	
	private $import_export_types;	//liste des types d'exports
	private $import_export_types_loaded;

function __construct($ref_serveur_import = "") {
	global $bdd;

	// Controle si la ref_art_categ est précisée
	if (!$ref_serveur_import) { return false; }

	// Sélection des informations générales
	$query = "SELECT ref_serveur_import, lib_serveur_import, url_serveur_import
						FROM import_serveurs 
						WHERE ref_serveur_import = '".$ref_serveur_import."' ";
	$resultat = $bdd->query ($query);

	// Controle si la ref_serveur est trouvée
	if (!$import_serveur = $resultat->fetchObject()) { return false; }

	// Attribution des informations à l'objet
	$this->ref_serveur_import 	= $ref_serveur_import;
	$this->lib_serveur_import		= $import_serveur->lib_serveur_import;
	$this->url_serveur_import		= $import_serveur->url_serveur_import;

	return true;
}



// *************************************************************************************************************
// FONCTIONS LIEES A L'AJOUT D'UN SERVEUR D'IMPORT
// *************************************************************************************************************

final public function create ($ref_serveur_import, $lib_serveur_import, $url_serveur_import) {
	global $DEFAUT_ID_TVA;
	global $bdd;

	// *************************************************
	// Controle des données transmises
	$this->ref_serveur_import	= $ref_serveur_import;
	$this->lib_serveur_import	= $lib_serveur_import;
	$this->url_serveur_import	= $url_serveur_import;

	// *************************************************
	// Controle de l'existance d'un serveur d'import ayant la même ref_serveur
	$query = "SELECT ref_serveur_import FROM import_serveurs
						WHERE ref_serveur_import = '".$this->ref_serveur_import."' || url_serveur_import ='".$this->url_serveur_import."'  LIMIT 0,1";
	$resultat = $bdd->query ($query);
	if ($serveur_exist = $resultat->fetchObject()) { 
		$GLOBALS['_ALERTES']['serveur_existants'] = 1;
	}
	
	// *************************************************
	// Si les valeurs reçues sont incorrectes
	if (count($GLOBALS['_ALERTES'])) {
		return false;
	}

	// *************************************************
	// Insertion dans la base
	$query = "INSERT INTO import_serveurs (ref_serveur_import, lib_serveur_import, url_serveur_import)
						VALUES ('".$this->ref_serveur_import."', '".addslashes($this->lib_serveur_import)."', 
										'".$this->url_serveur_import."' ) ";
	$bdd->exec ($query);

	
	// *************************************************
	// Résultat positif de la création
	$GLOBALS['_INFOS']['Création_import_serveur'] = $this->ref_serveur_import;

	return true;
}


// *************************************************************************************************************
// FONCTIONS LIEES A LA MODIFICATION D'UN SERVEUR D'IMPORT
// *************************************************************************************************************

final public function modification ($ref_serveur_import, $lib_serveur_import, $url_serveur_import) {
	global $bdd;
	
	// *************************************************
	// Controle des données transmises
	
	$this->lib_serveur_import		= $lib_serveur_import;
	$this->url_serveur_import		= $url_serveur_import;

	// *************************************************
	// Controle de l'existance d'un serveur d'import ayant la même ref_serveur
	if ($ref_serveur_import != $this->ref_serveur_import) {
		$query = "SELECT ref_serveur_import FROM import_serveurs
							WHERE ref_serveur_import = '".$ref_serveur_import."' LIMIT 0,1";
		$resultat = $bdd->query ($query);
		if ($serveur_exist = $resultat->fetchObject()) { 
			$GLOBALS['_ALERTES']['serveur_existants'] = 1;
		}
	}


	// *************************************************
	// Si les valeurs reçues sont incorrectes
	if (count($GLOBALS['_ALERTES'])) {
		return false;
	}

	// *************************************************
	// Mise a jour de la base
	$query = "UPDATE import_serveurs 
						SET ref_serveur_import = '".$ref_serveur_import."', 
								lib_serveur_import = '".addslashes($this->lib_serveur_import)."', 
								url_serveur_import = '".addslashes($this->url_serveur_import)."'
						WHERE ref_serveur_import = '".$this->ref_serveur_import."' ";
	$bdd->exec ($query);
	
	$this->ref_serveur_import	= $ref_serveur_import;
	
	return true;
}



// *************************************************************************************************************
// FONCTIONS LIEES A LA SUPPRESSION D'UN SERVEUR D'IMPORT
// *************************************************************************************************************
final public function suppression () {
	global $bdd;

	// *************************************************
	// Si les valeurs reçues sont incorrectes
	if (count($GLOBALS['_ALERTES'])) {
		return false;
	}

	// *************************************************
	// Suppression du serveur d'import
	
	$bdd->beginTransaction();

	// Suppression du serveur d'import
	$query = "DELETE FROM import_serveurs 
						WHERE ref_serveur_import = '".$this->ref_serveur_import."' ";
	$bdd->exec ($query);
	
	$bdd->commit();

	unset ($this);
}

// *************************************************************************************************************
// FONCTIONS DE GESTION DE L'ABONNEMENT DU SERVEURS D'IMPORT
// *************************************************************************************************************

//fonction d'ajout d'un impex dispo du ref_serveur_import

final public function add_impex ($id_impex_type) {
	global $bdd;
	
	
	$query = "SELECT ref_serveur_import FROM import_types
						WHERE ref_serveur_import = '".$this->ref_serveur_import."' && id_impex_type ='".$id_impex_type."'  LIMIT 0,1";
	$resultat = $bdd->query ($query);
	if ($impex_exist = $resultat->fetchObject()) { 
		$GLOBALS['_ALERTES']['impex_existants'] = 1;
	}
	// *************************************************
	// Si les valeurs reçues sont incorrectes
	if (count($GLOBALS['_ALERTES'])) {
		return false;
	}
	
	$query = "INSERT INTO import_types ( ref_serveur_import, id_impex_type)
						VALUES ('".$this->ref_serveur_import."', '".$id_impex_type."') ";
	$bdd->exec ($query);
	return true;
}

//fonction de suppression d'un impex du ref_serveur_import
final public function del_impex ($id_impex_type) {
	global $bdd;

	$query = "DELETE FROM import_types
						WHERE ref_serveur_import = '".$this->ref_serveur_import."' && id_impex_type = '".$id_impex_type."' ";
	$bdd->exec ($query);
	return true;
}


// *************************************************************************************************************
// FONCTIONS DE CHARGEMENT DE LA LISTE DES SERVEURS D'IMPORT
// *************************************************************************************************************

// Charge les serveurs d'import
function charger_import_serveurs () {
	global $bdd;

	$this->import_serveurs = array();
	$query = "SELECT ref_serveur_import, lib_serveur_import, url_serveur_import
						FROM import_serveurs ";
	$resultat = $bdd->query ($query);
	
	while ($import_serveurs = $resultat->fetchObject()) {
	
		$import_serveurs->import_types = array();
		$query2 = "SELECT it.id_impex_type, iet.lib_impex_type, it.import_infos
							FROM import_types it
							LEFT JOIN import_export_types iet ON iet.id_impex_type = it.id_impex_type
							WHERE ref_serveur_import = '".$import_serveurs->ref_serveur_import."' ";
		$resultat2 = $bdd->query ($query2);
		
		while ($import_types = $resultat2->fetchObject()) {
		
			$import_serveurs->import_types[$import_types->id_impex_type] = $import_types; 
		
		}
		$this->import_serveurs[] = $import_serveurs; 
		
	}

	$this->import_serveurs_loaded = 1;
	
	return true;
}

// Charge l'import_infos du serveur
function charger_import_infos ($id_impex_type) {
	global $bdd;
	
	$query = "SELECT import_infos
						FROM import_types it
						WHERE ref_serveur_import = '".$this->ref_serveur_import."' && id_impex_type = '".$id_impex_type."' ";
	$resultat = $bdd->query ($query);
	if ($import_types = $resultat->fetchObject()) { return $import_types->import_infos; }

}

//mise à jour des import_infos
function maj_import_infos ($id_impex_type, $import_infos) {
	global $bdd;
	
	$query = "UPDATE import_types 
						SET import_infos = '".$import_infos."'
						WHERE ref_serveur_import = '".$this->ref_serveur_import."' && id_impex_type = '".$id_impex_type."' ";
	$bdd->exec ($query);

}


// Charge les types d'export
function charger_impex_types () {
	global $bdd;

	$this->import_export_types = array();
	$query = "SELECT id_impex_type, lib_impex_type 
						FROM import_export_types ";
	$resultat = $bdd->query ($query);
	while ($import_export_types = $resultat->fetchObject()) {$this->import_export_types[] = $import_export_types;}

	$this->import_export_types_loaded = 1;
	return true;
	
}
// *************************************************************************************************************
// FONCTIONS DE LECTURE DES DONNEES 
// *************************************************************************************************************
function getRef_serveur_import () {
	return $this->ref_serveur_import;
}

function getLib_serveur_import () {
	return $this->lib_serveur_import;
}

function getUrl_serveur_import () {
	return $this->url_serveur_import;
}

function getImport_serveurs () {
	if (!$this->import_serveurs_loaded) { $this->charger_import_serveurs(); }
	return $this->import_serveurs;
}

function getImpex_types () {
	if (!$this->import_export_types_loaded) { $this->charger_impex_types(); }
	return $this->import_export_types;
}
}

//fonction modifiée pour l'import
function import_order_by_parent (&$tab1, $tab2, $cle1, $cle2, $ref_cle_parent = "", $ref_cle_ignored = "") {
	static $tab1 = array();
	static $indentation = 0;

	
	for ($i=0; $i<count($tab2); $i++) {
		
		// Si la clé indiquant le parent n'est pas égale à ref_cle_parent, on passe a l'enregistrement suivant
		if ($tab2[$i][$cle2] != $ref_cle_parent ) { continue; }
		
		// Si l'enregistrement a déjà été inséré dans le tableau, on passe au suivant
		if (isset($tab1[$tab2[$i][$cle1]])) { continue; }
		
		// Si l'enregistrement ne doit pas etre enregistré: on saute
		if ($tab2[$i][$cle1] == $ref_cle_ignored) { continue; }

		// Ajout de l'enregistrement en cours au tableau 1
		$tab1[$tab2[$i][$cle1]] = $tab2[$i];
		$tab1[$tab2[$i][$cle1]]["indentation"] = $indentation;
		
		// Ajout des enfant de l'enregistrement en cours au tableau 1
		$indentation++;
		$tab1 = import_order_by_parent ($tab1, $tab2, $cle1, $cle2, $tab2[$i][$cle1], $ref_cle_ignored);
		$indentation--;
	
	}
	if (!$indentation) {
		for ($k=0; $k<count($tab2); $k++) {
			$has_parent = false;
			for ($j=0; $j<count($tab2); $j++) {
				if ($tab2[$j][$cle1] == $tab2[$k][$cle2]) { 
					$has_parent = true;
				}
			}
			if (!$has_parent ) {
				$tab1[$tab2[$k][$cle1]] = $tab2[$k];
				$tab1[$tab2[$k][$cle1]]["indentation"] = 0;
			}
		}
	}
	return $tab1;
}
?>