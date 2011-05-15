<?php
// *************************************************************************************************************
// Ajout d'un évènement
// *************************************************************************************************************

require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");

//traitement des données transmises



$id_vehicule = "";
$lib_evenement = "";
$date_debut="";
$date_fin = "";
$cout = "";
$ecart = "";

	$id_vehicule = $_REQUEST['id_vehicule'];
	if(isset($_REQUEST['libelle'])){
	$lib_evenement = addslashes(urlencode($_REQUEST['libelle']));
	}
	if(isset($_REQUEST['date_debut'])){
	$date_debut = $_REQUEST['date_debut'];
	}
	if(isset($_REQUEST['date_fin'])){
	$date_fin = $_REQUEST['date_fin'];
	}
	if(isset($_REQUEST['cout'])){
	$cout = $_REQUEST['cout'];
	}
	if(isset($_REQUEST['ecart'])){
		$ecart = $_REQUEST['ecart'];
	}

// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_smenu_gestion_vehicules_histo_recherche.inc.php");
?>