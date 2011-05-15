<?php
// *************************************************************************************************************
// Création d'un controle de caisse
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");



$compte_caisse	= new compte_caisse($_REQUEST["id_compte_caisse"]);

foreach ($_REQUEST as $variable => $valeur) {
	
	if ((substr ($variable, 0, 4) == "OPE_") && is_numeric($valeur) && $valeur != 0) {
		$info_ope = array();
		$info_ope["montant_ar"] 	= $_REQUEST["ST_".$variable].$valeur;
		$info_ope["commentaire"] 			= $_REQUEST["DESC_".$variable];	
		$compte_caisse->create_ar_fonds_caisse ($info_ope);
	}
}

$totaux_theoriques = $compte_caisse->controle_total_caisse_move ();
$count_chq_theoriques = $compte_caisse->count_caisse_contenu ($CHQ_E_ID_REGMT_MODE);
$count_cb_theoriques = $compte_caisse->count_caisse_contenu ($CB_E_ID_REGMT_MODE);


	$info = array();
	$info["montant_theorique"] 	= $_REQUEST["montant_theorique"];
	$info["montant_controle"] 	= $_REQUEST["montant_controle"];
	$info["commentaire"] 			= $_REQUEST["commentaire"];
	
	$info["ESP"]							= array();
	$info["CHQ"]							= array();
	$info["CB"]								= array();
	//infos des especes
	$info["ESP"]["controle"] = 0;
	
	if (!isset($_REQUEST["pass_esp"])) {$info["ESP"]["controle"] = 1;}
	
	$info["ESP"]["montant_theorique"] = number_format($totaux_theoriques[$ESP_E_ID_REGMT_MODE], $TARIFS_NB_DECIMALES, ".", ""	);
	$info["ESP"]["montant_controle"] = $_REQUEST["montant_controle_esp"];
	$info["ESP"]["infos_theorique"] = "";
	$info["ESP"]["infos_controle"] = "";
	
	foreach ($MONNAIE[5] as $espece) {
		if (isset($_REQUEST["ESP_".str_replace(".", "", $espece)]) && is_numeric($_REQUEST["ESP_".str_replace(".", "", $espece)]) && $_REQUEST["ESP_".str_replace(".", "", $espece)] != 0) {
			$info["ESP"]["infos_controle"] .=  $espece.";".$_REQUEST["ESP_".str_replace(".", "", $espece)]."\n";
		}
	}
	
	//infos des cheques
	$info["CHQ"]["controle"] = 0;
	
	if (!isset($_REQUEST["pass_chq"])) {$info["CHQ"]["controle"] = 1;}
	
	$info["CHQ"]["montant_theorique"] = number_format($totaux_theoriques[$CHQ_E_ID_REGMT_MODE], $TARIFS_NB_DECIMALES, ".", ""	);
	$info["CHQ"]["montant_controle"] = $_REQUEST["montant_controle_chq"];
	$info["CHQ"]["infos_theorique"] = "";
	
	foreach($count_chq_theoriques as $chq_theo) {
		$info["CHQ"]["infos_theorique"] .= $chq_theo->montant_contenu.";".$chq_theo->infos_supp."\n";
	}
	$info["CHQ"]["infos_controle"] = "";
	
	
	//infos des CB
	$info["CB"]["controle"] = 0;
	if (!isset($_REQUEST["pass_cb"])) {$info["CB"]["controle"] = 1;}
	
	$info["CB"]["montant_theorique"] = number_format($totaux_theoriques[$CB_E_ID_REGMT_MODE], $TARIFS_NB_DECIMALES, ".", ""	);
	$info["CB"]["montant_controle"] = $_REQUEST["montant_controle_cb"];
	$info["CB"]["infos_theorique"] = "";
	
	foreach($count_cb_theoriques as $cb_theo) {
		$info["CB"]["infos_theorique"] .= $cb_theo->montant_contenu.";".$cb_theo->infos_supp."\n";
	}
	$info["CB"]["infos_controle"] = "";
	
	
	//infos de controle des cheeques et cb
	foreach ($_REQUEST as $variable => $valeur) {
	
		if ((substr ($variable, 0, 14) == "CHK_EXIST_CHQ_")  ) {
			if (isset($_REQUEST[str_replace("CHK_", "", $variable)])) {
				$info["CHQ"]["infos_controle"] .= $_REQUEST[str_replace("CHK_", "", $variable)]."\n";
			}
		}
		
		if ((substr ($variable, 0, 4) == "CHQ_") && is_numeric($valeur) && $valeur != 0) {
			$info["CHQ"]["infos_controle"] .= $valeur."; \n";
		}
		
		if ((substr ($variable, 0, 13) == "CHK_EXIST_CB_") ) {
			if (isset($_REQUEST[str_replace("CHK_", "", $variable)])) {
				$info["CB"]["infos_controle"] .= $_REQUEST[str_replace("CHK_", "", $variable)]."\n";
			}
		}
		
		if ((substr ($variable, 0, 3) == "CB_") && is_numeric($valeur) && $valeur != 0) {
			$info["CB"]["infos_controle"] .= $valeur."; \n";
		}
		
	}
	//print_r($info);
	
$id_compte_caisse_controle = $compte_caisse->create_controle_caisse ($info);


// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_compta_controle_caisse_create.inc.php");

?>