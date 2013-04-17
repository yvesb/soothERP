<?php
// *************************************************************************************************************
// IMPORT TARIFS FOURNISSEUR CSV
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
$form['fiches_par_page'] = $search['fiches_par_page'] = $ANNUAIRE_RECHERCHE_SHOWED_FICHES;
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

// Traitement de la liste des infos sélectionnées
$liste_rec = array();
foreach ($_REQUEST as $key=>$value) {
	if (substr_count($key, "id_rec")) {
		$liste_rec[] = $value;
	}
}

$import_tarfis_fournisseur = new import_tarifs_fournisseur_csv();

switch ($_REQUEST["fonction_generer"]) {
	case "supprimer":
		$import_tarfis_fournisseur->delete_lines($liste_rec);
	break;
	case "import":
		$import_tarfis_fournisseur->create($liste_rec);
	break;
}

// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************
include ($DIR.$_SESSION['theme']->getDir_theme()."/page_import_tarifs_fournisseur_csv_action.inc.php");
?>