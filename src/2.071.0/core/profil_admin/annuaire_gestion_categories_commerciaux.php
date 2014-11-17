<?php

//  ******************************************************
// ACCUEIL DE L'UTILISATEUR ADMINISTRATEUR
//  ******************************************************
require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR . "_session.inc.php");

include_once ($CONFIG_DIR . "profil_commercial.config.php");
// chargement de la class du profil
contact::load_profil_class($COMMERCIAL_ID_PROFIL);
// Préparations des variables d'affichage
$liste_categories = contact_commercial::charger_commerciaux_categories();

//  ******************************************************
// AFFICHAGE
//  ******************************************************

include ($DIR . $_SESSION['theme']->getDir_theme() . "page_annuaire_gestion_categories_commercial.inc.php");
?>