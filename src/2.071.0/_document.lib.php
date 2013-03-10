<?php
// *************************************************************************************************************
// FONCTIONS DE GESTION DES DOCUMENTS 
// *************************************************************************************************************

// Fonction permettant d'ouvrir un document existant
function open_doc ($ref_doc) {
	global $bdd;
	global $DIR;

	/* Utilisation du document en cache si besoin
	if (isset($_SESSION['user']->doc_actu) && $ref_doc == $_SESSION['user']->doc_actu->getRef_doc ()) {
		return $_SESSION['user']->doc_actu;
	}
	*/


	$query = "SELECT ref_doc, id_type_doc FROM documents
						WHERE ref_doc = '".addslashes($ref_doc)."' ";
	$resultat = $bdd->query ($query);
	if (!$doc = $resultat->fetchObject()) { return false; }

	// Creation de l'objet correspondant
	require_once ($DIR."documents/_doc_".strtolower($_SESSION['types_docs'][$doc->id_type_doc]->code_doc).".class.php");
	$classe_doc = "doc_".$_SESSION['types_docs'][$doc->id_type_doc]->code_doc;
	$document = new $classe_doc ($ref_doc);
 
	$document->open_doc();

	if (!$document->getRef_doc()) { return false; }

	/* Mise en cache de session
	$_SESSION['user']->doc_actu = $document;
	*/

	return $document;
}


// Fonction permettant de créer un document
function create_doc ($id_type_doc) {
	global $DIR;
	// Creation de l'objet correspondant
	require_once ($DIR."documents/_doc_".strtolower($_SESSION['types_docs'][$id_type_doc]->code_doc).".class.php");
	$classe_doc = "doc_".$_SESSION['types_docs'][$id_type_doc]->code_doc;
	$document = new $classe_doc ();
	$document->create_doc ();

	if (!$document->getRef_doc()) { return false; }

	return $document;
}


// Définition du type de ligne d'un document
function define_type_of_line ($ref_article) {
	if ($ref_article == "INFO" || $ref_article == "INFORMATION") { 
		return "information";
	}
	elseif ($ref_article == "SSTOTAL") { 
		return "soustotal";
	}
	elseif (substr($ref_article, 0, 4) == "TAXE") {
		return "taxe";
	}
	else {
		return "article";
	}
}

// **********************************************************
// gestion des différents modèles de ligne d'information
// **********************************************************
function charge_docs_infos_lines ($id_type_doc = "") {
	global $bdd;
	
	$modeles_lignes = array();
	$query = "SELECT id_doc_info_line, id_type_doc, lib_line, desc_line, desc_line_interne
						FROM docs_infos_lines
						";
	$resultat = $bdd->query ($query);
	while ($ligne = $resultat->fetchObject()) {
		if ($id_type_doc) {
			$tmp_array = explode(";", $ligne->id_type_doc);
			if (in_array($id_type_doc, $tmp_array)) {
				$modeles_lignes[] = $ligne;
			}
		} else {
			$modeles_lignes[] = $ligne;
		}
	}
	return $modeles_lignes;
}
//chargement des infos d'un modèle ligne
function charge_doc_info_line ($id_doc_info_line) {
	global $bdd;
	
	$query = "SELECT id_doc_info_line, id_type_doc, lib_line, desc_line, desc_line_interne
						FROM docs_infos_lines
						WHERE id_doc_info_line = '".$id_doc_info_line."' 
						";
	$resultat = $bdd->query ($query);
	if (!$ligne = $resultat->fetchObject()) { return false;}
	
	return $ligne;
}
//ajout des infos d'un modèle ligne
function add_doc_info_line ($id_type_doc, $lib_line, $desc_line, $desc_line_interne) {
	global $bdd;
	

	if (!count($id_type_doc)) {
		$GLOBALS['_ALERTES']['bad_id_type_doc'] = 1;
	}
	if (!$lib_line) {
		$GLOBALS['_ALERTES']['bad_lib_line'] = 1;
	}
	// *************************************************
	// Verification qu'il n'y a pas eu d'erreur
	if (count($GLOBALS['_ALERTES'])) {
		return false;
	}
	
	$query = "INSERT INTO docs_infos_lines (id_type_doc, lib_line, desc_line, desc_line_interne)
						VALUES ('".$id_type_doc."', '".addslashes($lib_line)."', '".addslashes($desc_line)."', '".addslashes($desc_line_interne)."') 
					
						";
	$bdd->exec ($query);
	
	return true;
}
//maj des infos d'un modèle ligne
function maj_doc_info_line ($id_doc_info_line, $id_type_doc, $lib_line, $desc_line, $desc_line_interne) {
	global $bdd;
	
	if (!count($id_type_doc)) {
		$GLOBALS['_ALERTES']['bad_id_type_doc'] = 1;
	}
	if (!$lib_line) {
		$GLOBALS['_ALERTES']['bad_lib_line'] = 1;
	}
	// *************************************************
	// Verification qu'il n'y a pas eu d'erreur
	if (count($GLOBALS['_ALERTES'])) {
		return false;
	}
	$query = "UPDATE docs_infos_lines
						SET id_type_doc = '".$id_type_doc."', lib_line = '".addslashes($lib_line)."', desc_line = '".addslashes($desc_line)."', desc_line_interne = '".addslashes($desc_line_interne)."'
						WHERE id_doc_info_line = '".$id_doc_info_line."'
					
						";
	$bdd->exec ($query);
	
	return true;
}
//del des infos d'un modèle ligne
function del_doc_info_line ($id_doc_info_line) {
	global $bdd;
	
	$query = "DELETE FROM docs_infos_lines
						WHERE id_doc_info_line = '".$id_doc_info_line."'
						";
	$bdd->exec ($query);
	
	return true;
}

// Supprime les saut de ligne d'une chaine
function defaire_sauts2lignes ($texte) {
	$texte = str_replace($texte, "\n", "<br>");
	$texte = str_replace($texte, "\r", "<br>");
	return $texte;
}
// Remet les saut de ligne d'une chaine
function refaire_sauts2lignes ($texte) {
	$texte = str_replace($texte, "<br>", "\n");
	return $texte;
}



