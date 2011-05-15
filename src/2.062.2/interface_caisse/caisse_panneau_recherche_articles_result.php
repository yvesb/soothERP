<?php
// *************************************************************************************************************
// [COLLABORATEUR] RECHERCHE D'UN ARTICLE POUR INSERTION DANS UN DOCUMENT
// *************************************************************************************************************



if(isset($NoHeader_caisse_panneau_recherche_articles_result) && $NoHeader_caisse_panneau_recherche_articles_result){

	$form['art_lib_s'] = "";
	$search['art_lib_s'] = "";
	$form['categ_ref_selected_s'] = "";
	$search['categ_ref_selected_s'] = "";

	// Ouverture du document
	if (!isset($art_page_to_show_s)) {
		echo "la variable 'art_page_to_show_s' n'est pas spécifiée";
		exit;
	}
	$form['art_page_to_show_s'] = $search['art_page_to_show_s'] = $art_page_to_show_s;
	unset($art_page_to_show_s);
	
	if(isset($art_lib_s)) {
		$form['art_lib_s'] = $search['art_lib_s'] = $art_lib_s;
	}
	unset($art_lib_s);

	
	if (isset($categ_ref_selected_s)) {
		$form['categ_ref_selected_s'] = $search['categ_ref_selected_s'] = $categ_ref_selected_s;
	}
	unset($categ_ref_selected_s);
	
	//@TODO FIXER LE NB DE ARTICLE PAR PAGE
	$form['articles_par_page'] = $search['articles_par_page'] = 999999;

}else{
	require ("_dir.inc.php");
	require ("_profil.inc.php");
	require ("_session.inc.php");

	$form['art_lib_s'] = "";
	$search['art_lib_s'] = "";
	$form['categ_ref_selected_s'] = "";
	$search['categ_ref_selected_s'] = "";

	// Ouverture du document
	if (!isset($_REQUEST['art_page_to_show_s'])) {
		echo "La référence du document n'est pas spécifié";
		exit;
	}
	$form['art_page_to_show_s'] = $search['art_page_to_show_s'] = $_REQUEST['art_page_to_show_s'];

	if (isset($_REQUEST['art_lib_s'])) {
		$form['art_lib_s'] = trim(rawurldecode($_REQUEST['art_lib_s']));
		$search['art_lib_s'] = trim(rawurldecode($_REQUEST['art_lib_s']));
	}
	
	if (isset($_REQUEST["categ_ref_selected_s"])) {
		$form['categ_ref_selected_s'] = $_REQUEST['categ_ref_selected_s'];
		$search['categ_ref_selected_s'] = $_REQUEST['categ_ref_selected_s'];
	}

	//@TODO FIXER LE NB DE ARTICLE PAR PAGE
	$form['articles_par_page'] = $search['articles_par_page'] = 999999;
}

// *************************************************************************************************************
// TRAITEMENTS
// *************************************************************************************************************


$nb_articles = 0;

// *************************************************
// Stock et Tarif affichés
$form['id_stock'] = $search['id_stock'] = $_SESSION['magasin']->getId_stock();

// *************************************************
// Résultat de la recherche
$t_articles = array();

// Préparation de la requete
$query_join 	= "";
$query_where 	= " dispo = 1 && a.variante != 2 ";
$query_limit	= (($search['art_page_to_show_s']-1)*$search['articles_par_page']).", ".$search['articles_par_page'];

// Stock 
$query_join 	.= " LEFT JOIN stocks_articles sa ON a.ref_article = sa.ref_article && sa.id_stock = '".$search['id_stock']."' ";

// Lib_article
if ($search['art_lib_s']) {
	$query_join .= " LEFT JOIN articles_codes_barres acb ON acb.ref_article = a.ref_article ";
	$libs = explode (" ", $search['art_lib_s']);
	$query_where 	.= "  && (
										( a.ref_article = '".addslashes($search['art_lib_s'])."' || 
											ref_oem LIKE '%".addslashes($search['art_lib_s'])."%' || 
											ref_interne LIKE '%".addslashes($search['art_lib_s'])."%' ||
											acb.code_barre = '".addslashes($search['art_lib_s'])."' ) || ";
	$query_where 	.= " ( ";
	for ($i=0; $i<count($libs); $i++) {
		$lib = trim($libs[$i]);
		$query_where 	.= " lib_article LIKE '%".addslashes($lib)."%' "; 
		if ( isset($libs[$i+1]) ) { $query_where 	.= " && "; }
	}
	$query_where 	.= " ) )";
}

