<?php
// *************************************************************************************************************
// FACTURES fournisseurS NON REGLEES
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");
require ($CONFIG_DIR."profil_".$_SESSION['profils'][$FOURNISSEUR_ID_PROFIL]->getCode_profil().".config.php");

if (!$_SESSION['user']->check_permission ("12")) {
	//on indique l'interdiction et on stop le script
	echo "<br /><span style=\"font-weight:bolder;color:#FF0000;\">Vos droits  d'accés ne vous permettent pas de visualiser ce type de page</span>";
	exit();
}
//infos de recherche 

$form['page_to_show'] = $search['page_to_show'] = 1;
if (isset($_REQUEST['page_to_show'])) {
	$form['page_to_show'] = $_REQUEST['page_to_show'];
	$search['page_to_show'] = $_REQUEST['page_to_show'];
}
$form['fiches_par_page'] = $search['fiches_par_page'] = $COMPTA_FACTURE_TOPAY_SHOWED_FICHES;
if (isset($_REQUEST['fiches_par_page'])) {
	$form['fiches_par_page'] = $_REQUEST['fiches_par_page'];
	$search['fiches_par_page'] = $_REQUEST['fiches_par_page'];
}
$form['orderby'] = $search['orderby'] = "date_creation";
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
//fin infos

// chargement de la class du profil
contact::load_profil_class($FOURNISSEUR_ID_PROFIL);
// Préparations des variables d'affichage
$liste_categories_fournisseur = contact_fournisseur::charger_fournisseurs_categories ();
foreach ($liste_categories_fournisseur as $categorie_fournisseur) {
	$categorie_fournisseur->count_fact = count_niveau_factures_fournisseur_to_pay($categorie_fournisseur->id_fournisseur_categ);
}

$categorie_fournisseur_var = $DEFAUT_ID_FOURNISSEUR_CATEG;

$nb_faf_non_attrib =  count_niveau_factures_fournisseur_to_pay();
if (!$nb_fiches) {
 $nb_fiches = count_niveau_factures_fournisseur_to_pay($categorie_fournisseur_var);
}

//chargement des factures de $DEFAUT_ID_fournisseur_CATEG
$factures = array();
$factures = get_factures_fournisseur_to_pay ($categorie_fournisseur_var);
$factures_total = get_factures_fournisseur_to_pay_total ($categorie_fournisseur_var);


// *************************************************************************************************************
// AFFICHAGE
// -*************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_compta_factures_fournisseur_nonreglees.inc.php");

?>