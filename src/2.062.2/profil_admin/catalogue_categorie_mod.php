<?php
// *************************************************************************************************************
// MODIFICATION D'UNE CATEGORIE D'ARTICLE
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");


if (isset($_REQUEST['ref_art_categ'])) {	
	// *************************************************
	// Controle des données fournies par le formulaire

	
	$lib_art_categ				= $_REQUEST['lib_art_categ'];
	$modele 							= $_REQUEST['modele'];
	$desc_art_categ				= $_REQUEST['desc_art_categ'];
	$ref_art_categ_parent	=	$_REQUEST['ref_art_categ_parent'];
	$defaut_id_tva				=	$_REQUEST['defaut_id_tva'];
	$duree_dispo_an				=	$_REQUEST['duree_dispo_an'];
	$duree_dispo_mois				=	$_REQUEST['duree_dispo_mois'];
	$duree_dispo_jour				=	$_REQUEST['duree_dispo_jour'];

	$duree_dispo = (($duree_dispo_an*365)+($duree_dispo_mois*30)+($duree_dispo_jour))*24*3600;
	
	// *************************************************
	// Création de la catégorie
	$art_categ = new art_categ ($_REQUEST['ref_art_categ']);
	$art_categ->modification ($lib_art_categ, $desc_art_categ, $ref_art_categ_parent, $modele, $defaut_id_tva, $duree_dispo);
	echo $art_categ->maj_restriction($_REQUEST['restriction']);
}

// *************************************************************************************************************
// AFFICHAGE
// -*************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_catalogue_categorie_mod.inc.php");

?>