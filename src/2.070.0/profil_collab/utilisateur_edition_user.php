<?php
// *************************************************************************************************************
// EDITION DE L'UTILISATEUR
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");


if (isset($_REQUEST['ref_contact'.$_REQUEST['ref_idform']])) {	



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
	
	//traitement des enregistrements
	
	$utilisateur = new utilisateur ($_REQUEST['user_ref'.$_REQUEST['ref_idform']]);
	
	//modif du mot de passe
	if ($code!="" && ($code == $code2)) { 
		$utilisateur->changer_code ($code);
		} elseif ($code != $code2) {
		$GLOBALS['_ALERTES']['Erreur_code'] = 1;
	}
	
	//utilisateur mis à Maitre
	$users = array();
	
	if (isset($_REQUEST['user_master'.$_REQUEST['ref_idform']]) && ($_REQUEST['user_master'.$_REQUEST['ref_idform']]=="0")) {
		$utilisateur->set_master ();
		// on récupére tout les réf_user pour rafraichir l'affichage
		$users = $utilisateur->liste_ref_user_actif();
	}
	
	//mise à jour de l'utilisateur
	$utilisateur->modification ($ref_coord_user, $pseudo, $actif, $id_langage);
}
	
	
// *************************************************************************************************************
// AFFICHAGE
// -*************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_utilisateur_edition_valid_user.inc.php");

?>