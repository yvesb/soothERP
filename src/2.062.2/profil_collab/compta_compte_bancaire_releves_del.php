<?php
// *************************************************************************************************************
// suppression D'UN RELEVE
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");


//chargement des comptes bancaires
$compte_bancaire	= new compte_bancaire($_REQUEST["id_compte_bancaire_rel"]);

$compte_bancaire->del_compte_bancaire_releve ($_REQUEST["id_compte_bancaire_releve"]);

// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_compta_compte_bancaire_releves_del.inc.php");

?>