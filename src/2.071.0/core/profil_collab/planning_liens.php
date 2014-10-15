<?php
// *************************************************************************************************************
// GESTION DES LIENS FAVORIS
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");


//chargement de la liste des favoris (de l'utilisateur en cours)
$liste_links = web_link::charger_web_link ();



// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_planning_liens.inc.php");

?>