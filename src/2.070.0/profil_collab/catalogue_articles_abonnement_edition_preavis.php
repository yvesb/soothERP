<?php
// *************************************************************************************************************
// EDITION D'UN ABONNEMENT Mise à jour du préavis
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");


if (isset($_REQUEST["preavis_id_abo"])) {
	$article = new article ($_REQUEST["preavis_ref_article"]);
	$infos = array();
	$infos["id_abo"] 						= ($_REQUEST["preavis_id_abo"]);
	$infos["date_preavis"] = date_Fr_to_Us($_REQUEST["preavis_date_preavis"]);
	if ($ARTICLE_ABO_TIME) {
		$infos["date_preavis"] .= " ".getTime_from_date($_REQUEST["preavis_date_preavis"]);
	}
	
	$abonnement = $article->maj_preavis_abonnement ($infos);
}

// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_catalogue_articles_abonnement_edition_preavis.inc.php");

?>