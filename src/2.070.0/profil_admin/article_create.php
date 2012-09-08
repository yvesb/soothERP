<?php
// *************************************************************************************************************
// [ADMINISTRATEUR] CREATION D'UN ARTICLE
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");


$articles_categories = get_articles_categories ();

	$ARTICLES_DEFAULT_VALUES = get_articles_default_values();

if (isset($_REQUEST['create'])) {	
	// *************************************************
	// Controle des données fournies par le formulaire
	if (!isset($_REQUEST['lib_article'])) {
		$erreur = "Une variable nécessaire à la création de l'article n'est pas précisée.";
		alerte_dev($erreur);
	}

	$infos_generales['ref_oem'] 		= $_REQUEST['ref_oem'];
	$infos_generales['ref_interne'] = $_REQUEST['ref_interne'];
	$infos_generales['lib_article'] = $_REQUEST['lib_article'];
	$infos_generales['lib_ticket'] 	= $_REQUEST['lib_ticket'];
	$infos_generales['desc_courte'] = $_REQUEST['desc_courte'];
	$infos_generales['desc_longue'] = $_REQUEST['desc_longue'];
	$infos_generales['ref_art_categ'] = $_REQUEST['ref_art_categ'];
	$infos_generales['ref_constructeur'] 	= $_REQUEST['ref_constructeur'];
	$infos_generales['prix_public_ht'] 		= $_REQUEST['prix_public_ht'];
	$infos_generales['id_valo'] 	= $_REQUEST['id_valo'];
	$infos_generales['valo_indice'] 	= $_REQUEST['valo_indice'];
	$infos_generales['lot'] 					= $_REQUEST['lot'];
	$infos_generales['composant']			= $_REQUEST['composant'];
	$infos_generales['variante']			= $_REQUEST['variante'];
	$infos_generales['gestion_sn']		= $_REQUEST['gestion_sn'];
	$infos_generales['date_debut_dispo']	= $_REQUEST['date_debut_dispo'];
	$infos_generales['date_fin_dispo']		= $_REQUEST['date_fin_dispo'];
	$infos_generales['gestion_sn']		= $_REQUEST['gestion_sn'];

	$infos_modele = array();
	include_once ("./modele_create_".$_REQUEST['code_modele'].".inc.php");
	
	// *************************************************
	// Création de l'article
	$article = new article ();
	$article->create ($infos_generales, $infos_modele);
}


// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_article_create.inc.php");

?>