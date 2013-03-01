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

if (isset($_REQUEST["id_fonction"])){

	// chargement de la class des fonctions
	$fonction = new fonctions($_REQUEST["id_fonction"]);

	$fonction->maj_fonction_user_permissions();
	
}
?>