<?php
// *************************************************************************************************************
// TABLEAU DE BORD COMPTA
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");


//infos necessaires pour les recherches
//chargements des exercices
$last_exercices = compta_exercices::charger_compta_exercices ();

// liste des points de vente
$magasins_liste	= charger_all_magasins ();

//chargement des categories de clients
if ($CLIENT_ID_PROFIL != 0) {
	include ($CONFIG_DIR."profil_".$_SESSION['profils'][$CLIENT_ID_PROFIL]->getCode_profil().".config.php");
	contact::load_profil_class($CLIENT_ID_PROFIL);
	$liste_categories_client = contact_client::charger_clients_categories ();
}

//chargement des categories de fournisseurs
if ($FOURNISSEUR_ID_PROFIL != 0) {
	include ($CONFIG_DIR."profil_".$_SESSION['profils'][$FOURNISSEUR_ID_PROFIL]->getCode_profil().".config.php"); 
	contact::load_profil_class($FOURNISSEUR_ID_PROFIL);
	$liste_categories_fournisseur = contact_fournisseur::charger_fournisseurs_categories ();
}

//liste des lieux de stock
$stocks_liste	= fetch_all_stocks();

//liste des catégories d'articles principales
$liste_art_categ = get_art_categs_racine ();

//chargement des comptes bancaires
$comptes_bancaires	= compte_bancaire::charger_comptes_bancaires();


//chargement des caisses
$comptes_caisses	= compte_caisse::charger_comptes_caisses("", 1);







//Chargemant des différents CA et soldes

$CA_categ_client = array();
$CA_categ_fournisseur = array();
$CA_magasins = array();
$CA_activites = array();
$CA_valeur_stocks = array();
$Solde_compte_bancaire = array();
$Solde_caisses = array();
$Solde_categ_client = array();
$Solde_categ_fournisseur = array();

