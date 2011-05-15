<?php
// *************************************************************************************************************
// ACCUEIL DE L'UTILISATEUR ADMINISTRATEUR
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");


if (isset($_REQUEST['ref_contact'])) {	
	// *************************************************
	// modification de l'ordre d'un utilisateur

	//on récupére fonction de l'ordre et et de la ref_contact le premier ref_user
	$ref_user	= utilisateur::getRef_user_from_ordre ($_REQUEST['ref_contact'], $_REQUEST['ordre_other']);
	
	//on récupére fonction de l'ordre et et de la ref_contact le deuxieme ref_user
	$ref_user_other = utilisateur::getRef_user_from_ordre ($_REQUEST['ref_contact'], $_REQUEST['ordre']);


	$utilisateur = new utilisateur ($ref_user);
	$utilisateur->modifier_ordre ($_REQUEST['ordre']);
}
// *************************************************************************************************************
// AFFICHAGE
// -*************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_annuaire_edition_valid_user_ordre.inc.php");


?>