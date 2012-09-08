<?php
// *************************************************************************************************************
// RECHARGEMENT DU BLOCK DES LIAISONS D'UN DOCUMENT
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");

		
		
if (isset($_REQUEST["ref_doc"])) {

	$ref_doc= $_REQUEST["ref_doc"];
	$document = open_doc ($ref_doc);
	$id_type_doc = $document->getID_TYPE_DOC ();
	$ref_contact = $document->getRef_contact ();
	
		

}
//liaisons du document
$doc_liaisons_possibles = $document->getLiaisons_possibles ();
$doc_liaisons = $document->getLiaisons ();

// *************************************************************************************************************
// AFFICHAGE
// -*************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_documents_edition_block_liaisons.inc.php");

?>