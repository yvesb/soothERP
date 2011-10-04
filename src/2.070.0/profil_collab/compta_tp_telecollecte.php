<?php
// *************************************************************************************************************
// télécollecte d'un TP
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");



if (isset($_REQUEST["id_tp"]) && isset($_REQUEST["tp_type"]) && $_REQUEST["tp_type"] == "TPE" ) {
if (!$_SESSION['user']->check_permission ("33",$_REQUEST["id_tp"])) {
		//on indique l'interdiction et on stop le script
		echo "<br /><span style=\"font-weight:bolder;color:#FF0000;\">Vos droits  d'accés ne vous permettent pas de visualiser ce type de page</span>";
		exit();
}
	
	//on traite un TPE
	$compte_tp	= new compte_tpe($_REQUEST["id_tp"]);
	$retour_var = "id_tpe=".$_REQUEST["id_tp"];
}

if (isset($_REQUEST["id_tp"]) && isset($_REQUEST["tp_type"]) && $_REQUEST["tp_type"] == "TPV"  ) {
if (!$_SESSION['user']->check_permission ("37",$_REQUEST["id_tp"])) {
		//on indique l'interdiction et on stop le script
		echo "<br /><span style=\"font-weight:bolder;color:#FF0000;\">Vos droits  d'accés ne vous permettent pas de visualiser ce type de page</span>";
		exit();
}
	//on traite un TPV
	$compte_tp	= new compte_tpv($_REQUEST["id_tp"]);
	$retour_var = "id_tpv=".$_REQUEST["id_tp"];
}

$totaux_theoriques = $compte_tp->collecte_total ();
$count_cb_theoriques = $compte_tp->charger_compte_tp_contenu();
// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_compta_tp_telecollecte.inc.php");

?>