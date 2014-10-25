<?php
// *************************************************************************************************************
// SUPPRESSION D'UN CATALOGUE CLIENT
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");


$catalogues_clients = new catalogue_client($_REQUEST["id_catalogue_client"]);
$catalogues_clients->suppression ();
// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_catalogues_clients_sup.inc.php");

?>