<?php
// *************************************************************************************************************
// ACCUEIL DE L'UTILISATEUR ADMINISTRATEUR
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ("_session.inc.php");
require ($CONFIG_DIR."profil_".$_SESSION['profils'][$COLLAB_ID_PROFIL]->getCode_profil().".config.php");


// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

$afficher_magasin = Icaisse::afficherBoutonChoixPointDeVente();

include ($DIR.$_SESSION['theme']->getDir_theme()."page_accueil.inc.php");

?>