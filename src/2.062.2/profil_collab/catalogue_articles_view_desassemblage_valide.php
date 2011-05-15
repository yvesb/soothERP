<?php
// *************************************************************************************************************
// DESASSEMBLAGE RAPIDE POUR UN ARTICLE SEUL
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");


//**************************************
// Controle

	if (!isset($_REQUEST['ref_article_des'])) {
		echo "La référence de l'article n'est pas précisée";
		exit;
	}

	$article = new article ($_REQUEST['ref_article_des']);
	if (!$article->getRef_article()) {
		echo "La référence de l'article est inconnue";		exit;

	}
	$GLOBALS['_OPTIONS']['CREATE_DOC']['id_stock'] = $_REQUEST["id_stock_des"];
	
	$GLOBALS['_OPTIONS']['CREATE_DOC']['ref_article'] = $_REQUEST["ref_article_des"];
	$GLOBALS['_OPTIONS']['CREATE_DOC']['qte_des'] = $_REQUEST["qte_des"];
	$GLOBALS['_OPTIONS']['CREATE_DOC']['fill_content'] = 1;
	$document = create_doc ($_REQUEST["id_type_doc_des"]);
	
	
	$document-> maj_etat_doc (56);

// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_catalogue_articles_view_desassemblage_valide.inc.php");

?>