<?php
// *************************************************************************************************************
// ENVOI D'UN DOCUMENT PAR FAX envois rapide vers 1 destinataire
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");

$erreur_email = false;
$msg = "";
if (isset($_REQUEST["ref_doc"])) {
	$document = open_doc ($_REQUEST['ref_doc']);
	
	$liste_email = array();
	if ($document->getRef_contact()) {
		$liste_fax = get_contact_faxs ($document->getRef_contact());
	}
	
	if (!$erreur_email) {
		$dest = str_replace(" ", "", str_replace(".", "",  str_replace("-", "", str_replace("/", "",  trim($_REQUEST["destinataires"]) ) ) ) );
		//echo ($dest.$FAX2MAIL_SER . " ". $FAX2MAIL_NUM . " ". $FAX2MAIL_PASS);
		if (!$retour = $document->fax_document ($dest.$FAX2MAIL_SER , $FAX2MAIL_NUM , $FAX2MAIL_PASS)) {
			$erreur_email = true;
			$msg = "Une erreur est survenue lors de l'envoi du fax.";
		}
		
	}
}

// *************************************************************************************************************
// AFFICHAGE
// -*************************************************************************************************************
include ($DIR.$_SESSION['theme']->getDir_theme()."page_documents_contact_fax_send_doc.inc.php");

?>