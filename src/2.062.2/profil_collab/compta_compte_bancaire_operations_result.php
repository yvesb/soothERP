<?php
// *************************************************************************************************************
// RECHERCHE DES OPERATION D'UN COMPTE BANCAIRE
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
$form['date_fin'] = $search['date_fin'] = date("Y-m-d")." 23:59:59";
if (isset($_REQUEST['date_fin'])) {
	$form['date_fin'] = $_REQUEST['date_fin']." 23:59:59";
	$search['date_fin'] = $_REQUEST['date_fin']." 23:59:59";
}

$search['date_debut'] = $ENTREPRISE_DATE_CREATION;

$nb_fiches = 0;

// *************************************************
// Résultat de la recherche
$fiches = array();
if (isset($_REQUEST['recherche'])) {
	// Préparation de la requete
	$query_join 	= "";
	$query_where 	= " id_compte_bancaire = '".$_REQUEST["id_compte_bancaire"]."' && date_move < '".$search['date_fin']."' ";
	
	//on recherche la date de debut de la liste part rapport au dernier relevé 
	$liste_releves = $compte_bancaire->getReleves_compte ();
	foreach ($liste_releves as $releve) {
		if ($releve->date_releve >= $search['date_fin']) {$next_montant_reel = $releve->solde_reel;	$id_compte_bancaire_releve = $releve->id_compte_bancaire_releve; continue; }
		$search['date_debut'] = $releve->date_releve;
		$query_where 	.= " &&  date_move > '".$releve->date_releve."' ";
		break;
	}
	
	if (isset($id_compte_bancaire_releve)) {
		$releve_encours = $compte_bancaire->charger_compte_bancaire_releve ($id_compte_bancaire_releve);
	}
	$query_limit	= (($search['page_to_show']-1)*$search['fiches_par_page']).", ".$search['fiches_par_page'];


	$solde_haut_page = 0;
	// Recherche
	$query = "SELECT cbm.id_compte_bancaire_move, cbm.id_compte_bancaire, cbm.date_move,
									 cbm.lib_move, montant_move, cbm.commentaire_move, cbm.id_operation, 
									 cjo.id_journal, cjo.numero_compte, cjo.montant, cjo.ref_operation, cjo.date_operation, cjo.id_operation_type,
 									cj.lib_journal, cj.desc_journal, cj.id_journal_parent, cj.id_journal_type, cj.contrepartie,
 									cjt.lib_journal as lib_journal_type, cjt.code_journal,
 									cjot.lib_operation_type, cjot.abrev_ope_type, cjot.table_liee
						FROM comptes_bancaires_moves cbm
							LEFT JOIN compta_journaux_opes cjo ON cjo.id_operation = cbm.id_operation
							LEFT JOIN compta_journaux cj ON cj.id_journal = cjo.id_journal
							LEFT JOIN compta_journaux_types cjt ON cjt.id_journal_type = cj.id_journal_type
							LEFT JOIN compta_journaux_opes_types cjot ON cjot.id_operation_type = cjo.id_operation_type
							".$query_join."
						WHERE ".$query_where." 
						GROUP BY cbm.id_compte_bancaire_move
						ORDER BY cbm.date_move DESC, cbm.lib_move ASC, cbm.id_compte_bancaire_move ASC
						LIMIT ".$query_limit;
	$resultat = $bdd->query($query);
	while ($fiche = $resultat->fetchObject()) { 
	
		$fiche->compte_tier = "";
		$fiche->libelle = "";

		switch ($fiche->id_operation_type) {
			// transfert de fond banque depuis caisse
			case 2:
 				$query_tmp = "SELECT ccd.id_compte_caisse_depot, ccd.id_compte_caisse_source, ccd.id_compte_bancaire_destination, 
											cc.lib_caisse ,
											cc2.lib_compte, cc2.numero_compte
											FROM comptes_caisses_depots ccd
											LEFT JOIN comptes_caisses cc  ON cc.id_compte_caisse = ccd.id_compte_caisse_source
											LEFT JOIN comptes_bancaires cc2  ON cc2.id_compte_bancaire = ccd.id_compte_bancaire_destination
											WHERE id_compte_caisse_depot = '".$fiche->ref_operation."' 
											";
				$resultat_tmp = $bdd->query($query_tmp);
				if ($inf_tmp = $resultat_tmp->fetchObject()) {
					$fiche->compte_tier = "";
					$fiche->id_compte_caisse = $inf_tmp->id_compte_caisse_source;
					$fiche->libelle = "Remise bancaire depuis ".$inf_tmp->lib_caisse;
				}
			break;
			// transfert de fond banque vers caisse
			case 3:
 				$query_tmp = "SELECT ccr.id_compte_caisse_retrait, ccr.id_compte_caisse_destination, ccr.id_compte_bancaire_source, 
											cc.lib_caisse ,
											cc2.lib_compte, cc2.numero_compte
											FROM comptes_caisses_retraits ccr
											LEFT JOIN comptes_caisses cc  ON cc.id_compte_caisse = ccr.id_compte_caisse_destination
											LEFT JOIN comptes_bancaires cc2  ON cc2.id_compte_bancaire = ccr.id_compte_bancaire_source
											WHERE id_compte_caisse_retrait = '".$fiche->ref_operation."' 
											";
				$resultat_tmp = $bdd->query($query_tmp);
				if ($inf_tmp = $resultat_tmp->fetchObject()) {
					$fiche->id_compte_caisse = $inf_tmp->id_compte_caisse_destination;
					$fiche->compte_tier = "";
					$fiche->libelle = "Retrait bancaire vers ".$inf_tmp->lib_caisse;
				}
			break;
			// règlement tier banque depuis tier
			case 5:
 				$query_tmp = "SELECT r.ref_contact, r.date_reglement, r.date_echeance, r.date_saisie, r.id_reglement_mode, r.montant_reglement, r.valide,
														 rm.lib_reglement_mode, rm.abrev_reglement_mode, rm.type_reglement,
														 a.nom
											FROM reglements r
												LEFT JOIN reglements_modes rm ON r.id_reglement_mode = rm.id_reglement_mode
												LEFT JOIN annuaire a ON a.ref_contact = r.ref_contact
											WHERE ref_reglement = '".$fiche->ref_operation."' 
											";
				$resultat_tmp = $bdd->query($query_tmp);
				if ($inf_tmp = $resultat_tmp->fetchObject()) {
					$nom_banque = "";
					$infos_complement = get_infos_reglement_type ($inf_tmp->id_reglement_mode, $fiche->ref_operation);
					if ($compte_bancaire_cible = new compte_bancaire ($infos_complement->id_compte_bancaire_dest)) {
						$nom_banque = $compte_bancaire_cible->getLib_compte();
					}
					$fiche->ref_contact = $inf_tmp->ref_contact;
					$fiche->compte_tier = $inf_tmp->nom;
					$fiche->libelle = $inf_tmp->lib_reglement_mode." par ".$inf_tmp->nom;
				}
			break;
			// règlement tier banque vers tier
			case 6:
 				$query_tmp = "SELECT r.ref_contact, r.date_reglement, r.date_echeance, r.date_saisie, r.id_reglement_mode, r.montant_reglement, r.valide,
														 rm.lib_reglement_mode, rm.abrev_reglement_mode, rm.type_reglement,
														 a.nom
											FROM reglements r
												LEFT JOIN reglements_modes rm ON r.id_reglement_mode = rm.id_reglement_mode
												LEFT JOIN annuaire a ON a.ref_contact = r.ref_contact
											WHERE ref_reglement = '".$fiche->ref_operation."' 
											";
				$resultat_tmp = $bdd->query($query_tmp);
				if ($inf_tmp = $resultat_tmp->fetchObject()) {
					$nom_banque = "";
					$infos_complement = get_infos_reglement_type ($inf_tmp->id_reglement_mode, $fiche->ref_operation);
					if (isset($infos_complement->id_compte_cb)) {
						$compte_cb = new compte_cb ($infos_complement->id_compte_cb);
						//création de l'opération dans le journal de banque correspondant
						$compte_bancaire_cible = new compte_bancaire ($compte_cb->getId_compte_bancaire ());
						$nom_banque = $compte_bancaire_cible->getLib_compte();
					} else if ($compte_bancaire_cible = new compte_bancaire ($infos_complement->id_compte_bancaire_source)) {
						$nom_banque = $compte_bancaire_cible->getLib_compte();
					}
					$fiche->ref_contact = $inf_tmp->ref_contact;
					$fiche->compte_tier = $inf_tmp->nom;
					$fiche->libelle = $inf_tmp->lib_reglement_mode." vers ".$inf_tmp->nom;
				}
			break;
			// transfert de fond banque depuis TPE
			case 7:
 				$query_tmp = "SELECT id_compte_tp_telecollecte, id_compte_tp, tp_type
											FROM comptes_tp_telecollecte ctt
											WHERE id_compte_tp_telecollecte = '".$fiche->ref_operation."' 
											";
				$resultat_tmp = $bdd->query($query_tmp);
				if ($inf_tmp = $resultat_tmp->fetchObject()) {
					$fiche->id_compte_tp = $inf_tmp->id_compte_tp;
					$fiche->tp_type = $inf_tmp->tp_type;
						
					$nom_banque = "";
					$nom_tp = "";
					if ($inf_tmp->tp_type == "TPE") {
						$compte_tpe = new compte_tpe ($inf_tmp->id_compte_tp);
						$nom_banque = $compte_tpe->getLib_compte_bancaire();
						$nom_tp = $compte_tpe->getLib_tpe();
					} else {
						$compte_tpv = new compte_tpv ($inf_tmp->id_compte_tp);
						$nom_banque = $compte_tpv->getLib_compte_bancaire();
						$nom_tp = $compte_tpv->getlib_tpv();
					}
					$fiche->compte_tier = "";
					$fiche->libelle = "Télécollecte depuis ".$nom_tp;
				}
			break;
		}
		unset ($query_tmp, $resultat_tmp, $inf_tmp);
	
		$fiches[] = $fiche; $solde_haut_page += $fiche->montant_move; 
	
	}
	//echo nl2br ($query);
	unset ($fiche, $resultat, $query);
	
	
	// Comptage des résultats
	$query = "SELECT COUNT(id_compte_bancaire_move) nb_fiches
						FROM comptes_bancaires_moves 
							".$query_join."
						WHERE ".$query_where." ";
	$resultat = $bdd->query($query);
	while ($result = $resultat->fetchObject()) { $nb_fiches += $result->nb_fiches; }
	//echo "<br><hr>".nl2br ($query);
	unset ($result, $resultat, $query);
	
	$report_solde = 0;
	if ($search['date_debut']) {
		$report_solde = $compte_bancaire->solde_reel_releve ($search['date_debut']);
	}
	//total en crédit en débit et en solde sur la période
	$query = "SELECT  id_compte_bancaire_move , montant_move
							FROM comptes_bancaires_moves 
							".$query_join."
						WHERE ".$query_where." 
						GROUP BY id_compte_bancaire_move
						ORDER BY date_move DESC, lib_move ASC, id_compte_bancaire_move ASC
						LIMIT ".((($search['page_to_show'])*$search['fiches_par_page']))." , ".abs($nb_fiches-(($search['page_to_show'])*$search['fiches_par_page']))."
					";
	$resultat = $bdd->query($query);
	//echo nl2br ($query);
	while ($tmp = $resultat->fetchObject()) { $report_solde += $tmp->montant_move; }
	
	$solde_haut_page += $report_solde;
	
}


// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_compta_compte_bancaire_operations_result.inc.php");

?>