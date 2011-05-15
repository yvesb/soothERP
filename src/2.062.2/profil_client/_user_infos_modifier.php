<?php
// *************************************************************************************************************
// INSCRIPTION DE L'UTILISATEUR CLIENT
// *************************************************************************************************************

require("_dir.inc.php");
require("_profil.inc.php");
require("_session.inc.php");



//##################
//	/!\ ATTENTION ! 
//##################
//	NE PAS UTILISER CE GENRE DE BOUCLE !!!
//	Ca rend l'interface graphique EXTREMENT dépendante du code métier!
//	foreach ($_REQUEST as $key=>$value) {
//		if($key != "user_societe" || $key != "user_nom" || $key != "user_prenom"){
//			$liste_reponse[$key] = $key."=".$value;
//			if ($key == "admin_emaila") { $email = $value;}
//		}
//	}
//	
//	La solution est de "mapper" les données,
//	c'est à dire avoir une correspondance entre les variables (inputs) de l'interface et les variables du code métier.
//	Ca permet de rendre le code plus souple, plus modulable et plus robuste au changement (code metier ou interface)


$infos_contact_code_metier = array();

//les champs avec un * sont indispendables 
//
//A droite, le tableau associatif nécessaire au code métier
//		$infos_contact_code_metier[KEY_METIER]	=  KEY_METIER."="
//A agauche, les noms des inputs de l'interface graphique
//		$_REQUEST[KEY_INTERFACE];
if(isset($_REQUEST["id_categorie"]))
{		$infos_contact_code_metier["id_categorie"]	=  "id_categorie"."=". $_REQUEST["id_categorie"];}

if(isset($_REQUEST["id_civilite"]))
{		$infos_contact_code_metier["id_civilite"]			=  "id_civilite"."=". $_REQUEST["id_civilite"];}

if(!isset($_REQUEST["nom"]))	// *
{		echo "le nom n'est pas spécifié";	exit;}
		$infos_contact_code_metier["nom"]						=  "nom"."=". $_REQUEST["nom"];
$nom = $_REQUEST["nom"];

if(isset($_REQUEST["siret"]))
{		$infos_contact_code_metier["siret"]					=  "siret"."=". $_REQUEST["siret"];}

if(isset($_REQUEST["tva_intra"]))
{		$infos_contact_code_metier["tva_intra"]			=  "tva_intra"."=". $_REQUEST["tva_intra"];}

//---------------------------------------------------------------

if(!isset($_REQUEST["pseudo"]))	// *
{		echo "le pseudo n'est pas spécifié";	exit;}
		$infos_contact_code_metier["admin_pseudo"] =  "admin_pseudo"."=". $_REQUEST["pseudo"];

//---------------------------------------------------------------

if(!isset($_REQUEST["emaila"]))	// *
{		echo "le pseudo n'est pas spécifié";	exit;}
		$infos_contact_code_metier["admin_emaila"] =  "admin_emaila"."=". $_REQUEST["emaila"];
$email = $_REQUEST["emaila"];
//---------------------------------------------------------------

if(isset($_REQUEST["passworda"]))
{		$infos_contact_code_metier["admin_passworda"] =  "admin_passworda"."=". $_REQUEST["passworda"];}

if(isset($_REQUEST["passwordold"]))
{		$infos_contact_code_metier["admin_passwordold"] =  "admin_passwordold"."=". $_REQUEST["passwordold"];}
//---------------------------------------------------------------

//if(isset($_REQUEST[""]))
//{		$infos_contact_code_metier["ref_adr_livraison"] =  "ref_adr_livraison"."=". $_REQUEST[""];}

if(isset($_REQUEST["livraison_adresse"]))
{		$infos_contact_code_metier["livraison_adresse"]		=  "livraison_adresse"."=". $_REQUEST["livraison_adresse"];}

if(isset($_REQUEST["livraison_code_postal"]))
{		$infos_contact_code_metier["livraison_code"]			=  "livraison_code"."=". $_REQUEST["livraison_code_postal"];}

