<?php
// *************************************************************************************************************
// RECHERCHE DES ARTICLES POUR L'ETAT DES STOCKS
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");


// *************************************************************************************************************
// TRAITEMENTS
// *************************************************************************************************************
if (isset($_REQUEST["id_stock"])) {
	$stock	= $_SESSION['stocks'][$_REQUEST["id_stock"]];
}

//liste des constructeurs
$constructeurs_liste = array();
$constructeurs_liste = get_constructeurs ();

//liste des lieux de stockage
$stocks_liste	= array();
$stocks_liste = $_SESSION['stocks'];


//liste des tarifs
get_tarifs_listes ();
$tarifs_liste	= array();
$tarifs_liste = $_SESSION['tarifs_listes'];	

// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_stocks_etat_recherche.inc.php");

?>