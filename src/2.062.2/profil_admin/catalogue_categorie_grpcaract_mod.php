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

	
	$lib_carac_groupe	= $_REQUEST['lib_carac_groupe_'.$_REQUEST['ref_carac_groupe']];
	$ref_carac_groupe	= $_REQUEST['ref_carac_groupe'];
	
	// *************************************************
	// Création de la catégorie
	$art_categ = new art_categ ($_REQUEST['ref_art_categ']);
	$art_categ-> maj_carac_groupe ($ref_carac_groupe, $lib_carac_groupe);
}

// *************************************************************************************************************
// AFFICHAGE
// -*************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_catalogue_categorie_grpcaract_mod.inc.php");

?>