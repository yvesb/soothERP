<?php
// *************************************************************************************************************
// ACCUEIL DE L'UTILISATEUR ADMINISTRATEUR
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");



	if (!isset($_REQUEST['ref_art_categs'])) {
		echo "La référence de la catégorie n'est pas précisée";
		exit;
	}

	$art_categ = new art_categ ($_REQUEST['ref_art_categs']);
	if (!$art_categ->getRef_art_categ()) {
		echo "La référence de la catégorie est inconnue";		exit;

	}
// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************


$tvas = get_tvas ($DEFAUT_ID_PAYS);
	


include ($DIR.$_SESSION['theme']->getDir_theme()."page_catalogue_categorie_tvas_list.inc.php");

?>