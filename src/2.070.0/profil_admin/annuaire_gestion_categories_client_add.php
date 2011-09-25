<?php
// *************************************************************************************************************
// ACCUEIL DE L'UTILISATEUR ADMINISTRATEUR
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");

// chargement de la class du profil
contact::load_profil_class($CLIENT_ID_PROFIL);
// Préparations des variables 
	//_vardump($_REQUEST);
	$infos	=	array();
	$infos['id_tarif']					=	$_REQUEST["id_tarif"];
	$infos['lib_client_categ']			=	$_REQUEST["lib_client_categ"];
	$infos['ref_commercial']			=	$_REQUEST["ref_commercial"];
	$infos['facturation_periodique']	=	$_REQUEST["facturation_periodique"];
	$infos['delai_reglement']			=	$_REQUEST["delai_reglement"];
	if(isset($_REQUEST["delai_reglement_fdm"])){
		$infos['delai_reglement']		.=	"FDM";
	}	
	$infos['note']						=	$_REQUEST["note"];
	$infos['defaut_encours']			= 	$_REQUEST["defaut_encours"];	
	$infos['nom_commercial']			=	$_REQUEST["nom_commercial"];
	$infos['prepaiement_type']			= 	$_REQUEST["prepaiement_type"];
	$infos['prepaiement_ratio']			= 	$_REQUEST["prepaiement_ratio"];
	$infos['reglement_mode_favori']		= 	$_REQUEST["reglement_mode_favori"];
	$infos['edition_mode_favori']		= 	$_REQUEST["edition_mode_favori"];
	$infos['cycle_relance']				= 	$_REQUEST["cycle_relance"];
	//création de la catégorie
	//_vardump($infos);
	contact_client::create_client_categorie ($infos);

// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************
include ($DIR.$_SESSION['theme']->getDir_theme()."page_annuaire_gestion_categories_client_add.inc.php");

?>