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

$article->mod_ref_article_externe ($_REQUEST["ref_fournisseur"], $_REQUEST["old_ref_fournisseur"], $_REQUEST["ref_article_externe"], $_REQUEST["old_ref_article_externe"], $_REQUEST["lib_article_externe"], $_REQUEST["pa_unitaire"], Date_Fr_to_Us($_REQUEST["date_pa"]));

// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_catalogue_articles_view_ref_externes_mod_valid.inc.php");

?>