<?php
// *************************************************************************************************************
// ACCUEIL DE L'UTILISATEUR ADMINISTRATEUR
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

//chargement des images
$images	=	$article->getImages();

//chargement des ref_externes
$ref_externes	=	$article->getRef_externes();


//chargement des codes barres
$codes_barres	=	$article->getCodes_barres();

//chargement de la laiste des composants
$article_composants = $article->getComposants ();

// chargement des stock de l'article
$art_stocks =  $article->getStocks ();
$art_stocks_rsv =  $article->getStocks_rsv ();
$art_stocks_cdf =  $article->getStocks_cdf ();
$art_stocks_tofab =  $article->getStocks_tofab ();
$art_composants =  $article->getComposants ();

$article_stocks_alertes = $article->getStocks_alertes ();
$art_stocks_moves =  $article->charger_stocks_moves ($_SESSION['magasin']->getId_stock());

//chargement des liaisons de l'articles
$article_liaisons	=	 $article->getLiaisons ();
//chargement des derniers documents
$art_docs = $article->getLast_docs ();
	
$tva_article = $article->getTva();

// chargement des tarifs des l'article
$liste_tarifs = $article->getTarifs ();
$liste_formules_tarifs = $article->getFormules_tarifs ();


//statistiques
//CA généré par l'article
$article_CA = $article->charger_article_CA ();
//stat evolutions des prix
$prix_histo = $article->charger_pv_paa_pa_histo ();

//modification des données en cas d'affichage variante
if ($article->getVariante() == 1) {
	//on charge un Esclave variante, alors on récupére les caractéristique possibles à partir du maitre
	$ref_article_master = $article->getVariante_master();
	$article_master = new article ($ref_article_master);
	$caracs = $article_master->getCaracs ();
	$art_caracs	=	$article_master->getCaracs();
}



$solde_30 = array();
$max_solde_30 = 1;

for ($i=29; $i>=0; $i--) {
	if (abs($article_CA["ventes_30"][$i]) > $max_solde_30) { $max_solde_30 = number_format(abs($article_CA["ventes_30"][$i]), $TARIFS_NB_DECIMALES, ".", ""	);}
	$solde_30[] = $article_CA["ventes_30"][$i];
}
$max_solde_30 = max_valeur ($max_solde_30);

$degrader_30_pos = rainbowDegrader(30, array('0','120','0'), array('0','254','0'));
$degrader_30_neg = rainbowDegrader(30, array('120','0','0'), array('254','0','0'));



$solde_12 = array();
$max_solde_12 = 1;
for ($i=11; $i>=0; $i--) {
	if (abs($article_CA["ventes_12"][$i]) > $max_solde_12) { $max_solde_12 = number_format(abs($article_CA["ventes_12"][$i]), $TARIFS_NB_DECIMALES, ".", ""	);}
	$solde_12[] = $article_CA["ventes_12"][$i];
}

$max_solde_12 = max_valeur ($max_solde_12);
$degrader_12 = rainbowDegrader(12, array('240','191','58'), array('0','74','153'));
$degrader_12_pos = rainbowDegrader(12, array('240','191','58'), array('0','74','153'));
$degrader_12_neg = rainbowDegrader(12, array('58','240','191'), array('153','74','0'));

//fin des stats


//infos pour mini moteur de recherche contact
$profils_mini = array();
foreach ($_SESSION['profils'] as $profil) {
	if ($profil->getActif() != 1) { continue; }
	$profils_mini[] = $profil;
}
unset ($profil);
// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_catalogue_articles_view_categ_caract.inc.php");

?>