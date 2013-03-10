<?php
// *************************************************************************************************************
// IMPORT FICHIER tarifs_fournisseur CSV
// *************************************************************************************************************
$tarifs_fournisseur_RECHERCHE_SHOWED_FICHES = 50;

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
$form['fiches_par_page'] = $search['fiches_par_page'] = $tarifs_fournisseur_RECHERCHE_SHOWED_FICHES;
if (isset($_REQUEST['fiches_par_page'])) {
	$form['fiches_par_page'] = $_REQUEST['fiches_par_page'];
	$search['fiches_par_page'] = $_REQUEST['fiches_par_page'];
}
$form['orderby'] = $search['orderby'] = "ref_article";
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

$import_tarifs_fournisseur = new import_tarifs_fournisseur_csv();
$array_retour = $import_tarifs_fournisseur->recupererDonneesAImporter();

foreach($array_retour as $k => $ret) {
	if(!trim($ret["pa_ht"])){
		$array_retour[$k]["alerte"] = "pa_ht";
	}
}

$nb_affiche = $form['fiches_par_page'];
$nb_fiches = count($array_retour);
if(((($form['page_to_show']-1)*$form['fiches_par_page']) +$form['fiches_par_page']) > $nb_fiches) {
	$nb_affiche = $nb_fiches-(($form['page_to_show']-1)*$form['fiches_par_page']);
}

// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************
include ($DIR.$_SESSION['theme']->getDir_theme()."/page_import_tarifs_fournisseur_csv_liste_result.inc.php");
?>