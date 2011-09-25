<?php
// *************************************************************************************************************
// MODIFICATION DE L'ORDRE DE L'ADRESSE D'UN CONTACT
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");


if (isset($_REQUEST['ref_contact'])) {	
	// *************************************************
	// modification de l'ordre d'une adresse

	//on récupére fonction de l'ordre et et de la ref_contact le premier ref_adresse
	$ref_adresse	= adresse::getRef_adresse_from_ordre($_REQUEST['ref_contact'], $_REQUEST['ordre_other']);
	
	//on récupére fonction de l'ordre et et de la ref_contact le deuxieme ref_adresse
	$ref_adresse_other	= adresse::getRef_adresse_from_ordre($_REQUEST['ref_contact'], $_REQUEST['ordre']);
	
	$adresse = new adresse ($ref_adresse);
	$adresse->modifier_ordre ($_REQUEST['ordre']);
}
// *************************************************************************************************************
// AFFICHAGE
// -*************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_annuaire_edition_valid_adresse_ordre.inc.php");

?>ok