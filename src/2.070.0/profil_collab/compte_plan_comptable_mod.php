<?php
// *************************************************************************************************************
// Modification d'un compte d'art_categ
// *************************************************************************************************************



require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");
//var_dump ($_REQUEST);
if (isset($_REQUEST["cible"])) {
	
	switch ($_REQUEST["cible"]){

		case "compte_bancaire":
			if (isset($_REQUEST["cible_id"])) {
				$compte_bancaire = new compte_bancaire ($_REQUEST["cible_id"]);
				$compte_bancaire->maj_defaut_numero_compte($_REQUEST["retour_value"]);
				//mise en favori du compte correspondant
				$compte_plan_general = new compta_plan_general ($_REQUEST["retour_value"]);
				$compte_plan_general->active_compte ();
			}
			
		break;
		
		case "art_categ":
			if (isset($_REQUEST["cible_id"])) {
				$art_categ = new art_categ ($_REQUEST['cible_id']);
				
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
		break;
		case "article":
			if (isset($_REQUEST["cible_id"])) {
				$art = new article ($_REQUEST['cible_id']);
				
				if (isset($_REQUEST["type"]) && $_REQUEST["type"] == "achat") {
					$art->maj_numero_compte_achat($_REQUEST["retour_value"]);
					//mise en favori du compte correspondant
					$compte_plan_general = new compta_plan_general ($_REQUEST["retour_value"]);
					$compte_plan_general->active_compte ();
				}
				if (isset($_REQUEST["type"]) && $_REQUEST["type"] == "vente") {
					$art->maj_numero_compte_vente($_REQUEST["retour_value"]);
					//mise en favori du compte correspondant
					$compte_plan_general = new compta_plan_general ($_REQUEST["retour_value"]);
					$compte_plan_general->active_compte ();
				}
			}
		break;		
		case "compte_caisse":
			if (isset($_REQUEST["cible_id"])) {
				$compte_caisse = new compte_caisse ($_REQUEST['cible_id']);
				$compte_caisse->maj_defaut_numero_compte($_REQUEST["retour_value"]);
				//mise en favori du compte correspondant
				$compte_plan_general = new compta_plan_general ($_REQUEST["retour_value"]);
				$compte_plan_general->active_compte ();
			
			}
		break;
		case "tiers_achat":
			// Fichier de configuration de ce profil
			include_once ($CONFIG_DIR."profil_fournisseur.config.php");
			
			// chargement de la class du profil
			contact::load_profil_class($FOURNISSEUR_ID_PROFIL);
			
			
			if (isset($_REQUEST["cible_id"])) {
			
				$infos	=	array();
				$infos['id_fournisseur_categ']				=	$_REQUEST["cible_id"];
				$infos['defaut_numero_compte']				=	$_REQUEST["retour_value"];
				//création de la catégorie
				contact_fournisseur::maj_defaut_numero_compte_categories ($infos);
			
			}
		break;
		case "compte_tpe":
			if (isset($_REQUEST["cible_id"])) {
			$compte_tpe = new compte_tpe ($_REQUEST['cible_id']);
			
				$compte_tpe->maj_defaut_numero_compte($_REQUEST["retour_value"]);
				//mise en favori du compte correspondant
				$compte_plan_general = new compta_plan_general ($_REQUEST["retour_value"]);
				$compte_plan_general->active_compte ();
			
			}
		break;
		case "compte_tpv":
			if (isset($_REQUEST["cible_id"])) {
				$compte_tpv = new compte_tpv ($_REQUEST['cible_id']);
				$compte_tpv->maj_defaut_numero_compte($_REQUEST["retour_value"]);
				//mise en favori du compte correspondant
				$compte_plan_general = new compta_plan_general ($_REQUEST["retour_value"]);
				$compte_plan_general->active_compte ();
			
			}
		break;
			//@FIXME	Erreur	
		case "client_categ":
			// Fichier de configuration de ce profil
			include_once ($CONFIG_DIR."profil_client.config.php");
			// chargement de la class du profil
			contact::load_profil_class($CLIENT_ID_PROFIL);
			if (isset($_REQUEST["cible_id"])) {
				$infos	=	array();
				$infos['id_client_categ']		=	$_REQUEST["cible_id"];
				$infos['defaut_numero_compte']	=	$_REQUEST["retour_value"];
				//création de la catégorie
				contact_client::maj_defaut_numero_compte_categories ($infos);
			}
		break;	
		//@FIXME	fixed	
		case "fournisseur_categ":
			// Fichier de configuration de ce profil
			include_once ($CONFIG_DIR."profil_fournisseur.config.php");
			// chargement de la class du profil
			contact::load_profil_class($FOURNISSEUR_ID_PROFIL);
			if (isset($_REQUEST["cible_id"])) {
				$infos	=	array();
				$infos['id_fournisseur_categ']		=	$_REQUEST["cible_id"];
				$infos['defaut_numero_compte']	=	$_REQUEST["retour_value"];
				//création de la catégorie
				contact_fournisseur::maj_defaut_numero_compte_categories ($infos);
			}
		break;
			//@FIXME	fixed
		case "compta_fournisseur":
			// Fichier de configuration de ce profil
			include_once ($CONFIG_DIR."profil_fournisseur.config.php");
			// chargement de la class du profil
			contact::load_profil_class($FOURNISSEUR_ID_PROFIL);
			if (isset($_REQUEST["cible_id"])) {
				$fournisseur = new contact_fournisseur($_REQUEST["cible_id"]);
				$infos	=	array();
				$fournisseur->maj_defaut_numero_compte($_REQUEST["retour_value"]);
			}
		break;	
			//@FIXME	fixed	
		case "compta_client":
			// Fichier de configuration de ce profil
			include_once ($CONFIG_DIR."profil_client.config.php");
			// chargement de la class du profil
			contact::load_profil_class($CLIENT_ID_PROFIL);
			if (isset($_REQUEST["cible_id"])) {
				$contact = new contact_client($_REQUEST["cible_id"]);
				$infos	=	array();
				$contact->maj_defaut_numero_compte($_REQUEST["retour_value"]);
			}
		break;		
		case "tva":
			if (isset($_REQUEST["cible_id"])) {
				$infos_tva = array();
				if ( isset($_REQUEST["type"]) && $_REQUEST["type"] == "achat" ) {
					$infos_tva["num_compte_achat"] =  $_REQUEST["retour_value"];
					//mise en favori du compte correspondant
					$compte_plan_general = new compta_plan_general ($_REQUEST["retour_value"]);
					$compte_plan_general->active_compte ();
				}
				if ( isset($_REQUEST["type"]) && $_REQUEST["type"] == "vente" ) {
					$infos_tva["num_compte_vente"] =  $_REQUEST["retour_value"];
					//mise en favori du compte correspondant
					$compte_plan_general = new compta_plan_general ($_REQUEST["retour_value"]);
					$compte_plan_general->active_compte ();
				}
				$tvas = maj_tva ($_REQUEST["cible_id"], $infos_tva);
			}
		break;
		case "line":
			//@FIXME en tests
		break;
	}
}
include ($DIR.$_SESSION['theme']->getDir_theme()."page_compte_plan_comptable_mod.inc.php");

?>