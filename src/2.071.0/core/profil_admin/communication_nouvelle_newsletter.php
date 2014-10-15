<?php
// *************************************************************************************************************
// ACCUEIL DE L'UTILISATEUR ADMINISTRATEUR
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");

$contact = new contact ($REF_CONTACT_ENTREPRISE);
$coordonnees = $contact->getCoordonnees ();
$ref_coordonnees = $coordonnees[0]->getRef_coord();
$coordonnees_expediteur = new coordonnee ($ref_coordonnees);
$email_entreprise = $coordonnees_expediteur->getEmail();

$mail_templates = charger_mail_templates();

// *************************************************************************************************************
// AFFICHAGE
// -*************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_communication_nouvelle_newsletter.inc.php");

?>