// Charge la liste des commandes en cours
function get_commandes_clients ($id_stock = "") {
	global $bdd;

	if (!$id_stock) {
	$id_stock = $_SESSION['magasin']->getId_stock ();
	$where_doc = "";
	} else {
	$where_doc = " && dcdc.id_stock = ".$id_stock;
	}
	
	$commandes = array();
	$query = "SELECT d.ref_doc, d.id_type_doc, dt.lib_type_doc, d.id_etat_doc, de.lib_etat_doc, d.ref_contact, d.nom_contact, dcdc.id_stock, s.lib_stock, s.abrev_stock,
										( SELECT SUM(dl.qte * dl.pu_ht * (1-dl.remise/100) * (1+dl.tva/100))
									 		FROM docs_lines dl
									 		WHERE d.ref_doc = dl.ref_doc && ISNULL(dl.ref_doc_line_parent) && visible = 1 
									 	) as montant_ttc,
									 	d.date_creation_doc as date_doc
						FROM documents d 
							LEFT JOIN documents_types dt ON d.id_type_doc = dt.id_type_doc 
							LEFT JOIN documents_etats de ON d.id_etat_doc = de.id_etat_doc 
							LEFT JOIN docs_lines dl ON d.ref_doc = dl.ref_doc 
							LEFT JOIN doc_cdc dcdc ON d.ref_doc = dcdc.ref_doc 
							LEFT JOIN stocks s ON s.id_stock = dcdc.id_stock 
						WHERE d.id_type_doc = 2 && d.id_etat_doc = 9 ".$where_doc."
						GROUP BY d.ref_doc
						ORDER BY date_doc DESC ";
	$resultat = $bdd->query ($query);

	while ($doc = $resultat->fetchObject()) {
		$doc->lines = array();
		$query2 = "SELECT dl.ref_article, dl.lib_article, dl.desc_article, SUM(dl.qte) as qte, SUM(dlc.qte_livree) as qte_livree, 
									 a.modele,	a.ref_oem, a.ref_interne, a.ref_constructeur, ann.nom nom_constructeur, ac.lib_art_categ, 
										( SELECT SUM(sa.qte) 
									 		FROM stocks_articles sa
									 		WHERE sa.ref_article = dl.ref_article && id_stock = ".$id_stock."
									 	) as qte_stock 
							FROM docs_lines dl
								LEFT JOIN doc_lines_cdc dlc ON dl.ref_doc_line = dlc.ref_doc_line
								LEFT JOIN articles a ON dl.ref_article = a.ref_article
								LEFT JOIN annuaire ann ON a.ref_constructeur = ann.ref_contact 
								LEFT JOIN art_categs ac ON a.ref_art_categ = ac.ref_art_categ 
							WHERE ref_doc = '".$doc->ref_doc."' && ISNULL(dl.ref_doc_line_parent)
							GROUP BY dl.qte, dl.ref_article 
							ORDER BY dl.ordre "; 
		$resultat2 = $bdd->query($query2); 
	while ($line = $resultat2->fetchObject()) { $doc->lines[] = $line;	}
		$commandes[] = $doc;
	}

	return $commandes;
}



// Charge la liste des commandes en cours
function get_commandes_fournisseurs ($id_stock = "") {
	global $bdd;

	if (!$id_stock) {
	$where_doc = "";
	} else {
	$where_doc = " && dcdf.id_stock = ".$id_stock;
	}
	
	$commandes = array();
	$query = "SELECT d.ref_doc, d.id_type_doc, dt.lib_type_doc, d.id_etat_doc, de.lib_etat_doc, ref_contact, nom_contact,  dcdf.id_stock, s.lib_stock, s.abrev_stock,
										( SELECT SUM(qte * pu_ht * (1-remise/100) * (1+tva/100))
									 		FROM docs_lines dl
									 		WHERE d.ref_doc = dl.ref_doc && ISNULL(dl.ref_doc_line_parent) && visible = 1 
									 	) as montant_ttc,
										d.date_creation_doc as date_doc
						FROM documents d 
							LEFT JOIN documents_types dt ON d.id_type_doc = dt.id_type_doc 
							LEFT JOIN documents_etats de ON d.id_etat_doc = de.id_etat_doc 
							LEFT JOIN docs_lines dl ON d.ref_doc = dl.ref_doc 
							LEFT JOIN doc_cdf dcdf ON d.ref_doc = dcdf.ref_doc 
							LEFT JOIN stocks s ON s.id_stock = dcdf.id_stock 
						WHERE d.id_type_doc = 6 && d.id_etat_doc = 27  ".$where_doc."
						GROUP BY ref_doc
						ORDER BY date_doc DESC ";
	$resultat = $bdd->query ($query);

	while ($doc = $resultat->fetchObject()) {
		$doc->lines = array();
		$query2 = "SELECT dl.ref_article, dl.lib_article, dl.desc_article, dl.qte, dlf.qte_recue as qte_recue,
										  a.ref_oem, a.ref_interne, a.ref_constructeur, ann.nom nom_constructeur, ac.lib_art_categ
							FROM docs_lines dl
								LEFT JOIN doc_lines_cdf dlf ON dl.ref_doc_line = dlf.ref_doc_line
								LEFT JOIN articles a ON dl.ref_article = a.ref_article
								LEFT JOIN annuaire ann ON a.ref_constructeur = ann.ref_contact 
								LEFT JOIN art_categs ac ON a.ref_art_categ = ac.ref_art_categ 
							WHERE ref_doc = '".$doc->ref_doc."' && ISNULL(dl.ref_doc_line_parent) 
							ORDER BY dl.ordre "; 
		$resultat2 = $bdd->query($query2); 
		while ($line = $resultat2->fetchObject()) { $doc->lines[] = $line; }
		$commandes[] = $doc;
	}

	return $commandes;
}



// Fonction retournant la liste des Bons de Livraisons Non Facturés
function get_livraisons_to_facture ($id_stock = NULL, $order = "") {
	global $bdd;

	if (!$order) { $order = " date_creation ASC";}
	
	$bls = array();
	$query = "SELECT d.ref_doc, d.ref_contact, d.nom_contact, d.id_type_doc, dt.lib_type_doc, d.id_etat_doc, de.lib_etat_doc,
									 d.date_creation_doc date_creation,
									 dbc.id_stock, s.lib_stock, s.abrev_stock,
									 ( SELECT SUM(qte * pu_ht * (1-remise/100) * (1+tva/100))
									 	 FROM docs_lines dl
									 	 WHERE d.ref_doc = dl.ref_doc && ISNULL(dl.ref_doc_line_parent) && visible = 1 
									 ) as montant_ttc
						FROM documents d
							LEFT JOIN documents_types dt ON d.id_type_doc = dt.id_type_doc 
							LEFT JOIN documents_etats de ON d.id_etat_doc = de.id_etat_doc 
							LEFT JOIN doc_blc dbc ON d.ref_doc = dbc.ref_doc 
							LEFT JOIN stocks s ON s.id_stock = dbc.id_stock 

							LEFT JOIN documents_liaisons dl ON d.ref_doc = dl.ref_doc_source && dl.active = 1
							LEFT JOIN documents d2 ON d2.ref_doc = dl.ref_doc_destination 
						WHERE (d.id_type_doc = 3 && d.id_etat_doc != 12) && dbc.id_stock = ".$id_stock."
						&& d.ref_doc NOT IN (
						SELECT distinct d.ref_doc
						FROM documents d
							LEFT JOIN documents_types dt ON d.id_type_doc = dt.id_type_doc 
							LEFT JOIN documents_etats de ON d.id_etat_doc = de.id_etat_doc 
							LEFT JOIN doc_blc dbc ON d.ref_doc = dbc.ref_doc 
							LEFT JOIN stocks s ON s.id_stock = dbc.id_stock 

							LEFT JOIN documents_liaisons dl ON d.ref_doc = dl.ref_doc_source && dl.active = 1
							LEFT JOIN documents d2 ON d2.ref_doc = dl.ref_doc_destination && (d2.id_type_doc = 4 && d2.id_etat_doc!=17)
						WHERE (d.id_type_doc = 3 && d.id_etat_doc != 12) && d2.ref_doc IS NOT NULL && dbc.id_stock = ".$id_stock."
						)
						ORDER BY ". $order;
	$resultat = $bdd->query($query);
	while ($tmp = $resultat->fetchObject()) { $bls[] = $tmp; }

	return $bls;
}
// Fonction retournant la liste des Bons de Livraisons Fournisseurs Non Facturés
function get_livraisons_fournisseur_to_facture ($id_stock = NULL, $order = "") {
	global $bdd;

	if (!$order) { $order = " date_creation ASC";}
	
	$bls = array();
	$query = "SELECT d.ref_doc, d.ref_contact, d.nom_contact, d.id_type_doc, dt.lib_type_doc, d.id_etat_doc, de.lib_etat_doc,
									 d.date_creation_doc date_creation,
									 dbf.id_stock, s.lib_stock, s.abrev_stock,
									 ( SELECT SUM(qte * pu_ht * (1-remise/100) * (1+tva/100))
									 	 FROM docs_lines dl
									 	 WHERE d.ref_doc = dl.ref_doc && ISNULL(dl.ref_doc_line_parent) && visible = 1 
									 ) as montant_ttc
						FROM documents d
							LEFT JOIN documents_types dt ON d.id_type_doc = dt.id_type_doc 
							LEFT JOIN documents_etats de ON d.id_etat_doc = de.id_etat_doc 
							LEFT JOIN doc_blf dbf ON d.ref_doc = dbf.ref_doc 
							LEFT JOIN stocks s ON s.id_stock = dbf.id_stock 

							LEFT JOIN documents_liaisons dl ON d.ref_doc = dl.ref_doc_source && dl.active = 1
							LEFT JOIN documents d2 ON d2.ref_doc = dl.ref_doc_destination && ( d2.id_type_doc = 8 && d2.id_etat_doc != 33 )
						WHERE (d.id_type_doc = 7 && d.id_etat_doc != 30) && d2.ref_doc IS NULL && dbf.id_stock = ".$id_stock."
						ORDER BY ". $order;
	$resultat = $bdd->query($query);
	while ($tmp = $resultat->fetchObject()) { $bls[] = $tmp; }

	return $bls;
}


