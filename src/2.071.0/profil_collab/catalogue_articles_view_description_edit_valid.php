<?php
// *************************************************************************************************************
// MISE A JOUR DE LA DESCRIPTION LONGUE D'UN ARTICLE
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

	$article->maj_description_longue (urldecode($_REQUEST['info_content']));



// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_catalogue_articles_view_description_edit_valid.inc.php");

															
?>