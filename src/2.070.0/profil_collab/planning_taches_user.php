<?php
// *************************************************************************************************************
// AFFICHAGE DES TACHES A FAIRE
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");
require ($CONFIG_DIR."profil_".$_SESSION['profils'][$COLLAB_ID_PROFIL]->getCode_profil().".config.php");

	
//infos pour mini moteur de recherche contact
$profils_mini = array();
foreach ($_SESSION['profils'] as $profil) {
	if ($profil->getId_profil() == $COLLAB_ID_PROFIL) {$profils_mini[] = $profil;}
	
}
unset ($profil);

//fonctions de collaborateurs
$liste_fonctions_collab = charger_fonctions ($COLLAB_ID_PROFIL);

$order_by = "";

//pagination
$page_to_show = 1;

//afficher tout les etats
$etat_tache = "0,1";

//nombre de taches par page
$taches_par_page = $NB_TACHES_SHOWED;

//chargement des taches du contact en session
$liste_taches = array();
$liste_taches = $_SESSION['user']->profil->charger_taches_todo ($order_by, $page_to_show, $taches_par_page, $etat_tache);

// Comptage des résultats
$nb_taches = $_INFOS['nb_taches'];

// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_planning_taches_user.inc.php");

?>