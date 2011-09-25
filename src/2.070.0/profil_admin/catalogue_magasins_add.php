<?php
// *************************************************************************************************************
// ACCUEIL DE L'UTILISATEUR ADMINISTRATEUR
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");


if (isset($_REQUEST['ajout_magasin'])) {	
	// *************************************************
	// Controle des données fournies par le formulaire

	
	$lib_magasin					= $_REQUEST['lib_magasin'];
	$abrev_magasin				= $_REQUEST['abrev_magasin']; 
	$id_mag_enseigne			= $_REQUEST['id_mag_enseigne']; 
	$id_stock 						= $_REQUEST['id_stock'];
	$id_tarif 						= $_REQUEST['id_tarif'];
	$mode_vente 					= $_REQUEST['mode_vente'];
	if (isset($_REQUEST['actif'])) {
	$actif						= 1;
	} else {
	$actif						= 0;
	}

	
	// *************************************************
	// Création de la catégorie
	$magasin_liste = new magasin ();
	$magasin_liste->create ($lib_magasin, $abrev_magasin, $id_mag_enseigne, $id_stock, $id_tarif, $mode_vente, $actif);
}

// *************************************************************************************************************
// AFFICHAGE
// -*************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_catalogue_magasins_add.inc.php");

?>