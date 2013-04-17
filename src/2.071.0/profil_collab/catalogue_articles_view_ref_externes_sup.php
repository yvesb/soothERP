<?php
// *************************************************************************************************************
// ARTICLE GESTION DES REF EXTERNES FOURNISSEURS
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
//suppression de la ref_externe
$article->del_ref_article_externe ($_REQUEST["ref_fournisseur"], $_REQUEST["ref_article_externe"]);


// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_catalogue_articles_view_ref_externes_sup.inc.php");

?>