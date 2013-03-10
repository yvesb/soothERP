<?php
// *************************************************************************************************************
// OPAGE POUR VALIDER LE CHOIX DU TYPE D'UN COURRIER ET D'UN MODELE PDF
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");

if(!isset($_REQUEST['ref_destinataire'])){
	echo "La référence du destinataire est inconnue";
	exit;
}
$ref_destinataire = $_REQUEST['ref_destinataire'];

if(!isset($_REQUEST['page_source'])){
	echo "La page source est inconnue";
	exit;
}
$page_source = $_REQUEST['page_source'];


if(!isset($_REQUEST['page_cible'])){
	echo "La page cible est inconnue";
	exit;
}
$page_cible = $_REQUEST['page_cible'];

if(!isset($_REQUEST['cible'])){
	echo "La cible est inconnue";
	exit;
}
$cible = $_REQUEST['cible'];

if(!isset($_REQUEST['id_type_courrier'])){
	echo "Le id_type_courrier est inconnu";
	exit;
}
$id_type_courrier = $_REQUEST['id_type_courrier'];

if(!isset($_REQUEST['id_pdf_modele'])){
	echo "La id_pdf_modele est inconnu";
	exit;
}
$id_pdf_modele = $_REQUEST['id_pdf_modele'];

// Si on a un id_courrier 
//	=> le courrier existe déjà et on change le type du courrier ET le modele de pdf
//sinon, on choisi le type ET le modele de pdf du courrier à créer 
if(isset($_REQUEST['id_courrier']) && is_numeric($_REQUEST['id_courrier'])){
	$courrier = new CourrierEtendu($_REQUEST['id_courrier']);
	$courrier->setId_type_courrier($id_type_courrier);
	$courrier->setId_pdf_modele($id_pdf_modele);
}else{
	
	$d = new DateTime();
	$courrier = CourrierEtendu::newCourrierEtendu($id_type_courrier, $id_pdf_modele, Courrier::ETAT_EN_REDAC(), $d->format("Y-m-d H:i:s"), "", "", $ref_destinataire, $_SESSION['user']);
}

// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_courriers_choix_type_valid.inc.php");



?>