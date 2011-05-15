<?php
// *************************************************************************************************************
// [COLLABORATEUR] RECHERCHE D'UN ARTICLE POUR INSERTION DANS UN DOCUMENT
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");



// *************************************************************************************************************
// TRAITEMENTS
// *************************************************************************************************************


// *************************************************
// Données pour le formulaire && la requete
$form['page_to_show'] = 1;
if (isset($_REQUEST['page_to_show'])) {
	$form['page_to_show'] = $_REQUEST['page_to_show'];
	$search['page_to_show'] = $_REQUEST['page_to_show'];
}
$form['fiches_par_page'] = $search['fiches_par_page'] = $CATALOGUE_RECHERCHE_SHOWED_FICHES;
if (isset($_REQUEST['fiches_par_page'])) {
	$form['fiches_par_page'] = $_REQUEST['fiches_par_page'];
	$search['fiches_par_page'] = $_REQUEST['fiches_par_page'];
}
$form['orderby'] = $search['orderby'] = "date_doc";
if (isset($_REQUEST['orderby'])) {
	$form['orderby'] = $_REQUEST['orderby'];
	$search['orderby'] = $_REQUEST['orderby'];
}
$form['orderorder'] = $search['orderorder'] = "DESC";
if (isset($_REQUEST['orderorder'])) {
	$form['orderorder'] = $_REQUEST['orderorder'];
	$search['orderorder'] = $_REQUEST['orderorder'];
}
$nb_fiches = 0;


