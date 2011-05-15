<?php
// *************************************************************************************************************
// AFFICHAGE DES MOUVEMENTS DE STOCK POUR UN ARTICLE
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");

//**************************************
// Controle

//chargmeent des mouvements de stocks
//$stocks_moves =  stock::charger_stocks_moves ($_REQUEST['id_stock']);

if (!isset($_REQUEST['ref_article'])) {
	echo "La référence de l'article n'est pas précisée";
	exit;
}

$article = new article ($_REQUEST['ref_article']);
if (!$article->getRef_article()) {
	echo "La référence de l'article est inconnue";		exit;

}

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

$nb_fiches = 0;

$stocks_moves = array();
if (isset($_REQUEST["id_stock"])) {

	$id_stock = $_REQUEST["id_stock"];
	
	$query_select = "";
	$query_join 	= "";
	$query_where 	= "";
	$query_where2 	= "";
	$query_group	= "";
	$query_limit	= (($search['page_to_show']-1)*$search['fiches_par_page']).", ".$search['fiches_par_page'];
	
	if ($id_stock) {
		if ($query_where) { $query_where .= " &&  "; }
		if (!$query_where) { $query_where .= "WHERE "; }
		$query_where .=  " sm.id_stock = '".$id_stock."' "; 
		
		if ($query_where2) { $query_where2 .= " &&  "; }
		if (!$query_where2) { $query_where2 .= "WHERE "; }
		$query_where2 .=  " sa.id_stock = '".$id_stock."' "; 
		
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
 
if ($article->getRef_article()) {
		if ($query_where) { $query_where .= " &&  "; }
		if (!$query_where) { $query_where .= "WHERE "; }
		$query_where .=  " sm.ref_article = '".$article->getRef_article()."' "; 
		
		if ($query_where2) { $query_where2 .= " &&  "; }
		if (!$query_where2) { $query_where2 .= "WHERE "; }
		$query_where2 .=  " sa.ref_article = '".$article->getRef_article()."' "; 
	}
	
	
	// Sélection des mouvements stocks
	$stocks_moves = array();
	$query = "SELECT sm.ref_stock_move, sm.id_stock, s.lib_stock, s.abrev_stock, sm.qte, sm.date, sm.ref_doc, sm.ref_article, d.id_etat_doc, d.id_type_doc, de.lib_etat_doc,
										a.ref_contact, a.nom,
										c.nom as nom_contact_doc, 
										c.ref_contact as ref_contact_doc
							FROM stocks_moves sm
							LEFT JOIN documents d ON d.ref_doc = sm.ref_doc
							LEFT JOIN stocks s ON s.id_stock = sm.id_stock
							LEFT JOIN documents_etats de ON d.id_etat_doc = de.id_etat_doc
							LEFT JOIN documents_events dev ON d.ref_doc = dev.ref_doc
							LEFT JOIN users u ON u.ref_user = dev.ref_user
							LEFT JOIN annuaire a ON u.ref_contact = a.ref_contact
							LEFT JOIN annuaire c ON c.ref_contact = d.ref_contact
						".$query_where."
						GROUP BY sm.ref_stock_move
						ORDER BY ref_stock_move DESC
						LIMIT ".$query_limit;

	$resultat = $bdd->query ($query);
	while ($var = $resultat->fetchObject()) { $stocks_moves[] = $var; }
	unset ($var, $resultat, $query);
	
	//quantité en stock
	$decompte_stock = 0;
	$query = "SELECT SUM(sa.qte) total_article_en_stock 
						FROM stocks_articles sa
						".$query_where2."
						";
	$resultat = $bdd->query ($query);
	if ($tmp = $resultat->fetchObject()) { $decompte_stock += $tmp->total_article_en_stock;}
	
	// quantité en stock (pagination)
	$end_limit = (($search['page_to_show']-1)*$search['fiches_par_page']);

	$query = "SELECT SUM(sm.qte) as qte
							FROM stocks_moves sm
						".$query_where."
						GROUP BY sm.ref_stock_move
						ORDER BY ref_stock_move DESC
						LIMIT 0, ".$end_limit;


	$resultat = $bdd->query ($query);
	while ($tmp = $resultat->fetchObject()) { $decompte_stock -= $tmp->qte;}
	
	// Comptage des résultats
	$query = "SELECT COUNT(sm.ref_stock_move) nb_fiches
						FROM stocks_moves sm 
						".$query_where;
						
	$resultat = $bdd->query($query); 
	while ($result = $resultat->fetchObject()) { $nb_fiches += $result->nb_fiches; }
	unset ($result, $resultat, $query);
	
	
	//cas spécifique des inventaires
	//si le premier enregistrement des résultats est un inventaires
	if (isset($stocks_moves[0]->id_type_doc) && $stocks_moves[0]->id_type_doc == $INVENTAIRE_ID_TYPE_DOC && isset($stocks_moves[1]->ref_doc) && $stocks_moves[0]->ref_doc != $stocks_moves[1]->ref_doc && (($search['page_to_show']-1)*$search['fiches_par_page']) != 0) {
		// on cherche le mouvement d'inventaire precedent si il existe il remplacera le premier de la liste
		$query = "SELECT sm.ref_stock_move, sm.id_stock, s.lib_stock, s.abrev_stock, sm.qte, sm.date, sm.ref_doc, sm.ref_article, d.id_etat_doc, d.id_type_doc, de.lib_etat_doc,
											a.ref_contact, a.nom,
											c.nom as nom_contact_doc, 
											c.ref_contact as ref_contact_doc
								FROM stocks_moves sm
								LEFT JOIN documents d ON d.ref_doc = sm.ref_doc
								LEFT JOIN stocks s ON s.id_stock = sm.id_stock
								LEFT JOIN documents_etats de ON d.id_etat_doc = de.id_etat_doc
								LEFT JOIN documents_events dev ON d.ref_doc = dev.ref_doc
								LEFT JOIN users u ON u.ref_user = dev.ref_user
								LEFT JOIN annuaire a ON u.ref_contact = a.ref_contact
								LEFT JOIN annuaire c ON c.ref_contact = d.ref_contact
							".$query_where."
							GROUP BY sm.ref_stock_move
							ORDER BY ref_stock_move DESC
							LIMIT ".((($search['page_to_show']-1)*$search['fiches_par_page'])-1).", 1";
	
		$resultat = $bdd->query ($query);
		while ($var = $resultat->fetchObject()) { 
			if ($var->ref_doc == $stocks_moves[0]->ref_doc) {
				// verification pour affichage d'une erreur en cas de différence de stocks sur l'inventaire 
				if (abs($stocks_moves[0]->qte) != abs($var->qte)) {$var_line_inv_errreur = true;}
				//remplacement de la premiere ligne par la ligne d'affichage du stock lors de l'inventaire
				$stocks_moves[0] = $var; 
			}
		}
		
	unset ($var, $resultat, $query);
	}
	//on repete l'opération si un inventaire est le dernier enregistrement de la page
	
	if (isset($stocks_moves[count($stocks_moves)-1]->id_type_doc) && $stocks_moves[count($stocks_moves)-1]->id_type_doc == $INVENTAIRE_ID_TYPE_DOC && isset($stocks_moves[count($stocks_moves)-2]->ref_doc) && $stocks_moves[count($stocks_moves)-1]->ref_doc != $stocks_moves[count($stocks_moves)-2]->ref_doc && ((($search['page_to_show']-1)*$search['fiches_par_page'])+count($stocks_moves)-1) != $nb_fiches) {
		// on cherche le mouvement d'inventaire suivant si il existe et que les qte en stock son différentes on mettra en rouge l'inventaire
		$query = "SELECT sm.ref_stock_move, sm.id_stock, s.lib_stock, s.abrev_stock, sm.qte, sm.date, sm.ref_doc, sm.ref_article, d.id_etat_doc, d.id_type_doc, de.lib_etat_doc,
											a.ref_contact, a.nom,
											c.nom as nom_contact_doc, 
											c.ref_contact as ref_contact_doc
								FROM stocks_moves sm
								LEFT JOIN documents d ON d.ref_doc = sm.ref_doc
								LEFT JOIN stocks s ON s.id_stock = sm.id_stock
								LEFT JOIN documents_etats de ON d.id_etat_doc = de.id_etat_doc
								LEFT JOIN documents_events dev ON d.ref_doc = dev.ref_doc
								LEFT JOIN users u ON u.ref_user = dev.ref_user
								LEFT JOIN annuaire a ON u.ref_contact = a.ref_contact
								LEFT JOIN annuaire c ON c.ref_contact = d.ref_contact
							".$query_where."
							GROUP BY sm.ref_stock_move
							ORDER BY ref_stock_move DESC
							LIMIT ".((($search['page_to_show']-1)*$search['fiches_par_page'])+count($stocks_moves)).", 1";
		$resultat = $bdd->query ($query);
		while ($var = $resultat->fetchObject()) { 
			if ($var->ref_doc == $stocks_moves[count($stocks_moves)-1]->ref_doc) {
				// verification pour affichage d'une erreur en cas de différence de stocks sur l'inventaire 
				if (abs($stocks_moves[count($stocks_moves)-1]->qte) != abs($var->qte)) {$var_line_inv_last_errreur = true;}
				
			}
		}
		
	unset ($var, $resultat, $query);
	}
	
}

// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_catalogue_articles_stocks_moves.inc.php");

?>