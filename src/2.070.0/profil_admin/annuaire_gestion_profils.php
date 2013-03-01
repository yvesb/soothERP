<?php
// *************************************************************************************************************
// ACCUEIL DE LA GESTION DES PROFILS
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");

// chargement de la liste complète des profils
$profils_liste	= getAll_profils ();

// *************************************************************************************************************
// AFFICHAGE
// -*************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_annuaire_gestion_profils.inc.php");

?>