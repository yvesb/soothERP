<?php
// *************************************************************************************************************
// ARTICLE STATS
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

//statistiques
//CA généré par l'article
$article_CA = $article->charger_article_CA ();


$solde_30 = array();
$max_solde_30 = 1;

for ($i=29; $i>=0; $i--) {
	if (abs($article_CA["ventes_30"][$i]) > $max_solde_30) { $max_solde_30 = number_format(abs($article_CA["ventes_30"][$i]), $TARIFS_NB_DECIMALES, ".", ""	);}
	$solde_30[] = $article_CA["ventes_30"][$i];
}
$max_solde_30 = max_valeur ($max_solde_30);

$degrader_30_pos = rainbowDegrader(30, array('0','120','0'), array('0','254','0'));
$degrader_30_neg = rainbowDegrader(30, array('120','0','0'), array('254','0','0'));


$solde_12 = array();
$max_solde_12 = 1;
for ($i=11; $i>=0; $i--) {
	if (abs($article_CA["ventes_12"][$i]) > $max_solde_12) { $max_solde_12 = number_format(abs($article_CA["ventes_12"][$i]), $TARIFS_NB_DECIMALES, ".", ""	);}
	$solde_12[] = $article_CA["ventes_12"][$i];
}

$max_solde_12 = max_valeur ($max_solde_12);
$degrader_12 = rainbowDegrader(12, array('240','191','58'), array('0','74','153'));
$degrader_12_pos = rainbowDegrader(12, array('240','191','58'), array('0','74','153'));
$degrader_12_neg = rainbowDegrader(12, array('58','240','191'), array('153','74','0'));

//fin des stats

// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_catalogue_articles_view_stats.inc.php");

?>