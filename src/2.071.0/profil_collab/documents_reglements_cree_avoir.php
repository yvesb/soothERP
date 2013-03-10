<?php
// *************************************************************************************************************
// CRÉATION D'UN AVOIR À PARTIR D'UNE FACTURE
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");

		
if (isset($_REQUEST["ref_doc"])) {
	
	$document = open_doc ($_REQUEST['ref_doc']);
	
	
	if ($document->getId_type_doc()  == $FACTURE_FOURNISSEUR_ID_TYPE_DOC) {
		$ref_avf = $document->create_avf ();
		echo $ref_avf;
	}
	if ($document->getId_type_doc()  == $FACTURE_CLIENT_ID_TYPE_DOC) {
		$ref_avc = $document->create_avc ();
		echo $ref_avc;
	}
	
}



?>