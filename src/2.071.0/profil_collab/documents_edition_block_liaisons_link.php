<?php
// *************************************************************************************************************
// NOUVEAU DOCUMENT
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");


		
		
if (isset($_REQUEST["ref_doc_cible"])) {

	$ref_doc				= $_REQUEST["ref_doc_cible"];
	$ref_doc_source	= $_REQUEST["ref_doc_liaison_pos"];
	//ouverture du document
	$document = open_doc ($ref_doc);
	//liaison du document source avec ce document 
	if ($document->link_from_doc ($ref_doc_source)) {
		$add_line_link_from_doc = true;
	}
	
	//récup d'infos diverses
	$id_type_doc = $document->getID_TYPE_DOC ();
	$ref_contact = $document->getRef_contact ();
	
		

}

// *************************************************************************************************************
// AFFICHAGE
// -*************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_documents_line_add.inc.php");

?>