// Fonction retournant la liste des Bons de Livraisons Non Facturés d'un contact spécifique
function get_client_livraisons_to_facture ($ref_contact , $order = "") {
	global $bdd;

	if (!$order) { $order = " date_creation ASC";}
	
	$bls = array();
	$query = "SELECT d.ref_doc, d.ref_contact, d.nom_contact, d.id_type_doc, dt.lib_type_doc, d.id_etat_doc, de.lib_etat_doc,
									 d.date_creation_doc date_creation,
									 dbc.id_stock, s.lib_stock, s.abrev_stock,
									 ( SELECT SUM(qte * pu_ht * (1-remise/100) * (1+tva/100))
									 	 FROM docs_lines dl
									 	 WHERE d.ref_doc = dl.ref_doc && ISNULL(dl.ref_doc_line_parent) && visible = 1 
									 ) as montant_ttc
						FROM documents d
							LEFT JOIN documents_types dt ON d.id_type_doc = dt.id_type_doc 
							LEFT JOIN documents_etats de ON d.id_etat_doc = de.id_etat_doc 
							LEFT JOIN doc_blc dbc ON d.ref_doc = dbc.ref_doc 
							LEFT JOIN stocks s ON s.id_stock = dbc.id_stock 

							LEFT JOIN documents_liaisons dl ON d.ref_doc = dl.ref_doc_source && dl.active = 1
							LEFT JOIN documents d2 ON d2.ref_doc = dl.ref_doc_destination && ( d2.id_type_doc = 4 && d2.id_etat_doc != 17 )
						WHERE (d.id_type_doc = 3 && d.id_etat_doc != 12) && d2.ref_doc IS NULL && d.ref_contact = '".$ref_contact."'
						ORDER BY ". $order;
	$resultat = $bdd->query($query);
	while ($tmp = $resultat->fetchObject()) { $bls[] = $tmp; }

	return $bls;
}

// Fonction retournant le nombre des Factures non réglées
function count_factures_to_pay ($id_client_categ = "" ) {
	global $bdd;
	global $DEFAUT_ID_CLIENT_CATEG;
	
	$where = "";
	if (!$id_client_categ) {
		$where = " && ISNULL(ac.id_client_categ)";
	} elseif (trim($id_client_categ) == $DEFAUT_ID_CLIENT_CATEG) {
		$where = " && (ac.id_client_categ = '".$id_client_categ."' || ISNULL(ac.id_client_categ))";	
	} else {
		$where = " && ac.id_client_categ = '".$id_client_categ."' ";	
	}
	$nb_factures = 0;
	$query = "SELECT d.ref_doc, d.date_creation_doc date_creation
						FROM documents d
							LEFT JOIN doc_fac df ON d.ref_doc = df.ref_doc
							LEFT JOIN annu_client ac ON ac.ref_contact = d.ref_contact
							LEFT JOIN factures_relances_niveaux fnr ON df.id_niveau_relance = fnr.id_niveau_relance 
							LEFT JOIN documents_types dt ON d.id_type_doc = dt.id_type_doc 
							LEFT JOIN documents_etats de ON d.id_etat_doc = de.id_etat_doc 
							LEFT JOIN magasins m ON m.id_magasin = df.id_magasin 
						WHERE d.id_type_doc = 4 && d.id_etat_doc != 17 && d.id_etat_doc != 19 ".$where." 
						ORDER BY fnr.id_niveau_relance ASC, date_creation DESC";
	$resultat = $bdd->query($query); 
	while ($tmp = $resultat->fetchObject()) { $nb_factures ++; }

	return $nb_factures;
}
// Fonction retournant le nombre des Factures non réglées par niveau de relance
function count_niveau_factures_to_pay ($id_client_categ = "" , $id_niveau_relance = "") {
	global $bdd;
	global $DEFAUT_ID_CLIENT_CATEG;

        if (is_null($id_niveau_relance))$id_niveau_relance = false;

	$where = "";
	if (!$id_client_categ) {
		$where = " && ISNULL(ac.id_client_categ)";
	} elseif (trim($id_client_categ) == $DEFAUT_ID_CLIENT_CATEG) {
		$where = " && (ac.id_client_categ = '".$id_client_categ."' || ISNULL(ac.id_client_categ))";	
	} else {
		$where = " && ac.id_client_categ = '".$id_client_categ."' ";	
	}
	if ($id_niveau_relance) {
		$where .= " && df.id_niveau_relance = '".$id_niveau_relance."' ";
	} else {
		$where .= " && df.id_niveau_relance IS NULL";
	}
	$nb_factures = 0;
	$query = "SELECT d.ref_doc, d.date_creation_doc date_creation
						FROM documents d
							LEFT JOIN doc_fac df ON d.ref_doc = df.ref_doc
							LEFT JOIN annu_client ac ON ac.ref_contact = d.ref_contact
							LEFT JOIN factures_relances_niveaux fnr ON df.id_niveau_relance = fnr.id_niveau_relance 
							LEFT JOIN documents_types dt ON d.id_type_doc = dt.id_type_doc 
							LEFT JOIN documents_etats de ON d.id_etat_doc = de.id_etat_doc 
							LEFT JOIN magasins m ON m.id_magasin = df.id_magasin 
						WHERE d.id_type_doc = 4 && d.id_etat_doc != 17 && d.id_etat_doc != 19  ".$where." 
						ORDER BY fnr.id_niveau_relance ASC, date_creation DESC";
	$resultat = $bdd->query($query); 
	while ($tmp = $resultat->fetchObject()) { $nb_factures ++; }

	return $nb_factures;
}

