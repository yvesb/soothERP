<?php
// *************************************************************************************************************
// supression D'UN compte de plan comptable général des favoris
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");


//ouverture de la class compta_plan_general
if (isset($_REQUEST["numero_compte"])) {
	$compte_plan_general = new compta_plan_general ($_REQUEST["numero_compte"]);
	//suppression de la liste des favoris du compte
	$compte_plan_general->desactive_compte ();
// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_compta_plan_entreprise_sup.inc.php");

}
?>