<?php
// *************************************************************************************************************
// [ADMINISTRATEUR] AFFICHAGE D'UNE FICHE DE CONTACT
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");
require ($DIR.$_SESSION['theme']->getDir_theme()."_theme.config.php" );

ini_set("memory_limit", "40M");

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

//chargement des infos de constructeur
if ($CONSTRUCTEUR_ID_PROFIL != 0) {
	include ($CONFIG_DIR."profil_".$_SESSION['profils'][$CONSTRUCTEUR_ID_PROFIL]->getCode_profil().".config.php");
	contact::load_profil_class($CONSTRUCTEUR_ID_PROFIL);
}

// Préparations des variables d'affichage
$profils 	= $contact->getProfils();
$adresses = $contact->getAdresses();
$civilites = get_civilites ($contact->getId_Categorie());
$coordonnees = $contact->getCoordonnees ();
$sites_web = $contact->getSites ();
$users = $contact->getUtilisateurs ();

// Verification des droits pour consulter ce contact

$allowed_profils = explode(",",$_SESSION['user']->check_permission ("22"));
if (!in_array("ALL",$allowed_profils)){
	if(!in_array("SP",$allowed_profils) && count($profils) == 0){
		echo "Vous n'avez pas les permissions necessaires a la visualisation de ce contact!";
		exit;
	}
	foreach($profils as $profilkey => $profilvalue){
		if(!in_array($profilkey,$allowed_profils)){
			echo "Vous n'avez pas les permissions necessaires a la visualisation de ce contact!";
			exit;
		}
	}
}

$allowed_profils = explode(",",$_SESSION['user']->check_permission ("36"));
if (!in_array("ALL",$allowed_profils)){
	if(!in_array("SP",$allowed_profils) && count($profils) == 0){
				?>
				<script type="text/javascript">
				window.location.replace("annuaire_print_contact.php?ref_contact=<?php echo $_REQUEST["ref_contact"]?>");
				</script>
				<?php 
						exit;
			}
	foreach($profils as $profilkey => $profilvalue){
		if(!in_array($profilkey,$allowed_profils)){
				?>
				<script type="text/javascript">
				window.location.replace("annuaire_print_contact.php?ref_contact=<?php echo $_REQUEST["ref_contact"]?>");
				</script>
				<?php 
						exit;
		}
	}
}


//chargement des derniers documents
$contact_last_docs = $contact->getLast_docs ();

