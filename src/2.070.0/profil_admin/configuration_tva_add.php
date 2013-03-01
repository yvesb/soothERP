<?php
// *************************************************************************************************************
// Modification d'un taux de TVA
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");

if (isset($_REQUEST["id_pays"])) {
	$infos_tva = array();
	$infos_tva["id_pays"] = $_REQUEST["id_pays"];
	$infos_tva["tva"] =  $_REQUEST["tva"];
	$tvas = add_tva ($infos_tva);
}
// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_configuration_tva_add.inc.php");

?>