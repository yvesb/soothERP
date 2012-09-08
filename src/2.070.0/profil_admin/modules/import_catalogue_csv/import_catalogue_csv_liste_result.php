<?php
// *************************************************************************************************************
// IMPORT FICHIER catalogue CSV
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");

// *************************************************
// Données pour le formulaire && la requete
$form['page_to_show'] = $search['page_to_show'] = 1;
if (isset($_REQUEST['page_to_show'])) {
	$form['page_to_show'] = $_REQUEST['page_to_show'];
	$search['page_to_show'] = $_REQUEST['page_to_show'];
}
$form['fiches_par_page'] = $search['fiches_par_page'] = $CATALOGUE_RECHERCHE_SHOWED_FICHES;
if (isset($_REQUEST['fiches_par_page'])) {
	$form['fiches_par_page'] = $_REQUEST['fiches_par_page'];
	$search['fiches_par_page'] = $_REQUEST['fiches_par_page'];
}
$form['orderby'] = $search['orderby'] = "lib_article";
if (isset($_REQUEST['orderby'])) {
	$form['orderby'] = $_REQUEST['orderby'];
	$search['orderby'] = $_REQUEST['orderby'];
}
$form['orderorder'] = $search['orderorder'] = "ASC";
if (isset($_REQUEST['orderorder'])) {
	$form['orderorder'] = $_REQUEST['orderorder'];
	$search['orderorder'] = $_REQUEST['orderorder'];
}
$nb_fiches = 0;

$form['lib_article'] = "";
if (isset($_REQUEST['lib_article'])) {
	$form['lib_article'] = trim(urldecode($_REQUEST['lib_article']));
	$search['lib_article'] = trim(urldecode($_REQUEST['lib_article']));
}
$form['civilite'] = "";
if (isset($_REQUEST['civilite'])) {
	$form['civilite'] = trim(urldecode($_REQUEST['civilite']));
	$search['civilite'] = trim(urldecode($_REQUEST['civilite']));
}
$form['ref_art_categ'] = 0;
if (isset($_REQUEST['ref_art_categ'])) {
	$form['ref_art_categ'] = $_REQUEST['ref_art_categ'];
	$search['ref_art_categ'] = $_REQUEST['ref_art_categ'];
}


$import_catalogue = new import_catalogue_csv(); 

$dao_csv_import_catalogue_ligne = new import_catalogue_csv_ligne();
$lignes = $dao_csv_import_catalogue_ligne->readAll();

$query = "SELECT id_colonne, champ_equivalent FROM csv_import_catalogue_cols WHERE champ_equivalent != ''";
$resultat = $bdd->query ($query);
$array_retour = array();
while ($tmp = $resultat->fetchObject()) {
	$i=0;
	$query2 = "SELECT valeur  FROM csv_import_catalogue_lines WHERE id_colonne = " . $tmp->id_colonne ; 
	$resultat2 = $bdd->query ($query2);
	while ($tmp2 = $resultat2->fetchObject()) {
		if (isset($array_retour[$i][$tmp->champ_equivalent])) {
			if ($tmp->champ_equivalent == "lib_article") {
				$array_retour[$i][$tmp->champ_equivalent] .= " ".$tmp2->valeur;
			} else {
				$array_retour[$i][$tmp->champ_equivalent] .= "\n".$tmp2->valeur;
			}
		} else {
			$array_retour[$i][$tmp->champ_equivalent] = $tmp2->valeur;
		}
		$i++;
	}
	unset ($query2, $resultat2, $tmp2);
}


for($j=0; $j < count($array_retour); $j++) {

	if (!trim($array_retour[$j]["lib_article"])) {
		$array_retour[$j]["alerte"] = "lib_article";
	}	else {
		
		if (isset($array_retour[$j]["ref_interne"]) && $array_retour[$j]["ref_interne"]) {
			$query_where 	= "";
			$query_where 	.= " (ref_interne = '".addslashes(trim($array_retour[$j]["ref_interne"]))."' &&  ref_interne != '' ) "; 
			
			$query = "SELECT ref_interne
								FROM  articles 
								WHERE ".$query_where."
								LIMIT 0,1";
			$resultat = $bdd->query($query);
			if ($fiche = $resultat->fetchObject()) { 
				if (trim($fiche->ref_interne) == trim($array_retour[$j]["ref_interne"])  ) {
					if ($array_retour[$j]["ref_interne"] != "") {$array_retour[$j]["averti"] = "ref_interne";}
				}
			}
			unset ($query, $resultat, $fiche);
		}
		$libs = explode (" ", trim($array_retour[$j]["lib_article"]));
		
		$query_where 	= "";
		for ($i=0; $i<count($libs); $i++) {
			$lib = trim($libs[$i]);
			$query_where 	.= " lib_article LIKE '%".addslashes($lib)."%' "; 
			if ( isset($libs[$i+1]) ) { $query_where 	.= " && "; }
		}
		$query = "SELECT a.ref_article, lib_article
							FROM articles a 
							WHERE ".$query_where."
							LIMIT 0,1";
		$resultat = $bdd->query($query);
		if ($fiche = $resultat->fetchObject()) { 
			if (!isset($array_retour[$j]["averti"])) {
				$array_retour[$j]["averti"] = "lib_article";
			}
		}
		
		unset ($query, $resultat, $fiche);
	}
	
}
$nb_affiche = $form['fiches_par_page'];
$nb_fiches = count($array_retour);
if ( ( ( ($form['page_to_show']-1)*$form['fiches_par_page']) +$form['fiches_par_page']) > $nb_fiches) {$nb_affiche = $nb_fiches-( ($form['page_to_show']-1)*$form['fiches_par_page']);}

// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************
include ($DIR."profil_".$_SESSION['profils'][$ID_PROFIL]->getCode_profil()."/modules/".$import_catalogue_csv['folder_name']."themes/".$_SESSION['theme']->getCode_theme()."/page_import_catalogue_csv_liste_result.inc.php");

?>

