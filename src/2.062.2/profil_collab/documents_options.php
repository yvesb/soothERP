<?php
// *************************************************************************************************************
// ONGLET DES OPTIONS DU DOCUMENT
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");



		
		
if (isset($_REQUEST["ref_doc"])) {

	$ref_doc= $_REQUEST["ref_doc"];
	$document = open_doc ($ref_doc);
	$id_type_doc = $document->getID_TYPE_DOC ();
	$ref_contact = $document->getRef_contact ();
	
	if ($id_type_doc == 2 || $id_type_doc == 3 ||$id_type_doc == 4 ||$id_type_doc == 6 ||$id_type_doc == 7 || $id_type_doc == 8) {
		$liste_doc_fusion = $document->getDoc_fusion_dispo ();
	}
	
}


// *************************************************************************************************************
// AFFICHAGE
// -*************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_documents_options.inc.php");

?>