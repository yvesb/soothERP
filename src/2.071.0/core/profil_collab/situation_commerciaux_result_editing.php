<?php
//  ******************************************************
// AFFICHAGE DES Résultats commerciaux (IMPRESSION ET ENVOIS)
//  ******************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");

//  ******************************************************
// AFFICHAGE
// - ******************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_situation_commerciaux_result_editing.inc.php");
?>