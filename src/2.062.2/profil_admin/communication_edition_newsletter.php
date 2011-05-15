<?php
// *************************************************************************************************************
// ACCUEIL DE L'UTILISATEUR ADMINISTRATEUR
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");

$newsletter = new newsletter ($_REQUEST["id_newsletter"]);

$id_newsletter =$newsletter->getId_newsletter();
$mail_templates = charger_mail_templates();
$newsletter_profils = getNewsletter_Profils($id_newsletter);

$envoyer_a = $newsletter->charge_inscrits (1);
$refuser_a = $newsletter->charge_inscrits (0);

// *************************************************************************************************************
// AFFICHAGE
// -*************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_communication_edition_newsletter.inc.php");

?>