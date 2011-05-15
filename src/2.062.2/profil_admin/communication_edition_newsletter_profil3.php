<?php
// *************************************************************************************************************
// ACCUEIL DE L'UTILISATEUR ADMINISTRATEUR
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");

$contact = new contact ($REF_CONTACT_ENTREPRISE);

$liste_profils_contact = ($contact->getProfils ());
if (isset ($liste_profils_contact [$COLLAB_ID_PROFIL])) {
	$liste_fonctions_collab = charger_fonctions ($COLLAB_ID_PROFIL);
}

$newsletter_profils_criteres = getNewsletter_Profil_Criteres($_REQUEST["id_newsletter"],$COLLAB_ID_PROFIL);

$collab_fct = array();
if (isset($newsletter_profils_criteres[0])) {$collab_fct = explode(";", $newsletter_profils_criteres[0]);}

// *************************************************************************************************************
// AFFICHAGE
// -*************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_communication_edition_newsletter_profil3.inc.php");

?>