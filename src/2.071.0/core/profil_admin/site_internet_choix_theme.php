<?php
// *********************************************
// CONFIG DES INTERFACES - THEMES
// *********************************************
require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR . "_session.inc.php");

$interfaces			 = array();
$liste_interfaces	 = charger_all_interfaces();

// CONFIG DES DONNEES d'affichage
// Variables nÚcessaires Ó l'affichage
$page_variables = array();
check_page_variables($page_variables);

// AFFICHAGE
include ($DIR . $_SESSION['theme']->getDir_theme() . "page_site_internet_choix_theme.php");
?>