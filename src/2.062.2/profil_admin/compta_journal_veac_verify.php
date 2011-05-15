<?php
// ***********************************************************************************************************
// journal des achats
// ***********************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");


$compta_e = new compta_exercices ();
$liste_exercices	= $compta_e->charger_compta_exercices();
//on récupère la dte du dernier exercice cloturé
foreach ($liste_exercices as $exercice) {
	if (!$exercice->etat_exercice) {$last_date_before_cloture = $exercice->date_fin; break;}
}

// *************************************************
// Données pour le formulaire && la requete
$form['page_to_show'] = $search['page_to_show'] = 1;
if (isset($_REQUEST['page_to_show'])) {
	$form['page_to_show'] = $_REQUEST['page_to_show'];
	$search['page_to_show'] = $_REQUEST['page_to_show'];
}
$form['fiches_par_page'] = $search['fiches_par_page'] = $COMPTA_EXTRAIT_COMPTE_SHOWED_FICHES;
if (isset($_REQUEST['fiches_par_page'])) {
	$form['fiches_par_page'] = $_REQUEST['fiches_par_page'];
	$search['fiches_par_page'] = $_REQUEST['fiches_par_page'];
}

$nb_fiches = 0;


$form['ref_contact'] = "" ;
$search['ref_contact'] = "";
if (isset($_REQUEST['ref_contact']) && $_REQUEST['ref_contact'] != "") {
	$form['ref_contact'] = $_REQUEST['ref_contact'];
	$search['ref_contact'] = $_REQUEST['ref_contact'];
}

$form['date_debut'] = "" ;
if (isset($_REQUEST['date_debut'])) {
	$form['date_debut'] = $_REQUEST['date_debut'];
	$search['date_debut'] = $_REQUEST['date_debut'];
}

$form['date_fin'] = "" ;
if (isset($_REQUEST['date_fin'])) {
	$form['date_fin'] = $_REQUEST['date_fin'];
	$search['date_fin'] = $_REQUEST['date_fin'];
}
$form['date_exercice"'] = "" ;
if (isset($_REQUEST['date_exercice']) && ($form['date_fin'] == "" && $form['date_debut'] == "")) {
	$form['date_exercice'] = explode(";",$_REQUEST['date_exercice']);
	$search['date_exercice'] = explode(";",$_REQUEST['date_exercice']);
	$search['date_debut'] = date_Us_to_Fr($search['date_exercice'][0]);
	$search['date_fin'] = date_Us_to_Fr($search['date_exercice'][1]);
}


// *************************************************
// Résultat de la recherche
$fiches = array();
if (isset($_REQUEST['recherche'])) {
	// Préparation de la requete
	$query_join 	= "";
	$query_where 	= "";
	$query_group	= "";
	
	$query_limit	= "";
	if (!isset($_REQUEST["print"])) {
		$query_limit	= "LIMIT ".(($search['page_to_show']-1)*$search['fiches_par_page']).", ".$search['fiches_par_page'];
	}
	
	
	$count_modes = 0;
	
	if ($search['ref_contact']) {
		if ($query_where) { $query_where .= " &&  "; }
		$query_where .=  " d.ref_contact = '".$search['ref_contact']."' "; 
	}
	if ($search['date_debut']) {
		if ($query_where) { $query_where .= " &&  "; }
		$query_where .=  " d.date_creation_doc >= '".date_Fr_to_Us($search['date_debut'])." 00:00:00' "; 
	}
	if ($search['date_fin']) {
		if ($query_where) { $query_where .= " &&  "; }
		$query_where .=  " d.date_creation_doc <= '".date_Fr_to_Us($search['date_fin'])." 23:59:59' "; 
	}
	

$nb_doc_aff = 0;

 
 //recherche des documents
 $queryd = "SELECT d.ref_doc 
						FROM documents d
						WHERE ".$query_where." && ( ( id_type_doc ='4' && (id_etat_doc = '18' || id_etat_doc = '19')) || ( id_type_doc ='8' && (id_etat_doc = '34' || id_etat_doc = '35')))
						".$query_limit;
	$resultatd = $bdd->query($queryd);
	
	while ($doc = $resultatd->fetchObject()) {
		 $document = open_doc ($doc->ref_doc);
		 $document->check_ventilation_facture ();
		$nb_doc_aff ++;
	}
	unset ($queryd, $resultatd, $doc);
	//total des résultats
 $queryd = "SELECT d.ref_doc 
						FROM documents d
						WHERE ".$query_where." && ( ( id_type_doc ='4' && (id_etat_doc = '18' || id_etat_doc = '19')) || ( id_type_doc ='8' && (id_etat_doc = '34' || id_etat_doc = '35')))
						";
	$resultatd = $bdd->query($queryd);
	while ($doc = $resultatd->fetchObject()) {
		$nb_fiches++;
	}
	unset ($queryd, $resultatd, $doc);
}
// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

	//affichage des résultats dans lmb
	include ($DIR.$_SESSION['theme']->getDir_theme()."page_compta_journal_veac_verify.inc.php");

?>