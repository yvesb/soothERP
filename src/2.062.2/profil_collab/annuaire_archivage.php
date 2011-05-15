<?php
// *************************************************************************************************************
// ARCHIVAGE DU CONTACT
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");

if (isset($_REQUEST['archivage_ref_contact'])) {	
	
	// *************************************************
	// Création du contact
	$contact = new contact ($_REQUEST['archivage_ref_contact']);
	$contact->archivage ();
}

// *************************************************************************************************************
// AFFICHAGE
// -*************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_annuaire_archivage.inc.php");

?>