<?php
// *************************************************************************************************************
// SUPPRESSION D'UN ROLE DE COLLABORATEUR
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");

// chargement de la class des fonctions
$fonction = new fonctions($_REQUEST["id_fonction"]);
//suppression de la fonctions
$fonction->delete_fonction ();

// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_annuaire_gestion_users_fonctions_sup.inc.php");

?>