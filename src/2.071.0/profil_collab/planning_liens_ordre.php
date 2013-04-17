<?php
// *************************************************************************************************************
// MODIFICATION DE L'ORDRE D'UN LIEN FAVORI
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");

//modification du lien
if (isset($_REQUEST["id_web_link"])) {
	$liens = new web_link ($_REQUEST["id_web_link"]);
	$liens->maj_ordre($_REQUEST["ordre"]);
	
}
	
// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

//include ($DIR.$_SESSION['theme']->getDir_theme()."page_planning_liens_add.inc.php");

?>