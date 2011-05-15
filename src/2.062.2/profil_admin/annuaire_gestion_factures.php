<?php
// *************************************************************************************************************
// ACCUEIL GESTION FACTURES NIVEAUX RELANCES
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");
require ($DIR.$_SESSION['theme']->getDir_theme()."_theme.config.php" );
require ($CONFIG_DIR."profil_".$_SESSION['profils'][$CLIENT_ID_PROFIL]->getCode_profil().".config.php");

// chargement de la class du profil
contact::load_profil_class($CLIENT_ID_PROFIL);
// Préparations des variables d'affichage
$liste_categories = contact_client::charger_clients_categories ();
$liste_relance_modele = charger_factures_relances_modeles ();
//chargement des niveau de relances si la categ client est définie
$niveaux_relances	= array();
if (isset($_REQUEST["id_relance_modele"])) {
	$niveaux_relances = getNiveaux_relance ($_REQUEST["id_relance_modele"]) ;
	$id_relance_modele = $_REQUEST["id_relance_modele"];
} else {
	$niveaux_relances = getNiveaux_relance (0) ;//getNiveaux_relance ($DEFAUT_ID_CLIENT_CATEG) ;
	$id_relance_modele = 0;
}
	
	
//chargement des modes d'édition
$editions_modes	= liste_mode_edition();

// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_annuaire_gestion_factures.inc.php");

?>