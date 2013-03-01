<?php
// *************************************************************************************************************
// ACCUEIL GESTION COMPTES BANCAIRES
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");


//chargement des comptes bancaires
$compte_bancaire	= new compte_bancaire($_REQUEST["id_compte_bancaire"]);

$liste_releves = $compte_bancaire->getReleves_compte ();
// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_compta_compte_bancaire_releves.inc.php");

?>