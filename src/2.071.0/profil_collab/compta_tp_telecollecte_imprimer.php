<?php
// *************************************************************************************************************
// IMPRESSION TELECOLLLECTE
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");

$print = 0;
if (isset($_REQUEST["print"])) {$print = 1;}

if (isset($_REQUEST["id_compte_tp"]) && isset($_REQUEST["tp_type"]) && $_REQUEST["tp_type"] == "TPE" ) {
	//on traite un TPE
	$compte_tp	= new compte_tpe($_REQUEST["id_compte_tp"]);
	$retour_var = "id_tpe=".$_REQUEST["id_compte_tp"];
}

if (isset($_REQUEST["id_compte_tp"]) && isset($_REQUEST["tp_type"]) && $_REQUEST["tp_type"] == "TPV"  ) {
	//on traite un TPV
	$compte_tp	= new compte_tpv($_REQUEST["id_compte_tp"]);
	$retour_var = "id_tpv=".$_REQUEST["id_compte_tp"];
}

$compte_tp->imprimer_telecollecte ($print, $_REQUEST["id_compte_tp_telecollecte"]);


?>