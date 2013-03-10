<?php
// *************************************************************************************************************
// [ADMINISTRATEUR] RECHERCHE D'UN COURRIER
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");

// *************************************************************************************************************
// TRAITEMENTS
// *************************************************************************************************************

	// *************************************************
// Profils à afficher
$profils = array();
foreach ($_SESSION['profils'] as $profil) {
	if ($profil->getActif() != 1) { continue; }
	$profils[] = $profil;
}
unset ($profil);


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
$form['orderby'] = $search['orderby'] = "etat";
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

$form['etat'] = "";
if (isset($_REQUEST['etat'])) {
	$form['etat'] = trim(urldecode($_REQUEST['etat']));
	$search['etat'] = trim(urldecode($_REQUEST['etat']));
}
$form['contact'] = "";
if (isset($_REQUEST['contact'])) {
	$form['contact'] = trim(urldecode($_REQUEST['contact']));
	$search['contact'] = trim(urldecode($_REQUEST['contact']));
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

$form['id_profil'] = 0;
if (isset($_REQUEST['id_profil'])) {
	$form['id_profil'] = $_REQUEST['id_profil'];
	$search['id_profil'] = $_REQUEST['id_profil'];
}


// *************************************************
// Résultat de la recherche
$fiches = array();
if (isset($_REQUEST['recherche'])) {
	// Préparation de la requete
	$query_join 	= "";
	$query_where 	= " 1";
	$query_group 	= "";
	$query_limit	= (($search['page_to_show']-1)*$search['fiches_par_page']).", ".$search['fiches_par_page'];

	
	// ETAT
	if ($search['etat']) {
		$query_where .= " && c.id_etat_courrier = ".$search['etat']." ";
	}
	
	// DATE
	if ($search['date_debut']) {
		if ($query_where) { $query_where .= " &&  "; }
		$query_where .=  "&& c.date_courrier > '".date_Fr_to_Us($search['date_debut'])." 00:00:00' "; 
	}
	if ($search['date_fin']) {
		if ($query_where) { $query_where .= " &&  "; }
		$query_where .=  "&& c.date_courrier <= '".date_Fr_to_Us($search['date_fin'])." 23:59:59' "; 
	}
	
	// CONTACT
	if ($search['contact']) {
		$libs = explode (" ", $search['contact']);
		if ($query_where) { $query_where .= " && "; }
		$query_where 	.= " ( ";
		for ($i=0; $i<count($libs); $i++) {
			$lib = trim($libs[$i]);
			
			$query_where 	.= " a.nom LIKE '%".addslashes($lib)."%' ";
			
			
			if ( isset($libs[$i+1]) ) { $query_where 	.= " && "; }
		}
		$query_where 	.= " ) ";
		$query_join 	.= " LEFT JOIN courriers_destinataires cd ON cd.id_courrier = c.id_courrier ";
		$query_join 	.= " LEFT JOIN courriers_events ce ON ce.id_courrier = c.id_courrier ";
		$query_join		.= " LEFT JOIN annuaire a ON a.ref_contact = cd.ref_destinataire";
		$query_join 	.= " LEFT JOIN users u ON u.ref_user = ce.ref_user ";
		
		$query_group 	.= " GROUP BY ( c.id_courrier )";

		
	}


	// Recherche
	$query = "SELECT * FROM courriers c 
							".$query_join."
						WHERE ".$query_where
						.$query_group."
						ORDER BY c.id_courrier
						LIMIT ".$query_limit;
	
	
	$resultat = $bdd->query($query);
	while ($fiche = $resultat->fetchObject()) { $fiches[] = $fiche; }
	//echo nl2br ($query);
	unset ($fiche, $resultat, $query);
	
	$nb_fiches = count($fiches);
}


// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_courrier_recherche_result.inc.php");

?>