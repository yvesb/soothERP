<?php
// *************************************************************************************************************
// ACCUEIL DE L'UTILISATEUR ADMINISTRATEUR
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");

// Fichier de configuration de ce profil
include_once ($CONFIG_DIR."profil_client.config.php");
// chargement de la class du profil
contact::load_profil_class($CLIENT_ID_PROFIL);
// Préparations des variables d'affichage
$ANNUAIRE_CATEGORIES	=	get_categories();

$liste_categories_clients = contact_client::charger_clients_categories ();

$newsletter_profils_criteres = getNewsletter_Profil_Criteres($_REQUEST["id_newsletter"],$CLIENT_ID_PROFIL);


$client_categorie = array();
$client_type = array();
$client_categ = array();
$client_cp = "";

if (isset($newsletter_profils_criteres[0])) {
	$client_categorie = explode(";", $newsletter_profils_criteres[0]);
	$client_type = explode(";", $newsletter_profils_criteres[1]);
	$client_categ = explode(";", $newsletter_profils_criteres[2]);
	$client_cp = $newsletter_profils_criteres[3];
}

// *************************************************************************************************************
// AFFICHAGE
// -*************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_communication_edition_newsletter_profil4.inc.php");

?>