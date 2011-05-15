<?php
// *************************************************************************************************************
// ACCUEIL COMPTA automatique TIERS ACHAT (catégories de fournisseurs)
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");



if (!$_SESSION['user']->check_permission ("13")) {
	//on indique l'interdiction et on stop le script
	echo "<br /><span style=\"font-weight:bolder;color:#FF0000;\">Vos droits  d'accés ne vous permettent pas de visualiser ce type de page</span>";
	exit();
}


include_once ($CONFIG_DIR."profil_fournisseur.config.php");
// chargement de la class du profil
contact::load_profil_class($FOURNISSEUR_ID_PROFIL);
// Préparations des variables d'affichage
$liste_categories = contact_fournisseur::charger_fournisseurs_categories ();

// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_compta_automatique_tiers_achat.inc.php");

?>