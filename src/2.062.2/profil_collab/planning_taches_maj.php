<?php
// *************************************************************************************************************
// MAJ D'UNE TACHE
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");


//maj de la tache
$tache = new tache ($_REQUEST["id_tache"]);
$tache->maj_tache($_REQUEST["lib_tache"], $_REQUEST["text_tache"], $_REQUEST["importance"], $_REQUEST["urgence"], date_Fr_to_Us($_REQUEST["date_echeance"]));
	
	
// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_planning_taches_maj.inc.php");

?>