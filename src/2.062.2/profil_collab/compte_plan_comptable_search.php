<?php
// *************************************************************************************************************
// RECHERCHE POUR MODIFICATION DU NUMERO DE COMPTE D'UNE CATEG ARTICLE
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");



// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************
$form['indent'] = $search['indent'] = "indent";
if (isset($_REQUEST['indent'])) {
	$form['indent'] = $_REQUEST['indent'];
	$search['indent'] = $_REQUEST['indent'];
}

$form['cible_id'] = $search['cible_id'] = "";
if (isset($_REQUEST['cible_id'])) {
	$form['cible_id'] = $_REQUEST['cible_id'];
	$search['cible_id'] = $_REQUEST['cible_id'];
}

$form['type'] = $search['type'] = "";
if (isset($_REQUEST['type'])) {
	$form['type'] = $_REQUEST['type'];
	$search['type'] = $_REQUEST['type'];
}

$form['retour_value_id'] = $search['retour_value_id'] = "";
if (isset($_REQUEST['retour_value_id'])) {
	$form['retour_value_id'] = $_REQUEST['retour_value_id'];
	$search['retour_value_id'] = $_REQUEST['retour_value_id'];
}
$form['retour_lib_id'] = $search['retour_lib_id'] = "";
if (isset($_REQUEST['retour_lib_id'])) {
	$form['retour_lib_id'] = $_REQUEST['retour_lib_id'];
	$search['retour_lib_id'] = $_REQUEST['retour_lib_id'];
}

include ($DIR.$_SESSION['theme']->getDir_theme()."page_compte_plan_comptable_search.inc.php");

?>