for ($i = 0; $i < 3 ; $i++) {
	if (!isset($last_exercices[$i])) { break;}
	
	//chargement des CA par catégorie de client
	foreach ($liste_categories_client as $categ_client) {
		if (!isset($CA_categ_client[$categ_client->id_client_categ])) {$CA_categ_client[$categ_client->id_client_categ] = array();}
		$where = "";
		if ($categ_client->id_client_categ == $DEFAUT_ID_CLIENT_CATEG) {$where .= " || ac.id_client_categ IS NULL || d.ref_contact IS NULL ";}
		$montant_CA = 0;
		$query = "SELECT d.ref_doc, d.date_creation_doc date_creation, dt.lib_type_doc, de.lib_etat_doc, 
										 SUM(ROUND(dl.qte * dl.pu_ht * (1-dl.remise/100) ,2)) as montant_ttc
							FROM documents d 
								LEFT JOIN docs_lines dl ON dl.ref_doc = d.ref_doc && dl.visible = 1
								LEFT JOIN documents_types dt ON d.id_type_doc = dt.id_type_doc
								LEFT JOIN documents_etats de ON d.id_etat_doc = de.id_etat_doc
								LEFT JOIN annu_client ac ON d.ref_contact = ac.ref_contact
							WHERE ( ac.id_client_categ = '".$categ_client->id_client_categ."' ".$where." ) && dl.ref_doc_line_parent IS NULL && d.id_etat_doc IN (16,18,19)
										&& date_creation_doc < '".$last_exercices[$i]->date_fin."' && date_creation_doc > '".$last_exercices[$i]->date_debut."' 
							GROUP BY d.ref_doc 
							ORDER BY date_creation DESC, d.id_type_doc ASC
							";
		$resultat = $bdd->query ($query);
		//echo $query;
		while ($doc = $resultat->fetchObject()) { 
			$montant_CA += $doc->montant_ttc;
		}
		$CA_categ_client[$categ_client->id_client_categ][$i] = $montant_CA;
	}
	unset ($doc, $query, $resultat);
	
	//chargement des CA par catégorie de fournisseur
	foreach ($liste_categories_fournisseur as $categ_fournisseur) {
		if (!isset($CA_categ_fournisseur[$categ_fournisseur->id_fournisseur_categ])) {$CA_categ_fournisseur[$categ_fournisseur->id_fournisseur_categ] = array();}
		$where = "";
		if ($categ_fournisseur->id_fournisseur_categ == $DEFAUT_ID_FOURNISSEUR_CATEG) {$where .= " || af.id_fournisseur_categ IS NULL || d.ref_contact IS NULL ";}
		$montant_CA = 0;
		$query = "SELECT d.ref_doc, d.date_creation_doc date_creation, dt.lib_type_doc, de.lib_etat_doc, 
										 SUM(ROUND(dl.qte * dl.pu_ht * (1-dl.remise/100) ,2)) as montant_ttc
							FROM documents d 
								LEFT JOIN docs_lines dl ON dl.ref_doc = d.ref_doc && dl.visible = 1
								LEFT JOIN documents_types dt ON d.id_type_doc = dt.id_type_doc
								LEFT JOIN documents_etats de ON d.id_etat_doc = de.id_etat_doc
								LEFT JOIN annu_fournisseur af ON d.ref_contact = af.ref_fournisseur
							WHERE ( af.id_fournisseur_categ = '".$categ_fournisseur->id_fournisseur_categ."' ".$where." ) && dl.ref_doc_line_parent IS NULL && d.id_etat_doc IN (32, 34 , 35)
										&& date_creation_doc < '".$last_exercices[$i]->date_fin."' && date_creation_doc > '".$last_exercices[$i]->date_debut."' 
							GROUP BY d.ref_doc 
							ORDER BY date_creation DESC, d.id_type_doc ASC
							";
		$resultat = $bdd->query ($query);
		//echo $query;
		while ($doc = $resultat->fetchObject()) { 
			$montant_CA += $doc->montant_ttc;
		}
		$CA_categ_fournisseur[$categ_fournisseur->id_fournisseur_categ][$i] = $montant_CA;
	}
	unset ($doc, $query, $resultat);
	
	
	//chargement des CA par point de vente
	foreach ($magasins_liste as $magasin) {
		if (!isset($CA_magasins[$magasin->id_magasin])) {$CA_magasins[$magasin->id_magasin] = array();}
		$where = "";
		if ($magasin->id_magasin == $DEFAUT_ID_MAGASIN) {$where .= " || df.id_magasin IS NULL ";}
		$montant_CA = 0;
		$query = "SELECT d.ref_doc, d.date_creation_doc date_creation, dt.lib_type_doc, de.lib_etat_doc, 
										 SUM(ROUND(dl.qte * dl.pu_ht * (1-dl.remise/100) ,2)) as montant_ttc
							FROM documents d 
								LEFT JOIN docs_lines dl ON dl.ref_doc = d.ref_doc && dl.visible = 1
								LEFT JOIN doc_fac df ON df.ref_doc = d.ref_doc
								LEFT JOIN documents_types dt ON d.id_type_doc = dt.id_type_doc
								LEFT JOIN documents_etats de ON d.id_etat_doc = de.id_etat_doc
							WHERE ( df.id_magasin = '".$magasin->id_magasin."' ".$where." ) && dl.ref_doc_line_parent IS NULL && d.id_etat_doc IN (16,18,19)
										&& date_creation_doc < '".$last_exercices[$i]->date_fin."' && date_creation_doc > '".$last_exercices[$i]->date_debut."' 
							GROUP BY d.ref_doc 
							ORDER BY date_creation DESC, d.id_type_doc ASC
							";
		$resultat = $bdd->query ($query);
		//echo $query;
		while ($doc = $resultat->fetchObject()) { 
			$montant_CA += $doc->montant_ttc;
		}
		$CA_magasins[$magasin->id_magasin][$i] = $montant_CA;
	}
	unset ($doc, $query, $resultat);
	
	
	//chargement des CA par activité
	foreach ($liste_art_categ as $art_categ) {
		if (!isset($CA_activites[$art_categ->ref_art_categ])) {$CA_activites[$art_categ->ref_art_categ] = array();}
		
		$where = "";
		$tmp_list_child_categ = array();
		$tmp_list_child_categ = get_child_categories ($tmp_list_child_categ, $art_categ->ref_art_categ);
		foreach ($tmp_list_child_categ as $child_categ) {
			if  ($where) { $where .= " , ";}
			$where .= "'".$child_categ."'";
		}
		$montant_CA = 0;
		$query = "SELECT d.ref_doc, d.date_creation_doc date_creation, dt.lib_type_doc, de.lib_etat_doc, 
										 SUM(ROUND(dl.qte * dl.pu_ht * (1-dl.remise/100) ,2)) as montant_ttc
							FROM docs_lines dl 
								LEFT JOIN articles a ON a.ref_article = dl.ref_article
								LEFT JOIN documents d ON dl.ref_doc = d.ref_doc
								LEFT JOIN documents_types dt ON d.id_type_doc = dt.id_type_doc
								LEFT JOIN documents_etats de ON d.id_etat_doc = de.id_etat_doc
							WHERE  a.ref_art_categ  IN ( ".$where."  ) && dl.ref_doc_line_parent IS NULL && d.id_etat_doc IN (16,18,19) && dl.visible = 1
										&& date_creation_doc < '".$last_exercices[$i]->date_fin."' && date_creation_doc > '".$last_exercices[$i]->date_debut."' 
							GROUP BY d.ref_doc 
							ORDER BY date_creation DESC, d.id_type_doc ASC
							";
		$resultat = $bdd->query ($query);
		//echo $query;
		while ($doc = $resultat->fetchObject()) { 
			$montant_CA += $doc->montant_ttc;
		}
		$CA_activites[$art_categ->ref_art_categ][$i] = $montant_CA;
	}
	unset ($doc, $query, $resultat);
	
	
	//chargement des valeur de stocks
	foreach ($stocks_liste as $stock) {
		if (!isset($CA_valeur_stocks[$stock->id_stock])) {$CA_valeur_stocks[$stock->id_stock] = array();}
		
		$montant_CA = 0;
		$query = "SELECT sm.date, sm.ref_article, sm.id_stock, SUM(sm.qte) as qte , a.prix_achat_ht
								FROM stocks_moves sm 
								LEFT JOIN articles a ON sm.ref_article = a.ref_article
								WHERE id_stock = '".$stock->id_stock."' && date > '".$last_exercices[$i]->date_debut."' 
								GROUP BY ref_article
								";
		$resultat = $bdd->query ($query);
		//echo $query;
		if ($stock_moves = $resultat->fetchObject()) {
		$summ_stock=0;
			while ($stock_moves = $resultat->fetchObject()) { 
			
				$qte_article = 0;
				$qte_article = -1*$stock_moves->qte;
				$query2 = "SELECT ref_stock_article, ref_article, id_stock, qte
								FROM stocks_articles 
								WHERE id_stock = '".$stock->id_stock."' && ref_article = '".$stock_moves->ref_article."'
								GROUP BY ref_article
								";
				$resultat2 = $bdd->query ($query2);
				while ($stock_articles = $resultat2->fetchObject()) { 
					$qte_article = $stock_articles->qte + $qte_article;
				}
				$montant_CA +=  $stock_moves->prix_achat_ht * $qte_article;
				//$montant_CA +=  $qte_article;
			}
		} else {
			$query2 = "SELECT  sa.ref_article, sa.id_stock, SUM(sa.qte) as qte , a.prix_achat_ht
								FROM stocks_articles sa 
								LEFT JOIN articles a ON sa.ref_article = a.ref_article
								WHERE id_stock = '".$stock->id_stock."'
								GROUP BY ref_article
								";
			$resultat2 = $bdd->query ($query2);
			while ($stock_articles = $resultat2->fetchObject()) { 
				$montant_CA +=  $stock_articles->prix_achat_ht *$stock_articles->qte;
				//$montant_CA += $stock_articles->qte;
			}
		
		}
		$CA_valeur_stocks[$stock->id_stock][$i] = $montant_CA;
	}
	unset ($stock, $query, $resultat);
	
	
	
	
}

