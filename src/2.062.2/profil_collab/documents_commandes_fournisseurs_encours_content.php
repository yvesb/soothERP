<?php
// *************************************************************************************************************
// COMMANDES FOURNISSEURS EN COURS
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");

$stock_vu = "";
if ($_REQUEST["id_stock"]) {$stock_vu = $_REQUEST["id_stock"];}
//chargement des commandes en cours
$commandes = array();
$commandes = get_commandes_fournisseurs ($stock_vu);



// *************************************************************************************************************
// AFFICHAGE
// -*************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_documents_commandes_fournisseurs_encours_content.inc.php");

?>