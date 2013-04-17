<?php
// *************************************************************************************************************
// RECHERCHE DES ARTICLES POUR L'ETAT DES STOCKS
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
// Stock affichés
$form['id_stock'] = "";
if (isset($_REQUEST['id_stock'])) {
	$form['id_stock'] = $_REQUEST['id_stock'];
	$search['id_stock'] = $_REQUEST['id_stock'];
}



// *************************************************
// Résultat de la recherche
$fiches = array();
if (isset($_REQUEST['recherche'])) {

//soit on recherche pour un stock spécifié
	
		// Préparation de la requete
		$query_select = "";
		$query_join 	= "";
		$query_where 	= " dispo = 1 && a.lot !='2' && a.modele = 'materiel'  ";
		$query_group	= "";
		$query_having	= "";
		$query_limit = "";
	
		// Ajustement pour faire fonctionner le comptage
		$count_query_join 	= $query_join;
	
		$search_stock_query = "";
		$search_stock_query2 = "";
		$search_stock_query3 = "";
		$search_stock_query4 = "";
		
	if (isset($search['id_stock']) && $search['id_stock'] != "") {
		$search_stock_query = " && sa.id_stock = '".$search['id_stock']."'";
		$search_stock_query2 = " && id_stock = '".$search['id_stock']."'";
		$search_stock_query3 = " && asa.id_stock = '".$search['id_stock']."' && (asa.seuil_alerte > 0 && ((ISNULL(sa.qte) && asa.seuil_alerte) || (asa.seuil_alerte > sa.qte)) ) ";
		
		$query_limit	= "LIMIT ".(($search['page_to_show']-1)*$search['fiches_par_page']).", ".$search['fiches_par_page'];
		
	} else {
		$query_where.=" && (asa.seuil_alerte > 0 && (ISNULL(sa.qte) || sa.qte) ) ";
		$search_stock_query4.=" && sa.qte >0";
		
	}
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
		$query = "SELECT a.ref_article, a.ref_oem, a.ref_interne, a.lib_article, a.ref_art_categ, ac.lib_art_categ, sa.id_stock,
										 a.ref_constructeur, a.dispo, a.date_fin_dispo, a.lot, a.modele
										 ".$query_select."
	
							FROM articles a 
								LEFT JOIN articles_stocks_alertes asa ON  asa.ref_article = a.ref_article
								LEFT JOIN art_categs ac ON a.ref_art_categ = ac.ref_art_categ
								LEFT JOIN stocks_articles sa ON   sa.ref_article = asa.ref_article ".$search_stock_query."
								
							WHERE ".$query_where." ".$search_stock_query3." 
							GROUP BY a.ref_article 
							".$query_having."
							ORDER BY ".$search['orderby']." ".$search['orderorder']." 
							".$query_limit;
		$resultat = $bdd->query($query);
		//@FIXME var_dump ($query);
		while ($fiche = $resultat->fetchObject()) {
		
				$fiche->qte = 0;
				$query0 = "SELECT SUM(sa.qte) qte
									FROM stocks_articles sa
									WHERE sa.ref_article = '".$fiche->ref_article."' ".$search_stock_query." ".$search_stock_query4."
									 ";
				$resultat0 = $bdd->query ($query0);
				while ($qte = $resultat0->fetchObject()) { 
					$fiche->qte = $qte->qte;
				}
				
				$fiche->seuil_alerte = 0;
				$query01 = "SELECT SUM(seuil_alerte) seuil_alerte
									FROM articles_stocks_alertes  
									WHERE ref_article = '".$fiche->ref_article."' ".$search_stock_query2."
									 ";
				$resultat01 = $bdd->query ($query01);
				while ($seuil_alerte = $resultat01->fetchObject()) { $fiche->seuil_alerte = $seuil_alerte->seuil_alerte; }
				// Sélection des stocks réservés (CDC "en cours")
				$fiche->stocks_rsv["qte"] = 0;
				$fiche->stocks_rsv["qte_livree"] = 0;
				$query2 = "SELECT SUM(dl.qte) qte, SUM(dlc.qte_livree) qte_livree, id_stock 
									FROM docs_lines dl 
										LEFT JOIN doc_lines_cdc dlc ON dl.ref_doc_line = dlc.ref_doc_line
										LEFT JOIN documents d ON d.ref_doc = dl.ref_doc
										LEFT JOIN doc_cdc dc ON d.ref_doc = dc.ref_doc
									WHERE dl.ref_article = '".$fiche->ref_article."' && d.id_etat_doc = 9 ".$search_stock_query2."
									GROUP BY dc.id_stock ";
				$resultat2 = $bdd->query ($query2);
				while ($rsv = $resultat2->fetchObject()) { 
						$fiche->stocks_rsv["qte"] = $fiche->stocks_rsv["qte"]+$rsv->qte;
						$fiche->stocks_rsv["qte_livree"] = $fiche->stocks_rsv["qte_livree"]+$rsv->qte_livree;
				}
				//réappro en cours
				$fiche->stocks_cdf["qte"] = 0;
				$fiche->stocks_cdf["qte_recue"] = 0;
				
				$query3 = "SELECT SUM(dl.qte) qte, SUM(dlf.qte_recue) qte_recue, id_stock, 
												 MIN(dc.date_livraison) date_livraison
									FROM docs_lines dl 
										LEFT JOIN doc_lines_cdf dlf ON dl.ref_doc_line = dlf.ref_doc_line
										LEFT JOIN documents d ON d.ref_doc = dl.ref_doc
										LEFT JOIN doc_cdf dc ON d.ref_doc = dc.ref_doc
									WHERE dl.ref_article = '".$fiche->ref_article."' && d.id_etat_doc = 27  ".$search_stock_query2."
									GROUP BY dc.id_stock";
				$resultat3 = $bdd->query ($query3);
				while ($cdf = $resultat3->fetchObject()) { 
						$fiche->stocks_cdf["qte"] = $fiche->stocks_cdf["qte"]+$cdf->qte;
						$fiche->stocks_cdf["qte_recue"] = $fiche->stocks_cdf["qte_recue"]+$cdf->qte_recue;
				}
			if ($fiche->qte < $fiche->seuil_alerte) {
				$fiches[] = $fiche;
			}
	
		}
		unset ($fiche, $resultat, $resultat2, $query, $query2);
		
	// Comptage des résultats
			
	if (isset($search['id_stock']) && $search['id_stock'] != "") {
			$query = "SELECT a.ref_article
											 ".$query_select."
								FROM articles_stocks_alertes asa
									LEFT JOIN articles a ON  asa.ref_article = a.ref_article
									LEFT JOIN stocks_articles sa ON   sa.ref_article = asa.ref_article  ".$search_stock_query."
									
								WHERE ".$query_where." ".$search_stock_query3."
								GROUP BY a.ref_article
								".$query_having."
								ORDER BY ".$search['orderby']." ".$search['orderorder']."
								";
			$resultat = $bdd->query($query);
			while ($result = $resultat->fetchObject()) { $nb_fiches ++; }
			unset ($result, $resultat, $query);
			
	} else {
		$nb_fiches = count($fiches);
	 // on découpe les résultats trouvés pour réspecter une pagination
	 $tmp_fiches = array();
		for ($i = (($search['page_to_show'] - 1)*$search['fiches_par_page']); $i <($search['page_to_show']*$search['fiches_par_page']) ; $i++) {
			if (isset($fiches[$i])) {
				$tmp_fiches[] = $fiches[$i];
			}
		}
		$fiches = $tmp_fiches;
	}

}



//liste des lieux de stockage
$stocks_liste	= array();
$stocks_liste = $_SESSION['stocks'];
	


// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************
if ( isset($_REQUEST["print"]) ){
	ini_set("memory_limit","1M");
	//**************************************
	// Controle
	$infos = array();
	$code_pdf_modele = "stock_a_renouveller";
	// Ouverture du fichier pdf des états des stocks
	include_once ($PDF_MODELES_DIR.$code_pdf_modele.".class.php");
	$class = "pdf_".$code_pdf_modele;
	$pdf = new $class;
	
	// Création
	$pdf->create_pdf($search['id_stock'],$fiches,$infos );
	
	// Sortie
	$pdf->Output();

}else {
	include ($DIR.$_SESSION['theme']->getDir_theme()."page_stocks_a_renouveller_result.inc.php");
}
?>