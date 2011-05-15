<?php
// *************************************************************************************************************
// AJOUT TPE
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");


//ouverture de la class compte_tpe
	$compte_tpe = new compte_tpe ();

$infos = array();
$infos['lib_tpe'] 						= $_REQUEST["lib_tpe"];
$infos['id_magasin'] 					= $_REQUEST["id_magasin"];
$infos['com_ope'] 						= $_REQUEST["com_ope"];
$infos['com_var'] 						= $_REQUEST["com_var"];
$infos['id_compte_bancaire'] 	= $_REQUEST["id_compte_bancaire"];
	
	
	//création du compte
	$compte_tpe->create_compte_tpe ($infos);

// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_compta_compte_tpes_add.inc.php");

?>