<?php
// *************************************************************************************************************
// TRANSFORMATION D'UN FAC NEGATIVE EN COMPENSATION PUIS TRANSFERT DE L'AVOIR À UNE FACTURE
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");

		
if (isset($_REQUEST["ref_doc_neg"])) {
	//ouverture de la facture negative
	$document = open_doc ($_REQUEST['ref_doc_neg']);
	
	if ($document->getId_type_doc()  == $FACTURE_FOURNISSEUR_ID_TYPE_DOC) {
		$ref_avf = $document->create_avf ();
		//Ouverture de l'avoir
		$reglement = new reglement($ref_avf);
	}
	if ($document->getId_type_doc()  == $FACTURE_CLIENT_ID_TYPE_DOC) {
		$ref_avc = $document->create_avc ();
		//Ouverture de l'avoir
		$reglement = new reglement($ref_avc);
	}
	
	//rapprochement du reglement  au document ciblé
	$document2 = open_doc ($_REQUEST['ref_doc']);
	$document2->rapprocher_reglement ($reglement);
	
}



?>