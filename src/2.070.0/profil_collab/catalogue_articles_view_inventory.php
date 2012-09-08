<?php
// *************************************************************************************************************
// INVENTAIRE RAPIDE POUR UN ARTICLE SEUL
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
	
	if ($article->getGestion_sn() == 2) {
		$id_stock = $_SESSION['magasin']->getId_stock();
		if(isset($_REQUEST['id_stock']) && $_REQUEST['id_stock'] != "") {
			$id_stock = $_REQUEST['id_stock'];
		}
		// Préparations des variables d'affichage
		$choix_sns = stock::getArticles_nl ($id_stock, $_REQUEST['ref_article']);
	}

// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_catalogue_articles_view_inventory.inc.php");

?>