<?php
// *************************************************************************************************************
// MODIFICATION D'UNE OPERATION BANCAIRE
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");


//chargement des comptes bancaires
$compte_bancaire	= new compte_bancaire($_REQUEST["id_compte_bancaire"]);

$infos_operation = $compte_bancaire->charger_compte_bancaire_move ($_REQUEST["id_compte_bancaire_move"]);


// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_compta_compte_bancaire_operations_edit.inc.php");

?>