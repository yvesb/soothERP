<?php
// *************************************************************************************************************
// EDITION DE L'UTILISATEUR
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");


if (isset($_REQUEST['ref_user'])) {	
	//traitement des enregistrements
	
	$utilisateur = new utilisateur ($_REQUEST['ref_user']);
	$utilisateur->set_master ();
	
	
}
	
	
// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

//include ($DIR.$_SESSION['theme']->getDir_theme()."page_set_master.inc.php");

?>