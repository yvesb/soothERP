<?php
// *************************************************************************************************************
// GESTION DES EVENEMENTS
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");

// Préparations des variables d'affichage
$liste_types_evenements = contact::charger_types_evenements();

// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_annuaire_gestion_evenements_contact.inc.php");

?>