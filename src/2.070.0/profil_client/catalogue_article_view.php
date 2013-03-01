<?php
// *************************************************************************************************************
// CATALOGUE CLIENT
// *************************************************************************************************************


require("_dir.inc.php");
require ("_profil.inc.php");
require ("_session.inc.php");



gestion_panier();
$catalogue = new catalogue_client($ID_CATALOGUE_INTERFACE);


$app_tarifs_s = $_SESSION["panier_interface_".$_INTERFACE['ID_INTERFACE']]["app_tarifs"];
//liste des sous-categories du catalogue_dir actuel
$catalogue_client_dir_parents = array();
if (isset($_REQUEST["id_catalogue_client_dir"])) {
$catalogue_client_dir_parents = $catalogue->charger_catalogue_client_dirs_parents ($_REQUEST["id_catalogue_client_dir"]);
}

$id_tarif = "";


//récup de l'id_tarif du client
if ($_SESSION['user']->getRef_contact ()) {
	$contact = new contact($_SESSION['user']->getRef_contact ());
	$profils 	= $contact->getProfils();
	if (isset($profils[$CLIENT_ID_PROFIL])) {
		$id_tarif = $profils[$CLIENT_ID_PROFIL]->getId_tarif ();
	}
}

if (!$id_tarif) {
	$id_tarif = $_SESSION['magasins'][$ID_MAGASIN]->getId_tarif();
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

//chargement des caractéristiques
$art_caracs	=	$article->getCaracs();

$liaisons	=	$article->getLiaisons ();
//chargement des images
$images	=	$article->getImages();

//ouverture du panier
$liste_contenu = $_SESSION["panier_interface_".$_INTERFACE['ID_INTERFACE']]["contenu"];
// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_catalogue_article_view.inc.php");

?>