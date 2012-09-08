<?php
// *************************************************************************************************************
// ACCUEIL DE L'UTILISATEUR ADMINISTRATEUR
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");

// Fichier de configuration de ce profil
include_once ($CONFIG_DIR."profil_client.config.php");
// chargement de la class du profil
contact::load_profil_class($CLIENT_ID_PROFIL);
// Préparations des variables 
//_vardump($_REQUEST);

	$infos	=	array();
	$infos['id_client_categ']			=	$_REQUEST["id_client_categ"];
	$infos['id_tarif']					=	$_REQUEST["id_tarif_".$_REQUEST["id_client_categ"]];
	$infos['lib_client_categ']			=	$_REQUEST["lib_client_categ_".$_REQUEST["id_client_categ"]];
	$infos['ref_commercial']			=	$_REQUEST["ref_commercial_".$_REQUEST["id_client_categ"]];
	$infos['facturation_periodique']	=	$_REQUEST["facturation_periodique_".$_REQUEST["id_client_categ"]];
	$infos['delai_reglement']			=	$_REQUEST["delai_reglement_".$_REQUEST["id_client_categ"]];
	if(isset($_REQUEST["delai_reglement_fdm_".$_REQUEST["id_client_categ"]])){
		$infos['delai_reglement']		.=	"FDM";
	}	
	$infos['note']						=	$_REQUEST["note_".$_REQUEST["id_client_categ"]];
	$infos['defaut_encours']			= 	$_REQUEST["defaut_encours_".$_REQUEST["id_client_categ"]];	
	$infos['nom_commercial']			=	$_REQUEST["nom_commercial_".$_REQUEST["id_client_categ"]];
	$infos['prepaiement_type']			= 	$_REQUEST["prepaiement_type_".$_REQUEST["id_client_categ"]];
	$infos['prepaiement_ratio']			= 	$_REQUEST["prepaiement_ratio_".$_REQUEST["id_client_categ"]];
	$infos['reglement_mode_favori']		= 	$_REQUEST["reglement_mode_favori_".$_REQUEST["id_client_categ"]];
	$infos['edition_mode_favori']		= 	$_REQUEST["edition_mode_favori_".$_REQUEST["id_client_categ"]];
	$infos['cycle_relance']				= 	$_REQUEST["cycle_relance_".$_REQUEST["id_client_categ"]];

	//création de la catégorie
	_vardump($infos);
	contact_client::maj_client_categorie ($infos);

	//Mise à jour de la catégorie  par defaut
	if (isset($_REQUEST["defaut_client_categ_".$_REQUEST["id_client_categ"]]) && $_REQUEST['id_client_categ'] != $DEFAUT_ID_CLIENT_CATEG) {
		maj_configuration_file ("profil_client.config.php", "maj_line", "\$DEFAUT_ID_CLIENT_CATEG	= ", "\$DEFAUT_ID_CLIENT_CATEG	= ".$_REQUEST['id_client_categ']."; ", $CONFIG_DIR);
	}
// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_annuaire_gestion_categories_client_mod.inc.php");

?>