// Fonction retournant la liste des Factures client non réglées
function get_factures_to_pay_total ($id_client_categ = "" , $id_niveau_relance = "" ) {
	global $bdd;
	global $DEFAUT_ID_CLIENT_CATEG;
	
	$where = "";
	if (!$id_client_categ) {
		$where = " && ISNULL(ac.id_client_categ)";
	} elseif (trim($id_client_categ) == $DEFAUT_ID_CLIENT_CATEG) {
		$where = " && (ac.id_client_categ = '".$id_client_categ."' || ISNULL(ac.id_client_categ))";	
	} else {
		$where = " && ac.id_client_categ = '".$id_client_categ."' ";	
	}
	if ($id_niveau_relance) {
		$where .= " && df.id_niveau_relance = '".$id_niveau_relance."' ";
	} else {
		$where .= " && df.id_niveau_relance IS NULL";
	}
	$factures_total = 0;
	$query = "SELECT d.ref_doc,
									 ( SELECT SUM(qte * pu_ht * (1-remise/100) * (1+tva/100))
									 	 FROM docs_lines dl
									 	 WHERE d.ref_doc = dl.ref_doc && ISNULL(dl.ref_doc_line_parent) && visible = 1 
									 ) as montant_ttc
						FROM documents d
							LEFT JOIN doc_fac df ON d.ref_doc = df.ref_doc
							LEFT JOIN annu_client ac ON ac.ref_contact = d.ref_contact
							LEFT JOIN factures_relances_niveaux fnr ON df.id_niveau_relance = fnr.id_niveau_relance 
							LEFT JOIN documents_types dt ON d.id_type_doc = dt.id_type_doc 
							LEFT JOIN documents_etats de ON d.id_etat_doc = de.id_etat_doc 
							LEFT JOIN magasins m ON m.id_magasin = df.id_magasin 
						WHERE d.id_type_doc = 4 && d.id_etat_doc != 17 && d.id_etat_doc != 19 ".$where." 
						";
	$resultat = $bdd->query($query); 
	while ($tmp = $resultat->fetchObject()) { $factures_total += $tmp->montant_ttc; }

	return $factures_total;
}

// Fonction retournant la liste des Factures clients non réglées
function get_factures_to_pay ($id_client_categ = "" , $id_niveau_relance = "" ) {
	global $bdd;
	global $DEFAUT_ID_CLIENT_CATEG;
	global $COMPTA_FACTURE_TOPAY_SHOWED_FICHES;
	global $search;
	
	$query_limit	= (($search['page_to_show']-1)*$search['fiches_par_page']).", ".$search['fiches_par_page'];
	$where = "";
	if (!$id_client_categ) {
		$where = " && ISNULL(ac.id_client_categ)";
	} elseif (trim($id_client_categ) == $DEFAUT_ID_CLIENT_CATEG) {
		$where = " && (ac.id_client_categ = '".$id_client_categ."' || ISNULL(ac.id_client_categ))";	
	} else {
		$where = " && ac.id_client_categ = '".$id_client_categ."' ";	
	}
	if ($id_niveau_relance) {
		$where .= " && df.id_niveau_relance = '".$id_niveau_relance."' ";
	} else {
		$where .= " && df.id_niveau_relance IS NULL";
	}
	$factures = array();
	$query = "SELECT d.ref_doc, d.ref_contact, d.nom_contact, d.id_type_doc, dt.lib_type_doc, d.id_etat_doc, de.lib_etat_doc,
									 d.date_creation_doc date_creation,
									 df.id_magasin , m.lib_magasin, m.abrev_magasin,
									 df.date_echeance, df.date_next_relance, fnr.id_niveau_relance, fnr.niveau_relance, fnr.lib_niveau_relance
						FROM documents d
							LEFT JOIN doc_fac df ON d.ref_doc = df.ref_doc
							LEFT JOIN annu_client ac ON ac.ref_contact = d.ref_contact
							LEFT JOIN factures_relances_niveaux fnr ON df.id_niveau_relance = fnr.id_niveau_relance 
							LEFT JOIN documents_types dt ON d.id_type_doc = dt.id_type_doc 
							LEFT JOIN documents_etats de ON d.id_etat_doc = de.id_etat_doc 
							LEFT JOIN magasins m ON m.id_magasin = df.id_magasin 
						WHERE d.id_type_doc = 4 && d.id_etat_doc != 17 && d.id_etat_doc != 19 ".$where." 
						ORDER BY fnr.id_niveau_relance ASC, ".$search['orderby']." ".$search['orderorder']."
						LIMIT ".$query_limit;
	$resultat = $bdd->query($query); 
	while ($tmp = $resultat->fetchObject()) {
		
		$document = open_doc ($tmp->ref_doc);
		$tmp->montant_ttc = $document->getMontant_ttc();
                $tmp->montant_du = $document->getMontant_to_pay();
		$factures[] = $tmp; 
	
	}

	return $factures;
}


//*********************************************************
//facture fournisseur non réglées

// Fonction retournant le nombre des Factures fournisseur non réglées 
function count_niveau_factures_fournisseur_to_pay ($id_fournisseur_categ = "" ) {
	global $bdd;
	global $DEFAUT_ID_FOURNISSEUR_CATEG;
	
	$where = "";
	if (!$id_fournisseur_categ) {
		$where = " && ISNULL(ac.id_fournisseur_categ)";
	} elseif (trim($id_fournisseur_categ) == $DEFAUT_ID_FOURNISSEUR_CATEG) {
		$where = " && (ac.id_fournisseur_categ = '".$id_fournisseur_categ."')";	
	} else {
		$where = " && ac.id_fournisseur_categ = '".$id_fournisseur_categ."' ";	
	}
	$nb_factures = 0;
	$query = "SELECT d.ref_doc, d.date_creation_doc date_creation
						FROM documents d
							LEFT JOIN doc_faf df ON d.ref_doc = df.ref_doc
							LEFT JOIN annu_fournisseur ac ON ac.ref_fournisseur = d.ref_contact 
							LEFT JOIN documents_types dt ON d.id_type_doc = dt.id_type_doc 
							LEFT JOIN documents_etats de ON d.id_etat_doc = de.id_etat_doc 
						WHERE d.id_type_doc = 8 && d.id_etat_doc != 33 && d.id_etat_doc != 35  ".$where." 
						ORDER BY date_creation DESC";
	$resultat = $bdd->query($query); 
	while ($tmp = $resultat->fetchObject()) { $nb_factures ++; }

	return $nb_factures;
}
// Fonction retournant la liste des Factures client non réglées
function get_factures_fournisseur_to_pay_total ($id_fournisseur_categ = "" ) {
	global $bdd;
	global $DEFAUT_ID_FOURNISSEUR_CATEG;
	
	$where = "";
	if (!$id_fournisseur_categ) {
		$where = " && ISNULL(ac.id_fournisseur_categ)";
	} elseif (trim($id_fournisseur_categ) == $DEFAUT_ID_FOURNISSEUR_CATEG) {
		$where = " && (ac.id_fournisseur_categ = '".$id_fournisseur_categ."')";	
	} else {
		$where = " && ac.id_fournisseur_categ = '".$id_fournisseur_categ."' ";	
	}
	$factures_total = 0;
	$query = "SELECT d.ref_doc,
									 ( SELECT SUM(qte * pu_ht * (1-remise/100) * (1+tva/100))
									 	 FROM docs_lines dl
									 	 WHERE d.ref_doc = dl.ref_doc && ISNULL(dl.ref_doc_line_parent) && visible = 1 
									 ) as montant_ttc
						FROM documents d
							LEFT JOIN doc_faf df ON d.ref_doc = df.ref_doc
							LEFT JOIN annu_fournisseur ac ON ac.ref_fournisseur = d.ref_contact
							LEFT JOIN documents_types dt ON d.id_type_doc = dt.id_type_doc 
							LEFT JOIN documents_etats de ON d.id_etat_doc = de.id_etat_doc 
						WHERE d.id_type_doc = 8 && d.id_etat_doc != 33 && d.id_etat_doc != 35 ".$where." 
						";
	$resultat = $bdd->query($query); 
	while ($tmp = $resultat->fetchObject()) { $factures_total += $tmp->montant_ttc; }

	return $factures_total;
}

