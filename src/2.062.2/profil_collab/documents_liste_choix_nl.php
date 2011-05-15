<?php
// *************************************************************************************************************
// [ADMINISTRATEUR] AFFICHAGE D'UNE LISTE DE COORDONNEES
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");


// *************************************************************************************************************
// TRAITEMENTS
// *************************************************************************************************************

// Controle

if (isset($_REQUEST['ref_article'])) {

	$id_stock = $_SESSION['magasin']->getId_stock();
	if(isset($_REQUEST['ref_doc']) && $_REQUEST['ref_doc'] != "") {
		// Ouverture du document
		$document = open_doc ($_REQUEST['ref_doc']);
		
		// Stock affiché
		$id_stock = $document->getid_stock_search();
	}
	// Préparations des variables d'affichage
	$choix_sns = stock::getArticles_nl ($id_stock, $_REQUEST['ref_article']);
	
	// *************************************************************************************************************
	// AFFICHAGE
	// *************************************************************************************************************

	include ($DIR.$_SESSION['theme']->getDir_theme()."page_documents_liste_choix_nl.inc.php");
}
?>