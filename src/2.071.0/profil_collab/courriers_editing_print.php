<?php
// *************************************************************************************************************
// AFFICHAGE DU COURRIER EN MODE PDF (partie document pdf)
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");

ini_set("memory_limit","40M");
if (!isset($_REQUEST["id_courrier"])) {
	echo "l'identifiant du courrier est inconnu";
	exit;
}
$courrier = new CourrierEtendu($_REQUEST["id_courrier"]+0);

//@TODO COURRIER : Gestion des filigranes : 
/*
if (isset($_REQUEST["filigrane"])) {
	$GLOBALS['PDF_OPTIONS']['filigrane'] = $_REQUEST["filigrane"];
}
//changement du code pdf_modele
if (isset($_REQUEST["code_pdf_modele"])) {
	$courrier->change_code_pdf_modele($_REQUEST["code_pdf_modele"]);
}
*/

if (isset($_REQUEST["print"])) {
	$courrier->print_pdf();
}else {
	$courrier->view_pdf();
}
?>