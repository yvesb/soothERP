<?php
// *************************************************************************************************************
// ACCUEIL DE L'UTILISATEUR ADMINISTRATEUR
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");


if (isset($_REQUEST['ref_art_categ'])) {	
	// *************************************************
	// Controle des données fournies par le formulaire

	
	$lib_carac	= $_REQUEST['lib_carac'];
	$unite	= $_REQUEST['unite'];
	$allowed_values	= "";
	if (isset($_REQUEST['allowed_values'])) {$allowed_values	= $_REQUEST['allowed_values'];}
	$default_value	= $_REQUEST['default_value'];
	$moteur_recherche	= $_REQUEST['moteur_recherche'];
	if (isset($_REQUEST['variante'])) {
		$variante	= 1;
	}else{
		$variante	= 0;
	}
	$affichage	= $_REQUEST['affichage'];
	$ref_carac_groupe	= $_REQUEST['ref_carac_groupe'];
	
	
	
	// *************************************************
	// Création de la catégorie
	$art_categ = new art_categ ($_REQUEST['ref_art_categ']);
	$art_categ->create_carac ($lib_carac, $unite, $allowed_values, $default_value, $moteur_recherche, $variante, $affichage, $ref_carac_groupe);
}

// *************************************************************************************************************
// AFFICHAGE
// -*************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_catalogue_categorie_caract_add.inc.php");

?>