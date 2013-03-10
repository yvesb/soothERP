<?php
// *************************************************************************************************************
// FUSION DE DOCUMENTS
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");


if (isset($_REQUEST['ref_doc']) && isset($_REQUEST['second_ref_doc'])) {	

	$document = open_doc ($_REQUEST['ref_doc']);

	 
	$document->fusion_doc ($_REQUEST['second_ref_doc']);
	

}

// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_document_edition_fusion.inc.php");

?>