// Catégorie
if ($search['categ_ref_selected_s']) { 
	$liste_categories = "";
	$liste_categs = array();
	$liste_categs = get_child_categories ($liste_categs, $search['categ_ref_selected_s']);
	foreach ($liste_categs as $categ) {
		if ($liste_categories) { $liste_categories .= ", "; }
		$liste_categories .= " '".$categ."' ";
	}
	
	$query_join .= "LEFT JOIN art_categs ac ON a.ref_art_categ = ac.ref_art_categ";
	$query_where.= "&&			a.ref_art_categ IN ( ".$liste_categories." )
									&&			ac.modele <> 'service_abo' ";
}

// Ajustement pour faire fonctionner le comptage
$count_query_join = $query_join;

// Recherche
$query = "SELECT a.ref_article, a.ref_oem, a.ref_interne, a.lib_article, a.desc_courte
					FROM articles a
					".$query_join."
					WHERE ".$query_where."
					GROUP BY a.ref_article 
					ORDER BY a.lib_article ASC
					LIMIT ".$query_limit; 


//echo "<br/>".nl2br($query)."<br/><hr/><br/>";

$resultat = $bdd->query($query); 
while ($res = $resultat->fetchObject()) {
	$t_articles[] = new article($res->ref_article);
}
unset ($res, $resultat, $query);



// ***************************************************************************************
if(count($t_articles) == 1 && isset($_REQUEST["ajout_si_article_unique"]) && $_REQUEST["ajout_si_article_unique"]){// UN SEUL ARTICLE -> on ajout cet article au ticket

	$article =  $t_articles[0];
	$ref_article = $article->getRef_article();
		
	$document = null;
	if(isset( $_REQUEST['ref_ticket'] ) && $_REQUEST['ref_ticket'] != ""){
		$document = open_doc($_REQUEST['ref_ticket']);
	}else{	//Nouveau Ticket de caisse
	
		// Par précotion, on efface toutes les variables de création de documents
		unset($GLOBALS['_OPTIONS']['CREATE_DOC']);
	
		$document = create_doc($TICKET_CAISSE_ID_TYPE_DOC);
	
		if (isset($_REQUEST['ref_contact']) && $_REQUEST['ref_contact'] != "") {
			$contact = new contact($_REQUEST['ref_contact']);
			$document->maj_contact($contact->getRef_contact());
			
			$adresses = $contact->getAdresses();
			if(count($adresses)>0)
				{$document->maj_adresse_contact($adresses[0]->getRef_adresse());}
			unset($contact, $adresses);
		}
	}
	
	//AJOUT D'UNE LIGNE
	//structure du tableau $infos
	$infos = array();
	$infos['type_of_line']	=	"article";
	$infos['sn']						= array();
	if (isset($_REQUEST['num_serie']) && $_REQUEST['num_serie'] != "") {
		$infos['sn'][]					=	$_REQUEST['num_serie'];
	}
	$infos['ref_article']		=	$ref_article;
	$infos['qte']						=	1;
	
	unset($GLOBALS['_INFOS']['new_lines']);
	$document->add_line($infos);
	
	foreach ($GLOBALS['_INFOS']['new_lines'] as $new_line){
		if ($new_line->ref_doc_line_parent == null){//substr($new_line->ref_article, 0, 2) == "A-" && 
			$ligne = $new_line;
			break;
		}
	}
	unset($GLOBALS['_INFOS']['new_lines']);
	
	document::maj_line_lib_article($ligne->ref_doc_line, $article->getLib_ticket());
	$ligne->lib_article = $article->getLib_ticket(); 
	
	unset($article);
	
	$montant_to_pay = $document->getMontant_to_pay();
	
	include ($DIR.$_SESSION['theme']->getDir_theme()."page_caisse_ajouter_article.inc.php");

	
}else{// ***************************************************************************************

	// Comptage des résultats
	$query = "SELECT a.ref_article
						FROM articles a
						".$query_join."
						WHERE ".$query_where."
						GROUP BY a.ref_article";
	
	//echo "<br/>".nl2br($query)."<br/><hr/><br/>";
		
	$resultat = $bdd->query($query); 
	while ($result = $resultat->fetchObject()) { $nb_articles += 1; }
	unset ($result, $resultat, $query);

	//echo "nb_fiches :".$nb_articles;
	
	// *************************************************************************************************************
	// AFFICHAGE
	// *************************************************************************************************************
	
	//$page_variables = array ("_ALERTES", "t_articles", "form['art_lib_s']", "form['art_page_to_show_s']", "form['articles_par_page']", "nb_articles", "form['categ_ref_selected_s']");

	include ($DIR.$_SESSION['theme']->getDir_theme()."page_caisse_panneau_recherche_articles_result.inc.php");
}
?>