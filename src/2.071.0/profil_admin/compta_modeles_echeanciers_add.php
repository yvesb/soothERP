<?php
// *************************************************************************************************************
// AJOUT D'UNE CARTE BANCAIRE 
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");


//_vardump($_REQUEST);

$new_modele_ech = new modele_echeancier();

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

$new_modele_ech->create_modele_echeancier($infos);

//_vardump($new_modele_ech);
// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_compta_modeles_echeanciers_add.inc.php");

?>