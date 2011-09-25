<?php
// *************************************************************************************************************
// AFFICHAGE D'UNE LISTE DE SN d'UN ARTICLE DANS UN STOCK DONNE
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
	if(isset($_REQUEST['id_stock']) && $_REQUEST['id_stock'] != "") {
		$id_stock = $_REQUEST['id_stock'];
	}
	// Préparations des variables d'affichage
	$choix_sns = stock::getArticles_sn ($id_stock, $_REQUEST['ref_article']);
	
	// *************************************************************************************************************
	// AFFICHAGE
	// *************************************************************************************************************

	include ($DIR.$_SESSION['theme']->getDir_theme()."page_catalogue_articles_liste_choix_sn.inc.php");
}
?>