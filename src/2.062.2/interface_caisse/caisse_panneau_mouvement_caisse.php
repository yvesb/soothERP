<?php
// *************************************************************************************************************
// PANNEAU AFFICHE EN BAS DE L'INTERFACE DE CAISSE
// *************************************************************************************************************

require ("_dir.inc.php");
require ("_profil.inc.php");
require ("_session.inc.php");

if(!isset($_REQUEST["sens_mouvement"])){
	echo "le sens du mouvement de la caisse n'est pas spécifié";
	exit; 
}

$sens_mouvement = $_REQUEST["sens_mouvement"];

include ($DIR.$_SESSION['theme']->getDir_theme()."page_caisse_panneau_mouvement_caisse.inc.php");

?>