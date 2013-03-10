<?php
// *************************************************************************************************************
// CONFIRGURATION DES DONNÉES pdf
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");


	
// *************************************************
// supression dans la base
if (isset ($_REQUEST["id_filigrane"]) && isset ($_REQUEST["ordre"])) {
	sup_filigranes ($_REQUEST["id_filigrane"], $_REQUEST["ordre"]);
}
// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_configuration_pdf_fili_maj.inc.php");
?>