// Fonction retournant la liste des Factures fournisseur non réglées
function get_factures_fournisseur_to_pay ($id_fournisseur_categ = ""  ) {
	global $bdd;
	global $DEFAUT_ID_FOURNISSEUR_CATEG;
	global $COMPTA_FACTURE_TOPAY_SHOWED_FICHES;
	global $search;
	
	$query_limit	= (($search['page_to_show']-1)*$search['fiches_par_page']).", ".$search['fiches_par_page'];
	$where = "";
	if (!$id_fournisseur_categ) {
		$where = " && ISNULL(ac.id_fournisseur_categ)";
	} elseif (trim($id_fournisseur_categ) == $DEFAUT_ID_FOURNISSEUR_CATEG) {
		$where = " && (ac.id_fournisseur_categ = '".$id_fournisseur_categ."')";	
	} else {
		$where = " && ac.id_fournisseur_categ = '".$id_fournisseur_categ."' ";	
	}
	
	$factures = array();
	$query = "SELECT d.ref_doc, d.ref_contact, d.nom_contact, d.id_type_doc, dt.lib_type_doc, d.id_etat_doc, de.lib_etat_doc,
									 d.date_creation_doc date_creation,
									 
									 df.date_echeance
						FROM documents d
							LEFT JOIN doc_faf df ON d.ref_doc = df.ref_doc
							LEFT JOIN annu_fournisseur ac ON ac.ref_fournisseur = d.ref_contact
							LEFT JOIN documents_types dt ON d.id_type_doc = dt.id_type_doc 
							LEFT JOIN documents_etats de ON d.id_etat_doc = de.id_etat_doc 
						WHERE d.id_type_doc = 8 && d.id_etat_doc != 33 && d.id_etat_doc != 35 ".$where." 
						ORDER BY ".$search['orderby']." ".$search['orderorder']."
						LIMIT ".$query_limit;
	$resultat = $bdd->query($query); 
	while ($tmp = $resultat->fetchObject()) {
		
		$document = open_doc ($tmp->ref_doc);
		$tmp->montant_ttc = $document->getMontant_to_pay();
		$factures[] = $tmp; 
	
	}

	return $factures;
}

//*********************************************************
// Fonction retournant la liste des factures non réglées pour un contact défini
function get_client_factures_to_pay ($ref_contact = "" ) {
	global $bdd;
	
	$where = "";
	
	$factures = array();
	$query = "SELECT d.ref_doc, d.ref_contact, d.nom_contact, d.id_type_doc, dt.lib_type_doc, d.id_etat_doc, de.lib_etat_doc,
									 d.date_creation_doc date_creation,
									 df.id_magasin , m.lib_magasin, m.abrev_magasin,
									 ( SELECT SUM(qte * pu_ht * (1-remise/100) * (1+tva/100))
									 	 FROM docs_lines dl
									 	 WHERE d.ref_doc = dl.ref_doc && ISNULL(dl.ref_doc_line_parent) && visible = 1 
									 ) as montant_ttc,
									 df.date_echeance, df.date_next_relance, fnr.id_niveau_relance, fnr.niveau_relance, fnr.lib_niveau_relance
						FROM documents d
							LEFT JOIN doc_fac df ON d.ref_doc = df.ref_doc
							LEFT JOIN annu_client ac ON ac.ref_contact = d.ref_contact
							LEFT JOIN factures_relances_niveaux fnr ON df.id_niveau_relance = fnr.id_niveau_relance 
							LEFT JOIN documents_types dt ON d.id_type_doc = dt.id_type_doc 
							LEFT JOIN documents_etats de ON d.id_etat_doc = de.id_etat_doc 
							LEFT JOIN magasins m ON m.id_magasin = df.id_magasin 
						WHERE d.id_type_doc = 4 && d.id_etat_doc != 17 && d.id_etat_doc != 19 ".$where." && d.ref_contact = '".$ref_contact."' 
						ORDER BY fnr.id_niveau_relance ASC, date_creation DESC";
	$resultat = $bdd->query($query); 
	while ($tmp = $resultat->fetchObject()) { 
	
		$document = open_doc ($tmp->ref_doc);
		$tmp->montant_ttc = $document->getMontant_to_pay();
		$factures[] = $tmp; 
	}

	return $factures;
}


