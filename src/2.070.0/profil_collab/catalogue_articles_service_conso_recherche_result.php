<?php
// *************************************************************************************************************
// RECHERCHE DES CONSOMMATIONS D'UN ARTICLE
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");




if (!isset($_REQUEST['ref_article'])) {
	echo "La référence de l'article n'est pas précisée";
	exit;
}

$article = new article ($_REQUEST['ref_article']);
if (!$article->getRef_article()) {
	echo "La référence de l'article est inconnue";		exit;

}


// *************************************************************************************************************
// TRAITEMENTS
// *************************************************************************************************************

$ANNUAIRE_CATEGORIES	=	get_categories();
// *************************************************
// Profils à afficher
$profils = array();
foreach ($_SESSION['profils'] as $profil) {
	if ($profil->getActif() == 0) { continue; }
	$profils[] = $profil;
}
unset ($profil);


// *************************************************
// Données pour le formulaire et la recherche
$form['page_to_show'] = $search['page_to_show'] = 1;
if (isset($_REQUEST['page_to_show_s'])) {
	$form['page_to_show'] = $_REQUEST['page_to_show_s'];
	$search['page_to_show'] = $_REQUEST['page_to_show_s'];
}
$form['fiches_par_page'] = $search['fiches_par_page'] = $ANNUAIRE_RECHERCHE_SHOWED_FICHES;
if (isset($_REQUEST['fiches_par_page'])) {
	$form['fiches_par_page'] = $_REQUEST['fiches_par_page'];
	$search['fiches_par_page'] = $_REQUEST['fiches_par_page'];
}
$nb_fiches = 0;
$form['orderby'] = $search['orderby'] = "nom";
if (isset($_REQUEST['orderby'])) {
	$form['orderby'] = $_REQUEST['orderby'];
	$search['orderby'] = $_REQUEST['orderby'];
}
$form['orderorder'] = $search['orderorder'] = "DESC";
if (isset($_REQUEST['orderorder'])) {
	$form['orderorder'] = $_REQUEST['orderorder'];
	$search['orderorder'] = $_REQUEST['orderorder'];
}

$form['nom'] = "";
if (isset($_REQUEST['nom'])) {
	$form['nom'] = trim(urldecode($_REQUEST['nom']));
	$search['nom'] = trim(urldecode($_REQUEST['nom']));
}

$form['id_categorie'] = "";
if (isset($_REQUEST['id_categorie']) && $_REQUEST['id_categorie']) {
	$form['id_categorie'] = trim(urldecode($_REQUEST['id_categorie']));
	$search['id_categorie'] = trim(urldecode($_REQUEST['id_categorie']));
}

$form['id_profil'] = 0;
$form['id_client_categ'] = "";
$form['type_client'] = "";
if (isset($_REQUEST['id_profil'])) {
	$form['id_profil'] = $_REQUEST['id_profil'];
	$search['id_profil'] = $_REQUEST['id_profil'];
	
	if ($CLIENT_ID_PROFIL == $_REQUEST['id_profil']) {
	
		if (isset($_REQUEST['id_client_categ'])) {
			$form['id_client_categ'] = $_REQUEST['id_client_categ'];
			$search['id_client_categ'] = $_REQUEST['id_client_categ'];
		}
		if (isset($_REQUEST['type_client'])) {
			$form['type_client'] = $_REQUEST['type_client'];
			$search['type_client'] = $_REQUEST['type_client'];
		}
		
	}
}

$form['code_postal'] = "";
if (isset($_REQUEST['code_postal'])) {
	$form['code_postal'] = urldecode($_REQUEST['code_postal']);
	$search['code_postal'] = urldecode($_REQUEST['code_postal']);
}


$form['type_recherche'] = 0;
if (isset($_REQUEST['type_recherche'])) {
	$form['type_recherche'] = ($_REQUEST['type_recherche']);
	$search['type_recherche'] = ($_REQUEST['type_recherche']);
}

$form['ref_article'] = 0;
if (isset($_REQUEST['ref_article'])) {
	$form['ref_article'] = ($_REQUEST['ref_article']);
	$search['ref_article'] = ($_REQUEST['ref_article']);
}

