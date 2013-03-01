<?php
// *************************************************************************************************************
// OPTIONS D'UN COURRIER
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");

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

if(!isset($_REQUEST['ref_destinataire'])){
	echo "La référence du destinataire est inconnue";
	exit;
}
$ref_destinataire = $_REQUEST['ref_destinataire'];

$infos_types_courrier_actifs = infos_types_courrier_actifs();

if(!isset($_REQUEST['id_courrier'])){
	echo "Le id du courrier est inconnu";
	exit;
}
$courrier = new CourrierEtendu($_REQUEST['id_courrier']);

$id_type_courrier_selected = $courrier->getId_type_courrier();
$id_pdf_modele_selected = $courrier->getId_pdf_modele();

// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_courriers_options.inc.php");
?>