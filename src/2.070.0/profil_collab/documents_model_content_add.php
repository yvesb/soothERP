<?php
// *************************************************************************************************************
// AJOUT DE LIGNES AU DOCUMENT
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");



if (isset($_REQUEST['ref_doc']) && isset($_REQUEST['ref_doc_mod'])) {
//echo 'titi'.$_REQUEST['ref_doc'].'<>'.$_REQUEST['ref_doc_mod'].'toto';
// ouverture des infos du document
	$document = open_doc ($_REQUEST['ref_doc']);
	$modele = open_doc ($_REQUEST['ref_doc_mod']);
	$modele->copie_content($document);
}





// *************************************************************************************************************
// AFFICHAGE
// -*************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_documents_line_add.inc.php");
?>