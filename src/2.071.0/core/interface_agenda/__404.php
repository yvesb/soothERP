<?php
//  ******************************************************
// ERREUR 404 DANS PROFIL COLLAB
//  ******************************************************
require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");

// AFFICHAGE
	header ("Location: ".$_ENV['CHEMIN_ABSOLU'].$CORE_REP."interface_agenda/accueil.php");
	exit(); 
?>