<?php
//  ******************************************************
// ACCUEIL DE L'UTILISATEUR ADMINISTRATEUR
//  ******************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");

// chargement de la class du profil
contact::load_profil_class($FOURNISSEUR_ID_PROFIL);
// Préparations des variables 

	$infos	=	array();
	$infos['note']				=	$_REQUEST["note"];
	$infos['lib_fournisseur_categ']	=	$_REQUEST["lib_fournisseur_categ"];
	//création de la catégorie
	contact_fournisseur::create_fournisseurs_categories ($infos);

//  ******************************************************
// AFFICHAGE
//  ******************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_annuaire_gestion_categories_fournisseur_add.inc.php");

?>