<?php
// *************************************************************************************************************
// ACCUEIL DE L'UTILISATEUR ADMINISTRATEUR
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");

contact::load_profil_class($FOURNISSEUR_ID_PROFIL);
$liste_categories_fournisseur = contact_fournisseur::charger_fournisseurs_categories ();

// *************************************************************************************************************
// AFFICHAGE
// -*************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_communication_nouvelle_newsletter_profil5.inc.php");

?>