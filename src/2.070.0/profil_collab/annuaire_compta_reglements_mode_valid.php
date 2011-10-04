<?php
// *************************************************************************************************************
// REGLEMENT VALIDATION
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");


if (isset($_REQUEST["id_reglement_mode"])) {

	$infos = array();
	
	
	$infos ["id_reglement_mode"]					=	 $_REQUEST["id_reglement_mode"];
	$infos ["ref_contact"]								=	 $_REQUEST["ref_contact"];
	$infos ["direction_reglement"]				=	 $_REQUEST["direction_reglement"];
	$infos ["montant_reglement"]					=	 $_REQUEST["montant_reglement"];
	$infos ["date_reglement"]							=	 date_Fr_to_Us($_REQUEST["date_reglement"])." ".date("H:i:s");
	$infos ["date_echeance"]							=	 date_Fr_to_Us($_REQUEST["date_echeance"]);
	
	switch ($infos ["id_reglement_mode"]) {
		//entrant espece
		case "1":
			$infos ["id_compte_caisse_dest"]			=	 $_REQUEST["id_compte_caisse_dest1"];
		break;
		
		//entrant cheque
		case "2":
			$infos ["id_compte_caisse_dest"]			=	 $_REQUEST["id_compte_caisse_dest2"];
			$infos ["numero_cheque"]							=	 $_REQUEST["numero_cheque"];
			$infos ["info_banque"]								=	 $_REQUEST["info_banque"];
			$infos ["info_compte"]								=	 $_REQUEST["info_compte"];
		break;
		
		//entrant cb
		case "3":
			//si on utilise un module de paiement virtuel
			if (substr_count($_REQUEST["id_compte_dest"], "tpv_")) {
				if (!isset($_REQUEST["done_reg_tpv"])) {
					$compte_tpv = new compte_tpv (str_replace("tpv_", "", $_REQUEST["id_compte_dest"]));
					$liste_docs = "";
					$main_doc = "";
					foreach ($_REQUEST as $variable => $valeur) {
						if (substr_count($variable, "docs_")) {
							if (!$main_doc) {$main_doc = $valeur; }
							if ($liste_docs) {$liste_docs .= "__";}
							$liste_docs .=  $valeur;
						}
					}
					$classe_module = $compte_tpv->getmodule_name();
					$module = new $classe_module( ) ;
					$module->lancer_reglement($infos ["montant_reglement"], $compte_tpv->getid_compte_tpv(), $infos ["ref_contact"], $liste_docs, $main_doc);
					
					exit;
				} else {
					$infos ["id_reglement_mode"]					=	$TPV_E_ID_REGMT_MODE;
					$infos ["direction_reglement"]				=	"entrant";
					$infos ["id_compte_tpv_dest"]					=	str_replace("tpv_", "", $_REQUEST["id_compte_dest"]);
					break;
				}
			}
			// sinon on utilise un paiement par carte physique
			$id_compte = explode (",", $_REQUEST["id_compte_dest"]);
			$id_compte_caisse_dest = $id_compte [0];
			$id_compte_tpe_dest = $id_compte [1];
			$infos ["id_compte_caisse_dest"]	=	 $id_compte_caisse_dest;
			$infos ["id_compte_tpe_dest"]			=	 $id_compte_tpe_dest;
		break;
		
		//entrant virement
		case "4":
			$infos ["id_compte_bancaire_source"]	=	 $_REQUEST["id_compte_bancaire_source"];
			$infos ["id_compte_bancaire_dest"]		=	 $_REQUEST["id_compte_bancaire_dest"];
		break;
		
		//entrant lettre
		case "5":
			$infos ["id_compte_bancaire_source"]	=	 "";
			if (isset($_REQUEST["id_compte_bancaire_source"])) {
			$infos ["id_compte_bancaire_source"]	=	 $_REQUEST["id_compte_bancaire_source"];
			}
			$infos ["id_compte_bancaire_dest"]		=	 $_REQUEST["id_compte_bancaire_dest"];
		break;
		
		//entrant prelevement
		case "6":
			$infos ["id_compte_bancaire_source"]	=	 "";
			if (isset($_REQUEST["id_compte_bancaire_source"])) {
			$infos ["id_compte_bancaire_source"]	=	 $_REQUEST["id_compte_bancaire_source"];
			}
			$infos ["id_compte_bancaire_dest"]		=	 $_REQUEST["id_compte_bancaire_dest"];
		break;
		
		//sortant espece
		case "7":
			$infos ["id_compte_caisse_source"]		=	 $_REQUEST["id_compte_caisse_source7"];
		break;
		
		//sortant cheque
		case "8":
			$infos ["id_compte_bancaire_source"]	=	 $_REQUEST["id_compte_bancaire_source"];
			$infos ["numero_cheque"]							=	 $_REQUEST["numero_cheque"];
		break;
		
		//sortant cb
		case "9":
			$infos ["id_compte_cb_source"]		=	 $_REQUEST["id_compte_cb_source"];
		break;
		
		//sortant virement
		case "10":
			$infos ["id_compte_bancaire_source"]	=	 $_REQUEST["id_compte_bancaire_source"];
			$infos ["id_compte_bancaire_dest"]		=	 "";
			if (isset($_REQUEST["id_compte_bancaire_dest"])) {
			$infos ["id_compte_bancaire_dest"]		=	 $_REQUEST["id_compte_bancaire_dest"];
			}
		break;
		
		//sortant lettre
		case "11":
			$infos ["id_compte_bancaire_source"]	=	 "";
			if (isset($_REQUEST["id_compte_bancaire_source"])) {
			$infos ["id_compte_bancaire_source"]	=	 $_REQUEST["id_compte_bancaire_source"];
			}
		break;
		
		//sortant prelevement
		case "12":
			$infos ["id_compte_bancaire_source"]	=	 "";
			if (isset($_REQUEST["id_compte_bancaire_source"])) {
			$infos ["id_compte_bancaire_source"]	=	 $_REQUEST["id_compte_bancaire_source"];
			}
		break;
	
	}
	
	$reglement = new reglement ();
	$reglement->create_reglement ($infos);  
	
	$i = 0;
	
	foreach ($_REQUEST as $variable => $valeur) {
		if (substr_count($variable, "docs_")) {
		 echo $valeur."<br/>";
			if ($i == 0) { $ref_doc = $valeur;}
			$document = open_doc ($valeur);
			$document->rapprocher_reglement ($reglement);
			$i++;
		}
	}

}


// *************************************************************************************************************
// AFFICHAGE
// -*************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_annuaire_compta_reglements_mode_valid.inc.php");

?>