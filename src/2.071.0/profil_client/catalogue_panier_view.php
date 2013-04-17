<?php
// *************************************************************************************************************
// CATALOGUE CLIENT PANIER RESUME
// *************************************************************************************************************


require("_dir.inc.php");
require ("_profil.inc.php");
require ("_session.inc.php");



$GLOBALS['_OPTIONS']['CREATE_DOC']['ref_contact'] = $_SESSION['user']->getRef_contact ();
gestion_panier();
$liste_contenu = $_SESSION["panier_interface_".$_INTERFACE['ID_INTERFACE']]["contenu"];

// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_catalogue_panier_view.inc.php");

?>