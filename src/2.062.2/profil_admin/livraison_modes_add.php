<?php
// *************************************************************************************************************
// Ajout de Modes de livraisons
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");


$lib_livraison_mode = $_REQUEST["lib_livraison_mode"];
$abrev_livraison_mode = $_REQUEST["abrev_livraison_mode"];
$ref_transporteur = $_REQUEST["ref_transporteur"];

$livraison_mode = new livraison_modes();
$livraison_mode->create($lib_livraison_mode, $abrev_livraison_mode, $ref_transporteur);


// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_livraison_modes_add.inc.php");

?>