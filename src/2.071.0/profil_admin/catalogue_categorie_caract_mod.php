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

	
	$ref_carac	= $_REQUEST['ref_carac'];
	$lib_carac	= $_REQUEST['lib_carac_'.$_REQUEST['ref_carac']];
	$unite	= $_REQUEST['unite_'.$_REQUEST['ref_carac']];
	$allowed_values	= "";
	if (isset($_REQUEST['allowed_values_'.$_REQUEST['ref_carac']])) {$allowed_values	= $_REQUEST['allowed_values_'.$_REQUEST['ref_carac']];}
	$default_value	= $_REQUEST['default_value_'.$_REQUEST['ref_carac']];
	$moteur_recherche	= $_REQUEST['moteur_recherche_'.$_REQUEST['ref_carac']];
	if (isset($_REQUEST['variante_'.$_REQUEST['ref_carac']])) {
	$variante	= 1;
	}else{
	$variante	= 0;
	}
	$affichage	= $_REQUEST['affichage_'.$_REQUEST['ref_carac']];
	$ref_carac_groupe	= $_REQUEST['ref_carac_groupe_'.$_REQUEST['ref_carac']];
	
	
	
	// *************************************************
	// Création de la catégorie
	$art_categ = new art_categ ($_REQUEST['ref_art_categ']);
	$art_categ->maj_carac ($ref_carac, $lib_carac, $unite, $allowed_values, $default_value, $moteur_recherche, $variante, $affichage, $ref_carac_groupe);
}

// *************************************************************************************************************
// AFFICHAGE
// -*************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_catalogue_categorie_caract_mod.inc.php");

?>