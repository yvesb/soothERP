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
	 	case "generer_fa_fournisseur":
		$document->generer_fa_fournisseur ();
		break;
	 }
		
	}
}


if (isset($GLOBALS['_INFOS']['ref_doc_copie'])) {

	$ref_doc= $GLOBALS['_INFOS']['ref_doc_copie'];
	$document = open_doc ($ref_doc);
	$id_type_doc = $document->getID_TYPE_DOC ();
	$ref_contact = $document->getRef_contact ();

// *************************************************************************************************************
// AFFICHAGE
// -*************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_documents_edition_generer_blank.inc.php");

}
?>