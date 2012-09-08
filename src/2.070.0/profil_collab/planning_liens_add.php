<?php
// *************************************************************************************************************
// AJOUT D'UN LIEN FAVORI
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");

//insertion du lien
$liens = new web_link ();
$liens->create_web_link($_REQUEST["lib_web_link"], $_REQUEST["url_web_link"], $_REQUEST["desc_web_link"]);
	
	
// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_planning_liens_add.inc.php");

?>