<?php
// *************************************************************************************************************
// MODIFICATION D'UN EXERCICE
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");


//ouverture de la class exercice
$exercice = new compta_exercices($_REQUEST["id_exercice"]);

//modification de l'exercice
$exercice->maj_exercice ($_REQUEST["lib_exercice_".$_REQUEST["id_exercice"]] , date_Fr_to_Us($_REQUEST["date_fin_".$_REQUEST["id_exercice"]]));

// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_compta_exercices_mod.inc.php");

?>