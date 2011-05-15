<?php
// *************************************************************************************************************
// SUPRESSION D'UNE CARTE BANCAIRE 
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");


//ouverture de la class compte_cb
	$compte_cb = new compte_cb ($_REQUEST["id_compte_cb"]);
	
	//création du compte
	$compte_cb->suppression ();

// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_compta_compte_cbs_sup.inc.php");

?>