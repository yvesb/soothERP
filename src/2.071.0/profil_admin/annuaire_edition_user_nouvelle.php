<?php
// *************************************************************************************************************
// ACCUEIL DE L'UTILISATEUR ADMINISTRATEUR
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");


if (isset($_REQUEST['ref_contact'.$_REQUEST['ref_idform']])) {	

// on récupére la dernier ref user si existe pour la réactualiser (afin de rafraichir l'affiche des ordres

	$ordre_previous	=	getMax_ordre("users", $_REQUEST['ref_contact'.$_REQUEST['ref_idform']], " && actif >= 0 ");
	if ($ordre_previous>0) {
		$ref_user_previous	= utilisateur::getRef_user_from_ordre ($_REQUEST['ref_contact'.$_REQUEST['ref_idform']], $ordre_previous);
	}


	// *************************************************
	// création d'une coordonnée
	$ref_contact		= $_REQUEST['ref_contact'.$_REQUEST['ref_idform']];
	$pseudo 				= $_REQUEST['user_pseudo'.$_REQUEST['ref_idform']];
	$code 					= $_REQUEST['user_code'.$_REQUEST['ref_idform']];
	$code2					= $_REQUEST['user_2code'.$_REQUEST['ref_idform']];
	$ref_coord_user = $_REQUEST['user_coord'.$_REQUEST['ref_idform']];
	$actif					= 0;
	if (isset($_REQUEST['user_actif'.$_REQUEST['ref_idform']])) {
	$actif					= 1;
	}
	$id_langage			= $_REQUEST['user_id_langage'.$_REQUEST['ref_idform']];
	
	if ($code!="" && ($code == $code2)) { 
		$utilisateur = new utilisateur ();
		$utilisateur->create ($ref_contact, $ref_coord_user, $pseudo, $actif, $code, $id_langage);
	} else {
	
		$GLOBALS['_ALERTES']['Erreur_code'] = 1;
	
	}
	
}
	
	
// *************************************************************************************************************
// AFFICHAGE
// -*************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_annuaire_edition_valid_user_nouvelle.inc.php");

?>