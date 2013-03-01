<?php
// *************************************************************************************************************
// Ajout de zone de livraisons
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");


$id_livraison_mode 	= $_REQUEST["id_livraison_mode"];
$base_calcul 					= $_REQUEST["base_calcul_".$id_livraison_mode];
$liste_cost = array();
$liste_cost_exist = array();
foreach ($_REQUEST as $key=>$value) {
	if (substr ($key, 0, 11) != "indice_min_") {continue;}
	if (!is_numeric($value) ) {continue;}
	if (in_array($value, $liste_cost_exist ) ) {continue;}
	$id_request = str_replace("indice_min_", "", $key);
	$cost = new stdclass;
	$cost->indice_min = $_REQUEST["indice_min_".$id_request];
	$fixe = $_REQUEST["fixe_".$id_request];
	if (!is_numeric($fixe)) {$fixe = 0;}
	$variab = $_REQUEST["variab_".$id_request];
	if (!is_numeric($variab) || $base_calcul == "PRIX") {$variab = 0;}
	$cost->formule = $fixe."+".$variab;
	if (isset($_REQUEST["nd_".$id_request])) {	$cost->formule = "-1+-1";}
	$liste_cost[] = $cost;
	$liste_cost_exist[] = $_REQUEST["indice_min_".$id_request];
}

$livraison_mode = new livraison_modes($id_livraison_mode);
$livraison_mode->create_cost($base_calcul, $liste_cost);


// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_livraison_modes_cost_mod.inc.php");

?>