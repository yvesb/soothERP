<?php
// *************************************************************************************************************
// AJOUT TPV
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");


//ouverture de la class compte_tpv
$compte_tpv = new compte_tpv ();

$infos = array();
$infos['lib_tpv'] 						= $_REQUEST["lib_tpv"];
$infos['module_name'] 				= $_REQUEST["module_name"];
$infos['com_ope'] 						= $_REQUEST["com_ope"];
$infos['com_var'] 						= $_REQUEST["com_var"];
$infos['id_compte_bancaire'] 	= $_REQUEST["id_compte_bancaire"];
	
	
//création du compte
$compte_tpv->create_compte_tpv ($infos);

// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_compta_compte_tpv_add.inc.php");

?>