// *************************************************
// Résultat de la recherche
$fiches = array();
if (isset($_REQUEST['recherche']) ) {
	// Préparation de la requete
	$query_select 	= "";
	$query_join 	= "";
	$query_join_count 	= "";
	$query_where 	= "";
	$query_limit	= (($search['page_to_show']-1)*$search['fiches_par_page']).", ".$search['fiches_par_page'];

	// Nom
	if ($search['nom']) {
		$libs = explode (" ", $search['nom']);
		$query_where 	.= " ( ";
		for ($i=0; $i<count($libs); $i++) {
			$lib = trim($libs[$i]);
			$query_where 	.= " nom LIKE '%".addslashes($lib)."%' "; 
			if ( isset($libs[$i+1]) ) { $query_where 	.= " && "; }
		}
		$query_where 	.= " ) ";
	}
	//ref_article
	if (isset($search['ref_article'])) {
		if ($query_where) { $query_where .= " && "; }
		$query_where	.= " aa.ref_article = '".($search['ref_article'])."'";
	}
	//id_categorie
	if (isset($search['id_categorie'])) {
		if ($query_where) { $query_where .= " && "; }
		$query_where	.= "id_categorie = '".addslashes($search['id_categorie'])."'";
	}
	// Profils
	if ($search['id_profil']) { 
		$query_join 	.= " LEFT JOIN annuaire_profils ap ON a.ref_contact = ap.ref_contact "; 
		$query_join_count 	.= " LEFT JOIN annuaire_profils ap ON a.ref_contact = ap.ref_contact "; 
		if ($query_where) { $query_where .= " && "; }
		$query_where 	.= "ap.id_profil = '".$search['id_profil']."'";
		
		if ((isset($search['id_client_categ']) || isset($search['type_client']) )  && ($search['id_client_categ'] || $search['type_client'])) { 
			$query_join 	.= " LEFT JOIN annu_client anc ON a.ref_contact = anc.ref_contact "; 
			$query_join_count .= " LEFT JOIN annu_client anc ON a.ref_contact = anc.ref_contact "; 
		}
		if (isset($search['id_client_categ']) && $search['id_client_categ']) { 
			if ($query_where) { $query_where .= " && "; }
			$query_where 	.= " anc.id_client_categ = '".$search['id_client_categ']."'";
		}
		
		if (isset($search['type_client']) && $search['type_client']) { 
			if ($query_where) { $query_where .= " && "; }
			$query_where 	.= " anc.type_client = '".$search['type_client']."'";
		}
		
	}
	//adresse
	if ($search['code_postal']) {
		if ($query_where) { $query_where .= " && "; }
		$query_where	.= "ad.code_postal LIKE '".$search['code_postal']."%'";
		$query_join_count 	.= " LEFT JOIN adresses ad ON a.ref_contact = ad.ref_contact  ";
	}
	
	if ($search['type_recherche']) {
		if ($query_where) { $query_where .= " && "; }
		//abo en cours
		if ($search['type_recherche'] == 1) { $query_where	.= " aa.credits_restants > 0  && aa.date_echeance > NOW() ";}
		//abo à renouveller
		if ($search['type_recherche'] == 2) { $query_where	.= " aa.credits_restants > 0 &&  aa.date_echeance < NOW() ";}
		//abo vide
		if ($search['type_recherche'] == 3) { $query_where	.= " aa.credits_restants <= 0 ";}
	}

	if (!$query_where) { 
		$query_where = 1; 
	}
	

	// Recherche
	$query = "SELECT a.ref_contact, aa.ref_article, aa.id_compte_credit, aa.date_souscription, aa.date_echeance , aa.credits_restants, nom, lib_civ_court, id_categorie,
									 text_adresse, ad.code_postal, ad.ville, ad.ordre, 
									 tel1, tel2, fax,  co.ordre,
									 email, url, si.ordre
									 ".$query_select."
						FROM articles_comptes_credits aa
							LEFT JOIN annuaire a ON a.ref_contact = aa.ref_contact 
							LEFT JOIN civilites c ON a.id_civilite = c.id_civilite 
							LEFT JOIN adresses ad ON a.ref_contact = ad.ref_contact 
							LEFT JOIN coordonnees co ON a.ref_contact = co.ref_contact && co.ordre = 1
							LEFT JOIN sites_web si ON a.ref_contact = si.ref_contact && si.ordre = 1
							".$query_join."
						WHERE ".$query_where." 
						GROUP BY aa.id_compte_credit 
						ORDER BY ".$search['orderby']." ".$search['orderorder'].", aa.date_echeance DESC
						LIMIT ".$query_limit;
	$resultat = $bdd->query($query);
	while ($fiche = $resultat->fetchObject()) { $fiches[] = $fiche; }
	//echo nl2br ($query);
	unset ($fiche, $resultat, $query);

	// Comptage des résultats
	$query = "SELECT aa.id_compte_credit
						FROM articles_comptes_credits aa 
						LEFT JOIN annuaire a ON a.ref_contact = aa.ref_contact 
							".$query_join_count."
						WHERE ".$query_where."
						";
	$resultat = $bdd->query($query);
	$result = $resultat->fetchAll();
	$nb_fiches = count($result);
	//echo "<br><hr>".nl2br ($query);
	unset ($result, $resultat, $query);
}

// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_catalogue_articles_service_conso_recherche_result.inc.php");

?>