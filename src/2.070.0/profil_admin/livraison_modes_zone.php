<?php
// *************************************************************************************************************
// Modes de livraisons
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");


$listepays = getPays_select_list ();

$id_livraison_mode = $_REQUEST["id_livraison_mode"];

$livraison_mode = new livraison_modes($id_livraison_mode);
$livraison_zones = $livraison_mode->charger_livraisons_modes_zone();

// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_livraison_modes_zone.inc.php");

?>