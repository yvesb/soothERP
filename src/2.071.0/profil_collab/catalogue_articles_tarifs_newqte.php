<?php
// *************************************************************************************************************
// AJOUT NOUVELLE LIGNE DE FORMULES 
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");


// Controle

	if (!isset($_REQUEST['ref_art_categ'])) {
		echo "La référence de la catégorie n'est pas précisée";
		exit;
	}

	$art_categ = new art_categ ($_REQUEST['ref_art_categ']);
	
	// on récupére la liste des tarifs
	$tarifs_liste	= array();
	$tarifs_liste = get_tarifs_listes_formules ($_REQUEST['ref_art_categ']);



	
	if (!$art_categ->getRef_art_categ()) {
		echo "La référence de la catégorie est inconnue";		exit;

	}
	
	
	
// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_catalogue_articles_tarifs_newqte.inc.php");

?>