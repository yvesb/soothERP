<?php
// *************************************************************************************************************
// CLASSE REGISSANT LES INFORMATIONS SUR UN DOCUMENT DE TYPE COMMANDE CLIENT
// *************************************************************************************************************


final class doc_cdc extends document {

	protected $ref_doc_externe;
	protected $date_livraison;
	protected $ref_adr_livraison;
	protected $adresse_livraison;
	protected $code_postal_livraison;
	protected $ville_livraison;
	protected $id_pays_livraison;
	protected $pays_livraison;
	protected $id_stock;
	protected $id_magasin;

	protected $id_livraison_mode;

	protected $ID_TYPE_DOC 					= 2;
	protected $LIB_TYPE_DOC 				= "Commande Client";
	protected $CODE_DOC 						= "CDC";
	protected $DOC_ID_REFERENCE_TAG = 14;

	protected $DEFAUT_ID_ETAT 	= 6;
	protected $DEFAUT_LIB_ETAT 	= "En saisie";

	protected $GESTION_SN	 		= 0;
	protected $CONTENT_FROM		= "CATALOGUE";
	protected $PU_FROM				= "PV";
	protected $ACCEPT_REGMT		= 1;
	protected $ID_ETAT_ANNULE	= 7;
	
	protected $doc_fusion_dispo;
	protected $doc_fusion_dispo_loaded;



public function open_doc ($select = "", $left_join = "") {
	global $bdd;

	$this->check_profils ();

	$select = ", dc.date_livraison, dc.ref_adr_livraison, dc.adresse_livraison, dc.code_postal_livraison, dc.ville_livraison, dc.id_pays_livraison, pc.pays pays_livraison, dc.ref_doc_externe, dc.id_stock, dc.id_magasin, dc.id_livraison_mode ";
	$left_join = " LEFT JOIN doc_cdc dc ON dc.ref_doc = d.ref_doc 
								 LEFT JOIN pays pc ON pc.id_pays = dc.id_pays_livraison";

	if (!$doc = parent::open_doc($select, $left_join)) { return false; }

	$this->ref_doc_externe	 	= $doc->ref_doc_externe;
	$this->date_livraison 		= $doc->date_livraison;
	$this->ref_adr_livraison 	= $doc->ref_adr_livraison;
	$this->adresse_livraison 	= $doc->adresse_livraison;
	$this->code_postal_livraison 	= $doc->code_postal_livraison;
	$this->ville_livraison 	= $doc->ville_livraison;
	$this->id_pays_livraison 	= $doc->id_pays_livraison;
	$this->pays_livraison 	= $doc->pays_livraison;
	$this->id_stock 					= $doc->id_stock;
	$this->id_magasin 				= $doc->id_magasin;
	$this->id_livraison_mode 	= $doc->id_livraison_mode;
	//$this->check_if_traitee ();
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
	$this->ref_adr_livraison = "NULL";
	$this->adresse_livraison = "";
	$this->code_postal_livraison 	= "";
	$this->ville_livraison 	= "";
	$this->id_pays_livraison 	= "";
	$this->pays_livraison 	= "";

	if (!parent::create_doc()) { return false; }
	
	$this->id_magasin 				= $_SESSION['magasin']->getId_magasin (); //$DEFAUT_ID_MAGASIN;

	if (isset($GLOBALS['_OPTIONS']['CREATE_DOC']['ref_doc_externe'])) {
		$this->ref_doc_externe = $GLOBALS['_OPTIONS']['CREATE_DOC']['ref_doc_externe'];
	}
	
	if (isset($GLOBALS['_OPTIONS']['CREATE_DOC']['code_affaire'])) {
		$this->code_affaire = $GLOBALS['_OPTIONS']['CREATE_DOC']['code_affaire'];
	}	
	
	if (isset($GLOBALS['_OPTIONS']['CREATE_DOC']['date_livraison'])) {
		$this->date_livraison = $GLOBALS['_OPTIONS']['CREATE_DOC']['date_livraison'];
	}
	$this->define_stock_expe ();

	// Insertion dans la base
	$query = "INSERT INTO doc_cdc (ref_doc, ref_doc_externe, date_livraison, ref_adr_livraison, adresse_livraison, code_postal_livraison, ville_livraison, id_pays_livraison, id_stock, id_magasin)
						VALUES ('".$this->ref_doc."', '".addslashes($this->ref_doc_externe)."', '".addslashes($this->date_livraison)."', 
										".ref_or_null($this->ref_adr_livraison).", '".addslashes($this->adresse_livraison)."',
										'".($this->code_postal_livraison)."', '".addslashes($this->ville_livraison)."', 
										".num_or_null($this->id_pays_livraison).", 
										'".$this->id_stock."', '".$this->id_magasin."' ) ";
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
	
	if (is_object($this->contact)) {
		$profil_client = $this->contact->getProfil ($CLIENT_ID_PROFIL);
		$profil_client->maj_type_client ("client");
		if ($profil_client->getRef_commercial ()) {
			$this->commerciaux = array();
			$commercial = new stdclass;
			$commercial->ref_contact = $profil_client->getRef_commercial ();
			$commercial->part = 100;
			$this->commerciaux[] = $commercial;
		}
	}
	
	if (isset($this->ref_doc) && $this->ref_doc) {
		$this->attribution_commercial ($this->commerciaux);
	}
}


// Renvoie l'adresse a utiliser dans le document pour un contact donné
function define_adresse_contact () {
	return parent::define_adresse_contact_et_livraison ();
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




function define_stock_expe () {
	global $DEFAUT_ID_STOCK_EXPE;

	$this->id_stock = $_SESSION['magasin']->getId_stock ();

	// Stock d'ou réserver les marchandises
	$livraison_externe = 0;
	foreach ($_SESSION['magasins'] as $id_magasin => $magasin) {
		if ($this->ref_adr_livraison != $magasin->getRef_adr_stock ()) { continue; }
		$livraison_externe = $id_magasin;
		break;
	}
	if ($livraison_externe) {
		if ($DEFAUT_ID_STOCK_EXPE) {
			$this->id_stock = $DEFAUT_ID_STOCK_EXPE;
		}
		else {
			$this->id_stock = $_SESSION['magasins'][$livraison_externe]->getId_stock ();
		}
	}

	$GLOBALS['_INFOS']['id_stock'] = $this->id_stock;
}


// *************************************************************************************************************
// FONCTIONS LIEES A LA MODIFICATION D'UN DOCUMENT
// *************************************************************************************************************
public function maj_contact ($ref_contact) {
	global $bdd;

	parent::maj_contact ($ref_contact);

	// *************************************************
	// MAJ de la base
	$query = "UPDATE doc_cdc 
						SET ref_adr_livraison = ".ref_or_null($this->ref_adr_livraison).", 
								adresse_livraison = '".addslashes($this->adresse_livraison)."', 
								code_postal_livraison = '".($this->code_postal_livraison)."', 
								ville_livraison = '".addslashes($this->ville_livraison)."', 
								id_pays_livraison = ".num_or_null($this->id_pays_livraison)."
						WHERE ref_doc = '".$this->ref_doc."' ";
	$bdd->exec ($query);

	return true;
}



// Met à jour la ref_doc_externe
public function maj_ref_doc_externe ($ref_doc_externe) {
	global $bdd;	

	$this->ref_doc_externe = $ref_doc_externe;

	// *************************************************
	// MAJ de la base
	$query = "UPDATE doc_cdc 
						SET ref_doc_externe = '".addslashes($this->ref_doc_externe)."'
						WHERE ref_doc = '".$this->ref_doc."' ";
	$bdd->exec ($query);
	
	return true;
}

// Met à jour l' id_magasin pour ce bon de commande
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
	$query = "UPDATE doc_cdc 
						SET id_magasin = '".$this->id_magasin."'
						WHERE ref_doc = '".$this->ref_doc."' ";
	$bdd->exec ($query);

	// *************************************************
	// Retour des informations
	$GLOBALS['_INFOS']['id_magasin'] = $this->id_magasin;

	return true;
}

// Met à jour la date de livraison demandée
public function maj_date_livraison ($new_date_livraison) {
	global $bdd;
	
	$this->date_livraison = $new_date_livraison;

	$query = "UPDATE doc_cdc SET date_livraison = '".addslashes($this->date_livraison)."'
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

	$query = "UPDATE doc_cdc SET id_livraison_mode = ".num_or_null($this->id_livraison_mode)."
						WHERE ref_doc = '".$this->ref_doc."' ";
	$bdd->exec ($query);
	
	//calcul et insertion pour ce document des frais de port (calcul effectué depuis la class livraison mode)
	$livraison_mode->calcul_frais_livraison_doc ($this);
	
	return true;
}


// Liste des documents pouvant être fusionner
public function check_allow_fusion ($second_document) {
	//verifcation que l'état des document permet la fusion
	if (($this->id_etat_doc != "6" && $this->id_etat_doc != "9") && ($second_document->getId_etat_doc () != "6" && $second_document->getId_etat_doc () != "9")) {
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
						WHERE (d.id_etat_doc = '6' ||  d.id_etat_doc = '9' ) && d.ref_contact = '".$this->ref_contact."' && d.ref_doc != '".$this->ref_doc."'
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
	$query['select']			= ", dl_cdc.qte_livree";
	$query['left_join'] 	= " LEFT JOIN doc_lines_cdc dl_cdc ON dl_cdc.ref_doc_line = dl.ref_doc_line";
	return $query;
}


// Mise à jour de l'information "qte_livree" d'une ligne de document
static function maj_line_infos_supp ($ref_doc_line, $donnees, $maj_donnees=NULL) {
	$table = "doc_lines_cdc";
	$maj_donnees = "qte_livree = ".$donnees['qte_livree']." ";

	parent::maj_line_infos_supp ($ref_doc_line, $table, $maj_donnees);

	return true;
}


// Vérifie si la commande est traitée
function check_if_traitee () {
	global $bdd;

	$this->charger_contenu ();

	$traitee = 1;
	foreach ($this->contenu as $line) {
		if (isset($line->type_of_line) && $line->type_of_line != "article") { continue; }
		if ($line->qte <= $line->qte_livree) { continue; }
		$traitee = 0;
		break;
	}

	if ($traitee) {
		$this->maj_etat_doc(10);
	}
	elseif ($this->id_etat_doc == 10 && !$traitee) {
		$this->maj_etat_doc(9);
	}
}


// *************************************************************************************************************
// FONCTIONS LIEES A LA MODIFICATION DE L'ETAT D'UN DOCUMENT
// *************************************************************************************************************

// Action après de changer l'état du document
protected function action_after_maj_etat ($old_etat_doc) {
	global $bdd;

	$return = parent::action_after_maj_etat($old_etat_doc);
		
	switch ($old_etat_doc) {
		case 6: case 7: case 8: 
			if ($this->id_etat_doc == 9 || $this->id_etat_doc == 10) {
				if (!$this->contenu_materiel_loaded) { $this->charger_contenu_materiel (); }
				foreach ($this->contenu_materiel as $doc_line) {
					edi_event(116,$doc_line->ref_article); 
				}
			}
		break;
	}
	
	switch ($old_etat_doc) {
		case 6: case 8: case 9: case 10: 
			if ($this->id_etat_doc == 7) {
				if (!$this->contenu_materiel_loaded) { $this->charger_contenu_materiel (); }
				foreach ($this->contenu_materiel as $doc_line) {
					edi_event(116,$doc_line->ref_article);
				}
			}
		break;
	}
	edi_event(126,$this->ref_doc,$this->id_etat_doc);

	return $return;
}

// *************************************************************************************************************
// FONCTIONS DIVERSES 
// *************************************************************************************************************

// PROFILS DE CONTACT NECESSAIRE POUR UTILISER CE TYPE DE DOCUMENT
function check_profils () {
	return $this->check_profil_client ();
}



// *************************************************************************************************************
// FONCTIONS SPECIFIQUES AU TYPE DE DOC 
// *************************************************************************************************************

// Génère un BL Client à partir de cette commande.
public function generer_bl_client ($lines = false) {
	$GLOBALS['_OPTIONS']['CREATE_DOC']['ref_adr_contact'] = $this->ref_adr_livraison;
	$GLOBALS['_OPTIONS']['CREATE_DOC']['adresse_contact'] = $this->adresse_livraison;
	$GLOBALS['_OPTIONS']['CREATE_DOC']['code_postal_contact'] = $this->code_postal_livraison;
	$GLOBALS['_OPTIONS']['CREATE_DOC']['ville_contact'] = $this->ville_livraison;
	$GLOBALS['_OPTIONS']['CREATE_DOC']['id_pays_contact'] = $this->id_pays_livraison;
	$GLOBALS['_OPTIONS']['CREATE_DOC']['code_affaire'] = $this->code_affaire;
	
	if (!isset($GLOBALS['_OPTIONS']['CREATE_DOC']['ref_adr_contact'])) {$GLOBALS['_OPTIONS']['CREATE_DOC']['ref_adr_contact'] = "";}
		
	if (is_array($lines)) {
		$GLOBALS['_OPTIONS']['CREATE_DOC']['doc_lines'] = $lines;
	}
	$GLOBALS['_OPTIONS']['CREATE_DOC']['info_line_cdc'] = 1;
	
	$GLOBALS['_OPTIONS']['CREATE_DOC']['follow_reglement'] = 1;
	$GLOBALS['_OPTIONS']['CREATE_DOC']['follow_commerciaux'] = 1;

	return $this->copie_doc (3);
}

// Génère un FA Client à partir de cette commande.
public function generer_fa_client ($lines = false) {
	$GLOBALS['_OPTIONS']['CREATE_DOC']['ref_adr_contact'] = $this->ref_adr_livraison;
	$GLOBALS['_OPTIONS']['CREATE_DOC']['adresse_contact'] = $this->adresse_livraison;
	$GLOBALS['_OPTIONS']['CREATE_DOC']['code_postal_contact'] = $this->code_postal_livraison;
	$GLOBALS['_OPTIONS']['CREATE_DOC']['ville_contact'] = $this->ville_livraison;
	$GLOBALS['_OPTIONS']['CREATE_DOC']['id_pays_contact'] = $this->id_pays_livraison;
	$GLOBALS['_OPTIONS']['CREATE_DOC']['code_affaire'] = $this->code_affaire;
	
	if (!isset($GLOBALS['_OPTIONS']['CREATE_DOC']['ref_adr_contact'])) {$GLOBALS['_OPTIONS']['CREATE_DOC']['ref_adr_contact'] = "";}
		
	if (is_array($lines)) {
		$GLOBALS['_OPTIONS']['CREATE_DOC']['doc_lines'] = $lines;
	}
	
	$GLOBALS['_OPTIONS']['CREATE_DOC']['follow_reglement'] = 1;
	$GLOBALS['_OPTIONS']['CREATE_DOC']['follow_commerciaux'] = 1;

	return $this->copie_doc (4);
}

// Renouvelle une commande à partir de celle-ci.
public function generer_commande_client ($lines = false) {
	// Possible uniquement si la commande est annulée ou traitée
	if ($this->id_etat_doc != 7 && $this->id_etat_doc != 10) { return false; }

	$GLOBALS['_OPTIONS']['CREATE_DOC']['ref_adr_contact'] = $this->ref_adr_contact;
	$GLOBALS['_OPTIONS']['CREATE_DOC']['adresse_contact'] = $this->adresse_contact;
	$GLOBALS['_OPTIONS']['CREATE_DOC']['code_postal_contact'] = $this->code_postal_contact;
	$GLOBALS['_OPTIONS']['CREATE_DOC']['ville_contact'] = $this->ville_contact;
	$GLOBALS['_OPTIONS']['CREATE_DOC']['id_pays_contact'] = $this->id_pays_contact;
	$GLOBALS['_OPTIONS']['CREATE_DOC']['code_affaire'] = $this->code_affaire;
	
	$GLOBALS['_OPTIONS']['CREATE_DOC']['ref_adr_livraison'] = $this->ref_adr_livraison;
	$GLOBALS['_OPTIONS']['CREATE_DOC']['adresse_livraison'] = $this->adresse_livraison;
	$GLOBALS['_OPTIONS']['CREATE_DOC']['code_postal_livraison'] = $this->code_postal_livraison;
	$GLOBALS['_OPTIONS']['CREATE_DOC']['ville_livraison'] = $this->ville_livraison;
	$GLOBALS['_OPTIONS']['CREATE_DOC']['id_pays_livraison'] = $this->id_pays_livraison;

	if (!isset($GLOBALS['_OPTIONS']['CREATE_DOC']['ref_adr_livraison'])) {$GLOBALS['_OPTIONS']['CREATE_DOC']['ref_adr_livraison'] = "";}
	
	if (is_array($lines)) {
		$GLOBALS['_OPTIONS']['CREATE_DOC']['doc_lines'] = $lines;
	}

	return $this->copie_doc (2);
}



// *************************************************************************************************************
// FONCTIONS DE RECOPIE D'UN DOCUMENT
// *************************************************************************************************************

// Lors de la copie vers un Bon de Livraison, la Quantité à livrer est ajustée à ce qu'il manque
function action_before_copie_line_to_doc ($new_doc, $line) {
	if ($new_doc->getID_TYPE_DOC() != 3) { return true; }
	if ($line->type_of_line != "article") { return true; }

	$line->qte -= $line->qte_livree;

	if (!$line->qte) { return false; }

	return true;
}


// Liaison entre les lignes des documents de la CDC et du BLC
function action_after_copie_line_to_doc ($new_doc, $line) {
	global $bdd;

	//en cas de fusion on met à jour les blc lié et les qté livrée
  if (isset($GLOBALS['_OPTIONS']['FUSION'])) {
		$query = "UPDATE doc_lines_blc SET ref_doc_line_cdc = '".$line->ref_doc_line."'
							WHERE  ref_doc_line_cdc = '".$line->old_ref_doc_line."' ";
		$bdd->exec ($query);
		$query = "UPDATE doc_lines_cdc SET ref_doc_line = '".$line->ref_doc_line."'
							WHERE  ref_doc_line = '".$line->old_ref_doc_line."' ";
		$bdd->exec ($query);
		
		 return true; 
	}
	
	if ($new_doc->getID_TYPE_DOC() != 3) { return true; }
	
	$query = "INSERT INTO doc_lines_blc (ref_doc_line, ref_doc_line_cdc)
						VALUES ('".$line->ref_doc_line."', '".$line->old_ref_doc_line."') ";
	$bdd->exec ($query);

	return true;
}


protected function create_info_copie_line_texte ($doc_source) { 
	return "Votre référence: ".$this->ref_doc_externe; 
}


public function create_info_copie_line_pac ($doc_source) {
	$infos['type_of_line'] = "information";
	$infos['titre'] = "Commande Internet";
	$infos['texte'] = "";
	$this->add_line ($infos);
}
// *************************************************************************************************************
// FONCTIONS LIEES A L'EDITION D'UN DOCUMENT 
// *************************************************************************************************************




// *************************************************************************************************************
// FONCTIONS DE LIAISON ENTRE DOCUMENTS 
// *************************************************************************************************************
// Chargement des documents à lier : Devis(1) Accepté(4), non lié à une commande (2)
public function charger_liaisons_possibles () {
	global $bdd;

	$this->liaisons_possibles = array();
	if ($this->id_etat_doc == 7 || $this->id_etat_doc == 10) {$this->liaisons_possibles_loaded = true; return true;}
	
	$query = "SELECT d.ref_doc, d.id_type_doc, dt.lib_type_doc, d.id_etat_doc, de.lib_etat_doc,
									 d.date_creation_doc date_creation
						FROM documents d
							LEFT JOIN documents_types dt ON d.id_type_doc = dt.id_type_doc 
							LEFT JOIN documents_etats de ON d.id_etat_doc = de.id_etat_doc 
							LEFT JOIN documents_liaisons dl ON d.ref_doc = dl.ref_doc_source && dl.active = 1
							LEFT JOIN documents d2 ON d2.ref_doc = dl.ref_doc_destination && d2.id_type_doc = 2
						WHERE d.ref_contact = ".ref_or_null($this->ref_contact)." && 
									(d.id_type_doc = 1 && d.id_etat_doc = 4) && d2.ref_doc IS NULL  
						ORDER BY date_creation ";
	$resultat = $bdd->query($query);
	while ($tmp = $resultat->fetchObject()) { $this->liaisons_possibles[] = $tmp; }

	$this->liaisons_possibles_loaded = true;

	return true;
}


// Action en cas de rupture d'une liaison
protected function action_before_break_liaison ($ref_doc) {
	global $bdd;

	// *************************************************
	// Actions spéciales uniquement en cas de rupture d'une liaison avec un BLC
	$query = "SELECT id_type_doc, id_etat_doc FROM documents WHERE ref_doc = '".$this->ref_doc."'";
	$resultat = $bdd->query ($query);
	if (!$doc = $resultat->fetchObject()) { return false; }

	if ($doc->id_type_doc != 3) { return false; }

	// *************************************************
	// Diminution des quantités livrées le cas échéant
	if ($doc->id_etat_doc == 13 || $doc->id_etat_doc == 14 || $doc->id_etat_doc == 15) {
		$query = "UPDATE doc_lines_cdc dl_cdc, doc_lines_blc dl_blc, docs_lines dl1, docs_lines dl2
							SET dl_cdc.qte_livree -= dl2.qte 
							WHERE dl1.ref_doc = '".$this->ref_doc."' && dl2.ref_doc = '".$ref_doc."' &&
										dl_blc.ref_doc_line_cdc = dl1.ref_doc_line && dl_blc.ref_doc_line = dl2.ref_doc_line ";
		$bdd->exec ($query);
	}

	// *************************************************
	// Suppression de la liaison ligne à ligne
	$query = "UPDATE doc_lines_blc dl_blc, docs_lines dl1, docs_lines dl2
						SET dl_blc.ref_doc_line_cdc = NULL 
						WHERE dl1.ref_doc = '".$this->ref_doc."' && dl2.ref_doc = '".$ref_doc."' &&
									dl_blc.ref_doc_line_cdc = dl1.ref_doc_line && dl_blc.ref_doc_line = dl2.ref_doc_line ";
	$bdd->exec ($query);

	return true;
}


// *************************************************************************************************************
// FONCTIONS DE GESTION DES REGLEMENTS
// *************************************************************************************************************

protected function need_infos_facturation () {
	// Si la commande est annulée ou traitée, les informations de facturation ne sont pas nécessaires.
	if ($this->id_etat_doc == $this->ID_ETAT_ANNULE || $this->id_etat_doc == 10) { return false; }
	return true;
}


protected function reglement_partiel () {
	// Une commande en saisie devient "en cours" lorsqu'un règlement est enregistré.
	if ($this->id_etat_doc == 6) {
		$this->maj_etat_doc(9);
	}
	$GLOBALS['INFOS']['change_etat'] = 1;
}



// *************************************************************************************************************
// FONCTIONS DE RESTITUTION DES DONNEES 
// *************************************************************************************************************

function getRef_doc_externe () {
	return $this->ref_doc_externe;
}

function getDate_livraison () {
	return $this->date_livraison;
}

function getRef_adr_livraison () {
	return $this->ref_adr_livraison;
}

function getAdresse_livraison () {
	return $this->define_text_adresse ($this->adresse_livraison, $this->code_postal_livraison, $this->ville_livraison, $this->id_pays_livraison, $this->pays_livraison);
}
 
function getText_adresse_livraison () {
	return $this->adresse_livraison;
}
 
function getCode_postal_livraison () {
	return $this->code_postal_livraison;
}
 
function getVille_livraison () {
	return $this->ville_livraison;
}
 
function getId_pays_livraison () {
	return $this->id_pays_livraison;
}
 
function getPays_livraison () {
	return $this->pays_livraison;
}

function getId_stock () {
	return $this->id_stock;
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
