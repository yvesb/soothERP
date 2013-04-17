<?php
// *************************************************************************************************************
// historique des controle de la caisse RESULTAT
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
$form['fiches_par_page'] = $search['fiches_par_page'] = $CAISSES_CONTROLE_SHOWED_FICHES;
if (isset($_REQUEST['fiches_par_page'])) {
	$form['fiches_par_page'] = $_REQUEST['fiches_par_page'];
	$search['fiches_par_page'] = $_REQUEST['fiches_par_page'];
}

$nb_fiches = 0;



$form['id_compte_caisse'] = "";
if (isset($_REQUEST['id_compte_caisse'])) {
	$form['id_compte_caisse'] = $_REQUEST['id_compte_caisse'];
	$search['id_compte_caisse'] = $_REQUEST['id_compte_caisse'];
}

$form['id_move_type'] = $search['id_move_type'] = array();
if (isset($_REQUEST['id_move_type'])) {
			$form['id_move_type'] = explode(",", $_REQUEST['id_move_type']);
			$search['id_move_type'] = explode(",", $_REQUEST['id_move_type']);
}

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
	$query_where 	= "";
	$query_group	= "";
	$query_limit	= (($search['page_to_show']-1)*$search['fiches_par_page']).", ".$search['fiches_par_page'];
	
	$count_modes = 0;
	if ($search['id_compte_caisse']) {
		$query_where .=  " ccm.id_compte_caisse = '".$search['id_compte_caisse']."'  "; 	
		if (count($search['id_move_type'])) {
			if ($query_where) { $query_where .= " &&  "; }
			$query_where .=  " ( ";
		}
		foreach ($search['id_move_type'] as $move_type) {
			if ($move_type == "") {
				$query_where .=  " ccm.id_move_type != 1 "; 	 
			break;
			}
			
			if ($count_modes) {$query_where .=  " || ";}
			$query_where .=  " ccm.id_move_type = ".$move_type." "; 
			
			$count_modes ++;
		}
		if (count($search['id_move_type'])) {
		$query_where .=  " ) "; 
		}
		
	}
	if ($search['date_debut']) {
		if ($query_where) { $query_where .= " &&  "; }
		$query_where .=  " ccm.date_move >= '".date_Fr_to_Us($search['date_debut'])." 00:00:00' "; 
	}
	if ($search['date_fin']) {
		if ($query_where) { $query_where .= " &&  "; }
		$query_where .=  " ccm.date_move <= '".date_Fr_to_Us($search['date_fin'])." 23:59:59' "; 
	}
	


	// Recherche
	$query = "SELECT ccm.id_compte_caisse_move, ccm.id_compte_caisse, ccm.id_move_type, ccm.id_move_type, 
									 ccm.date_move, ccm.ref_user, ccm.montant_move, ccm.Info_supp,
									 cmt.lib_move_type,
									 u.pseudo
									 ".$query_select."

						FROM comptes_caisses_moves ccm
							LEFT JOIN comptes_moves_types cmt ON cmt.id_move_type = ccm.id_move_type
							LEFT JOIN users u ON u.ref_user = ccm.ref_user
							".$query_join."
						WHERE ".$query_where."
						".$query_group."
						ORDER BY ccm.date_move DESC
						LIMIT ".$query_limit;
	$resultat = $bdd->query($query);
	//echo $query;
	while ($fiche = $resultat->fetchObject()) {
		$fiches[] = $fiche; 
	}
	unset ($fiche, $resultat, $query);
 //print_r($fiches);
	// Comptage des résultats
	$query = "SELECT COUNT(ccm.id_compte_caisse_move) nb_fiches
						FROM comptes_caisses_moves ccm
							".$query_join."
							
						WHERE ".$query_where;
	$resultat = $bdd->query($query); 
	while ($result = $resultat->fetchObject()) { $nb_fiches += $result->nb_fiches; }
	unset ($result, $resultat, $query);
}



// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_compta_controle_caisse_historique_result.inc.php");

?>