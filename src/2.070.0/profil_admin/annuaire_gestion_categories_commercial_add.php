<?php
// *************************************************************************************************************
// GESTION DES CATEGORIES DE COMMERCIAUX
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");

// chargement de la class du profil
contact::load_profil_class($COMMERCIAL_ID_PROFIL);
// Préparations des variables 

	$infos	=	array();
	$infos['id_commission_regle']				=	$_REQUEST["categ_id_commission_regle"];
	$infos['lib_commercial_categ']	=	$_REQUEST["lib_commercial_categ"];
	//création de la catégorie
	contact_commercial::create_commerciaux_categories ($infos);

// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_annuaire_gestion_categories_commercial_add.inc.php");

?>