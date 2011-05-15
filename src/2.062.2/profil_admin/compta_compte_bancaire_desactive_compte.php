<?php
// *************************************************************************************************************
// ACCUEIL DE L'UTILISATEUR ADMINISTRATEUR
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");


//ouverture de la class compte_bancaire
	$compte_bancaire = new compte_bancaire ($_REQUEST["id_compte_bancaire"]);
	
	
	//desactivation du compte
	$compte_bancaire->desactive_compte ();


?>