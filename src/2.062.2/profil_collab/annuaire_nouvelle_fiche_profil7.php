<?php
// *************************************************************************************************************
// PROFIL COMMERCIAL
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");


//chargement des catégories de commerciaux
if ($COMMERCIAL_ID_PROFIL != 0) {
	include ($CONFIG_DIR."profil_".$_SESSION['profils'][$COMMERCIAL_ID_PROFIL]->getCode_profil().".config.php"); 
	contact::load_profil_class($COMMERCIAL_ID_PROFIL);
	$liste_categories_commercial = contact_commercial::charger_commerciaux_categories ();
	$liste_commissions_regles = contact_commercial::charger_commissions_regles ();
}

// *************************************************************************************************************
// AFFICHAGE
// -*************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_annuaire_nouvelle_fiche_profil7.inc.php");

?>