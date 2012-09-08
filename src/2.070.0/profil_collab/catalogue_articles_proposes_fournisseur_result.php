<?php
// *************************************************************************************************************
// [COLLABORRATEUR] RECHERCHE D'UN ARTICLE CATALOGUE
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");


// *************************************************************************************************************
// TRAITEMENTS
// *************************************************************************************************************

//$fournisseurs_liste = get_fournisseurs();

/*
//liste des lieux de stockage
$stocks_liste	= array();
$stocks_liste = $_SESSION['stocks'];


//liste des tarifs
get_tarifs_listes ();
$tarifs_liste	= array();
$tarifs_liste = $_SESSION['tarifs_listes'];	
*/


// *************************************************
// Données pour le formulaire && la requete
// *************************************************

$nb_fiches = 0;

// ************************************************* $_REQUEST['page_to_show']
$form['page_to_show'] = $search['page_to_show'] = 1;
if (isset($_REQUEST['page_to_show'])) {
	$form['page_to_show'] = $_REQUEST['page_to_show'];
	$search['page_to_show'] = $_REQUEST['page_to_show'];
}

// ************************************************* $CATALOGUE_RECHERCHE_SHOWED_FICHES
$form['fiches_par_page'] = $search['fiches_par_page'] = $CATALOGUE_RECHERCHE_SHOWED_FICHES;
if (isset($_REQUEST['fiches_par_page'])) {
	$form['fiches_par_page'] = $_REQUEST['fiches_par_page'];
	$search['fiches_par_page'] = $_REQUEST['fiches_par_page'];
}

// ************************************************* $_REQUEST['orderby']
$form['orderby'] = $search['orderby'] = "a.lib_article";
if (isset($_REQUEST['orderby'])) {
	$form['orderby'] = $search['orderby'] = $_REQUEST['orderby'];
}

// ************************************************* $_REQUEST['orderorder']
$form['orderorder'] = $search['orderorder'] = "ASC";
if (isset($_REQUEST['orderorder'])) {
	$form['orderorder'] = $_REQUEST['orderorder'];
	$search['orderorder'] = $_REQUEST['orderorder'];
}

// ************************************************* $_REQUEST['ref_fournisseur'] 
$form['ref_fournisseur'] = $search['ref_fournisseur'] = "";
if (isset($_REQUEST['ref_fournisseur'])) {
	$form['ref_fournisseur'] = urldecode($_REQUEST['ref_fournisseur']);
	$search['ref_fournisseur'] = urldecode($_REQUEST['ref_fournisseur']);
}

// ************************************************* $_REQUEST['lib_article'] 
$form['lib_article'] = $search['lib_article'] = "";
if (isset($_REQUEST['lib_article'])) {
	$form['lib_article'] = trim(urldecode($_REQUEST['lib_article']));
	$search['lib_article'] = trim(urldecode($_REQUEST['lib_article']));
}

// ************************************************* $_REQUEST['ref_art_categ'] 
$form['ref_art_categ'] = $search['ref_art_categ'] = "";
if (isset($_REQUEST['ref_art_categ'])) {
	$form['ref_art_categ'] = $_REQUEST['ref_art_categ'];
	$search['ref_art_categ'] = $_REQUEST['ref_art_categ'];
}

// ************************************************* $_REQUEST['ref_constructeur'] 
/*
$form['ref_constructeur'] = $search['ref_constructeur'] = "";
if (isset($_REQUEST['ref_constructeur'])) {
	$form['ref_constructeur'] = $_REQUEST['ref_constructeur'];
	$search['ref_constructeur'] = $_REQUEST['ref_constructeur'];
}
*/

// *************************************************
// Résultat de la recherche
// *************************************************