// Charge la liste de l'historique des ventes (BLC
function get_historique_ventes ($id_stock = "", $page_to_show = "1", $fiches_par_page = "10", $date_debut ="", $date_fin ="", $type_values ="") {
	global $bdd;

	
	$query_limit	= (($page_to_show-1)*$fiches_par_page).", ".$fiches_par_page;
	
	$where_doc = " d.id_type_doc = 4 && d.id_etat_doc != '17'";
	if ($type_values == "CDC") {
		$where_doc = " d.id_type_doc = 2 && d.id_etat_doc != '7'";
	} 
	
	if ($date_debut) {
		$where_doc .=  " && d.date_creation_doc > '".date_Fr_to_Us($date_debut)." 00:00:00' "; 
	}
	if ($date_fin) {
		$where_doc .=  " && d.date_creation_doc <= '".date_Fr_to_Us($date_fin)." 23:59:59' "; 
	}
	
	$histo_ventes = array();
	$query = "SELECT d.ref_doc
						FROM documents d 
							LEFT JOIN documents_types dt ON d.id_type_doc = dt.id_type_doc 
							LEFT JOIN documents_etats de ON d.id_etat_doc = de.id_etat_doc 
							LEFT JOIN docs_lines dl ON d.ref_doc = dl.ref_doc 
						WHERE ".$where_doc." 
						GROUP BY d.ref_doc
						ORDER BY date_creation_doc DESC 
						LIMIT ".$query_limit;
	$resultat = $bdd->query ($query);

	while ($doc = $resultat->fetchObject()) {		$histo_ventes[] = open_doc ($doc->ref_doc);	}
	
	//renvois du nombre total de résultat pour la pagination
	
	$GLOBALS['_INFOS']['HISTO_VENTES']['nb_fiches'] = 0;
	$query = "SELECT d.ref_doc
						FROM documents d 
							LEFT JOIN documents_types dt ON d.id_type_doc = dt.id_type_doc 
							LEFT JOIN documents_etats de ON d.id_etat_doc = de.id_etat_doc 
							LEFT JOIN docs_lines dl ON d.ref_doc = dl.ref_doc 
						WHERE  ".$where_doc." 
						GROUP BY d.ref_doc" ;
	$resultat = $bdd->query($query);
	while ($result = $resultat->fetchObject()) { $GLOBALS['_INFOS']['HISTO_VENTES']['nb_fiches'] += 1; }
	
	
	return $histo_ventes;
	
}
// Charge la liste de l'historique des achats (BLF)
function get_historique_achats ($id_stock = "", $page_to_show = "1", $fiches_par_page = "10", $date_debut ="", $date_fin ="") {
	global $bdd;

	
	$query_limit	= (($page_to_show-1)*$fiches_par_page).", ".$fiches_par_page;
	
	if (!$id_stock) {
	$id_stock = $_SESSION['magasin']->getId_stock ();
	$where_doc = "";
	} else {
	$where_doc = " && dblf.id_stock = ".$id_stock;
	}
	if ($date_debut) {
		$where_doc .=  " && d.date_creation_doc > '".date_Fr_to_Us($date_debut)." 00:00:00' "; 
	}
	if ($date_fin) {
		$where_doc .=  " && d.date_creation_doc <= '".date_Fr_to_Us($date_fin)." 23:59:59' "; 
	}
	
	$histo_ventes = array();
	$query = "SELECT d.ref_doc, d.id_type_doc, dt.lib_type_doc, d.id_etat_doc, de.lib_etat_doc, d.ref_contact, d.nom_contact, dblf.id_stock, s.lib_stock, s.abrev_stock,
										( SELECT SUM(dl.qte * dl.pu_ht * (1-dl.remise/100) * (1+dl.tva/100))
									 		FROM docs_lines dl
									 		WHERE d.ref_doc = dl.ref_doc && ISNULL(dl.ref_doc_line_parent) && visible = 1 
									 	) as montant_ttc,
									 	d.date_creation_doc as date_doc
						FROM documents d 
							LEFT JOIN documents_types dt ON d.id_type_doc = dt.id_type_doc 
							LEFT JOIN documents_etats de ON d.id_etat_doc = de.id_etat_doc 
							LEFT JOIN docs_lines dl ON d.ref_doc = dl.ref_doc 
							LEFT JOIN doc_blf dblf ON d.ref_doc = dblf.ref_doc 
							LEFT JOIN stocks s ON s.id_stock = dblf.id_stock 
						WHERE d.id_type_doc = 7 && d.id_etat_doc != '30' ".$where_doc." 
						GROUP BY d.ref_doc
						ORDER BY date_doc DESC 
						LIMIT ".$query_limit;
	$resultat = $bdd->query ($query);

	while ($doc = $resultat->fetchObject()) {
	
		$doc->liaison_fac = array();
		$query3 = "SELECT dl.ref_doc_destination, 
										( SELECT SUM(dli.qte * dli.pu_ht * (1-dli.remise/100) * (1+dli.tva/100))
									 		FROM docs_lines dli
									 		WHERE dl.ref_doc_destination = dli.ref_doc && visible = 1 
									 	) as montant_ttc, dl.active, d.id_type_doc, dt.lib_type_doc, d.id_etat_doc, de.lib_etat_doc,
									 d.date_creation_doc date_creation
						FROM documents_liaisons dl
							LEFT JOIN documents d ON d.ref_doc = dl.ref_doc_destination 
							LEFT JOIN documents_types dt ON d.id_type_doc = dt.id_type_doc 
							LEFT JOIN documents_etats de ON d.id_etat_doc = de.id_etat_doc 
							WHERE ref_doc_source = '".$doc->ref_doc."' && d.id_type_doc = '4' && d.id_etat_doc != '17' 
							GROUP BY ref_doc_destination ";
		$resultat3 = $bdd->query($query3);
		while ($liaison = $resultat3->fetchObject()) {
		 $doc->liaison_fac[] = $liaison; 
		 }
		 
		$doc->lines = array();
		$query2 = "SELECT dl.ref_article, dl.lib_article, dl.desc_article, SUM(dl.qte) as qte, 
										a.ref_oem, a.ref_interne, a.ref_constructeur, ann.nom nom_constructeur, ac.lib_art_categ,
										SUM(dl.qte * dl.pu_ht * (1-dl.remise/100) * (1+dl.tva/100)) as montant
							FROM docs_lines dl
								LEFT JOIN doc_lines_blf dlb ON dl.ref_doc_line = dlb.ref_doc_line
								LEFT JOIN articles a ON dl.ref_article = a.ref_article
								LEFT JOIN annuaire ann ON a.ref_constructeur = ann.ref_contact 
								LEFT JOIN art_categs ac ON a.ref_art_categ = ac.ref_art_categ 
							WHERE ref_doc = '".$doc->ref_doc."' && ISNULL(dl.ref_doc_line_parent)
							GROUP BY dl.qte, dl.ref_article 
							ORDER BY dl.ordre "; 
		$resultat2 = $bdd->query($query2); 
	while ($line = $resultat2->fetchObject()) { $doc->lines[] = $line;	}
		$histo_ventes[] = $doc;
	}
	//renvois du nombre total de résultat pour la pagination
	
	$GLOBALS['_INFOS']['HISTO_ACHATS']['nb_fiches'] = 0;
	$query = "SELECT d.ref_doc
						FROM documents d 
							LEFT JOIN documents_types dt ON d.id_type_doc = dt.id_type_doc 
							LEFT JOIN documents_etats de ON d.id_etat_doc = de.id_etat_doc 
							LEFT JOIN docs_lines dl ON d.ref_doc = dl.ref_doc 
							LEFT JOIN doc_blf dblf ON d.ref_doc = dblf.ref_doc 
						WHERE d.id_type_doc = 7 && d.id_etat_doc != '30' ".$where_doc." 
						GROUP BY d.ref_doc" ;
	$resultat = $bdd->query($query);
	while ($result = $resultat->fetchObject()) { $GLOBALS['_INFOS']['HISTO_ACHATS']['nb_fiches'] += 1; }
	
	
	return $histo_ventes;
	
}

// liste des modes d'edition
function liste_mode_edition () {
	global $bdd;
	
	$editions_modes	= array();
	$query = "SELECT id_edition_mode, lib_edition_mode, code_edition_mode
							FROM editions_modes 
						WHERE actif = 1 ";
	$resultat = $bdd->query ($query);
	while ($e_mode = $resultat->fetchObject()) { $editions_modes[] = $e_mode; }
	return $editions_modes;
}


