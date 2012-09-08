<?php
// *************************************************************************************************************
// CLASSE REGISSANT LES INFORMATIONS SUR UN DOCUMENT DE TYPE FACTURE FOURNISSEUR
// *************************************************************************************************************


final class doc_faf extends document {

	protected $ref_doc_externe;
	protected $date_echeance;

	protected $ID_TYPE_DOC 					= 8;
	protected $LIB_TYPE_DOC 				= "Facture Fournisseur";
	protected $CODE_DOC 						= "FAF";
	protected $DOC_ID_REFERENCE_TAG = 22;

	protected $DEFAUT_ID_ETAT 	= 32;
	protected $DEFAUT_LIB_ETAT 	= "En saisie";
	protected $GESTION_SN	 		= 1;
	protected $CONTENT_FROM		= "CATALOGUE";
	protected $PU_FROM				= "PA";
	protected $ACCEPT_REGMT		= -1;
	protected $ID_ETAT_ANNULE	= 33;

	protected $doc_fusion_dispo;
	protected $doc_fusion_dispo_loaded;




public function open_doc ($select = "", $left_join = "") {
	global $bdd;

	$this->check_profils ();

	$select = ", df.date_echeance, df.ref_doc_externe ";
	$left_join = " LEFT JOIN doc_faf df ON df.ref_doc = d.ref_doc ";

	if (!$doc = parent::open_doc($select, $left_join)) { return false; }

	$this->ref_doc_externe = $doc->ref_doc_externe;
	$this->date_echeance = $doc->date_echeance;

	// Blocage des quantités
	if ($this->id_etat_doc == 34 || $this->id_etat_doc == 35) {
		//$this->quantite_locked = true;
	}
	return true;
}



// *************************************************************************************************************
// FONCTIONS LIEES A LA CREATION D'UN DOCUMENT
// *************************************************************************************************************

public function create_doc () { 
	global $bdd;
	global $DEFAUT_APP_TARIFS_FOURNISSEUR;

	$this->app_tarifs = $DEFAUT_APP_TARIFS_FOURNISSEUR;
	
	if (!parent::create_doc()) { return false; }

	// *************************************************
	// Informations complémentaires
	$this->date_echeance 			= date ("Y-m-d", time());
	
	$query = "INSERT INTO doc_faf (ref_doc, date_echeance)
						VALUES ('".$this->ref_doc."', '".$this->date_echeance."') ";
	$bdd->exec ($query);

	return true;
}


// Charge les informations supplémentaire du contact
protected function load_infos_contact () {
	$this->load_infos_contact_fournisseur();
	parent::load_infos_contact();
}



// Renvoie le type d'afichage des tarifs a utiliser (HT ou TTC) pour le document
protected function define_aff_tarif () {
	$this->define_fournisseur_aff_tarif();
}


// *************************************************************************************************************
// FONCTIONS LIEES A LA MODIFICATION D'UN DOCUMENT
// *************************************************************************************************************


//fonction de mise à jour de l'app_tarif du contact en cas de changement d'app_tarif du document
public function maj_app_tarifs ($new_app_tarifs) {
	global $bdd;
	global $FOURNISSEUR_ID_PROFIL;

	// Controle
	if ($new_app_tarifs != "HT") {
		$new_app_tarifs == "TTC";
	}
	$this->app_tarifs = $new_app_tarifs;
	
	// Maj de la base de données
	$query = "UPDATE documents SET app_tarifs = '".$this->app_tarifs."'
						WHERE ref_doc = '".$this->ref_doc."' ";
	$bdd->exec ($query);
	
	//on met à jour l'app_tarif du contact en fonction du profil / doc dans le même temps
	if (!is_object($this->contact)) { $this->contact = new contact ($this->ref_contact); }
	if ($this->contact->charger_profiled_infos($FOURNISSEUR_ID_PROFIL)) {
		$profil_tmp = $this->contact->getProfil($FOURNISSEUR_ID_PROFIL);
		$profil_tmp->maj_app_tarifs ($this->app_tarifs);
	}
}

// Liste des documents pouvant être fusionner
public function check_allow_fusion ($second_document) {
	//verifcation que l'état des document permet la fusion
	if (($this->id_etat_doc != "32" && $this->id_etat_doc != "34") && ($second_document->getId_etat_doc () != "32" && $second_document->getId_etat_doc () != "34")) {
		return false;
	}
	return true;
}



// Liste des documents pouvant être fusionner
public function liste_doc_fusion () {
	global $bdd;
	
	$this->doc_fusion_dispo = array();
	$query = "SELECT d.ref_doc, d.id_type_doc, dt.lib_type_doc, d.id_etat_doc, de.lib_etat_doc, d.ref_contact, d.nom_contact,
										( SELECT SUM(dl.qte * dl.pu_ht * (1-dl.remise/100) * (1+dl.tva/100))
									 		FROM docs_lines dl
									 		WHERE d.ref_doc = dl.ref_doc && ISNULL(dl.ref_doc_line_parent) && visible = 1 
									 	) as montant_ttc,
									 	d.date_creation_doc as date_doc
						FROM documents d 
							LEFT JOIN documents_types dt ON d.id_type_doc = dt.id_type_doc 
							LEFT JOIN documents_etats de ON d.id_etat_doc = de.id_etat_doc 
						WHERE (d.id_etat_doc = '32' ||  d.id_etat_doc = '34' ) && d.ref_contact = '".$this->ref_contact."' && d.ref_doc != '".$this->ref_doc."'
						GROUP BY d.ref_doc
						ORDER BY date_doc DESC ";
	$resultat = $bdd->query ($query);
	while ($doc = $resultat->fetchObject()) {$this->doc_fusion_dispo[] = $doc;}
	
	$this->doc_fusion_dispo_loaded = true;
	return true;
}


// Met à jour la ref_doc_externe
public function maj_ref_doc_externe ($ref_doc_externe) {
	global $bdd;	

	$this->ref_doc_externe = $ref_doc_externe;

	// *************************************************
	// MAJ de la base
	$query = "UPDATE doc_faf 
						SET ref_doc_externe = '".addslashes($this->ref_doc_externe)."'
						WHERE ref_doc = '".$this->ref_doc."' ";
	$bdd->exec ($query);
	
	return true;
}



//fonction de maj de la ref_article_externe
public function maj_line_ref_article_externe ($ref_doc_line , $ref_article_externe, $old_ref_article_externe = "", $ref_article) {
	global $bdd;
	
	//si le document n'est pas annulé ou en cours de saisie, on met à jour les ref_externes de l'article
	switch ($this->id_etat_doc) {
	case 34: case 35:
			//si un contact est défini et que na nouvelle ref_article_externe n'est pas vide
			if ($this->ref_contact) {
				//chargement de la ligne
				$line = $this->charger_line ($ref_doc_line);
				// on charge l'article
				$article = new article ($ref_article);
				$article->maj_ref_article_externe ($this->ref_contact, $ref_article_externe, $old_ref_article_externe, $line->pu_ht, $this->date_creation);
				
				// en cas d'erreur, on ne met pas à jour la ref_externe dans la ligne de document
				if (count($GLOBALS['_ALERTES'])) {
					return false;
				}
			}
		break;
	}
	
	// pas de mise à jour si  les ref_articles_externes sont identiques
	if ($ref_article_externe == $old_ref_article_externe) {return false;}
	//mise à jour de la ligne article si pas de problème concernant la mise à jour
	$query = "UPDATE doc_lines_faf SET ref_article_externe = '".$ref_article_externe."' 
						WHERE ref_doc_line = '".$ref_doc_line."' ";
	$resultat = $bdd->query ($query);
	if (!$resultat->rowCount()) {
		// La ligne n'existe pas il faut la créer
		$query = "INSERT INTO doc_lines_faf (ref_doc_line, ref_article_externe)
							VALUES ('".$ref_doc_line."', '".$ref_article_externe."') ";
		$bdd->exec ($query);
	}

	$GLOBALS['_INFOS']['ref_article_externe'] = $ref_article_externe;

	return true;
}




// Met à jour la date d'échéance de la facture
public function maj_date_echeance ($new_date_echeance) {
	global $bdd;

	// Controler la date!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
	if (count($GLOBALS['_ALERTES'])) {
		return false;
	}

	$this->date_echeance = $new_date_echeance;

	// *************************************************
	// MAJ de la base
	$query = "UPDATE doc_faf 
						SET date_echeance = '".$this->date_echeance."'
						WHERE ref_doc = '".$this->ref_doc."' ";
	$bdd->exec ($query);

	// *************************************************
	// Retour des informations
	$GLOBALS['_INFOS']['date_echeance'] = $this->date_echeance;

	return true;
}



// *************************************************************************************************************
// FONCTIONS DIVERSES 
// *************************************************************************************************************

// PROFILS DE CONTACT NECESSAIRE POUR UTILISER CE TYPE DE DOCUMENT
function check_profils () {
	return $this->check_profil_fournisseur();
}


// *************************************************************************************************************
// FONCTIONS DE GESTION DU CONTENU
// *************************************************************************************************************

protected function doc_line_infos_supp () {
	$query['select']			= ", dl_faf.ref_article_externe";
	$query['left_join'] 	= " LEFT JOIN doc_lines_faf dl_faf ON dl_faf.ref_doc_line = dl.ref_doc_line";
	return $query;
}


//affichage dans les résultat du prix achat fournisseur ou de la valeur d'achat actuelle
protected function select_article_pa ($article) {

	$ref_externes = $article->charger_ref_article_externe_fournisseur($this->ref_contact);
	
	if (isset($ref_externes[0])) {return $ref_externes[0]->pa_unitaire;}
	return $article->getPaa_ht();

}


//fonction d'ajout des infos supp d'une ligne article
public function add_line_article_info_supp ($ref_doc_line, $ref_article) {
	global $bdd;
	
	$article = new article ($ref_article);
	$ref_article_externe = "";
	$ref_externes = $article->charger_ref_article_externe_fournisseur($this->ref_contact);
	
	if (isset($ref_externes[0])) {$ref_article_externe = $ref_externes[0]->ref_article_externe;}
	
	$query = "UPDATE doc_lines_faf SET ref_article_externe = '".$ref_article_externe."' 
						WHERE ref_doc_line = '".$ref_doc_line."' ";
	$resultat = $bdd->query ($query);
	if (!$resultat->rowCount()) {
		// La ligne n'existe pas il faut la créer
		$query = "INSERT INTO doc_lines_faf (ref_doc_line, ref_article_externe)
							VALUES ('".$ref_doc_line."', '".$ref_article_externe."') ";
		$bdd->exec ($query);
	}


	return true;
}


public function action_after_copie_line_from_line ($line) {
	global $bdd;

	if (isset($line->type_of_line) && $line->type_of_line != "article") { return true; }
	
	$ref_article_externe = "";
	if (isset($line->ref_article_externe)) {	$ref_article_externe = $line->ref_article_externe;}
	$query = "INSERT INTO doc_lines_faf (ref_doc_line, ref_article_externe)
						VALUES ('".$line->ref_doc_line."', '".$ref_article_externe."') ";
	$bdd->exec ($query);

	return true;

}
// *************************************************************************************************************
// FONCTIONS SPECIFIQUES AU TYPE DE DOC 
// *************************************************************************************************************


// Action après de changer l'état du document
protected function action_after_maj_etat ($old_etat_doc) {
	global $bdd;

	switch ($old_etat_doc) {
		case 32: case 33:
			if ($this->id_etat_doc == 34 || $this->id_etat_doc == 35) {
				// ajout de la ligne comptable
				$this->ajout_ventilation_facture ();
				//$this->quantite_locked = true;

			}
		break;
		case 34: case 35:
			if ($this->id_etat_doc == 32 || $this->id_etat_doc == 33 ) {
				// suppression des lignes comptables du document
				$this->supprime_ventilation_facture ();
				//$this->quantite_locked = false;	
			}
		break;
	}
	if ($this->id_etat_doc == 34 || $this->id_etat_doc == 35 ) {
		//mise à jour des ref_articles externes 
		if ($this->ref_contact) {
			if (!$this->contenu_loaded) { $this->charger_contenu(); }
			
			for ($i=0; $i<count($this->contenu); $i++) {
			if ($this->contenu[$i]->type_of_line != 'article') { continue;}
			// on charge l'article
			$article = new article ($this->contenu[$i]->ref_article);
			$article->maj_ref_article_externe ($this->ref_contact, $this->contenu[$i]->ref_article_externe, $this->contenu[$i]->ref_article_externe, $this->contenu[$i]->pu_ht, $this->date_creation);
			}
		}
	}

	return true;
}

// *************************************************************************************************************
// FONCTIONS DE VENTILATION COMPTABLE
// *************************************************************************************************************
// chargement ventilation facture Fournisseur
function charger_ventilation_facture () {
	global $bdd;
	global $DEFAUT_COMPTE_HT_ACHAT;
	global $DEFAUT_COMPTE_TVA_ACHAT;
	global $DEFAUT_COMPTE_TIERS_ACHAT;
	
	$defaut_num_compte = array();
	$defaut_num_compte[6] = $DEFAUT_COMPTE_HT_ACHAT;
	$defaut_num_compte[7] = $DEFAUT_COMPTE_TVA_ACHAT;
	$defaut_num_compte[8] = $DEFAUT_COMPTE_TIERS_ACHAT;


	$id_journal_achat = 2;
	$ventillation_facture = array();
	
	$query = "SELECT id_journal, lib_journal, desc_journal, id_journal_parent
						FROM compta_journaux 
						WHERE id_journal_parent = '".$id_journal_achat."'
						";
	$resultat = $bdd->query ($query);
	while ($doc = $resultat->fetchObject()) {
	
		$ventillation_facture[$doc->id_journal] = array();
		$query2 = "SELECT numero_compte, montant, ref_doc, id_journal
							FROM compta_docs 
							WHERE ref_doc = '".$this->ref_doc."' && id_journal ='".$doc->id_journal."'
							";
		$resultat2 = $bdd->query ($query2);
		while ($doc2 = $resultat2->fetchObject()) {
			if (!$doc2->numero_compte) {!$doc2->numero_compte = $defaut_num_compte[$doc2->id_journal];}
			$ventillation_facture[$doc->id_journal][] = $doc2;
		}
	}
	return $ventillation_facture;
}


//ajout de lignes de ventilation
/* 2.044+ Fixed number_format */
function ajout_ventilation_facture_old($infos_lines = array()) {
	global $bdd;
	global $DEFAUT_ID_PAYS;
	global $DEFAUT_COMPTE_HT_ACHAT;
	global $DEFAUT_COMPTE_TVA_ACHAT;
	global $DEFAUT_COMPTE_TIERS_ACHAT;
	global $DEFAUT_ID_FOURNISSEUR_CATEG;
	global $FOURNISSEUR_ID_PROFIL;
	
	global $TARIFS_NB_DECIMALES; 
	
	//si aucunes données transmise on cré un ligne d'aprés les infos de chaque art_categ présent , TVA et TTC compte tier FOURNISSEUR)
	if (!count($infos_lines)) {
		$calcul_TTC = 0;
	
		//comptes HT ACHAT
		// chargement des art_categ présents dans le doc		
		$query = "SELECT DISTINCT ac.ref_art_categ, 
										ac.defaut_numero_compte_achat,
										( 
										 	SELECT SUM(t.pu_ht * t.qte * (1-t.remise/100))
											FROM articles ab 
												LEFT JOIN docs_lines t ON t.ref_article = ab.ref_article && visible = 1
											WHERE t.ref_doc = '".$this->ref_doc."' &&  ac.ref_art_categ = ab.ref_art_categ && ISNULL(t.ref_doc_line_parent)
											
										)  as montant_ht
							
							FROM art_categs ac 
								LEFT JOIN articles a ON a.ref_art_categ = ac.ref_art_categ
								LEFT JOIN docs_lines dl ON dl.ref_article = a.ref_article
							WHERE ref_doc = '".$this->ref_doc."' && ISNULL(dl.ref_doc_line_parent)  
							 ";
		$resultat = $bdd->query ($query);
		while ($art_categ = $resultat->fetchObject()) {
			if (!$art_categ->defaut_numero_compte_achat) {$art_categ->defaut_numero_compte_achat= $DEFAUT_COMPTE_HT_ACHAT;}
			//sauvegarde de la ligne dans compta_docs HT achat
			$query3 = "INSERT INTO compta_docs  (numero_compte, montant, ref_doc, id_journal)
								VALUES ('".$art_categ->defaut_numero_compte_achat."', '".number_format(round($art_categ->montant_ht,2), $TARIFS_NB_DECIMALES, ".", ""	)."',  '".$this->ref_doc."' , '6') 
								";
			$bdd->exec ($query3);
			unset($query3);
			$calcul_TTC += round($art_categ->montant_ht,2);
		}
		unset($query, $resultat);
		
		//comptes TVA collectée
		$liste_tvas =  get_tvas($DEFAUT_ID_PAYS);
		// chargement des tva présents dans le doc		
		$doc_tvas = $this->getTVAs ();
	
		foreach ($doc_tvas as $ttva=>$val_tva) {
			$defaut_num_compte_tva = $DEFAUT_COMPTE_TVA_ACHAT;
			foreach($liste_tvas as $db_tva) {
				if ($ttva == $db_tva["tva"]) {$defaut_num_compte_tva = $db_tva["num_compte_achat"];}
			}
			if (!$defaut_num_compte_tva) {$defaut_num_compte_tva = $DEFAUT_COMPTE_TVA_ACHAT;}
			//sauvegarde de la ligne dans compta_docs TVA achat
			$query3 = "INSERT INTO compta_docs  (numero_compte, montant, ref_doc, id_journal)
								VALUES ('".$defaut_num_compte_tva."', '".number_format(round($val_tva,2), $TARIFS_NB_DECIMALES, ".", ""	)."',  '".$this->ref_doc."' , '7') 	";
			$bdd->exec ($query3);
			unset($query3);
			$calcul_TTC += round($val_tva,2);
		}
		
		//compte tier achat (categorie FOURNISSEUR)
		$categorie_fournisseur = $DEFAUT_ID_FOURNISSEUR_CATEG;
		$compte_ttc_defaut =  $DEFAUT_COMPTE_TIERS_ACHAT;
		$contact = new contact ($this->ref_contact);
		contact::load_profil_class($FOURNISSEUR_ID_PROFIL);
		if (is_object($contact) && $contact->getRef_contact ()) {
			$contact_profil = $contact->getProfil($FOURNISSEUR_ID_PROFIL);
			$compte_ttc_defaut = $contact_profil->getDefaut_numero_compte ();
		} else {
			$liste_categ = contact_fournisseur::charger_fournisseurs_categories ();
			foreach ($liste_categ as $categ) {
				if ($categ->id_fournisseur_categ != $categorie_fournisseur) {continue;}
				if ($categ->defaut_numero_compte) {$compte_ttc_defaut = $categ->defaut_numero_compte; break;}
				
			}
		}
		if (!$compte_ttc_defaut) {$compte_ttc_defaut = $DEFAUT_COMPTE_TIERS_ACHAT;}
		//verification de la correspondance au centime du total TVA + HT = TTC
		if (abs(round($this->getMontant_ttc (),2))-0.01 <= abs($calcul_TTC)  && abs(round($this->getMontant_ttc (),2))+0.01 >= abs($calcul_TTC)) {
			//sauvegarde de la ligne dans compta_docs TTC vente
			$query3 = "INSERT INTO compta_docs  (numero_compte, montant, ref_doc, id_journal)
								VALUES ('".$compte_ttc_defaut ."', '".number_format(round($calcul_TTC,2), $TARIFS_NB_DECIMALES, ".", ""	)."',  '".$this->ref_doc."' , '8') 	";
			$bdd->exec ($query3);
			unset($query3);
		}
		return true;
	}
	
	foreach ($infos_lines as $line) {
		//sinon les infos sont envoyées depuis un ou plusieurs ligne (pop_up_compta), on cré donc un enregistrement
		$query = "INSERT INTO compta_docs  (numero_compte, montant, ref_doc, id_journal)
							VALUES ('".$line["numero_compte"]."', '".$line["montant"]."', '".$this->ref_doc."' , '".$line["id_journal"]."' ) 
							";
		$bdd->exec ($query);
		unset($query);
	}
	
	return true;
}

//suppression des lignes de compta de la fac
function supprime_ventilation_facture () {
	global $bdd;

	$query = "DELETE FROM compta_docs
						WHERE ref_doc = '".$this->ref_doc."'
						";
	$bdd->exec ($query);
	return true;
}

//verification des lignes de compta (en cas de changement dans le contenu du document)
function check_ventilation_facture () {
	global $bdd;
	global $TARIFS_NB_DECIMALES;
	global $DEFAUT_COMPTE_HT_ACHAT;
	global $DEFAUT_COMPTE_TVA_ACHAT;
	global $DEFAUT_COMPTE_TIERS_ACHAT;
	
	//on bloque si la facture n'est pas à régler ou acquitée
	if ($this->id_etat_doc == 33 || $this->id_etat_doc == 32 ) { return false; }
	
	$ventilation_facture = $this->charger_ventilation_facture ();
	if (count($ventilation_facture)) {
		
			// si plusieurs lignes de définies
			// on verifie que le montant du document correspond au montant ht des lignes comptables par journal
			$tmp_montant_ht = 0;
			$tmp_montant_tva = 0;
			$tmp_montant_ttc = 0;
			foreach ($ventilation_facture as $line) {
				if (isset($line['6'])) {	$tmp_montant_ht += $line['6']->montant;}
				if (isset($line['7'])) {	$tmp_montant_tva += $line['7']->montant;}
				if (isset($line['8'])) {	$tmp_montant_ttc += $line['8']->montant;}
			}

                        if (abs(round($this->getMontant_ht (),$TARIFS_NB_DECIMALES)-$tmp_montant_ht) <= 0.011  ) {return true;}
			//si ce n'est pas le cas
			// on supprime puis on ajoute une ligne avec les valeurs par defaut
			$this->supprime_ventilation_facture ();
		
	}
	//on ajoute une ligne avec les valeurs par defaut
	$this->ajout_ventilation_facture ();
	return true;

}



/* --------------------- */
//@FIXME
// *************************************************************************************************************
// * WARNING! BETA Version NOT TO BE RC.
// *************************************************************************************************************
// chargement ventilation facture fournisseur
/**
 * Ajoute les lignes de ventilations associé au document 
 * V2.0450.04012010 - fixed, en test
 * //@TODO TESTME.
 * @return bool
 */
public function ajout_ventilation_facture($infos_lines = array()) {
	
	//Globals	
	global $bdd;
	global $DEFAUT_ID_PAYS;
	global $DEFAUT_COMPTE_HT_ACHAT;
	global $DEFAUT_COMPTE_TVA_ACHAT;
	global $DEFAUT_COMPTE_TIERS_ACHAT;
	global $DEFAUT_ID_FOURNISSEUR_CATEG;
	global $FOURNISSEUR_ID_PROFIL;
	global $TARIFS_NB_DECIMALES; 
	global $CALCUL_TARIFS_NB_DECIMALS;
	
	
	//si aucunes données transmise on cré un ligne d'aprés les infos de chaque art_categ présent , TVA et TTC compte tier client)
	if (!count($infos_lines)) {
		// requete sql : on recup. tt les lignes du documents + ref_article + montant_ht de la transaction	
		$query = "SELECT a.ref_article,
				        dl.pu_ht, dl.qte, dl.remise, dl.tva, 
				        IF (
			                ( a.numero_compte_achat = NULL ) ,
			                ( SELECT ac.defaut_numero_compte_achat
			                  FROM art_categs ac
			                  WHERE ac.ref_art_categ = a.ref_art_categ  ),
			                a.numero_compte_achat
				          ) as compte
					FROM articles a
					LEFT JOIN  docs_lines dl ON dl.ref_article = a.ref_article
					WHERE dl.ref_doc = '".$this->ref_doc."' && ISNULL(dl.ref_doc_line_parent);  ";
		$resultat = $bdd->query ($query);
		// sur tout le tableau de résultat
		$ventilations_ht = array();
		$ventilations_tva = array();
		while ($ventil = $resultat->fetchObject()) {
			// nouvels objet de ventilation
			$ventil_ht = new stdClass();
			$ventil_tva = new stdClass();
			
			/* --- traitements HT --- */
			// si l'article n'a pas de compte par defaut
			if ($ventil->compte == "") {
				// on appelle la fonction de determination de compte comptable by ref_article
				$ventil_ht->compte = doc_faf::get_compte_comptable_by_ref_article($ventil->ref_article,'achat');
			} else {
				// sinon on garde le compte assigné
				$ventil_ht->compte = $ventil->compte;
			}
			// defini le montant ht, formaté a $CALCUL_TARIFS_NB_DECIMALS chiffres apres la virgule (.)
			$ventil_ht->montant_ht = round ($ventil->pu_ht * $ventil->qte * (1-$ventil->remise/100), $CALCUL_TARIFS_NB_DECIMALS);
			
			/* --- traitements TVA --- */
			// defini le taux de tva
			$ventil_tva->taux = $ventil->tva;
			// on appelle la fonction de determination de compte comptable by taux
			$ventil_tva->compte = doc_faf::get_compte_comptable_by_taux_tva($ventil_tva->taux,'achat');
			// defini le montant tva, formaté a $CALCUL_TARIFS_NB_DECIMALS chiffres apres la virgule (.)
			$ventil_tva->tva = round($ventil->pu_ht * ($ventil->tva/100)* $ventil->qte * (1-$ventil->remise/100), $CALCUL_TARIFS_NB_DECIMALS) ;
			
			// feed du tableau de ventilation
			$ventilations_ht[] = $ventil_ht;
			$ventilations_tva[] = $ventil_tva;
		}
		// on trie le tableau de ventilation par compte DESC
		// si le trie est ok
		if ( count($ventilations_ht) > 1 ) { 
			usort($ventilations_ht, array( $this, "ventilation_sort_by_compte" ));
		}
			/* ******************* */
			/* ------- H T ------- */
			/* ******************* */
			// montant global HT
			$calcul_HT = 0;
			// nombre de ventilation a traiter
			$max = count($ventilations_ht);
			$i = 0; $compte = ""; $montant_ht =0;
			do{	// faire tant que existe une ventilation
				do { // faire tant que le compte ne change pas
					// somme des montants du compte
					$montant_ht +=  $ventilations_ht[$i]->montant_ht;
					// somme des montants globals
					$calcul_HT +=  $ventilations_ht[$i]->montant_ht;
					// affect le compte
					$compte = $ventilations_ht[$i]->compte;
					//next ligne
					$i++;
				}while($i<=$max-1 && $compte == $ventilations_ht[$i]->compte);
				// on ventile a chaque changement de compte comptable
				$query3 = "INSERT INTO compta_docs  (numero_compte, montant, ref_doc, id_journal)
									VALUES ('".$compte."', '".round($montant_ht,$CALCUL_TARIFS_NB_DECIMALS)."',  '".$this->ref_doc."' , '6') ";
				$bdd->exec ($query3);
				unset($query3);
				// reset des variables
				$compte = 0; $montant_ht = 0;
			} while ($i<=$max-1);
		
		if ( count($ventilations_tva) > 1 ) {
			usort($ventilations_tva, array( $this, "ventilation_sort_by_compte" ));
		}
			/* ******************* */
			/* ------- TVA ------- */
			/* ******************* */
			// montant global HT
			$calcul_TVA = 0;
			$max = count($ventilations_tva);
			$i = 0; $taux = 0; $montant_tva =0;
			do{	// faire tant que existe une ventilation
				do{// faire tant que le taux tva ne change pas
					// somme des montants du compte
					$montant_tva += $ventilations_tva[$i]->tva;
					// somme des montants globals
					$calcul_TVA += $ventilations_tva[$i]->tva;
					// affect le taux
					$compte = $ventilations_tva[$i]->compte;
					//next ligne
					$i++;
				}while($i<=$max-1 && $compte == $ventilations_tva[$i]->compte);
				//sauvegarde de la ligne dans compta_docs TVA achat
				$query3 = "INSERT INTO compta_docs  (numero_compte, montant, ref_doc, id_journal)
									VALUES ('".$compte."', '".round($montant_tva,$CALCUL_TARIFS_NB_DECIMALS)."',  '".$this->ref_doc."' , '7') 	";
				$bdd->exec ($query3);
				unset($query3);
				$taux = 0; $montant_tva =0;
			}while ($i<=$max-1);
		
			/* ******************* */
			/* ------- TTC ------- */
			/* ******************* */
			//compte tier achat (categorie fournisseur)
			$categorie_fournisseur = $DEFAUT_ID_FOURNISSEUR_CATEG;
			$compte_ttc_defaut =  $DEFAUT_COMPTE_TIERS_ACHAT;
			$contact = new contact ($this->ref_contact);
			contact::load_profil_class($FOURNISSEUR_ID_PROFIL);
			if (is_object($contact) && $contact->getRef_contact ()) {
				$contact_profil = $contact->getProfil($FOURNISSEUR_ID_PROFIL);
				$compte_ttc_defaut = $contact_profil->getDefaut_numero_compte ();
			} else {
				$liste_categ = contact_fournisseur::charger_fournisseurs_categories ();
				foreach ($liste_categ as $categ) {
					if ($categ->id_fournisseur_categ != $categorie_fournisseur) {continue;}
					if ($categ->defaut_numero_compte) {$compte_ttc_defaut = $categ->defaut_numero_compte; break;}
					
				}
			}
			if (!$compte_ttc_defaut) {$compte_ttc_defaut = $DEFAUT_COMPTE_TIERS_ACHAT;}
			//verification de la correspondance au centime du total TVA + HT = TTC
			$calcul_TTC = round($calcul_HT + $calcul_TVA,$CALCUL_TARIFS_NB_DECIMALS);
			if (abs(round($this->getMontant_ttc (),2))-0.01 <= abs($calcul_TTC)  && abs(round($this->getMontant_ttc (),2))+0.01 >= abs($calcul_TTC)) {
			//sauvegarde de la ligne dans compta_docs TTC achat
			$query3 = "INSERT INTO compta_docs  (numero_compte, montant, ref_doc, id_journal)
								VALUES ('".$compte_ttc_defaut ."', '".round($calcul_TTC,$CALCUL_TARIFS_NB_DECIMALS)."',  '".$this->ref_doc."' , '8') 	";
			$bdd->exec ($query3);
			unset($query3);
			}

			return true;
		} else {
                    foreach ($infos_lines as $line) {
                            //sinon les infos sont envoyées depuis un ou plusieurs ligne (pop_up_compta), on cré donc un enregistrement
                            $query = "INSERT INTO compta_docs  (numero_compte, montant, ref_doc, id_journal)
                                                                    VALUES ('".$line["numero_compte"]."', '".$line["montant"]."', '".$this->ref_doc."' , '".$line["id_journal"]."' )
                                                                    ";
                            $bdd->exec ($query);
                            unset($query);
                    }
                    return true;
		}

	}
	
static function get_compte_comptable_by_ref_article( $ref_article, $mode ){
	global $bdd;
	global $DEFAUT_COMPTE_HT_VENTE;
	global $DEFAUT_COMPTE_HT_ACHAT;
	
	
	// determination du compte comptable global
	// et exit en false si erreur sur l'appel de la fonction
	if($mode=="vente"){ $mode = "vente"; $defaut_compte = $DEFAUT_COMPTE_HT_VENTE;  } 
	elseif ($mode=="achat"){ $mode = "achat"; $defaut_compte = $DEFAUT_COMPTE_HT_ACHAT; }
	else  { return false; }
	
	//Recherche du compte comptable de la ref_article
	// on prend la ref_art_categ afin de remonter l'arbre des categories
	$query = " SELECT numero_compte_".$mode." as compte, ref_art_categ FROM articles WHERE ref_article = '".$ref_article."'";
	$res = $bdd->query( $query );
	$search = $res->fetchObject();
	$compte = $search->compte;
	$ref_categ = $search->ref_art_categ;
	// si l'article n'a pas de compte associé, alors on cherche celui de sa catégorie
	// alors on boucle TANT QUE pas de compte && existe un parent
	while( $compte == "" && $ref_categ != "" && count($search)>0){
		$query = " SELECT defaut_numero_compte_".$mode." as compte, ref_art_categ_parent FROM art_categs WHERE ref_art_categ = '".$ref_categ."'";
		$res = $bdd->query( $query );
		$search = $res->fetchObject();
		$compte = $search->compte;
		$ref_categ = $search->ref_art_categ_parent;
	}
	// si la boucle ne renvois pas de compte comptable
	// on utilise le compte global selon le mode selectioné
	if( $compte == "" ){
		return $defaut_compte;
	} else {
		return $compte;
	}
}

static function get_compte_comptable_by_taux_tva( $taux, $mode ){
	global $bdd;
	global $DEFAUT_COMPTE_TVA_VENTE;
	global $DEFAUT_COMPTE_TVA_ACHAT;
	
	
	// determination du compte comptable global
	// et exit en false si erreur sur l'appel de la fonction
	if($mode=="vente"){ $mode = "vente"; $defaut_compte = $DEFAUT_COMPTE_TVA_VENTE;  } 
	elseif ($mode=="achat"){ $mode = "achat"; $defaut_compte = $DEFAUT_COMPTE_TVA_ACHAT; }
	else  { return false; }
	
	
	$compte = "";
	//Recherche du compte comptable de la ref_article
	// on prend la ref_art_categ afin de remonter l'arbre des categories
	$query = " SELECT num_compte_".$mode." as compte FROM tvas t WHERE t.tva > (".$taux."-0.01) && t.tva < (".$taux."+0.01)";
	if ($res = $bdd->query( $query )){
		if ($search = $res->fetchObject()){
			$compte = $search->compte;
			}
		}
	// si pas de compte comptable
	// on utilise le compte global selon le mode selectioné
	if( $compte == "" ){
		return $defaut_compte;
	} else {
		return $compte;
	}
}
 function ventilation_sort_by_compte($a,$b){
	// fonction de trie sur un table de ventilations
	// on trie par compte comptable DESC
	return 	($a->compte > $b->compte) ? -1 : 1;
}
// *************************************************************************************************************
// * END WARNING! BETA Version NOT TO BE RC.
// *************************************************************************************************************
//@FIXME
/* --------------------- */

//fonctions de mise à jour lignes si non bloquée et des doc_faf_compta en cas de changement du contenu du document

protected function add_line_article ($infos) {
	if (!$this->quantite_locked) {
		parent::add_line_article ($infos);
		$this->check_ventilation_facture ();
	}
}

public function delete_line ($ref_doc_line) {
	if (!$this->quantite_locked) {
		$doc_line_infos = $this->charger_line ($ref_doc_line);
		parent::delete_line ($ref_doc_line);
		if ($doc_line_infos->type_of_line == "article") {
			$this->check_ventilation_facture ();
		}
	}
	
}

public function maj_line_qte ($ref_doc_line, $new_qte) {
	if (!$this->quantite_locked) {
		parent::maj_line_qte ($ref_doc_line, $new_qte);
		$this->check_ventilation_facture ();
	}
}

public function maj_line_pu_ht ($ref_doc_line, $new_pu_ht) {
	if (!$this->quantite_locked) {
		parent::maj_line_pu_ht ($ref_doc_line, $new_pu_ht);
		$this->check_ventilation_facture ();
	}
}
public function maj_line_tva ($ref_doc_line, $new_tva) {
	if (!$this->quantite_locked) {
		parent::maj_line_tva ($ref_doc_line, $new_tva);
		$this->check_ventilation_facture ();
	}
}

public function maj_line_remise ($ref_doc_line, $new_remise) {
	if (!$this->quantite_locked) {
		parent::maj_line_remise ($ref_doc_line, $new_remise);
		$this->check_ventilation_facture ();
	}
}

public function set_line_visible ($ref_doc_line) {
	if (!$this->quantite_locked) {
		$doc_line_infos = $this->charger_line ($ref_doc_line);
		parent::set_line_visible ($ref_doc_line);
		if ($doc_line_infos->type_of_line == "article") {
			$this->check_ventilation_facture ();
		}
	}
}

public function set_line_invisible ($ref_doc_line) {
	if (!$this->quantite_locked) {
		$doc_line_infos = $this->charger_line ($ref_doc_line);
		parent::set_line_invisible ($ref_doc_line);
		if ($doc_line_infos->type_of_line == "article") {
			$this->check_ventilation_facture ();
		}
	}
}




// *************************************************************************************************************
// FONCTIONS DE LIAISON ENTRE DOCUMENTS 
// *************************************************************************************************************
// Chargement des documents à lier potentiellement
public function charger_liaisons_possibles () {
	global $bdd;

	$this->liaisons_possibles = array();
	if ($this->id_etat_doc == 33 || $this->id_etat_doc == 35) {$this->liaisons_possibles_loaded = true; return true;}
	

	$query = "SELECT d.ref_doc, d.id_type_doc, dt.lib_type_doc, d.id_etat_doc, de.lib_etat_doc,
									 d.date_creation_doc date_creation
						FROM documents d
							LEFT JOIN documents_types dt ON d.id_type_doc = dt.id_type_doc 
							LEFT JOIN documents_etats de ON d.id_etat_doc = de.id_etat_doc 
							LEFT JOIN documents_liaisons dl ON d.ref_doc = dl.ref_doc_source && dl.active = 1
							LEFT JOIN documents d2 ON d2.ref_doc = dl.ref_doc_destination && d2.id_type_doc = 8
						WHERE d.ref_contact = ".ref_or_null($this->ref_contact)." && 
									(d.id_type_doc = 7 && d.id_etat_doc = 31 ) && d2.ref_doc IS NULL
						ORDER BY date_creation "; 
	$resultat = $bdd->query($query); 
	while ($tmp = $resultat->fetchObject()) { $this->liaisons_possibles[] = $tmp; }

	$this->liaisons_possibles_loaded = true;


	return true;
}



// *************************************************************************************************************
// FONCTIONS DE GESTION DES REGLEMENTS
// *************************************************************************************************************

protected function need_infos_facturation () {
	// Si la facture est annulée ou acquittée, les informations de facturation ne sont pas nécessaires.
	if ($this->id_etat_doc == $this->ID_ETAT_ANNULE || $this->id_etat_doc == 35) { return false; }
	return true;
}

protected function reglement_inexistant () {
	if ($this->id_etat_doc == $this->ID_ETAT_ANNULE) { return false; }

	// Une facture devient "à régler" si aucun règlement n'est enregistré, sauf si en saisie
	if ($this->id_etat_doc == 32) { return false; }
	$this->maj_etat_doc(34);

	$_SESSION['INFOS']['change_etat'] = 1;

	return true;
}

protected function reglement_partiel () {
	// Une facture en saisie devient "A régler" lorsqu'un règlement est enregistré.
        if ($this->id_etat_doc == 32 || $this->id_etat_doc == 35) {
		$this->maj_etat_doc(34);
	}
	$GLOBALS['INFOS']['change_etat'] = 1;
}

protected function reglement_total () {
	// Une facture devient acquittée en cas de règlement total
	if ($this->id_etat_doc == 32 || $this->id_etat_doc == 34) {
		$this->maj_etat_doc(35);
	}
	$GLOBALS['INFOS']['change_etat'] = 1;
}


public function create_avf () {
	global $AVF_E_ID_REGMT_MODE;
	global $COMP_E_ID_REGMT_MODE;

	// Chargement du montant disponible pour cet avoir
	$this->calcul_montant_to_pay ();

	// Création de la "Compensation" et de l'"Avoir Client"
	$infos_comp['ref_contact'] 			= $this->ref_contact;
	$infos_comp['id_reglement_mode'] = $COMP_E_ID_REGMT_MODE;
	$infos_comp['date_reglement']	= date ("Y-m-d", time());
	$infos_comp['date_echeance']		= date ("Y-m-d", time());
	$infos_comp['direction_reglement'] = "entrant";
	$infos_comp['montant_reglement'] = abs($this->montant_to_pay);
	$comp = new reglement();
	$comp->create_reglement($infos_comp);

	// Association de la compensation à cette facture
	$tmp = $this->rapprocher_reglement ($comp);
	
	// Retour de l'information sur l'avoir généré
	$ref_avf = $comp->getRef_avf();
	return $ref_avf;
}


// *************************************************************************************************************
// FONCTIONS DE RESTITUTION DES DONNEES 
// *************************************************************************************************************
 
function getRef_doc_externe () {
	return $this->ref_doc_externe;
}

function getDate_echeance () {
	return $this->date_echeance;
}

function getDoc_fusion_dispo () {
	if (!$this->doc_fusion_dispo_loaded) {$this->liste_doc_fusion ();}
	return  $this->doc_fusion_dispo;
}




}

?>