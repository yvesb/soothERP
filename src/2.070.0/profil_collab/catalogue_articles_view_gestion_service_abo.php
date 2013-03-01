<?php
// *************************************************************************************************************
// GESTION DES ABONNEMENTS A UN ARTICLE
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




//liste des lieux de stockage
$stocks_liste	= array();
$stocks_liste = $_SESSION['stocks'];
	
	
//liste des grille tarifs
$tarifs_liste	= array();
$tarifs_liste = get_tarifs_listes_formules ($article->getRef_art_categ ());
	

// Charge les différents types de liaisons existants
$liaisons_liste	= array();
$liaisons_liste = get_liaisons_types (); 
	


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

//chargement des caractéristiques
$art_caracs	=	$article->getCaracs();

// chargement des tarifs des l'article
$liste_tarifs = $article->getTarifs ();

// chargement des stock de l'article
$art_stocks =  $article->getStocks ();

//chargement des images
$images	=	$article->getImages();

//chargement des derniers documents
$art_docs = $article->getLast_docs ();
	
$tva_article = $article->getTva();

//modification des données en cas d'affichage variante
if ($article->getVariante() == 1) {
	//on charge un Esclave variante, alors on récupére les caractéristique possibles à partir du maitre
	$ref_article_master = $article->getVariante_master();
	$article_master = new article ($ref_article_master);
	$caracs = $article_master->getCaracs ();
	$art_caracs	=	$article_master->getCaracs();
}


//gestion des stats
$article_service_abo = $article->charger_article_abo_stats ();

$evo_sousc_12 = array();
$max_evo_sousc_12 = 1;
for ($i=11; $i>=0; $i--) {
	if (abs($article_service_abo["souscription_12"][$i]) > $max_evo_sousc_12) { $max_evo_sousc_12 = number_format(abs($article_service_abo["souscription_12"][$i]), $TARIFS_NB_DECIMALES, ".", ""	);}
	$evo_sousc_12[] = $article_service_abo["souscription_12"][$i];
}

$max_evo_sousc_12 = max_valeur ($max_evo_sousc_12);


$evo_abo_12 = array();
$max_evo_abo_12 = 1;
for ($i=11; $i>=0; $i--) {
	if (abs($article_service_abo["abonnes_12"][$i]) > $max_evo_abo_12) { $max_evo_abo_12 = number_format(abs($article_service_abo["abonnes_12"][$i]), $TARIFS_NB_DECIMALES, ".", ""	);}
	$evo_abo_12[] = $article_service_abo["abonnes_12"][$i];
}

$max_evo_abo_12 = max_valeur ($max_evo_abo_12);


$degrader_12 = rainbowDegrader(12, array('240','191','58'), array('0','74','153'));
$degrader_12_pos = rainbowDegrader(12, array('240','191','58'), array('0','74','153'));
$degrader_12_neg = rainbowDegrader(12, array('58','240','191'), array('153','74','0'));


// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_catalogue_articles_view_gestion_service_abo.inc.php");

?>