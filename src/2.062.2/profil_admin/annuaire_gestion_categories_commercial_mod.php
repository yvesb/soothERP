<?php
// *************************************************************************************************************
// Gestion catégories commercial
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");

// Fichier de configuration de ce profil
include_once ($CONFIG_DIR."profil_commercial.config.php");

// chargement de la class du profil
contact::load_profil_class($COMMERCIAL_ID_PROFIL);
// Préparations des variables 

	$infos	=	array();
	$infos['id_commercial_categ']				=	$_REQUEST["id_commercial_categ"];
	$infos['id_commission_regle']				=	$_REQUEST["categ_id_commission_regle_".$_REQUEST["id_commercial_categ"]];
	$infos['lib_commercial_categ']	=	$_REQUEST["lib_commercial_categ_".$_REQUEST["id_commercial_categ"]];
	//création de la catégorie
	contact_commercial::maj_infos_commerciaux_categories ($infos);

	//Mise à jour de la catégorie  par defaut
	if (isset($_REQUEST['defaut_commercial_categ_'.$_REQUEST['id_commercial_categ']]) && $_REQUEST['id_commercial_categ'] != $DEFAUT_ID_COMMERCIAL_CATEG) {
		maj_configuration_file ("profil_commercial.config.php", "maj_line", "\$DEFAUT_ID_COMMERCIAL_CATEG =", "\$DEFAUT_ID_COMMERCIAL_CATEG = ".$_REQUEST['id_commercial_categ']."; ", $CONFIG_DIR);
	}
// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_annuaire_gestion_categories_commercial_mod.inc.php");

?>