<?php
// *************************************************************************************************************
// Mouvements des caisses RESULTAT
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
$form['fiches_par_page'] = $search['fiches_par_page'] = $COMPTE_OPERATIONS_RECHERCHE_SHOWED_FICHES;
if (isset($_REQUEST['fiches_par_page'])) {
	$form['fiches_par_page'] = $_REQUEST['fiches_par_page'];
	$search['fiches_par_page'] = $_REQUEST['fiches_par_page'];
}

$nb_fiches = 0;


$form['date_debut'] = "" ;
if (isset($_REQUEST['date_debut'])) {
	$form['date_debut'] = $_REQUEST['date_debut'];
	$search['date_debut'] = $_REQUEST['date_debut'];
}

$form['date_fin'] = "" ;
if (isset($_REQUEST['date_fin'])) {
	$form['date_fin'] = $_REQUEST['date_fin'];
	$search['date_fin'] = $_REQUEST['date_fin'];
}


// *************************************************
// Résultat de la recherche
$fiches = array();
if (isset($_REQUEST['recherche'])) {
	// Préparation de la requete
	$query_select = "";
	$query_join 	= "";
	$query_where 	= " ";
	$query_group	= " GROUP BY rec.ref_reglement ";
	$query_limit	= (($search['page_to_show']-1)*$search['fiches_par_page']).", ".$search['fiches_par_page'];
	
	if ($search['date_debut']) {
		if ($query_where) { $query_where .= " &&  "; }
		$query_where .=  " r.date_reglement >= '".date_Fr_to_Us($search['date_debut'])." 00:00:00' "; 
	}
	if ($search['date_fin']) {
		if ($query_where) { $query_where .= " &&  "; }
		$query_where .=  " r.date_reglement <= '".date_Fr_to_Us($search['date_fin'])." 23:59:59' "; 
	}
	

if (isset($_REQUEST["id_compte_tp"]) && isset($_REQUEST["tp_type"]) && $_REQUEST["tp_type"] == "TPE" ) {
	//on traite un TPE
	$query = "
						SELECT rec.ref_reglement, ccm.id_compte_caisse, 
									 r.ref_contact, r.date_saisie, r.montant_reglement, r.date_reglement,
									 rd.ref_doc,
									 rm.lib_reglement_mode, rm.abrev_reglement_mode,
									 cc.lib_caisse,
									 u.pseudo, 
									 a.nom
									 ".$query_select."
	
						FROM regmt_e_cb rec
							LEFT JOIN reglements r ON r.ref_reglement = rec.ref_reglement
							LEFT JOIN reglements_modes rm ON r.id_reglement_mode = rm.id_reglement_mode
							LEFT JOIN reglements_docs rd ON r.ref_reglement = rd.ref_reglement
							LEFT JOIN comptes_caisses_moves ccm ON ccm.id_compte_caisse_move = rec.id_compte_caisse_move
							LEFT JOIN comptes_caisses cc ON cc.id_compte_caisse = ccm.id_compte_caisse
							LEFT JOIN users u ON u.ref_user = ccm.ref_user
							LEFT JOIN annuaire a ON a.ref_contact = r.ref_contact
							
						WHERE  rec.id_compte_tpe_dest = '".$_REQUEST["id_compte_tp"]."'   && r.valide = '1' ".$query_where."
						".$query_group."
						ORDER BY r.date_reglement DESC
						LIMIT ".$query_limit;
						
						
	$resultat = $bdd->query($query);
	//echo $query;
	while ($fiche = $resultat->fetchObject()) {
		$fiches[] = $fiche; 
	}
	unset ($fiche, $resultat, $query);
 //print_r($fiches);
	// Comptage des résultats
	$query = "SELECT DISTINCT(rec.ref_reglement) 
						FROM regmt_e_cb rec
							LEFT JOIN reglements r ON r.ref_reglement = rec.ref_reglement
							LEFT JOIN reglements_modes rm ON r.id_reglement_mode = rm.id_reglement_mode
							LEFT JOIN reglements_docs rd ON r.ref_reglement = rd.ref_reglement
							LEFT JOIN comptes_caisses_moves ccm ON ccm.id_compte_caisse_move = rec.id_compte_caisse_move
							LEFT JOIN comptes_caisses cc ON cc.id_compte_caisse = ccm.id_compte_caisse
							LEFT JOIN users u ON u.ref_user = ccm.ref_user
							LEFT JOIN annuaire a ON a.ref_contact = r.ref_contact
							
						WHERE   rec.id_compte_tpe_dest = '".$_REQUEST["id_compte_tp"]."'   && r.valide = '1' ".$query_where."
						".$query_group;
	$resultat = $bdd->query($query); 
	while ($result = $resultat->fetchObject()) { $nb_fiches ++; }
	unset ($result, $resultat, $query);
}

if (isset($_REQUEST["id_compte_tp"]) && isset($_REQUEST["tp_type"]) && $_REQUEST["tp_type"] == "TPV"  ) {
	//on traite un TPV
	$query = "
						SELECT rec.ref_reglement,
									 r.ref_contact, r.date_saisie, r.montant_reglement, r.date_reglement,
									 rd.ref_doc,
									 rm.lib_reglement_mode, rm.abrev_reglement_mode, 
									 a.nom
									 ".$query_select."
	
						FROM regmt_e_tpv rec
							LEFT JOIN reglements r ON r.ref_reglement = rec.ref_reglement
							LEFT JOIN reglements_modes rm ON r.id_reglement_mode = rm.id_reglement_mode
							LEFT JOIN reglements_docs rd ON r.ref_reglement = rd.ref_reglement
							LEFT JOIN annuaire a ON a.ref_contact = r.ref_contact
							
						WHERE  rec.id_compte_tpv_dest = '".$_REQUEST["id_compte_tp"]."'   && r.valide = '1' ".$query_where."
						".$query_group."
						ORDER BY r.date_reglement DESC
						LIMIT ".$query_limit;
						
						
	$resultat = $bdd->query($query);
	//echo $query;
	while ($fiche = $resultat->fetchObject()) {
		$fiches[] = $fiche; 
	}
	unset ($fiche, $resultat, $query);
 //print_r($fiches);
	// Comptage des résultats
	$query = "SELECT DISTINCT(rec.ref_reglement) 
						FROM regmt_e_cb rec
							LEFT JOIN reglements r ON r.ref_reglement = rec.ref_reglement
							LEFT JOIN reglements_modes rm ON r.id_reglement_mode = rm.id_reglement_mode
							LEFT JOIN reglements_docs rd ON r.ref_reglement = rd.ref_reglement
							LEFT JOIN comptes_caisses_moves ccm ON ccm.id_compte_caisse_move = rec.id_compte_caisse_move
							LEFT JOIN comptes_caisses cc ON cc.id_compte_caisse = ccm.id_compte_caisse
							LEFT JOIN users u ON u.ref_user = ccm.ref_user
							LEFT JOIN annuaire a ON a.ref_contact = r.ref_contact
							
						WHERE   rec.id_compte_tpe_dest = '".$_REQUEST["id_compte_tp"]."'   && r.valide = '1' ".$query_where."
						".$query_group;
	$resultat = $bdd->query($query); 
	while ($result = $resultat->fetchObject()) { $nb_fiches ++; }
	unset ($result, $resultat, $query);
}

}


// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_compta_tp_mouvement_result.inc.php");

?>