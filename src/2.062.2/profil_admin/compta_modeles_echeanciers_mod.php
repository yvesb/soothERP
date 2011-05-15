<?php
// *************************************************************************************************************
// MODIF D'UN MODELE D'ECHEANCIER
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");


$new_modele_ech = new modele_echeancier($_REQUEST["id_mod_ech"]);

//_vardump($_REQUEST);
$infos = array();
$infos["lib_echeancier_modele"] = $_REQUEST["lib_modele"];

foreach($_REQUEST as $key => $value){
	if(substr($key,0,10) == "slct_type_"){
		$infos["echeances"][substr($key,10)]["type_reglement"] = $value;
	}
	if(substr($key,0,10) == "slct_mode_"){
		$infos["echeances"][substr($key,10)]["id_mode_reglement"] = $value;
	}
	if(substr($key,0,10) == "inp_delai_"){
		$infos["echeances"][substr($key,10)]["jour"] = intval($value);
	}
	if(substr($key,0,12) == "inp_montant_"){
		$infos["echeances"][substr($key,12)]["pourcentage"] = intval($value);
	}
}
//_vardump($_REQUEST);

$new_modele_ech->maj_modele_echeancier($infos);

// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_compta_modeles_echeanciers_mod.inc.php");

?>