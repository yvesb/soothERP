<?php
// *************************************************************************************************************
// Formulaire d'ajout d'un évènement pour un véhicule
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");

$id_vehicule = $_REQUEST['id_vehicule'];
global $bdd;

$query = "SELECT * FROM mod_vehicules WHERE id_vehicule = '".$id_vehicule."' ORDER BY lib_vehicule ASC";
$resultat = $bdd->query ($query);
$vehicule = $resultat->fetchObject();
// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_smenu_gestion_vehicules_ajout_evenement.inc.php");

?>