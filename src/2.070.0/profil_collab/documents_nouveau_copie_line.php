<?php
// *************************************************************************************************************
// OUVERTURE D'UN DOCUMENT EN MODE EDITION APRES COPIE DE LIGNES D'UN AUTRE DOCUMENT
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");

		
		
if (isset($_REQUEST["old_ref_doc"])) {

	$lines = array();
	if (isset ($_REQUEST['lines'])) {
	$lines = $_REQUEST['lines'];
	}
	
		
	if (isset($_REQUEST['id_type_doc']) && $_REQUEST['id_type_doc'] != "") {
	
		$id_type_doc = $_REQUEST['id_type_doc'];
		if (isset($_REQUEST['ref_contact'])) {$GLOBALS['_OPTIONS']['CREATE_DOC']['ref_contact'] =  $_REQUEST['ref_contact'];}
		$document = create_doc ($id_type_doc);
		
	}
	
	$ref_doc = $document->getRef_doc();
	$old_ref_doc = "";
	
	if (isset($_REQUEST["old_ref_doc"])) {	$old_ref_doc = $_REQUEST["old_ref_doc"];}
	//copie des lignes vers le document
	$document->copie_line_from_lines ($lines, "", $old_ref_doc);
	
	//création d'une liaison inactive entre les documents aprés la copie des lignes
	if (isset($_REQUEST["link_old_ref_doc"]) && $_REQUEST["link_old_ref_doc"] == 1 ) {
		$document->link_from_doc_set_active ($old_ref_doc, 0);
	}
	
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
	
}

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
$echeances = $document->getEcheancier();
$nb_echeances_restantes = $document->getNb_echeances_restantes ();
$montant_acquite = 0;
$liste_reglement_valide = array();

//liaisons du document
$doc_liaisons_possibles = $document->getLiaisons_possibles ();
$doc_liaisons = $document->getLiaisons ();


// *************************************************************************************************************
// AFFICHAGE
// -*************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_documents_edition.inc.php");

?>