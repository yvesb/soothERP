<?php
// *************************************************************************************************************
// CONFIRGURATION DES DONNÉES pdf
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");


					
// *************************************************
// Mise a jour de la base
	
if (isset ($_REQUEST["lib_filigrane_".$_REQUEST["id_filigrane"]]) && isset ($_REQUEST["id_filigrane"])) {
	maj_filigranes ($_REQUEST["lib_filigrane_".$_REQUEST["id_filigrane"]], $_REQUEST["id_filigrane"]);
}
	

// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_configuration_pdf_fili_maj.inc.php");
?>