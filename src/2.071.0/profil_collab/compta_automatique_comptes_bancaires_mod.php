<?php
// *************************************************************************************************************
// Modification d'un compte de compte bancaire
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");

if (isset($_REQUEST["id_compte_bancaire"])) {
	$compte_bancaire = new compte_bancaire ($_REQUEST['id_compte_bancaire']);
	
		$compte_bancaire->maj_defaut_numero_compte($_REQUEST["retour_value"]);
		//mise en favori du compte correspondant
		$compte_plan_general = new compta_plan_general ($_REQUEST["retour_value"]);
		$compte_plan_general->active_compte ();

}
?>