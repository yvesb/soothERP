<?php
// *************************************************************************************************************
// ACCUEIL DE L'UTILISATEUR ADMINISTRATEUR
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");


	$id_niveau_relance	= $_REQUEST["id_niveau_relance"];
	$lib_niveau_relance	=	$_REQUEST["lib_niveau_relance_".$_REQUEST["id_niveau_relance"]];
	$delai_before_next	=	$_REQUEST["delai_before_next_".$_REQUEST["id_niveau_relance"]];
	$id_edition_mode	=	$_REQUEST["id_edition_mode_".$_REQUEST["id_niveau_relance"]];
	$actif = 0;
	if (isset($_REQUEST["actif_".$_REQUEST["id_niveau_relance"]])) {$actif	=	1;}
	$impression = 0;
	if (isset($_REQUEST["impression_".$_REQUEST["id_niveau_relance"]])) {$impression	=	1;}
	
//ouverture de la class facture_niveaux_relances
	$fact_n_r = new facture_niveau_relance ($id_niveau_relance);
	//maj du niveau de relance
	$fact_n_r->maj_relance ($lib_niveau_relance, $delai_before_next, $id_edition_mode, $actif, $impression);

// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_annuaire_gestion_factures_n_relances_mod.inc.php");

?>