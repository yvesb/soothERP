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

$form['fiches_par_page'] = $search['fiches_par_page'] = $STOCK_MOVE_RECHERCHE_SHOWED ;
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
$form['ref_art_categ'] = "";
if (isset($_REQUEST['ref_art_categ'])) {
	$form['ref_art_categ'] = $_REQUEST['ref_art_categ'];
	$search['ref_art_categ'] = $_REQUEST['ref_art_categ'];
}
$form['ref_constructeur'] = "";
if (isset($_REQUEST['ref_constructeur'])) {
	$form['ref_constructeur'] = $_REQUEST['ref_constructeur'];
	$search['ref_constructeur'] = $_REQUEST['ref_constructeur'];
}


$nb_fiches = 0;

$stocks_moves = array();
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
	// Catégorie
	if ($search['ref_art_categ']) { 
		$query_where 	.= " && a.ref_art_categ = '".$search['ref_art_categ']."'";
	}
	// Constructeur
	if ($search['ref_constructeur']) { 
		$query_where 	.= " && a.ref_constructeur = '".$search['ref_constructeur']."'";
	}
	
 
	// Sélection des mouvements stocks
	$stocks_moves = array();
	$query = "SELECT sm.ref_stock_move, sm.id_stock, s.lib_stock, s.abrev_stock, sm.qte, sm.date, sm.ref_doc, sm.ref_article, d.id_etat_doc, d.id_type_doc, de.lib_etat_doc, a.lib_article,
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
						GROUP BY sm.ref_stock_move
						ORDER BY date DESC
						LIMIT ".$query_limit;

	$resultat = $bdd->query ($query);
	while ($var = $resultat->fetchObject()) { $stocks_moves[] = $var; }
	unset ($var, $resultat, $query);
	
	// Comptage des résultats
	$query = "SELECT COUNT(sm.ref_stock_move) nb_fiches
						FROM stocks_moves sm 
							LEFT JOIN articles a ON a.ref_article = sm.ref_article
						".$query_where;
						
	$resultat = $bdd->query($query); 
	while ($result = $resultat->fetchObject()) { $nb_fiches += $result->nb_fiches; }
	unset ($result, $resultat, $query);
}

// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_stocks_moves.inc.php");

?>