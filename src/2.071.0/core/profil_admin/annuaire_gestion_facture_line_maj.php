<?php
// *************************************************************************************************************
// MAJ des lignes de relance
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");

if (isset($_REQUEST['delai_before_next'])) {
	
	$delai_before_next = $_REQUEST['delai_before_next'];
	$id_line = $_REQUEST['id_line'];
	$id_relance_modele = $_REQUEST['id_relance_modele'];

	global $bdd;
	
	if ($id_relance_modele == 0){
		$query = "UPDATE factures_relances_niveaux SET delai_before_next = ".$delai_before_next."
							WHERE id_niveau_relance = '".$id_line."' 
							AND id_relance_modele IS NULL";
	}
	else{
		$query = "UPDATE factures_relances_niveaux SET delai_before_next = ".$delai_before_next."
							WHERE id_niveau_relance = '".$id_line."' 
							AND id_relance_modele = '".$id_relance_modele."' ";
	}
}
if (isset($_REQUEST['id_edition_mode'])) {
	
	$id_edition_mode = $_REQUEST['id_edition_mode'];
	$id_line = $_REQUEST['id_line'];
	$id_relance_modele = $_REQUEST['id_relance_modele'];
	
	global $bdd;
	if ($id_relance_modele == 0){
		if(empty($id_edition_mode)){
			$query = "UPDATE factures_relances_niveaux SET id_edition_mode = NULL
							WHERE id_niveau_relance = '".$id_line."' 
							AND id_relance_modele IS NULL";
		}else{
			$query = "UPDATE factures_relances_niveaux SET id_edition_mode = ".$id_edition_mode."
							WHERE id_niveau_relance = '".$id_line."' 
							AND id_relance_modele IS NULL";
		}
	}
	else{
		if(empty($id_edition_mode)){
			$query = "UPDATE factures_relances_niveaux SET id_edition_mode = NULL
							WHERE id_niveau_relance = '".$id_line."'
							AND id_relance_modele = '".$id_relance_modele."' ";
		}
		else{
			$query = "UPDATE factures_relances_niveaux SET id_edition_mode = ".$id_edition_mode."
							WHERE id_niveau_relance = '".$id_line."'
							AND id_relance_modele = '".$id_relance_modele."' ";
		}
	}
}
if (isset($_REQUEST['montant_min'])) {
	
	$montant_min = $_REQUEST['montant_min'];
	$id_line = $_REQUEST['id_line'];
	$id_relance_modele = $_REQUEST['id_relance_modele'];
	global $bdd;
	
	if ($id_relance_modele == 0){
		$query = "UPDATE factures_relances_niveaux SET montant_mini = ".$montant_min."
							WHERE id_niveau_relance = '".$id_line."' 
							AND id_relance_modele IS NULL";
	}
	else{
		$query = "UPDATE factures_relances_niveaux SET montant_mini = ".$montant_min."
							WHERE id_niveau_relance = '".$id_line."'
							AND id_relance_modele = '".$id_relance_modele."' ";
	}
}
if (isset($_REQUEST['impression_checked'])) {
	
	$impression_checked = $_REQUEST['impression_checked'];
	$id_line = $_REQUEST['id_line'];
	$id_relance_modele = $_REQUEST['id_relance_modele'];
	global $bdd;

	if ($id_relance_modele == 0){
		$query = "UPDATE factures_relances_niveaux SET impression = ".$impression_checked."
							WHERE id_niveau_relance = '".$id_line."' 
							AND id_relance_modele IS NULL";
	}
	else{
		$query = "UPDATE factures_relances_niveaux SET impression = ".$impression_checked."
							WHERE id_niveau_relance = '".$id_line."'
							AND id_relance_modele = '".$id_relance_modele."' ";
	}
}
if (isset($_REQUEST['actif_checked'])) {
	
	$actif_checked = $_REQUEST['actif_checked'];
	$id_line = $_REQUEST['id_line'];
	$id_relance_modele = $_REQUEST['id_relance_modele'];
	global $bdd;
	
	if ($id_relance_modele == 0){
		$query = "UPDATE factures_relances_niveaux SET actif = ".$actif_checked."
							WHERE id_niveau_relance = '".$id_line."' 
							AND id_relance_modele IS NULL";
	}
	else{
		$query = "UPDATE factures_relances_niveaux SET actif = ".$actif_checked."
							WHERE id_niveau_relance = '".$id_line."'
							AND id_relance_modele = '".$id_relance_modele."' ";
	}
}
if (isset($_REQUEST['suite_avant_echeance_checked'])) {
	
	$suite_avant_echeance_checked = $_REQUEST['suite_avant_echeance_checked'];
	$id_line = $_REQUEST['id_line'];
	$id_relance_modele = $_REQUEST['id_relance_modele'];
	global $bdd;
	
	if ($id_relance_modele == 0){
		$query = "UPDATE factures_relances_niveaux SET suite_avant_echeance = ".$suite_avant_echeance_checked."
							WHERE id_niveau_relance = '".$id_line."' 
							AND id_relance_modele IS NULL";
	}
	else{
		$query = "UPDATE factures_relances_niveaux SET suite_avant_echeance = ".$suite_avant_echeance_checked."
							WHERE id_niveau_relance = '".$id_line."'
							AND id_relance_modele = '".$id_relance_modele."' ";
	}
}
$bdd->exec ($query);
?>