<?php
// ***********************************************************************************************************
// journal des ventes
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
	$query_join 	= "";
	$query_where 	= "";
	$query_group	= "";
	
	$query_limit	= "";
	$nb_fiches = 6;
	
	$journaux_caisses = array();
	$journaux_banques = array();
	
	switch ($search['page_to_show']) {
		
		//depots caise vers banque
		case 1:
			if ($search['date_debut']) {
				if ($query_where) { $query_where .= " &&  "; }
				$query_where .=  " ccd.date_depot > '".date_Fr_to_Us($search['date_debut'])." 00:00:00' "; 
			}
			if ($search['date_fin']) {
				if ($query_where) { $query_where .= " &&  "; }
				$query_where .=  " ccd.date_depot <= '".date_Fr_to_Us($search['date_fin'])." 23:59:59' "; 
			}
		 //récuperer les depots bancaires de la periode
		 $query = "SELECT ccd.id_compte_caisse_depot, ccd.id_compte_caisse_source, ccd.id_compte_bancaire_destination, ccd.ref_user, ccd.date_depot, ccd.montant_depot, ccd.num_remise, ccd.commentaire,
											cc.lib_caisse , cc.defaut_numero_compte as d_cpt_caisse,
											cc2.lib_compte, cc2.numero_compte, cc2.defaut_numero_compte as d_cpt_banque, a.nom
											FROM comptes_caisses_depots ccd
											LEFT JOIN comptes_caisses cc  ON cc.id_compte_caisse = ccd.id_compte_caisse_source
											LEFT JOIN comptes_bancaires cc2  ON cc2.id_compte_bancaire = ccd.id_compte_bancaire_destination
											LEFT JOIN annuaire a  ON cc2.ref_contact = a.ref_contact
								WHERE ".$query_where."
								".$query_limit;
			$resultat = $bdd->query($query);
			
			while ($tmp = $resultat->fetchObject()) {
				if (!$tmp->d_cpt_caisse) {$tmp->d_cpt_caisse	= $DEFAUT_COMPTE_CAISSES;}
				if (!$tmp->d_cpt_banque) {$tmp->d_cpt_banque	= $DEFAUT_COMPTE_BANQUES;}
				
				$query2 = "SELECT id_operation FROM compta_journaux_opes 
									WHERE ref_operation = '".addslashes($tmp->id_compte_caisse_depot)."' && id_operation_type = '1' "; 
				$resultat2 = $bdd->query($query2);
				if (!$tmp2 = $resultat2->fetchObject()) {
					if (!isset($journaux_caisses[$tmp->d_cpt_caisse])) {
						$journal_caisse_depart = compta_journaux::check_exist_journaux ($DEFAUT_ID_JOURNAL_CAISSES, $tmp->d_cpt_caisse);
						$journaux_caisses[$journal_caisse_depart->getContrepartie ()] = $journal_caisse_depart;
					} else {
						$journal_caisse_depart = $journaux_caisses[$tmp->d_cpt_caisse];
					}
					//création de opération de journal
					$journal_caisse_depart->create_operation ($DEFAUT_COMPTE_VIREMENTS_INTERNES, -$tmp->montant_depot, $tmp->id_compte_caisse_depot, $tmp->date_depot, 1); 
				
				}
				$query3 = "SELECT id_operation FROM compta_journaux_opes 
									WHERE ref_operation = '".addslashes($tmp->id_compte_caisse_depot)."' && id_operation_type = '2' "; 
				$resultat3 = $bdd->query($query3);
				if (!$tmp3 = $resultat3->fetchObject()) {
					if (!isset($journaux_banques[$tmp->d_cpt_banque])) {
						$journal_banque_arrivee =  compta_journaux::check_exist_journaux ($DEFAUT_ID_JOURNAL_BANQUES, $tmp->d_cpt_banque);
						$journaux_banques[$journal_banque_arrivee->getContrepartie ()] = $journal_banque_arrivee;
					} else {
						$journal_banque_arrivee = $journaux_banques[$tmp->d_cpt_banque];
					}
					//création de opération de journal
					$journal_banque_arrivee->create_operation ($DEFAUT_COMPTE_VIREMENTS_INTERNES, $tmp->montant_depot, $tmp->id_compte_caisse_depot, $tmp->date_depot, 2); 
				}
				unset ($query2, $resultat2, $tmp2);
				unset ($query3, $resultat3, $tmp3);
			}
			unset ($query, $resultat, $tmp);
		break;
		
		//retrait banque vers caisse
		
		case 2:
			if ($search['date_debut']) {
				if ($query_where) { $query_where .= " &&  "; }
				$query_where .=  " ccr.date_retrait > '".date_Fr_to_Us($search['date_debut'])." 00:00:00' "; 
			}
			if ($search['date_fin']) {
				if ($query_where) { $query_where .= " &&  "; }
				$query_where .=  " ccr.date_retrait <= '".date_Fr_to_Us($search['date_fin'])." 23:59:59' "; 
			}
		 //récuperer les retraits bancaires de la periode
		 $query = "SELECT ccr.id_compte_caisse_retrait, ccr.id_compte_caisse_destination, ccr.id_compte_bancaire_source, ccr.ref_user, ccr.date_retrait, ccr.montant_retrait, ccr.commentaire,
											cc.lib_caisse , cc.defaut_numero_compte as d_cpt_caisse,
											cc2.lib_compte, cc2.numero_compte, cc2.defaut_numero_compte as d_cpt_banque, a.nom
										FROM comptes_caisses_retraits ccr
										LEFT JOIN comptes_caisses cc  ON cc.id_compte_caisse = ccr.id_compte_caisse_destination
										LEFT JOIN comptes_bancaires cc2  ON cc2.id_compte_bancaire = ccr.id_compte_bancaire_source
										LEFT JOIN annuaire a  ON cc2.ref_contact = a.ref_contact
								WHERE ".$query_where."
								".$query_limit;
			$resultat = $bdd->query($query);
			
			while ($tmp = $resultat->fetchObject()) {
				if (!$tmp->d_cpt_caisse) {$tmp->d_cpt_caisse	= $DEFAUT_COMPTE_CAISSES;}
				if (!$tmp->d_cpt_banque) {$tmp->d_cpt_banque	= $DEFAUT_COMPTE_BANQUES;}
				
				$query2 = "SELECT id_operation FROM compta_journaux_opes 
									WHERE ref_operation = '".addslashes($tmp->id_compte_caisse_retrait)."' && id_operation_type = '4' "; 
				$resultat2 = $bdd->query($query2);
				if (!$tmp2 = $resultat2->fetchObject()) {
					if (!isset($journaux_caisses[$tmp->d_cpt_caisse])) {
						$journal_caisse_arrivee = compta_journaux::check_exist_journaux ($DEFAUT_ID_JOURNAL_CAISSES, $tmp->d_cpt_caisse);
						$journaux_caisses[$journal_caisse_arrivee->getContrepartie ()] = $journal_caisse_arrivee;
					} else {
						$journal_caisse_arrivee = $journaux_caisses[$tmp->d_cpt_caisse];
					}
					//création de opération de journal
					$journal_caisse_arrivee->create_operation ($DEFAUT_COMPTE_VIREMENTS_INTERNES, $tmp->montant_retrait, $tmp->id_compte_caisse_retrait, $tmp->date_retrait, 4); 
				
				}
				$query3 = "SELECT id_operation FROM compta_journaux_opes 
									WHERE ref_operation = '".addslashes($tmp->id_compte_caisse_retrait)."' && id_operation_type = '3' "; 
				$resultat3 = $bdd->query($query3);
				if (!$tmp3 = $resultat3->fetchObject()) {
					if (!isset($journaux_banques[$tmp->d_cpt_banque])) {
						$journal_banque_depart =  compta_journaux::check_exist_journaux ($DEFAUT_ID_JOURNAL_BANQUES, $tmp->d_cpt_banque);
						$journaux_banques[$journal_banque_depart->getContrepartie ()] = $journal_banque_depart;
					} else {
						$journal_banque_depart = $journaux_banques[$tmp->d_cpt_banque];
					}
					//création de opération de journal
					$journal_banque_depart->create_operation ($DEFAUT_COMPTE_VIREMENTS_INTERNES, -$tmp->montant_retrait, $tmp->id_compte_caisse_retrait, $tmp->date_retrait, 3); 
				}
				unset ($query2, $resultat2, $tmp2);
				unset ($query3, $resultat3, $tmp3);
			}
			unset ($query, $resultat, $tmp);
		break;
		
		//transfert entre caisses (de compte différents)
		
		case 3:
			if ($search['date_debut']) {
				if ($query_where) { $query_where .= " &&  "; }
				$query_where .=  " cct.date_transfert > '".date_Fr_to_Us($search['date_debut'])." 00:00:00' "; 
			}
			if ($search['date_fin']) {
				if ($query_where) { $query_where .= " &&  "; }
				$query_where .=  " cct.date_transfert <= '".date_Fr_to_Us($search['date_fin'])." 23:59:59' "; 
			}
		 //récuperer les transferts de la periode
		 $query = "SELECT cct.id_compte_caisse_transfert, cct.id_compte_caisse_source, cct.id_compte_caisse_destination, cct.ref_user, cct.date_transfert, cct.montant_theorique, cct.montant_transfert, cct.commentaire, 
											cc.lib_caisse as lib_caisse_source, cc.defaut_numero_compte as d_cpt_caisse_source,
											cc2.lib_caisse as lib_caisse_dest, cc2.defaut_numero_compte as d_cpt_caisse_dest
								FROM comptes_caisses_transferts cct
								LEFT JOIN comptes_caisses cc  ON cc.id_compte_caisse = cct.id_compte_caisse_source
								LEFT JOIN comptes_caisses cc2  ON cc2.id_compte_caisse = cct.id_compte_caisse_destination
								WHERE ".$query_where."
								".$query_limit;
			$resultat = $bdd->query($query);
			
			while ($tmp = $resultat->fetchObject()) {
				if (!$tmp->d_cpt_caisse_source) {$tmp->d_cpt_caisse_source	= $DEFAUT_COMPTE_CAISSES;}
				if (!$tmp->d_cpt_caisse_dest) {$tmp->d_cpt_caisse_dest	= $DEFAUT_COMPTE_CAISSES;}
				
				if ($tmp->d_cpt_caisse_dest != $tmp->d_cpt_caisse_source) {
					
					$query2 = "SELECT id_operation FROM compta_journaux_opes 
										WHERE ref_operation = '".addslashes($tmp->id_compte_caisse_transfert)."' && id_operation_type = '9' "; 
					$resultat2 = $bdd->query($query2);
					if (!$tmp2 = $resultat2->fetchObject()) {
						if (!isset($journaux_caisses[$tmp->d_cpt_caisse_source])) {
							$journal_caisse_depart = compta_journaux::check_exist_journaux ($DEFAUT_ID_JOURNAL_CAISSES, $tmp->d_cpt_caisse_source);
							$journaux_caisses[$journal_caisse_depart->getContrepartie ()] = $journal_caisse_depart;
						} else {
							$journal_caisse_depart = $journaux_caisses[$tmp->d_cpt_caisse_source];
						}
						//création de opération de journal
						$journal_caisse_depart->create_operation ($DEFAUT_COMPTE_VIREMENTS_INTERNES, -$tmp->montant_transfert, $tmp->id_compte_caisse_transfert, $tmp->date_transfert, 9); 
					
					}
					$query3 = "SELECT id_operation FROM compta_journaux_opes 
										WHERE ref_operation = '".addslashes($tmp->id_compte_caisse_transfert)."' && id_operation_type = '10' "; 
					$resultat3 = $bdd->query($query3);
					if (!$tmp3 = $resultat3->fetchObject()) {
						if (!isset($journaux_caisses[$tmp->d_cpt_caisse_dest])) {
							$journal_caisse_arrive = compta_journaux::check_exist_journaux ($DEFAUT_ID_JOURNAL_CAISSES, $tmp->d_cpt_caisse_dest);
							$journaux_caisses[$journal_caisse_arrive->getContrepartie ()] = $journal_caisse_arrive;
						} else {
							$journal_caisse_arrive = $journaux_caisses[$tmp->d_cpt_caisse_dest];
						}
						//création de opération de journal
						$journal_caisse_arrive->create_operation ($DEFAUT_COMPTE_VIREMENTS_INTERNES, $tmp->montant_transfert, $tmp->id_compte_caisse_transfert, $tmp->date_transfert, 9); 
					}
					unset ($query2, $resultat2, $tmp2);
					unset ($query3, $resultat3, $tmp3);
				}
			}
			unset ($query, $resultat, $tmp);
		break;
		//depots tpe vers banque
		case 4:
			//d'abord les TPE
			if ($search['date_debut']) {
				if ($query_where) { $query_where .= " &&  "; }
				$query_where .=  " ctt.date_telecollecte > '".date_Fr_to_Us($search['date_debut'])." 00:00:00' "; 
			}
			if ($search['date_fin']) {
				if ($query_where) { $query_where .= " &&  "; }
				$query_where .=  " ctt.date_telecollecte <= '".date_Fr_to_Us($search['date_fin'])." 23:59:59' "; 
			}
			if ($query_where) { $query_where .= " &&  "; }
			$query_where .=  " ctt.tp_type = 'TPE' "; 
		 //récuperer les telecollectes de la periode
		 $query = "SELECT ctt.id_compte_tp_telecollecte, ctt.id_compte_tp, ctt.tp_type, ctt.ref_user, ctt.date_telecollecte, ctt.montant_telecollecte, ctt.montant_commission, ctt.montant_transfere, ctt.commentaire,
		 									ct.defaut_numero_compte as d_cpt_caisse,
		 									cb.defaut_numero_compte as d_cpt_banque
								FROM comptes_tp_telecollecte ctt
								LEFT JOIN comptes_tpes ct  ON ct.id_compte_tpe = ctt.id_compte_tp
								LEFT JOIN comptes_bancaires cb ON cb.id_compte_bancaire = ct.id_compte_bancaire
								WHERE ".$query_where."
								".$query_limit;
			$resultat = $bdd->query($query);
			
			while ($tmp = $resultat->fetchObject()) {
				if (!$tmp->d_cpt_caisse) {$tmp->d_cpt_caisse	= $DEFAUT_COMPTE_CAISSES;}
				if (!$tmp->d_cpt_banque) {$tmp->d_cpt_banque	= $DEFAUT_COMPTE_BANQUES;}
				
				$query2 = "SELECT id_operation FROM compta_journaux_opes 
									WHERE ref_operation = '".addslashes($tmp->id_compte_tp_telecollecte)."' && id_operation_type = '7' "; 
				$resultat2 = $bdd->query($query2);
				if (!$tmp2 = $resultat2->fetchObject()) {
					if (!isset($journaux_banques[$tmp->d_cpt_banque])) {
						$journal_banque_arrivee =  compta_journaux::check_exist_journaux ($DEFAUT_ID_JOURNAL_BANQUES, $tmp->d_cpt_banque);
						$journaux_banques[$journal_banque_arrivee->getContrepartie ()] = $journal_banque_arrivee;
					} else {
						$journal_banque_arrivee = $journaux_banques[$tmp->d_cpt_banque];
					}
					//création de opération de journal
					$journal_banque_arrivee->create_operation ($DEFAUT_COMPTE_VIREMENTS_INTERNES, $tmp->montant_transfere, $tmp->id_compte_tp_telecollecte, $tmp->date_telecollecte, 7); 
				
				}
				$query3 = "SELECT id_operation FROM compta_journaux_opes 
									WHERE ref_operation = '".addslashes($tmp->id_compte_tp_telecollecte)."' && id_operation_type = '8' "; 
				$resultat3 = $bdd->query($query3);
				if (!$tmp3 = $resultat3->fetchObject()) {
					if (!isset($journaux_caisses[$tmp->d_cpt_caisse])) {
						$journal_caisse_depart = compta_journaux::check_exist_journaux ($DEFAUT_ID_JOURNAL_CAISSES, $tmp->d_cpt_caisse);
						$journaux_caisses[$journal_caisse_depart->getContrepartie ()] = $journal_caisse_depart;
					} else {
						$journal_caisse_depart = $journaux_caisses[$tmp->d_cpt_caisse];
					}
					//création de opération de journal
					$journal_caisse_depart->create_operation ($DEFAUT_COMPTE_VIREMENTS_INTERNES, -$tmp->montant_transfere, $tmp->id_compte_tp_telecollecte, $tmp->date_telecollecte, 8); 
				}
				unset ($query2, $resultat2, $tmp2);
				unset ($query3, $resultat3, $tmp3);
			}
			unset ($query, $resultat, $tmp);
			
			//puis les TPV
			if ($search['date_debut']) {
				if ($query_where) { $query_where .= " &&  "; }
				$query_where .=  " ctt.date_telecollecte > '".date_Fr_to_Us($search['date_debut'])." 00:00:00' "; 
			}
			if ($search['date_fin']) {
				if ($query_where) { $query_where .= " &&  "; }
				$query_where .=  " ctt.date_telecollecte <= '".date_Fr_to_Us($search['date_fin'])." 23:59:59' "; 
			}
			if ($query_where) { $query_where .= " &&  "; }
			$query_where .=  " ctt.tp_type = 'TPV' "; 
		 //récuperer les telecollectes de la periode
		 $query = "SELECT ctt.id_compte_tp_telecollecte, ctt.id_compte_tp, ctt.tp_type, ctt.ref_user, ctt.date_telecollecte, ctt.montant_telecollecte, ctt.montant_commission, ctt.montant_transfere, ctt.commentaire,
		 									ct.defaut_numero_compte as d_cpt_caisse,
		 									cb.defaut_numero_compte as d_cpt_banque
								FROM comptes_tp_telecollecte ctt
								LEFT JOIN comptes_tpv ct  ON ct.id_compte_tpv = ctt.id_compte_tp
								LEFT JOIN comptes_bancaires cb ON cb.id_compte_bancaire = ct.id_compte_bancaire
								WHERE ".$query_where." 
								".$query_limit;
			$resultat = $bdd->query($query);
			
			while ($tmp = $resultat->fetchObject()) {
				if (!$tmp->d_cpt_caisse) {$tmp->d_cpt_caisse	= $DEFAUT_COMPTE_CAISSES;}
				if (!$tmp->d_cpt_banque) {$tmp->d_cpt_banque	= $DEFAUT_COMPTE_BANQUES;}
				
				$query2 = "SELECT id_operation FROM compta_journaux_opes 
									WHERE ref_operation = '".addslashes($tmp->id_compte_tp_telecollecte)."' && id_operation_type = '7' "; 
				$resultat2 = $bdd->query($query2);
				if (!$tmp2 = $resultat2->fetchObject()) {
					if (!isset($journaux_banques[$tmp->d_cpt_banque])) {
						$journal_banque_arrivee =  compta_journaux::check_exist_journaux ($DEFAUT_ID_JOURNAL_BANQUES, $tmp->d_cpt_banque);
						$journaux_banques[$journal_banque_arrivee->getContrepartie ()] = $journal_banque_arrivee;
					} else {
						$journal_banque_arrivee = $journaux_banques[$tmp->d_cpt_banque];
					}
					//création de opération de journal
					$journal_banque_arrivee->create_operation ($DEFAUT_COMPTE_VIREMENTS_INTERNES, $tmp->montant_transfere, $tmp->id_compte_tp_telecollecte, $tmp->date_telecollecte, 7); 
				
				}
				$query3 = "SELECT id_operation FROM compta_journaux_opes 
									WHERE ref_operation = '".addslashes($tmp->id_compte_tp_telecollecte)."' && id_operation_type = '8' "; 
				$resultat3 = $bdd->query($query3);
				if (!$tmp3 = $resultat3->fetchObject()) {
					if (!isset($journaux_caisses[$tmp->d_cpt_caisse])) {
						$journal_caisse_depart = compta_journaux::check_exist_journaux ($DEFAUT_ID_JOURNAL_CAISSES, $tmp->d_cpt_caisse);
						$journaux_caisses[$journal_caisse_depart->getContrepartie ()] = $journal_caisse_depart;
					} else {
						$journal_caisse_depart = $journaux_caisses[$tmp->d_cpt_caisse];
					}
					//création de opération de journal
					$journal_caisse_depart->create_operation ($DEFAUT_COMPTE_VIREMENTS_INTERNES, -$tmp->montant_transfere, $tmp->id_compte_tp_telecollecte, $tmp->date_telecollecte, 8); 
				}
				unset ($query2, $resultat2, $tmp2);
				unset ($query3, $resultat3, $tmp3);
			}
			unset ($query, $resultat, $tmp);
		break;
		//rgmt entrant caise vers banque (VIR , Prel, lettre de change)
		case 5:
			if ($search['date_debut']) {
				if ($query_where) { $query_where .= " &&  "; }
				$query_where .=  " r.date_reglement > '".date_Fr_to_Us($search['date_debut'])." 00:00:00' "; 
			}
			if ($search['date_fin']) {
				if ($query_where) { $query_where .= " &&  "; }
				$query_where .=  " r.date_reglement <= '".date_Fr_to_Us($search['date_fin'])." 23:59:59' "; 
			}
			if ($query_where) { $query_where .= " &&  "; }
			$query_where .=  " r.id_reglement_mode IN (".$VIR_E_ID_REGMT_MODE.", ".$LCR_E_ID_REGMT_MODE.", ".$PRB_E_ID_REGMT_MODE.") "; 

		 //récuperer les reglements de la periode
		 $query = "SELECT r.ref_reglement, r.ref_contact, r.date_reglement, r.date_echeance, r.date_saisie, r.id_reglement_mode, r.montant_reglement, r.valide,
										 cbrev.defaut_numero_compte as d_cpt_banque_rev,
										 cbrel.defaut_numero_compte as d_cpt_banque_rel,
										 cbrep.defaut_numero_compte as d_cpt_banque_rep,
										 d.id_type_doc
							FROM reglements r
							
							LEFT JOIN regmt_e_vir rev ON rev.ref_reglement = r.ref_reglement
							LEFT JOIN regmt_e_lcr rel ON rel.ref_reglement = r.ref_reglement
							LEFT JOIN regmt_e_prb rep ON rep.ref_reglement = r.ref_reglement
							
							LEFT JOIN comptes_bancaires cbrev ON cbrev.id_compte_bancaire = rev.id_compte_bancaire_dest
							LEFT JOIN comptes_bancaires cbrel ON cbrel.id_compte_bancaire = rel.id_compte_bancaire_dest
							LEFT JOIN comptes_bancaires cbrep ON cbrep.id_compte_bancaire = rep.id_compte_bancaire_dest
							
							LEFT JOIN reglements_docs rd ON rd.ref_reglement = r.ref_reglement
							LEFT JOIN documents d ON d.ref_doc = rd.ref_doc
							
							WHERE  ".$query_where."
							
								".$query_limit;
			$resultat = $bdd->query($query);
			
			while ($tmp = $resultat->fetchObject()) {
				if ($tmp->id_reglement_mode == $VIR_E_ID_REGMT_MODE) {$tmp->d_cpt_banque	= $tmp->d_cpt_banque_rev;}
				if ($tmp->id_reglement_mode == $LCR_E_ID_REGMT_MODE) {$tmp->d_cpt_banque	= $tmp->d_cpt_banque_rel;}
				if ($tmp->id_reglement_mode == $PRB_E_ID_REGMT_MODE) {$tmp->d_cpt_banque	= $tmp->d_cpt_banque_rep;}
				if (!$tmp->d_cpt_banque) {$tmp->d_cpt_banque	= $DEFAUT_COMPTE_BANQUES;}
				if ($tmp->id_type_doc) {
					//if ($tmp->id_type_doc == $DEVIS_CLIENT_ID_TYPE_DOC || $tmp->id_type_doc == $LIVRAISON_CLIENT_ID_TYPE_DOC || $tmp->id_type_doc == $COMMANDE_CLIENT_ID_TYPE_DOC || $tmp->id_type_doc == $FACTURE_CLIENT_ID_TYPE_DOC) {$infos["doc_ACCEPT_REGMT"] = "1";}
					if ($tmp->id_type_doc == $DEVIS_FOURNISSEUR_ID_TYPE_DOC || $tmp->id_type_doc == $LIVRAISON_FOURNISSEUR_ID_TYPE_DOC || $tmp->id_type_doc == $COMMANDE_FOURNISSEUR_ID_TYPE_DOC || $tmp->id_type_doc == $FACTURE_FOURNISSEUR_ID_TYPE_DOC) {$infos["doc_ACCEPT_REGMT"] = "-1";}
				}
				
				$query3 = "SELECT id_operation FROM compta_journaux_opes 
									WHERE ref_operation = '".addslashes($tmp->ref_reglement)."' && id_operation_type = '5' "; 
				$resultat3 = $bdd->query($query3);
				if (!$tmp3 = $resultat3->fetchObject()) {
					if (!isset($journaux_banques[$tmp->d_cpt_banque])) {
						$journal_banque_arrivee =  compta_journaux::check_exist_journaux ($DEFAUT_ID_JOURNAL_BANQUES, $tmp->d_cpt_banque);
						$journaux_banques[$journal_banque_arrivee->getContrepartie ()] = $journal_banque_arrivee;
					} else {
						$journal_banque_arrivee = $journaux_banques[$tmp->d_cpt_banque];
					}
					
					// récupération du compte tier vente
					$numero_compte_comptable = $DEFAUT_COMPTE_TIERS_VENTE;
					if (isset($infos["doc_ACCEPT_REGMT"]) && $infos["doc_ACCEPT_REGMT"] == "-1") {$numero_compte_comptable = $DEFAUT_COMPTE_TIERS_ACHAT;}
					$tmp_contact = new contact ($tmp->ref_contact);
					if ($tmp_contact->getRef_contact()) {
						$profils 	= $tmp_contact->getProfils ();
						//gestion des cas ambigus entre profils et sens de règlement
						if (isset($profils[$CLIENT_ID_PROFIL]) && !isset($profils[$FOURNISSEUR_ID_PROFIL]) ) { $ID_PROFIL = $CLIENT_ID_PROFIL;}
						if (!isset($profils[$CLIENT_ID_PROFIL]) && isset($profils[$FOURNISSEUR_ID_PROFIL]) ) { $ID_PROFIL = $FOURNISSEUR_ID_PROFIL;}
						
						if (isset($profils[$CLIENT_ID_PROFIL]) && isset($profils[$FOURNISSEUR_ID_PROFIL]) ) { 
							$ID_PROFIL = $CLIENT_ID_PROFIL;
							if (isset($infos["doc_ACCEPT_REGMT"]) && $infos["doc_ACCEPT_REGMT"] == "-1") {$ID_PROFIL = $FOURNISSEUR_ID_PROFIL;}
						}
						$numero_compte_comptable = $profils[$ID_PROFIL]->getDefaut_numero_compte ();
					} 
					
					//création de opération de journal
					$journal_banque_arrivee->create_operation ($numero_compte_comptable, $tmp->montant_reglement, $tmp->ref_reglement, $tmp->date_reglement, 5); 
				}
				unset ($query3, $resultat3, $tmp3);
			}
			unset ($query, $resultat, $tmp);
		break;
		//rgmt sortant caisse vers banque (CHQ, CB, VIR , Prel, lettre de change)
		case 6:
			if ($search['date_debut']) {
				if ($query_where) { $query_where .= " &&  "; }
				$query_where .=  " r.date_reglement > '".date_Fr_to_Us($search['date_debut'])." 00:00:00' "; 
			}
			if ($search['date_fin']) {
				if ($query_where) { $query_where .= " &&  "; }
				$query_where .=  " r.date_reglement <= '".date_Fr_to_Us($search['date_fin'])." 23:59:59' "; 
			}
			if ($query_where) { $query_where .= " &&  "; }
			$query_where .=  " r.id_reglement_mode IN (".$CHQ_S_ID_REGMT_MODE.", ".$CB_S_ID_REGMT_MODE.", ".$VIR_S_ID_REGMT_MODE.", ".$LCR_S_ID_REGMT_MODE.", ".$PRB_S_ID_REGMT_MODE.") "; 

		 //récuperer les reglements de la periode
		 $query = "SELECT r.ref_reglement, r.ref_contact, r.date_reglement, r.date_echeance, r.date_saisie, r.id_reglement_mode, r.montant_reglement, r.valide,
										 cbrsc.defaut_numero_compte as d_cpt_banque_rsc,
										 cbrscb.defaut_numero_compte as d_cpt_banque_rscb,
										 cbrsv.defaut_numero_compte as d_cpt_banque_rsv,
										 cbrsl.defaut_numero_compte as d_cpt_banque_rsl,
										 cbrsp.defaut_numero_compte as d_cpt_banque_rsp,
										 d.id_type_doc
							FROM reglements r
							
							LEFT JOIN regmt_s_chq rsc ON rsc.ref_reglement = r.ref_reglement
							LEFT JOIN regmt_s_cb rscb ON rscb.ref_reglement = r.ref_reglement
							LEFT JOIN regmt_s_vir rsv ON rsv.ref_reglement = r.ref_reglement
							LEFT JOIN regmt_s_lcr rsl ON rsl.ref_reglement = r.ref_reglement
							LEFT JOIN regmt_s_prb rsp ON rsp.ref_reglement = r.ref_reglement
							
							LEFT JOIN comptes_bancaires cbrsc ON cbrsc.id_compte_bancaire = rsc.id_compte_bancaire_source
							LEFT JOIN comptes_cbs cbs ON cbs.id_compte_cb = rscb.id_compte_cb
							LEFT JOIN comptes_bancaires cbrscb ON cbrscb.id_compte_bancaire = cbs.id_compte_bancaire
							
							LEFT JOIN comptes_bancaires cbrsv ON cbrsv.id_compte_bancaire = rsv.id_compte_bancaire_source
							LEFT JOIN comptes_bancaires cbrsl ON cbrsl.id_compte_bancaire = rsl.id_compte_bancaire_source
							LEFT JOIN comptes_bancaires cbrsp ON cbrsp.id_compte_bancaire = rsp.id_compte_bancaire_source
							
							
							
							LEFT JOIN reglements_docs rd ON rd.ref_reglement = r.ref_reglement
							LEFT JOIN documents d ON d.ref_doc = rd.ref_doc
							
							WHERE  ".$query_where."
							
								".$query_limit;
			$resultat = $bdd->query($query);
			
			while ($tmp = $resultat->fetchObject()) {
				if ($tmp->id_reglement_mode == $CHQ_S_ID_REGMT_MODE) {$tmp->d_cpt_banque	= $tmp->d_cpt_banque_rsc;}
				if ($tmp->id_reglement_mode == $CB_S_ID_REGMT_MODE) {$tmp->d_cpt_banque	= $tmp->d_cpt_banque_rscb;}
				if ($tmp->id_reglement_mode == $VIR_S_ID_REGMT_MODE) {$tmp->d_cpt_banque	= $tmp->d_cpt_banque_rsv;}
				if ($tmp->id_reglement_mode == $LCR_S_ID_REGMT_MODE) {$tmp->d_cpt_banque	= $tmp->d_cpt_banque_rsl;}
				if ($tmp->id_reglement_mode == $PRB_S_ID_REGMT_MODE) {$tmp->d_cpt_banque	= $tmp->d_cpt_banque_rsp;}
				if (!$tmp->d_cpt_banque) {$tmp->d_cpt_banque	= $DEFAUT_COMPTE_BANQUES;}
				if ($tmp->id_type_doc && ($tmp->id_type_doc == $DEVIS_CLIENT_ID_TYPE_DOC || $tmp->id_type_doc == $LIVRAISON_CLIENT_ID_TYPE_DOC || $tmp->id_type_doc == $COMMANDE_CLIENT_ID_TYPE_DOC || $tmp->id_type_doc == $FACTURE_CLIENT_ID_TYPE_DOC)) {$infos["doc_ACCEPT_REGMT"] = "1";}
				
				$query3 = "SELECT id_operation FROM compta_journaux_opes 
									WHERE ref_operation = '".addslashes($tmp->ref_reglement)."' && id_operation_type = '6' "; 
				$resultat3 = $bdd->query($query3);
				if (!$tmp3 = $resultat3->fetchObject()) {
					if (!isset($journaux_banques[$tmp->d_cpt_banque])) {
						$journal_banque_arrivee =  compta_journaux::check_exist_journaux ($DEFAUT_ID_JOURNAL_BANQUES, $tmp->d_cpt_banque);
						$journaux_banques[$journal_banque_arrivee->getContrepartie ()] = $journal_banque_arrivee;
					} else {
						$journal_banque_arrivee = $journaux_banques[$tmp->d_cpt_banque];
					}
					
					// récupération du compte tier vente
					$numero_compte_comptable = $DEFAUT_COMPTE_TIERS_ACHAT;
					if (isset($infos["doc_ACCEPT_REGMT"]) && $infos["doc_ACCEPT_REGMT"] == "1") {$numero_compte_comptable = $DEFAUT_COMPTE_TIERS_VENTE;}
					$tmp_contact = new contact ($tmp->ref_contact);
					if ($tmp_contact->getRef_contact()) {
						$profils 	= $tmp_contact->getProfils ();
						//gestion des cas ambigus entre profils et sens de règlement
						if (isset($profils[$CLIENT_ID_PROFIL]) && !isset($profils[$FOURNISSEUR_ID_PROFIL]) ) { $ID_PROFIL = $CLIENT_ID_PROFIL;}
						if (!isset($profils[$CLIENT_ID_PROFIL]) && isset($profils[$FOURNISSEUR_ID_PROFIL]) ) { $ID_PROFIL = $FOURNISSEUR_ID_PROFIL;}
						
						if (isset($profils[$CLIENT_ID_PROFIL]) && isset($profils[$FOURNISSEUR_ID_PROFIL]) ) { 
							$ID_PROFIL = $FOURNISSEUR_ID_PROFIL;
							if (isset($infos["doc_ACCEPT_REGMT"]) && $infos["doc_ACCEPT_REGMT"] == "1") {$ID_PROFIL = $CLIENT_ID_PROFIL;}
						}
						$numero_compte_comptable = $profils[$ID_PROFIL]->getDefaut_numero_compte ();
					} 
					
					//création de opération de journal
					$journal_banque_arrivee->create_operation ($numero_compte_comptable, -$tmp->montant_reglement, $tmp->ref_reglement, $tmp->date_reglement, 6); 
				}
				unset ($query3, $resultat3, $tmp3);
			}
			unset ($query, $resultat, $tmp);
		break;
	}
}
// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

//affichage des résultats dans lmb
include ($DIR.$_SESSION['theme']->getDir_theme()."page_compta_journal_tresorerie_verify.inc.php");

?>