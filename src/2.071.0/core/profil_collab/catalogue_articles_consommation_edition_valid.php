<?php
// *************************************************************************************************************
// EDITION De consommation
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");


if (isset($_REQUEST["conso_id_compte_credit"])) {
	$article = new article ($_REQUEST["conso_ref_article"]);
	$infos = array();
	$infos["id_compte_credit"] 		= ($_REQUEST["conso_id_compte_credit"]);
	$infos["date_souscription"] 	= date_Fr_to_Us($_REQUEST["conso_date_souscription"]);
	$infos["date_echeance"] 			= date_Fr_to_Us($_REQUEST["conso_date_echeance"]);
	$infos["credits_restants"] 		= ($_REQUEST["conso_credits_restants"]);

	$consommation = $article->maj_infos_consommation ($infos);
}

// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_catalogue_articles_consommation_edition_valid.inc.php");

?>