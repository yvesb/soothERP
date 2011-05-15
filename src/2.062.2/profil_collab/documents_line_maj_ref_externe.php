<?php
// *************************************************************************************************************
// MAJ REF_EXTERNE D'UNE LIGNE D'UN DOCUMENT
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");

if (isset($_REQUEST['ref_doc'])) {
	// ouverture des infos du document et mise à jour
	$document = open_doc ($_REQUEST['ref_doc']);
	$document->maj_line_ref_article_externe ($_REQUEST['ref_doc_line'], $_REQUEST['ref_externe'], $_REQUEST['old_ref_externe'], $_REQUEST['ref_article']);
	$id_type_doc = $document->getID_TYPE_DOC ();

// *************************************************************************************************************
// AFFICHAGE
// -*************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_documents_line_maj_ref_externe.inc.php");
}
?>