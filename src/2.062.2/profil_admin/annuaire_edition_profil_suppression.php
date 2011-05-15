<?php
// *************************************************************************************************************
// SUPPRESSION D'UN PROFIL
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");



if (isset($_REQUEST['id_profil'])) {	
	// *************************************************
	// Controle des données fournies par le formulaire

	$infos_profils = array();
	$id_profil	=	$_REQUEST['id_profil'];
	
	if (!isset($_SESSION['profils'][$id_profil])) { continue; }
	
	$infos_profils[$id_profil]['id_profil'] = $id_profil;
	
	// *************************************************
	// Suppréssion du profil
	$contact= new contact ($_REQUEST['ref_contact']);
	$result = $contact->delete_profiled_infos ($infos_profils[$id_profil]);
	
	// AFFICHAGE
	

	if ($result) {
		include ($DIR.$_SESSION['theme']->getDir_theme()."page_annuaire_edition_valid_profil".$id_profil."_suppression.inc.php");
	}
}
?>