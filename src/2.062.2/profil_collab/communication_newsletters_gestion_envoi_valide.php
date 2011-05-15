<?php
// *************************************************************************************************************
// PREVIEW DE MODELE DE MAIL
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");

if (!$_SESSION['user']->check_permission ("14")) {
		//on indique l'interdiction et on stop le script
		echo "<br /><span style=\"font-weight:bolder;color:#FF0000;\">Vos droits  d'accés ne vous permettent pas de visualiser ce type de page</span>";
		exit();
}

if (!isset($_REQUEST["id_newsletter"])) {exit;}

$newsletter = new newsletter ($_REQUEST["id_newsletter"]);
$mail_template = new mail_template ($newsletter->getId_mail_template());
$contact_entreprise = new contact($REF_CONTACT_ENTREPRISE);

$id_envoi = $_REQUEST["id_envoi"];


// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************
include ($DIR.$_SESSION['theme']->getDir_theme()."page_communication_newsletters_gestion_envoi_valide.inc.php");

?>