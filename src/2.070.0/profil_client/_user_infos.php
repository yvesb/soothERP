<?php
// *************************************************************************************************************
// IDENTIFICATION DE L'UTILISATEUR CLIENT
// *************************************************************************************************************

$_PAGE['MUST_BE_LOGIN'] = 1;

require("_dir.inc.php");
require("_profil.inc.php");
require("_session.inc.php");



// * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *

gestion_panier();
$liste_contenu = $_SESSION["panier_interface_".$_INTERFACE['ID_INTERFACE']]["contenu"];

// * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *

$contact 							= new contact ($_SESSION['user']->getRef_contact());
$profil_client				= $contact->getProfil($CLIENT_ID_PROFIL);
$liste_adresses				= $contact->getAdresses();
$user									= current($contact->getUtilisateurs());
$coordonnee						= new coordonnee($user->getRef_coord_user());
$listepays						= getPays_select_list();
$civilites						= get_civilites($contact->getId_Categorie());
$ANNUAIRE_CATEGORIES	=	get_categories();

// * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *

if($profil_client->getRef_adr_facturation())
{		$adresse_facturation = new adresse($profil_client->getRef_adr_facturation());} 
elseif(isset($liste_adresses[1]))
{		$adresse_facturation = new adresse($liste_adresses[1]->getRef_adresse ());}
else
{		$adresse_facturation = new adresse();}

// * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *

if($profil_client->getRef_adr_livraison())
{		$adresse_livraison = new adresse($profil_client->getRef_adr_livraison());}
elseif(isset($liste_adresses[0]))
{		$adresse_livraison = new adresse($liste_adresses[0]->getRef_adresse ());}
else
{		$adresse_livraison = new adresse();}

// * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *

$editable = ($MODIFICATION_ALLOWED != 0);
//Valeurs de $MODIFICATION_ALLOWED
//
// 0 : modification impossible
//			
// 1 : modification d'un contact avec une validation par un collaborateur mais sans un mail de confirmation
// 3 : modification d'un contact avec une validation par un collaborateur mais avec un mail de confirmation
//
// 2 : modification d'un contact automatique sans mail de confirmation
// 4 : modification d'un contact automatique avec mail de confirmation

// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_user_infos.inc.php");

?>