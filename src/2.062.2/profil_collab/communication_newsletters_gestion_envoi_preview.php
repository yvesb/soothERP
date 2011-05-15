<?php
// *************************************************************************************************************
// PREVIEW DE MODELE DE MAIL
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");


$newsletter = new newsletter ($_REQUEST["id_newsletter_preview"]);

$mail_template = new mail_template ($newsletter->getId_mail_template());


$contact_entreprise = new contact($REF_CONTACT_ENTREPRISE);
$nom_entreprise = str_replace (CHR(13), " " ,str_replace (CHR(10), " " , $contact_entreprise->getNom()));
// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************
include ($DIR.$_SESSION['theme']->getDir_theme()."page_communication_newsletters_gestion_envoi_preview.inc.php");

?>