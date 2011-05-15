<?php
// *************************************************************************************************************
// ACCUEIL DE L'UTILISATEUR ADMINISTRATEUR
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");


if (isset($_REQUEST['id_magasin'])) {	
	// *************************************************
	// Controle des données fournies par le formulaire

	
	$lib_magasin					= $_REQUEST['lib_magasin_'.$_REQUEST['id_magasin']];
	$abrev_magasin				= $_REQUEST['abrev_magasin_'.$_REQUEST['id_magasin']];
	$id_mag_enseigne			= $_REQUEST['id_mag_enseigne_'.$_REQUEST['id_magasin']]; 
	$id_stock 						= $_REQUEST['id_stock_'.$_REQUEST['id_magasin']];
	$id_tarif 						= $_REQUEST['id_tarif_'.$_REQUEST['id_magasin']];
	$mode_vente 					= $_REQUEST['mode_vente_'.$_REQUEST['id_magasin']];
	if (isset($_REQUEST['actif_'.$_REQUEST['id_magasin']]) || $_REQUEST['id_magasin'] == $DEFAUT_ID_MAGASIN) {
		$actif						= 1;
	} else {
		$actif						= 0;
	}
	// *************************************************
	// Création de la catégorie
	$magasin_liste = new magasin ($_REQUEST['id_magasin']);
	$magasin_liste->modification ($lib_magasin, $abrev_magasin, $id_mag_enseigne, $id_stock, $id_tarif, $mode_vente, $actif);
	
	//Mise à jour du magasin par defaut
	if (isset($_REQUEST['defaut_magasin_'.$_REQUEST['id_magasin']]) && $_REQUEST['id_magasin'] != $DEFAUT_ID_MAGASIN && !isset($GLOBALS['_ALERTES']['last_active_magasin']) && $actif) {
		maj_configuration_file ("config_generale.inc.php", "maj_line", "\$DEFAUT_ID_MAGASIN	=", "\$DEFAUT_ID_MAGASIN	= ".$_REQUEST['id_magasin'].";			// Magasin par défaut", $CONFIG_DIR);
	}
}

// *************************************************************************************************************
// AFFICHAGE
// -*************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_catalogue_magasins_mod.inc.php");

?>