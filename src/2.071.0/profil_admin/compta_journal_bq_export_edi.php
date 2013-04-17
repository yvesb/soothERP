<?php
// ***********************************************************************************************************
// export journal des ventes et achats format EDI
// ***********************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");


$compta_e = new compta_exercices ();
$liste_exercices	= $compta_e->charger_compta_exercices();
//on récupère la dte du dernier exercice cloturé
foreach ($liste_exercices as $exercice) {
	if (!$exercice->etat_exercice) {$last_date_before_cloture = $exercice->date_fin; break;}
}

// *************************************************
// Données pour le formulaire && la requete
$form['page_to_show'] = $search['page_to_show'] = 1;
if (isset($_REQUEST['page_to_show'])) {
	$form['page_to_show'] = $_REQUEST['page_to_show'];
	$search['page_to_show'] = $_REQUEST['page_to_show'];
}
$form['fiches_par_page'] = $search['fiches_par_page'] = $COMPTA_EXTRAIT_COMPTE_SHOWED_FICHES;
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
$form['date_exercice"'] = "" ;
if (isset($_REQUEST['date_exercice']) && ($form['date_fin'] == "" && $form['date_debut'] == "")) {
	$form['date_exercice'] = explode(";",$_REQUEST['date_exercice']);
	$search['date_exercice'] = explode(";",$_REQUEST['date_exercice']);
	$search['date_debut'] = date_Us_to_Fr($search['date_exercice'][0]);
	$search['date_fin'] = date_Us_to_Fr($search['date_exercice'][1]);
}

// *************************************************
// Résultat de la recherche
$fiches = array();
if (isset($_REQUEST['recherche'])) {
	// Préparation de la requete
	
	// Recherche des FAC
	$query_join 	= "";
	$query_where 	= "";
	$query_group	= "";
	$query_limit	= "";
	
	$count_modes = 0;
	
	if ($search['date_debut']) {
		if ($query_where) { $query_where .= " &&  "; }
		$query_where .=  " cbm.date_move > '".date_Fr_to_Us($search['date_debut'])." 00:00:00' "; 
	}
	if ($search['date_fin']) {
		if ($query_where) { $query_where .= " &&  "; }
		$query_where .=  " cbm.date_move <= '".date_Fr_to_Us($search['date_fin'])." 23:59:59' "; 
	}
	

 
 //recherche des operations
 $queryd = "SELECT cbm.id_compte_bancaire_move, cbm.id_compte_bancaire, cbm.date_move, cb.defaut_numero_compte,
									 cbm.lib_move, montant_move, cbm.commentaire_move, cbm.id_operation, 
									 cjo.id_journal, cjo.numero_compte, cjo.montant, cjo.ref_operation, cjo.date_operation, cjo.id_operation_type,
 									cj.lib_journal, cj.desc_journal, cj.id_journal_parent, cj.id_journal_type, cj.contrepartie,
 									cjt.lib_journal as lib_journal_type, cjt.code_journal,
 									cjot.lib_operation_type, cjot.abrev_ope_type, cjot.table_liee
						FROM comptes_bancaires_moves cbm
							LEFT JOIN compta_journaux_opes cjo ON cjo.id_operation = cbm.id_operation
							LEFT JOIN comptes_bancaires  cb ON cb.id_compte_bancaire = cbm.id_compte_bancaire
							LEFT JOIN compta_journaux cj ON cj.id_journal = cjo.id_journal
							LEFT JOIN compta_journaux_types cjt ON cjt.id_journal_type = cj.id_journal_type
							LEFT JOIN compta_journaux_opes_types cjot ON cjot.id_operation_type = cjo.id_operation_type
							".$query_join."
						WHERE ".$query_where." 
						GROUP BY cbm.id_compte_bancaire_move
						ORDER BY cbm.date_move DESC, cbm.lib_move ASC, cbm.id_compte_bancaire_move ASC
						";
	//echo $queryd;
	$resultatd = $bdd->query($queryd);
	while ($fiche = $resultatd->fetchObject()) {
		$fiches[] = $fiche; 
	}
	unset ($queryd, $resultatd, $fiche);
}

// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************
//echo count($fiches);
	$complement_nom_fichier = "";
	if ($search['date_debut']) {
		$complement_nom_fichier .=  "-".$search['date_debut']; 
	}
	if ($search['date_fin']) {
		$complement_nom_fichier .=  "-".$search['date_fin']; 
	}
	header('Pragma: public'); 
	header('Expires: 0'); 
	header('Cache-Control: must-revalidate, post-check=0, pre-check=0'); 
	header('Content-Type: application/force-download'); 
	header('Content-Type: application/octet-stream'); 
	header('Content-Type: application/download'); 
	header('Content-Type: text/plain; name="ECRITURES'.$complement_nom_fichier.'.edi"');
	header('Content-Disposition: attachment; filename=ECRITURES'.$complement_nom_fichier.'.edi;'); 
	$i = 1;
	
	foreach ($fiches as $fiche) {
		$montant_int = 0;
		if ($fiche->montant_move > 0) {$montant_int = 1;}
		$DorC= ($montant_int % 2)? 'C' : 'D';
		$journal_exp = "BQ".$fiche->defaut_numero_compte;
		$type_fact = "FA";
		if (!$fiche->numero_compte) {$fiche->numero_compte = "472";} 
		echo "E;".$fiche->numero_compte.";".date("dmY",strtotime($fiche->date_move)).";".$journal_exp.";".substr(str_replace(";","",str_replace("\n"," ",str_replace("\r","",$fiche->lib_move))), 0, strpos($fiche->lib_move, " ")).";;".str_replace(";","",str_replace("\n"," ",str_replace("\r","",$fiche->lib_move))).";".$DorC.";".abs(number_format($fiche->montant_move, $TARIFS_NB_DECIMALES, ".", ""	)).";;\n";
	//	E;627;30042008;BQ;PRELVT; ;Frais sur traitement et rejet de LCR;D;32.90;;
		$i++;
	}
?>