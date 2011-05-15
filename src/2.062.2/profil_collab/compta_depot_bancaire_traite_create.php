<?php
// *************************************************************************************************************
// Remise bancaire depuis la caisse (ou dépot bancaire depuis la caisse)
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");



$compte_caisse	= new compte_caisse($_REQUEST["id_compte_caisse"]);

$totaux_theoriques = $compte_caisse->controle_total_caisse_move ();


	$info = array();
	$info["id_compte_bancaire_destination"] 	= $_REQUEST["id_compte_bancaire_destination"];
	$info["montant_theorique"] 	= $_REQUEST["montant_theorique"];
	$info["montant_depot"] 			= $_REQUEST["montant_depot"];
	$info["commentaire"] 				= $_REQUEST["commentaire"];
	$info["num_remise"] 		= $_REQUEST["num_remise"];
	
	
	if ($_REQUEST["type_remise"] == "ESP") {
		//infos des especes
		$info["ESP"]							= array();
		$info["ESP"]["id_reglement_mode"] = $ESP_E_ID_REGMT_MODE;
		$info["ESP"]["montant_depot"] = $_REQUEST["montant_depot_esp"];
		$info["ESP"]["infos_depot"] = "";
		
		foreach ($MONNAIE[5] as $espece) {
			if (isset($_REQUEST["ESP_".str_replace(".", "", $espece)]) && is_numeric($_REQUEST["ESP_".str_replace(".", "", $espece)]) && $_REQUEST["ESP_".str_replace(".", "", $espece)] != 0) {
				$info["ESP"]["infos_depot"] .=  $espece.";".$_REQUEST["ESP_".str_replace(".", "", $espece)]."\n";
			}
		}
	}
	
	if ($_REQUEST["type_remise"] == "CHQ") {
		//infos des cheques
		$info["CHQ"]							= array();
		$info["CHQ"]["id_reglement_mode"] = $CHQ_E_ID_REGMT_MODE;
		$info["CHQ"]["montant_depot"] = $_REQUEST["montant_depot_chq"];
		$info["CHQ"]["liste_cheques"] = array();
		$info["CHQ"]["liste_cheques_add"] = array();
		//infos de controle des cheques 
		//Montant/ref_reglement/Numéro de chèque/Banque/Porteur/
		foreach ($_REQUEST as $variable => $valeur) {
		
			if ((substr ($variable, 0, 14) == "CHK_EXIST_CHQ_")  ) {
				if (isset($_REQUEST[str_replace("CHK_", "", $variable)])) {
					$info["CHQ"]["liste_cheques"][] = array("montant_depot"=>$_REQUEST[str_replace("CHK_", "", $variable)]."", "infos_depot"=>$_REQUEST["REF_".str_replace("CHK_", "", $variable)]);
				}
			}
			
			if ((substr ($variable, 0, 4) == "CHQ_") && is_numeric($valeur) && $valeur != 0) {
				$info["CHQ"]["liste_cheques_add"][] = array("montant_depot"=>$valeur, "infos_depot"=>";".$_REQUEST["NUM_".str_replace("CHQ_", "", $variable)].";".$_REQUEST["BNQ_".str_replace("CHQ_", "", $variable)].";".$_REQUEST["POR_".str_replace("CHQ_", "", $variable)]);
			}
		}
	}
		if ($_REQUEST["type_remise"] == "Traite") {
		//infos des cheques
		$info["LC"]							= array();
		$info["LC"]["id_reglement_mode"] = $LC_E_ID_REGMT_MODE;
		$info["LC"]["montant_depot"] = $_REQUEST["montant_depot_chq"];
		$info["LC"]["liste_cheques"] = array();
		$info["LC"]["liste_cheques_add"] = array();
		//infos de controle des cheques 
		//Montant/ref_reglement/Numéro de chèque/Banque/Porteur/
		foreach ($_REQUEST as $variable => $valeur) {
		
			if ((substr ($variable, 0, 14) == "CHK_EXIST_CHQ_")  ) {
				if (isset($_REQUEST[str_replace("CHK_", "", $variable)])) {
					$info["LC"]["liste_cheques"][] = array("montant_depot"=>$_REQUEST[str_replace("CHK_", "", $variable)]."", "infos_depot"=>$_REQUEST["REF_".str_replace("CHK_", "", $variable)]);
				}
			}
		}
	}
	
	print_r($info);

$id_compte_caisse_depot = $compte_caisse->create_depot_caisse ($info);

// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_compta_depot_bancaire_traite_create.inc.php");

?>