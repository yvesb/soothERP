<?php
// *************************************************************************************************************
// IMPORT FICHIER catalogue CSV ETAPE 2 (après correspondance des colonnes et des valeurs du fichier)
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");



ini_set("memory_limit","40M");
$import_catalogue = new import_catalogue_csv(); 

$dao_csv_import_catalogue_ligne = new import_catalogue_csv_ligne();
$lignes = $dao_csv_import_catalogue_ligne->readAll();
if (!count($lignes)) {
	//import terminé ou aucun enregistrement à traiter
	$import_catalogue->maj_etape(3);
	header ("Location: ".$DIR."profil_".$_SESSION['profils'][$ID_PROFIL]->getCode_profil()."/modules/".$import_catalogue_csv['folder_name']."import_catalogue_csv_step3.php");
	exit();
}
$query = "SELECT id_colonne FROM csv_import_catalogue_cols WHERE champ_equivalent = 'lib_article'";
$resultat = $bdd->query ($query);
$array_retour = array();
while ($tmp = $resultat->fetchObject()) {
	$i=0;
	$query2 = "SELECT valeur FROM csv_import_catalogue_lines WHERE id_colonne = " . $tmp->id_colonne ; 
	$resultat2 = $bdd->query ($query2);
	while ($tmp2 = $resultat2->fetchObject()) {
		if (isset($array_retour[$i]["lib_article"])) {$array_retour[$i]["lib_article"] .= " ".$tmp2->valeur;} else {$array_retour[$i]["lib_article"] = $tmp2->valeur;}
		$i++;
	}
	unset ($query2, $resultat2, $tmp2);
}
$query = "SELECT id_colonne FROM csv_import_catalogue_cols WHERE champ_equivalent = 'ref_interne'";
$resultat = $bdd->query ($query);
while ($tmp = $resultat->fetchObject()) {
	$i=0;
	$query2 = "SELECT valeur FROM csv_import_catalogue_lines WHERE id_colonne = " . $tmp->id_colonne ; 
	$resultat2 = $bdd->query ($query2);
	while ($tmp2 = $resultat2->fetchObject()) {
		if (isset($array_retour[$i]["ref_interne"])) {$array_retour[$i]["ref_interne"] .= " ".$tmp2->valeur;} else {$array_retour[$i]["ref_interne"] = $tmp2->valeur;}
		$i++;
	}
	unset ($query2, $resultat2, $tmp2);
}
$count_nom_doublon = 0;
$count_nom_vide = 0;
$count_ref_interne_doublon = 0;
foreach ($array_retour as $ret) {
	$find_ref_interne = 0;
	if (!trim($ret["lib_article"])) {
		$count_nom_vide++;
	}	else {
		if (isset($ret["ref_interne"])) {
			$query_where 	= "";
			$query_where 	.= " ( ref_interne = '".addslashes(trim($ret["ref_interne"]))."' && ref_interne != '' )"; 
			
			$query = "SELECT ref_interne 
								FROM articles
								WHERE ".$query_where."
								LIMIT 0,1";
			$resultat = $bdd->query($query);
			if ($fiche = $resultat->fetchObject()) { 
				if (trim($fiche->ref_interne) == trim($ret["ref_interne"])  ) {
				
					if (trim($ret["ref_interne"]) != "") {$count_ref_interne_doublon ++; $find_ref_interne = 1;}
				}
			}
			unset ($query, $resultat, $fiche);
		}
		$libs = explode (" ", trim($ret["lib_article"]));
		
		$query_where 	= "";
		for ($i=0; $i<count($libs); $i++) {
			$lib = trim($libs[$i]);
			$query_where 	.= " lib_article LIKE '%".addslashes($lib)."%' "; 
			if ( isset($libs[$i+1]) ) { $query_where 	.= " && "; }
		}
		$query = "SELECT lib_article
							FROM articles a 
							WHERE ".$query_where."
							LIMIT 0,1";
		$resultat = $bdd->query($query);
		if ($fiche = $resultat->fetchObject()) {
			if (!$find_ref_interne ) {
				$count_nom_doublon ++;
			}
		}
		unset ($query, $resultat, $fiche);
	}
	
}

$total_avert = $count_nom_doublon+$count_ref_interne_doublon;
// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************
include ($DIR."profil_".$_SESSION['profils'][$ID_PROFIL]->getCode_profil()."/modules/".$import_catalogue_csv['folder_name']."themes/".$_SESSION['theme']->getCode_theme()."/page_import_catalogue_csv_step2.inc.php");

?>