<?php
// *************************************************************************************************************
// GESTION DES PDF ARTICLES
// *************************************************************************************************************

require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");


//variable nécessaires aux newsletter
$mail_templates = charger_mail_templates();

$liste_profils_contacts = fetch_all_profils_contacts();
$liste_pdf_modeles = charge_modele_pdf_annuaire();// charge_modele_pdf_contact ();
$liste_pour_activation = getListePdfContact();

// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_communication_mod_fiche_contact.inc.php");

//include ($DIR.$_SESSION['theme']->getDir_theme()."page_articles_gestion_categ.inc.php");

?>