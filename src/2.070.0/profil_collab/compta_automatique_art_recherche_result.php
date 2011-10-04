<?php
// *************************************************************************************************************
// [ADMINISTRATEUR] RECHERCHE D'UNE FICHE D'ARTICLE
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");


// *************************************************
// Données pour le formulaire && la requete
$form['type'] = $search['type'] = 1;
if (isset($_REQUEST['type'])) {
	$form['type'] = $_REQUEST['type'];
	$search['type'] = $_REQUEST['type'];
}
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


$form['lib_article'] = "";
if (isset($_REQUEST['lib_article'])) {
	$form['lib_article'] = trim(urldecode($_REQUEST['lib_article']));
	$search['lib_article'] = trim(urldecode($_REQUEST['lib_article']));
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

$form['in_stock'] = $search['in_stock'] = 0;
if ($_REQUEST['in_stock']) {
	$form['in_stock'] = 1;
	$search['in_stock'] = 1;
}
$form['is_nouveau'] = $search['is_nouveau'] = 0;
if ($_REQUEST['is_nouveau']) {
	$form['is_nouveau'] = 1;
	$search['is_nouveau'] = 1;
}
$form['in_promotion'] = $search['in_promotion'] = 0;
if ($_REQUEST['in_promotion']) {
	$form['in_promotion'] = 1;
	$search['in_promotion'] = 1;
}


// *************************************************
// Stock et Tarif affichés
$form['id_stock'] = $_SESSION['magasin']->getId_stock();
if (isset($_REQUEST['id_stock'])) {
	$form['id_stock'] = $_REQUEST['id_stock'];
	$search['id_stock'] = $_REQUEST['id_stock'];
}

$form['id_tarif'] = $_SESSION['magasin']->getId_tarif();
if (isset($_REQUEST['id_tarif'])) {
	$form['id_tarif'] = $_REQUEST['id_tarif'];
	$search['id_tarif'] = $_REQUEST['id_tarif'];
}


// *************************************************
// Résultat de la recherche
$fiches = array();
if (isset($_REQUEST['recherche'])) {
	// Préparation de la requete
	$query_select = "";
	$query_join 	= "";
	$count_query_join 	= "";
	$query_where 	= " dispo = 1 ";
	$query_group	= "";
	$query_limit	= (($search['page_to_show']-1)*$search['fiches_par_page']).", ".$search['fiches_par_page'];

	// Lib_article
	if ($search['lib_article']) {
		$libs = explode (" ", $search['lib_article']);
		$query_where 	.= "  && (
											( a.ref_article = '".addslashes($search['lib_article'])."' || 
												ref_oem LIKE '%".addslashes($search['lib_article'])."%' || 
												ref_interne LIKE '%".addslashes($search['lib_article'])."%' ||
												acb.code_barre = '".addslashes($search['lib_article'])."' ) || ";
		$count_query_join .= $query_join  .=  " LEFT JOIN articles_codes_barres acb ON acb.ref_article = a.ref_article ";
		$query_where 	.= " ( ";
		for ($i=0; $i<count($libs); $i++) {
			$lib = trim($libs[$i]);
			$query_where 	.= " lib_article LIKE '%".addslashes($lib)."%' "; 
			if ( isset($libs[$i+1]) ) { $query_where 	.= " && "; }
		}
		$query_where 	.= " ) )";
	}
	
	// Catégorie
	if ($search['ref_art_categ']) { 
		$liste_categories = "";
		$liste_categs = array();
		$liste_categs = get_child_categories ($liste_categs, $search['ref_art_categ']);
		foreach ($liste_categs as $categ) {
			if ($liste_categories) { $liste_categories .= ", "; }
			$liste_categories .= " '".$categ."' ";
		}
		$query_where 	.= " && a.ref_art_categ IN ( ".$liste_categories." ) ";
	}
	// Constructeur
	if (isset($search['ref_constructeur'])) { 
		if ($search['ref_constructeur']) { 
			$query_where 	.= " && a.ref_constructeur = '".$search['ref_constructeur']."'";
		} 
		if ($search['ref_constructeur'] == "0"){
			$query_where 	.= " && ISNULL(a.ref_constructeur)";
		}
	}
	// Nouveauté
	if ($search['is_nouveau']) {
		$query_where 	.= " && a.date_creation > '".date("Y:m:d h:i:s", time()-$DELAI_ARTICLE_IS_NEW)."'";
	}
	// promotion
	if ($search['in_promotion']) {
	//	$query_where 	.= " ";
	}
	

	// Stock 
	if ($search['id_stock']) {
		$query_select  .= ", sa.qte stock";
		$query_join 	 .= " LEFT JOIN stocks_articles sa ON a.ref_article = sa.ref_article  
																										&& sa.id_stock = '".$search['id_stock']."'";
		// en stock
		if ($search['in_stock']) {
				$query_where 	.=  " && sa.qte > 0  ";
		}
	}
	else {
		$query_select  .= ", SUM(sa.qte) stock";
		$query_join 	 .= " LEFT JOIN stocks_articles sa ON a.ref_article = sa.ref_article";
		$query_group  .= " GROUP BY a.ref_article ";
			// en stock
			if ($search['in_stock']) {
				$query_where 	.=  " && sa.qte > 0  ";
			}
	}

	if ($query_where) { $query_where .= " && "; }
	$query_where 	.= " a.variante != 2";
	
	// Ajustement pour faire fonctionner le comptage
	$count_query_join 	= $query_join;

		$query_group  = " GROUP BY a.ref_article ";
	// Recherche
	$query = "SELECT a.ref_article, a.ref_oem, a.ref_interne, a.lib_article, a.desc_courte,
									 a.ref_constructeur, ann.nom nom_constructeur, a.dispo, a.lot,
									 ac.lib_art_categ, ac.modele, t.tva, ia.lib_file,
									 a.numero_compte_achat, a.numero_compte_vente,
									 ac.defaut_numero_compte_achat,						
									 ac.defaut_numero_compte_vente
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
//	var_dump ( $query );
//	exit;
	$resultat = $bdd->query($query);
	
	while ($fiche = $resultat->fetchObject()) {
		$fiche->tarifs = get_article_tarifs ($fiche->ref_article, $search['id_tarif']);
		$fiches[] = $fiche; 
	}
	unset ($fiche, $resultat, $query);

	// Comptage des résultats
	$query = "SELECT DISTINCT a.ref_article
						FROM articles a 
							".$count_query_join."
						WHERE ".$query_where."
						GROUP BY a.ref_article ";
	$resultat = $bdd->query($query); 
	while ($result = $resultat->fetchObject()) { $nb_fiches += 1; }
	unset ($result, $resultat, $query);
}



//liste des lieux de stockage
$stocks_liste	= array();
$stocks_liste = $_SESSION['stocks'];
	

//liste des tarifs
get_tarifs_listes ();
$tarifs_liste	= array();
$tarifs_liste = $_SESSION['tarifs_listes'];	


// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_compta_automatique_art_recherche_result.inc.php");

?>