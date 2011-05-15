<?php
// *************************************************************************************************************
// GESTION DES PDF ARTICLES
// *************************************************************************************************************

require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");


//variable nécessaires aux newsletter
$mail_templates = charger_mail_templates();

$liste_categs_articles = fetch_all_categs_articles();
$liste_pdf_modeles = charge_modele_pdf_article ();
$liste_pour_activation = getListePdfArt();

// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_communication_mod_fiche_art.inc.php");

//include ($DIR.$_SESSION['theme']->getDir_theme()."page_articles_gestion_categ.inc.php");

?>