<?php
// *************************************************************************************************************
// retrait en la banque vers caisse 
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");


$comptes_bancaires	=  compte_bancaire::charger_comptes_bancaires("" , 1);
$compte_caisse	= new compte_caisse($_REQUEST["id_caisse"]);

$totaux_theoriques = $compte_caisse->controle_total_caisse_move ();
// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_compta_retrait_bancaire_caisse.inc.php");

?>