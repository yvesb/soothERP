<?php
// *************************************************************************************************************
// AJOUT D'UN CATALOGUE CLIENT
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");


$catalogues_clients = new catalogue_client();
$catalogues_clients->create ($_REQUEST["lib_catalogue_client"]);
// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_catalogues_clients_add.inc.php");

?>