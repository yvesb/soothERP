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
$nb_fiches = 0;


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

$form['emplacement_s'] = $search['emplacement_s'] = "";
if (isset($_REQUEST['emplacement_s'])) {
	$form['emplacement_s'] = $_REQUEST['emplacement_s'];
	$search['emplacement_s'] = $_REQUEST['emplacement_s'];
}
$form['aff_pa'] = $search['aff_pa'] = 0;
if ($_REQUEST['aff_pa']) {
	$form['aff_pa'] = 1;
	$search['aff_pa'] = 1;
}


$form['in_stock'] = $search['in_stock'] = 0;
if (isset($_REQUEST['in_stock']) && $_REQUEST['in_stock']) {
	$form['in_stock'] = $_REQUEST['in_stock'];
	$search['in_stock'] = $_REQUEST['in_stock'];
}
	
// *************************************************
// Stock affichés
$form['id_stock'] = array();
if (isset($_REQUEST['id_stock'])) {
	$form['id_stock'] = explode(",", $_REQUEST['id_stock']);
	$search['id_stock'] = explode(",", $_REQUEST['id_stock']);
}



// *************************************************
// Résultat de la recherche
$fiches = array();
if (isset($_REQUEST['recherche'])) {
	// Préparation de la requete
	$query_select = "";
	$query_join 	= "";
	$query_where 	= " dispo = 1 && a.lot != '2' && a.modele = 'materiel' ";
	$query_group	= "";
	$query_limit	= (($search['page_to_show']-1)*$search['fiches_par_page']).", ".$search['fiches_par_page'];

	// Catégorie
	if ($search['ref_art_categ']) { 
		$query_where 	.= " && a.ref_art_categ = '".$search['ref_art_categ']."'";
	}
	// Constructeur
	if ($search['ref_constructeur']) { 
		$query_where 	.= " && a.ref_constructeur = '".$search['ref_constructeur']."'";
	}
	// Prix d'achat
	if ($search['aff_pa']) {
		$query_select 	.= ",  a.prix_achat_ht, a.paa_ht ";
	}

		// Sélection des stocks disponibles
		$where_stock = "";
		$where_instock = "";
		if ($search['id_stock'] && $search['id_stock'][0] != "") {
			$where_stock .= " && (";
			$i = 0;
			foreach ($search['id_stock'] as $stock) {
				if ($i != 0) { $where_stock .= " || ";}
				$where_stock .= " sa.id_stock = '".$stock."'";
				if ($i != 0) { $where_instock .= " || ";}
				$where_instock .= " sa.id_stock = '".$stock."'";
				$i ++;
			}
			$where_stock .= " ) ";
		}
		
	// stock non null
	if ($search['in_stock'] == 1) {
		$query_join 	.= " LEFT JOIN stocks_articles sa ON a.ref_article = sa.ref_article";
		$query_where 	.=  " && sa.qte < 0 ".$where_stock." ";
		$query_group	.= "GROUP BY a.ref_article, sa.ref_article ";
	}
	// stock positif
	if ($search['in_stock'] == 2) {
		$query_join 	.= " LEFT JOIN stocks_articles sa ON a.ref_article = sa.ref_article";
		$query_where 	.=  " && sa.qte > 0 ".$where_stock." ";
		$query_group	.= "GROUP BY a.ref_article, sa.ref_article ";
	}
	// Emplacement
	if ($search['emplacement_s']) { 
	$query_select 	.= ", asa.emplacement";
	$query_join 	.= " LEFT JOIN articles_stocks_alertes asa ON a.ref_article = asa.ref_article";
	$query_where 	.= " && lower(asa.emplacement) LIKE lower('%".$search['emplacement_s']."%')";
	}
	// Ajustement pour faire fonctionner le comptage
	$count_query_join 	= $query_join;

	if ($query_where) { $query_where .= " && "; }
	$query_where 	.= " a.variante != 2";
	
	// Recherche
	$query = "SELECT a.ref_article, a.ref_oem, a.ref_interne, a.lib_article, 
									 a.ref_constructeur, ann.nom nom_constructeur, a.dispo, a.date_fin_dispo, a.modele, a.lot, 
									 ac.lib_art_categ, t.tva, ia.lib_file
									 ".$query_select."

						FROM articles a
							LEFT JOIN tvas t ON t.id_tva = a.id_tva
							LEFT JOIN annuaire ann ON a.ref_constructeur = ann.ref_contact 
							LEFT JOIN art_categs ac ON a.ref_art_categ = ac.ref_art_categ 
							LEFT JOIN articles_images ai ON ai.ref_article = a.ref_article && ai.ordre = 1
							LEFT JOIN images_articles ia ON ia.id_image= ai.id_image
							".$query_join."
						WHERE ".$query_where."
						".$query_group."
						ORDER BY ".$search['orderby']." ".$search['orderorder']."
						LIMIT ".$query_limit;
	$resultat = $bdd->query($query);
	while ($fiche = $resultat->fetchObject()) {
	
		$fiche->stocks = array();
		$query = "SELECT sa.id_stock, sa.qte,  asa.seuil_alerte
							FROM stocks_articles sa
								LEFT JOIN articles_stocks_alertes asa ON sa.id_stock = asa.id_stock && asa.ref_article = '".$fiche->ref_article."'
							WHERE sa.ref_article = '".$fiche->ref_article."' ".$where_stock;
							//echo $query;
		$resultat2 = $bdd->query ($query);
		while ($var = $resultat2->fetchObject()) { $fiche->stocks[$var->id_stock] = $var; }

		$fiches[] = $fiche; 
	}
	unset ($fiche, $resultat, $query);

	// Comptage des résultats
	$query = "SELECT a.ref_article
						FROM articles a 
							".$count_query_join."
						WHERE ".$query_where."
						GROUP BY a.ref_article ";
	$resultat = $bdd->query($query); 
	while ($result = $resultat->fetchObject()) { $nb_fiches += 1;  }
	unset ($result, $resultat, $query);
}



//liste des lieux de stockage
$stocks_liste	= array();
$stocks_liste = $_SESSION['stocks'];
	


// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_stocks_etat_recherche_result.inc.php");

?>