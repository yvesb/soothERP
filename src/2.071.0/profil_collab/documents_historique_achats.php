<?php
// *************************************************************************************************************
// HISTORIQUE DES ACHATS
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");

//chargement des commandes en cours

$search['page_to_show'] = 1;
$fiches_par_page = $DOCUMENT_RECHERCHE_SHOWED_FICHES;

$histo_achats = array();
$histo_achats = get_historique_achats ($_SESSION['magasin']->getId_stock());

$stock_vu = $_SESSION['magasin']->getId_stock();
// *************************************************************************************************************
// AFFICHAGE
// -*************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_documents_historique_achats.inc.php");

?>