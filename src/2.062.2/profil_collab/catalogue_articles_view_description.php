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

//liste des grille tarifs
$tarifs_liste	= array();
$tarifs_liste = get_tarifs_listes_formules ($article->getRef_art_categ ());
$liste_tarifs = $article->getTarifs ();
$tva_article = $article->getTva();

$mode_taxation = "TTC";
$aff_taxation = (1+$tva_article/100);
if (isset($_REQUEST["aff_ht"])) {
	$aff_taxation = 1;
	$mode_taxation = "HT";
}

$tarif_affiche = 0;
//tarif affiché
foreach ($tarifs_liste as $tarif_liste) {
	if ($tarif_liste->id_tarif == $_SESSION['magasin']->getId_tarif()) {
		foreach ($liste_tarifs as $tarifs) {
			if ($tarif_liste->id_tarif == $tarifs->id_tarif) {
			$tarif_affiche = $tarifs->pu_ht*$aff_taxation ;
			break;
			}
		}
	}
}
	

if (isset($_REQUEST["id_tarif"])) {
	foreach ($liste_tarifs as $tarifs) {
		if ($_REQUEST["id_tarif"] == $tarifs->id_tarif) {
			$tarif_affiche = $tarifs->pu_ht*$aff_taxation ;
			break;
		}
	}
}
if (isset($_REQUEST["autre_prix"])) {
	$tarif_affiche = $_REQUEST["autre_prix"];
}

//chargement des images
$images	=	$article->getImages();
// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_catalogue_articles_view_description.inc.php");

?>