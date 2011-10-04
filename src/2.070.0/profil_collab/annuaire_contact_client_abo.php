<?php
// *************************************************************************************************************
// 
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

// Préparations des variables d'affichage
$profils 	= $contact->getProfils();

//chargement des infos de clients
if ($CLIENT_ID_PROFIL != 0) {
	include ($CONFIG_DIR."profil_".$_SESSION['profils'][$CLIENT_ID_PROFIL]->getCode_profil().".config.php");
	contact::load_profil_class($CLIENT_ID_PROFIL);
	$liste_categories_client = contact_client::charger_clients_categories ();
}


if(isset($profils[$CLIENT_ID_PROFIL]) ) {
	//liste des abonnements du clients
	$client_abo = $profils[$CLIENT_ID_PROFIL]->charger_client_abo();
	
}

if(isset($_REQUEST["develop_abo"])){
	$develop_abo = $_REQUEST["develop_abo"];
}

// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_annuaire_contact_client_abo.inc.php");
?>