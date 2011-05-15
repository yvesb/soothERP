<?php
// *************************************************************************************************************
// RAPPROCHEMENT D'UNE OPERATION BANCAIRE
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");


//chargement des comptes bancaires
$compte_bancaire	= new compte_bancaire($_REQUEST["id_compte_bancaire"]);

$infos_operation = $compte_bancaire->charger_compte_bancaire_move ($_REQUEST["id_compte_bancaire_move"]);

$journal = new compta_journaux("", $DEFAUT_ID_JOURNAL_BANQUES , $compte_bancaire->getDefaut_numero_compte());
// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_compta_compte_bancaire_rapprochement_edit.inc.php");

?>