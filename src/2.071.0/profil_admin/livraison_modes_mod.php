<?php
// *************************************************************************************************************
// Ajout de Modes de livraisons
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");


$id_livraison_mode = $_REQUEST["id_livraison_mode"];
$lib_livraison_mode = $_REQUEST["lib_livraison_mode_".$id_livraison_mode];
$abrev_livraison_mode = $_REQUEST["abrev_livraison_mode_".$id_livraison_mode];
$ref_transporteur = $_REQUEST["ref_transporteur_".$id_livraison_mode];

$livraison_mode = new livraison_modes($id_livraison_mode);
$livraison_mode->modifier($lib_livraison_mode, $abrev_livraison_mode, $ref_transporteur);


// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_livraison_modes_mod.inc.php");

?>