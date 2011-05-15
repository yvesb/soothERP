<?php
// *************************************************************************************************************
// MODIFICATION D'UNE OPERATION
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");


//chargement des comptes bancaires
$compte_bancaire	= new compte_bancaire($_REQUEST["id_compte_bancaire_ope"]);

$compte_bancaire->maj_compte_bancaire_move ($_REQUEST["id_compte_bancaire_move"], date_Fr_to_Us($_REQUEST["date_move"]), $_REQUEST["lib_move"], $_REQUEST["montant_move"], $_REQUEST["commentaire_move"], $_REQUEST["fitid"]);

$compte_bancaire->check_calcul_releve (date_Fr_to_Us($_REQUEST["date_move"]));
// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_compta_compte_bancaire_operations_edit_valid.inc.php");

?>