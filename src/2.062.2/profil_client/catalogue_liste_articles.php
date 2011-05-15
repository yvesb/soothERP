<?php
// *************************************************************************************************************
// CATALOGUE CLIENT
// *************************************************************************************************************


require("_dir.inc.php");
require ("_profil.inc.php");
require ("_session.inc.php");



gestion_panier();
$catalogue = new catalogue_client($ID_CATALOGUE_INTERFACE);
$id_tarif = "";

$list_catalogue_dir =	get_catalogue_client_dirs($ID_CATALOGUE_INTERFACE);

//récup de l'id_tarif du client
if ($_SESSION['user']->getRef_contact ()) {
	$contact = new contact($_SESSION['user']->getRef_contact ());
	$profils 	= $contact->getProfils();
	if (isset($profils[$CLIENT_ID_PROFIL])) {
		$id_tarif = $profils[$CLIENT_ID_PROFIL]->getId_tarif ();
	}
}

//affichage des tarifs
if (isset($_REQUEST['app_tarifs_s'])) {
	$_SESSION["panier_interface_".$_INTERFACE['ID_INTERFACE']]["app_tarifs"] = $_REQUEST['app_tarifs_s'];
}

//ouverture du panier
$GLOBALS['_OPTIONS']['CREATE_DOC']['ref_contact'] = $_SESSION['user']->getRef_contact ();
$liste_contenu = $_SESSION["panier_interface_".$_INTERFACE['ID_INTERFACE']]["contenu"];
$app_tarifs_s = $_SESSION["panier_interface_".$_INTERFACE['ID_INTERFACE']]["app_tarifs"];

if (!$id_tarif) {
	$id_tarif = $_SESSION['magasins'][$ID_MAGASIN]->getId_tarif();
}
$catalogue_client_dir_childs = array();
$catalogue_client_dir_parents = array();
if (isset($_REQUEST['id_catalogue_client_dir'])) {
	//liste des sous-categories du catalogue_dir actuel
	$catalogue_client_dir_childs = $catalogue->charger_catalogue_client_dirs_childs($_REQUEST["id_catalogue_client_dir"]);
	$catalogue_client_dir_parents = $catalogue->charger_catalogue_client_dirs_parents ($_REQUEST["id_catalogue_client_dir"]);
}

// *************************************************
// Résultat de la recherche
$form['page_to_show'] = $search['page_to_show'] = 1;
if (isset($_REQUEST['page_to_show'])) {
	$form['page_to_show'] = $_REQUEST['page_to_show'];
	$search['page_to_show'] = $_REQUEST['page_to_show'];
}
$form['fiches_par_page'] = $search['fiches_par_page'] = $CATALOGUE_RECHERCHE_SHOWED;
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
$form['lib_article'] = "";
if (isset($_REQUEST['lib_article'])) {
	$form['lib_article'] = trim(urldecode($_REQUEST['lib_article']));
	$search['lib_article'] = trim(urldecode($_REQUEST['lib_article']));
}
$nb_fiches = 0;

$fiches = array();
	// Préparation de la requete
	$query_select = "";
	$query_join 	= "";
	$query_where 	= " dispo = 1 ";
	$query_group	= "";
	$query_limit	= (($search['page_to_show']-1)*$search['fiches_par_page']).", ".$search['fiches_par_page'];

	// Lib_article
	if (isset($search['lib_article'])) {
		$libs = explode (" ", $search['lib_article']);
		$query_where 	.= "  && (
											( a.ref_article = '".addslashes($search['lib_article'])."' || 
												ref_oem LIKE '%".addslashes($search['lib_article'])."%' || 
												ref_interne LIKE '%".addslashes($search['lib_article'])."%' ||
												acb.code_barre = '".addslashes($search['lib_article'])."' ) || ";
		$query_join  .=  " LEFT JOIN articles_codes_barres acb ON acb.ref_article = a.ref_article ";
		$query_where 	.= " ( ";
		for ($i=0; $i<count($libs); $i++) {
			$lib = trim($libs[$i]);
			$query_where 	.= " lib_article LIKE '%".addslashes($lib)."%' "; 
			if ( isset($libs[$i+1]) ) { $query_where 	.= " && "; }
		}
		$query_where 	.= " ) )";
	}
	
	// Catégorie
	if (isset($catalogue_client_dir_parents[0]->ref_art_categ)) { 
	//	$query_where 	.= " && a.ref_art_categ = '".$catalogue_client_dir_parents[0]->ref_art_categ."'";
		
		$liste_categories = "";
		$liste_categs = array();
		$liste_categs = get_child_categories ($liste_categs, $catalogue_client_dir_parents[0]->ref_art_categ);
		foreach ($liste_categs as $categ) {
		
			foreach ($list_catalogue_dir as $cat_dir) {
			if ($cat_dir->ref_art_categ != $categ){ continue;}
			if ($liste_categories) { $liste_categories .= ", "; }
			$liste_categories .= " '".$categ."' ";
			}
		}
		$query_where 	.= " && a.ref_art_categ IN ( ".$liste_categories." ) ";
		
	} else {
		//onlimite au catégories autorisées pour l'interface
		if (count($list_catalogue_dir)){
			$tmp_art_categ = array();
			foreach ($list_catalogue_dir as $cat_dir) {$tmp_art_categ[] = "'".$cat_dir->ref_art_categ."'";}
			$query_where 	.= " && a.ref_art_categ IN (".implode(",", $tmp_art_categ).")";
		}
	}

	// Stock 
	if ($_SESSION['magasins'][$ID_MAGASIN]->getId_stock()) {
		$query_select  .= ", sa.qte stock";
		$query_join 	 .= " LEFT JOIN stocks_articles sa ON a.ref_article = sa.ref_article  
												&& sa.id_stock = '".$_SESSION['magasins'][$ID_MAGASIN]->getId_stock()."'";
	}
	
	if ($query_where) { $query_where .= " && "; }
	$query_where 	.= " a.variante != 1";
	
		$query_group  .= " GROUP BY a.ref_article ";
	// Recherche
	$query = "SELECT a.ref_article, a.ref_oem, a.ref_interne, a.lib_article, a.desc_courte,
									 a.ref_constructeur, ann.nom nom_constructeur, a.dispo,
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
		$fiche->tarifs = get_article_tarifs ($fiche->ref_article, $id_tarif);
		$fiches[] = $fiche; 
	}
	unset ($fiche, $resultat, $query);

	// Comptage des résultats
	$query = "SELECT COUNT(a.ref_article) nb_fiches
						FROM articles a 
							".$query_join."
						WHERE ".$query_where."
						".$query_group;
	$resultat = $bdd->query($query); 
	while ($result = $resultat->fetchObject()) { $nb_fiches += 1;}
	unset ($result, $resultat, $query); 



// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_catalogue_liste_articles.inc.php");

?>