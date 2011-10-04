<?php
// *************************************************************************************************************
// MODIFICATION TPE
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");


//ouverture de la class compte_tpe
	$compte_tpe = new compte_tpe ($_REQUEST["id_compte_tpe"]);

$infos = array();
$infos['lib_tpe'] 						= $_REQUEST["lib_tpe_".$_REQUEST["id_compte_tpe"]];
$infos['id_magasin'] 					= $_REQUEST["id_magasin_".$_REQUEST["id_compte_tpe"]];
$infos['id_compte_bancaire'] 	= $_REQUEST["id_compte_bancaire_".$_REQUEST["id_compte_tpe"]];
$infos['com_ope'] 						= $_REQUEST["com_ope_".$_REQUEST["id_compte_tpe"]];
$infos['com_var'] 						= $_REQUEST["com_var_".$_REQUEST["id_compte_tpe"]];
	
	
	//modification du compte
	$compte_tpe->maj_compte_tpe ($infos);

// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_compta_compte_tpes_mod.inc.php");

?>