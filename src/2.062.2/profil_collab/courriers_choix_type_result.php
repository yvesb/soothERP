<?php
// *************************************************************************************************************
// PAGE POUR CHOISIR LE TYPE D'UN COURRIER ET D'UN MODELE PDF
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

if(!isset($_REQUEST['id_type_courrier'])){
	echo "Le id_type_courrier du courrier est inconnu";
	exit;
}
$id_type_courrier_selected = $_REQUEST['id_type_courrier'];

$infos_types_courrier_actifs = infos_types_courrier_actifs();

if(isset($_REQUEST['id_courrier'])){
	$id_courrier = $_REQUEST['id_courrier'];
	$courrier = new CourrierEtendu($id_courrier);
	$id_type_courrier_du_courrier = $courrier->getId_type_courrier();
	if($id_type_courrier_selected == $id_type_courrier_du_courrier){
		$id_pdf_modele_selected = $courrier->getId_pdf_modele();
	}else{
	$var_tmp = modele_pdf_par_defaut_du_type($id_type_courrier_selected);
	$id_pdf_modele_selected = $var_tmp->id_pdf_modele;
	}
}else{
	$var_tmp = modele_pdf_par_defaut_du_type($id_type_courrier_selected);
	$id_pdf_modele_selected = $var_tmp->id_pdf_modele;
}

$modeles_pdf_du_type  = modele_pdf_courrier_valide_du_type($id_type_courrier_selected);

// *************************************************************************************************************
// AFFICHAGE
// -*************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_courriers_choix_type_result.inc.php");



?>