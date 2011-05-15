<?php
// *************************************************************************************************************
// SUPPRESSION D'UN REGLEMENT
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");

		
if (isset($_REQUEST["ref_reglement"])) {

	$ref_doc= $_REQUEST["ref_doc_".$_REQUEST["ref_reglement"]];

	$reglement = new reglement ($_REQUEST["ref_reglement"]);
	$document = open_doc ($ref_doc);
	$document->delier_reglement ($reglement->getRef_reglement());
	//supression du règlement
	$reglement->delete_reglement ();  

	
}


// *************************************************************************************************************
// AFFICHAGE
// -*************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_documents_reglements_sup.inc.php");

?>