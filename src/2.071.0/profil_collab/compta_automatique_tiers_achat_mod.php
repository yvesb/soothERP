<?php
// *************************************************************************************************************
// Modification d'un compte de catégorie de fournisseur
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");

// Fichier de configuration de ce profil
include_once ($CONFIG_DIR."profil_fournisseur.config.php");

// chargement de la class du profil
contact::load_profil_class($FOURNISSEUR_ID_PROFIL);


if (isset($_REQUEST["id_fournisseur_categ"])) {

	$infos	=	array();
	$infos['id_fournisseur_categ']				=	$_REQUEST["id_fournisseur_categ"];
	$infos['defaut_numero_compte']				=	$_REQUEST["retour_value"];
	//création de la catégorie
	contact_fournisseur::maj_defaut_numero_compte_categories ($infos);

}
?>