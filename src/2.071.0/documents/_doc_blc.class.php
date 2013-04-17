<?php
// *************************************************************************************************************
// CLASSE REGISSANT LES INFORMATIONS SUR UN DOCUMENT DE TYPE BON DE LIVRAISON CLIENT
// *************************************************************************************************************


final class doc_blc extends document {

	protected $ref_doc_externe;
	protected $id_stock;

	protected $id_magasin;
	protected $ref_adr_stock;
	protected $lib_stock;

	protected $id_livraison_mode;

	protected $ID_TYPE_DOC 					= 3;
	protected $LIB_TYPE_DOC 				= "Bon de Livraison Client";
	protected $CODE_DOC 						= "BLC";
	protected $DOC_ID_REFERENCE_TAG = 15;

	protected $DEFAUT_ID_ETAT 	= 11;
	protected $DEFAUT_LIB_ETAT 	= "En saisie";
	protected $GESTION_SN	 		= 1;
	protected $CONTENT_FROM		= "STOCK";
	protected $PU_FROM				= "PV";
	protected $ACCEPT_REGMT		= 1;
	protected $ID_ETAT_ANNULE	= 12;

	protected $client_facturation;
	protected $client_encours;
	protected $a_facturer = false;

	protected $doc_fusion_dispo;
	protected $doc_fusion_dispo_loaded;


public function open_doc ($select = "", $left_join = "") {
	global $bdd;

	$this->check_profils ();

	$select = ", db.id_stock, s.lib_stock, s.ref_adr_stock, db.id_livraison_mode, db.ref_doc_externe, ac.facturation_periodique, ac.encours, db.id_magasin ";
	$left_join = " LEFT JOIN doc_blc db ON db.ref_doc = d.ref_doc 
								 LEFT JOIN stocks s ON db.id_stock = s.id_stock
								 LEFT JOIN annu_client ac ON ac.ref_contact = d.ref_contact";

	if (!$doc = parent::open_doc($select, $left_join)) { return false; }

	$this->ref_doc_externe	 	= $doc->ref_doc_externe;
	$this->id_stock 				= $doc->id_stock;
	$this->ref_adr_stock 		= $doc->ref_adr_stock;
	$this->lib_stock 				= $doc->lib_stock;
	$this->id_magasin 			= $doc->id_magasin;
	$this->id_livraison_mode 	= $doc->id_livraison_mode;

	$this->client_facturation = "immediate";
	if ($doc->facturation_periodique) {
		$this->client_facturation = "differee";
	}
	$this->client_encours = $doc->encours;

	
	// Blocage des quantités
	if ($this->id_etat_doc == 14 || $this->id_etat_doc == 15) {
		$this->quantite_locked = true;
	}

	return true;
}



// *************************************************************************************************************
// FONCTIONS LIEES A LA CREATION D'UN DOCUMENT
// *************************************************************************************************************

public function create_doc () { 
	global $bdd;
	global $DEFAUT_APP_TARIFS_CLIENT;
	global $DEFAUT_ID_MAGASIN;

	$this->app_tarifs = $DEFAUT_APP_TARIFS_CLIENT;

	$this->id_stock 	= $_SESSION['magasin']->getId_stock();
	$this->lib_stock 	= $_SESSION['magasin']->getLib_stock();
	$this->id_magasin = $_SESSION['magasin']->getId_magasin (); //$DEFAUT_ID_MAGASIN;

	if (isset($GLOBALS['_OPTIONS']['CREATE_DOC']['id_stock'])) {
		$this->id_stock = $GLOBALS['_OPTIONS']['CREATE_DOC']['id_stock'];
		if (!isset($_SESSION['stocks'][$this->id_stock])) {
			$GLOBALS['_ALERTES']['stock_not_actif'] = 1;
			return false;
		}
		$this->lib_stock = $_SESSION['stocks'][$this->id_stock]->getLib_stock();
	}
	
	if (isset($GLOBALS['_OPTIONS']['CREATE_DOC']['ref_doc_externe'])) {
		$this->ref_doc_externe = $GLOBALS['_OPTIONS']['CREATE_DOC']['ref_doc_externe'];
	}

	if (!parent::create_doc()) { return false; }

	$query = "INSERT INTO doc_blc (ref_doc, ref_doc_externe, id_stock, id_magasin)
						VALUES ('".$this->ref_doc."', '".addslashes($this->ref_doc_externe)."', '".$this->id_stock."', '".$this->id_magasin."') ";
	$bdd->exec ($query);
	
	$this->attribution_commercial ($this->commerciaux);

	return true;
}


// Charge les informations supplémentaire du contact
protected function load_infos_contact () {
	global $CLIENT_ID_PROFIL;
	global $COMMERCIAL_ID_PROFIL;

	$this->load_infos_contact_client ();
	parent::load_infos_contact();
	
	$this->commerciaux = array();

	$user_commercial = new contact($_SESSION['user']->getRef_contact());
	if ($user_commercial->is_profiled ($COMMERCIAL_ID_PROFIL)) {
		$commercial = new stdclass;
		$commercial->ref_contact = $_SESSION['user']->getRef_contact();
		$commercial->part = 100;
		$this->commerciaux[] = $commercial;
	}

	$this->client_facturation = "immediate";
	if (is_object($this->contact)) {
		$infos_client = $this->contact->getProfil ($CLIENT_ID_PROFIL);
		$this->client_encours = $infos_client->getEncours();
		if ($infos_client->getFactures_par_mois()) {
			$this->client_facturation = "differee";
		}
		$infos_client->maj_type_client ("client");
		if ($infos_client->getRef_commercial ()) {
			$this->commerciaux = array();
			$commercial = new stdclass;
			$commercial->ref_contact = $infos_client->getRef_commercial ();
			$commercial->part = 100;
			$this->commerciaux[] = $commercial;
		}
	}
	
	if (isset($this->ref_doc) && $this->ref_doc) {
		$this->attribution_commercial ($this->commerciaux);
	}
}


//attibution par défaut du commercial
protected function load_defauts_infos_contact () {
	global $COMMERCIAL_ID_PROFIL;
	
	parent::load_defauts_infos_contact();

	$this->commerciaux = array();

	$user_commercial = new contact($_SESSION['user']->getRef_contact());
	if ($user_commercial->is_profiled ($COMMERCIAL_ID_PROFIL)) {
		$commercial = new stdclass;
		$commercial->ref_contact = $_SESSION['user']->getRef_contact();
		$commercial->part = 100;
		$this->commerciaux[] = $commercial;
		if (isset($this->ref_doc) && $this->ref_doc) {
			$this->attribution_commercial ($this->commerciaux);
		}
	}
	return true;
}


// Renvoie l'adresse a utiliser dans le document pour un contact donné
function define_adresse_contact () {
	global $bdd;

	$adresse_contact_ok = 0;
	if (isset($GLOBALS['_OPTIONS']['CREATE_DOC']['ref_adr_contact'])) {
		$this->ref_adr_contact = $GLOBALS['_OPTIONS']['CREATE_DOC']['ref_adr_contact'];
		$adresse_contact_ok = 1;
	}
	if (isset($GLOBALS['_OPTIONS']['CREATE_DOC']['adresse_contact'])) {
		$this->adresse_contact = $GLOBALS['_OPTIONS']['CREATE_DOC']['adresse_contact'];
		$adresse_contact_ok = 1;
	}
	if (isset($GLOBALS['_OPTIONS']['CREATE_DOC']['code_postal_contact'])) {
		$this->code_postal_contact = $GLOBALS['_OPTIONS']['CREATE_DOC']['code_postal_contact'];
		$adresse_contact_ok = 1;
	}
	if (isset($GLOBALS['_OPTIONS']['CREATE_DOC']['ville_contact'])) {
		$this->ville_contact = $GLOBALS['_OPTIONS']['CREATE_DOC']['ville_contact'];
		$adresse_contact_ok = 1;
	}
	if (isset($GLOBALS['_OPTIONS']['CREATE_DOC']['id_pays_contact'])) {
		$this->id_pays_contact = $GLOBALS['_OPTIONS']['CREATE_DOC']['id_pays_contact'];
		$adresse_contact_ok = 1;
	}

	if (!$adresse_contact_ok && ($_SESSION['magasin']->getMode_vente() == "VAC")) {
		$this->ref_adr_contact = "NULL";
		$this->adresse_contact = $_SESSION['magasin']->getLib_magasin ();
	}
	elseif (!$adresse_contact_ok) {
		// Sélection des adresses prédéfinies
		$query = "SELECT ref_adr_livraison, a1.text_adresse ta1, a1.code_postal cp1, a1.ville v1, a1.id_pays ip1, p1.pays p1
							FROM annu_client ac
								LEFT JOIN adresses a1 ON ac.ref_adr_livraison = a1.ref_adresse
								LEFT JOIN pays p1 ON a1.id_pays = p1.id_pays
							WHERE ac.ref_contact = '".$this->ref_contact."' ";
		$resultat = $bdd->query ($query); 
		if (!$a = $resultat->fetchObject()) { return false; }

		$this->ref_adr_contact 			= $a->ref_adr_livraison;
		$this->adresse_contact 			= $a->ta1;
		$this->code_postal_contact 	= $a->cp1 ;
		$this->ville_contact 				= $a->v1 ;
		$this->id_pays_contact 			= $a->ip1 ;
		$this->pays_contact 				= $a->p1 ;
	}

	return true;
}




// *************************************************************************************************************
// FONCTIONS LIEES A LA MODIFICATION D'UN DOCUMENT
// *************************************************************************************************************

// Met à jour l' id_magasin pour ce bon de livraison
public function maj_id_magasin ($new_id_magasin) {
	global $bdd;	

	if (!is_numeric($new_id_magasin)) {
		$GLOBALS['_ALERTES']['bad_id_magasin'] = 1;
	}

	if (count($GLOBALS['_ALERTES'])) {
		return false;
	}

	$this->id_magasin = $new_id_magasin;
	// *************************************************
	// MAJ de la base
	$query = "UPDATE doc_blc 
						SET id_magasin = '".$this->id_magasin."'
						WHERE ref_doc = '".$this->ref_doc."' ";
	$bdd->exec ($query);

	// *************************************************
	// Retour des informations
	$GLOBALS['_INFOS']['id_magasin'] = $this->id_magasin;

	return true;
}

// Met à jour la ref_doc_externe
public function maj_ref_doc_externe ($ref_doc_externe) {
	global $bdd;	

	$this->ref_doc_externe = $ref_doc_externe;

	// *************************************************
	// MAJ de la base
	$query = "UPDATE doc_blc 
						SET ref_doc_externe = '".addslashes($this->ref_doc_externe)."'
						WHERE ref_doc = '".$this->ref_doc."' ";
	$bdd->exec ($query);
	
	return true;
}

// Met à jour la date de livraison demandée
public function maj_id_livraison_mode ($id_livraison_mode) {
	global $bdd;
	
	//chargement de l'ancien mode de livraison pour suppression de la ligne de document correspondante
	$livraison_mode_old = new livraison_modes($this->id_livraison_mode);
	//suppression
	if ($livraison_mode_old->getRef_article()) {
		$query = "DELETE  FROM  docs_lines 
							WHERE ref_doc = '".$this->ref_doc."' && ref_article = ".ref_or_null($livraison_mode_old->getRef_article())." ";
		$bdd->exec ($query);
	}
	
	$livraison_mode = new livraison_modes($id_livraison_mode);
	//mise à jour du nouveau mode de livraison
	$this->id_livraison_mode = $id_livraison_mode;

	$query = "UPDATE doc_blc SET id_livraison_mode = ".num_or_null($this->id_livraison_mode)."
						WHERE ref_doc = '".$this->ref_doc."' ";
	$bdd->exec ($query);
	
	//calcul et insertion pour ce document des frais de port (calcul effectué depuis la class livraison mode)
	$livraison_mode->calcul_frais_livraison_doc ($this);
	
	return true;
}

// Liste des documents pouvant être fusionner
public function check_allow_fusion ($second_document) {
	//verifcation que l'état des document permet la fusion
	if (($this->id_etat_doc != "11" && $this->id_etat_doc != "13") && ($second_document->getId_etat_doc () != "11" && $second_document->getId_etat_doc () != "13")) {
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
						WHERE (d.id_etat_doc = '11' ||  d.id_etat_doc = '13' ) && d.ref_contact = '".$this->ref_contact."' && d.ref_doc != '".$this->ref_doc."'
						GROUP BY d.ref_doc
						ORDER BY date_doc DESC ";
	$resultat = $bdd->query ($query);
	while ($doc = $resultat->fetchObject()) {$this->doc_fusion_dispo[] = $doc;}
	
	$this->doc_fusion_dispo_loaded = true;
	return true;
}



// *************************************************************************************************************
// FONCTIONS DE GESTION DU CONTENU
// *************************************************************************************************************
protected function doc_line_infos_supp () {
	$query['select']			= ", dl_blc.ref_doc_line_cdc, sa.qte stock";
	$query['left_join'] 	= " LEFT JOIN doc_lines_blc dl_blc ON dl_blc.ref_doc_line = dl.ref_doc_line
														LEFT JOIN stocks_articles sa ON sa.ref_article = dl.ref_article && 
																			sa.id_stock = '".$this->id_stock."' ";
	return $query;
}

// Chargement des informations supplémentaires concernant les numéros de série 
protected function doc_line_sn_infos_supp () {
	$query['select']		= ", IF (ISNULL(sas.numero_serie), 0, 1) as sn_exist";
	$query['left_join'] = " LEFT JOIN stocks_articles_sn sas ON sas.numero_serie = dls.numero_serie";
	return $query;
}



// *************************************************************************************************************
// FONCTIONS LIEES A LA MODIFICATION DE L'ETAT D'UN DOCUMENT
// *************************************************************************************************************

// Vérification de la possibilité de changer l'état du document
protected function check_maj_etat ($new_etat_doc) {
	if ($new_etat_doc == 14 ) {
		$new_etat_doc = 15;
	}
	return parent::check_maj_etat($new_etat_doc);
}


// Action avant de changer l'état du document
protected function action_before_maj_etat ($new_etat_doc) {
	switch ($this->id_etat_doc) {
		case 11: case 12: case 13:
			// Livraison du BLC donc suppression du stock
			if ($new_etat_doc == 14 || $new_etat_doc == 15) {
				$this->del_content_from_stock ($this->id_stock);
				$this->add_service_abo();
				$this->add_service_conso();
			}
		break;
		case 14: case 15:
			if ($new_etat_doc == 11 || $new_etat_doc == 12 || $new_etat_doc == 13) {
				$this->add_content_to_stock ($this->id_stock);
				$this->del_service_abo();
				$this->del_service_conso();
			}
		break;
	}
	return true;
}


// Action après de changer l'état du document
protected function action_after_maj_etat ($old_etat_doc) {
	global $bdd;

	switch ($old_etat_doc) {
		case 11: case 12: case 13: 
			if ($this->id_etat_doc == 14 || $this->id_etat_doc == 15) {
				// Préciser dans le BL associé que la qté est livrée (ou en cours de livraison)
				$this->maj_cdc_qte_livree (1);
				
				//edi: mise à jour de l'etat de la commande
				if (!$this->liaisons_loaded) { $this->charger_liaisons(); }
				foreach($this->liaisons['source'] as $ref){
					if(preg_match('/^CDC-.+$/',$ref->ref_doc_source) == 1){
						//liaison_edi
						if($this->id_etat_doc == 15){
							edi_event(126,$ref->ref_doc_source,15);
						}
					}
				}
			}else if($this->id_etat_doc == 13){
				//edi: mise à jour de l'etat de la commande
				if (!$this->liaisons_loaded) { $this->charger_liaisons(); }
				foreach($this->liaisons['source'] as $ref){
					if(preg_match('/^CDC-.+$/',$ref->ref_doc_source) == 1){
						//liaison_edi
						edi_event(126,$ref->ref_doc_source,13);
					}
				}
			}
		break;
		case 14: case 15:
			if ($this->id_etat_doc == 11 || $this->id_etat_doc == 12 || $this->id_etat_doc == 13) {
				// Préciser dans le BL associé que la qté n'est pas livrée (ou en cours de livraison)
				$this->maj_cdc_qte_livree (-1);
			}
		break;
	}

	if (!$this->liaisons_loaded) { $this->charger_liaisons () ; }
	foreach ($this->liaisons['dest'] as $dest) {
		//si le BLC est déjà lié avec une facture (et la liaison valide), alors on ne facture pas
		if ($dest->active ) { $GLOBALS['_OPTIONS']['CREATE_DOC']['not_generer_facture'] = 1;}
	}
	if ((($this->id_etat_doc == 14 && $old_etat_doc !=15) || ($this->id_etat_doc == 15 && $old_etat_doc !=14))  && !isset($GLOBALS['_OPTIONS']['CREATE_DOC']['not_generer_facture'])) { 
		$this->generer_fa_client();
	}

	if ($this->id_etat_doc == 14 || $this->id_etat_doc == 15) {
		$this->quantite_locked = true;
	} else {
		$this->quantite_locked = false;
	}

	return true;
}



// *************************************************************************************************************
// FONCTIONS DIVERSES 
// *************************************************************************************************************

// PROFILS DE CONTACT NECESSAIRE POUR UTILISER CE TYPE DE DOCUMENT
function check_profils () {
	return $this->check_profil_client ();
}


//fonctions de mise à jour lignes si non bloquée 
protected function add_line_article ($infos) {
	if (!$this->quantite_locked) {
		parent::add_line_article ($infos);
	}
}

public function delete_line ($ref_doc_line) {
	if (!$this->quantite_locked) {
		parent::delete_line ($ref_doc_line);
	}
	
}

public function maj_line_qte ($ref_doc_line, $new_qte) {
	if (!$this->quantite_locked) {
		parent::maj_line_qte ($ref_doc_line, $new_qte);
	}
}

public function maj_line_pu_ht ($ref_doc_line, $new_pu_ht) {
	//if (!$this->quantite_locked) {
		parent::maj_line_pu_ht ($ref_doc_line, $new_pu_ht);
	//}
}
public function maj_line_tva ($ref_doc_line, $new_tva) {
	//if (!$this->quantite_locked) {
		parent::maj_line_tva ($ref_doc_line, $new_tva);
	//}
}

public function maj_line_remise ($ref_doc_line, $new_remise) {
	//if (!$this->quantite_locked) {
		parent::maj_line_remise ($ref_doc_line, $new_remise);
	//}
}

public function set_line_visible ($ref_doc_line) {
	if (!$this->quantite_locked) {
		parent::set_line_visible ($ref_doc_line);
	}
}

public function set_line_invisible ($ref_doc_line) {
	if (!$this->quantite_locked) {
		parent::set_line_invisible ($ref_doc_line);
	}
}





// *************************************************************************************************************
// FONCTIONS SPECIFIQUES AU TYPE DE DOC 
// *************************************************************************************************************

// Vérifie si il faut payer avant de pouvoir livrer le client
public function must_pay_before_livraison () {
	// Information sur la nécessité d'enregistrer un règlement
	if ($this->id_etat_doc != 11 && $this->id_etat_doc != 13) { return false; }

	$this->calcul_montant_to_pay ();
	if ((!is_numeric($this->client_encours) || ($this->montant_to_pay - $this->client_encours) > 0.01 ) && $this->montant_to_pay) {
		return true;
	}
	return false;
}


// Génère une facture client à partir de ce bl.
public function generer_fa_client () {
	global $bdd;

	// Sélection d'une adresse de facturation prédéterminée dans la commande si celle-ci a été définie dans la commande
	$query = "SELECT d.ref_adr_contact, d.adresse_contact, d.code_postal_contact, d.ville_contact, d.id_pays_contact
						FROM documents d
							LEFT JOIN documents_liaisons dl ON d.ref_doc = dl.ref_doc_source
						WHERE ref_doc_destination = '".$this->ref_doc."' && d.id_type_doc = 2 ";
	$resultat = $bdd->query ($query);
	if ($tmp = $resultat->fetchObject()) {
		$GLOBALS['_OPTIONS']['CREATE_DOC']['ref_adr_contact'] = $tmp->ref_adr_contact;
		$GLOBALS['_OPTIONS']['CREATE_DOC']['adresse_contact'] = $tmp->adresse_contact;
		$GLOBALS['_OPTIONS']['CREATE_DOC']['code_postal_contact'] = $tmp->code_postal_contact;
		$GLOBALS['_OPTIONS']['CREATE_DOC']['ville_contact'] = $tmp->ville_contact;
		$GLOBALS['_OPTIONS']['CREATE_DOC']['id_pays_contact'] = $tmp->id_pays_contact;
	}
	else {
		$query = "SELECT ref_adr_facturation, a1.text_adresse ta1, a1.code_postal cp1, a1.ville v1, a1.id_pays ip1, p1.pays p1
							FROM annu_client ac
								LEFT JOIN adresses a1 ON ac.ref_adr_livraison = a1.ref_adresse
								LEFT JOIN pays p1 ON a1.id_pays = p1.id_pays
							WHERE ac.ref_contact = '".$this->ref_contact."' ";
		$resultat = $bdd->query ($query);
		if ($a = $resultat->fetchObject()) { 
			$GLOBALS['_OPTIONS']['CREATE_DOC']['ref_adr_contact'] = $a->ref_adr_facturation;
			$GLOBALS['_OPTIONS']['CREATE_DOC']['adresse_contact'] = $a->ta1;
			$GLOBALS['_OPTIONS']['CREATE_DOC']['code_postal_contact'] = $a->cp1;
			$GLOBALS['_OPTIONS']['CREATE_DOC']['ville_contact'] = $a->v1;
			$GLOBALS['_OPTIONS']['CREATE_DOC']['id_pays_contact'] = $a->ip1;
		}
	}
	$GLOBALS['_OPTIONS']['CREATE_DOC']['info_line'] = 1;
	$GLOBALS['_OPTIONS']['CREATE_DOC']['follow_reglement'] = 1;
	$GLOBALS['_OPTIONS']['CREATE_DOC']['follow_commerciaux'] = 1;
	$GLOBALS['_OPTIONS']['CREATE_DOC']['code_affaire'] = $this->code_affaire;

	return $this->copie_doc (4);
}




// Génère un retour des produits sélectionnés
public function generer_retour_client ($lines = false) {
	// Possible uniquement si le BL est livré
	if ($this->id_etat_doc != 15) { return false; }
	
	if (is_array($lines)) {
		$GLOBALS['_OPTIONS']['CREATE_DOC']['doc_lines'] = $lines;
	}
	
	$GLOBALS['_OPTIONS']['CREATE_DOC']['code_affaire'] = $this->code_affaire;
	
	return $this->copie_doc (3);
}


// *************************************************************************************************************
// FONCTIONS DE RECOPIE D'UN DOCUMENT
// *************************************************************************************************************
// Lors de la copie vers un Bon de Livraison, la Quantité à livrer est inversée si il s'agit d'un retour
function action_before_copie_line_to_doc ($new_doc, $line) {
	if ($new_doc->getID_TYPE_DOC() != 3 || isset($GLOBALS['_OPTIONS']['FUSION']))  { return true; }

	$line->qte = -$line->qte;

	return true;
}

// Liaison entre les lignes des documents de la BLC et du BLC
function action_after_copie_line_to_doc ($new_doc, $line) {
	global $bdd;
	//en cas de fusion on met à jour les doc_lines_blc pour correspondance avec les CDC
  if (isset($GLOBALS['_OPTIONS']['FUSION'])) {
		$query = "UPDATE doc_lines_blc SET ref_doc_line = '".$line->ref_doc_line."'
							WHERE  ref_doc_line = '".$line->old_ref_doc_line."' ";
		$bdd->exec ($query);
		
		return true; 
	}
	
	return true;
}

protected function create_info_copie_line_texte ($doc_source) { 
	return "Votre référence: ".$this->ref_doc_externe; 
}

//insertion d'une ligne d'information au debut du BLC s'il est généré depuis une CDC ayant une référence externe
protected function create_info_copie_line_cdc ($doc_source) {
	if ($doc_source->getID_TYPE_DOC() == 2 && $doc_source->getRef_doc_externe () != "") {
	$infos['type_of_line'] = "information";
	$infos['titre'] = "Votre commande Ref.".$doc_source->getRef_doc_externe ()." du ".date_Us_to_Fr ($doc_source->getDate_creation());
	$infos['texte'] = $this->create_info_copie_line_texte ($doc_source);
	$this->add_line ($infos);
	}
}

// *************************************************************************************************************
// FONCTIONS LIEES A L'EDITION D'UN DOCUMENT 
// *************************************************************************************************************
protected function check_allow_maj_line_qte () { 
	if ($this->id_etat_doc == 15 || $this->id_etat_doc == 14) { return false; }
	return true; 
}


// *************************************************************************************************************
// FONCTIONS DE LIAISON ENTRE DOCUMENTS 
// *************************************************************************************************************
// Chargement les Bon de commande (2) "en cours" (9)
public function charger_liaisons_possibles () {
	global $bdd;
	
	$this->liaisons_possibles = array();
	if ($this->id_etat_doc == 12 || $this->id_etat_doc == 15) {$this->liaisons_possibles_loaded = true; return true;}
	
	$query = "SELECT d.ref_doc, d.id_type_doc, dt.lib_type_doc, d.id_etat_doc, de.lib_etat_doc,
									 d.date_creation_doc date_creation
						FROM documents d
							LEFT JOIN documents_types dt ON d.id_type_doc = dt.id_type_doc 
							LEFT JOIN documents_etats de ON d.id_etat_doc = de.id_etat_doc 
							LEFT JOIN documents_liaisons dl ON d.ref_doc = dl.ref_doc_source && dl.active = 1
							LEFT JOIN documents d2 ON d2.ref_doc = dl.ref_doc_destination && d2.id_type_doc = 3 
						WHERE d.ref_contact = ".ref_or_null($this->ref_contact)." && 
									(d.id_type_doc = 2 && d.id_etat_doc = 9 ) && (d2.ref_doc != '".$this->ref_doc."' || d2.ref_doc is null)
						ORDER BY date_creation  "; 
						// && d2.ref_doc IS NULL
	$resultat = $bdd->query($query); 
	while ($tmp = $resultat->fetchObject()) { $this->liaisons_possibles[] = $tmp; }

	$this->liaisons_possibles_loaded = true;

	return true;
}


// Action en cas de rupture d'une liaison
protected function action_before_break_liaison ($ref_doc) {
	global $bdd;

	// *************************************************
	// Actions spéciales uniquement en cas de rupture d'une liaison avec un CDC
	$query = "SELECT id_type_doc FROM documents WHERE ref_doc = '".$ref_doc."'";
	$resultat = $bdd->query ($query);
	if (!$doc = $resultat->fetchObject() || $doc->id_type_doc != 2) { return false; }

	// *************************************************
	// Diminution des quantités livrées le cas échéant
	if ($this->id_etat_doc == 14 || $this->id_etat_doc == 15) {
		$this->maj_cdc_qte_livree(-1);
	}

	// *************************************************
	// Suppression de la liaison des articles ligne à ligne
	$query = "UPDATE doc_lines_blc dl_blc, docs_lines dl1, docs_lines dl2
						SET dl_blc.ref_doc_line_cdc = NULL 
						WHERE dl1.ref_doc = '".$ref_doc."' && dl2.ref_doc = '".$this->ref_doc."' &&
									dl_blc.ref_doc_line_cdc = dl1.ref_doc_line && dl_blc.ref_doc_line = dl2.ref_doc_line ";
	$bdd->exec ($query);

	return true;
}




// *************************************************************************************************************
// FONCTIONS DE GESTION DES REGLEMENTS
// *************************************************************************************************************
protected function need_infos_facturation () {
	// Si la livraison a eu lieu, ou si elle est annulée, les informations de facturation seront gérées dans la facture.
	if ($this->id_etat_doc == $this->ID_ETAT_ANNULE || $this->id_etat_doc == 14 || $this->id_etat_doc == 15) { return false; }
	return true;
}



// *************************************************************************************************************
// FONCTIONS DIVERSES
// *************************************************************************************************************
function maj_cdc_qte_livree ($add = 1) {
	global $bdd;

	$signe = "+";
	if ($add != 1) { $signe = "-"; }

	if (!$this->contenu_loaded) { $this->charger_contenu(); }

	$liste_of_lines = "''";
	for ($i=0; $i<count($this->contenu); $i++) {
		if (isset($this->contenu[$i]->type_of_line) && $this->contenu[$i]->type_of_line != "article") { continue; }
		if (!$this->contenu[$i]->ref_doc_line_cdc || !$this->contenu[$i]->qte) { continue; }

		$query = "UPDATE doc_lines_cdc SET qte_livree = qte_livree ".$signe." ".$this->contenu[$i]->qte." 
							WHERE ref_doc_line = '".$this->contenu[$i]->ref_doc_line_cdc."' ";
		$resultat = $bdd->query ($query);
		if (!$resultat->rowCount()) {
			// La ligne n'existe pas il faut la créer
			$query = "INSERT INTO doc_lines_cdc (ref_doc_line, qte_livree)
								VALUES ('".$this->contenu[$i]->ref_doc_line_cdc."', '".$this->contenu[$i]->qte."') ";
			$bdd->exec ($query);
		}

		$liste_of_lines .= ",'".$this->contenu[$i]->ref_doc_line_cdc."'";
	}

	// Vérification de l'état des commandes livrées
	$query = "SELECT DISTINCT(ref_doc) ref_doc
						FROM docs_lines 
						WHERE ref_doc_line IN (".$liste_of_lines.") ";
	$resultat = $bdd->query ($query);
	$docs_cdc = array();
	while ($var = $resultat->fetchObject()) { 
		$cdc = open_doc ($var->ref_doc); 
		$cdc->check_if_traitee ();
	}
	
	//edi: mise à jour des stock
	if (!$this->contenu_materiel_loaded) { $this->charger_contenu_materiel (); }
	foreach ($this->contenu_materiel as $doc_line) {
		edi_event(116,$doc_line->ref_article);
	}
}


// *************************************************************************************************************
// FONCTIONS DE RESTITUTION DES DONNEES 
// *************************************************************************************************************

function getRef_doc_externe () {
	return $this->ref_doc_externe;
}
 
function getId_Stock () {
	return $this->id_stock;
}

function getClient_encours () {
	return $this->client_encours;
}

function getClient_facturation () {
	return $this->client_facturation;
}

function getA_facturer () {
	if ($this->id_etat_doc != 14 && $this->id_etat_doc != 15) {
		$this->a_facturer = false;
		return $this->a_facturer;
	}

	// Sinon le BLC est a facturer sauf si l'on trouve une facture (non annulée) liée
	$this->a_facturer = true;
	if (!$this->liaisons_loaded) { $this->charger_liaisons(); }

	foreach ($this->liaisons['dest'] as $liaison) {
		if ($liaison->id_type_doc != 4 || $liaison->id_etat_doc == 17) { continue; }
		$this->a_facturer = false;
		break;
	}
	return $this->a_facturer;
}

function getId_magasin () {
	return $this->id_magasin;
}


function getDoc_fusion_dispo () {
	if (!$this->doc_fusion_dispo_loaded) {$this->liste_doc_fusion ();}
	return  $this->doc_fusion_dispo;
}

function getId_livraison_mode () {
	return $this->id_livraison_mode;
}
 
 

}

?>
