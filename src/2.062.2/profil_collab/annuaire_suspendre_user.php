<?php
// *************************************************************************************************************
// SUSPENDRE LES UTILISATEURS DU CONTACT
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");

if (isset($_REQUEST['users_ref_contact'])) {	
	
	// *************************************************
	// Création du contact
	$contact = new contact ($_REQUEST['users_ref_contact']);
	$contact->blocages_utilisateurs ();
	$users = array();
	$users= $contact->getUtilisateurs ();
}

// *************************************************************************************************************
// AFFICHAGE
// -*************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_annuaire_suspendre_user.inc.php");

?>