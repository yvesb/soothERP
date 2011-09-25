<?php
// *************************************************************************************************************
// CONFIG DE RECHERCHE COM ACHAT
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");

$liste_recherche=charge_recherche_type("4");
$parent='com_achat';
$idtype='4';
$titre='de documents commerciaux - Achat';

// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_recherche.inc.php");

?>