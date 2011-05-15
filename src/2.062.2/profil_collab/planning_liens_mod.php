<?php
// *************************************************************************************************************
// MODIFICATION D'UN LIEN FAVORI
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");

//modification du lien

if (isset($_REQUEST["ident"]) && isset($_REQUEST["id_web_link_".$_REQUEST["ident"]])) {
	$liens = new web_link ($_REQUEST["id_web_link_".$_REQUEST["ident"]]);
	$liens->maj_web_link($_REQUEST["lib_web_link_".$_REQUEST["ident"]], $_REQUEST["url_web_link_".$_REQUEST["ident"]], $_REQUEST["desc_web_link_".$_REQUEST["ident"]]);
}
	
	
// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_planning_liens_mod.inc.php");

?>