<?php
// *************************************************************************************************************
// DESACTIVE TPE
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");


//ouverture de la class compte_tpe
	$compte_tpe = new compte_tpe ($_REQUEST["id_compte_tpe"]);
	
	
	//desactivation du compte
	$compte_tpe->desactive_compte ();


?>