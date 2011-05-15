<?php
// *************************************************************************************************************
// MODIFICATION D'UN RELEVE
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");


//chargement des comptes bancaires
$compte_bancaire	= new compte_bancaire($_REQUEST["id_compte_bancaire_ope"]);

$compte_bancaire->maj_compte_bancaire_releve ($_REQUEST["id_compte_bancaire_releve"], date_Fr_to_Us($_REQUEST["date_releve"]), $_REQUEST["solde_reel"]);

// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_compta_compte_bancaire_releves_edit_valid.inc.php");

?>