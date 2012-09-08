<?php
// *************************************************************************************************************
// Modification des véhicules
// *************************************************************************************************************

require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");

//mise à jour des données transmises
if(isset($_REQUEST['id_vehicule'])){
	$lib_vehicule = $_REQUEST['lib_vehicule_'.$_REQUEST['id_vehicule']];
	$marque = $_REQUEST['marque_'.$_REQUEST['id_vehicule']];
	$attribution = $_REQUEST['attribution_'.$_REQUEST['id_vehicule']];

	maj_vehicules($_REQUEST['id_vehicule'], $lib_vehicule, $marque, $attribution);
}


// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_smenu_gestion_vehicules_maj.inc.php");
?>