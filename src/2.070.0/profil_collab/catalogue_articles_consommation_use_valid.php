<?php
// *************************************************************************************************************
// usage de crédits de consommation
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");


if (isset($_REQUEST["conso_id_compte_credit"])) {
	$article = new article ($_REQUEST["conso_ref_article"]);
	$infos = array();
	$infos["id_compte_credit"] 		= ($_REQUEST["conso_id_compte_credit"]);
	$infos["credit_used"] 		= ($_REQUEST["conso_credits_used"]);

	$article->add_credits_consommation ($infos);
}

// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_catalogue_articles_consommation_use_valid.inc.php");

?>