<?php
// *************************************************************************************************************
// GESTION AVANCEE DU CONTENU DES CATALOGUES CLIENTS
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");

//liste des catalogues clients
$catalogues_clients = catalogue_client::charger_liste_catalogues_clients ();

// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_catalogues_clients_edition_avance.inc.php");

?>