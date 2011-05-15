<?php
// *************************************************************************************************************
// RECHERCHE DES OPERATION D'UN COMPTE BANCAIRE
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");


//chargement des comptes bancaires
$compte_bancaire	= new compte_bancaire($_REQUEST["id_compte_bancaire"]);


// *************************************************
// Données pour le formulaire && la requete
$form['page_to_show'] = $search['page_to_show'] = 1;
if (isset($_REQUEST['page_to_show'])) {
	$form['page_to_show'] = $_REQUEST['page_to_show'];
	$search['page_to_show'] = $_REQUEST['page_to_show'];
}
$form['fiches_par_page'] = $search['fiches_par_page'] = $COMPTE_OPERATIONS_RECHERCHE_SHOWED_FICHES;
if (isset($_REQUEST['fiches_par_page'])) {
	$form['fiches_par_page'] = $_REQUEST['fiches_par_page'];
	$search['fiches_par_page'] = $_REQUEST['fiches_par_page'];
}

$form['orderby'] = $search['orderby'] = "date_move";
if (isset($_REQUEST['orderby'])) {
	$form['orderby'] = $_REQUEST['orderby'];
	$search['orderby'] = $_REQUEST['orderby'];
}

$form['orderorder'] = $search['orderorder'] = "DESC";
if (isset($_REQUEST['orderorder'])) {
	$form['orderorder'] = $_REQUEST['orderorder'];
	$search['orderorder'] = $_REQUEST['orderorder'];
}

$form['id_compte_bancaire'] = $search['id_compte_bancaire'] = "";
if (isset($_REQUEST['id_compte_bancaire']) && $_REQUEST['id_compte_bancaire'] != "") {
	$form['id_compte_bancaire'] = $_REQUEST['id_compte_bancaire'];
	$search['id_compte_bancaire'] = $_REQUEST['id_compte_bancaire'];
}

$form['date_fin'] = $search['date_fin'] = 0;
if (isset($_REQUEST['date_fin']) && $_REQUEST['date_fin'] != "") {
	$form['date_fin'] = date_Fr_to_Us($_REQUEST['date_fin'])." 23:59:59";
	$search['date_fin'] = date_Fr_to_Us($_REQUEST['date_fin'])." 23:59:59";
}

$form['date_debut'] = $search['date_debut'] = 0;
if (isset($_REQUEST['date_debut']) && $_REQUEST['date_debut'] != "") {
	$form['date_debut'] = date_Fr_to_Us($_REQUEST['date_debut']);
	$search['date_debut'] = date_Fr_to_Us($_REQUEST['date_debut']);
}

$form['libelle'] = $search['libelle'] = "";
if (isset($_REQUEST['libelle']) && $_REQUEST['libelle'] != "") {
	$form['libelle'] = trim(urldecode($_REQUEST['libelle']));
	$search['libelle'] = trim(urldecode($_REQUEST['libelle']));
}
$form['montant'] = $search['montant'] = 0;
if (isset($_REQUEST['montant']) && $_REQUEST['montant'] != "") {
	$form['montant'] = abs(convert_numeric(str_replace(" ","",$_REQUEST['montant'])));
	$search['montant'] = abs(convert_numeric(str_replace(" ","",$_REQUEST['montant'])));
}
$form['delta_montant'] = $search['delta_montant'] = 0;
if (isset($_REQUEST['delta_montant']) && $_REQUEST['delta_montant'] != "") {
	$form['delta_montant'] = abs(convert_numeric($_REQUEST['delta_montant']));
	$search['delta_montant'] = abs(convert_numeric($_REQUEST['delta_montant']));
}
$form['ope_type'] = $search['ope_type'] = 0;
if (isset($_REQUEST['ope_type']) && $_REQUEST['ope_type'] != "0") {
	if ($_REQUEST['ope_type'] != "1") {
		$form['ope_type'] = ">";
		$search['ope_type'] = ">";
	}
	if ($_REQUEST['ope_type'] != "2") {
		$form['ope_type'] = "<";
		$search['ope_type'] = "<";
	}
}
$nb_fiches = 0;

// *************************************************
// Résultat de la recherche
$fiches = array();
if (isset($_REQUEST['recherche'])) {
	// Préparation de la requete
	$query_join 	= "";
	$query_having = "";
	$query_where 	= "";
	
	if ($search['id_compte_bancaire']) {
		if ($query_where) { $query_where .= " && "; }
		$query_where 	.= " id_compte_bancaire = '".$search["id_compte_bancaire"]."' ";
	}
	
	if ($search['date_fin']) {
		if ($query_where) { $query_where .= " && "; }
		$query_where 	.= " date_move < '".$search['date_fin']."' ";
	}
	if ($search['date_debut']) {
		if ($query_where) { $query_where .= " && "; }
		$query_where 	.= " date_move > '".$search['date_debut']."' ";
	}
	
	if ($search['libelle']) {
		$libs = explode (" ", $search['libelle']);
		if ($query_where) { $query_where .= " && "; }
		$query_where 	.= " ( ";
		for ($i=0; $i<count($libs); $i++) {
			$lib = trim($libs[$i]);
			$query_where 	.= " lib_move LIKE '%".addslashes($lib)."%' "; 
			if ( isset($libs[$i+1]) ) { $query_where 	.= " && "; }
		}
		$query_where 	.= " ) ";
	}
	
	if ($search['montant']) {
		if ($query_where) { $query_where .= " && "; }
		$query_where .= "   ( ABS(montant_move) <= '".($search['montant']+$search['delta_montant'])."' &&
															 ABS(montant_move) >= '".($search['montant']-$search['delta_montant'])."' )";
	}
	
	if ($search['ope_type']) {
		if ($query_where) { $query_where .= " && "; }
		$query_where .= "   (montant_move ".$search['ope_type']."= '0'  )";
	}
															
	$query_limit	= (($search['page_to_show']-1)*$search['fiches_par_page']).", ".$search['fiches_par_page'];



	// Recherche
	$query = "SELECT id_compte_bancaire_move, id_compte_bancaire, date_move,
									 lib_move, montant_move, commentaire_move
						FROM comptes_bancaires_moves
							".$query_join."
						WHERE ".$query_where." 
						ORDER BY ".$search['orderby']." ".$search['orderorder']." 
						LIMIT ".$query_limit;
	$resultat = $bdd->query($query);
	while ($fiche = $resultat->fetchObject()) { $fiches[] = $fiche; }
	//echo nl2br ($query);
	unset ($fiche, $resultat, $query);
	
	
	// Comptage des résultats
	$query = "SELECT COUNT(id_compte_bancaire_move) nb_fiches
						FROM comptes_bancaires_moves 
							".$query_join."
						WHERE ".$query_where." ";
	$resultat = $bdd->query($query);
	while ($result = $resultat->fetchObject()) { $nb_fiches += $result->nb_fiches; }
	//echo "<br><hr>".nl2br ($query);
	unset ($result, $resultat, $query);
	
	$report_solde = 0;
	
}


// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_compta_compte_bancaire_recherche_result.inc.php");

?>