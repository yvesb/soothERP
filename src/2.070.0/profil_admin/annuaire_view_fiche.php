<?php
// *************************************************************************************************************
// [ADMINISTRATEUR] AFFICHAGE D'UNE FICHE DE CONTACT
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


//chargement des infos de admin
if ($ADMIN_ID_PROFIL != 0) {
	include ($CONFIG_DIR."profil_".$_SESSION['profils'][$ADMIN_ID_PROFIL]->getCode_profil().".config.php"); 
}
//chargement des catégories de fournisseurs
if ($FOURNISSEUR_ID_PROFIL != 0) {
	include ($CONFIG_DIR."profil_".$_SESSION['profils'][$FOURNISSEUR_ID_PROFIL]->getCode_profil().".config.php"); 
	contact::load_profil_class($FOURNISSEUR_ID_PROFIL);
	$liste_categories_fournisseur = contact_fournisseur::charger_fournisseurs_categories ();
}

//chargement des catégories de commerciaux
if ($COMMERCIAL_ID_PROFIL != 0) {
	include ($CONFIG_DIR."profil_".$_SESSION['profils'][$COMMERCIAL_ID_PROFIL]->getCode_profil().".config.php"); 
	contact::load_profil_class($COMMERCIAL_ID_PROFIL);
	$liste_categories_commercial = contact_commercial::charger_commerciaux_categories ();
	$liste_commissions_regles = contact_commercial::charger_commissions_regles ();
}

//chargement des catégories de clients
if ($CLIENT_ID_PROFIL != 0) {
	include ($CONFIG_DIR."profil_".$_SESSION['profils'][$CLIENT_ID_PROFIL]->getCode_profil().".config.php");
	contact::load_profil_class($CLIENT_ID_PROFIL);
	$liste_categories_client = contact_client::charger_clients_categories ();
}

// Préparations des variables d'affichage
$profils 	= $contact->getProfils();
$adresses = $contact->getAdresses();
$civilites = get_civilites ($contact->getId_Categorie());
$coordonnees = $contact->getCoordonnees ();
$sites_web = $contact->getSites ();
$users = $contact->getUtilisateurs ();

//chargement des derniers documents
$contact_last_docs = $contact->getLast_docs ();


//liste des pays pour affichage dans select
$listepays = getPays_select_list ();

//liste des langages
$langages = getLangues ();


//liste des lieux de stockage
$stocks_liste	= array();
$stocks_liste = $_SESSION['stocks'];
	
//liste des tarifs
$tarifs_liste	= array();
$tarifs_liste = get_full_tarifs_listes ();
	

//infos pour mini moteur de recherche contact
$profils_mini = array();
foreach ($_SESSION['profils'] as $profil) {
	if ($profil->getActif() != 1 && $profil->getActif() != 2) { continue; }
	$profils_mini[] = $profil;
}
unset ($profil);

$ANNUAIRE_CATEGORIES	=	get_categories();

if(isset($profils[$COLLAB_ID_PROFIL]) ) {
	//fonctions de collaborateurs
	$liste_fonctions_collab = charger_fonctions ($COLLAB_ID_PROFIL);
	//fonctions du collaborateur
	$fonctions_collab = $profils[$COLLAB_ID_PROFIL]->getCollab_fonctions ();
}
// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_annuaire_view_fiche.inc.php");

?>