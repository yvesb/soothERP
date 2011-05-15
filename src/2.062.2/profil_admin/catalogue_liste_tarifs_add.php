<?php
// *************************************************************************************************************
// ACCUEIL DE L'UTILISATEUR ADMINISTRATEUR
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");


if (isset($_REQUEST['ajout_tarif'])) {	
	// *************************************************
	// Controle des données fournies par le formulaire

	
	$lib_tarif						= $_REQUEST['lib_tarif'];
	$desc_tarif 					= $_REQUEST['desc_tarif'];
	$marge_moyenne						= $_REQUEST['marge_moyenne'];

	
	// *************************************************
	// Création de la catégorie
	$tarif_liste = new tarif_liste ();
	$tarif_liste->create ($lib_tarif, $desc_tarif, $marge_moyenne);
}

// *************************************************************************************************************
// AFFICHAGE
// -*************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_catalogue_liste_tarifs_add.inc.php");

?>