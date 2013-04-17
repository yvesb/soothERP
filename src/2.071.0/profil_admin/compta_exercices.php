<?php
// *************************************************************************************************************
// ACCUEIL GESTION DES EXERCICES
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");


$compta_e = new compta_exercices ();

$compta_e->check_exercice();

//chargement des exercices
$liste_exercices	= $compta_e->charger_compta_exercices();


// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_compta_exercices.inc.php");

?>