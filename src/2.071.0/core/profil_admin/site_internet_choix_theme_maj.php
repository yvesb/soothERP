<?php
// ***********************************************
// CONFIG DES INTERFACES - THEMES
// ***********************************************
require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");
// AFFICHAGE
include ($DIR.$_SESSION['theme']->getDir_theme()."page_site_internet_choix_theme_maj.php");
?>