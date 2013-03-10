<?php
// *************************************************************************************************************
// IMPRESSION RIB COMPTES BANCAIRES
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");

$print = 0;
if (isset($_REQUEST["print"])) {$print = 1;}
//solde en cours de chaque compte
$compte_bancaire	= new compte_bancaire($_REQUEST["id_compte_bancaire"]);
$compte_bancaire->imprimer_rib_bancaire ($print);


?>