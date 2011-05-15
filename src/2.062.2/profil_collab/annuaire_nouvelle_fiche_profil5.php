<?php
// *************************************************************************************************************
// PROFIL FOURNISSEUR
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");


//chargement des infos de fournisseurs
if ($FOURNISSEUR_ID_PROFIL != 0) {
	include ($CONFIG_DIR."profil_".$_SESSION['profils'][$FOURNISSEUR_ID_PROFIL]->getCode_profil().".config.php"); 
	contact::load_profil_class($FOURNISSEUR_ID_PROFIL);
	$liste_categories_fournisseur = contact_fournisseur::charger_fournisseurs_categories ();
}

//liste des lieux de stockage
$stocks_liste	= array();
$stocks_liste = $_SESSION['stocks'];

// *************************************************************************************************************
// AFFICHAGE
// -*************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_annuaire_nouvelle_fiche_profil5.inc.php");

?>