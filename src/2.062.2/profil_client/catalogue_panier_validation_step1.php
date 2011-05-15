<?php
// *************************************************************************************************************
// CATALOGUE CLIENT PANIER pre-validation
// *************************************************************************************************************

require("_dir.inc.php");
require ("_profil.inc.php");
require ("_session.inc.php");


if (!$_SESSION['user']->getLogin())
{		header ("Location: _user_login.php?page_from=".$_SERVER['PHP_SELF']);}

//GESTION DU PANIER
$GLOBALS['_OPTIONS']['CREATE_DOC']['ref_contact'] = $_SESSION['user']->getRef_contact ();
gestion_panier();

$liste_contenu = $_SESSION["panier_interface_".$_INTERFACE['ID_INTERFACE']]["contenu"];

if (count($liste_contenu) == 0) // Si le panier est vide, on redirige vers catalogue_panier_view.php
{		header ("Location: catalogue_panier_view.php");}

$contact = new contact($_SESSION['user']->getRef_contact());
$profil_client = $contact->getProfil($CLIENT_ID_PROFIL);

$liste_coordonnees = $contact->getCoordonnees();
$liste_adresses = $contact->getAdresses();

if ($profil_client->getRef_adr_facturation ()) {
	$adresse_facturation = new adresse ($profil_client->getRef_adr_facturation ());
} else {
	if (isset($liste_adresses[0])) {
		$adresse_facturation = new adresse ($liste_adresses[0]->getRef_adresse ());
	} else {
		$adresse_facturation = new adresse ();
	}
}
if ($profil_client->getRef_adr_livraison ()) {
	$adresse_livraison = new adresse ($profil_client->getRef_adr_livraison ());
} else {
	if (isset($liste_adresses[0])) {
		$adresse_livraison = new adresse ($liste_adresses[0]->getRef_adresse ());
	} else {
		$adresse_livraison = new adresse ();
	}
}

$users = $contact->getUtilisateurs ();

$listepays = getPays_select_list ();

$civilites = get_civilites ($contact->getId_Categorie());

$ANNUAIRE_CATEGORIES	=	get_categories();

$listepays = getPays_select_list ();
// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_catalogue_panier_validation_step1.inc.php");

?>