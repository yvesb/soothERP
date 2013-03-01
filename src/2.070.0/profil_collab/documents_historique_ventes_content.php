<?php
// *************************************************************************************************************
// HISTORIQUE DES VENTES
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");

//chargement des commandes en cours
$search['page_to_show'] = 1;
if (isset($_REQUEST['page_to_show'])) {
	$search['page_to_show'] = $_REQUEST['page_to_show'];
}
$search['date_debut'] = "";
if (isset($_REQUEST['date_debut'])) {
	$search['date_debut'] = $_REQUEST['date_debut'];
}
$search['date_fin'] = "";
if (isset($_REQUEST['date_fin'])) {
	$search['date_fin'] = $_REQUEST['date_fin'];
}
$search['type_values'] = "FAC";
if (isset($_REQUEST['type_values'])) {
	$search['type_values'] = $_REQUEST['type_values'];
}



$fiches_par_page = $DOCUMENT_RECHERCHE_SHOWED_FICHES;

$histo_ventes = array();
$histo_ventes = get_historique_ventes ($_REQUEST["id_stock"], $search['page_to_show'], $fiches_par_page, $search['date_debut'], $search['date_fin'], $search['type_values']);

$stock_vu = $_REQUEST["id_stock"];
// *************************************************************************************************************
// AFFICHAGE
// -*************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_documents_historique_ventes_content.inc.php");

?>