<?php
// *************************************************************************************************************
// MODIFICATION D'UN CATALOGUE CLIENT
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");


$catalogues_clients = new catalogue_client($_REQUEST["id_catalogue_client"]);
$catalogues_clients->modification ($_REQUEST["lib_catalogue_client"]);
// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_catalogues_clients_mod.inc.php");

?>