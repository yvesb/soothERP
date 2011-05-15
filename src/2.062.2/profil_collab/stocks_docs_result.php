<?php
// *************************************************************************************************************
// AFFICHAGE DES MOUVEMENTS DE STOCK
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");

//**************************************
// Controle



$form['page_to_show'] = $search['page_to_show'] = 1;
if (isset($_REQUEST['page_to_show'])) {
	$form['page_to_show'] = $_REQUEST['page_to_show'];
	$search['page_to_show'] = $_REQUEST['page_to_show'];
}

$form['fiches_par_page'] = $search['fiches_par_page'] = $DOCUMENT_RECHERCHE_SHOWED_FICHES ;
if (isset($_REQUEST['fiches_par_page'])) {
	$form['fiches_par_page'] = $_REQUEST['fiches_par_page'];
	$search['fiches_par_page'] = $_REQUEST['fiches_par_page'];
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
$form['id_type_doc'] = $search['id_type_doc'] = 0;
if (isset($_REQUEST['id_type_doc'])) {
	$form['id_type_doc'] = $_REQUEST['id_type_doc'];
	$search['id_type_doc'] = $_REQUEST['id_type_doc'];
}
$form['id_etat_doc'] = $search['id_etat_doc'] = 0;
if (isset($_REQUEST['id_etat_doc'])) {
	$form['id_etat_doc'] = $_REQUEST['id_etat_doc'];
	$search['id_etat_doc'] = $_REQUEST['id_etat_doc'];
}


$nb_fiches = 0;

$stocks_docs = array();
if (isset($_REQUEST["id_stock"])) {

	$id_stock = $_REQUEST["id_stock"];
	
	$query_select = "";
	$query_join 	= "";
	$query_where 	= "";
	$query_group	= "";
	$query_limit	= (($search['page_to_show']-1)*$search['fiches_par_page']).", ".$search['fiches_par_page'];
	
	if ($id_stock) {
		if ($query_where) { $query_where .= " &&  "; }
		if (!$query_where) { $query_where .= "WHERE "; }
		$query_where .=  " sm.id_stock = '".$id_stock."' "; 
	}
	if ($search['date_debut']) {
		if ($query_where) { $query_where .= " &&  "; }
		if (!$query_where) { $query_where .= "WHERE "; }
		$query_where .=  " sm.date > '".date_Fr_to_Us($search['date_debut'])." 00:00:00' "; 
	}
	if ($search['date_fin']) {
		if ($query_where) { $query_where .= " &&  "; }
		if (!$query_where) { $query_where .= "WHERE "; }
		$query_where .=  " sm.date <= '".date_Fr_to_Us($search['date_fin'])." 23:59:59' "; 
	}
	// Type de document
	if ($search['id_type_doc']) { 
		if ($query_where) { $query_where .= " &&  "; }
		if (!$query_where) { $query_where .= "WHERE "; }
		$query_where 	.= " d.id_type_doc = '".$search['id_type_doc']."'";
	}
	// Etat du document
	if ($search['id_etat_doc']) { 
		if ($query_where) { $query_where .= " &&  "; }
		if (!$query_where) { $query_where .= "WHERE "; }
		$query_where 	.= " d.id_etat_doc IN (".$search['id_etat_doc']." )";
	}
 
	// Sélection des mouvements stocks
	$stocks_docs = array();
	$query = "SELECT sm.ref_stock_move, sm.id_stock, s.lib_stock, s.abrev_stock, sm.qte, sm.date, sm.ref_doc, sm.ref_article, d.id_etat_doc, d.id_type_doc, de.lib_etat_doc, a.lib_article, a.ref_art_categ, a.ref_constructeur,
										an.ref_contact, an.nom
						FROM stocks_moves sm
							LEFT JOIN documents d ON d.ref_doc = sm.ref_doc
							LEFT JOIN stocks s ON s.id_stock = sm.id_stock
							LEFT JOIN documents_etats de ON d.id_etat_doc = de.id_etat_doc
							LEFT JOIN articles a ON a.ref_article = sm.ref_article
							LEFT JOIN documents_events dev ON d.ref_doc = dev.ref_doc
							LEFT JOIN users u ON u.ref_user = dev.ref_user
							LEFT JOIN annuaire an ON u.ref_contact = an.ref_contact
						".$query_where." 
						GROUP BY sm.ref_doc
						ORDER BY date DESC
						LIMIT ".$query_limit;

	$resultat = $bdd->query ($query);
	while ($var = $resultat->fetchObject()) { $stocks_docs[] = $var; }
	unset ($var, $resultat, $query);
	
	// Comptage des résultats
	$query = "SELECT COUNT(sm.ref_doc) as  nb_fiches
						FROM stocks_moves sm 
							LEFT JOIN documents d ON d.ref_doc = sm.ref_doc
						".$query_where."
						
						GROUP BY sm.ref_doc";
						
	$resultat = $bdd->query($query); 
	while ($result = $resultat->fetchObject()) { $nb_fiches ++; }
	unset ($result, $resultat, $query);
}

// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_stocks_docs_result.inc.php");

?>