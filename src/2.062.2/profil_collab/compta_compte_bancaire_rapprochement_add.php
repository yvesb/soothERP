<?php
// *************************************************************************************************************
// SUPPRESSION D'UN RAPPROCHEMENT
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");


//chargement des comptes bancaires
$compte_bancaire	= new compte_bancaire($_REQUEST["id_compte_bancaire"]);

$compte_bancaire->add_compte_bancaire_rapprochement ($_REQUEST["id_compte_bancaire_move"], $_REQUEST["id_operation"], ($_REQUEST["date_move"]));

// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_compta_compte_bancaire_rapprochement_add.inc.php");

?>