//solde comptes bancaires
foreach ($comptes_bancaires as $compte_b) {
$compte_bancaire	= new compte_bancaire($compte_b->id_compte_bancaire);
$Solde_compte_bancaire[$compte_b->id_compte_bancaire] = $compte_bancaire->solde_calcule_releve (date("Y-m-d"));
}

//solde par caisse
foreach ($comptes_caisses as $caisse) {
	$Solde_caisses[$caisse->id_compte_caisse] = 0;
}

//Solde des comptes par catégories client
foreach ($liste_categories_client as $categ_client) {
	$solde_contact = 0;
	$where = "";
	if ($categ_client->id_client_categ == $DEFAUT_ID_CLIENT_CATEG) {$where .= " || ac.id_client_categ IS NULL || d.ref_contact IS NULL ";}
	$livre_documents = array();
	$query_doc = "SELECT d.ref_doc, d.id_type_doc, dt.lib_type_doc, d.id_etat_doc, d.ref_contact, de.lib_etat_doc,

										( SELECT SUM(qte * pu_ht * (1-remise/100) * (1+tva/100))
											FROM docs_lines dl
											WHERE d.ref_doc = dl.ref_doc && ISNULL(dl.ref_doc_line_parent) && visible = 1 ) as montant_ttc,

											date_creation_doc as date,
											fnr.lib_niveau_relance 	

						FROM documents d 
							LEFT JOIN documents_types dt ON d.id_type_doc = dt.id_type_doc 
							LEFT JOIN documents_etats de ON d.id_etat_doc = de.id_etat_doc 
							LEFT JOIN doc_fac df ON d.ref_doc = df.ref_doc 
							LEFT JOIN factures_relances_niveaux fnr ON fnr.id_niveau_relance = df.id_niveau_relance 
							LEFT JOIN annu_client ac ON d.ref_contact = ac.ref_contact
						WHERE ( ac.id_client_categ = '".$categ_client->id_client_categ."' ".$where." ) && d.id_type_doc = '4' && d.id_etat_doc != '17'
						GROUP BY d.ref_doc 
						ORDER BY date ASC";

	$doc = $bdd->query ($query_doc);
	while ($var_doc = $doc->fetchObject()) {
		$solde_contact += -1*number_format($var_doc->montant_ttc, $TARIFS_NB_DECIMALES, ".", ""	);
	}
	// Sélection des règlements du contact
	$where = "";
	if ($categ_client->id_client_categ == $DEFAUT_ID_CLIENT_CATEG) {$where .= " || ac.id_client_categ IS NULL ";}
	$livre_reglements = array();
	$query_reg = "SELECT r.ref_reglement, r.id_reglement_mode, r.ref_contact, rm.lib_reglement_mode,
									 r.date_saisie as date, r.montant_reglement as montant_ttc, rm.type_reglement , 
									 ac.id_client_categ, af.id_fournisseur_categ, d.id_type_doc

						FROM reglements r  
							LEFT JOIN reglements_modes rm ON r.id_reglement_mode = rm.id_reglement_mode 
							LEFT JOIN reglements_docs  rd ON r.ref_reglement = rd.ref_reglement 
							LEFT JOIN documents d ON d.ref_doc = rd.ref_doc
							LEFT JOIN annuaire_profils ap ON r.ref_contact = ap.ref_contact
							LEFT JOIN annu_client ac ON r.ref_contact = ac.ref_contact
							LEFT JOIN annu_fournisseur af ON r.ref_contact = af.ref_fournisseur
						WHERE ( ac.id_client_categ = '".$categ_client->id_client_categ."' ".$where.") && r.id_reglement_mode != '15' && r.id_reglement_mode != '16' && valide = 1 && ( rd.liaison_valide = 1 || rd.liaison_valide IS NULL ) && ( d.id_type_doc IN (1,2,3,4) || d.id_type_doc IS NULL) 
						GROUP BY r.ref_reglement 
						ORDER BY date ASC";

	$resultat_reg = $bdd->query ($query_reg);
	while ($var_reg = $resultat_reg->fetchObject()) {
		$livre_reglements[$var_reg->ref_reglement] = $var_reg; 
	}
	//on calcul un ran qui cumule l'ensemble des résultats

	foreach ($livre_reglements as $reglement) {	
		// Règlement en débit
		if (isset($reglement->ref_reglement) && $reglement->type_reglement == "sortant") {
			if ($reglement->id_fournisseur_categ && $reglement->id_type_doc == NULL ) {continue;}
			$solde_contact = $solde_contact - number_format($reglement->montant_ttc, $TARIFS_NB_DECIMALES, ".", ""	);
		} 
		//règlement en crédit
		if (isset($reglement->ref_reglement) && $reglement->type_reglement == "entrant") { 
			$solde_contact = $solde_contact + number_format($reglement->montant_ttc, $TARIFS_NB_DECIMALES, ".", ""	);
		}
	}
	$Solde_categ_client[$categ_client->id_client_categ] = $solde_contact;
}






