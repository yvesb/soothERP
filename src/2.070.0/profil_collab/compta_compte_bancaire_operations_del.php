<?php
// *************************************************************************************************************
// SUPPRESSION D'UNE OPERATION
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");

echo $_REQUEST["date_move"];

//chargement des comptes bancaires
$compte_bancaire	= new compte_bancaire($_REQUEST["id_compte_bancaire"]);

$compte_bancaire->del_compte_bancaire_move ($_REQUEST["id_compte_bancaire_move"], ($_REQUEST["date_move"]));

$compte_bancaire->check_calcul_releve (($_REQUEST["date_move"]));
// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_compta_compte_bancaire_operations_del.inc.php");

?>