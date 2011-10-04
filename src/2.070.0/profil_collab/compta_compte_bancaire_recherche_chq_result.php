<?php
// *************************************************************************************************************
// Recherche BANCAIRE chèque remisés
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");


//chargement des comptes bancaires
$compte_bancaire	= new compte_bancaire($_REQUEST["id_compte_bancaire"]);


// *************************************************
// Données pour le formulaire && la requete
$form['page_to_show'] = $search['page_to_show'] = 1;
if (isset($_REQUEST['page_to_show'])) {
	$form['page_to_show'] = $_REQUEST['page_to_show'];
	$search['page_to_show'] = $_REQUEST['page_to_show'];
}
$form['fiches_par_page'] = $search['fiches_par_page'] = $COMPTE_OPERATIONS_RECHERCHE_SHOWED_FICHES;
if (isset($_REQUEST['fiches_par_page'])) {
	$form['fiches_par_page'] = $_REQUEST['fiches_par_page'];
	$search['fiches_par_page'] = $_REQUEST['fiches_par_page'];
}

$form['orderby'] = $search['orderby'] = "date_depot";
if (isset($_REQUEST['orderby'])) {
	$form['orderby'] = $_REQUEST['orderby'];
	$search['orderby'] = $_REQUEST['orderby'];
}

$form['orderorder'] = $search['orderorder'] = "DESC";
if (isset($_REQUEST['orderorder'])) {
	$form['orderorder'] = $_REQUEST['orderorder'];
	$search['orderorder'] = $_REQUEST['orderorder'];
}

$form['id_compte_bancaire'] = $search['id_compte_bancaire'] = "";
if (isset($_REQUEST['id_compte_bancaire']) && $_REQUEST['id_compte_bancaire'] != "") {
	$form['id_compte_bancaire'] = $_REQUEST['id_compte_bancaire'];
	$search['id_compte_bancaire'] = $_REQUEST['id_compte_bancaire'];
}

$form['date_fin'] = $search['date_fin'] = 0;
if (isset($_REQUEST['date_fin']) && $_REQUEST['date_fin'] != "") {
	$form['date_fin'] = date_Fr_to_Us($_REQUEST['date_fin'])." 23:59:59";
	$search['date_fin'] = date_Fr_to_Us($_REQUEST['date_fin'])." 23:59:59";
}

$form['date_debut'] = $search['date_debut'] = 0;
if (isset($_REQUEST['date_debut']) && $_REQUEST['date_debut'] != "") {
	$form['date_debut'] = date_Fr_to_Us($_REQUEST['date_debut']);
	$search['date_debut'] = date_Fr_to_Us($_REQUEST['date_debut']);
}

$form['nom_porteur'] = $search['nom_porteur'] = "";
if (isset($_REQUEST['nom_porteur']) && $_REQUEST['nom_porteur'] != "") {
	$form['nom_porteur'] = trim(urldecode($_REQUEST['nom_porteur']));
	$search['nom_porteur'] = trim(urldecode($_REQUEST['nom_porteur']));
}

$form['num_cheque'] = $search['num_cheque'] = "";
if (isset($_REQUEST['num_cheque']) && $_REQUEST['num_cheque'] != "") {
	$form['num_cheque'] = trim(urldecode($_REQUEST['num_cheque']));
	$search['num_cheque'] = trim(urldecode($_REQUEST['num_cheque']));
}

$form['banque'] = $search['banque'] = "";
if (isset($_REQUEST['banque']) && $_REQUEST['banque'] != "") {
	$form['banque'] = trim(urldecode($_REQUEST['banque']));
	$search['banque'] = trim(urldecode($_REQUEST['banque']));
}

$form['montant'] = $search['montant'] = 0;
if (isset($_REQUEST['montant']) && $_REQUEST['montant'] != "") {
	$form['montant'] = abs(convert_numeric(str_replace(" ","",$_REQUEST['montant'])));
	$search['montant'] = abs(convert_numeric(str_replace(" ","",$_REQUEST['montant'])));
}

$form['delta_montant'] = $search['delta_montant'] = 0;
if (isset($_REQUEST['delta_montant']) && $_REQUEST['delta_montant'] != "") {
	$form['delta_montant'] = abs(convert_numeric($_REQUEST['delta_montant']));
	$search['delta_montant'] = abs(convert_numeric($_REQUEST['delta_montant']));
}

$nb_fiches = 0;

