<?php
// ***********************************************************************************************************
// journal des tresorerie pour rapprochement bancaire
// ***********************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");


if (!$_SESSION['user']->check_permission ("13")) {
	//on indique l'interdiction et on stop le script
	echo "<br /><span style=\"font-weight:bolder;color:#FF0000;\">Vos droits  d'accés ne vous permettent pas de visualiser ce type de page</span>";
	exit();
}
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


$form['id_operation_type'] = "" ;
$search['id_operation_type'] = "";
if (isset($_REQUEST['id_operation_type']) && $_REQUEST['id_operation_type'] != "") {
	$form['id_operation_type'] = $_REQUEST['id_operation_type'];
	$search['id_operation_type'] = $_REQUEST['id_operation_type'];
}

$form['id_journal'] = "" ;
$search['id_journal'] = "";
if (isset($_REQUEST['id_journal']) && $_REQUEST['id_journal'] != "") {
	$form['id_journal'] = $_REQUEST['id_journal'];
	$search['id_journal'] = $_REQUEST['id_journal'];
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


// *************************************************
// Résultat de la recherche
$fiches = array();
if (isset($_REQUEST['recherche'])) {
	// Préparation de la requete
	$query_join 	= "";
	$query_where 	= " cjo.id_journal = '".$search['id_journal']."' && (cbor.complet = 0 ||  ISNULL(cbor.complet))";
	$query_group	= "";
	$query_limit	= "";
	if (!isset($_REQUEST["print"])) {
		$query_limit	= "LIMIT ".(($search['page_to_show']-1)*$search['fiches_par_page']).", ".$search['fiches_par_page'];
	}
	
	$count_modes = 0;
	
	if ($search['id_operation_type']) {
		if ($query_where) { $query_where .= " &&  "; }
		$query_where .=  " cjo.id_operation_type IN (".$search['id_operation_type'].")"; 
	}
	if ($search['date_debut']) {
		if ($query_where) { $query_where .= " &&  "; }
		$query_where .=  " cjo.date_operation > '".date_Fr_to_Us($search['date_debut'])." 00:00:00' "; 
	}
	if ($search['date_fin']) {
		if ($query_where) { $query_where .= " &&  "; }
		$query_where .=  " cjo.date_operation <= '".date_Fr_to_Us($search['date_fin'])." 23:59:59' "; 
	}
	
	if ($search['montant']) {
		if ($query_where) { $query_where .= " &&  "; }
		$query_where .= "
										(
											(
												(ABS(cjo.montant)-ABS(cbor.montant_rapproche)) < '".($search['montant']+$search['delta_montant']+0.01)."' &&
												(ABS(cjo.montant)-ABS(cbor.montant_rapproche)) > '".($search['montant']-$search['delta_montant']-0.01)."' 
											)
											||  
											(
												ABS(cjo.montant) < '".($search['montant']+$search['delta_montant']+0.01)."' &&
												ABS(cjo.montant) > '".($search['montant']-$search['delta_montant']-0.01)."'
											)
										)
										";
															 
	}
	
	



$nb_doc_aff = array();

 
 //recherche des documents
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
						".$query_limit;
	$resultatd = $bdd->query($queryd);
	
	while ($fiche = $resultatd->fetchObject()) {
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
					$fiche->libelle = $inf_tmp->lib_reglement_mode.": ".$inf_tmp->nom;
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
					$fiche->libelle = $inf_tmp->lib_reglement_mode.":  vers ".$inf_tmp->nom;
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
		
		$fiches[] = $fiche; 
		unset ($query_tmp, $resultat_tmp, $inf_tmp);
	}
	unset ($queryd, $resultatd, $fiche);
	
 $queryd = "SELECT cjo.id_operation 
						FROM compta_journaux_opes cjo
							LEFT JOIN compta_journaux cj ON cj.id_journal = cjo.id_journal
							LEFT JOIN comptes_bancaires_ope_rapp cbor ON cbor.id_operation = cjo.id_operation
							LEFT JOIN compta_journaux_types cjt ON cjt.id_journal_type = cj.id_journal_type
							LEFT JOIN compta_journaux_opes_types cjot ON cjot.id_operation_type = cjo.id_operation_type
							
						WHERE ".$query_where." 
						";
	$resultatd = $bdd->query($queryd);
	while ($fiche = $resultatd->fetchObject()) {
		$nb_fiches++;
	}
	unset ($queryd, $resultatd, $fiche);

}

// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

	include ($DIR.$_SESSION['theme']->getDir_theme()."page_compta_compte_bancaire_rapprochement_journal_result.inc.php");

?>