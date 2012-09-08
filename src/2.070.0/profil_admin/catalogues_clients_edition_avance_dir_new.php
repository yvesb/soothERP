<?php
// *************************************************************************************************************
// EDITION DES INFORMATIONS D'UNE CATEGORIE D'UN CATALOGUE CLIENT
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");
require ($DIR.$_SESSION['theme']->getDir_theme()."_theme.config.php" );



//id_catalogue_client
//&id_catalogue_client_dir_parent=&lib_catalogue_client_dir=Racine

//liste des categories du catalogue client
$list_catalogue_dir =	get_catalogue_client_dirs($_REQUEST["id_catalogue_client"]);

//chargement des art_categ
$select_art_categ =	get_articles_categories();

// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************


include ($DIR.$_SESSION['theme']->getDir_theme()."page_catalogues_clients_edition_avance_dir_new.inc.php");

?>