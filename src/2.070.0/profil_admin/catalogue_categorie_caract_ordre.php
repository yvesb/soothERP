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

	
	$new_ordre				= $_REQUEST['ordre'];
	$new_ordre_other			= $_REQUEST['ordre_other'];
	//on récupére fonction de l'ordre et et de la réf_art_categ le premier ref_carac_groupe
	$ref_carac	= art_categ::getRef_carac_from_ordre ($_REQUEST['ref_art_categ'] , $_REQUEST['ordre_other']);
	
	//on récupére fonction de l'ordre et et de la réf_art_categ le deuxième ref_carac_groupe
	$ref_carac_other	= art_categ::getRef_carac_from_ordre ($_REQUEST['ref_art_categ'] , $_REQUEST['ordre']);
	
	
	// *************************************************
	// modifier l'ordre
	
	$art_categ = new art_categ ($_REQUEST['ref_art_categ']);
	
	$art_categ-> modifier_carac_ordre ($ref_carac, $new_ordre);

}

// *************************************************************************************************************
// AFFICHAGE
// -*************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_catalogue_categorie_caract_ordre.inc.php");


?>