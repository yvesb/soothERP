<?php
// *************************************************************************************************************
// AFFICHAGE DES EVENEMENTS D'UNE FICHE DE CONTACT
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");
require ($DIR.$_SESSION['theme']->getDir_theme()."_theme.config.php" );

// *************************************************************************************************************
// TRAITEMENTS
// *************************************************************************************************************


// Controle

	if (!isset($_REQUEST['ref_contact'])) {
		echo "La référence du contact n'est pas précisée";
		exit;
	}

	$contact = new contact ($_REQUEST['ref_contact']);
	if (!$contact->getRef_contact()) {
		echo "La référence du contact est inconnue";		exit;

	}


//chargement de l'evenement
$evenement = $contact->charger_evenement ($_REQUEST['id_comm_event']);

$liste_types_evenements = contact::charger_types_evenements_liste();


// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_annuaire_view_evenements_mod.inc.php");

?>