//liste des etats de documents
function get_etat($doc_type) {
	global $bdd;
	
	$etats_liste	= array();
	
	if ($doc_type) {
		$query = "SELECT id_etat_doc, lib_etat_doc, id_type_doc, ordre
							FROM documents_etats  
							WHERE id_type_doc = '".$doc_type."' 
							ORDER BY ordre ASC";
		$resultat = $bdd->query ($query);
		while ($etats = $resultat->fetchObject()) { $etats_liste[] = $etats; }
	}
	$result[] = "=Tous";
	$result[] = implode(",", get_etat_is_open(1, $doc_type))."=Documents en cours";
	$result[] = implode(",", get_etat_is_open(0, $doc_type))."=Documents en archive";
	
	// on boucle sur tous les éléments
	if (count($etats_liste)>0) {
		foreach ($etats_liste as $etat_liste) {
			$result[] = $etat_liste->id_etat_doc."=".($etat_liste->lib_etat_doc);
		}
	}
  print implode(";", $result);
}

//fonction renvoyant les id_etat_doc en fonction du is_open et de l'id_type_doc si indiqué
function get_etat_is_open($is_open = 0, $doc_type = "") {
	global $bdd;
	
	$id_etat_doc = array();
	$where = "";
	if ($doc_type) { $where .= " && id_type_doc = '".$doc_type."' "; }
	$query = "SELECT id_etat_doc
						FROM documents_etats  
						WHERE is_open = '".$is_open."' ".$where."
						ORDER BY ordre ASC";
	$resultat = $bdd->query ($query);
	while ($id_etat_docs = $resultat->fetchObject()) { $id_etat_doc[] = $id_etat_docs->id_etat_doc; }
	
	return $id_etat_doc;
	
}

//liste de tout les type de docs
function fetch_all_types_docs () {
	global $bdd;
	
	$documents_type	= array();
	$query = "SELECT id_type_doc, lib_type_doc, lib_type_printed, actif , code_doc
						FROM documents_types
						ORDER BY lib_type_doc ASC";
	$resultat = $bdd->query ($query);
	while ($documents = $resultat->fetchObject()) { $documents_type[] = $documents; }
	
	return $documents_type;
}


//liste des groupes de type de  documents 
function docs_type_groupes ($id_type_groupe = "") {
	global $bdd;
	
	$where = "";
	if ($id_type_groupe) {$where = " WHERE id_type_groupe = '".$id_type_groupe."' ";}
	$types_groupes	= array();
	$query = "SELECT dtg.id_type_groupe, dtg.lib_type_groupe, ordre
						FROM documents_types_groupes dtg
						".$where."
						ORDER BY ordre ASC";
	$resultat = $bdd->query ($query);
	while ($groupe = $resultat->fetchObject()) {
		$types_groupes[] = $groupe;
	}
	
	return $types_groupes;
}

//liste des documents et des informations connexes pour l'edition des informations d'impression pdf des documents
function docs_infos_by_groupe ($id_type_groupe) {
	global $bdd;
	
	$documents_liste	= array();
	$query = "SELECT dt.id_type_doc, dt.lib_type_doc, dt.lib_type_printed, dt.actif , dt.code_doc, dt.id_type_groupe,
										dtg.lib_type_groupe
						FROM documents_types dt
						LEFT JOIN documents_types_groupes dtg ON dtg.id_type_groupe = dt.id_type_groupe
						WHERE dt.id_type_groupe = '".$id_type_groupe."'
						ORDER BY id_type_doc ASC";
	$resultat = $bdd->query ($query);
	while ($documents = $resultat->fetchObject()) {
		$documents->doc_modeles_pdf = array();
		$query_in = "SELECT dmp.id_type_doc, dmp.id_pdf_modele, dmp.usage,
											pm.lib_modele, pm.desc_modele , pm.code_pdf_modele
							FROM doc_modeles_pdf  dmp
							LEFT JOIN pdf_modeles  pm ON pm.id_pdf_modele = dmp.id_pdf_modele
							WHERE dmp.id_type_doc = '".$documents->id_type_doc."'
							ORDER BY dmp.usage ASC";
		$resultat_in = $bdd->query ($query_in);
		while ($modeles_pdf = $resultat_in->fetchObject()) {
			$documents->doc_modeles_pdf[] = $modeles_pdf;
		}
		unset ($query_in, $resultat_in, $modeles_pdf);
		$documents_liste[] = $documents;
		
		
	}
	
	return $documents_liste;
}

//chargement des infos d'un modele pdf
function charge_modele_pdf ($id_pdf_modele) {
	global $bdd;
	$query = "SELECT id_pdf_modele, id_pdf_type, lib_modele, desc_modele , code_pdf_modele
							FROM pdf_modeles  
							WHERE id_pdf_modele = '".$id_pdf_modele."'
							";
	$resultat = $bdd->query ($query);
	if ($modele_pdf = $resultat->fetchObject()) {
		return $modele_pdf;
	}
}
//chargement des infos d'un modele pdf
function charge_modele_pdf_document () {
	global $bdd;
	$modeles_liste	= array();
	$query = "SELECT id_pdf_modele, id_pdf_type, lib_modele, desc_modele , code_pdf_modele
							FROM pdf_modeles  
							WHERE id_pdf_type = '1'
							";
	$resultat = $bdd->query ($query);
	while ($modele_pdf = $resultat->fetchObject()) { $modeles_liste[] = $modele_pdf;}
	return $modeles_liste;
}
//cahrgement des modeles pdf valides pour un id_type_doc
function charger_modeles_pdf_valides($id_type_doc) {
	global $bdd;
	$modeles_liste	= array();
	$query = "SELECT dmp.id_type_doc, dmp.usage, pm.id_pdf_modele, pm.id_pdf_type, pm.lib_modele, pm.desc_modele , pm.code_pdf_modele
							FROM doc_modeles_pdf dmp  
							LEFT JOIN pdf_modeles pm ON pm.id_pdf_modele = dmp.id_pdf_modele 
						WHERE dmp.id_type_doc = '".$id_type_doc."' && `usage` != 'inactif' 
						ORDER BY dmp.usage ASC ";
	$resultat = $bdd->query ($query);
	while ($modele_pdf = $resultat->fetchObject()) { $modeles_liste[] = $modele_pdf;}
	return $modeles_liste;
	

}