if(isset($_REQUEST["livraison_ville"]))
{		$infos_contact_code_metier["livraison_ville"]			=  "livraison_ville"."=". $_REQUEST["livraison_ville"];}

if(isset($_REQUEST["livraison_id_pays"]))
{		$infos_contact_code_metier["id_pays_livraison"]		=  "id_pays_livraison"."=". $_REQUEST["livraison_id_pays"];}

//---------------------------------------------------------------

//if(isset($_REQUEST[""]))
//{		$infos_contact_code_metier["ref_adr_facturation"] =  "ref_adr_facturation"."=". $_REQUEST[""];}

if(!isset($_REQUEST["facturation_adresse"]))	// *
{		echo "l'adresse de facturation n'est pas spécifié";	exit;}
		$infos_contact_code_metier["adresse_adresse"]		=  "adresse_adresse"."=". $_REQUEST["facturation_adresse"];

if(!isset($_REQUEST["facturation_code_postal"]))	// *
{		echo "le code postal de l'adresse de facturation n'est pas spécifié";	exit;}
		$infos_contact_code_metier["adresse_code"]			=  "adresse_code"."=". $_REQUEST["facturation_code_postal"];

if(!isset($_REQUEST["facturation_ville"]))	// *
{		echo "la ville de l'adresse de facturation n'est pas spécifiée";	exit;}
		$infos_contact_code_metier["adresse_ville"]			=  "adresse_ville"."=". $_REQUEST["facturation_ville"];

if(!isset($_REQUEST["facturation_id_pays"]))	// *
{		echo "le pays  de l'adresse de facturation n'est pas spécifié";	exit;}
		$infos_contact_code_metier["id_pays_contact"]			=  "id_pays_contact"."=". $_REQUEST["facturation_id_pays"];

//---------------------------------------------------------------

if(isset($_REQUEST["coordonnee_tel1"]))
{		$infos_contact_code_metier["coordonnee_tel1"]		=  "coordonnee_tel1"."=". $_REQUEST["coordonnee_tel1"];}

if(isset($_REQUEST["coordonnee_tel2"]))
{		$infos_contact_code_metier["coordonnee_tel2"]		=  "coordonnee_tel2"."=". $_REQUEST["coordonnee_tel2"];}

if(isset($_REQUEST["coordonnee_fax"]))
{		$infos_contact_code_metier["coordonnee_fax"]		=  "coordonnee_fax"."=". $_REQUEST["coordonnee_fax"];}

//---------------------------------------------------------------

$infos_contact_code_metier["ref_contact"] = "ref_contact"."=". $_SESSION['user']->getRef_contact();

//---------------------------------------------------------------

//inscription à la newsletter
//if(isset($_REQUEST['newsletter'])){}

//---------------------------------------------------------------

// * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *

require_once("_inscription_profil_client.class.php");

//SI l'email a été modifié -> La confirmation est OBLIGATOIRE !
// $MODIFICATION_ALLOWED
// 0 : modification impossible
//			-> Ne rien faire
// 1 : modification d'un contact avec une validation par un collaborateur mais sans un mail de confirmation
//			-> devient : 3
// 3 : modification d'un contact avec une validation par un collaborateur mais avec un mail confirmation
// 2 : modification d'un contact automatique sans mail de confirmation
//			-> devient : 4
// 4 : modification d'un contact automatique avec mail de confirmation

if($email != $_SESSION['user']->getEmail() && $MODIFICATION_ALLOWED == 1)
{		$modification = new Modification_profil_client($_INTERFACE['ID_INTERFACE'], 3);}
elseif($email != $_SESSION['user']->getEmail() && $MODIFICATION_ALLOWED == 2)
{		$modification = new Modification_profil_client($_INTERFACE['ID_INTERFACE'], 4);}
else
{		$modification = new Modification_profil_client($_INTERFACE['ID_INTERFACE'], $MODIFICATION_ALLOWED);}

// * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *

$prise_en_compte_de_modification = $modification->modification_contact($_SESSION['user']->getRef_contact(), $infos_contact_code_metier, $email);

// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

include($DIR.$_SESSION['theme']->getDir_theme()."page_user_infos_modifier.inc.php");

?>