<?php
// *************************************************************************************************************
// MAJ DE L'ADRESSE CONTACT D'UN DOCUMENT et rechargement entete
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");


//liste des lieux de stockage
$stocks_liste	= array();
$stocks_liste = $_SESSION['stocks'];

if (isset($_REQUEST['ref_doc'])) {

// ouverture des infos du document
$document = open_doc ($_REQUEST['ref_doc']);

	switch ($_REQUEST['type_adresse']) {
	case "adresse_contact":
		$document->maj_adresse_contact ($_REQUEST['ref_adresse']);
		break;
	case "adresse_livraison":
		$document->maj_adresse_livraison ($_REQUEST['ref_adresse']);
		break;
	}	

	$id_type_doc = $document->getID_TYPE_DOC ();
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
}

// *************************************************************************************************************
// AFFICHAGE
// -*************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_documents_edition_block_headoc_".$id_type_doc.".inc.php");

?>