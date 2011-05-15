<?php
// *************************************************************************************************************
// LISTE DES TACHES A CREES
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");
require ($CONFIG_DIR."profil_".$_SESSION['profils'][$COLLAB_ID_PROFIL]->getCode_profil().".config.php");


$order_by = "";

//ordonancement
if(isset($_REQUEST["order_by_date"]) && ($_REQUEST["order_by_date"] == "ASC" || $_REQUEST["order_by_date"] == "DESC")) {
	$order_by = "date_creation ".$_REQUEST["order_by_date"].", urgence DESC, importance DESC ";
}
if(isset($_REQUEST["order_by_urgence"]) && ($_REQUEST["order_by_urgence"] == "ASC" || $_REQUEST["order_by_urgence"] == "DESC")) {
	$order_by = "urgence ".$_REQUEST["order_by_urgence"].", date_creation DESC, importance DESC ";
}
if(isset($_REQUEST["order_by_importance"]) && ($_REQUEST["order_by_importance"] == "ASC" || $_REQUEST["order_by_importance"] == "DESC" )) {
	$order_by = "importance ".$_REQUEST["order_by_importance"].", urgence DESC, date_creation DESC ";
}

//pagination
$page_to_show = 1;
if(isset($_REQUEST["page_to_show"])) {
	$page_to_show = $_REQUEST["page_to_show"];
}

//afficher tout les etats
$etat_tache = "0,1";
if(isset($_REQUEST["all_etat_tache"]) && $_REQUEST["all_etat_tache"] == "1") {
	$etat_tache = "0,1,2";
}

//nombre de taches par page
$taches_par_page = $NB_TACHES_SHOWED;

//chargement des taches du contact en session
$liste_taches_crees = array();
$liste_taches_crees = $_SESSION['user']->profil->charger_taches_crees ($order_by, $page_to_show, $taches_par_page, $etat_tache);

// Comptage des résultats
$nb_taches = $_INFOS['nb_taches'];

// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_planning_taches_crees_liste.inc.php");

?>