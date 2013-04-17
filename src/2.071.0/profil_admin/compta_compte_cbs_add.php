<?php
// *************************************************************************************************************
// AJOUT D'UNE CARTE BANCAIRE 
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");


//ouverture de la class compte_cb
	$compte_cb = new compte_cb ();

$infos = array();
$infos['id_compte_bancaire'] 	= $_REQUEST["id_compte_bancaire"];
$infos['ref_porteur'] 		= $_REQUEST["ref_porteur"];
$infos['id_cb_type'] 		= $_REQUEST["id_cb_type"];
$infos['numero_carte'] 	= $_REQUEST["numero_carte"];
$infos['date_expiration'] 	= date("Y-m-d", strtotime(date_Fr_to_Us('01-'.$_REQUEST["date_expiration"])));
$infos['controle'] 			= $_REQUEST["controle"];
$infos['differe'] 					= $_REQUEST["differe"];
	
	
	//création du compte
	$compte_cb->create_compte_cb ($infos);

// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_compta_compte_cbs_add.inc.php");

?>