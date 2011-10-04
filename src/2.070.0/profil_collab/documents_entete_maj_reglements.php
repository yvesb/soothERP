<?php
// *************************************************************************************************************
// MAJ DE LA REF_DOC_EXTERNE D'UN DOCUMENT 
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");


if (isset($_REQUEST['ref_doc'])) {


	// ouverture des infos du document et mise à jour
	$document = open_doc ($_REQUEST['ref_doc']); 	 

	if ($document->getACCEPT_REGMT() != 0) {
		$liste_reglements = $document->getReglements ();
	}
	$echeances = $document->getEcheancier();
	$nb_echeances_restantes = $document->getNb_echeances_restantes ();
	$montant_acquite = 0;
	$liste_reglement_valide = array();
}

include $DIR.$_SESSION['theme']->getDir_theme()."page_documents_reglements_entete.inc.php"

?>