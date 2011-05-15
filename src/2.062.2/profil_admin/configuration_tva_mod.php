<?php
// *************************************************************************************************************
// Modification d'un taux de TVA
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");

if (isset($_REQUEST["id_tva"])) {
	$infos_tva = array();
	if (isset($_REQUEST["tva_".$_REQUEST["id_tva"]])) {
		$infos_tva["tva"] =  $_REQUEST["tva_".$_REQUEST["id_tva"]];
	}
	if (isset($_REQUEST["num_compte_achat"])) {
		$infos_tva["num_compte_achat"] =  $_REQUEST["num_compte_achat"];
		//mise en favori du compte correspondant
		$compte_plan_general = new compta_plan_general ($_REQUEST["num_compte_achat"]);
		$compte_plan_general->active_compte ();
	}
	if (isset($_REQUEST["num_compte_vente"])) {
		$infos_tva["num_compte_vente"] =  $_REQUEST["num_compte_vente"];
		//mise en favori du compte correspondant
		$compte_plan_general = new compta_plan_general ($_REQUEST["num_compte_vente"]);
		$compte_plan_general->active_compte ();
	}

	$tvas = maj_tva ($_REQUEST["id_tva"], $infos_tva);
}
// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_configuration_tva_mod.inc.php");

?>