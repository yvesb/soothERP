<?php
// *************************************************************************************************************
// RESUME DES STOCK D'UN ARTICLE (affichage dans les moteurs de recherche article)
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");


//**************************************
// Controle

	if (!isset($_REQUEST['ref_article'])) {
		echo "La référence de l'article n'est pas précisée";
		exit;
	}

	$article = new article ($_REQUEST['ref_article']);
	if (!$article->getRef_article()) {
		echo "La référence de l'article est inconnue";		exit;

	}




//liste des lieux de stockage
$stocks_liste	= array();
$stocks_liste = $_SESSION['stocks'];

// chargement des stock de l'article
$art_stocks =  $article->getStocks ();
$art_stocks_rsv =  $article->getStocks_rsv ();
$art_stocks_cdf =  $article->getStocks_cdf ();
$art_stocks_tofab =  $article->getStocks_tofab ();
$art_composants =  $article->getComposants ();
$art_stock_alerte = $article->getStocks_alertes();

// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_catalogue_articles_resume_stock_all.inc.php");

?>