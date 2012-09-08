<?php
// *************************************************************************************************************
// PAGE mentions legales
// *************************************************************************************************************

$_PAGE['MUST_BE_LOGIN'] = 0;
require("_dir.inc.php");
require("_profil.inc.php");
require("_session.inc.php");



gestion_panier();
$liste_contenu = $_SESSION["panier_interface_".$_INTERFACE['ID_INTERFACE']]["contenu"];
	
// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_mentionslegales.inc.php");

?>