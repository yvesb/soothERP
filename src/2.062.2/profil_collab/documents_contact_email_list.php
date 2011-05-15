<?php
// *************************************************************************************************************
// AJOUT DE LIGNES AU DOCUMENT
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");


if (isset($_REQUEST['ref_doc'])) {

	// ouverture des infos du document
	$document = open_doc ($_REQUEST['ref_doc']);
	
	$contact = new contact($document->getRef_contact ());
	$contact_entreprise = new contact($REF_CONTACT_ENTREPRISE);

	$liste_email = get_contact_emails ($document->getRef_contact ());
	// *************************************************************************************************************
	// AFFICHAGE
	// *************************************************************************************************************
	
	include ($DIR.$_SESSION['theme']->getDir_theme()."page_documents_contact_email_list.inc.php");
}

?>