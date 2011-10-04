<?php
// *************************************************************************************************************
// IMPRESSION DES ETATS DES STOCKS
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");

ini_set("memory_limit","40M");
//**************************************
// Controle
$infos = array();

$infos["ref_art_categ"] = $_REQUEST["ref_art_categ"];
$infos["ref_constructeur"] = $_REQUEST["ref_constructeur"];
$infos["aff_pa"] = $_REQUEST["aff_pa"];
$infos["orderby"] = $_REQUEST["orderby"];
$infos["orderorder"] = $_REQUEST["orderorder"];
$infos["id_stocks"] = $_REQUEST['id_stocks'];
$infos["in_stock"] = $_REQUEST["in_stock"];

// Ouverture du fichier pdf des �tats des stocks
stock::imprimer_etat_stocks ($infos);


// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************


?>