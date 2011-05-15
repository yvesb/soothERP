<?php
// *************************************************************************************************************
// ACCUEIL DE L'UTILISATEUR ADMINISTRATEUR
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");


//ouverture de la class compte_caisse
	$compte_caisse = new compte_caisse ();

$infos = array();
$infos['lib_caisse'] 		= $_REQUEST["lib_caisse"];
$infos['id_magasin'] 		= $_REQUEST["id_magasin"];
$infos['id_compte_tpe'] 	= $_REQUEST["id_compte_tpe"];
	
	
	//création du compte
	$compte_caisse->create_compte_caisse ($infos);

// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_compta_compte_caisse_add.inc.php");

?>