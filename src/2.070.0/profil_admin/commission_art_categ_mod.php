<?php
// *************************************************************************************************************
// Modification des commissions pour une art_categ
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");


if (isset($_REQUEST['id_commission_regle'])) {	
	// *************************************************
	// Controle des données fournies par le formulaire
	$id_commission_regle				= $_REQUEST['id_commission_regle'];
	$ref_art_categ				= $_REQUEST['ref_art_categ'];
	$formule_comm					= $_REQUEST['formule_comm'];


	// *************************************************
	// Création de la catégorie
	if ($_REQUEST["old_formule_comm"] == ""  && $formule_comm != "") {
		commission_liste::add_form_comm_art_categ ($id_commission_regle, $ref_art_categ, $formule_comm) ;
	} else {
		if ($_REQUEST["old_formule_comm"] != ""  && $formule_comm != "") {
			commission_liste::mod_form_comm_art_categ ($id_commission_regle, $ref_art_categ, $formule_comm) ;
		} else {
			commission_liste::del_form_comm_art_categ ($id_commission_regle, $ref_art_categ, $formule_comm) ;
		}
	}
}


?>