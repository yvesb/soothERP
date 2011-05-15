<?php
// *************************************************************************************************************
// AJOUT D'UNE CATEGORIE 
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");


if (isset($_REQUEST['create_art_categs'])) {	
	// *************************************************
	// Controle des données fournies par le formulaire

	
	$ref_art_categ				= $_REQUEST['ref_art_categ'];
	$lib_art_categ				= $_REQUEST['lib_art_categ'];
	$modele 							= $_REQUEST['modele'];
	$desc_art_categ				= $_REQUEST['desc_art_categ'];
	$ref_art_categ_parent	=	$_REQUEST['ref_art_categ_parent'];
	$defaut_id_tva				=	$_REQUEST['defaut_id_tva'];
	$duree_dispo_an				=	$_REQUEST['duree_dispo_an'];
	$duree_dispo_mois			=	$_REQUEST['duree_dispo_mois'];
	$duree_dispo_jour			=	$_REQUEST['duree_dispo_jour'];

	$duree_dispo = (($duree_dispo_an*365)+($duree_dispo_mois*30)+($duree_dispo_jour))*24*3600;


	
	// *************************************************
	// Création de la catégorie
	$art_categ = new art_categ ();
	$art_categ->create ($lib_art_categ, $desc_art_categ, $ref_art_categ_parent, $modele, $defaut_id_tva, $duree_dispo, $ref_art_categ);

	//indertion des groupes de carac
	foreach ($_REQUEST as $variable => $valeur) {
		if (substr ($variable, 0, 17) != "ref_carac_groupe_") { continue; }
		if (isset($_REQUEST['lib_carac_groupe_'.$valeur]) && isset($_REQUEST['ordre_carac_groupe_'.$valeur])) {
			$ref_carac_groupe	= $valeur;
			$lib_carac_groupe	= $_REQUEST['lib_carac_groupe_'.$valeur];
			$ordre	= $_REQUEST['ordre_carac_groupe_'.$valeur];
			$art_categ->create_carac_groupe ($lib_carac_groupe, $ordre, $ref_carac_groupe);
		}
	}
	
	// insertion des carac
	foreach ($_REQUEST as $variable => $valeur) {
		if (substr ($variable, 0, 11) != "ref_caracs_") { continue; }
		if (isset($_REQUEST['lib_carac_'.$valeur]) && isset($_REQUEST['unite_'.$valeur])) {
			$ref_carac	= $valeur;
			$lib_carac	= $_REQUEST['lib_carac_'.$valeur];
			$unite	= $_REQUEST['unite_'.$valeur];
			$allowed_values	= $_REQUEST['allowed_values_'.$valeur];
			$default_value	= $_REQUEST['default_value_'.$valeur];
			$moteur_recherche	= $_REQUEST['moteur_recherche_'.$valeur];
			if (isset($_REQUEST['variante_'.$valeur])) {
				$variante	= 1;
			}else{
				$variante	= 0;
			}
			$affichage	= $_REQUEST['affichage_'.$valeur];
			$ref_carac_groupe	= $_REQUEST['ref_carac_groupe_'.$valeur];
			$ordre	= $_REQUEST['ordre_carac_'.$valeur];
			$art_categ->create_carac ($lib_carac, $unite, $allowed_values, $default_value, $moteur_recherche, $variante, $affichage, $ref_carac_groupe, $ordre, $ref_carac);
		}
	}

}
// *************************************************************************************************************
// AFFICHAGE
// -*************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_serveur_import_catalogue_categorie_add.inc.php");

?>