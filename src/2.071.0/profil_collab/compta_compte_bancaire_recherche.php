<?php
// *************************************************************************************************************
// Recherche BANCAIRE
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");


//chargement des comptes bancaires
$comptes_bancaires	= compte_bancaire::charger_comptes_bancaires("" , 1);
$compte_bancaire	= new compte_bancaire($_REQUEST["id_compte_bancaire"]);
// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_compta_compte_bancaire_recherche.inc.php");

?>