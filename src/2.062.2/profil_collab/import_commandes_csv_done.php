<?php 

require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");

$import_commandes = new import_commandes_csv();

if (!empty($_FILES["fichier_csv"]["name"]) && substr_count($_FILES["fichier_csv"]["name"], ".csv")) {
	echo 'a';
	$import_commandes->parser_fichier($_FILES['fichier_csv']['tmp_name']);
	echo 'b';
}

// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************
include ($DIR.$_SESSION['theme']->getDir_theme()."/page_import_commandes_csv_done.inc.php");



?>