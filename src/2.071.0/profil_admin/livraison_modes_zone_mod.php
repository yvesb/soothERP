<?php
// *************************************************************************************************************
// Ajout de zone de livraisons
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");


$id_livraison_mode 	= $_REQUEST["id_livraison_mode"];
$id_livraison_zone 	= $_REQUEST["id_livraison_zone"];
$liste_cp 					= $_REQUEST["zone_liste_cp_".$id_livraison_zone."_".$id_livraison_mode];
$id_pays 						= $_REQUEST["zone_id_pays_".$id_livraison_zone."_".$id_livraison_mode];

$livraison_mode = new livraison_modes($id_livraison_mode);
$livraison_mode->modifier_zone($id_livraison_zone, $liste_cp, $id_pays);


// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_livraison_modes_zone_add.inc.php");

?>