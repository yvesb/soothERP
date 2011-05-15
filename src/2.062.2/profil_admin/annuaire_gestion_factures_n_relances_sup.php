<?php
// *************************************************************************************************************
// ACCUEIL DE L'UTILISATEUR ADMINISTRATEUR
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");


	$id_niveau_relance	= $_REQUEST["id_niveau_relance"];
//ouverture de la class facture_niveaux_relances
	$fact_n_r = new facture_niveau_relance ($id_niveau_relance);
	//maj du niveau de relance
	$fact_n_r->suppression ();

// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_annuaire_gestion_factures_n_relances_sup.inc.php");

?>