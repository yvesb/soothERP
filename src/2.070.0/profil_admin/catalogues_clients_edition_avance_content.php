<?php
// *************************************************************************************************************
// GESTION AVANCEE DU CONTENU DES CATALOGUES CLIENTS (AFFICHAGE DES CATEGORIES)
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");




//liste des categories du catalogue client
$list_catalogue_dir =	get_catalogue_client_dirs($_REQUEST["id_catalogue_client"]);

// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_catalogues_clients_edition_avance_content.inc.php");

?>