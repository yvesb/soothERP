<?php
// *************************************************************************************************************
// NOUVEAU DOCUMENT
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");

		
		
if (isset($_REQUEST["ref_doc"])) {

	$ref_doc				= $_REQUEST["ref_doc"];
	$ref_doc_liaison	= $_REQUEST["ref_doc_liaison"];
	//ouverture du document
	$document = open_doc ($ref_doc);
	//briser la liaison du document_liaison avec ce document 
	$document->break_liaison ($ref_doc_liaison);
	
	
		

}

// *************************************************************************************************************
// AFFICHAGE
// -*************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_documents_edition_block_liaisons_unlink.inc.php");

?>