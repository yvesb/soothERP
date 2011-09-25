<?php
// *************************************************************************************************************
// MODIF D'UNE CARTE BANCAIRE 
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");


//ouverture de la class compte_cb
	$compte_cb = new compte_cb ($_REQUEST["id_compte_cb"]);

$infos = array();
$infos['id_compte_bancaire'] 	= $_REQUEST["id_compte_bancaire_".$_REQUEST["id_compte_cb"]];
$infos['ref_porteur'] 				= $_REQUEST["ref_porteur_".$_REQUEST["id_compte_cb"]];
$infos['id_cb_type'] 					= $_REQUEST["id_cb_type_".$_REQUEST["id_compte_cb"]];
$infos['numero_carte'] 				= $_REQUEST["numero_carte_".$_REQUEST["id_compte_cb"]];
$infos['date_expiration']		 	= date("Y-m-d", strtotime(date_Fr_to_Us('01-'.$_REQUEST["date_expiration_".$_REQUEST["id_compte_cb"]])));
$infos['controle'] 						= $_REQUEST["controle_".$_REQUEST["id_compte_cb"]];
$infos['differe'] 						= $_REQUEST["differe_".$_REQUEST["id_compte_cb"]];
	
	
	//création du compte
	$compte_cb->maj_compte_cb ($infos);

// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_compta_compte_cbs_mod.inc.php");

?>