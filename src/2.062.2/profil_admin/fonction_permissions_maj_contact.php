<?php 
// *************************************************************************************************************
// MISE A JOUR DES PERMISSION D'UTILISATEURS D'APRES LEURS FONCTIONS
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");


// *************************************************************************************************************
// TRAITEMENTS
// *************************************************************************************************************

if (isset($_REQUEST["id_fonction"]) && isset($_REQUEST["ref_contact"]) && isset($_REQUEST["ref_user"])){

	// chargement de la class des fonctions
	$fonction = new fonctions($_REQUEST["id_fonction"]);

	$fonction->maj_user_permissions($_REQUEST["ref_contact"],$_REQUEST["ref_user"]);
	
}
?>