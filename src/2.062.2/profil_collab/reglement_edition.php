<?php
// *************************************************************************************************************
// EDITION D'UN REGLEMENT
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");



if (isset($_REQUEST["ref_reglement"])) {
//maj de la tache
$reglement = new reglement ($_REQUEST["ref_reglement"]);
$lettrages = $reglement->getLettrages ();
}

// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_reglement_edition.inc.php");

?>