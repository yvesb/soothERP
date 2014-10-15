<?php
// *************************************************************************************************************
// Modification d'un compte caisse
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");

if (isset($_REQUEST["id_compte_tpe"])) {
	$compte_tpe = new compte_tpe ($_REQUEST['id_compte_tpe']);
	
		$compte_tpe->maj_defaut_numero_compte($_REQUEST["retour_value"]);
		//mise en favori du compte correspondant
		$compte_plan_general = new compta_plan_general ($_REQUEST["retour_value"]);
		$compte_plan_general->active_compte ();

}
if (isset($_REQUEST["id_compte_tpv"])) {
	$compte_tpv = new compte_tpv ($_REQUEST['id_compte_tpv']);
	$compte_tpv->maj_defaut_numero_compte($_REQUEST["retour_value"]);
	//mise en favori du compte correspondant
	$compte_plan_general = new compta_plan_general ($_REQUEST["retour_value"]);
	$compte_plan_general->active_compte ();

}
?>