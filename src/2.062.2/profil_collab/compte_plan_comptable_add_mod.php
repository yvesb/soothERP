<?php
// *************************************************************************************************************
// AJOUT D'UN COMPTE COMPTABLE
// *************************************************************************************************************

//Require
require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");

//Vars
$form['numero_compte'] = $search['numero_compte'] = "";
if (isset($_REQUEST['numero_compte'])) {
	$form['numero_compte'] = $_REQUEST['numero_compte'];
	$search['numero_compte'] = $_REQUEST['numero_compte'];
}
$form['lib_compte'] = $search['lib_compte'] = "";
if (isset($_REQUEST['lib_compte'])) {
	$form['lib_compte'] = $_REQUEST['lib_compte'];
	$search['lib_compte'] = $_REQUEST['lib_compte'];
}

//Verifs BDD
$query = "SELECT count(*) as nb_occurence, numero_compte, lib_compte
				FROM plan_comptable
				WHERE 	numero_compte = '".$search['numero_compte']."' 
				OR 		lib_compte = '".$search['lib_compte']."';";
if( $bdd->exec()  ){
	
}

// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_compte_plan_comptable_add.inc.php");
