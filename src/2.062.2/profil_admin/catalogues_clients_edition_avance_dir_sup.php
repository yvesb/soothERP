<?php
// *************************************************************************************************************
// SUPPRESSION D'UNE CATEGORIE D'UN CATALOGUE CLIENT
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");


if (isset($_REQUEST['id_catalogue_client'])) {	
	// *************************************************
	// Controle des données fournies par le formulaire

	
	$id_catalogue_client_dir		= $_REQUEST['id_catalogue_client_dir'];
	$new_id_catalogue_dir_parent		=	$_REQUEST['id_catalogue_dir_parent'];

	
	// *************************************************
	// Création de la catégorie
	$catalogue_client = new catalogue_client ($_REQUEST['id_catalogue_client']);
	$catalogue_client->suppression_catalogue_client_dir ($id_catalogue_client_dir, $new_id_catalogue_dir_parent);
}

// *************************************************************************************************************
// AFFICHAGE
// -*************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_catalogues_clients_edition_avance_dir_sup.inc.php");

?>