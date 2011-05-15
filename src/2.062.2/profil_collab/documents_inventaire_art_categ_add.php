<?php
// *************************************************************************************************************
// AJOUT DE LIGNES AU DOCUMENT
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");


if (isset($_REQUEST['ref_doc'])) {
	// ouverture des infos du document
	$document = open_doc ($_REQUEST['ref_doc']);
	if (isset($_REQUEST['preremplir']) && $_REQUEST['preremplir'] == "1") {
		$GLOBALS['_OPTIONS']['CREATE_DOC']['pre_remplir'] = 1;
	} 
	if (isset($_REQUEST["ref_constructeur"]) && $_REQUEST["ref_constructeur"] != "" ) {
		$document->insert_art_categ ($_REQUEST["art_categ"], $_REQUEST["ref_constructeur"]);
	} else {
		$document->insert_art_categ ($_REQUEST["art_categ"]);
	}
}
$insert_line_from_art_categ = 1;

if (!isset($GLOBALS['_OPTIONS']['CREATE_DOC']['pre_remplir'])) {
$_INFOS['new_lines'] = array();
}

// *************************************************************************************************************
// AFFICHAGE
// -*************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_documents_line_add.inc.php");

?>