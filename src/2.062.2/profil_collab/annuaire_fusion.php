<?php
// *************************************************************************************************************
// FUSION DEUX DEUX FICHES CONTACT
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");

if (isset($_REQUEST['old_ref_contact'])) {	
	
	// *************************************************
	// Création du contact
	$contact = new contact ($_REQUEST['old_ref_contact']);
	$contact->fusion ($_REQUEST['new_ref_contact']);
}

// *************************************************************************************************************
// AFFICHAGE
// -*************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_annuaire_fusion.inc.php");

?>