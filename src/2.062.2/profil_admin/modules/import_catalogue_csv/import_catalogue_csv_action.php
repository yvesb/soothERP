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
$form['orderby'] = $search['orderby'] = "nom";
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

$query = "SELECT id_colonne, champ_equivalent FROM csv_import_catalogue_cols ";
$resultat = $bdd->query ($query);
$array_retour = array();
while ($tmp = $resultat->fetchObject()) {
	$i=0;
	$query2 = "SELECT id_ligne  FROM csv_import_catalogue_lines WHERE id_colonne = " . $tmp->id_colonne ; 
	$resultat2 = $bdd->query ($query2);
	while ($tmp2 = $resultat2->fetchObject()) {
		$array_retour[$i][$tmp->id_colonne] = $tmp2->id_ligne;
		$i++;
	}
	unset ($query2, $resultat2, $tmp2);
}


//traitement de la liste des infos sélectionnées
$liste_rec = array();
foreach ($_REQUEST as $key=>$value) {
	if (substr_count($key, "id_rec")) {$liste_rec[] = $value;}
}


$liste_ligne = array();
// 
for($j=0; $j < count($array_retour); $j++) {
	if (in_array($j, $liste_rec)) {
		switch ($_REQUEST["fonction_generer"]) {
			case "supprimer":
				foreach ($array_retour[$j] as $id_ligne) {
					$liste_ligne[] = $id_ligne;
				}
			break;			
			
			case "import":
				foreach ($array_retour[$j] as $id_ligne) {
					$liste_ligne[] = $id_ligne;
				}
			break;
		}
	}

}
switch ($_REQUEST["fonction_generer"]) {
	case "supprimer":
		$dao_csv_import_catalogue_ligne->supprimer($liste_ligne);
	break;
	case "import":
		$import_catalogue->create($liste_ligne, "import_cop.csv");
	break;
}

// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************
include ($DIR."profil_".$_SESSION['profils'][$ID_PROFIL]->getCode_profil()."/modules/".$import_catalogue_csv['folder_name']."themes/".$_SESSION['theme']->getCode_theme()."/page_import_catalogue_csv_action.inc.php");

?>