$fiches = array();
if (isset($_REQUEST['recherche'])) {
	// Préparation de la requete
	$query_select = "";
	$query_join 	= "";
	$count_query_join 	= "";
	$query_where 	= "";
	$query_group	= "";
	$query_limit	= (($search['page_to_show']-1)*$search['fiches_par_page']).", ".$search['fiches_par_page'];


	// ************************************************* $search['lib_article'] 
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
	
	// ************************************************* $search['ref_art_categ'] 
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
	
	// ************************************************* $search['ref_constructeur'] 
	if (isset($search['ref_constructeur'])) { 
			$query_where 	.= " && a.ref_constructeur = '".$search['ref_constructeur']."'";
	}

	// ************************************************* $search['ref_fournisseur'] 
	$query_where_fournisseur = "";
	if (isset($search['ref_fournisseur'])) { 
		$query_where_fournisseurA	= "doc.ref_contact = '".$search['ref_fournisseur']."'";
		$query_where_fournisseurB	= "arf.ref_fournisseur = '".$search['ref_fournisseur']."'";
	}
	
	
	// Ajustement pour faire fonctionner le comptage
	$count_query_join 	= $query_join;

	$query_group  = " GROUP BY a.ref_article ";
	// Recherche
	/*
	$query = "SELECT 	arf.ref_fournisseur, a.ref_article, a.ref_interne, a.ref_oem, arf.ref_article_externe, arf.lib_article_externe, ac.lib_art_categ, ann.nom as nom_constructeur,  a.lib_article,
										apAa.prix_achat_ht, apAAa.prix_achat_actuel_ht, apAa.date_maj as date_dernier_achat
									 ".$query_select."
						FROM articles_ref_fournisseur arf
						LEFT JOIN	articles a ON arf.ref_article 			= a.ref_article
						LEFT JOIN art_categs ac ON a.ref_art_categ 		= ac.ref_art_categ
						LEFT JOIN annuaire ann ON a.ref_constructeur 	= ann.ref_contact 
						LEFT JOIN articles_paa_archive apAAa ON apAAa.ref_article = arf.ref_article 
						LEFT JOIN articles_pa_archive apAa ON apAa.ref_article 		= arf.ref_article
							 	".$query_join."
						WHERE ".$query_where." 
						GROUP BY a.ref_article
						HAVING MAX(apAa.date_maj)
						ORDER BY ".$search['orderby']." ".$search['orderorder']."
						LIMIT ".$query_limit;
	*/
	
	$query = "
					SELECT 	a.ref_article, a.ref_interne, a.ref_oem, arf.ref_article_externe, arf.lib_article_externe, ac.lib_art_categ, 
									ann.nom as nom_constructeur,  a.lib_article,
									resA.date_dernier_achat as date_dernier_achat, resA.prix_achat_ht as prix_achat_ht, 
									arf.pa_unitaire as prix_achat_actuel_ht, arf.date_pa
					FROM 			articles_ref_fournisseur arf
					LEFT JOIN	articles a 			ON arf.ref_article = a.ref_article
					LEFT JOIN art_categs ac 	ON a.ref_art_categ 		= ac.ref_art_categ
					LEFT JOIN annuaire ann 		ON a.ref_constructeur 	= ann.ref_contact 
					LEFT JOIN(	SELECT	a.ref_article, doc.date_creation_doc as date_dernier_achat, doc_l.pu_ht as prix_achat_ht
											FROM 			documents doc
											LEFT JOIN doc_cdf cdf ON cdf.ref_doc = doc.ref_doc
											LEFT JOIN docs_lines doc_l ON doc_l.ref_doc = doc.ref_doc
											LEFT JOIN articles a ON doc_l.ref_article = a.ref_article
											WHERE ".$query_where_fournisseurA."
											GROUP BY a.ref_article
											HAVING MAX(date_dernier_achat)) resA ON a.ref_article = resA.ref_article ";
if($query_where_fournisseurA != ""){
$query.=" WHERE ".$query_where_fournisseurB;}
$query.="	ORDER BY ".$search['orderby']." ".$search['orderorder']."
					LIMIT ".$query_limit;
	
	//echo "<br/><hr/><br/>".nl2br($query)."<br/><hr/><br/>";
	$resultat = $bdd->query($query);
	while ($fiche = $resultat->fetchObject()) {
		$fiches[] = $fiche; 
	}
	unset ($fiche, $resultat, $query);

	// Comptage des résultats
	/*
	$query = "SELECT 	a.ref_article
						FROM articles_ref_fournisseur arf
						LEFT JOIN	articles a ON arf.ref_article 			= a.ref_article
						LEFT JOIN art_categs ac ON a.ref_art_categ 		= ac.ref_art_categ
						LEFT JOIN annuaire ann ON a.ref_constructeur 	= ann.ref_contact 
						LEFT JOIN articles_paa_archive apAAa ON apAAa.ref_article = arf.ref_article 
						LEFT JOIN articles_pa_archive apAa ON apAa.ref_article 		= arf.ref_article
							 	".$query_join."
						WHERE ".$query_where."
						GROUP BY a.ref_article
						HAVING MAX(apAa.date_maj)";*/
	/*
	$query = "SELECT 	a.ref_article
					FROM documents doc
					LEFT JOIN doc_blf blf 									ON blf.ref_doc = doc.ref_doc
					LEFT JOIN docs_lines doc_l 							ON doc_l.ref_doc = doc.ref_doc
					LEFT JOIN documents_editions doc_e 			ON doc.ref_doc = doc_e.ref_doc
					LEFT JOIN articles_ref_fournisseur arf 	ON arf.ref_article = doc_l.ref_article
					LEFT JOIN	articles a 										ON arf.ref_article = a.ref_article
					LEFT JOIN art_categs ac 								ON a.ref_art_categ 		= ac.ref_art_categ
					LEFT JOIN annuaire ann 									ON a.ref_constructeur 	= ann.ref_contact 
					
					WHERE doc_l.ref_article != '' && doc.id_etat_doc = 31 ".$query_where." 
					
					GROUP BY doc_l.ref_article";
	*/
	
		$query = "
					SELECT 	a.ref_article, resA.date_dernier_achat as date_dernier_achat, resA.prix_achat_ht as prix_achat_ht, 
									arf.pa_unitaire as prix_achat_actuel_ht, arf.date_pa
					FROM 			articles_ref_fournisseur arf
					LEFT JOIN	articles a 			ON arf.ref_article = a.ref_article
					LEFT JOIN art_categs ac 	ON a.ref_art_categ 		= ac.ref_art_categ
					LEFT JOIN annuaire ann 		ON a.ref_constructeur 	= ann.ref_contact 
					LEFT JOIN(	SELECT	a.ref_article, doc.date_creation_doc as date_dernier_achat, doc_l.pu_ht as prix_achat_ht
											FROM 			documents doc
											LEFT JOIN doc_cdf cdf ON cdf.ref_doc = doc.ref_doc
											LEFT JOIN docs_lines doc_l ON doc_l.ref_doc = doc.ref_doc
											LEFT JOIN articles a ON doc_l.ref_article = a.ref_article
											WHERE ".$query_where_fournisseurA."
											GROUP BY a.ref_article
											HAVING MAX(date_dernier_achat)) resA ON a.ref_article = resA.ref_article ";
if($query_where_fournisseurB != ""){
$query.=" WHERE ".$query_where_fournisseurB;}


	//echo "<br/><hr/><br/>".nl2br($query)."<br/><hr/><br/>";
	$resultat = $bdd->query($query); 
	while ($result = $resultat->fetchObject()) { $nb_fiches++; }
	unset ($result, $resultat, $query);
}

// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_catalogue_articles_proposes_fournisseur_result.inc.php");

?>