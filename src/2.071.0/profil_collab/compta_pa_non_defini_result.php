<?php
// *************************************************************************************************************
// RECHERCHE DES ARTICLES DONT LE PRIX D'ACHAT N'EST PAS DÉFINI
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

$form['in_pa_zero'] = $search['in_pa_zero'] = 0;
if ($_REQUEST['in_pa_zero']) {
	$form['in_pa_zero'] = 1;
	$search['in_pa_zero'] = 1;
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
		$query_where 	.= " && a.ref_art_categ = '".$search['ref_art_categ']."'";
	}
	// Constructeur
	if ($search['ref_constructeur']) { 
		$query_where 	.= " && a.ref_constructeur = '".$search['ref_constructeur']."'";
	}
	
	// Stock 
	if ($search['id_stock']) {
		$query_select  .= ", sa.qte stock";
		$query_join 	 .= " LEFT JOIN stocks_articles sa ON a.ref_article = sa.ref_article  
																										&& sa.id_stock = '".$search['id_stock']."'";
	}
	else {
		$query_select  .= ", SUM(sa.qte) stock";
		$query_join 	 .= " LEFT JOIN stocks_articles sa ON a.ref_article = sa.ref_article";
		$query_group  .= " GROUP BY a.ref_article ";
	}

	// pa 
	if ($search['in_pa_zero']) {
				$query_where 	.=  " && (a.prix_achat_ht = 0 || ISNULL(a.prix_achat_ht))";
	}
	else {
				$query_where 	.=  " && ISNULL(a.prix_achat_ht)";
	}

	if ($query_where) { $query_where .= " && "; }
	$query_where 	.= " a.variante != 2";
	
	// Ajustement pour faire fonctionner le comptage
	$count_query_join 	= $query_join;

	// Recherche
	$query = "SELECT a.ref_article, a.ref_oem, a.ref_interne, a.lib_article, a.desc_courte,
									 a.ref_constructeur, ann.nom nom_constructeur, a.dispo, a.prix_achat_ht, a.lot, a.modele,
									 ac.lib_art_categ, t.tva
									 ".$query_select."

						FROM articles a
							LEFT JOIN tvas t ON t.id_tva = a.id_tva
							LEFT JOIN annuaire ann ON a.ref_constructeur = ann.ref_contact 
							LEFT JOIN art_categs ac ON a.ref_art_categ = ac.ref_art_categ 
							".$query_join."
						WHERE ".$query_where."
						".$query_group."
						ORDER BY ".$search['orderby']." ".$search['orderorder']."
						LIMIT ".$query_limit;
						
	$resultat = $bdd->query($query);
	while ($fiche = $resultat->fetchObject()) {
		$fiche->tarifs = get_article_tarifs ($fiche->ref_article, $search['id_tarif']);
		$fiches[] = $fiche; 
	}
	unset ($fiche, $resultat, $query);
		$query_group  = " GROUP BY a.ref_article ";

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

include ($DIR.$_SESSION['theme']->getDir_theme()."page_compta_pa_non_defini_result.inc.php");

?>