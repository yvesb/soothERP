<?php
// *************************************************************************************************************
// AFFICAHE DES MOUVEMENTS DE STOCKS
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");

//**************************************
// Controle

if (isset($_REQUEST["id_stock"])) {
	$stock	= $_SESSION['stocks'][$_REQUEST["id_stock"]];
}

//liste des lieux de stockage
$stocks_liste	= array();
$stocks_liste = $_SESSION['stocks'];



// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_stocks_mouvements.inc.php");

?>