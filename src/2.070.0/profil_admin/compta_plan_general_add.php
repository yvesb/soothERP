<?php
// *************************************************************************************************************
// AJOUT D'UN compte de plan comptable général
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");


//ouverture de la class compta_plan_general
	$compte_plan_general = new compta_plan_general ();

$infos = array();
$infos['numero_compte'] 	= $_REQUEST["numero_compte"];
$infos['lib_compte'] 		= $_REQUEST["lib_compte"];
$favori = 0;
if (isset($_REQUEST["favori"]) ) {
	$favori = $_REQUEST["favori"];
}
$infos['favori'] 		= $favori;
	
	
	//création du compte
	$compte_plan_general->create_compte_plan_comptable ($infos);

// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_compta_plan_general_add.inc.php");

?>