<?php
// *************************************************************************************************************
// MODIFICATION D'UN PROFIL
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");


if ($COMMERCIAL_ID_PROFIL != 0) {	
	// *************************************************
	// Controle des données fournies par le formulaire

	$infos_profils = array();
	$id_profil	=	$COMMERCIAL_ID_PROFIL;
	if (!isset($_SESSION['profils'][$id_profil])) { continue; }

	$infos_profils[$id_profil]['id_profil'] = $id_profil;
	include_once ($CONFIG_DIR."profil_".$_SESSION['profils'][$id_profil]->getCode_profil().".config.php");
	
	$infos_profils[$id_profil]['id_commercial_categ'] 	=  $_REQUEST['comm_id_commercial_categ_'.$_REQUEST["ref_contact"]];
	$infos_profils[$id_profil]['id_commission_regle'] 	=  $_REQUEST['comm_id_commission_regle_'.$_REQUEST["ref_contact"]];
	
	// *************************************************
	// Modification du profil
	$contact= new contact ($_REQUEST['ref_contact']);
	$contact->maj_profiled_infos ($infos_profils[$id_profil]);
	
	

}
// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_commission_commercial_mod.inc.php");

?>