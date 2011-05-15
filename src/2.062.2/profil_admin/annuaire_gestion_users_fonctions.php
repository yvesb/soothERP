<?php
// *************************************************************************************************************
// GESTION DES ROLES DES COLLABORATEURS
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");
require ($DIR.$_SESSION['theme']->getDir_theme()."_theme.config.php" );

// Préparations des variables d'affichage
$liste_fonctions = charger_fonctions ($COLLAB_ID_PROFIL);
$liste_permissions = charger_permissions ($COLLAB_ID_PROFIL);

	
// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_annuaire_gestion_users_fonctions.inc.php");

?>