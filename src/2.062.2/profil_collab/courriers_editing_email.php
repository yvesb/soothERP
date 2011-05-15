<?php
// *************************************************************************************************************
// ENVOI D'UN COURRIER (sous forme de PDF) PAR EMAIL
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");

if (isset($_REQUEST["id_courrier"])) {
	$courrier = new CourrierEtendu ($_REQUEST['id_courrier']);
	
	$contact_entreprise = new contact($REF_CONTACT_ENTREPRISE);
	
	$liste_email = array();
	foreach ($courrier->getDestinataires() as $destinataire) {
		$liste_email = array_merge($liste_email, get_contact_emails($destinataire->getRef_contact()));
	}
if(isset($_REQUEST["code_pdf_modele"]))
	$code_pdf_modele = $_REQUEST["code_pdf_modele"];

//@TODO COURRIER : Gestion des filigranes : 
if(isset($_REQUEST["filigrane"]))
	$filigrane = $_REQUEST["filigrane"];
}

// *************************************************************************************************************
// AFFICHAGE
// -*************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_courriers_editing_email.inc.php");

?>