<?php
// *************************************************************************************************************
// ACCUEIL DE L'UTILISATEUR ADMINISTRATEUR
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");


//ouverture de la class facture_niveaux_relances
	$fact_n_r = new facture_niveau_relance ();

	$id_client_categ		=	$_REQUEST["id_client_categ"];
	$lib_niveau_relance	=	$_REQUEST["lib_niveau_relance"];
	$delai_before_next	=	$_REQUEST["delai_before_next"];
	$id_edition_mode		=	$_REQUEST["id_edition_mode"];
	$id_courrier_joint	=	$_REQUEST["id_courrier_joint"];
	$impression = 0;
	if (isset($_REQUEST["impression"])) {$impression	=	1;}
	
	//création du niveau de relance
	$fact_n_r->create_niveau_relance ($id_client_categ, $lib_niveau_relance, $delai_before_next, $id_edition_mode, $id_courrier_joint, $impression);

// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_annuaire_gestion_factures_n_relances_add.inc.php");

?>