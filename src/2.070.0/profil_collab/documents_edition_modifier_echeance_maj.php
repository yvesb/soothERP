<?php
// *************************************************************************************************************
// FUSION DE DOCUMENTS
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");
//_vardump($_REQUEST);
$infos = array();
$ref_doc = $_REQUEST['ref_doc'];
$montant_acquite = $_REQUEST['montant_acquite'];
$infos["ref_doc"] = $_REQUEST['ref_doc'];
$inp_to_use = $_REQUEST['inp_to_use'];
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
		$infos["echeances"][substr($key,12)]["pourcentage"] = $value;
	}
        if(substr($key,0,9) == "inp_euro_"){
                $infos["echeances"][substr($key,9)]["montant"] = $value;
        }
}

$facture = open_doc($infos["ref_doc"]);
$nb_ech = count($infos["echeances"]);
$facture->getEcheancierObj()->suppr_echeancier();
if ($inp_to_use == "montant"){
    for ( $i=1; $i<=$nb_ech; $i++){
        $facture->getEcheancierObj()->add_montant_jours($infos["echeances"][$i]['id_mode_reglement'], $infos["echeances"][$i]['type_reglement'], $infos["echeances"][$i]['montant'], $infos["echeances"][$i]['jour']);
    }
}

else{
    for ( $i=1; $i<=$nb_ech; $i++){
        $facture->getEcheancierObj()->add_pourcent_jours($infos["echeances"][$i]['id_mode_reglement'], $infos["echeances"][$i]['type_reglement'], $infos["echeances"][$i]['pourcentage'], $infos["echeances"][$i]['jour']);
    }
}

$new_date_echeance = $facture->getEcheancierObj()->get_Last_echeance($facture->getRef_doc());
if ($new_date_echeance != false)
    $facture->maj_date_echeance($new_date_echeance);

/*
$ref_doc = $_REQUEST["ref_doc"];
$montant_acquite = $_REQUEST["montant_acquite"];
$montant_ech = $_REQUEST["montant_ech"];
$select_montant_ech = $_REQUEST["select_montant_ech"];
$mode_reglement_ech = $_REQUEST["mode_reglement_ech"];
$date_fixe_ech = $_REQUEST["date_fixe_ech"];
$date_delai_ech = $_REQUEST["date_delai_ech"];
$type_ech = $_REQUEST["type_ech"];

global $bdd;

if ($select_montant_ech == 1){
$query = "UPDATE `doc_echeanciers`
		  SET `montant`           = ".$montant_ech.",";
	if($mode_reglement_ech != 0){
		      $query .= "`id_mode_reglement` = ".$mode_reglement_ech.", ";
	}
	if($date_fixe_ech != ""){
			  $query .= "`date`              = str_to_date('".$date_fixe_ech."','%d/%m/%Y'), ";
	}
	if($date_delai_ech != ""){
		      $query .= "`jour`              = ".$date_delai_ech.", ";
	}
		      $query .= "`type_reglement`    = '".$type_ech."' 
		  WHERE `ref_doc` = '".$ref_doc."' ";
}else{
$query = "UPDATE `doc_echeanciers`
		  SET `pourcentage`       = ".$montant_ech.",";
	if($mode_reglement_ech != 0){
   $query .= "`id_mode_reglement` = ".$mode_reglement_ech.", ";
	}
	if($date_fixe_ech != ""){
   		$query .= "`date`         = str_to_date('".$date_fixe_ech."','%d/%m/%Y'), ";
	}
	if($date_delai_ech != ""){
   $query .= "`jour`              = ".$date_delai_ech.", ";
	}
   $query .= "`type_reglement`    = '".$type_ech."' 
		  WHERE `ref_doc` = '".$ref_doc."' ";	
}

if($bdd->exec($query)){
// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_documents_edition_recharger_echeance.inc.php");
}*/
include ($DIR.$_SESSION['theme']->getDir_theme()."page_documents_edition_recharger_echeance.inc.php");
?>