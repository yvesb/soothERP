<?php
// *************************************************************************************************************
// CONFIG DE RECHERCHE COM VENTE
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");

$liste_recherche=charge_recherche_type("3");
$parent='com_vente';
$idtype='3';
$titre='de documents commerciaux - Vente';

// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_recherche.inc.php");

?>