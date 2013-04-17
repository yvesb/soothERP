<?php
// *************************************************************************************************************
// modification D'UN compte de plan comptable général
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");


//ouverture de la class compta_plan_general
if (isset($_REQUEST["old_numero_compte_".$_REQUEST["increment"]])) {
	$compte_plan_general = new compta_plan_general ($_REQUEST["old_numero_compte_".$_REQUEST["increment"]]);

	$infos = array();
	$infos['numero_compte'] 	= $_REQUEST["numero_compte_".$_REQUEST["increment"]];
	$infos['lib_compte'] 		= $_REQUEST["lib_compte_".$_REQUEST["increment"]];
	$favori = 0;
	if (isset($_REQUEST["favori_".$_REQUEST["increment"]]) && $_REQUEST["favori_".$_REQUEST["increment"]] == "1") {
		$favori = 1;
	}
	$infos['favori'] 		= $favori;
	
	
	//création du compte
	$compte_plan_general->maj_compte_plan_comptable ($infos);
// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_compta_plan_entreprise_mod.inc.php");

}
?>