<?php
// *************************************************************************************************************
// MODIFICATION D'UN RELEVE
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");


//chargement des comptes bancaires
$compte_bancaire	= new compte_bancaire($_REQUEST["id_compte_bancaire"]);

$infos_releve = $compte_bancaire->charger_compte_bancaire_releve ($_REQUEST["id_compte_bancaire_releve"]);

	$search['date_fin'] = $infos_releve->date_releve;
	$query_join 	= "";
	$query_where 	= " id_compte_bancaire = '".$_REQUEST["id_compte_bancaire"]."' && date_move < '".$search['date_fin']."' ";
	
	//on recherche la date de debut de la liste part rapport au dernier relevé 
	$liste_releves = $compte_bancaire->getReleves_compte ();
	foreach ($liste_releves as $releve) {
		if ($releve->date_releve >= $search['date_fin']) {$next_montant_reel = $releve->solde_reel; continue; }
		$search['date_debut'] = $releve->date_releve;
		$query_where 	.= " &&  date_move > '".$releve->date_releve."' ";
		break;
	}
	$totaux = array();
	//total en crédit en débit et en solde sur la période
	$query = "SELECT SUM(montant_move) as credit
							FROM comptes_bancaires_moves 
						WHERE ".$query_where." && montant_move > 0
					";
	$resultat = $bdd->query($query);
	if ($tmp = $resultat->fetchObject()) { $totaux["credit"] = $tmp->credit; }
	unset ($tmp, $resultat, $query);
	$query = "SELECT SUM(montant_move) as debit
							FROM comptes_bancaires_moves 
						WHERE ".$query_where." && montant_move < 0
					";
	$resultat = $bdd->query($query);
	if ($tmp = $resultat->fetchObject()) { $totaux["debit"] = $tmp->debit; }
	unset ($tmp, $resultat, $query);
	
	//on recherche le solde du relevé précédent
	$ancien_solde_reel = 0;
	if (isset($search['date_debut'])) {
		$ancien_solde_reel = $compte_bancaire->solde_reel_releve ($search['date_debut']);
	}
// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_compta_compte_bancaire_releves_edit.inc.php");

?>