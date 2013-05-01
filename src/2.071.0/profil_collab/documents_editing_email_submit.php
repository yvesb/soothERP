<?php
// *************************************************************************************************************
// ENVOI D'UN DOCUMENT PAR EMAIL
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");

$erreur_email = false;
if (isset($_REQUEST["ref_doc"])) {

    if (is_array($_REQUEST["ref_doc"])){

        global $FICHIERS_DIR;

        $pdf = new PDF_etendu ();

	// Ajout des documents au PDF
        foreach($_REQUEST["ref_doc"] as $document){
            $document = open_doc ($document);
            $pdf->add_doc ("", $document);
        }

        $code_file = md5(uniqid(rand(), true));
        $pdf->Output($FICHIERS_DIR."doc_tmp/MULTI_".$code_file.".pdf" , "F");

        $filename 	= array();
	$filename[] = $FICHIERS_DIR."doc_tmp/MULTI_".$code_file.".pdf";
	$typemime		= "application/pdf";
	$nom			= array();
	$nom[]			= "FACTURES_".$code_file.".pdf";
       	$contact_entreprise = new contact($REF_CONTACT_ENTREPRISE);
	$nom_entreprise = str_replace (CHR(13), " " ,str_replace (CHR(10), " " , $contact_entreprise->getNom()));
	$nom_aff			= array();
	$nom_aff[]			= "FACTURES_".$nom_entreprise.".pdf";

        //on récupère l'email de l'utilisateur en cours pour envoyer le mail
	$reply 			= $_SESSION['user']->getEmail();
	$from 			= $_SESSION['user']->getEmail();
        // Envoi de l'email
	$mail = new email();
	$mail->prepare_envoi(0, 1);

    }else{

	$GLOBALS['_OPTIONS']['CREATE_DOC']['no_charge_all_sn'] = 1;
	$document = open_doc ($_REQUEST['ref_doc']);
	
	if (isset($_REQUEST["filigrane"])) { $GLOBALS['PDF_OPTIONS']['filigrane'] = $_REQUEST["filigrane"];}
	
	if (isset($_REQUEST["code_pdf_modele"])) {
		$document->change_code_pdf_modele ($_REQUEST["code_pdf_modele"]);
	}
	
	$liste_email = array();
	if ($document->getRef_contact()) {
		$liste_email = get_contact_emails ($document->getRef_contact());
	}
	
	$msg = "";
	$liste_destinataires = explode(";", $_REQUEST["destinataires"]);
	foreach($liste_destinataires as $destinataire){
		if (!email::verifier_syntaxe_email($destinataire)) {
			$erreur_email = true;
			$msg = "Un email de destination n'est pas valide.";
		}
		
	}
	
	if (!$erreur_email) {
               if (isset($_REQUEST["encode"])){
                   $message = urldecode($_REQUEST["message"]);
               }else{
                   $message = $_REQUEST["message"];
               }
               
		if (!$retour = $document->mail_document ($liste_destinataires , $_REQUEST["titre"] , $message)) {
			$erreur_email = true;
			$msg = "Une erreur est survenue lors de l'envoi de l'email.";
		}
		
	}
    }
}

// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************
if ($erreur_email) {
	$contact_entreprise = new contact($REF_CONTACT_ENTREPRISE);
	include ($DIR.$_SESSION['theme']->getDir_theme()."page_documents_editing_email.inc.php");
} else {
	include ($DIR.$_SESSION['theme']->getDir_theme()."page_documents_editing_email_submit.inc.php");
}

?>