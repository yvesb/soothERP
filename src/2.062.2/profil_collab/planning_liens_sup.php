<?php
// *************************************************************************************************************
// SUPPRESSION D'UN LIEN FAVORI
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");

//modification du lien

if (isset($_REQUEST["id_web_link"])) {
	$liens = new web_link ($_REQUEST["id_web_link"]);
	$liens->delete_web_link();
}
	
	
// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_planning_liens_sup.inc.php");

?>