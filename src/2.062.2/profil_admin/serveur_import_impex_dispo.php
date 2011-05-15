<?php
// *************************************************************************************************************
// LISTE DES TYPES D'IMPORT MIS A DISPOSITION
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");

$export_serveur = new export_serveur ();
$liste_export_types = $export_serveur->getExport_types ();

$liste_import_dispo = explode(";", $_REQUEST["impex"]);

// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_serveur_import_impex_dispo.inc.php");

?>