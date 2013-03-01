<?php
// *************************************************************************************************************
// Modes de livraisons
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");


$id_livraison_mode = $_REQUEST["id_livraison_mode"];

$livraison_mode = new livraison_modes($id_livraison_mode);
$livraison_costs = $livraison_mode->charger_livraisons_modes_cost();

// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_livraison_modes_cost.inc.php");

?>