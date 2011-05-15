<?php
// *************************************************************************************************************
// ACCUEIL DE L'UTILISATEUR ADMINISTRATEUR
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");


// Controle

	if (!isset($_REQUEST['ref_art_categ_'.$_REQUEST["n_liste"]])) {
		echo "La référence de la catégorie n'est pas précisée";
		exit;
	}
	
	$art_categ = new art_categ ($_REQUEST['ref_art_categ_'.$_REQUEST["n_liste"]]);
	if (!$art_categ->getRef_art_categ()) {
		echo "La référence de la catégorie est inconnue";		exit;

	}

$indice_qte =	$_REQUEST["indice_qte_".$_REQUEST["n_liste"]];
$id_tarif	=	$_REQUEST["id_tarif_".$_REQUEST["n_liste"]];
 	$art_categ -> delete_formule_tarif ($id_tarif, $indice_qte);
	
	
	


$tarifs_liste	= array();
$tarifs_liste = get_full_tarifs_listes ();
	
$reset_formule	=	$tarifs_liste[0]->marge_moyenne;
//********************************************************************************************************
// AFFICHAGE
//********************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_catalogue_categorie_tarifs_sup.inc.php");

?>