<?php
// *************************************************************************************************************
// GESTION SIMPLE DU CONTENU DES CATALOGUES CLIENTS
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");

//liste des catalogues clients
$catalogues_clients = catalogue_client::charger_liste_catalogues_clients ();

//liste des catégories d'articles
$list_art_categ =	get_articles_categories("", array($LIVRAISON_MODE_ART_CATEG));

//Liste des catégories d'articles attribuées aux catalogues clients
$catalogues_clients_dir = catalogue_client::charger_liste_catalogues_clients_dir();
// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_catalogues_clients_edition_simple.inc.php");

?>