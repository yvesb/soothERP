<?php
// *************************************************************************************************************
// EDITION De CONSOMMATION
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");


if (isset($_REQUEST["id_compte_credit"])) {
	$article = new article ($_REQUEST["ref_article"]);
	$consommation = $article->charger_consommation ($_REQUEST["id_compte_credit"]);
}

// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_catalogue_articles_consommation_edition.inc.php");

?>