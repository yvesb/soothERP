<?php
// *************************************************************************************************************
// ACCUEIL DE L'UTILISATEUR ADMINISTRATEUR
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");


//ouverture de la class compte_caisse
	$compte_caisse = new compte_caisse ($_REQUEST["id_compte_caisse"]);
	
	
	//activation du compte
	$compte_caisse->active_compte ();


?>