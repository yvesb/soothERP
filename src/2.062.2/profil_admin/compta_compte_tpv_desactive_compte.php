<?php
// *************************************************************************************************************
// DESACTIVE TPV
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");


//ouverture de la class compte_tpv
	$compte_tpv = new compte_tpv ($_REQUEST["id_compte_tpv"]);
	
	
	//desactivation du compte
	$compte_tpv->desactive_compte ();


?>