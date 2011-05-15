<?php
// *************************************************************************************************************
// MODIFICATION DE L'ORDRE LA COORDONNEE D'UN CONTACT
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");


if (isset($_REQUEST['ref_contact'])) {	
	// *************************************************
	// modification de l'ordre d'une coordonnnée

	//on récupére fonction de l'ordre et et de la ref_contact le premier ref_coord
	$ref_coord	= coordonnee::getRef_coord_from_ordre ($_REQUEST['ref_contact'], $_REQUEST['ordre_other']);

	//on récupére fonction de l'ordre et et de la ref_contact le deuxieme ref_coord
	$ref_coord_other	= coordonnee::getRef_coord_from_ordre ($_REQUEST['ref_contact'], $_REQUEST['ordre']);


	$coordonnee = new coordonnee ($ref_coord);
	$coordonnee->modifier_ordre ($_REQUEST['ordre']);
}
// *************************************************************************************************************
// AFFICHAGE
// -*************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_annuaire_edition_valid_coordonnee_ordre.inc.php");


?>ok