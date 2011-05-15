<?php
// *************************************************************************************************************
// CATALOGUE CLIENT PANIER validation
// *************************************************************************************************************

require("_dir.inc.php");
require ("_profil.inc.php");
require ("_session.inc.php");




// *************************************************************************************************************
function make_reglement_first_step(&$infos, $ref_contact, $id_reglement_mode, $montant, $t = null){
	global $ID_COMPTE_CAISSE_DESTINATION;
	if(is_null($t) || !is_numeric($t) || $t < 0 ){$t = time();}
	
	$infos["id_reglement_mode"]			=	$id_reglement_mode;
	$infos["ref_contact"]						=	$ref_contact;
	$infos["direction_reglement"]		=	"entrant";
	$infos["montant_reglement"]			=	$montant;
	$infos["date_reglement"]				=	strftime("%Y-%m-%d %H:%M:%S", $t);
	$infos["date_echeance"]					=	strftime("%Y-%m-%d %H:%M:%S", $t);
	$infos["id_compte_caisse_dest"]	=	$ID_COMPTE_CAISSE_DESTINATION;
}

function make_reglement_cb(&$infos, &$cdc, $montant, $t = null){
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
}

function make_reglement_virement(&$infos, $id_compte_bancaire_source){
	$infos ["id_compte_bancaire_source"]	=	 $id_compte_bancaire_source;
}

function make_reglement_prelevement(&$infos, $id_compte_bancaire_source){
	$infos ["id_compte_bancaire_source"]	=	 $id_compte_bancaire_source;
}

function make_reglement_last_step(&$infos, &$doc){
	$reglement = new reglement ();
	$reglement->create_reglement($infos);
	if($cdc->rapprocher_reglement($reglement))//le règlement a été associé	=> CDC passe en état 'En cours' (état 9)
	{		$cdc->maj_etat_doc(9);}
	else{}//aucun règlement n'a été associé	=> CDC reste en état 'A valider' (état 8)
	
	return $cdc->getId_etat_doc();
}
// *************************************************************************************************************



if (!$_SESSION['user']->getLogin())
{		header ("Location: _user_login.php?page_from=".$_SERVER['PHP_SELF']);}

//On récupère le moyen de paiement
if(!isset($_REQUEST["id_reglement_mode"])){
	echo "le regelement n'est pas spécifié";
	exit;
}
$id_reglement_mode = $_REQUEST["id_reglement_mode"];


gestion_panier();
if (count($_SESSION["panier_interface_".$_INTERFACE['ID_INTERFACE']]["contenu"]) == 0) 
{		header ("Location: catalogue_panier_view.php");}

//Récupération du panier
unset($GLOBALS['_OPTIONS']['CREATE_DOC']);
$GLOBALS['_OPTIONS']['CREATE_DOC']['ref_contact'] = $_SESSION['user']->getRef_contact();
$panier = open_client_panier ();

if (count($panier->getContenu()) == 0)
{		header ("Location: catalogue_panier_view.php");}


//On valide le panier
//Etats du documents 'Panier Client / PAC'
//41 => En saisie
//42 => Validé
//43 => Annulé
$panier->maj_etat_doc(42);

//On récupère le BLC créé par le changement d'état du panier
$cdc = open_doc($GLOBALS['_INFOS']['ref_doc_copie']);

//On supprime le panier, on en a plus besoin
setcookie("panier_interface_".$_INTERFACE['ID_INTERFACE'], "", time() - 3600);
if (isset($_SESSION["panier_interface_".$_INTERFACE['ID_INTERFACE']]))
{		interface_del_panier();}
unset($_SESSION["panier_interface_".$_INTERFACE['ID_INTERFACE']]);
unset($panier);

//Etats du document 'Bon de Commande / CDC'
//6 => En saisie
//7 => Annulée
//8 => A valider
//9 => En cours
//10 => Traitée 
//Si aucun règlement n'est associé 		=> CDC reste en état 'A valider' (état 8)
//Si on a associe un règlement valide	=> CDC passe en état 'En cours' (état 9)

//On traite le moyen de paiement
$infos = array();
$t = time();
switch ($id_reglement_mode) {
	case "2":{ //entrant cheque => règlement à la réception du chèque
	break;}
	
	case "3":{ //entrant cb
			make_reglement_first_step($infos, $cdc->getRef_contact(), $id_reglement_mode, $montant, $t);
			make_reglement_cb($cdc, $infos, $id_reglement_mode, $montant, $t);
			make_reglement_last_step($infos, $doc);
	break;}
	
	case "4":{ //entrant virement
		make_reglement_first_step($infos, $cdc->getRef_contact(), $id_reglement_mode, $montant, $t);
		make_reglement_virement($infos, $id_compte_bancaire_source);
		make_reglement_last_step($infos, $doc);
	break;}
	
	case "5":{ //entrant lettre => règlement à la réception de la lettre
	break;}
	
	case "6":{ //entrant prelevement
		make_reglement_first_step($infos, $cdc->getRef_contact(), $id_reglement_mode, $montant, $t);
		make_reglement_prelevement($infos, $id_compte_bancaire_source);
		make_reglement_last_step($infos, $doc);
	break;}
}
unset($infos);

$liste_contenu = array();

// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_catalogue_panier_validation_step4.inc.php");

?>
