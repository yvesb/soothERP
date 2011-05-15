<?php
// *************************************************************************************************************
// EDITION D'UN ABONNEMENT
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");


if (isset($_REQUEST["abo_id_abo"])) {
	$article = new article ($_REQUEST["abo_ref_article"]);
	$infos = array();
	$infos["id_abo"] 						= ($_REQUEST["abo_id_abo"]);
	$infos["date_souscription"] = date_Fr_to_Us($_REQUEST["abo_date_souscription"]);
	$infos["date_echeance"] 		= date_Fr_to_Us($_REQUEST["abo_date_echeance"]);
	$infos["fin_engagement"] 		= date_Fr_to_Us($_REQUEST["abo_fin_engagement"]);
	$infos["fin_abonnement"] 		= date_Fr_to_Us($_REQUEST["abo_fin_abonnement"]);
	$infos["date_preavis"] 			= date_Fr_to_Us($_REQUEST["abo_date_preavis"]);
	if ($ARTICLE_ABO_TIME) {
		$infos["date_souscription"] .= " ".getTime_from_date($_REQUEST["abo_date_souscription"]);
		$infos["date_echeance"] 		.= " ".getTime_from_date($_REQUEST["abo_date_echeance"]);
		$infos["fin_engagement"] 		.= " ".getTime_from_date($_REQUEST["abo_fin_engagement"]);
		$infos["fin_abonnement"] 		.= " ".getTime_from_date($_REQUEST["abo_fin_abonnement"]);
		$infos["date_preavis"] 			.= " ".getTime_from_date($_REQUEST["abo_date_preavis"]);
	}
	
	$abonnement = $article->maj_infos_abonnement ($infos);
}

if(isset($_REQUEST["source"])) {
	$source = $_REQUEST["source"];
}

if(isset($_REQUEST["develop_abo"])) {
	$develop_abo = $_REQUEST["develop_abo"];
}

// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_catalogue_articles_abonnement_edition_valid.inc.php");

?>