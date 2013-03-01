<?php
// *************************************************************************************************************
// retrait en la banque vers caisse 
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");



$compte_caisse	= new compte_caisse($_REQUEST["id_compte_caisse"]);

$totaux_theoriques = $compte_caisse->controle_total_caisse_move ();


	$info = array();
	$info["id_compte_bancaire_source"] 	= $_REQUEST["id_compte_bancaire_source"];
	$info["montant_theorique"] 	= $_REQUEST["montant_theorique"];
	$info["montant_retrait"] 	= $_REQUEST["montant_retrait"];
	$info["commentaire"] 			= $_REQUEST["commentaire"];
	
	$info["ESP"]							= array();
	//infos des especes
	
	$info["ESP"]["id_reglement_mode"] = $ESP_E_ID_REGMT_MODE;
	$info["ESP"]["montant_retrait"] = $_REQUEST["montant_retrait_esp"];
	$info["ESP"]["infos_retrait"] = "";
	
	foreach ($MONNAIE[5] as $espece) {
		if (isset($_REQUEST["ESP_".str_replace(".", "", $espece)]) && is_numeric($_REQUEST["ESP_".str_replace(".", "", $espece)]) && $_REQUEST["ESP_".str_replace(".", "", $espece)] != 0) {
			$info["ESP"]["infos_retrait"] .=  $espece.";".$_REQUEST["ESP_".str_replace(".", "", $espece)]."\n";
		}
	}
	
	
$id_compte_caisse_retrait = $compte_caisse->create_retrait_caisse ($info);

// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_compta_retrait_bancaire_caisse_create.inc.php");

?>