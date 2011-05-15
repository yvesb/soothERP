<?php
// *************************************************************************************************************
// [ADMINISTRATEUR] RECHERCHE D'UNE FICHE DE CONTACT
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");



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
//$form['profils'] = array();
//if (isset($_REQUEST['profils'])) {
//	$form['profils'] = $_REQUEST['profils'];
//	$search['profils'] = "";
//	if (count($form['profils']) && !isset($form['profils'][0]) ) {
//		foreach ($_REQUEST['profils'] as $id_profil => $var) {
//			if ($search['profils']) { $search['profils'] .= "||"; }
//			$search['profils'] .= " id_profil = '".$id_profil."' ";
//		}
//	}
//}

$form['code_postal'] = "";
if (isset($_REQUEST['code_postal'])) {
	$form['code_postal'] = urldecode($_REQUEST['code_postal']);
	$search['code_postal'] = urldecode($_REQUEST['code_postal']);
}
$form['ville'] = 0;
if (isset($_REQUEST['ville'])) {
	$form['ville'] = urldecode($_REQUEST['ville']);
	$search['ville'] = urldecode($_REQUEST['ville']);
}

$form['pays'] = 0;
$id_pays = 0;
if (isset($_REQUEST['pays'])) {
	$form['pays'] = urldecode($_REQUEST['pays']);
	$search['pays'] = urldecode($_REQUEST['pays']);
	$query = "SELECT id_pays FROM pays WHERE pays like '%".addslashes($search['pays'])."%' ";
$resultat1 = $bdd->query($query);
while ($pays = $resultat1->fetchObject()) { 
$id_pays = $pays->id_pays;
}

}

$form['tel'] = "";
if (isset($_REQUEST['tel'])) {
	$form['tel'] = urldecode($_REQUEST['tel']);
	$search['tel'] = urldecode($_REQUEST['tel']);
}
$form['email'] = "";
if (isset($_REQUEST['email'])) {
	$form['email'] = urldecode($_REQUEST['email']);
	$search['email'] = urldecode($_REQUEST['email']);
}
$form['url'] = "";
if (isset($_REQUEST['url'])) {
	$form['url'] = urldecode($_REQUEST['url']);
	$search['url'] = urldecode($_REQUEST['url']);
}

// Recherche dans les archives && $_REQUEST['archive']
$form['archive'] = $search['archive'] = false;
if (isset($_REQUEST['archive']) && $_REQUEST['archive'] == true) {
	$form['archive'] = true;
	$search['archive'] = true;
}





