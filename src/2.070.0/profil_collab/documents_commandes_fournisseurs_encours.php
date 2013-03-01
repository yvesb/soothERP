<?php
// *************************************************************************************************************
// COMMANDES FOURNISSEURS EN COURS
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");

$stock_vu = "";
//chargement des commandes en cours
$commandes = array();
$commandes = get_commandes_fournisseurs ();


// *************************************************************************************************************
// AFFICHAGE
// -*************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_documents_commandes_fournisseurs_encours.inc.php");

?>