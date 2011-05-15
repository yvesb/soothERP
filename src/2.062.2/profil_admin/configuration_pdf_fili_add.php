<?php
// *************************************************************************************************************
// CONFIRGURATION DES DONNÉES pdf
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");


	
// *************************************************
// ajout dans la base
if (isset ($_REQUEST["lib_filigrane"]) && isset ($_REQUEST["ordre_fili"])) {
	add_filigranes ($_REQUEST["lib_filigrane"], $_REQUEST["ordre_fili"]);
}
// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_configuration_pdf_fili_maj.inc.php");
?>