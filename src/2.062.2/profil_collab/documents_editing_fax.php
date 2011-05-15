<?php
// *************************************************************************************************************
// ENVOI D'UN DOCUMENT PAR fax
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");

if (isset($_REQUEST["ref_doc"])) {
	$document = open_doc ($_REQUEST['ref_doc']);
	$liste_fax = array();
	
	if ($document->getRef_contact()) {
		$liste_fax = get_contact_faxs ($document->getRef_contact());
	}
}

// *************************************************************************************************************
// AFFICHAGE
// -*************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_documents_editing_fax.inc.php");

?>