// *************************************************
// Résultat de la recherche
$fiches = array();
if (isset($_REQUEST['recherche'])) {
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
	//id_categorie
	if (isset($search['id_categorie'])) {
		if ($query_where) { $query_where .= " && "; }
		$query_where	.= "id_categorie = '".addslashes($search['id_categorie'])."'";
	}
	// Profils
	if ($search['id_profil'] != 'ALL') { 
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
			if ($search['pays']) {
			if ($query_where) { $query_where .= " && "; }
			$query_where	.= "ad.id_pays = $id_pays ";
		}

	
	if ($search['ville']) {
		if ($query_where) { $query_where .= " && "; }
		$query_where	.= "ad.ville LIKE '%".addslashes($search['ville'])."%'";
	}

	if ($search['code_postal']) {
		if ($query_where) { $query_where .= " && "; }
		$query_where	.= "ad.code_postal LIKE '".$search['code_postal']."%'";
	}
	if ($search['ville'] || $search['code_postal'] || $search['pays'] ) {

		$query_join_count 	.= " LEFT JOIN adresses ad ON a.ref_contact = ad.ref_contact  ";
	}
	
	// Coordonnées
	if ($search['tel']) {
		if ($query_where) { $query_where .= " && "; }
		$query_where .= "(tel1 LIKE '%".$search['tel']."%' || tel2 LIKE '%".$search['tel']."%' || fax LIKE '%".$search['tel']."%')";
	}
	if ($search['email']) {
		if ($query_where) { $query_where .= " && "; }
		$query_where	.= "email LIKE '%".$search['email']."%'"; 
	}
	if ($search['tel'] || $search['email']) {
		$query_join_count 	.= " LEFT JOIN coordonnees co ON a.ref_contact = co.ref_contact ";
	}
	// Site
	if ($search['url']) {
		if ($query_where) { $query_where .= " && "; }
		$query_where	.= "url LIKE '%".$search['url']."%'"; 
		$query_join_count 	.= " LEFT JOIN sites_web si ON a.ref_contact = si.ref_contact ";
	}

	// Recherche dans les archives
	if (!$search['archive']) {
		if ($query_where) { $query_where .= " && "; }
		$query_where	.= "date_archivage IS NULL "; 
	}

	if (!$query_where) { 
		$query_where = 1; 
	}
	
	// Recherche
	$query = "SELECT a.ref_contact, nom, lib_civ_court, id_categorie, ad.id_type_adresse,
									 text_adresse, ad.code_postal, ad.ville, ad.ordre, 
									 tel1, tel2, fax,  co.ordre, co.id_type_coordonnee, si.id_type_site_web,
									 email, url, si.ordre
									 ".$query_select."
						FROM annuaire a 
							LEFT JOIN civilites c ON a.id_civilite = c.id_civilite 
							LEFT JOIN adresses ad ON a.ref_contact = ad.ref_contact 
							LEFT JOIN coordonnees co ON a.ref_contact = co.ref_contact && co.ordre = 1
							LEFT JOIN sites_web si ON a.ref_contact = si.ref_contact && si.ordre = 1
							".$query_join."
						WHERE ".$query_where." 
						GROUP BY a.ref_contact
						ORDER BY ".$search['orderby']." ".$search['orderorder'].", ad.ordre ASC, co.ordre ASC, si.ordre ASC
						LIMIT ".$query_limit;
	$resultat = $bdd->query($query);
	while ($fiche = $resultat->fetchObject()) { $fiches[] = $fiche; }
	//echo nl2br ($query);
	unset ($fiche, $resultat, $query);
	
	$ref_user = $_SESSION['user']->getRef_user();
	$droitsVoirAdresses = getDroitVoirAdresse($ref_user);
	$droitsVoirCoord = getDroitVoirCoordonnees($ref_user);
	$droitsVoirSite = getDroitVoirSiteWeb($ref_user);
	
	//_vardump($fiches);
	//Gestion des droits affichage addresse------------------------------
	if(count($droitsVoirAdresses)>0){
		if($droitsVoirAdresses[0] != "ALL"){
			for($i=0;$i<count($fiches);$i++){
				if($fiches[$i]->id_type_adresse != "" && $fiches[$i]->id_type_adresse != 0){
					if (!in_array($fiches[$i]->id_type_adresse,$droitsVoirAdresses)){
						$fiches[$i]->text_adresse = "";
						$fiches[$i]->code_postal = "";
						$fiches[$i]->ville = "";
					}
				}
			}
		}
	}else{
		for($i=0;$i<count($fiches);$i++){
			if($fiches[$i]->id_type_adresse != "" && $fiches[$i]->id_type_adresse != 0){
				$fiches[$i]->text_adresse = "";
				$fiches[$i]->code_postal = "";
				$fiches[$i]->ville = "";
			}
		}		
	}
	//FIN Gestion des droits affichage addresse---------------------------
	//Gestion des droits affichage coordonnees----------------------------
	if(count($droitsVoirCoord)>0){
		if($droitsVoirCoord[0] != "ALL"){
			for($i=0;$i<count($fiches);$i++){
				if($fiches[$i]->id_type_coordonnee != "" && $fiches[$i]->id_type_coordonnee != 0){
					if (!in_array($fiches[$i]->id_type_coordonnee,$droitsVoirCoord)){
						$fiches[$i]->tel1 = "";
						$fiches[$i]->tel2 = "";
						$fiches[$i]->fax = "";
						$fiches[$i]->email = "";
					}
				}
			}
		}
	}else{
		for($i=0;$i<count($fiches);$i++){
			if($fiches[$i]->id_type_coordonnee != "" && $fiches[$i]->id_type_coordonnee != 0){
				$fiches[$i]->tel1 = "";
				$fiches[$i]->tel2 = "";
				$fiches[$i]->fax = "";
				$fiches[$i]->email = "";
			}
		}		
	}
	//FIN Gestion des droits affichage coordonnees-----------------------
	//Gestion des droits affichage site web------------------------------
	if(count($droitsVoirSite)>0){
		if($droitsVoirSite[0] != "ALL"){
			for($i=0;$i<count($fiches);$i++){
				if($fiches[$i]->id_type_site_web != "" && $fiches[$i]->id_type_site_web != 0){
					if (!in_array($fiches[$i]->id_type_site_web,$droitsVoirSite)){
						$fiches[$i]->url = "";
					}
				}
			}
		}
	}else{
		for($i=0;$i<count($fiches);$i++){
			if($fiches[$i]->id_type_site_web != "" && $fiches[$i]->id_type_site_web != 0){
				$fiches[$i]->url = "";
			}
		}		
	}
	//FIN Gestion des droits affichage site web---------------------------

	
	// Comptage des résultats
	$query = "SELECT a.ref_contact
						FROM annuaire a 
							".$query_join_count."
						WHERE ".$query_where."
						GROUP BY a.ref_contact";
	$resultat = $bdd->query($query);
	$result = $resultat->fetchAll();
	$nb_fiches = count($result);
	// echo $query; exit(1);
	//echo "<br><hr>".nl2br ($query);
	unset ($result, $resultat, $query);
}


// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_annuaire_recherche_avancee_result.inc.php");

?>