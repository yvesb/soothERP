<?php
// *************************************************************************************************************
// AFFICHAGE DE L'EDITION (IMPRESSION ET ENVOIS) D'UN COURRIER
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");

if(!isset($_REQUEST["id_courrier"])){
	echo "l'identifiant du courrier est inconnu";
	exit;
}
$id_courrier= $_REQUEST["id_courrier"];

//parametre pour l'url appellée quand on clic sur le bouton
$params_b = "?id_courrier=".$id_courrier;
if (isset($_REQUEST["code_pdf_modele"]))
	$params_b.= "&code_pdf_modele=".$_REQUEST["code_pdf_modele"];
//@TODO COURRIER : Gestion des filigranes : 
if (isset($_REQUEST["filigrane"]))
	$params_b.="&filigrane=".$_REQUEST["filigrane"];
	
//parametre pour l'url appellée quand on clic sur le bouton IMPRIMER
$params_p = "?id_courrier=".$id_courrier;
if (isset($_REQUEST["print"]))
	$params_p.="&print=1";
if (isset($_REQUEST["code_pdf_modele"]))
	$params_p.="&code_pdf_modele=".$_REQUEST["code_pdf_modele"];
//@TODO COURRIER : Gestion des filigranes : 
if (isset($_REQUEST["filigrane"]))
	$params_p.="&filigrane=".$_REQUEST["filigrane"];

// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_courriers_editing.inc.php");
?>