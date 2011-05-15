<?php
// *************************************************************************************************************
// SUPRESSION D'UN ART_CATEG D'UN DOCUMENT INVENTAIRE
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");

//liste des lieux de stockage
$stocks_liste	= array();
$stocks_liste = $_SESSION['stocks'];

if (isset($_REQUEST['ref_doc'])) {

	// ouverture des infos du document et mise à jour
	$document = open_doc ($_REQUEST['ref_doc']);
	 
	$document->supprime_art_categ ($_REQUEST['art_categ']);
		
	$id_type_doc = $document->getID_TYPE_DOC ();
	$ref_contact = $document->getRef_contact ();
	$art_categs = $document->getArt_categs();
			
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
	
// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_documents_edition_block_headoc_".$id_type_doc.".inc.php");
}


?>