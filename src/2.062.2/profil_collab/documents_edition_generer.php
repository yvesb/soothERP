<?php
// *************************************************************************************************************
// GENERE UN BRF
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");


if (isset($_REQUEST['ref_doc'])) {

// ouverture des infos du document et mise à jour
	$document = open_doc ($_REQUEST['ref_doc']);
	if (isset($_REQUEST["fonction_generer"])) {
	 switch ($_REQUEST["fonction_generer"]) {
	 	case "generer_br_fournisseur":
		$document->generer_br_fournisseur ();
		break;
	 	case "generer_bl_client":
		$document->generer_bl_client ();
		break;
	 	case "generer_fa_client":
		$document->generer_fa_client ();
		break;
	 }
		
	}
}


if (isset($GLOBALS['_INFOS']['ref_doc_copie'])) {

	$ref_doc= $GLOBALS['_INFOS']['ref_doc_copie'];
	$document = open_doc ($ref_doc);
	$id_type_doc = $document->getID_TYPE_DOC ();
	$ref_contact = $document->getRef_contact ();
	
	//si un montant est négatif
	$montant_negatif = false;
	$montant_positif = 1;
	if (isset($_REQUEST["montant_neg"])) { $montant_negatif = true; $montant_positif = -1;}
			
	if ($document->getACCEPT_REGMT() != 0) {

		//liste des reglements_modes
		$reglements_modes	= array();

		if (($document->getACCEPT_REGMT() == 1 && !$montant_negatif) || ($document->getACCEPT_REGMT() == -1 && $montant_negatif)) {
			$reglements_modes = getReglements_modes ("entrant");
		}
		if (($document->getACCEPT_REGMT() == -1 && !$montant_negatif) || ($document->getACCEPT_REGMT() == 1 && $montant_negatif)) {
			$reglements_modes = getReglements_modes ("sortant");
		}
	
		$liste_reglements = $document->getReglements ();
	}
	
	$echeances = $document->getEcheancier();
	$nb_echeances_restantes = $document->getNb_echeances_restantes ();
	$montant_acquite = 0;
	$liste_reglement_valide = array();
	

//liste des types de documents
$types_liste	= array();
$types_liste = $_SESSION['types_docs'];

//liste des constructeurs
$constructeurs_liste = array();
$constructeurs_liste = get_constructeurs ();
		

//liste des lieux de stockage
$stocks_liste	= array();
$stocks_liste = $_SESSION['stocks'];


//liste des tarifs
get_tarifs_listes ();
$tarifs_liste	= array();
$tarifs_liste = $_SESSION['tarifs_listes'];	

//infos pour mini moteur de recherche contact
$profils_mini = array();
foreach ($_SESSION['profils'] as $profil) {
	if ($profil->getActif() != 1) { continue; }
	$profils_mini[] = $profil;
}
unset ($profil);
foreach ($_SESSION['profils'] as $profil) {
	if ($profil->getActif() != 2 ) { continue; }
	$profils_mini[] = $profil;
}
unset ($profil);


$ANNUAIRE_CATEGORIES	=	get_categories();
	
//liaisons du document
$doc_liaisons_possibles = $document->getLiaisons_possibles ();
$doc_liaisons = $document->getLiaisons ();

//liste des factures à payer

$document->get_infos_facturation($montant_positif);
$liste_factures = $document->factures_to_pay;
$liste_avoir_to_use = $document->avoirs_to_use;
$liste_regmnt_to_use = $document->regmnt_to_use;

// *************************************************************************************************************
// AFFICHAGE
// -*************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_documents_edition.inc.php");

}
?>