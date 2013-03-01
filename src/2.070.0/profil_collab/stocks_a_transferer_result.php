<?php
// *************************************************************************************************************
// RECHERCHE DES ARTICLES POUR TRANSFERT D'ARTICLES
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
$form['fiches_par_page'] = $search['fiches_par_page'] = $CATALOGUE_RECHERCHE_SHOWED_FICHES;
if (isset($_REQUEST['fiches_par_page'])) {
	$form['fiches_par_page'] = $_REQUEST['fiches_par_page'];
	$search['fiches_par_page'] = $_REQUEST['fiches_par_page'];
}
$form['orderby'] = $search['orderby'] = "lib_article";
if (isset($_REQUEST['orderby'])) {
	$form['orderby'] = $_REQUEST['orderby'];
	$search['orderby'] = $_REQUEST['orderby'];
}
$form['orderorder'] = $search['orderorder'] = "ASC";
if (isset($_REQUEST['orderorder'])) {
	$form['orderorder'] = $_REQUEST['orderorder'];
	$search['orderorder'] = $_REQUEST['orderorder'];
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




// *************************************************
// Stock de départ
$form['stock_depart'] = "";
if (isset($_REQUEST['stock_depart'])) {
	$form['stock_depart'] = $_REQUEST['stock_depart'];
	$search['stock_depart'] = $_REQUEST['stock_depart'];
}
// *************************************************
// Stock d'arrivéée
$form['stock_arrivee'] = "";
if (isset($_REQUEST['stock_arrivee'])) {
	$form['stock_arrivee'] = $_REQUEST['stock_arrivee'];
	$search['stock_arrivee'] = $_REQUEST['stock_arrivee'];
}



// *************************************************
// Résultat de la recherche
$fiches = array();
if (isset($_REQUEST['recherche'])) {

//soit on recherche pour un stock spécifié
	
		// Préparation de la requete
		$query_select = "";
		$query_join 	= "";
		$query_where 	= " dispo = 1  && a.lot !='2' && a.modele = 'materiel' ";
		$query_group	= "";
		$query_having	= "";
		$query_limit = "";
	
		// Ajustement pour faire fonctionner le comptage
		$count_query_join 	= $query_join;
	
	
		
	// Catégorie
	if ($search['ref_art_categ']) { 
		$query_where 	.= " && a.ref_art_categ = '".$search['ref_art_categ']."'";
	}
	// Constructeur
	if ($search['ref_constructeur']) { 
		$query_where 	.= " && a.ref_constructeur = '".$search['ref_constructeur']."'";
	}
	
	if ($query_where) { $query_where .= " && "; }
	$query_where 	.= " a.variante != 2";
	
		// Recherche
		$query = "SELECT a.ref_article, a.ref_oem, a.ref_interne, a.lib_article, 
										 a.ref_constructeur, a.dispo, a.date_fin_dispo, SUM(sa.qte) qte, SUM(asa.seuil_alerte) seuil_alerte, SUM(sad.qte) qted, SUM(asad.seuil_alerte) seuil_alerted
										 ".$query_select."
											, 
												(
												SELECT SUM(dl.qte) 
												FROM docs_lines dl 
													LEFT JOIN doc_lines_cdc dlc ON dl.ref_doc_line = dlc.ref_doc_line
													LEFT JOIN documents d ON d.ref_doc = dl.ref_doc
													LEFT JOIN doc_cdc dc ON d.ref_doc = dc.ref_doc
												WHERE dl.ref_article = a.ref_article && d.id_etat_doc = 9  && dc.id_stock = '".$search['stock_arrivee']."'
												GROUP BY dc.id_stock 
												) as stocks_rsv_qte
											, 
												(
												SELECT SUM(dlc2.qte_livree)
												FROM docs_lines dl2 
													LEFT JOIN doc_lines_cdc dlc2 ON dl2.ref_doc_line = dlc2.ref_doc_line
													LEFT JOIN documents d2 ON d2.ref_doc = dl2.ref_doc
													LEFT JOIN doc_cdc dc2 ON d2.ref_doc = dc2.ref_doc
												WHERE dl2.ref_article = a.ref_article && d2.id_etat_doc = 9  && dc2.id_stock = '".$search['stock_arrivee']."'
												GROUP BY dc2.id_stock 
												) as stocks_rsv_qte_livree
											, 
												(
												SELECT SUM(dld.qte) 
												FROM docs_lines dld 
													LEFT JOIN doc_lines_cdc dlcd ON dld.ref_doc_line = dlcd.ref_doc_line
													LEFT JOIN documents dd ON dd.ref_doc = dld.ref_doc
													LEFT JOIN doc_cdc dcd ON dd.ref_doc = dcd.ref_doc
												WHERE dld.ref_article = a.ref_article && dd.id_etat_doc = 9  && dcd.id_stock = '".$search['stock_depart']."'
												GROUP BY dcd.id_stock 
												) as stocks_rsv_qted
											, 
												(
												SELECT SUM(dlcd2.qte_livree)
												FROM docs_lines dld2 
													LEFT JOIN doc_lines_cdc dlcd2 ON dld2.ref_doc_line = dlcd2.ref_doc_line
													LEFT JOIN documents dd2 ON dd2.ref_doc = dld2.ref_doc
													LEFT JOIN doc_cdc dcd2 ON dd2.ref_doc = dcd2.ref_doc
												WHERE dld2.ref_article = a.ref_article && dd2.id_etat_doc = 9  && dcd2.id_stock = '".$search['stock_depart']."'
												GROUP BY dcd2.id_stock 
												) as stocks_rsv_qte_livreed
							FROM articles a 
								LEFT JOIN articles_stocks_alertes asa ON  asa.ref_article = a.ref_article  && asa.id_stock = '".$search['stock_arrivee']."' 
								LEFT JOIN stocks_articles sa ON   sa.ref_article = asa.ref_article  && sa.id_stock = '".$search['stock_arrivee']."'
								LEFT JOIN articles_stocks_alertes asad ON  asad.ref_article = a.ref_article  && asad.id_stock = '".$search['stock_depart']."' 
								LEFT JOIN stocks_articles sad ON   sad.ref_article = asad.ref_article  && sad.id_stock = '".$search['stock_depart']."'
								
							WHERE ".$query_where." && asa.id_stock = '".$search['stock_arrivee']."' && (asa.seuil_alerte > 0 && ((ISNULL(sa.qte) && asa.seuil_alerte) || (asa.seuil_alerte > sa.qte)) ) 
							GROUP BY a.ref_article 
							HAVING SUM(sad.qte) >= SUM(asad.seuil_alerte)
							ORDER BY lib_article DESC
							".$query_limit;
		$resultat = $bdd->query($query);
		while ($fiche = $resultat->fetchObject()) {
				if (!isset($fiche->qte)) {$fiche->qte = 0;}
				if (!isset($fiche->qted)) {$fiche->qted = 0;}
				if (!isset($fiche->seuil_alerte)) {$fiche->seuil_alerte = 0;}
				if (!isset($fiche->seuil_alerted)) {$fiche->seuil_alerted = 0;}
				if (!isset($fiche->stocks_rsv_qte_livreed)) {$fiche->stocks_rsv_qte_livreed = 0 ;}
				if (!isset($fiche->stocks_rsv_qted)) {$fiche->stocks_rsv_qted = 0 ; }
				if (!isset($fiche->stocks_rsv_qte_livree)) {$fiche->stocks_rsv_qte_livree = 0 ;}
				if (!isset($fiche->stocks_rsv_qte)) {$fiche->stocks_rsv_qte = 0 ;}
				
				if (($fiche->qted - ($fiche->stocks_rsv_qted - $fiche->stocks_rsv_qte_livreed)) > $fiche->seuil_alerted) {
				$fiches[] = $fiche;
				}
	
		}
		unset ($fiche, $resultat, $resultat2, $query, $query2);
		
	

}



//liste des lieux de stockage
$stocks_liste	= array();
$stocks_liste = $_SESSION['stocks'];
	


// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_stocks_a_transferer_result.inc.php");

?>