<?php
// *************************************************************************************************************
// ENVOI D'UN DOCUMENT PAR EMAIL envois rapide vers 1 destinataire
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");

$erreur_email = false;
$msg = "";
if (isset($_REQUEST["ref_doc"])) {

        if (is_array($_REQUEST["ref_doc"])){

        global $FICHIERS_DIR;

        $pdf = new PDF_etendu ();

        $ref_contact = "";
        $liste_destinataires = array();

// Ajout des documents au PDF
        foreach($_REQUEST["ref_doc"] as $document){
            $document = open_doc ($document);
            $ref_contact = $document->getRef_contact();
            $pdf->add_doc ("", $document);
        }

        $liste_email = get_contact_emails ($ref_contact);
        foreach ($liste_email as $email){
            $liste_destinataires[] = $email->email;
        }
        if(!email::verifier_syntaxe_emails($liste_destinataires)){
			$erreur_email = true;
			$msg = "L'email de destination n'est pas valide.";
	}

        $code_file = md5(uniqid(rand(), true));
        $pdf->Output($FICHIERS_DIR."doc_tmp/MULTI_".$code_file.".pdf" , "F");

        $filename               = array();
	$filename[]             = $FICHIERS_DIR."doc_tmp/MULTI_".$code_file.".pdf";
	$typemime		= "application/pdf";
	$nom			= array();
	$nom[]			= "FACTURES_".$code_file.".pdf";
       	$contact_entreprise     = new contact($REF_CONTACT_ENTREPRISE);
	$nom_entreprise         = str_replace (CHR(13), " " ,str_replace (CHR(10), " " , $contact_entreprise->getNom()));
	$nom_aff		= array();
	$nom_aff[]		= "FACTURES_".$nom_entreprise.".pdf";

        //on récupère l'email de l'utilisateur en cours pour envoyer le mail
	$reply 			= $_SESSION['user']->getEmail();
	$from 			= $_SESSION['user']->getEmail();

       if (isset($_REQUEST["sujet"])){
           $sujet = "[ $nom_entreprise ] - ".$_REQUEST["sujet"];
       }else{
           $sujet = "[ $nom_entreprise ] - Factures";
       }

       if (isset($_REQUEST["encode"])){
           $message = urldecode($_REQUEST["message"]);
       }else{
           $message = $_REQUEST["message"];
       }

       // Envoi de l'email
	$mail = new email();
	$mail->prepare_envoi(0, 1);
	if ($mail->mail_attachement ($liste_destinataires , $sujet , $message , $filename , $typemime , $nom , $reply , $from, $nom_aff)) {
		//$this->document_edition_add (2);
	}else{
            $erreur_email = true;
        }

    }else{

	$document = open_doc ($_REQUEST['ref_doc']);
	
	$liste_email = array();
	if ($document->getRef_contact()) {
		$liste_email = get_contact_emails ($document->getRef_contact());
	}
	
	$liste_destinataires = explode(";", $_REQUEST["destinataires"]);
	if(!email::verifier_syntaxe_emails($liste_destinataires)){
			$erreur_email = true;
			$msg = "L'email de destination n'est pas valide.";
	}
	if (!$erreur_email) {
	       if (isset($_REQUEST["encode"])){
                   $message = urldecode($_REQUEST["message"]);
               }else{
                   $message = $_REQUEST["message"];
               }

		if (!$retour = $document->mail_document ($_REQUEST["destinataires"] , $_REQUEST["titre"] , $message)) {
			$erreur_email = true;
			$msg = "Une erreur est survenue lors de l'envoi de l'email.";
		}
		
	}
    }
}

// *************************************************************************************************************
// AFFICHAGE
// -*************************************************************************************************************
include ($DIR.$_SESSION['theme']->getDir_theme()."page_documents_contact_email_send_doc.inc.php");

?>