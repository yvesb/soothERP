<?php
// *************************************************************************************************************
// ACCUEIL DE L'UTILISATEUR ADMINISTRATEUR
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");

contact::load_profil_class($FOURNISSEUR_ID_PROFIL);
$liste_categories_fournisseur = contact_fournisseur::charger_fournisseurs_categories ();

$newsletter_profils_criteres = getNewsletter_Profil_Criteres($_REQUEST["id_newsletter"],$FOURNISSEUR_ID_PROFIL);

$fourn_cat = array();
if (isset($newsletter_profils_criteres[0])) {$fourn_cat = explode(";", $newsletter_profils_criteres[0]);}
// *************************************************************************************************************
// AFFICHAGE
// -*************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_communication_edition_newsletter_profil5.inc.php");

?>