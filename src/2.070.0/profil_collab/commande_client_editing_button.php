<?php
// *************************************************************************************************************
// AAFFICHAGE DES COMMANDES CLIENTS (partie boutons)
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");


//chargement des modes d'édition
$editions_modes	= liste_mode_edition();

$liste_modeles_pdf_valides = charge_modele_pdf_commande_client ();

$filigrane_pdf = charger_filigranes ();

// *************************************************************************************************************
// AFFICHAGE
// -*************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_commande_client_editing_button.inc.php");

?>