//modele pdf par défaut
function defaut_doc_modele_pdf ($id_type_doc, $id_pdf_modele) {
	global $bdd;
	
	$query = "UPDATE doc_modeles_pdf
						SET  `usage` = 'actif'
						WHERE id_type_doc = '".$id_type_doc."' && `usage` != 'inactif' 
						";
	$bdd->exec ($query);
	
	$query = "UPDATE doc_modeles_pdf
						SET  `usage` = 'defaut'
						WHERE id_type_doc = '".$id_type_doc."' && id_pdf_modele = '".$id_pdf_modele."' 
						";
	$bdd->exec ($query);
	
	// 2.044 : Maxime : On met à jour l'id_pdf_modele dans la table documents_types
	$query = "UPDATE documents_types
					SET id_pdf_modele = '" . $id_pdf_modele . "' 
					WHERE id_type_doc = '" . $id_type_doc . "';";
	$bdd->exec ($query);
	return true;
}
//activation d'un modele pdf
function active_doc_modele_pdf ($id_type_doc, $id_pdf_modele) {
	global $bdd;
	$query = "UPDATE doc_modeles_pdf
						SET  `usage` = 'actif'
						WHERE id_type_doc = '".$id_type_doc."' && id_pdf_modele = '".$id_pdf_modele."' 
						";
	$bdd->exec ($query);
	return true;
}
//désactivation d'un modele pdf
function desactive_doc_modele_pdf ($id_type_doc, $id_pdf_modele) {
	global $bdd;
	$query = "UPDATE doc_modeles_pdf
						SET  `usage` = 'inactif'
						WHERE id_type_doc = '".$id_type_doc."' && id_pdf_modele = '".$id_pdf_modele."' 
						";
	$bdd->exec ($query);
	return true;
}
//suppression d'un modele pdf
function supprime_doc_modele_pdf ($id_pdf_modele) {
	global $bdd;
	$query = "DELETE FROM pdf_modeles
						WHERE id_pdf_modele = '".$id_pdf_modele."' 
						";
	$bdd->exec ($query);
	
	// On supprime également dans la table doc_modeles_pdf
	$query = "DELETE FROM doc_modeles_pdf
						WHERE id_pdf_modele = '".$id_pdf_modele."' 
						";
	$bdd->exec ($query);
	
	return true;
}

//liste des adresses d'un contact
function getContact_adresses ($ref_contact) {
	global $bdd;
	
	$adresses_liste	= array();
	$query = "SELECT ref_contact, ref_adresse, lib_adresse, text_adresse, code_postal, ville, a.id_pays, note, ordre, p.pays
						FROM adresses a
							LEFT JOIN pays p ON a.id_pays = p.id_pays
						WHERE ref_contact = '".$ref_contact."' 
						ORDER BY ordre ASC ";
	$resultat = $bdd->query ($query);
	while ($adresses = $resultat->fetchObject()) { $adresses_liste[] = $adresses; }
	
	return $adresses_liste;
}


//liste des filigranes pour un document pdf
function charger_filigranes () {
	global $bdd;
	
	$filigranes_liste	= array();
	$query = "SELECT id_filigrane, lib_filigrane, ordre
						FROM documents_filigranes 
						ORDER BY ordre ASC ";
	$resultat = $bdd->query ($query);
	while ($tmp = $resultat->fetchObject()) { $filigranes_liste[] = $tmp; }
	
	return $filigranes_liste;
}

//ajout des filigranes
function add_filigranes ($lib_filigrane, $ordre_fili) {
	global $bdd;
	$query = "INSERT INTO documents_filigranes (lib_filigrane, ordre)
						VALUES ('".addslashes($lib_filigrane)."' , '".$ordre_fili."' ) ";
	$bdd->exec ($query);

}
//modification du filigrane
function maj_filigranes ($lib_filigrane, $id_filigrane) {
	global $bdd;
	$query = "UPDATE documents_filigranes 
						SET lib_filigrane = '".addslashes($lib_filigrane)."' 
						WHERE id_filigrane = '".$id_filigrane."' ";
	$bdd->exec ($query);
	
}
//supression d'un filigrane
function sup_filigranes ($id_filigrane, $ordre) {
	global $bdd;

	// *************************************************
	// Suppression du filigrane
	$query = "DELETE FROM documents_filigranes 
						WHERE id_filigrane = '".$id_filigrane."' ";
	$bdd->exec ($query);
	
	// Changement de l'ordre des filigranes suivants
	$query = "UPDATE documents_filigranes 
						SET ordre = ordre -1
						WHERE id_filigrane = '".$id_filigrane."' && ordre > '".$ordre."'";
	$bdd->exec ($query);

}
//modification de l'ordre des filigranes
function ordre_filigranes ($id_filigrane, $old_ordre, $new_ordre) {
	global $bdd;
	
	if ($new_ordre < $old_ordre) {
		$variation = "+";
		$symbole1 = "<";
		$symbole2 = ">=";
	}
	else {
		$variation = "-";
		$symbole1 = ">";
		$symbole2 = "<=";
	}
	
	$bdd->beginTransaction();
	
	// Mise à jour des autres coordonnees
	$query = "UPDATE documents_filigranes
						SET ordre = ordre ".$variation." 1
						WHERE ordre ".$symbole1." '".$old_ordre."' && ordre ".$symbole2." '".$new_ordre."' ";
	$bdd->exec ($query);
	
	// Mise à jour de cette coordonnee
	$query = "UPDATE documents_filigranes
						SET ordre = '".$new_ordre."'
						WHERE id_filigrane = '".$id_filigrane."'  ";
	$bdd->exec ($query);
	
	$bdd->commit();	

}


//purge des documents annulés
function purge_all_docs_annules ($id_type_doc = "") {
	global $bdd;
	global $DIR;
	
	$nb_docs_purged = 0;
	ini_set("memory_limit","20M");
	
	foreach ($_SESSION['types_docs'] as $type_doc) {
		if ($id_type_doc && $id_type_doc != $type_doc->id_type_doc) {continue;}
                if(file_exists($DIR."documents/_doc_".strtolower($type_doc->code_doc).".class.php"))
                {
                    require_once ($DIR."documents/_doc_".strtolower($type_doc->code_doc).".class.php");
                    $classe_doc = "doc_".$type_doc->code_doc;
                    $document = new $classe_doc ();
                    $id_etat_annule = $document->getID_ETAT_ANNULE ();
                    global ${"DUREE_AVANT_PURGE_ANNULE_".$type_doc->code_doc};
                    $query = "DELETE FROM documents
                                                            WHERE id_type_doc = '".$type_doc->id_type_doc."'
                                                                                    && date_creation_doc < '".date("Y-m-d" , mktime(0, 0, 0, date("m"), date("d")-(${"DUREE_AVANT_PURGE_ANNULE_".$type_doc->code_doc}), date("Y")))."'
                                                                                    && id_etat_doc = '".$id_etat_annule."' ";
                    $nb_docs_purged += $bdd->exec ($query);
                }
	}
	return $nb_docs_purged;
}

// return id_type_groupe from ref_doc
function searchIdTypeGroup($ref_doc) {
  global $bdd;
  
  $query = "SELECT id_type_groupe FROM documents_types
  			WHERE id_type_doc IN (SELECT id_type_doc FROM documents WHERE ref_doc='".$ref_doc."');";
  $res = $bdd->query($query);
  if ($res = $res->fetchObject())
    return $res->id_type_groupe;
}

function charge_docs_content_model ($id_type_doc) {
  global $bdd;
  
  $infos_doc_mod = array();
  $query = "SELECT ref_doc, lib_modele, desc_modele FROM doc_mod
  			WHERE 	types_docs LIKE '%;".$id_type_doc.";%'";
  $res = $bdd->query($query);
  while($tmp = $res->fetchObject()) { $infos_doc_mod[] = $tmp; }
  return $infos_doc_mod; 
}