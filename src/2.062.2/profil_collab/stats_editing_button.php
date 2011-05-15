<?php
// *************************************************************************************************************
// AAFFICHAGE DE L'EDITION D'UN DOCUMENT (partie boutons)
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");


//chargement des modes d'édition
$editions_modes	= liste_mode_edition();

$liste_modeles_pdf_valides = charge_modele_pdf_stats ();

$filigrane_pdf = charger_filigranes ();

// *************************************************************************************************************
// AFFICHAGE
// -*************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_stats_editing_button.inc.php");

?>