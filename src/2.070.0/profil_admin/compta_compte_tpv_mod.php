<?php
// *************************************************************************************************************
// MODIFICATION TPV
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");


//ouverture de la class compte_tpve
	$compte_tpv = new compte_tpv ($_REQUEST["id_compte_tpv"]);

$infos = array();
$infos['lib_tpv'] 						= $_REQUEST["lib_tpv_".$_REQUEST["id_compte_tpv"]];
$infos['module_name'] 					= $_REQUEST["module_name_".$_REQUEST["id_compte_tpv"]];
$infos['id_compte_bancaire'] 	= $_REQUEST["id_compte_bancaire_".$_REQUEST["id_compte_tpv"]];
$infos['com_ope'] 						= $_REQUEST["com_ope_".$_REQUEST["id_compte_tpv"]];
$infos['com_var'] 						= $_REQUEST["com_var_".$_REQUEST["id_compte_tpv"]];
	
	
	//modification du compte
	$compte_tpv->maj_compte_tpv ($infos);

// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_compta_compte_tpv_mod.inc.php");

?>