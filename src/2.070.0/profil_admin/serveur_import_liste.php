<?php
// *************************************************************************************************************
// LISTE DES SERVEURS D'IMPORT
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");

$import_serveur = new import_serveur ();
$liste_serveurs_import = $import_serveur->getImport_serveurs ();

$liste_import_types = $import_serveur->getImpex_types ();
// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_serveur_import_liste.inc.php");

?>