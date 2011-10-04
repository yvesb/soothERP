<?php
// *************************************************************************************************************
// ACCUEIL DE L'UTILISATEUR ADMINISTRATEUR
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");


if (isset($_REQUEST['ajout_stock'])) {	
	// *************************************************
	// Controle des données fournies par le formulaire

	
	$lib_stock						= $_REQUEST['lib_stock'];
	$abrev_stock						= $_REQUEST['abrev_stock'];
	$ref_adr_stock 					= $_REQUEST['ref_adr_stock'];
	if (isset($_REQUEST['actif'])) {
	$actif						= 1;
	} else {
	$actif						= 0;
	}

	
	// *************************************************
	// Création de la catégorie
	$stock_liste = new stock ();
	$stock_liste->create ($lib_stock, $abrev_stock, $ref_adr_stock, $actif);
}

// *************************************************************************************************************
// AFFICHAGE
// -*************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_catalogue_stockage_add.inc.php");

?>