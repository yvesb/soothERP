<?php
// *************************************************************************************************************
// GESTION DU REFERENCEMENT DU SITE INTERNET
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");


//informations de référencement
$pages_referencees = get_reference($_REQUEST["nom_fichier"]);


// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_site_internet_referencement_details.inc.php");

?>