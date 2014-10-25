<?php
// *************************************************************************************************************
// SUPPRESSION D'UN SERVEUR D'IMPORT
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");


$import_serveur = new import_serveur ($_REQUEST["ref_serveur"]);

$url = $import_serveur->getUrl_serveur_import ();

$import_serveur->suppression ();

// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_serveur_import_sup.inc.php");

?>