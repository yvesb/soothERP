<?php
// *************************************************************************************************************
// ACCUEIL DE L'UTILISATEUR ADMINISTRATEUR
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");
require_once ($DIR."_article_liaisons_types.class.php");


if (isset($_REQUEST['id_liaison_type'])) {	
	// *************************************************
	// Controle des données fournies par le formulaire

	if (isset($_REQUEST['actif_'.$_REQUEST['id_liaison_type']]) || ( isset($_REQUEST['systeme_'.$_REQUEST['id_liaison_type']]) && $_REQUEST['systeme_'.$_REQUEST['id_liaison_type']] == "1")) {
	$actif						= 1;
	} else {
	$actif						= 0;
	}

	
	// *************************************************
	// Création de la catégorie
	$liaison_liste = new art_liaison_type ($_REQUEST['id_liaison_type']);
	$liaison_liste->modifier_actif ($actif);
}

// *************************************************************************************************************
// AFFICHAGE
// -*************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_catalogue_liaisons_mod.inc.php");

?>