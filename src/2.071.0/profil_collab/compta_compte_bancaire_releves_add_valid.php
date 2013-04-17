<?php
// *************************************************************************************************************
// AJOUT D'UN RELEVE
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");


//chargement des comptes bancaires
$compte_bancaire	= new compte_bancaire($_REQUEST["id_compte_bancaire_new_releve"]);
$compte_bancaire->add_releve_compte (date_Fr_to_Us($_REQUEST["date_new_releve"]), $_REQUEST["montant_reel_new_releve"]);
// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_compta_compte_bancaire_releves_add_valid.inc.php");

?>