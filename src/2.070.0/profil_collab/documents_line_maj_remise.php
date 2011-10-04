<?php
// *************************************************************************************************************
// MAJ LINE_REMISE D'UNE LIGNE D'UN DOCUMENT
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");


if (isset($_REQUEST['ref_doc'])) {

// ouverture des infos du document et mise à jour
	$document = open_doc ($_REQUEST['ref_doc']);
	$document-> maj_line_remise ($_REQUEST['ref_doc_line'], $_REQUEST['remise']);
	
	
include $DIR.$_SESSION['theme']->getDir_theme()."page_documents_line_maj_remise.inc.php";
}


?>