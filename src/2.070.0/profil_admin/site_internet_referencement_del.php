<?php
// *************************************************************************************************************
// GESTION DU REFERENCEMENT DU SITE INTERNET (suppression)
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");


if (isset($_REQUEST["nom_fichier"])) {
	//mas des informations de référencement
	del_reference ($_REQUEST["nom_fichier"]);
}


// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_site_internet_referencement_del.inc.php");

?>