<?php
// *************************************************************************************************************
// EDITION DE L'ARTICLE EN MODE VISUALISATION
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");


if (isset($_REQUEST['ref_article'])) {	

	
		$article = new article ($_REQUEST['ref_article']);
		$article->fusion ($_REQUEST["second_ref_article"]);
	

}

// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_catalogue_articles_fusion.inc.php");

?>
