<?php
// *************************************************************************************************************
// Suppression d'un véhicule
// *************************************************************************************************************

require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");

//mise à jour des données transmises
if(isset($_REQUEST['id_vehicule'])){
	del_vehicule($_REQUEST['id_vehicule']);
}


// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_smenu_gestion_vehicules_del.inc.php");
?>