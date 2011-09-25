<?php
// *************************************************************************************************************
// ACCUEIL DE LA GESTION DES PROFILS
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");

$infos	=	array();
$infos['actif']				=	$_REQUEST["actif_".$_REQUEST["id_profil"]];
$infos['niveau_secu']	=	$_REQUEST["niveau_secu_".$_REQUEST["id_profil"]];
$infos['id_profil']		=	$_REQUEST["id_profil"];

profil::maj_profil ($infos);


// *************************************************************************************************************
// AFFICHAGE
// -*************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_annuaire_gestion_profils_mod.inc.php");

?>