<?php
// *************************************************************************************************************
// ACCUEIL DE L'UTILISATEUR ADMINISTRATEUR
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");

if (isset($_COOKIE["tarif_d"])) {
	$tarif = $_COOKIE["tarif_d"]; 
} else {
	$tarif = $DEFAUT_APP_TARIFS_CLIENT; 
}
setcookie("tarif_d", $tarif, time()+ $COOKIE_LOGIN_LT, '/');

$_REQUEST['recherche'] = 1;

// Moteur de recherche pour les devis en cours

// *************************************************
// Données pour le formulaire && la requete
$form['page_to_show'] = $search['page_to_show'] = 1;
if (isset($_REQUEST['page_to_show'])) {
	$form['page_to_show'] = $_REQUEST['page_to_show'];
	$search['page_to_show'] = $_REQUEST['page_to_show'];
}
$form['fiches_par_page'] = $search['fiches_par_page'] = $DOCUMENT_RECHERCHE_SHOWED_FICHES;
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

$form['id_type_doc'] = $search['id_type_doc'] = 0;
if (isset($_REQUEST['id_type_doc'])) {
	$form['id_type_doc'] = $_REQUEST['id_type_doc'];
	$search['id_type_doc'] = $_REQUEST['id_type_doc'];
}

$form['ref_constructeur'] = $search['ref_constructeur'] = "";
if (isset($_REQUEST['ref_constructeur'])) {
	$form['ref_constructeur'] = $_REQUEST['ref_constructeur'];
	$search['ref_constructeur'] = $_REQUEST['ref_constructeur'];
}
$form['ref_client'] = $search['ref_client'] = "";
if (isset($_REQUEST['ref_client'])) {
	$form['ref_client'] = $_REQUEST['ref_client'];
	$search['ref_client'] = $_REQUEST['ref_client'];
}
$form['ref_fournisseur'] = $search['ref_fournisseur'] = "";
if (isset($_REQUEST['ref_fournisseur'])) {
	$form['ref_fournisseur'] = $_REQUEST['ref_fournisseur'];
	$search['ref_fournisseur'] = $_REQUEST['ref_fournisseur'];
}
$form['ref_commercial'] = $search['ref_commercial'] = "";
if (isset($_REQUEST['ref_commercial'])) {
	$form['ref_commercial'] = $_REQUEST['ref_commercial'];
	$search['ref_commercial'] = $_REQUEST['ref_commercial'];
}
$form['id_name_mag'] = $search['id_name_mag'] = "";
if (isset($_REQUEST['id_name_mag'])) {
	$form['id_name_mag'] = $_REQUEST['id_name_mag'];
	$search['id_name_mag'] = $_REQUEST['id_name_mag'];
}
$form['id_name_categ_art'] = $search['id_name_categ_art'] = "";
if (isset($_REQUEST['id_name_categ_art'])) {
	$form['id_name_categ_art'] = $_REQUEST['id_name_categ_art'];
	$search['id_name_categ_art'] = $_REQUEST['id_name_categ_art'];
}

$form['devcours'] = $search['devcours'] = 0;
if ($_REQUEST['devcours']) {
	$form['devcours'] = 1;
	$search['devcours'] = 1;
}

$form['devaredig'] = $search['devaredig'] = 0;
if ($_REQUEST['devaredig']) {
	$form['devaredig'] = 1;
	$search['devaredig'] = 1;
}

$form['devrec'] = $search['devrec'] = 0;
if ($_REQUEST['devrec']) {
	$form['devrec'] = 1;
	$search['devrec'] = 1;
}

$form['devperim'] = $search['devperim'] = 0;
if ($_REQUEST['devperim']) {
	$form['devperim'] = 1;
	$search['devperim'] = 1;
}



