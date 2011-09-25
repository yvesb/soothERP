<?php
// *************************************************************************************************************
// ENVOI D'UN DOCUMENT PAR EMAIL
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");

$erreur_fax = false;
if (isset($_REQUEST["ref_doc"])) {
	$document = open_doc ($_REQUEST['ref_doc']);
	
	$liste_fax = array();
	if ($document->getRef_contact()) {
		$liste_fax = get_contact_faxs ($document->getRef_contact());
	}
	
	$destinataire = $_REQUEST["destinataires"];
	if ( !is_numeric(trim(str_replace(" ", "", $destinataire))) ) {
		$erreur_fax = true;
		$msg = "le numero du fax n'est pas valide";
	}

	if (!$erreur_fax) {
		if (!$document->fax_document ($_REQUEST["destinataires"] , $_REQUEST["titre"] , $_REQUEST["message"])) {
			$erreur_fax = true;
			$msg = "Une erreur est survenue lors de l'envois du fax.";
		}
	}
	
}

//*************************************************************************************************************
// AFFICHAGE
//*************************************************************************************************************
if ($erreur_fax) {
include ($DIR.$_SESSION['theme']->getDir_theme()."page_documents_editing_fax.inc.php");
} else {
include ($DIR.$_SESSION['theme']->getDir_theme()."page_documents_editing_fax_submit.inc.php");
}

?>