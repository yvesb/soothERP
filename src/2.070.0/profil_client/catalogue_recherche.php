<?php
// *************************************************************************************************************
// CATALOGUE CLIENT
// *************************************************************************************************************

require("_dir.inc.php");
require ("_profil.inc.php");
require ("_session.inc.php");


//liste des categories du catalogue client
$list_catalogue_dir =	get_catalogue_client_dirs($ID_CATALOGUE_INTERFACE);

// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_catalogue.inc.php");

?>