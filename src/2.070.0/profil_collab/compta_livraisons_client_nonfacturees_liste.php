<?php
// *************************************************************************************************************
// LIVRAISONS CLIENTS NON FACTUREES
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");

//chargement des livraisons non facturées
$livraisons = array();
$order = "";
if (isset($_REQUEST['orderorder']) && isset($_REQUEST['orderby']) && $_REQUEST['orderorder'] != "" && $_REQUEST['orderby'] != "") {
$order = $_REQUEST['orderby']." ".$_REQUEST['orderorder'];
}

$stocks_liste	= fetch_all_stocks();

if (isset($_SESSION['stocks'][$_REQUEST['id_stock']])) {
$stocks = $_SESSION['stocks'][$_REQUEST['id_stock']];
} else {
$stocks = new stock(0, $stocks_liste[$_REQUEST['id_stock']]);
}



$livraisons = get_livraisons_to_facture ($_REQUEST['id_stock'], $order);
// *************************************************************************************************************
// AFFICHAGE
// -*************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_compta_livraisons_client_nonfacturees_liste.inc.php");

?>