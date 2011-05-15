<?php
// *************************************************************************************************************
// ENVOI D'UN COURRIER (sous forme de PDF) PAR EMAIL
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");


$erreur_email = false;

if (isset($_REQUEST["id_courrier"])) {
	$courrier = new CourrierEtendu ($_REQUEST['id_courrier']);
	
	//@TODO COURRIER : Gestion des filigranes : 
	if (isset($_REQUEST["filigrane"])) { $GLOBALS['PDF_OPTIONS']['filigrane'] = $_REQUEST["filigrane"];}
	
	if (isset($_REQUEST["code_pdf_modele"])) {
		$courrier->change_code_pdf_modele ($_REQUEST["code_pdf_modele"]);
	}
	
	
	$liste_email = array();
	if ($courrier->getDestinataires()) {
		foreach($courrier->getDestinataires() as $destinataire){
			$liste_email = get_contact_emails ($destinataire->getRef_contact());
		}
	}
	
	$liste_destinataires = explode(";", $_REQUEST["destinataires"]);
	foreach($liste_destinataires as $destinataire){
			if (!preg_match("#^[0-9a-z]([-_.]?[0-9a-z])*@[0-9a-z]([-.]?[0-9a-z])*\\.[a-z]{2,3}$#i", $destinataire)) {
			$erreur_email = true;
			$msg = "Un email de destination n'est pas valide.";
		}
	}
	
	if (!$erreur_email) {
		$fp = fopen($DIR."_____email.log.txt","a");
		if ($fp){
			fwrite($fp,"no error");
			fclose($fp);
		}
		if (!$retour = $courrier->mail_courrier ($liste_destinataires , $_REQUEST["titre"] , nl2br($_REQUEST["message"]))) {
			$erreur_email = true;
			$msg = "Une erreur est survenue lors de l'envoi de l'email.";
		}
		
	}
}else{ $erreur_email = true; }

// *************************************************************************************************************
// AFFICHAGE
// -*************************************************************************************************************
if ($erreur_email) {
	$contact_entreprise = new contact($REF_CONTACT_ENTREPRISE);
	include ($DIR.$_SESSION['theme']->getDir_theme()."page_courriers_editing_email.inc.php");
} else {
	include ($DIR.$_SESSION['theme']->getDir_theme()."page_courriers_editing_email_submit.inc.php");
}

?>