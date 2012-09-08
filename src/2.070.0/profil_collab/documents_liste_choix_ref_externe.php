<?php
// *************************************************************************************************************
// [ADMINISTRATEUR] AFFICHAGE D'UNE LISTE DES REF_ARTICLE_EXTERNE
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");


// *************************************************************************************************************
// TRAITEMENTS
// *************************************************************************************************************

// Controle

if (isset($_REQUEST['ref_article'])) {
	// Préparations des variables d'affichage
	$document = open_doc($_REQUEST["ref_doc"]);
	$article = new article ($_REQUEST['ref_article']);
	$liste_choix_ref_externe = $article->charger_ref_article_externe_fournisseur($document->getRef_contact());
	
	// *************************************************************************************************************
	// AFFICHAGE
	// *************************************************************************************************************
	include ($DIR.$_SESSION['theme']->getDir_theme()."page_documents_liste_choix_ref_externe.inc.php");
}
?>