<?php
// *************************************************************************************************************
// IDENTIFICATION DE L'UTILISATEUR CLIENT
// *************************************************************************************************************


require("_dir.inc.php");
require("_profil.inc.php");
require("_session.inc.php");


gestion_panier();
$liste_contenu = $_SESSION["panier_interface_".$_INTERFACE['ID_INTERFACE']]["contenu"];


// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_user_account.inc.php");

?>