<?php
// *************************************************************************************************************
// AFFICHAGE DE L'EDITION D'UN DOCUMENT (partie document pdf)
// *************************************************************************************************************

require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");

ini_set("memory_limit","40M");
if (isset($_REQUEST["ref_article"])) {
	$GLOBALS['_OPTIONS']['CREATE_DOC']['no_charge_all_sn'] = 1;
	$article = new article ($_REQUEST['ref_article']);
	
	/*if (isset($_REQUEST["filigrane"])) { $GLOBALS['PDF_OPTIONS']['filigrane'] = $_REQUEST["filigrane"];}
	//changement du code pdf_modele
	
	if (isset($_REQUEST["code_pdf_modele"])) {
		$document->change_code_pdf_modele ($_REQUEST["code_pdf_modele"]);
	}*/
	if (isset($_REQUEST["print"])) {
		$article->print_pdf();
	}else {
		$article->view_pdf();
	}
}

?>