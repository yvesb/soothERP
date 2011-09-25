<?php
// *************************************************************************************************************
// EDITION D'UN ABONNEMENT
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");


if (isset($_REQUEST["id_abo"])) {
	$article = new article ($_REQUEST["ref_article"]);
	$abonnement = $article->charger_abonnement ($_REQUEST["id_abo"]);
}

if (isset($_REQUEST["source"])){
	$source = $_REQUEST["source"];
}

if (isset($_REQUEST["develop_abo"])){
	$develop_abo = $_REQUEST["develop_abo"];
}

// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_catalogue_articles_abonnement_edition.inc.php");

?>