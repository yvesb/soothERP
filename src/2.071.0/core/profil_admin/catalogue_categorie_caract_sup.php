<?php
//  ******************************************************
// ACCUEIL DE L'UTILISATEUR ADMINISTRATEUR
//  ******************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");


if (isset($_REQUEST['ref_art_categ'])) {	
	// *************************************************
	// Controle des données fournies par le formulaire

	$ref_carac	= $_REQUEST['ref_carac'];
	
	// *************************************************
	// Création de la catégorie
	$art_categ = new art_categ ($_REQUEST['ref_art_categ']);
	$art_categ-> delete_carac ($ref_carac);
}

//  ******************************************************
// AFFICHAGE
// - ******************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_catalogue_categorie_caract_sup.inc.php");

?>