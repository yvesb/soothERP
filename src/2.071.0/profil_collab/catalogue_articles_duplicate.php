<?php
// *************************************************************************************************************
// ACCUEIL DE L'UTILISATEUR ADMINISTRATEUR
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");
require ($DIR.$_SESSION['theme']->getDir_theme()."_theme.config.php" );
require_once ($DIR."_article_liaisons_types.class.php");

if(!$_SESSION['user']->check_permission ("38")){
		echo "<br /><span style=\"font-weight:bolder;color:#FF0000;\">Vos droits  d'accés ne vous permettent pas de visualiser ce type de document</span>";
		exit();
}


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

	
//liste des lieux de stockage
$stocks_liste	= array();
$stocks_liste = $_SESSION['stocks'];
	
//liste des grilles tarifaires
$tarifs_liste	= array();
$tarifs_liste = get_tarifs_listes_formules ($article->getRef_art_categ ());


// Charge les différents types de liaisons existants
$liaisons_type_liste = art_liaison_type::getLiaisons_type();

//liste des constructeurs
$constructeurs_liste = array();
$constructeurs_liste = get_constructeurs ();

	
//appel de des infos de la categ pour liste des caracteristiques de la catégorie	
$art_categs = new art_categ ($article->getRef_art_categ ());
	
// on récupére la liste des caractéristiques
	$caracs = array();
	$caracs = $article->getCaracs ();
	$caracs_groupes = $article->getCaracs_groupes ();
	for ($i = 0; $i < count($caracs); $i++) {
		foreach ($caracs_groupes as $carac_groupe) {
			if ($caracs[$i]->ref_carac_groupe == $carac_groupe->ref_carac_groupe) {
			$caracs[$i]->lib_carac_groupe = $carac_groupe->lib_carac_groupe;
			}
		}
	}
	
	
//liste des tvas du pays par defaut
$tvas = get_tvas ($DEFAUT_ID_PAYS);
	

$liste_tarifs = $article->getTarifs ();
$liste_formules_tarifs = $article->getFormules_tarifs ();

//getStocks_alertes
$article_stocks_alertes = $article->getStocks_alertes ();
//chargement de la laiste des composants
$article_composants = $article->getComposants ();
//chargement des carac
$art_caracs	=	$article->getCaracs();
//chargement des liaisons de l'articles
$article_liaisons	=	 $article->getLiaisons ();

// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_catalogue_articles_duplicate.inc.php");

?>