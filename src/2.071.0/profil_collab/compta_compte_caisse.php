<?php
// *************************************************************************************************************
// ACCUEIL GESTION COMPTES CAISSES
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");


//chargement des comptes caisse
if (isset ($_REQUEST["id_magasin"])) {
	$comptes_caisses	= compte_caisse::charger_comptes_caisses($_REQUEST["id_magasin"]);
	$id_magasin = $_REQUEST["id_magasin"];
} else {
	$comptes_caisses	= compte_caisse::charger_comptes_caisses($_SESSION['magasin']->getId_magasin ());
	$id_magasin = $_SESSION['magasin']->getId_magasin ();
}

// liste des magasins
$magasins_liste	= charger_all_magasins ();

// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_compta_compte_caisse.inc.php");

?>