<?php
// *************************************************************************************************************
// RECHERCHE DES EVENEMENTS DES CONTACTS
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");



// *************************************************************************************************************
// TRAITEMENTS
// *************************************************************************************************************



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
$form['orderby'] = $search['orderby'] = "date_event";
if (isset($_REQUEST['orderby'])) {
	$form['orderby'] = $_REQUEST['orderby'];
	$search['orderby'] = $_REQUEST['orderby'];
}
$form['orderorder'] = $search['orderorder'] = "DESC";
if (isset($_REQUEST['orderorder'])) {
	$form['orderorder'] = $_REQUEST['orderorder'];
	$search['orderorder'] = $_REQUEST['orderorder'];
}
$nb_fiches = 0;

$form['id_comm_event_type'] = "";
if (isset($_REQUEST['id_comm_event_type']) && $_REQUEST['id_comm_event_type']) {
	$form['id_comm_event_type'] = trim(urldecode($_REQUEST['id_comm_event_type']));
	$search['id_comm_event_type'] = trim(urldecode($_REQUEST['id_comm_event_type']));
}


// *************************************************
// Résultat de la recherche
$fiches = array();
if (isset($_REQUEST['recherche'])) {
	// Préparation de la requete
	$query_join 	= "";
	$query_where 	= "";
	$query_limit	= (($search['page_to_show']-1)*$search['fiches_par_page']).", ".$search['fiches_par_page'];

	
	// Profils
	if (isset($search['id_comm_event_type'])) { 
		if ($query_where) { $query_where .= " && "; }
		if (!$query_where) { $query_where .= " WHERE "; }
		$query_where 	.= "ce.id_comm_event_type = '".$search['id_comm_event_type']."'";
	}


	// Recherche
	$query = "SELECT ce.id_comm_event, ce.date_event, ce.duree_event, ce.ref_user, ce.ref_contact, ce.id_comm_event_type, ce.texte, ce.date_rappel,
									 u.pseudo,
									 a.nom,
									 cet.lib_comm_event_type
						FROM comm_events ce 
							LEFT JOIN users u ON ce.ref_user = u.ref_user
							LEFT JOIN annuaire a ON ce.ref_contact = a.ref_contact
							LEFT JOIN comm_events_types cet ON ce.id_comm_event_type = cet.id_comm_event_type
							".$query_join."
						 ".$query_where." 
						ORDER BY ".$search['orderby']." ".$search['orderorder']."
						LIMIT ".$query_limit;
						
	$resultat = $bdd->query($query);
	while ($fiche = $resultat->fetchObject()) { $fiches[] = $fiche; }
	//echo nl2br ($query);
	unset ($fiche, $resultat, $query);
	
	// Comptage des résultats
	$query = "SELECT COUNT(ce.id_comm_event) nb_fiches
						FROM comm_events ce 
							".$query_join."
							".$query_where."
						GROUP BY ce.id_comm_event";
	$resultat = $bdd->query($query);
	while ($result = $resultat->fetchObject()) { $nb_fiches += $result->nb_fiches; }
	//echo "<br><hr>".nl2br ($query);
	unset ($result, $resultat, $query);
}

// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_evenements_recherche_result.inc.php");

?>