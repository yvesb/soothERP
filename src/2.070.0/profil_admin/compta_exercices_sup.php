<?php
// *************************************************************************************************************
// SUPPRESSION D'UN EXERCICE
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");


//ouverture de la class exercice
$exercice = new compta_exercices($_REQUEST["id_exercice"]);

//modification de l'exercice
$exercice->suppression ();

// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_compta_exercices_sup.inc.php");

?>