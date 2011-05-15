<?php
// *************************************************************************************************************
// MAJ D'UN NUMERO DE SERIE A UN LIGNE DE DOCUMENT
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");


if (isset($_REQUEST['ref_doc'])) {

// ouverture des infos du document et mise à jour
	$document = open_doc ($_REQUEST['ref_doc']);
	$document->maj_line_sn ($_REQUEST['ref_doc_line'], $_REQUEST['sn'],  $_REQUEST['new_sn']);
	$id_type_doc = $document->getID_TYPE_DOC ();
	
// *************************************************************************************************************
// AFFICHAGE
// -*************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_documents_line_maj_sn.inc.php");
}

?>