// *************************************************
// Résultat de la recherche
$fiches = array();
if (isset($_REQUEST['recherche'])) {
	// Préparation de la requete
	$query_join 	= "";
	$query_having = "";
	$query_where 	= "";
	$query_where2 	= "";
	
	if ($search['id_compte_bancaire']) {
		$query_where 	.= " && id_compte_bancaire_destination = '".$search['id_compte_bancaire']."' ";
	}
	
	if ($search['date_fin']) {
		$query_where 	.= " && date_depot < '".$search['date_fin']."' ";
	}
	if ($search['date_debut']) {
		$query_where 	.= " &&  date_depot > '".$search['date_debut']."' ";
	}
	
	if ($search['montant']) {
		$query_where .= " &&    ( ABS(ccdm.montant_depot) <= '".($search['montant']+$search['delta_montant'])."' &&
															 ABS(ccdm.montant_depot) >= '".($search['montant']-$search['delta_montant'])."' )";
															 
		$query_where2 .= " &&    ( ABS(ccc.montant_contenu) <= '".($search['montant']+$search['delta_montant'])."' &&
															 ABS(ccc.montant_contenu) >= '".($search['montant']-$search['delta_montant'])."' )";
	}
	
	
	if ($search['nom_porteur']) {
		$query_where2 .= " &&  rec.info_compte LIKE '%".$search['nom_porteur']."%' ";
	}
	if ($search['num_cheque']) {
		$query_where2 .= " &&  rec.numero_cheque LIKE '%".$search['num_cheque']."%' ";
	}
	if ($search['banque']) {
		$query_where2 .= " &&  rec.info_banque LIKE '%".$search['banque']."%' ";
	}
	



	// Recherche
	
	$query = "SELECT ccdm.id_compte_caisse_depot, ccdm.id_reglement_mode, ccdm.montant_depot, ccdm.infos_depot,
										ccd.id_compte_bancaire_destination, ccd.id_compte_caisse_source, ccd.date_depot, ccd.num_remise
						FROM comptes_caisses_depots_montants ccdm
						LEFT JOIN comptes_caisses_depots ccd ON ccd.id_compte_caisse_depot = ccdm.id_compte_caisse_depot
						
						WHERE id_reglement_mode = '".$CHQ_E_ID_REGMT_MODE."' ".$query_where."
						ORDER BY ".$search['orderby']." ".$search['orderorder']."
						";
	$resultat = $bdd->query ($query);
	while ($fiche = $resultat->fetchObject()) { 
		$infos = explode (";", $fiche->infos_depot);
		$fiche->reference = $infos[0];
		$fiche->numero = $infos[1];
		$fiche->banque = $infos[2];
		$fiche->porteur = $infos[3];
		if ( $search['nom_porteur'] && !substr_count(strtolower($fiche->porteur), strtolower($search['nom_porteur'])) ) { continue; }
		if ( $search['num_cheque'] && !substr_count(strtolower($fiche->numero), strtolower($search['num_cheque'])) ) { continue; }
		if ( $search['banque'] && !substr_count(strtolower($fiche->banque), strtolower($search['banque'])) ) { continue; }
		$fiches[] = $fiche; 
	}
	//echo nl2br ($query);
	unset ($fiche, $resultat, $query);
	
	$nb_fiches = count($fiches); 
	
	$fiches2 = array();
	if (!count($fiches)) {
		//on recherche dans les contenus de caisses si on a rien trouvé dans les remises
		$query = "SELECT ccc.id_compte_caisse, ccc.id_reglement_mode, ccc.montant_contenu, ccc.infos_supp, ccc.controle, 
										rec.ref_reglement, rec.numero_cheque, rec.info_banque, rec.info_compte,
										r.ref_contact, r.date_saisie,
										cc.lib_caisse
							FROM comptes_caisses_contenu ccc 
							LEFT JOIN reglements r ON r.ref_reglement = ccc.infos_supp
							LEFT JOIN regmt_e_chq rec ON rec.ref_reglement = r.ref_reglement
							LEFT JOIN comptes_caisses cc ON cc.id_compte_caisse = ccc.id_compte_caisse
							WHERE  ccc.id_reglement_mode = '".$CHQ_E_ID_REGMT_MODE."' ".$query_where2." 
							";
		$resultat = $bdd->query($query);
		while ($total = $resultat->fetchObject()) { $fiches2[] = $total;}
		
		
		$nb_fiches = count($fiches2); 
	}
	
	
}


// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_compta_compte_bancaire_recherche_chq_result.inc.php");

?>