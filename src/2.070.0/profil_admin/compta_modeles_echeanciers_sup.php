<?php
// *************************************************************************************************************
// SUPRESSION D'UNE CARTE BANCAIRE 
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");


//ouverture de la class compte_cb
	$modele_ech = new modele_echeancier($_REQUEST["id_mod_ech"]);
	
	//création du compte
	$modele_ech->suppression ();

// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_compta_modeles_echeanciers_sup.inc.php");

?>