<?php
// *************************************************************************************************************
// AFFICHAGE DE L'EDITION D'UN CONTACT (partie document pdf)
// *************************************************************************************************************

$MUST_BE_LOGIN = 1;
require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");


//changement du code pdf_modele
if (isset($_REQUEST["code_pdf_modele"])) {
	stock::change_code_pdf_modele($_REQUEST["code_pdf_modele"]);
}
	

if(isset($_REQUEST['id_stocks'])){ $infos['id_stocks'] = $_REQUEST['id_stocks']; }
if(isset($_REQUEST['aff_pa'])){ $infos['aff_pa'] = $_REQUEST['aff_pa']; }
if(isset($_REQUEST['ref_constructeur'])){ $infos['ref_constructeur'] = $_REQUEST['ref_constructeur']; }
if(isset($_REQUEST['ref_art_categ'])){ $infos['ref_art_categ'] = $_REQUEST['ref_art_categ']; }
if(isset($_REQUEST['in_stock'])){ $infos['in_stock'] = $_REQUEST['in_stock']; }
if(isset($_REQUEST['aff_info_tracab'])){ $infos['aff_info_tracab'] = $_REQUEST['aff_info_tracab']; }
stock::imprimer_etat_stocks($infos);

?>
