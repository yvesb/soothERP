<?php
// *************************************************************************************************************
// ACCUEIL DE L'UTILISATEUR ADMINISTRATEUR
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");


if (isset($_REQUEST['ref_contact'])) {	
	// *************************************************
	// modification de l'ordre d'un site_web

	//on récupére fonction de l'ordre et et de la ref_contact le premier ref_site
	$ref_site	= site::getRef_site_from_ordre ($_REQUEST['ref_contact'], $_REQUEST['ordre_other']);
	
	//on récupére fonction de l'ordre et et de la ref_contact le deuxieme ref_site
	$ref_site_other	= site::getRef_site_from_ordre ($_REQUEST['ref_contact'], $_REQUEST['ordre']);

	$site = new site ($ref_site);
	$site->modifier_ordre ($_REQUEST['ordre']);
}
// *************************************************************************************************************
// AFFICHAGE
// -*************************************************************************************************************
include ($DIR.$_SESSION['theme']->getDir_theme()."page_annuaire_edition_valid_site_ordre.inc.php");



?>ok