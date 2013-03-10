<?php
// *************************************************************************************************************
// GESTION des newsletters préparation de l'envoi
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");

if (!$_SESSION['user']->check_permission ("14")) {
		//on indique l'interdiction et on stop le script
		echo "<br /><span style=\"font-weight:bolder;color:#FF0000;\">Vos droits  d'accés ne vous permettent pas de visualiser ce type de page</span>";
		exit();
}

$newsletter = new newsletter ($_REQUEST["id_newsletter"]);
$liste_envois = $newsletter->charger_envois_newsletter ();
// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_communication_newsletters_gestion_archives.inc.php");

?>