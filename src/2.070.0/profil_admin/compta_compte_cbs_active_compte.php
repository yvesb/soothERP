<?php
// *************************************************************************************************************
// ACTIVATION D'UNE CARTE BANCAIRE 
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");


//ouverture de la class compte_cb
	$compte_cb = new compte_cb ($_REQUEST["id_compte_cb"]);
	
	//activation du compte
	$compte_cb->active_compte ();


?>