<?php
//  ******************************************************
// Suppression des types de pièces jointes
//  ******************************************************

require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");

//mise à jour des données transmises
if(isset($_REQUEST['id_piece_type'])){
	del_types_ged($_REQUEST['id_piece_type']);
}


//  ******************************************************
// AFFICHAGE
//  ******************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_configuration_entreprise_ged_del.inc.php");
?>