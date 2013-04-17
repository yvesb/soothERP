<?php
// *************************************************************************************************************
// ACCUEIL DE L'UTILISATEUR ADMINISTRATEUR
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");


// Controle


	if (!isset($_REQUEST['ref_article'])) {
		echo "La référence de l'article n'est pas précisée";
		exit;
	}

	$article = new article ($_REQUEST['ref_article']);
	if (!$article->getRef_article()) {
		echo "La référence de l'article est inconnue";		exit;

	}
	
//liste des grilles tarifaires
$tarifs_liste	= array();
$tarifs_liste = get_tarifs_listes_formules ($article->getRef_art_categ ());



//appel de des infos de la categ pour liste des caracteristiques de la catégorie	
$art_categs = new art_categ ($article->getRef_art_categ ());


//liste des tvas du pays par defaut
$tvas = get_tvas ($DEFAUT_ID_PAYS);
	
$liste_tarifs = $article->getTarifs ();
$liste_formules_tarifs = $article->getFormules_tarifs ();
	
// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_catalogue_articles_edition_tarifs.inc.php");

?>