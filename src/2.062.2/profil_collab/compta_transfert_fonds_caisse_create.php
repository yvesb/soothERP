<?php
// *************************************************************************************************************
// Création d'un transfert de caisse
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");



$compte_caisse	= new compte_caisse($_REQUEST["id_compte_caisse"]);

$totaux_theoriques = $compte_caisse->controle_total_caisse_move ();


	$info = array();
	$info["id_compte_caisse_destination"] 	= $_REQUEST["id_compte_caisse_destination"];
	$info["montant_theorique"] 	= $_REQUEST["montant_theorique"];
	$info["montant_transfert"] 	= $_REQUEST["montant_transfert"];
	$info["commentaire"] 			= $_REQUEST["commentaire"];
	
	$info["ESP"]							= array();
	$info["CHQ"]							= array();
	//infos des especes
	
	$info["ESP"]["id_reglement_mode"] = $ESP_E_ID_REGMT_MODE;
	$info["ESP"]["montant_theorique"] = number_format($totaux_theoriques[$ESP_E_ID_REGMT_MODE], $TARIFS_NB_DECIMALES, ".", ""	);
	$info["ESP"]["montant_transfert"] = $_REQUEST["montant_transfert_esp"];
	$info["ESP"]["infos_transfert"] = "";
	
	foreach ($MONNAIE[5] as $espece) {
		if (isset($_REQUEST["ESP_".str_replace(".", "", $espece)]) && is_numeric($_REQUEST["ESP_".str_replace(".", "", $espece)]) && $_REQUEST["ESP_".str_replace(".", "", $espece)] != 0) {
			$info["ESP"]["infos_transfert"] .=  $espece.";".$_REQUEST["ESP_".str_replace(".", "", $espece)]."\n";
		}
	}
	
	//infos des cheques
	
	$info["CHQ"]["id_reglement_mode"] = $CHQ_E_ID_REGMT_MODE;
	$info["CHQ"]["montant_theorique"] = number_format($totaux_theoriques[$CHQ_E_ID_REGMT_MODE], $TARIFS_NB_DECIMALES, ".", ""	);
	$info["CHQ"]["montant_transfert"] = $_REQUEST["montant_transfert_chq"];
	$info["CHQ"]["infos_transfert"] = "";
	$info["CHQ"]["infos_transfert_add"] = "";
	
	//infos de controle des cheques 
	foreach ($_REQUEST as $variable => $valeur) {
	
		if ((substr ($variable, 0, 14) == "CHK_EXIST_CHQ_")  ) {
			if (isset($_REQUEST[str_replace("CHK_", "", $variable)])) {
				$info["CHQ"]["infos_transfert"] .= $_REQUEST[str_replace("CHK_", "", $variable)]."\n";
			}
		}
		
		if ((substr ($variable, 0, 4) == "CHQ_") && is_numeric($valeur) && $valeur != 0) {
			$info["CHQ"]["infos_transfert_add"] .= $valeur."; \n";
		}
		
		
	}
	//print_r($info);
	
$id_compte_caisse_transfert = $compte_caisse->create_transfert_caisse ($info);

// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_compta_transfert_fonds_caisse_create.inc.php");

?>