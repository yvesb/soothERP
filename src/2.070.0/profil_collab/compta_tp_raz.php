<?php
// *************************************************************************************************************
// REMISE A ZERO Du contenu TP
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");


if (isset($_REQUEST["id_tp"]) && isset($_REQUEST["tp_type"]) && $_REQUEST["tp_type"] == "TPE" ) {
	//on traite un TPE
	$compte_tp	= new compte_tpe($_REQUEST["id_tp"]);
	$retour_var = "id_tpe=".$_REQUEST["id_tp"];
}

if (isset($_REQUEST["id_tp"]) && isset($_REQUEST["tp_type"]) && $_REQUEST["tp_type"] == "TPV"  ) {
	//on traite un TPV
	$compte_tp	= new compte_tpv($_REQUEST["id_tp"]);
	$retour_var = "id_tpv=".$_REQUEST["id_tp"];
}


$last_date_telecollecte = $compte_tp->getLast_date_telecollecte ();
$totaux_theoriques = $compte_tp->collecte_total ();


// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_compta_tp_raz.inc.php");

?>