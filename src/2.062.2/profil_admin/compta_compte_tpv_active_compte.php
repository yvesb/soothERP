<?php
// *************************************************************************************************************
// ACTIVATION TPV
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");


//ouverture de la class compte_tpv
	$compte_tpv = new compte_tpv ($_REQUEST["id_compte_tpv"]);
	
	
	//activation du compte
	$compte_tpv->active_compte ();


?>