<?php
// *************************************************************************************************************
// Modification d'un compte d'art_categ
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");

if (isset($_REQUEST["ref_art_categ"])) {
	$art_categ = new art_categ ($_REQUEST['ref_art_categ']);
	
	if (isset($_REQUEST["type"]) && $_REQUEST["type"] == "achat") {
		$art_categ->maj_defaut_numero_compte_achat($_REQUEST["retour_value"]);
		//mise en favori du compte correspondant
		$compte_plan_general = new compta_plan_general ($_REQUEST["retour_value"]);
		$compte_plan_general->active_compte ();
	}
	if (isset($_REQUEST["type"]) && $_REQUEST["type"] == "vente") {
		$art_categ->maj_defaut_numero_compte_vente($_REQUEST["retour_value"]);
		//mise en favori du compte correspondant
		$compte_plan_general = new compta_plan_general ($_REQUEST["retour_value"]);
		$compte_plan_general->active_compte ();
	}

}
?>