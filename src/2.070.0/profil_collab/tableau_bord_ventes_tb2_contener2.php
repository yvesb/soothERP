<?php
// *************************************************************************************************************
// Tableau de bord des ventes analyse ca
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");
require ($DIR.$_SESSION['theme']->getDir_theme()."_theme.config.php" );

$date_debut = date_FR_to_Us($_REQUEST["date_debut"]);
$date_fin = date_FR_to_Us($_REQUEST["date_fin"]);

$CA_global = charger_doc_CA (array($date_debut." 00:00:00" , $date_fin." 23:59:59" ));

// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_tableau_bord_ventes_tb2_contener2.inc.php");

?>