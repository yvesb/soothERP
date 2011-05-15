<?php
// *************************************************************************************************************
// LISTE DES NUMEROS DE SERIE D'UN ARTICLE DANS UN MOUVEMENT DE STOCK
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");

//**************************************
// Controle


//liste des lieux de stockage
$stocks_liste	= array();
$stocks_liste = $_SESSION['stocks'];



// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_stocks_resume_sn.inc.php");

?>