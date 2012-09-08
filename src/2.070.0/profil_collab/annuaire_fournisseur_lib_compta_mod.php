<?php
// *************************************************************************************************************
// MODIFICATION D'UN PROFIL
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");


if (isset($FOURNISSEUR_ID_PROFIL)) {	
	// *************************************************
	// Controle des données fournies par le formulaire

	$infos_profils = array();
	$id_profil	=	$FOURNISSEUR_ID_PROFIL;
	if (!isset($_SESSION['profils'][$id_profil])) { continue; }

	$infos_profils[$id_profil]['id_profil'] = $id_profil;
	include_once ($CONFIG_DIR."profil_".$_SESSION['profils'][$id_profil]->getCode_profil().".config.php");
	
	
	// *************************************************
	// chargement
	$contact= new contact ($_REQUEST['ref_contact']);
	$profils 	= $contact->getProfils();
	$profils[$id_profil]->maj_defaut_lib_compte ($_REQUEST['defaut_lib_compte']);
}
// *************************************************************************************************************
// AFFICHAGE
// -*************************************************************************************************************


?>maj_defaut_lib_compte