//chargement des evenements
$evenements = $contact->getEvenements ();

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
if(isset($profils[$CLIENT_ID_PROFIL]) ) {
	//liste des documents en cours du client 
	$client_last_DEV_en_cours = $profils[$CLIENT_ID_PROFIL]->charger_last_docs ($DEVIS_CLIENT_ID_TYPE_DOC, 1);
	$client_last_CDC_en_cours = $profils[$CLIENT_ID_PROFIL]->charger_last_docs ($COMMANDE_CLIENT_ID_TYPE_DOC, 1);
	$client_last_BLC_en_cours = $profils[$CLIENT_ID_PROFIL]->charger_last_docs ($LIVRAISON_CLIENT_ID_TYPE_DOC, 1);
	$client_last_FAC_en_cours = $profils[$CLIENT_ID_PROFIL]->charger_last_docs ($FACTURE_CLIENT_ID_TYPE_DOC, 1);
	//liste des documents en archive du client 
	$client_last_DEV_archive = $profils[$CLIENT_ID_PROFIL]->charger_last_docs ($DEVIS_CLIENT_ID_TYPE_DOC, 0);
	$client_last_CDC_archive = $profils[$CLIENT_ID_PROFIL]->charger_last_docs ($COMMANDE_CLIENT_ID_TYPE_DOC, 0);
	$client_last_BLC_archive = $profils[$CLIENT_ID_PROFIL]->charger_last_docs ($LIVRAISON_CLIENT_ID_TYPE_DOC, 0);
	$client_last_FAC_archive = $profils[$CLIENT_ID_PROFIL]->charger_last_docs ($FACTURE_CLIENT_ID_TYPE_DOC, 0);
	//liste des CA du client
	$client_CA = $profils[$CLIENT_ID_PROFIL]->charger_client_CA() ;
	//liste des abonnements du clients
	$client_abo = $profils[$CLIENT_ID_PROFIL]->charger_client_abo();
	//liste des consommmation (Services pré-payés) du clients
	$client_conso = $profils[$CLIENT_ID_PROFIL]->charger_client_conso();
}
if(isset($profils[$FOURNISSEUR_ID_PROFIL]) ) {
	//liste des documents en cours du fournisseur 
	$client_last_DEF_en_cours = $profils[$FOURNISSEUR_ID_PROFIL]->charger_last_docs ($DEVIS_FOURNISSEUR_ID_TYPE_DOC, 1);
	$client_last_CDF_en_cours = $profils[$FOURNISSEUR_ID_PROFIL]->charger_last_docs ($COMMANDE_FOURNISSEUR_ID_TYPE_DOC, 1);
	$client_last_BLF_en_cours = $profils[$FOURNISSEUR_ID_PROFIL]->charger_last_docs ($LIVRAISON_FOURNISSEUR_ID_TYPE_DOC, 1);
	$client_last_FAF_en_cours = $profils[$FOURNISSEUR_ID_PROFIL]->charger_last_docs ($FACTURE_FOURNISSEUR_ID_TYPE_DOC, 1);
	//liste des documents en archive du fournisseur 
	$client_last_DEF_archive = $profils[$FOURNISSEUR_ID_PROFIL]->charger_last_docs ($DEVIS_FOURNISSEUR_ID_TYPE_DOC, 0);
	$client_last_CDF_archive = $profils[$FOURNISSEUR_ID_PROFIL]->charger_last_docs ($COMMANDE_FOURNISSEUR_ID_TYPE_DOC, 0);
	$client_last_BLF_archive = $profils[$FOURNISSEUR_ID_PROFIL]->charger_last_docs ($LIVRAISON_FOURNISSEUR_ID_TYPE_DOC, 0);
	$client_last_FAF_archive = $profils[$FOURNISSEUR_ID_PROFIL]->charger_last_docs ($FACTURE_FOURNISSEUR_ID_TYPE_DOC, 0);
	//liste des CA du fournisseur
	$fournisseur_CA = $profils[$FOURNISSEUR_ID_PROFIL]->charger_fournisseur_CA() ;
	
}
if (isset($profils[$CONSTRUCTEUR_ID_PROFIL])) {
	//liste des CA des articles vendui du constructeur
	$constructeur_vente_CA = $profils[$CONSTRUCTEUR_ID_PROFIL]->charger_constructeur_vente_CA() ;
	//liste des CA des articles achatés au constructeur
	$constructeur_achat_CA = $profils[$CONSTRUCTEUR_ID_PROFIL]->charger_constructeur_achat_CA() ;
	//nombre d'articles de ce constructeur
	$constructeur_nb_articles = $profils[$CONSTRUCTEUR_ID_PROFIL]->count_constructeur_articles() ;
	//nombre de categories d'articles de ce constructeur
	$constructeur_nb_art_categ = $profils[$CONSTRUCTEUR_ID_PROFIL]->count_constructeur_art_categ() ;
	//liste des fournisseurs de ce constructeur
	$constructeur_fournisseurs_liste = $profils[$CONSTRUCTEUR_ID_PROFIL]->charger_constructeur_fournisseurs_liste() ;
	//liste des xx articles ajoutés au catalogue de ce construteur
	$last_constructeur_articles = $profils[$CONSTRUCTEUR_ID_PROFIL]->charger_last_constructeur_articles() ;
	 
}
$solde_comptable = compta_exercices::solde_extrait_compte ($contact->getRef_contact());

// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_annuaire_view_fiche.inc.php");

?>