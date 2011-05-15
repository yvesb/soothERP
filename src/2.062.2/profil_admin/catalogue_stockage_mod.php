<?php
// *************************************************************************************************************
// ACCUEIL DE L'UTILISATEUR ADMINISTRATEUR
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");


if (isset($_REQUEST['id_stock'])) {	
	// *************************************************
	// Controle des données fournies par le formulaire

	
	$lib_stock						= $_REQUEST['lib_stock_'.$_REQUEST['id_stock']];
	$abrev_stock						= $_REQUEST['abrev_stock_'.$_REQUEST['id_stock']];
	$ref_adr_stock 					= $_REQUEST['ref_adr_stock_'.$_REQUEST['id_stock']];
	if (isset($_REQUEST['actif_'.$_REQUEST['id_stock']])) {
	$actif						= 1;
	} else {
	$actif						= 0;
	}

	
	// *************************************************
	// Création de la catégorie
	$stock_liste = new stock ($_REQUEST['id_stock']);
	$stock_liste->modification ($lib_stock, $abrev_stock, $ref_adr_stock, $actif);
}

// *************************************************************************************************************
// AFFICHAGE
// -*************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_catalogue_stockage_mod.inc.php");

?>