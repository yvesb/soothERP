<?php
// *************************************************************************************************************
// AFFICHAGE DU COURRIER EN MODE PDF (partie boutons)
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");


$id_courrier = $_REQUEST['id_courrier'];
if (isset($_REQUEST["code_pdf_modele"]))
	$code_pdf_modele = $_REQUEST["code_pdf_modele"];

//@TODO COURRIER : Gestion des filigranes : 
if (isset($_REQUEST["filigrane"]))
	$filigrane = $_REQUEST["filigrane"];


	
//chargement des modes d'édition
$editions_modes	= liste_mode_edition();

$courrier = new CourrierEtendu($id_courrier);
$liste_modeles_pdf_courrier_valides = modele_pdf_courrier_valide_du_type($courrier->getId_type_courrier());

//@TODO COURRIER : Gestion des filigranes : 
$filigranes_pdf_courrier = charger_filigranes_pdf_courrier();

// *************************************************************************************************************
// AFFICHAGE
// -*************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_courriers_editing_button.inc.php");




?>