// *************************************************
// Résultat de la recherche
$fiches = array();
if (isset($_REQUEST['recherche'])) {
	// Préparation de la requete
	$query_join 	= "";
	$query_where 	= "1 ";
	$query_limit	= (($search['page_to_show']-1)*$search['fiches_par_page']).", ".$search['fiches_par_page'];
	}

	// bouton radio : toutes les devis en cours (a réaliser et attente réponse client)
	if ($search['devcours']) {
		$query_where 	.= " && (d.id_etat_doc = 1 OR d.id_etat_doc = 3)";
	}
	
	// bouton radio : uniquement les devis récents
	if ($search['devrec']) {
		$query_where .= " && TO_DAYS(NOW()) - TO_DAYS(d.date_creation_doc) <= '".$DELAI_DEVIS_CLIENT_RECENT."' ";
	}
	
	// bouton radio : uniquement les devis périmés      
	if ($search['devperim']) {
		$query_where .= " && (TO_DAYS(NOW()) - TO_DAYS(d.date_creation_doc) >= '".$DELAI_DEVIS_CLIENT_RETARD."' )";
	}
	
	// bouton radio : uniquement les devis à rédiger
	if ($search['devaredig']) {
	
	$query_where .= " && d.id_etat_doc = 1";
	}
	
	// mini-moteur : par commercial
	if ($search['ref_commercial']) {
		$query_where 	.=  " && d.ref_doc IN ( SELECT ref_doc FROM doc_ventes_commerciaux
												WHERE ref_contact = '".$search['ref_commercial']."')";
	$query_join 	.= "LEFT JOIN doc_ventes_commerciaux dvc ON dvc.ref_doc = d.ref_doc";
	}
	
	// mini-moteur : par fabriquant
	if ($search['ref_constructeur']) {
		$query_where 	.=  " && d.ref_doc IN ( SELECT ref_doc FROM docs_lines WHERE ref_article 
											IN ( SELECT ref_article 
												FROM articles 
												WHERE ref_constructeur = '".$search['ref_constructeur']."'))";
	}
	// mini-moteur : par client
	if ($search['ref_client']) {
		$query_where 	.= " && d.ref_contact = '".$search['ref_client']."'";
	}
	// liste déroulante : par magasin
	if ($search['id_name_mag']) {
		$query_where 	.= " && dd.id_magasin = '".$search['id_name_mag']."'";
	
	}
	
	// liste déroulante : par catégorie d'article

	if ($search['id_name_categ_art']) {
		$liste_categories = "";
		$liste_categs = array();
		$liste_categs = get_child_categories ($liste_categs, $search['id_name_categ_art']);
		foreach ($liste_categs as $categ) {
			if ($liste_categories) { $liste_categories .= ", "; }
			$liste_categories .= " '".$categ."' ";
		}
		
		$query_where 	.= " && d.ref_doc IN ( SELECT ref_doc FROM docs_lines WHERE ref_article 
											IN ( SELECT ref_article 
												FROM articles 
												WHERE ref_art_categ 
													IN ( ".$liste_categories." ))) ";
		
	}
	
	// mini-moteur : par fournisseur
	if ($search['ref_fournisseur']) {
		$query_where 	.= " && d.ref_doc IN ( SELECT ref_doc FROM docs_lines WHERE ref_article 
											IN ( SELECT ref_article 
												FROM articles_ref_fournisseur 
												WHERE ref_fournisseur = '".$search['ref_fournisseur']."'))";
	}
	// champ caché, ne retient que les devis
	if ($search['id_type_doc']) { 
		$query_where 	.= " && ((d.id_etat_doc = 1 OR d.id_etat_doc = 3) && (d.id_type_doc = '".$search['id_type_doc']."') )";
	}
	
	// Recherche : sélection des devis
	$query = "SELECT d.ref_doc, d.id_type_doc, dt.lib_type_doc, d.id_etat_doc, de.lib_etat_doc, d.ref_contact, d.nom_contact,

										( SELECT SUM(qte * pu_ht * (1-remise/100) * (1+tva/100))
									 		FROM docs_lines dl
									 		WHERE d.ref_doc = dl.ref_doc && ISNULL(dl.ref_doc_line_parent) && visible = 1 ) as montant_ttc,
											
										( SELECT SUM(qte * pu_ht * (1-remise/100) )
									 		FROM docs_lines dl
									 		WHERE d.ref_doc = dl.ref_doc && ISNULL(dl.ref_doc_line_parent) && visible = 1 ) as montant_ht,

									 		d.date_creation_doc as date_doc

						FROM documents d 
							LEFT JOIN documents_types dt ON d.id_type_doc = dt.id_type_doc 
							LEFT JOIN documents_etats de ON d.id_etat_doc = de.id_etat_doc 
							LEFT JOIN docs_lines dl ON d.ref_doc = dl.ref_doc
							LEFT JOIN doc_dev dd ON d.ref_doc = dd.ref_doc
							
							".$query_join."

						WHERE ".$query_where."
						GROUP BY d.ref_doc 
						ORDER BY ".$search['orderby']." ".$search['orderorder']."
						LIMIT ".$query_limit;
	$resultat = $bdd->query($query);
	while ($fiche = $resultat->fetchObject()) { $fiches[] = $fiche; }
	//echo nl2br ($query);
	unset ($fiche, $resultat, $query);
	
	// Comptage des résultats
	$query = "SELECT d.ref_doc 
						FROM documents d 
					LEFT JOIN doc_dev dd ON d.ref_doc = dd.ref_doc
							".$query_join."
						WHERE ".$query_where."
						GROUP BY d.ref_doc " ;
	$resultat = $bdd->query($query);
	
	while ($result = $resultat->fetchObject()) { $nb_fiches ++;}
	//echo "<br><hr>".nl2br ($query);
	unset ($result, $resultat, $query);

	// sélection des articles
	foreach ($fiches as $fiche) {
	$query = "SELECT dl.ref_doc_line, dl.ref_doc, dl.ref_article, dl.lib_article, dl.desc_article, dl.qte, dl.pu_ht,
						a.modele, (dl.pu_ht * (1+tva/100)) as pu_ttc,
										( SELECT SUM(sa.qte) 
									 		FROM stocks_articles sa
									 		WHERE sa.ref_article = dl.ref_article
									 	) as qte_stock 
				FROM docs_lines dl
				LEFT JOIN articles a ON dl.ref_article = a.ref_article
				WHERE ref_doc = '".$fiche->ref_doc."'&& dl.ref_article NOT LIKE 'TAXE%' 
				GROUP BY ref_doc_line ";
	$resultat = $bdd->query($query);
	while ($article = $resultat->fetchObject()) { $detail_art[] = $article; }
	unset ($article, $resultat, $query);
				
	}

// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_documents_dev_cli_recherche_result.inc.php");
?>