$form['lib_article'] = "";
if (isset($_REQUEST['lib_article'])) {
	$form['lib_article'] = trim(rawurldecode($_REQUEST['lib_article']));
	$search['lib_article'] = trim(rawurldecode($_REQUEST['lib_article']));
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


// Ouverture du document
$document = open_doc ($_REQUEST['ref_doc']);

// *************************************************
// Stock et Tarif affichés
$form['id_stock'] = $search['id_stock'] = $document->getid_stock_search();
if (isset($_REQUEST['id_stock'])) {
	$form['id_stock'] = $_REQUEST['id_stock'];
	$search['id_stock'] = $_REQUEST['id_stock'];
}

$form['id_tarif'] = $search['id_tarif'] = $_SESSION['magasin']->getId_tarif();
if (isset($_REQUEST['id_tarif'])) {
	$form['id_tarif'] = $_REQUEST['id_tarif'];
	$search['id_tarif'] = $_REQUEST['id_tarif'];
}

if ($document->getId_type_doc() == $DEVIS_CLIENT_ID_TYPE_DOC || $document->getId_type_doc() == $LIVRAISON_CLIENT_ID_TYPE_DOC || $document->getId_type_doc() == $COMMANDE_CLIENT_ID_TYPE_DOC || $document->getId_type_doc() == $FACTURE_CLIENT_ID_TYPE_DOC) {
	$contact = new contact ($document->getRef_contact());
	if ($contact->getRef_contact()){
		if ($profil = $contact->getProfil ($CLIENT_ID_PROFIL)) {
			if($profil->getId_tarif ()) {
				$form['id_tarif'] = $search['id_tarif'] = $profil->getId_tarif ();
			}
		}
	}
}

// *************************************************
// Résultat de la recherche
$fiches = array();
if (isset($_REQUEST['recherche'])) {
	// Préparation de la requete
	$query_select	= "";
	$query_join 	= "";
	$query_where 	= " dispo = 1 ";
	$query_group 	= "";
	$query_limit	= (($search['page_to_show']-1)*$search['fiches_par_page']).", ".$search['fiches_par_page'];

	// Stock 
	if ($search['id_stock']) {
		$query_select .= ", sa.qte stock";
		$query_join 	.= " LEFT JOIN stocks_articles sa ON a.ref_article = sa.ref_article && 
																											 sa.id_stock = '".$search['id_stock']."' ";
	}
	else {
		$query_select .= ", SUM(sa.qte) stock";
		$query_join 	.= " LEFT JOIN stocks_articles sa ON a.ref_article = sa.ref_article";
	}
	// Lib_article
	$search_sn = 0;
	if ($search['lib_article']) {
		$libs = explode (" ", $search['lib_article']);
		$query_where 	.= "&& 
											( a.ref_article = '".addslashes($search['lib_article'])."' || 
												a.ref_oem LIKE '%".addslashes($search['lib_article'])."%' || 
												a.ref_interne LIKE '%".addslashes($search['lib_article'])."%' ||
												acb.code_barre = '".addslashes($search['lib_article'])."' || ";
		$query_where 	.= " ( ";
		for ($i=0; $i<count($libs); $i++) {
			$lib = trim($libs[$i]);
			$query_where 	.= " a.lib_article LIKE '%".addslashes($lib)."%' "; 
			if ( isset($libs[$i+1]) ) { $query_where 	.= " && "; }
		}
		$query_join 	.= " LEFT JOIN articles_codes_barres acb ON acb.ref_article = a.ref_article ";
		
		$query_where 	.= " ) ";
		// Aménagement en cas de recherche par numéro de série
		if ($search['lib_article'] && count($libs) == 1 && !$search['ref_art_categ'] && !$search['ref_constructeur']) {
			$search_sn		 = 1;
			$query_select .= ", sas.numero_serie ";
			$query_join 	.= " LEFT JOIN stocks_articles_sn sas ON sa.ref_stock_article = sas.ref_stock_article ";
			$query_where 	.= " || sas.numero_serie = '".addslashes($search['lib_article'])."' "; 
		}

		
		$query_where 	.= " ) ";
	}
	
	
	if (($document->getId_type_doc() == $DEVIS_FOURNISSEUR_ID_TYPE_DOC || $document->getId_type_doc() == $COMMANDE_FOURNISSEUR_ID_TYPE_DOC || $document->getId_type_doc() == $LIVRAISON_FOURNISSEUR_ID_TYPE_DOC || $document->getId_type_doc() == $FACTURE_FOURNISSEUR_ID_TYPE_DOC) && $document->getRef_contact() ) {
	
			$query_select .= ", arf.pa_unitaire ";
			$query_join 	.= " LEFT JOIN articles_ref_fournisseur  arf ON arf.ref_article = a.ref_article && arf.ref_fournisseur = '".$document->getRef_contact()."' ";
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
	// Ajustement pour faire fonctionner le comptage
	$count_query_join = $query_join;


	
	$query_group .= " GROUP BY a.ref_article ";
	// *************************************************
	// Aménagement en cas de recherche automatique 
	if ($_REQUEST['recherche_auto']) {
		$query_more = $document->auto_search_articles ($_REQUEST['recherche_auto']);
		$count_query_join = $query_join 	.= $query_more['query_join'];
		$query_where 	.= $query_more['query_where'];
		if (isset($query_more['query_select'])) {
			$query_select 	.= $query_more['query_select'];
		}
		if (isset($query_more['query_group'])) {
			$query_group 	.= $query_more['query_group'];
		}
	}

	if ($query_where) { $query_where .= " && "; }
	$query_where 	.= " a.variante != 2 && ISNULL(a.id_modele_spe)";

	// Recherche
	$query = "SELECT a.ref_article, a.ref_oem, a.ref_interne, a.lib_article, a.desc_courte, 
									 a.ref_constructeur, ann.nom nom_constructeur, a.dispo, a.prix_achat_ht, a.paa_ht, a.lot,
									 ac.lib_art_categ, ac.modele, t.tva, ia.lib_file
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
						//echo $query;
	$resultat = $bdd->query($query); 
	while ($fiche = $resultat->fetchObject()) {
		$fiche->tarifs = get_article_tarifs ($fiche->ref_article, $search['id_tarif']);
		if ($search_sn) {
			if ($fiche->numero_serie != $search['lib_article']) { unset($fiche->numero_serie); }
		}
		$fiches[] = $fiche; 
	}
	unset ($fiche, $resultat, $query);
	
	// Comptage des résultats
	$query = "SELECT a.ref_article
						FROM articles a 
							".$query_join."
						WHERE ".$query_where."
						".$query_group;
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

include ($DIR.$_SESSION['theme']->getDir_theme()."page_documents_recherche_articles_result.inc.php");

?>