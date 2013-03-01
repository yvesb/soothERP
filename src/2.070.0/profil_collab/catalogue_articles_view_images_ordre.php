<?php
// *************************************************************************************************************
// SUPRESSION D'UNE IMAGE D'UN ARTICLE EN MODE VISUALISATION
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

$article->image_maj_ordre ($_REQUEST['id_image'], $_REQUEST['ordre']);


//chargement des images
$images	=	$article->getImages();
// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_catalogue_articles_view_info_images.inc.php");

?>