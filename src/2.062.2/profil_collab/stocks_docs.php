<?php
// *************************************************************************************************************
// AFFICAHE DES DOCUMENTS DE STOCKS (liés à des mouvements)
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


	$types_liste = $_SESSION['types_docs'];

// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_stocks_docs.inc.php");

?>