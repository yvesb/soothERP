<?php
// *************************************************************************************************************
// CHANGE LE LIBELE DU TYPE D'UN COURRIER
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");

if(!isset($_REQUEST["id_type_courrier"])){
	echo "l'id du type de courrier est inconnu";
	exit;
}
$id_type_courrier = $_REQUEST["id_type_courrier"];

if(!isset($_REQUEST["lib_type_courrier"])){
	echo "le nouveau libélé du type est inconnu";
	exit;
}
$lib_type_courrier = $_REQUEST["lib_type_courrier"];

setLib_type_courrier($id_type_courrier, $lib_type_courrier);

// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_courriers_gestion_types_mod.inc.php");

?>