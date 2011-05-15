<?php
// *************************************************************************************************************
// ACCUEIL DE L'UTILISATEUR ADMINISTRATEUR
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");
require_once ($DIR."_article_liaisons_types.class.php");


	// *************************************************
	// Controle des données fournies par le formulaire

	
	$new_ordre				= $_REQUEST['ordre'];
	$new_ordre_other			= $_REQUEST['ordre_other'];
	

	//on récupére fonction de l'ordre la premier ref
	$id_liaison_type	= art_liaison_type::getId_liaison_type_from_ordre ($_REQUEST['ordre_other']);

	//on récupére fonction de l'ordre la deuxième ref
	$id_liaison_type_other	= art_liaison_type::getId_liaison_type_from_ordre ($_REQUEST['ordre']);

	
	
	// *************************************************
	// modification de l'ordre
	$liaison_liste = new art_liaison_type ($id_liaison_type);
	$liaison_liste->modifier_ordre ($new_ordre);


// *************************************************************************************************************
// AFFICHAGE
// -*************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_catalogue_liaisons_ordre.inc.php");

?>