<?php
// *************************************************************************************************************
// RECHERCHE DES ABONNEMENTS D'UN ARTICLE
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
	echo "La référence de l'article est inconnue";
	exit;
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
if (isset($_REQUEST['page_to_show'])) {
	$form['page_to_show'] = $_REQUEST['page_to_show'];
	$search['page_to_show'] = $_REQUEST['page_to_show'];
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

$form['ref_client'] = "";
if (isset($_REQUEST['ref_client'])){
	if ($_REQUEST['ref_client']!="") {
		$form['ref_client'] = trim(urldecode($_REQUEST['ref_client']));
		$search['ref_client'] = trim(urldecode($_REQUEST['ref_client']));
	}else{
		$form['ref_client'] = "";
		$search['ref_client'] = "";
	}
}

$form['etat_abo'] = "";
if (isset($_REQUEST['etat_abo'])) {
	$form['etat_abo'] = trim(urldecode($_REQUEST['etat_abo']));
	$search['etat_abo'] = trim(urldecode($_REQUEST['etat_abo']));
}

$form['id_client_categ'] = "";
if (isset($_REQUEST['id_client_categ']) && $_REQUEST['id_client_categ']!=0) {
	$form['id_client_categ'] = trim(urldecode($_REQUEST['id_client_categ']));
	$search['id_client_categ'] = trim(urldecode($_REQUEST['id_client_categ']));
}else{
		$form['id_client_categ'] = "";
		$search['id_client_categ'] = "";
}

$form['date_souscription_min'] = "";
if (isset($_REQUEST['date_souscription_min'])) {
	$form['date_souscription_min'] = trim(urldecode($_REQUEST['date_souscription_min']));
	$search['date_souscription_min'] = trim(urldecode($_REQUEST['date_souscription_min']));
}
$form['date_souscription_max'] = "";
if (isset($_REQUEST['date_souscription_max'])) {
	$form['date_souscription_max'] = trim(urldecode($_REQUEST['date_souscription_max']));
	$search['date_souscription_max'] = trim(urldecode($_REQUEST['date_souscription_max']));
}
$form['date_echeance_min'] = "";
if (isset($_REQUEST['date_echeance_min'])) {
	$form['date_echeance_min'] = trim(urldecode($_REQUEST['date_echeance_min']));
	$search['date_echeance_min'] = trim(urldecode($_REQUEST['date_echeance_min']));
}
$form['date_echeance_max'] = "";
if (isset($_REQUEST['date_echeance_max'])) {
	$form['date_echeance_max'] = trim(urldecode($_REQUEST['date_echeance_max']));
	$search['date_echeance_max'] = trim(urldecode($_REQUEST['date_echeance_max']));
}
$form['date_fin_min'] = "";
if (isset($_REQUEST['date_fin_min'])) {
	$form['date_fin_min'] = trim(urldecode($_REQUEST['date_fin_min']));
	$search['date_fin_min'] = trim(urldecode($_REQUEST['date_fin_min']));
}

$form['date_fin_max'] = "";
if (isset($_REQUEST['date_fin_max'])) {
	$form['date_fin_max'] = trim(urldecode($_REQUEST['date_fin_max']));
	$search['date_fin_max'] = trim(urldecode($_REQUEST['date_fin_max']));
}

$form['adresse_code'] = "";
if (isset($_REQUEST['adresse_code'])) {
	$form['adresse_code'] = trim(urldecode($_REQUEST['adresse_code']));
	$search['adresse_code'] = trim(urldecode($_REQUEST['adresse_code']));
}

$form['adresse_ville'] = "";
if (isset($_REQUEST['adresse_ville'])) {
	$form['adresse_ville'] = trim(urldecode($_REQUEST['adresse_ville']));
	$search['adresse_ville'] = trim(urldecode($_REQUEST['adresse_ville']));
}

$form['adresse_pays'] = "";
if (isset($_REQUEST['adresse_pays'])) {
	$form['adresse_pays'] = trim(urldecode($_REQUEST['adresse_pays']));
	$search['adresse_pays'] = trim(urldecode($_REQUEST['adresse_pays']));
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
	
	//ref_article
	if (isset($search['ref_article'])) {
		if ($query_where) { $query_where .= " && "; }
		$query_where	.= " aa.ref_article = '".($search['ref_article'])."'";
	}
		
	//catégorie de clients
	if ($search['id_client_categ']) {
		if ($query_where) { $query_where .= " && "; }
		$query_join 	.= " LEFT JOIN annu_client ac ON a.ref_contact = ac.ref_contact  ";
		$query_join_count 	.= " LEFT JOIN annu_client ac ON a.ref_contact = ac.ref_contact  ";
		$query_where	.= "ac.id_client_categ  = '".$search['id_client_categ']."'";
	}
	
	//adresse 1
	if ($search['adresse_code']) {
		if ($query_where) { $query_where .= " && "; }
		$query_where	.= "ad.code_postal LIKE '".$search['adresse_code']."%'";
	}
	
	//adresse 2
	if ($search['adresse_ville']) {
		if ($query_where) { $query_where .= " && "; }
		$query_where	.= "ad.ville = '".$search['adresse_ville']."'";
	}
	
	//adresse 3
	if ($search['adresse_ville'] || $search['adresse_code']) { 
		$query_join_count 	.= " LEFT JOIN adresses ad ON a.ref_contact = ad.ref_contact  ";
	}
	
	//adresse 4
	if ($search['adresse_pays']) {
		if ((!$search['adresse_ville']) || (!$search['adresse_code'])) {
			$query_join_count 	.= " LEFT JOIN adresses ad ON a.ref_contact = ad.ref_contact  ";
		}
		$query_join 	.= " LEFT JOIN pays p ON ad.id_pays = p.id_pays  ";
		$query_join_count 	.= " LEFT JOIN pays p ON ad.id_pays = p.id_pays  ";
		if ($query_where) { $query_where .= " && "; }
		$query_where	.= "p.pays = '".$search['adresse_pays']."'";
	}
	
	// etat abonnement :
	// 0 : TOUS
	// 1 : Abonnements en cours
	// 2 : Abonnements échus, à renouveller
	// 3 : Abonnements terminés
	if ($search['etat_abo']) {
		if ($query_where) { $query_where .= " && "; }
		// 1 : Abonnements en cours
		if ($search['etat_abo'] == 1) { $query_where	.= " aa.date_echeance > NOW() ";}
		// 2 : Abonnements échus, à renouveller
		if ($search['etat_abo'] == 2) { $query_where	.= " (aa.fin_abonnement > NOW() || aa.fin_abonnement = '0000-00-00 00:00:00') && aa.date_echeance < NOW()  ";}
		// 3 : Abonnements terminés
		if ($search['etat_abo'] == 3) { $query_where	.= " aa.fin_abonnement < NOW() && aa.fin_abonnement != '0000-00-00 00:00:00'";}
	}
	
	//date de souscription
	if($search['date_souscription_min']){
		$query_where	.= " && aa.date_souscription > '".date_Fr_to_Us($search['date_souscription_min'])." 00:00:00'";
	}
	if($search['date_souscription_max']){
		$query_where	.= " && aa.date_souscription < '".date_Fr_to_Us($search['date_souscription_max'])." 00:00:00'";
	}
	
	//date de echeance
	if($search['date_echeance_min']){
		$query_where	.= " && aa.date_echeance > '".date_Fr_to_Us($search['date_echeance_min'])." 00:00:00'";
	}

	if($search['date_echeance_max']){
		$query_where	.= " && aa.date_echeance < '".date_Fr_to_Us($search['date_echeance_max'])." 00:00:00'";
	}
	
	//date de fin
	if($search['date_fin_min']){
		$query_where	.= " && aa.fin_abonnement > '".date_Fr_to_Us($search['date_fin_min'])." 00:00:00'";
	}
	if($search['date_fin_max']){
		$query_where	.= " && aa.fin_abonnement < '".date_Fr_to_Us($search['date_fin_max'])." 00:00:00'";
	}

	//ref_client
	if ($search['ref_client']) {
		if ($query_where) { $query_where .= " && "; }
		$query_where	.= "a.ref_contact = '".addslashes($search['ref_client'])."'";
	}
		
	if (!$query_where) { 
		$query_where = 1; 
	}
	

	// Recherche
	$query = "SELECT 	a.ref_contact, aa.ref_article, aa.id_abo, aa.date_souscription, aa.date_echeance , aa.date_preavis, aa.fin_engagement, aa.fin_abonnement, 
										nom, lib_civ_court, id_categorie, amsa.reconduction,ad.text_adresse, ad.code_postal, ad.ville, ad.ordre, tel1, tel2, fax,  co.ordre,
									 email, url, si.ordre
									 ".$query_select."
						FROM articles_abonnes aa
							LEFT JOIN articles_modele_service_abo amsa ON amsa.ref_article = aa.ref_article 
							LEFT JOIN annuaire a ON a.ref_contact = aa.ref_contact 
							LEFT JOIN civilites c ON a.id_civilite = c.id_civilite
							LEFT JOIN coordonnees co ON a.ref_contact = co.ref_contact && co.ordre = 1
							LEFT JOIN adresses ad ON a.ref_contact = ad.ref_contact  
							LEFT JOIN sites_web si ON a.ref_contact = si.ref_contact && si.ordre = 1
							".$query_join."
						WHERE ".$query_where." 
						GROUP BY aa.id_abo 
						ORDER BY ".$search['orderby']." ".$search['orderorder'].", aa.date_echeance DESC
						LIMIT ".$query_limit;
	
	//echo $query; 

	$resultat = $bdd->query($query);
	while ($fiche = $resultat->fetchObject()) { $fiches[] = $fiche; }
	//echo nl2br ($query);
	unset ($fiche, $resultat, $query);

	// Comptage des résultats
	$query = "SELECT aa.id_abo
						FROM articles_abonnes aa 
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

include ($DIR.$_SESSION['theme']->getDir_theme()."page_catalogue_articles_service_abo_recherche_result.inc.php");

?>