<?php
// *************************************************************************************************************
// IMPORT FICHIER ANNUAIRE CSV
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");


//$dao = new dao_csv_import_annu_cols();
$dao = new import_annuaire_csv_colonne();
$array_verif_doublon = array();
$array_verif_corresp_doublon = array();
$index = 1;

$flagChampNomObigatoire = false; 
foreach ($_POST as $k => $v){
	if (substr_count($k, "_equiv_")) {continue;}
	if (!$v || (is_array($v) && !count($v))) {continue;} 
	if (is_array($v)) {
		foreach ($v as $uv) {
			if (!$uv) {continue;} 
			$array_verif_doublon[$uv][] = $k;
		}
	}else {
		$array_verif_doublon[$v][] = $k;
	}
	foreach ($_POST as $l => $m){
		if (!substr_count($l, $k."_equiv_")) {continue;}
		if (!$m) {continue;}
		$array_verif_corresp_doublon[$k][$m][] = $l;
	}
	if($k == "nom" && (is_array($v) && count($v) && trim($v[0]) != "") ){
		$flagChampNomObigatoire = true;
	}
}
if (isset($array_verif_doublon)) {
	foreach ($array_verif_doublon as $ck=>$alt) {
		if (count($alt)<2) {continue;}
		print_r($alt);
		$GLOBALS['_ALERTES']['doublons'] = 1;
		
	}
}

if (count($GLOBALS['_ALERTES'])) {
echo "ERREUR !!!";
}



if (isset($array_verif_corresp_doublon)) {
	foreach ($array_verif_corresp_doublon as $alt=>$hd) {
		foreach ($hd as $alerte => $value) {
			if (count($value)<2) {continue;}
			$GLOBALS['_ALERTES']['doublons'] = 1;
		}
	}
}


if(!$flagChampNomObigatoire){
	$GLOBALS['_ALERTES']['flagChampNomObigatoire'] = "Champ nom Obigatoire";
}
if (!count($GLOBALS['_ALERTES'])) {
	
	foreach ($_POST as $k => $v){
		if (substr_count($k, "_equiv_")) {continue;}
		if (!$v || (is_array($v) && !count($v))) {continue;} 
		
		if (is_array($v)) {
			foreach ($v as $uv) {
				if (!$uv) {continue;} 
				$dao->update($uv,$k);
			}
		}else {
			$dao->update($v,$k);
		}
		foreach ($_POST as $l => $m){
			if (!substr_count($l, $k."_equiv_")) {continue;}
			if (!$m) {continue;}
			$dao_csv_import_annu_ligne = new import_annuaire_csv_ligne();
			$dao_csv_import_annu_ligne->updateParLot($v,$m,str_replace($k."_equiv_","",$l));
		}
	}
	$import_annuaire = new import_annuaire_csv(); 
	$import_annuaire->maj_etape(2);
}

	//
	//$index++;
// *************************************************************************************************************
// REDIRECT
// *************************************************************************************************************
include ($DIR."profil_".$_SESSION['profils'][$ID_PROFIL]->getCode_profil()."/modules/".$import_annuaire_csv['folder_name']."themes/".$_SESSION['theme']->getCode_theme()."/page_import_annuaire_csv_step1_done.inc.php");
?>