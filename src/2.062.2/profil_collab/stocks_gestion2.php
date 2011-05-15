<?php
// *************************************************************************************************************
// ACCUEIL GESTION COMPTES BANCAIRES
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");

if (isset($_REQUEST["id_stock"])) {
	$stock	= $_SESSION['stocks'][$_REQUEST["id_stock"]];
	
	$erreurs_stock = $stock->erreurs_stock ();
	
	$list_art_categ = get_articles_categories_materiel();
	
	foreach ($list_art_categ as $art_categ) {
		$art_categ->valeur_stock = valeur_stock_art_categ ($_REQUEST["id_stock"], $art_categ->ref_art_categ);
	}

	// *************************************************************************************************************
	// AFFICHAGE
	// *************************************************************************************************************
	
	include ($DIR.$_SESSION['theme']->getDir_theme()."page_stocks_gestion2.inc.php");
}
?>