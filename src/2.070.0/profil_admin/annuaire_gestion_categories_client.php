<?php
// *************************************************************************************************************
// ACCUEIL DE L'UTILISATEUR ADMINISTRATEUR
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");
require ($DIR.$_SESSION['theme']->getDir_theme()."_theme.config.php" );

// Fichier de configuration de ce profil
include_once ($CONFIG_DIR."profil_client.config.php");
// chargement de la class du profil
contact::load_profil_class($CLIENT_ID_PROFIL);
// Préparations des variables d'affichage
$liste_categories = contact_client::charger_clients_categories ();

//liste des tarifs
$tarifs_liste	= array();
$tarifs_liste = get_full_tarifs_listes ();

$reglements_modes = getReglements_modes();
$editions_modes = getEdition_modes_actifs();
//$cycles_relances = modele_echeancier::charger_modeles_echeances();
$cycles_relances = charger_factures_relances_modeles ();


//infos pour mini moteur de recherche contact
$profils_mini = array();
foreach ($_SESSION['profils'] as $profil) {
	if ($profil->getActif() != 1 && $profil->getActif() != 2) { continue; }
	$profils_mini[] = $profil;
}
unset ($profil);
	
// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_annuaire_gestion_categories_client.inc.php");

?>