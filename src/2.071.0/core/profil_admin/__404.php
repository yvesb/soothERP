<?php
//  ******************************************************
// ERREUR 404 DANS PROFIL ADMIN
//  ******************************************************
require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");

// AFFICHAGE
	header ("Location: ".$_ENV['CHEMIN_ABSOLU'].$CORE_REP."profil_admin/accueil.php");
	exit(); 
?>