<?php
// *************************************************************************************************************
// ACCUEIL DE L'UTILISATEUR ADMINISTRATEUR
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");
require ($CONFIG_DIR."profil_".$_SESSION['profils'][$COLLAB_ID_PROFIL]->getCode_profil().".config.php");


//chargement des taches du contact en session
$liste_taches = array();
$liste_taches = $_SESSION['user']->profil->charger_taches_todo ("", 1, $NB_TACHES_SHOWED_ACCUEIL);

//chargement des taches du contact en session
$liste_open_docs = array();
$liste_open_docs = $_SESSION['user']->profil->charger_open_docs ();


//chargement de la liste des favoris (de l'utilisateur en cours
$liste_links = web_link::charger_web_link ();


// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************


include ($DIR.$_SESSION['theme']->getDir_theme()."page_accueil.inc.php");

?>