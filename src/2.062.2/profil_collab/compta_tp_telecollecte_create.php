<?php
// *************************************************************************************************************
// Création d'une telecollecte
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");




if (isset($_REQUEST["id_compte_tp"]) && isset($_REQUEST["tp_type"]) && $_REQUEST["tp_type"] == "TPE" ) {
	//on traite un TPE
	$compte_tp	= new compte_tpe($_REQUEST["id_compte_tp"]);
	$retour_var = "id_tpe=".$_REQUEST["id_compte_tp"];
}

if (isset($_REQUEST["id_compte_tp"]) && isset($_REQUEST["tp_type"]) && $_REQUEST["tp_type"] == "TPV"  ) {
	//on traite un TPV
	$compte_tp	= new compte_tpv($_REQUEST["id_compte_tp"]);
	$retour_var = "id_tpv=".$_REQUEST["id_compte_tp"];
}


	$info = array();
	$info["date_telecollecte"] 	= date_Fr_to_Us($_REQUEST["date_telecollecte"])." ".getTime_from_date($_REQUEST["date_telecollecte"]);
	$info["montant_telecollecte"]	= $_REQUEST["montant_total"];
	$info["montant_commission"]	= $_REQUEST["montant_commission"];
	$info["montant_transfere"] 	= $_REQUEST["montant_transfere"];
	$info["nombre_ope"] 				= $_REQUEST["nombre_ope"];
	$info["commentaire"] 				= $_REQUEST["commentaire"];
	
	$info["CB"]								= array();
	//infos des CB

	$info["CB"]["infos_telecollecte"] = "";
	
	
	//infos des cb
	foreach ($_REQUEST as $variable => $valeur) {
	
		if ((substr ($variable, 0, 13) == "CHK_EXIST_CB_") ) {
			if (isset($_REQUEST[str_replace("CHK_", "", $variable)])) {
				$info["CB"]["infos_telecollecte"] .= $_REQUEST[str_replace("CHK_", "", $variable)]."\n";
			}
		}
		
		if ((substr ($variable, 0, 3) == "CB_") && is_numeric($valeur) && $valeur != 0) {
			$info["CB"]["infos_telecollecte"] .= $valeur."; \n";
		}
		
	}
	//print_r($info);
	
$id_compte_tp_telecollecte = $compte_tp->create_telecollecte ($info);


// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_compta_tp_telecollecte_create.inc.php");

?>