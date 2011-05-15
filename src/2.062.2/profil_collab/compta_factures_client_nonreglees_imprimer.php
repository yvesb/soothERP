<?php
// *************************************************************************************************************
// FACTURES CLIENTS NON REGLEES
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");
require ($CONFIG_DIR."profil_".$_SESSION['profils'][$CLIENT_ID_PROFIL]->getCode_profil().".config.php");

ini_set("memory_limit","40M");
if (!$_SESSION['user']->check_permission ("11")) {
	//on indique l'interdiction et on stop le script
	echo "<br /><span style=\"font-weight:bolder;color:#FF0000;\">Vos droits  d'accés ne vous permettent pas de visualiser ce type de page</span>";
	exit();
}
//infos de recherche (pour généraliser l'affichage à l'ensemble des résultats

$form['page_to_show'] = $search['page_to_show'] = 1;

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

$categorie_client_var = "";
$lib_client_categ = "";
$lib_niveau_relance = "";
// chargement de la class du profil
contact::load_profil_class($CLIENT_ID_PROFIL);
$form['fiches_par_page'] = $search['fiches_par_page'] = $nb_fiches;

$niveau_relance_var = "";
//deux cas de figure soit on imprime les résultat (comme sur la page) soit les documents factures
$GLOBALS['PDF_OPTIONS']['HideToolbar'] = 0;
$GLOBALS['PDF_OPTIONS']['AutoPrint'] = 0;

if (isset($_REQUEST["print_fact"])) {
	$pdf = new PDF_etendu ();
	//on liste les documents pour les imprimer
	foreach ($factures as $facture) {
	$GLOBALS['_OPTIONS']['CREATE_DOC']['no_charge_all_sn'] = 1;
		$document = open_doc ($facture->ref_doc);
		// Ajout du document au PDF
		$pdf->add_doc ("", $document);
	}
} else {
	//on affiche les resultats comme sur le listing des factures non réglées
	include_once ($PDF_MODELES_DIR."factures_apayer.class.php");
	$class = "pdf_factures_apayer";
	$pdf = new $class;
        $pdf->create_pdf($factures, $lib_client_categ, $lib_niveau_relance);
}
// Sortie
$pdf->Output();


?>