//Solde des comptes par catégories fournisseur
foreach ($liste_categories_fournisseur as $categ_fournisseur) {
	$solde_contact = 0;
	$where = "";
	if ($categ_fournisseur->id_fournisseur_categ == $DEFAUT_ID_FOURNISSEUR_CATEG) {$where .= " || af.id_fournisseur_categ IS NULL || d.ref_contact IS NULL ";}
	$livre_documents = array();
	$query_doc = "SELECT d.ref_doc, d.id_type_doc, dt.lib_type_doc, d.id_etat_doc, d.ref_contact, de.lib_etat_doc,

										( SELECT SUM(qte * pu_ht * (1-remise/100) * (1+tva/100))
											FROM docs_lines dl
											WHERE d.ref_doc = dl.ref_doc && ISNULL(dl.ref_doc_line_parent) && visible = 1 ) as montant_ttc,

											date_creation_doc as date,
											fnr.lib_niveau_relance 	

						FROM documents d 
							LEFT JOIN documents_types dt ON d.id_type_doc = dt.id_type_doc 
							LEFT JOIN documents_etats de ON d.id_etat_doc = de.id_etat_doc 
							LEFT JOIN doc_fac df ON d.ref_doc = df.ref_doc 
							LEFT JOIN factures_relances_niveaux fnr ON fnr.id_niveau_relance = df.id_niveau_relance 
							LEFT JOIN annu_fournisseur af ON d.ref_contact = af.ref_fournisseur
						WHERE ( af.id_fournisseur_categ = '".$categ_fournisseur->id_fournisseur_categ."' ".$where." ) && d.id_type_doc = '8' && d.id_etat_doc != '33'
						GROUP BY d.ref_doc 
						ORDER BY date ASC";

	$doc = $bdd->query ($query_doc);
	//	echo nl2br($query_ran_last_doc);
	while ($var_doc = $doc->fetchObject()) {
		$solde_contact += -1*number_format($var_doc->montant_ttc, $TARIFS_NB_DECIMALES, ".", ""	);
	}

	// Sélection des règlements du contact
	$where = "";
	if ($categ_fournisseur->id_fournisseur_categ == $DEFAUT_ID_FOURNISSEUR_CATEG) {$where .= " || af.id_fournisseur_categ IS NULL ";}
	$livre_reglements = array();
	$query_reg = "SELECT r.ref_reglement, r.id_reglement_mode, r.ref_contact, rm.lib_reglement_mode,
									 r.date_saisie as date, r.montant_reglement as montant_ttc, rm.type_reglement, 
									 ac.id_client_categ, af.id_fournisseur_categ, d.id_type_doc

						FROM reglements r  
							LEFT JOIN reglements_modes rm ON r.id_reglement_mode = rm.id_reglement_mode 
							LEFT JOIN reglements_docs  rd ON r.ref_reglement = rd.ref_reglement 
							LEFT JOIN documents d ON d.ref_doc = rd.ref_doc
							LEFT JOIN annu_fournisseur af ON r.ref_contact = af.ref_fournisseur
							LEFT JOIN annu_client ac ON r.ref_contact = ac.ref_contact
						WHERE ( af.id_fournisseur_categ = '".$categ_fournisseur->id_fournisseur_categ."' ".$where." )  && r.id_reglement_mode != '13' && r.id_reglement_mode != '14' && ( rd.liaison_valide = 1 || rd.liaison_valide IS NULL ) && ( d.id_type_doc IN (5,6,7,8) || d.id_type_doc IS NULL) 
						GROUP BY r.ref_reglement 
						ORDER BY date ASC";

	$resultat_reg = $bdd->query ($query_reg);
	//echo nl2br($query_reg);
	while ($var_reg = $resultat_reg->fetchObject()) {
		$livre_reglements[$var_reg->ref_reglement] = $var_reg; 
	}
	//on calcul un ran qui cumule l'ensemble des résultats

	foreach ($livre_reglements as $reglement) {	
		// Règlement en débit
		if (isset($reglement->ref_reglement) && $reglement->type_reglement == "sortant") {
			$solde_contact = $solde_contact + number_format($reglement->montant_ttc, $TARIFS_NB_DECIMALES, ".", ""	);
		} 
		//règlement en crédit
		if (isset($reglement->ref_reglement) && $reglement->type_reglement == "entrant") { 
			if ($reglement->id_client_categ && $reglement->id_type_doc == NULL ) {continue;}
			$solde_contact = $solde_contact - number_format($reglement->montant_ttc, $TARIFS_NB_DECIMALES, ".", ""	);
		}
	}
	$Solde_categ_fournisseur[$categ_fournisseur->id_fournisseur_categ] = $solde_contact;
}


// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_compta_tableau_bord.inc.php");

?>