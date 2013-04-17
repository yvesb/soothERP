<?php
// *************************************************************************************************************
// ACCUEIL GESTION PLAN COMPTABLE ENTREPRISE
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");


//chargement des comptes du plan comptable
$comptes_plan_general	= compta_plan_general::charger_comptes_plan_general(1);

// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_compta_plan_entreprise.inc.php");

?>