<?php
// *************************************************************************************************************
// MAJ LINE_QTE D'UNE LIGNE D'UN DOCUMENT
// *************************************************************************************************************

$_PAGE['MUST_BE_LOGIN'] = 0;
require("_dir.inc.php");
require ("_profil.inc.php");
require ("_session.inc.php");


if (isset($_REQUEST['ref_article'])) {

	// ouverture des infos du document et mise à jour

	interface_maj_line_panier ($_REQUEST['ref_article'], $_REQUEST['qte_article']); 
	
// *************************************************************************************************************
// AFFICHAGE
// -*************************************************************************************************************

//include ($DIR.$_SESSION['theme']->getDir_theme()."page_documents_line_maj_qte.inc.php");
}
?>