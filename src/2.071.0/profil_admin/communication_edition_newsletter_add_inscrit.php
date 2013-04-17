<?php
// *************************************************************************************************************
// GESTION DES NEWSLETTER supression d'un inscrit
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");


$newsletter = new newsletter ($_REQUEST['id_newsletter']);
if (!$newsletter->add_newsletter_inscrit ($_REQUEST["email"], $_REQUEST["nom"], $_REQUEST["inscrit"])) {$erreur = 1;}

$serialisation_envoyer_a = $_REQUEST["serialisation"];

// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_communication_edition_newsletter_add_inscrit.inc.php");
?>