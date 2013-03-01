<?php
// *************************************************************************************************************
// ACCUEIL DE L'UTILISATEUR ADMINISTRATEUR
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");


//ouverture de la class compte_caisse
$compte_caisse = new compte_caisse ($_REQUEST["id_compte_caisse"]);

$infos = array();
$infos['lib_caisse'] 	= $_REQUEST["lib_caisse_".$_REQUEST["id_compte_caisse"]];
$infos['id_magasin'] 	= $_REQUEST["id_magasin_".$_REQUEST["id_compte_caisse"]];
	
	
//modification du compte
$compte_caisse->maj_compte_caisse ($infos);

// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_compta_compte_caisse_mod.inc.php");

?>