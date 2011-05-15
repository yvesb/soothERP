<?php
// *************************************************************************************************************
// ENVOI D'UN DOCUMENT PAR EMAIL
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");

if (isset($_REQUEST["ref_doc"])) {
	$document = open_doc ($_REQUEST['ref_doc']);
	$liste_email = array();
	
	$contact_entreprise = new contact($REF_CONTACT_ENTREPRISE);
	
	if ($document->getRef_contact()) {
		$liste_email = get_contact_emails ($document->getRef_contact());
	}
}

// *************************************************************************************************************
// AFFICHAGE
// -*************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_documents_editing_email.inc.php");

?>