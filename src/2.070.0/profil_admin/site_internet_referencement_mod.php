<?php
// *************************************************************************************************************
// GESTION DU REFERENCEMENT DU SITE INTERNET (modification)
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");


if (isset($_REQUEST["nom_fichier"])) {
	//mas des informations de référencement
	maj_reference ($_REQUEST["nom_fichier"], $_REQUEST["titre"], $_REQUEST["meta_desc"], $_REQUEST["meta_motscles"]);
}


// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_site_internet_referencement_mod.inc.php");

?>