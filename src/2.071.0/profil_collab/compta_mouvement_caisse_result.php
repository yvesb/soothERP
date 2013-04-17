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
$form['fiches_par_page'] = $search['fiches_par_page'] = $CAISSES_MOVES_SHOWED_FICHES;
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

$form['id_reglement_mode'] = $search['id_reglement_mode'] = array();
if (isset($_REQUEST['id_reglement_mode'])) {
			$form['id_reglement_mode'] = explode(",", $_REQUEST['id_reglement_mode']);
			$search['id_reglement_mode'] = explode(",", $_REQUEST['id_reglement_mode']);
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
		if (count($search['id_reglement_mode'])>1) {
			if ($query_where) { $query_where .= " &&  "; }
			$query_where .=  " ( ";
		}
		foreach ($search['id_reglement_mode'] as $reglement_mode) {
			if ($reglement_mode == "") {
				$query_where .=  ""; 	 
			break;
			}
			if (trim($reglement_mode) == "CHQ") {
				if ($count_modes) {$query_where .=  " || ";}
				if (count($search['id_reglement_mode']) == 1 && $query_where) {	$query_where .= " &&  "; }
				$query_where .=  " ccm.id_reglement_mode = 2 "; 
			
			}
			if (trim($reglement_mode) == "ESP") {
				if ($count_modes) {$query_where .=  " || ";}
				if (count($search['id_reglement_mode']) == 1 && $query_where) {	$query_where .= " &&  "; }
				$query_where .=  " ( ccm.id_reglement_mode = 1 || ccm.id_reglement_mode = 7) "; 
			}
			if (trim($reglement_mode) == "CB") {
				if ($count_modes) {$query_where .=  " || ";}
				if (count($search['id_reglement_mode']) == 1 && $query_where) {	$query_where .= " &&  "; }
				$query_where .=  " ccm.id_reglement_mode = 3 "; 
			}
			if (trim($reglement_mode) == "OP") {
				if ($count_modes) {$query_where .=  " || ";}
				if (count($search['id_reglement_mode']) == 1 && $query_where) {	$query_where .= " &&  "; }
				$query_where .=  "  ISNULL(ccm.id_reglement_mode)"; 
			}
			$count_modes ++;
		}
		if (count($search['id_reglement_mode'])>1) {
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
	$query = "SELECT ccm.id_compte_caisse_move, ccm.id_compte_caisse, ccm.id_move_type, ccm.id_reglement_mode, 
									 ccm.date_move, ccm.ref_user, ccm.montant_move, ccm.Info_supp,
									 rm.lib_reglement_mode, rm.type_reglement,
									 cmt.lib_move_type,
									 u.pseudo
									 ".$query_select."

						FROM comptes_caisses_moves ccm
							LEFT JOIN reglements_modes rm ON rm.id_reglement_mode = ccm.id_reglement_mode
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
							LEFT JOIN reglements_modes rm ON rm.id_reglement_mode = ccm.id_reglement_mode
							".$query_join."
							
						WHERE ".$query_where;
	$resultat = $bdd->query($query); 
	while ($result = $resultat->fetchObject()) { $nb_fiches += $result->nb_fiches; }
	unset ($result, $resultat, $query);
}


// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************
if (isset($_REQUEST["print"])) {
	ini_set("memory_limit","40M");
	// impression pdf
	$code_pdf_modele = "mouvement_caisse";
	$GLOBALS['PDF_OPTIONS']['HideToolbar'] = 0;
	$GLOBALS['PDF_OPTIONS']['AutoPrint'] = 1;
	
	$caisse = new compte_caisse($form['id_compte_caisse']);
	
	//$infos
	$infos = array();
	$infos["lib_type_printed"] = "Historique des opérations Caisse";
	$infos["dates"] = "du  ".$search['date_debut']." au ".$search['date_fin'];
	$infos["caisse"] = $caisse->getLib_caisse ().' '.$search['id_compte_caisse'];
	
	include_once ($PDF_MODELES_DIR.$code_pdf_modele.".class.php");
	$class = "pdf_".$code_pdf_modele;
	$pdf = new $class;
	
	// Création
	$pdf->create_pdf($infos, $fiches);
	
	// Sortie
	$pdf->Output();

} else {
include ($DIR.$_SESSION['theme']->getDir_theme()."page_compta_mouvement_caisse_result.inc.php");
}
?>