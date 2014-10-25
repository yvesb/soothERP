<?php
// *************************************************************************************************************
// CONFIG DE RECHERCHE COM STOCK
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");

$liste_recherche=charge_recherche_type("5");
$parent='com_stock';
$idtype='5';
$titre='de documents commerciaux - Stock';

// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_recherche.inc.php");

?>