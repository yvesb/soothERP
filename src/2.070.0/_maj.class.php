<?php
// *************************************************************************************************************
// CLASSE DE GESTION DES MISES A JOUR SYSTEME 
// *************************************************************************************************************


class maj_serveur {
	var $version_before_maj;
	var $version_after_maj;

	var $ftp_id_connect;					// Identifiant de la connexion FTP
	var $tmp_files_dir;						// Dossier local temporaire de téléchargement des fichiers de mise à jour
	var $ftp_files_dir;						// Dossier FTP de téléchargement des fichiers de mise à jour

	var $xml_liste_fichiers;			// fichier xml distant listant les fichiers à downloader
	var $install_files;						// liste des fichiers à télécharger
	var $install_dirs;						// liste des dossiers à télécharger
	var $install_infos;						// liste des infos de téléchargement
	var $derniereBaliseRencontree;
	var $download_infos_file;			//fichier de progression de la maj
	
	var $parseurXML;
	
	var $do_not_synchro_dirs;			// Tableau des dossiers qui ne peuvent etre synchronisés

	var $break_point_file;				// Nom du fichier contenant les Break Points
	var $last_break_point;				// Dernier Break Point encas de restauration d'une MAJ


function __construct ($version_after_maj) {
	global $_SERVER; 
	global $CONFIG_DIR;
	global $DIR;
	global $MAJ_SERVEUR;

	// Informations sur la mise à jour
	$this->version_before_maj = $_SERVER['VERSION'];
	$this->version_after_maj 	= $version_after_maj; // Conversion en nombre

	$texte = "<b>MISE A JOUR DE LMB v".$this->version_before_maj." vers v".$this->version_after_maj."</b>";
	$GLOBALS['_INFOS']['maj_actions'][] = $texte;

	// Initialisation des variables
	$this->tmp_files_dir = $DIR."echange_lmb/maj_lmb_".$this->version_after_maj."/";
	$this->ftp_files_dir = $MAJ_SERVEUR['ftp_racine']."maj-v".$this->version_after_maj."/";
	$this->xml_liste_fichiers = "lmb_liste_fichiers.xml";
	$this->install_files = array();
	$this->install_dirs = array();
	$this->install_infos = array();
	$this->derniereBaliseRencontree = "";
	$this->download_infos_file = "lmb_download_state.tmp";
	$this->do_not_synchro_dirs = array(); //($CONFIG_DIR);

	// Recherche d'un éventuel Break Point (Afin de ne pas répéter une étape de la mise à jour)
	$this->last_break_point = 0;
	$this->break_point_file = $DIR."echange_lmb/v".$this->version_after_maj."_break_points.tmp";

	if (is_file($this->break_point_file)) {
		$break_points = file ($this->break_point_file);
		$this->last_break_point = $break_points [count($break_points)-1] * 1;
		$GLOBALS['_INFOS']['maj_actions'][] = "<i>Récupération de la mise à jour au point n°".$this->last_break_point."</i>";
	}

	return true;
}



// *************************************************************************************************************
// Fonction de gestion des étapes de mise à jour
// *************************************************************************************************************
// Permet de gérer une erreur lors de la mise à jour, afin de reprendre à cette étape lors d'une tentative ultérieure
function set_break_point($i) {
	$GLOBALS['_INFOS']['maj_actions'][] = "<b>Point de restauration n° ".$i." créé</b>";
	$file_id = fopen ($this->break_point_file, "a");
	fwrite ($file_id, $i."\n");
	fclose ($file_id);
	$this->last_break_point = $i;
}


function unset_break_point() {
	unlink ($this->break_point_file);
}

// *************************************************************************************************************
// Téléchargement des fichiers nécessaires à la mise à jour
// *************************************************************************************************************
function get_maj_files ($all) {
	global $DIR;
	global $MAJ_SERVEUR;
	$MS = &$MAJ_SERVEUR;

	// *************************************************
	// Mise en place d'une connexion FTP basique
	$GLOBALS['_INFOS']['maj_actions'][] = "Connexion au serveur FTP";
	$this->ftp_id_connect = ftp_connect($MS['ftp_server']); 
	$login_result = ftp_login($this->ftp_id_connect, $MS['ftp_user'], $MS['ftp_pass']);

	// Vérification de la connexion
	if ((!$this->ftp_id_connect) || (!$login_result)) {
		$error = "La connexion FTP a échoué : ".$MS['ftp_server']." / ".$MS['ftp_user'].""; 
		alerte_dev ($error);
		exit; 
	}
	ftp_pasv($this->ftp_id_connect, true);
	// Téléchargement du script de mise à jour (dossier complet)
	$GLOBALS['_INFOS']['maj_actions'][] = "<b>Téléchargement des fichiers de mise à jour</b>";
	$this->ftp_download_dir ();

	// Fermeture du flux FTP
	ftp_close($this->ftp_id_connect); 
}


// *************************************************************************************************************
// Fonctions FTP
// *************************************************************************************************************
// Upload un répertoire complet
function ftp_download_dir () {

	if (!is_dir($this->tmp_files_dir)) { mkdir($this->tmp_files_dir);}
	//fichier de progression
	$this->make_download_state (1, "Mise &agrave; jour vers version ".$this->version_after_maj." en cours", "T&eacute;l&eacute;chargement des fichiers", "" );
	
	//chargement du fichier xml listant les fichiers et dossier à télécharger
	set_time_limit(300);
	ftp_get ($this->ftp_id_connect, $this->tmp_files_dir.$this->xml_liste_fichiers, $this->ftp_files_dir.$this->xml_liste_fichiers, FTP_BINARY);

	//chargement du fichier de maj
	ftp_get ($this->ftp_id_connect, $this->tmp_files_dir."maj.php", $this->ftp_files_dir."maj.php", FTP_BINARY);
	
	//lecture du fichier
	$this->read_xml_file();
	
	$downloaded = 0;
	$total_size = $this->install_infos[0]['TOTAL_SIZE'];
	
	// Création de l'arborescence des répertoires
	if (!is_dir($this->tmp_files_dir."files/")) { mkdir($this->tmp_files_dir."files/");}
	$dir_list = $this->install_dirs;
	foreach ($dir_list as $dir) {
		if (!is_dir($this->tmp_files_dir."files/".$dir['SRC'])) {@mkdir ($this->tmp_files_dir."files/".$dir['SRC']);}
		$GLOBALS['_INFOS']['maj_actions'][] = "<b>Dossier</b> : ".$this->tmp_files_dir."files/".$dir['SRC']."<br>";
	}
	
	// Téléchargement des fichiers 1 à 1
	$files_list = $this->install_files;
	foreach ($files_list as $file) {
		set_time_limit(300);

		// Téléchargement du fichier
		ftp_get ($this->ftp_id_connect, $this->tmp_files_dir."files/".$file['SRC'], $this->ftp_files_dir."files/".$file['SRC'], FTP_BINARY);
		$GLOBALS['_INFOS']['maj_actions'][] = "<b>FICHIER</b> : ".$this->tmp_files_dir."files/".$file['SRC']."<br>";
		
		// Inscription des informations sur l'état du téléchargement
		$downloaded 	+= filesize ($this->tmp_files_dir."files/".$file['SRC']);
		$percent = number_format(((90 * $downloaded)/$total_size), 0);
		
		$this->make_download_state ($percent, "Mise &agrave; jour vers version ".$this->version_after_maj." en cours", "T&eacute;l&eacute;chargement des fichiers", "T&eacute;l&eacute;chargement : ".number_format($downloaded/1048576,2)." MB sur ".number_format($total_size/1048576,2)." MB");
	}
	//Fin du téléchargement des fichiers
	
	//Vérification au moins une fois du bon téléchargement des fichiers
	foreach ($files_list as $file) {
		set_time_limit(300);
		//le fichier
		if (!file_exists ($this->tmp_files_dir."files/".$file['SRC'])) {
			// Téléchargement du fichier
			ftp_get ($this->ftp_id_connect, $this->tmp_files_dir."files/".$file['SRC'], $this->ftp_files_dir."files/".$file['SRC'], FTP_BINARY);
		}
	}
	
	//relance de la vérification
	$liste_missing_files = array();
	foreach ($files_list as $file) {
		set_time_limit(300);
		//le fichier
		if (!file_exists ($this->tmp_files_dir."files/".$file['SRC'])) {
			$liste_missing_files[] = $file['SRC'];
		}
	}
	if (count($liste_missing_files)) {
		$this->make_download_state (1, "Mise &agrave; jour interrompue ! ", "Des fichiers sont manquants ", "Actualisez la page de mise &agrave; jour pour r&eacute;essayer " );
		exit;
	}
	
}




// Vérification des fichiers présents pour une mise à jour manuel
function check_files () {

	if (!is_dir($this->tmp_files_dir)) { mkdir($this->tmp_files_dir);}
	//fichier de progression
	$this->make_download_state (1, "Mise &agrave; jour vers version ".$this->version_after_maj." en cours", "V&eacute;rification des fichiers", "" );
	
	//chargement du fichier xml listant les fichiers et dossier à télécharger
	set_time_limit(300);
	//lecture du fichier
	$this->read_xml_file();
	// Création de l'arborescence des répertoires
	if (!is_dir($this->tmp_files_dir."files/")) { mkdir($this->tmp_files_dir."files/");}
	
	// vérification des fichiers 1 à 1
	$files_list = $this->install_files;
	//relance de la vérification
	$liste_missing_files = array();
	foreach ($files_list as $file) {
		set_time_limit(300);
		//le fichier
		if (!file_exists ($this->tmp_files_dir."files/".$file['SRC'])) {
			$liste_missing_files[] = $file['SRC'];
		}
	}
	if (count($liste_missing_files)) {
		$this->make_download_state (1, "Mise &agrave; jour interrompue ! ", "Des fichiers sont manquants ", "Veuillez v&eacute;rifier que l'ensemble des fichiers &agrave; installer sont pr&eacute;sent dans le dossier echange_lmb/maj_lmb_".$this->version_after_maj."/files/ " );
		exit;
	}
	
}


// Lit le fichier d'information sur le code source.
function read_xml_file () {
	
	// Création du parseur XML
	$this->parseurXML = xml_parser_create("ISO-8859-1");

	//This is the RIGHT WAY to set everything inside the object.
	xml_set_object ( $this->parseurXML, $this );
	
	// Nom des fonctions à appeler lorsque des balises ouvrantes ou fermantes sont rencontrées
	xml_set_element_handler($this->parseurXML, "opentag" , "closetag");

	// Nom de la fonction à appeler lorsque du texte est rencontré
	xml_set_character_data_handler($this->parseurXML, "texttag");

	// Ouverture du fichier
	$fp = fopen($this->tmp_files_dir.$this->xml_liste_fichiers, "r");
	if (!$fp) alerte_dev ("Impossible d'ouvrir le fichier XML");

	// Lecture ligne par ligne
	while ( $ligneXML = fgets($fp, 1024)) {
		// Analyse de la ligne
		// REM: feof($fp) retourne TRUE s'il s'agit de la dernière ligne du fichier.
		xml_parse($this->parseurXML, $ligneXML, feof($fp)) or alerte_dev("Fichier incorrect sur LM.fr");
	}

	xml_parser_free($this->parseurXML);
	fclose($fp);

	return true;
}

// Fontion de lecture des balises ouvrantes
function opentag($parseur, $nomBalise, $tableauAttributs) {
	//$this->$derniereBaliseRencontree = $nomBalise;

	switch ($nomBalise) {
			case "DIR": 
					$this->install_dirs[] = $tableauAttributs;
					break;
			case "FILE": 
					$this->install_files[] = $tableauAttributs;
					break;
			case "INSTALL": 
					$this->install_infos[] = $tableauAttributs;
					break;
	} 
}

// Fonction de traitement des balises fermantes
function closetag($parseur, $nomBalise) {
	//$this->derniereBaliseRencontree = "";
}

//Fonction de traitement du texte
// qui est appelée par le "parseur" (non utilisée car pas de texte entre les balises)
function texttag($parseur, $texte)
{
}

// *********************************************************************************************************
// Fonctions de création du fichier d'état de téléchargement
// *********************************************************************************************************
public function make_download_state($percent, $majetat, $majinfos, $majinfos_more) {
	/******************************
	* Structure du fichier :
	avancement de la maj (en %)
	texte appliqué pour indiqué l'état de la maj
	texte indiquant le type de maj en cours
	texte complémentaire
	*/
	$entete_download_state  = $percent."\n";			// pourcentage de la maj
	$entete_download_state .= $majetat."\n";			// majetat (texte)
	$entete_download_state .= $majinfos."\n";	// type de maj en cours
	$entete_download_state .= $majinfos_more."\n";				// infos complémentaires
	
	if (is_dir($this->tmp_files_dir)) {
	$infos_file = fopen ($this->tmp_files_dir.$this->download_infos_file, "w");
	fwrite ($infos_file, $entete_download_state);
	fclose($infos_file);
	}
	
	return true;
}





// Vide le répertoire temporaire FTP
function flush_tmp_files() {
	$GLOBALS['_INFOS']['maj_actions'][] = "Suppression des fichiers de mise à jour";
	$this->rmdir ($this->tmp_files_dir);
}


function rmdir ($dir) {
	$files = scandir($dir);
	if (count($files) == 2) {
		rmdir($dir);
		return true;
	}
	
	for ($i=2; $i<count($files); $i++) {
		if (is_dir ($dir."/".$files[$i])) { 
			$this->rmdir($dir.$files[$i]."/");
		}
		else {
			unlink ($dir.$files[$i]); 
		}
	}
	rmdir($dir);
	return true;
}

function rmfile ($file) {
  unlink ($file); 
}

function create_config_file () {
	global $CONFIG_DIR;
	//@TODO
}

function delete_depreciated_file () {
	//@TODO
}

// Synchronise les fichiers généraux de LMB avec la mise à jour téléchargée
function synchronise_files () {
	global $DIR;

	$GLOBALS['_INFOS']['maj_actions'][] = "Synchronisation des fichiers recus";

	// Les fichiers sont dans le répertoire files/ du répertoire temporaire
	$source_dir = $this->tmp_files_dir."files/";
	// Ces fichiers vont etre déplacés à la racine
	$dest_dir = $DIR;

	if (!is_dir($source_dir)) {
		$GLOBALS['_INFOS']['maj_actions'][count($GLOBALS['_INFOS']['maj_actions'])-1] = " <i>( Aucun fichier à synchroniser )</i>";
		return false; 
	}

	$this->synchronise_dir($source_dir, $dest_dir);
	return true;
}


// Effectue une copie exacte d'un dossier vers un autre
function synchronise_dir ($source_dir, $dest_dir) {
	$files = scandir($source_dir);

	// Boucle sur les fichiers 
	for ($i=2; $i<count($files); $i++) {
		if (!is_file($source_dir.$files[$i])) { continue; }

		$old_name = $source_dir.$files[$i];
		$new_name = $dest_dir.$files[$i];
		copy ($old_name, $new_name);
	}

	// Boucle sur les dossiers 
	for ($i=2; $i<count($files); $i++) {
		if (!is_dir($source_dir.$files[$i])) { continue; }

		$new_source_dir = $source_dir.$files[$i]."/";
		$new_dest_dir 	= $dest_dir.$files[$i]."/";

		// Protection spéciale pour les dossiers qui ne sont jamais synchronisés
		if (in_array($new_dest_dir, $this->do_not_synchro_dirs)) { continue; }

		// Si il n'existe pas on le créé
		if (!is_dir($new_dest_dir)) { mkdir ($new_dest_dir); }

		//Synchronisation des sous dossiers
		$this->synchronise_dir($new_source_dir, $new_dest_dir);
	}
}




// *************************************************************************************************************
// Actions sur la base de données
// *************************************************************************************************************
function exec_sql ($query) {
	global $bdd;
	$bdd->exec ($query);

	$GLOBALS['_INFOS']['maj_actions'][] = "Requete effectuée : <br>".nl2br($query);
}




// *************************************************************************************************************
// Mise à jour d'un fichier de configuration
// *************************************************************************************************************
//fonction maj_configuration_file déplacée et modifiée dans divers.lib.php




// *************************************************************************************************************
// ACTIONS PREDETERMINEES SUR LE SERVEUR (Démarrage, Arret)
// *************************************************************************************************************
// Ferme le serveur pour effectuer la mise à jour tranquillement.
public function stop_serveur () {
	global $CONFIG_DIR;
	maj_configuration_file ("config_serveur.inc.php", "maj_line", "\$_SERVER['ACTIF'] =", "\$_SERVER['ACTIF'] = 0;", $CONFIG_DIR);
	$GLOBALS['_INFOS']['maj_actions'][] = "Arret du serveur";
}

// Réouvre le serveur pour effectuer la mise à jour tranquillement.
public function start_serveur () {
	global $CONFIG_DIR;
	maj_configuration_file ("config_serveur.inc.php", "maj_line", "\$_SERVER['ACTIF'] =", "\$_SERVER['ACTIF'] = 1;", $CONFIG_DIR);
	$GLOBALS['_INFOS']['maj_actions'][] = "Démarrage du serveur";
}

// Inscrit la nouvelle version du serveur dans le fichier de configuration adequat
public function maj_version () {
	global $CONFIG_DIR;

	$line = "\$_SERVER['VERSION'] = '".$this->version_after_maj."';";
	maj_configuration_file ("config_serveur.inc.php", "maj_line", "\$_SERVER['VERSION'] =", $line, $CONFIG_DIR);
	$GLOBALS['_INFOS']['maj_actions'][] = "Démarrage du serveur";
}


public function show_maj_procedure () {
	foreach ($GLOBALS['_INFOS']['maj_actions'] as $action) {
		echo "<li>".$action."</li>";
	}
}



}

?>