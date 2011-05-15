<?php
// *************************************************************************************************************
// EDITION D'UNE TACHE
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");


//chargement des modes d'édition
//infos pour mini moteur de recherche contact
$profils_mini = array();
foreach ($_SESSION['profils'] as $profil) {
	if ($profil->getId_profil() == $COLLAB_ID_PROFIL) {$profils_mini[] = $profil;}
	
}
unset ($profil);

//fonctions de collaborateurs
$liste_fonctions_collab = charger_fonctions ($COLLAB_ID_PROFIL);

if (isset($_REQUEST["id_tache"])) {
//maj de la tache
$tache_cree = new tache ($_REQUEST["id_tache"]);

//chargement des informations de la tache
$liste_collabs = array();
$liste_collabs = $tache_cree->getCollabs ();
$liste_collabs_fonctions = array();
$liste_collabs_fonctions = $tache_cree->getCollabs_fonctions ();
}

// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_planning_taches_edition.inc.php");

?>