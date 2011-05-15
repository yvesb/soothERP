<?php
// *************************************************************************************************************
// ACCUEIL DE L'UTILISATEUR ADMINISTRATEUR
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");

// Fichier de configuration de ce profil
include_once ($CONFIG_DIR."profil_fournisseur.config.php");

// chargement de la class du profil
contact::load_profil_class($FOURNISSEUR_ID_PROFIL);
// Préparations des variables 

	$infos	=	array();
	$infos['id_fournisseur_categ']				=	$_REQUEST["id_fournisseur_categ"];
	$infos['note']				=	$_REQUEST["note_".$_REQUEST["id_fournisseur_categ"]];
	$infos['lib_fournisseur_categ']	=	$_REQUEST["lib_fournisseur_categ_".$_REQUEST["id_fournisseur_categ"]];
	//création de la catégorie
	contact_fournisseur::maj_infos_fournisseurs_categories ($infos);

	//Mise à jour de la catégorie  par defaut
	if (isset($_REQUEST['defaut_fournisseur_categ_'.$_REQUEST['id_fournisseur_categ']]) && $_REQUEST['id_fournisseur_categ'] != $DEFAUT_ID_FOURNISSEUR_CATEG) {
		maj_configuration_file ("profil_fournisseur.config.php", "maj_line", "\$DEFAUT_ID_FOURNISSEUR_CATEG =", "\$DEFAUT_ID_FOURNISSEUR_CATEG = ".$_REQUEST['id_fournisseur_categ']."; ", $CONFIG_DIR);
	}
// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_annuaire_gestion_categories_fournisseur_mod.inc.php");

?>