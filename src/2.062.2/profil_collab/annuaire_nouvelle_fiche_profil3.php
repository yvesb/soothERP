<?php
// *************************************************************************************************************
// NOUVEAU PROFIL COLLAB
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");



//liste des pays pour affichage dans select
$listepays = getPays_select_list ();

//fonctions de collaborateurs
$liste_fonctions_collab = charger_fonctions ($COLLAB_ID_PROFIL);

// *************************************************************************************************************
// AFFICHAGE
// -*************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_annuaire_nouvelle_fiche_profil3.inc.php");

?>