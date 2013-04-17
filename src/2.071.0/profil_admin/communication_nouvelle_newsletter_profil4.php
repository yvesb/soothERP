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
$liste_categories_clients = contact_client::charger_clients_categories ();


$ANNUAIRE_CATEGORIES	=	get_categories();
// *************************************************************************************************************
// AFFICHAGE
// -*************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_communication_nouvelle_newsletter_profil4.inc.php");

?>