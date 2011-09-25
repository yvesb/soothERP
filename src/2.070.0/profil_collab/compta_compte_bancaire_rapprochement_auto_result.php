<?php
// ***********************************************************************************************************
// rapprochement bancaire automatique
// ***********************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");


if (!$_SESSION['user']->check_permission ("13")) {
	//on indique l'interdiction et on stop le script
	echo "<br /><span style=\"font-weight:bolder;color:#FF0000;\">Vos droits  d'accés ne vous permettent pas de visualiser ce type de page</span>";
	exit();
}

$compte_bancaire	= new compte_bancaire($_REQUEST["id_compte_bancaire"]);


$journal = new compta_journaux("", $DEFAUT_ID_JOURNAL_BANQUES , $compte_bancaire->getDefaut_numero_compte());

$date_fin_moves = date("Y-m-d")." 23:59:59";
$query_where0 = "";
$search['date_debut'] = $ENTREPRISE_DATE_CREATION;

if (isset($_REQUEST["date_fin"])) { 
	$date_fin_moves = $_REQUEST["date_fin"];
}
$query_where0 = " && cbm.date_move < '".$date_fin_moves."' ";
	
//on recherche la date de debut de la liste part rapport au dernier relevé 
$liste_releves = $compte_bancaire->getReleves_compte ();
foreach ($liste_releves as $releve) {
	if ($releve->date_releve >= $date_fin_moves) { continue; }
	$search['date_debut'] = $releve->date_releve;
	$query_where0 	.= " &&  cbm.date_move > '".$releve->date_releve."' ";
	break;
}

$next_date_fin_moves = $search['date_debut'];

$nb_ope = 0;
$nb_move = 0;
$nb_move_page = 0;

// *************************************************
// Résultat de la recherche
$fiches = array();

// Recherche des mouvements de compte non rapprochés
$query = "SELECT cbm.id_compte_bancaire_move, cbm.id_compte_bancaire, cbm.date_move,
								 cbm.lib_move, cbm.montant_move, cbm.commentaire_move, cbm.id_operation
					FROM comptes_bancaires_moves cbm
					WHERE  cbm.id_compte_bancaire = '".$_REQUEST["id_compte_bancaire"]."' && ISNULL(cbm.id_operation) ".$query_where0 ."
					GROUP BY id_compte_bancaire_move
					ORDER BY date_move DESC, lib_move ASC, id_compte_bancaire_move ASC
					";
$resultat = $bdd->query($query);
while ($fiche = $resultat->fetchObject()) {
	$nb_move ++;
	$nb_move_page ++;
	
	// Préparation de la requete
	$query_join 	= "";
	$query_where 	= " cjo.id_journal = '".$journal->getId_journal()."' && (cbor.complet = 0 ||  ISNULL(cbor.complet))";
	$query_group	= "";
	
	if ($fiche->montant_move >0) {
		if ($query_where) { $query_where .= " &&  "; }
		$query_where .=  " cjo.id_operation_type IN (2,7,5)"; 
	} else {
		if ($query_where) { $query_where .= " &&  "; }
		$query_where .=  " cjo.id_operation_type IN (3,6)"; 
	}
		if ($query_where) { $query_where .= " &&  "; }
		$query_where .=  " cjo.date_operation > '".date("Y-m-d H:i:s",mktime(0, 0, 0, date("m",strtotime($fiche->date_move)), date("d",strtotime($fiche->date_move))-($E_RAPPROCHEMENT), date("Y",strtotime($fiche->date_move))))."' "; 
		
		if ($query_where) { $query_where .= " &&  "; }
		$query_where .=  " cjo.date_operation <= '".date("Y-m-d H:i:s",mktime(23, 59, 59, date("m",strtotime($fiche->date_move)), date("d",strtotime($fiche->date_move))+($E_RAPPROCHEMENT), date("Y",strtotime($fiche->date_move))))."' "; 

	$search['montant'] = abs($fiche->montant_move);
	if ($search['montant']) {
		if ($query_where) { $query_where .= " &&  "; }
		$query_where .= "
										(
											(
												(ABS(cjo.montant)-ABS(cbor.montant_rapproche)) < '".($search['montant']+0.02)."' &&
												(ABS(cjo.montant)-ABS(cbor.montant_rapproche)) > '".($search['montant']-0.02)."' 
											)
											||  
											(
												ABS(cjo.montant) < '".($search['montant']+0.02)."' &&
												ABS(cjo.montant) > '".($search['montant']-0.02)."'
											)
										)
										";
	}
	

 
 //recherche des operations pouvant correspondre
 $queryd = "SELECT cjo.id_operation ,cjo.id_journal, cjo.numero_compte, cjo.montant, cjo.ref_operation, cjo.date_operation, cjo.id_operation_type,
									cj.lib_journal, cj.desc_journal, cj.id_journal_parent, cj.id_journal_type, cj.contrepartie,
									cjt.lib_journal as lib_journal_type, cjt.code_journal,
									cjot.lib_operation_type, cjot.abrev_ope_type, cjot.table_liee,
									cbor.montant_rapproche
						FROM compta_journaux_opes cjo
							LEFT JOIN compta_journaux cj ON cj.id_journal = cjo.id_journal
							LEFT JOIN comptes_bancaires_ope_rapp cbor ON cbor.id_operation = cjo.id_operation
							LEFT JOIN compta_journaux_types cjt ON cjt.id_journal_type = cj.id_journal_type
							LEFT JOIN compta_journaux_opes_types cjot ON cjot.id_operation_type = cjo.id_operation_type
							
						WHERE ".$query_where." 
						ORDER BY date_operation DESC
						";
	$resultatd = $bdd->query($queryd);
	$fiche_ope = $resultatd->fetchObject();
	// si une seule concordance, alors rapprochement
	if (is_object($fiche_ope) && count($fiche_ope) == 1) {
		$GLOBALS['_ALERTES'] = array();
		$compte_bancaire->add_compte_bancaire_rapprochement ($fiche->id_compte_bancaire_move, $fiche_ope->id_operation, $fiche->date_move);
		$nb_ope ++; 
	}
}

if (isset($_REQUEST["nb_move"])) {
	$nb_move += $_REQUEST["nb_move"];
}
if (isset($_REQUEST["nb_ope"])) {
	$nb_ope += $_REQUEST["nb_ope"];
}
// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

	include ($DIR.$_SESSION['theme']->getDir_theme()."page_compta_compte_bancaire_rapprochement_auto_result.inc.php");

?>