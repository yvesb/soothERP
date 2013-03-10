<?php
// *************************************************************************************************************
// CONFIGURATION DES DONNÉES de TAXE
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");


if (isset($_REQUEST["id_taxe"]) && isset($_REQUEST["lib_taxe_".$_REQUEST["id_taxe"]]) && isset($_REQUEST["visible_".$_REQUEST["id_taxe"]])) {
	$taxe = new taxe ($_REQUEST["id_taxe"]);
	$taxe->modif_taxe($_REQUEST["lib_taxe_".$_REQUEST["id_taxe"]], $_REQUEST["visible_".$_REQUEST["id_taxe"]]);
}


// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_configuration_taxes_maj.inc.php");
?>