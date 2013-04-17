<?php
// *************************************************************************************************************
// historique telecollecte des TP RESULTAT
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
	$query_group	= "";
	$query_limit	= (($search['page_to_show']-1)*$search['fiches_par_page']).", ".$search['fiches_par_page'];
	
	if ($search['date_debut']) {
		if ($query_where) { $query_where .= " &&  "; }
		$query_where .=  " ctt.date_telecollecte >= '".date_Fr_to_Us($search['date_debut'])." 00:00:00' "; 
	}
	if ($search['date_fin']) {
		if ($query_where) { $query_where .= " &&  "; }
		$query_where .=  " ctt.date_telecollecte <= '".date_Fr_to_Us($search['date_fin'])." 23:59:59' "; 
	}
	

if (isset($_REQUEST["id_compte_tp"]) && isset($_REQUEST["tp_type"]) && $_REQUEST["tp_type"] == "TPE" ) {
	//on traite un TPE
	$query = "
						SELECT ctt.id_compte_tp_telecollecte, ctt.id_compte_tp, ctt.tp_type, ctt.ref_user, ctt.date_telecollecte, ctt.montant_telecollecte, ctt.montant_commission, ctt.montant_transfere, ctt.commentaire,
									 u.pseudo
									 ".$query_select."
	
						FROM comptes_tp_telecollecte ctt
							LEFT JOIN users u ON u.ref_user = ctt.ref_user
							
						WHERE  ctt.id_compte_tp = '".$_REQUEST["id_compte_tp"]."' && ctt.tp_type = 'TPE' ".$query_where."
						".$query_group."
						ORDER BY ctt.date_telecollecte DESC
						LIMIT ".$query_limit;
						
						
	$resultat = $bdd->query($query);
	//echo $query;
	while ($fiche = $resultat->fetchObject()) {
		$fiches[] = $fiche; 
	}
	unset ($fiche, $resultat, $query);
 //print_r($fiches);
	// Comptage des résultats
	$query = "SELECT DISTINCT(ctt.id_compte_tp_telecollecte) 
						FROM comptes_tp_telecollecte ctt
							
						WHERE  ctt.id_compte_tp = '".$_REQUEST["id_compte_tp"]."' && tp_type = 'TPE'   ".$query_where."
						".$query_group;
	$resultat = $bdd->query($query); 
	while ($result = $resultat->fetchObject()) { $nb_fiches ++; }
	unset ($result, $resultat, $query);
}

if (isset($_REQUEST["id_compte_tp"]) && isset($_REQUEST["tp_type"]) && $_REQUEST["tp_type"] == "TPV"  ) {
	//on traite un TPV
	$query = "
						SELECT ctt.id_compte_tp_telecollecte, ctt.id_compte_tp, ctt.tp_type, ctt.ref_user, ctt.date_telecollecte, ctt.montant_telecollecte, ctt.montant_commission, ctt.montant_transfere, ctt.commentaire,
									 u.pseudo
									 ".$query_select."
	
						FROM comptes_tp_telecollecte ctt
							LEFT JOIN users u ON u.ref_user = ctt.ref_user
							
						WHERE  ctt.id_compte_tp = '".$_REQUEST["id_compte_tp"]."' && ctt.tp_type = 'TPV' ".$query_where."
						".$query_group."
						ORDER BY ctt.date_telecollecte DESC
						LIMIT ".$query_limit;
						
						
	$resultat = $bdd->query($query);
	//echo $query;
	while ($fiche = $resultat->fetchObject()) {
		$fiches[] = $fiche; 
	}
	unset ($fiche, $resultat, $query);
 //print_r($fiches);
	// Comptage des résultats
	$query = "SELECT DISTINCT(ctt.id_compte_tp_telecollecte) 
						FROM comptes_tp_telecollecte ctt
							
						WHERE  ctt.id_compte_tp = '".$_REQUEST["id_compte_tp"]."' && tp_type = 'TPV'  ".$query_where."
						".$query_group;
	$resultat = $bdd->query($query); 
	while ($result = $resultat->fetchObject()) { $nb_fiches ++; }
	unset ($result, $resultat, $query);
}

}


// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_compta_tp_telecollecte_historique_result.inc.php");

?>