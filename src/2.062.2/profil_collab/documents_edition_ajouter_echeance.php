<?php
// *************************************************************************************************************
// FUSION DE DOCUMENTS
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");

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
}
?>