<?php
// *************************************************************************************************************
// CLASSE REGISSANT LES INFORMATIONS SUR UN DOCUMENT DE TYPE DEVIS CLIENT
// *************************************************************************************************************

final class doc_dev extends document {

	protected $ref_doc_externe;
	protected $id_magasin;
	protected $date_echeance;
	protected $date_livraison;
	protected $ref_adr_livraison;
	protected $adresse_livraison;
	protected $code_postal_livraison;
	protected $ville_livraison;
	protected $id_pays_livraison;
	protected $pays_livraison;

	protected $id_livraison_mode;
	
	protected $ID_TYPE_DOC 					= 1;
	protected $LIB_TYPE_DOC 				= "Devis Client";
	protected $CODE_DOC 						= "DEV";
	protected $DOC_ID_REFERENCE_TAG = 11;

	protected $DEFAUT_ID_ETAT 	= 1;
	protected $DEFAUT_LIB_ETAT 	= "En saisie";
	protected $GESTION_SN	 		= 0;
	protected $CONTENT_FROM		= "CATALOGUE";
	protected $PU_FROM				= "PV";
	protected $ID_ETAT_ANNULE	= 2;



public function open_doc ($select = "", $left_join = "") {
	global $bdd;

	$this->check_profils ();

	$select = ", dd.id_magasin, dd.date_echeance, dd.date_livraison, dd.ref_adr_livraison, dd.adresse_livraison, dd.code_postal_livraison, dd.ville_livraison, dd.ref_doc_externe, dd.id_pays_livraison, dd.id_livraison_mode, pl.pays  ";
	$left_join = " LEFT JOIN doc_dev dd ON dd.ref_doc = d.ref_doc 
								 LEFT JOIN pays pl ON pl.id_pays = dd.id_pays_livraison ";

	if (!$doc = parent::open_doc($select, $left_join)) { return false; }

	$this->ref_doc_externe	 	= $doc->ref_doc_externe;
	$this->id_magasin 				= $doc->id_magasin;
	$this->date_echeance			= $doc->date_echeance;
	$this->date_livraison 		= $doc->date_livraison;
	$this->ref_adr_livraison 	= $doc->ref_adr_livraison;
	$this->adresse_livraison 	= $doc->adresse_livraison;
	$this->code_postal_livraison 	= $doc->code_postal_livraison;
	$this->ville_livraison 	= $doc->ville_livraison;
	$this->id_pays_livraison 	= $doc->id_pays_livraison;
	$this->id_livraison_mode 	= $doc->id_livraison_mode;
	$this->pays_livraison 	= $doc->pays;

	return true;
}


// *************************************************************************************************************
// FONCTIONS LIEES A LA CREATION D'UN DOCUMENT
// *************************************************************************************************************

public function create_doc () { 
	global $bdd;
	global $DEVIS_CLIENT_LT;
	global $DEFAUT_APP_TARIFS_CLIENT;
	global $DEFAUT_ID_MAGASIN;

	$this->app_tarifs = $DEFAUT_APP_TARIFS_CLIENT;
	
	$this->ref_adr_livraison = "NULL";
	$this->adresse_livraison = "";
	$this->code_postal_livraison 	= "";
	$this->ville_livraison 	= "";
	$this->id_pays_livraison 	= "";
	$this->pays_livraison 	= "";
	
	if ($_SESSION['magasin']->getMode_vente() == "VAC") {
		$this->ref_adr_livraison = "NULL";
		$this->adresse_livraison = $_SESSION['magasin']->getLib_magasin ();
	}

	if (!parent::create_doc()) { return false; }

	$this->id_magasin 			= $_SESSION['magasin']->getId_magasin (); //$DEFAUT_ID_MAGASIN;
	
	if (isset($GLOBALS['_OPTIONS']['CREATE_DOC']['ref_doc_externe'])) {
		$this->ref_doc_externe = $GLOBALS['_OPTIONS']['CREATE_DOC']['ref_doc_externe'];
	}
	
	if (isset($GLOBALS['_OPTIONS']['CREATE_DOC']['code_affaire'])) {
		$this->code_affaire = $GLOBALS['_OPTIONS']['CREATE_DOC']['code_affaire'];
	}	
	
	if (isset($GLOBALS['_OPTIONS']['CREATE_DOC']['date_echeance'])) {
		$this->date_echeance = $GLOBALS['_OPTIONS']['CREATE_DOC']['date_echeance'];
	}
	else {
		$this->date_echeance 	= date ("Y-m-d", time()+$DEVIS_CLIENT_LT);
	}

	$query = "INSERT INTO doc_dev (ref_doc, ref_doc_externe, id_magasin, date_echeance, ref_adr_livraison, adresse_livraison, code_postal_livraison, ville_livraison, id_pays_livraison)
						VALUES ('".$this->ref_doc."', '".addslashes($this->ref_doc_externe)."', '".$this->id_magasin."', '".$this->date_echeance."', 
										".ref_or_null($this->ref_adr_livraison).", '".addslashes($this->adresse_livraison)."', '".($this->code_postal_livraison)."', '".addslashes($this->ville_livraison)."', ".num_or_null($this->id_pays_livraison).") ";
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
		$profil_client->maj_type_client ("prospect");
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
	return parent::define_adresse_contact_et_livraison ();
}




// *************************************************************************************************************
// FONCTIONS LIEES A LA MODIFICATION D'UN DOCUMENT
// *************************************************************************************************************
// Met à jour l' id_magasin pour ce devis
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
	$query = "UPDATE doc_dev 
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
	$query = "UPDATE doc_dev 
						SET ref_doc_externe = '".addslashes($this->ref_doc_externe)."'
						WHERE ref_doc = '".$this->ref_doc."' ";
	$bdd->exec ($query);
	
	return true;
}

public function maj_contact ($ref_contact) {
	global $bdd;

	parent::maj_contact ($ref_contact);


	// *************************************************
	// MAJ de la base
	$query = "UPDATE doc_dev 
						SET ref_adr_livraison = ".ref_or_null($this->ref_adr_livraison).", 
								adresse_livraison = '".addslashes($this->adresse_livraison)."', 
								code_postal_livraison = '".($this->code_postal_livraison)."', 
								ville_livraison = '".addslashes($this->ville_livraison)."', 
								id_pays_livraison = ".num_or_null($this->id_pays_livraison)."
						WHERE ref_doc = '".$this->ref_doc."' ";
	$bdd->exec ($query);
	
	return true;
}



// Met à jour la date d'échéance du devis
public function maj_date_echeance ($new_date_echeance) {
	global $bdd;
	
	$this->date_echeance = $new_date_echeance;
	
	$query = "UPDATE doc_dev SET date_echeance = '".addslashes($this->date_echeance)."'
						WHERE ref_doc = '".$this->ref_doc."' ";
	$bdd->exec ($query);
	
	return true;
}


// Met à jour la date de livraison demandée
public function maj_date_livraison ($new_date_livraison) {
	global $bdd;
	
	$this->date_livraison = $new_date_livraison;

	$query = "UPDATE doc_dev SET date_livraison = '".addslashes($this->date_livraison)."'
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

	$query = "UPDATE doc_dev SET id_livraison_mode = ".num_or_null($this->id_livraison_mode)."
						WHERE ref_doc = '".$this->ref_doc."' ";
	$bdd->exec ($query);
	
	//calcul et insertion pour ce document des frais de port (calcul effectué depuis la class livraison mode)
	$livraison_mode->calcul_frais_livraison_doc ($this);
	
	return true;
}



// *************************************************************************************************************
// FONCTIONS DE GESTION DU CONTENU
// *************************************************************************************************************



// *************************************************************************************************************
// FONCTIONS LIEES A LA MODIFICATION DE L'ETAT D'UN DOCUMENT
// *************************************************************************************************************

// Action après de changer l'état du document
protected function action_after_maj_etat ($old_etat_doc) {
	global $DEVIS_CLIENT_AUTO_GENERE;
	// Si passage a un état Devis Accepté, création du document suivant du cycle si défini
	if ($this->id_etat_doc == 4) { 
		$case_generer = $DEVIS_CLIENT_AUTO_GENERE;
		if (isset($GLOBALS['_OPTIONS']['GENERE_DOC'])) {
			$case_generer = $GLOBALS['_OPTIONS']['GENERE_DOC'];
		}
		switch ($case_generer) {
			case "COT":
			$this->generer_cotation_client();
			break;
			case "CDC":
			$this->generer_commande_client();
			break;
			case "BLC":
			$this->generer_livraison_client();
			break;
			case "FAC":
			$this->generer_facture_client();
			break;
			case "":
			break;
		}
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


// *************************************************************************************************************
// FONCTIONS SPECIFIQUES AU TYPE DE DOC 
// *************************************************************************************************************

// Génère une cotation client à partir de ce devis.
public function generer_cotation_client ($lines = false) {
	$GLOBALS['_OPTIONS']['CREATE_DOC']['ref_adr_livraison'] = $this->ref_adr_livraison;
	$GLOBALS['_OPTIONS']['CREATE_DOC']['adresse_livraison'] = $this->adresse_livraison;
	$GLOBALS['_OPTIONS']['CREATE_DOC']['code_postal_livraison'] = $this->code_postal_livraison;
	$GLOBALS['_OPTIONS']['CREATE_DOC']['ville_livraison'] = $this->ville_livraison;
	$GLOBALS['_OPTIONS']['CREATE_DOC']['id_pays_livraison'] = $this->id_pays_livraison;
	$GLOBALS['_OPTIONS']['CREATE_DOC']['code_affaire'] = $this->code_affaire;
	$GLOBALS['_OPTIONS']['CREATE_DOC']['follow_commerciaux'] = 1;

	if (is_array($lines)) {
		$GLOBALS['_OPTIONS']['CREATE_DOC']['doc_lines'] = $lines;
	}

	return $this->copie_doc (16);
}
// Génère une commande client à partir de ce devis.
public function generer_commande_client ($lines = false) {
	$GLOBALS['_OPTIONS']['CREATE_DOC']['ref_adr_livraison'] = $this->ref_adr_livraison;
	$GLOBALS['_OPTIONS']['CREATE_DOC']['adresse_livraison'] = $this->adresse_livraison;
	$GLOBALS['_OPTIONS']['CREATE_DOC']['code_postal_livraison'] = $this->code_postal_livraison;
	$GLOBALS['_OPTIONS']['CREATE_DOC']['ville_livraison'] = $this->ville_livraison;
	$GLOBALS['_OPTIONS']['CREATE_DOC']['id_pays_livraison'] = $this->id_pays_livraison;
	$GLOBALS['_OPTIONS']['CREATE_DOC']['code_affaire'] = $this->code_affaire;
	$GLOBALS['_OPTIONS']['CREATE_DOC']['date_livraison'] = $this->date_livraison;
	$GLOBALS['_OPTIONS']['CREATE_DOC']['follow_commerciaux'] = 1;

	if (is_array($lines)) {
		$GLOBALS['_OPTIONS']['CREATE_DOC']['doc_lines'] = $lines;
	}

	return $this->copie_doc (2);
}
// Génère une Bon de livraison client à partir de ce devis.
public function generer_livraison_client ($lines = false) {
	$GLOBALS['_OPTIONS']['CREATE_DOC']['ref_adr_contact'] = $this->ref_adr_livraison;
	$GLOBALS['_OPTIONS']['CREATE_DOC']['adresse_contact'] = $this->adresse_livraison;
	$GLOBALS['_OPTIONS']['CREATE_DOC']['code_postal_contact'] = $this->code_postal_livraison;
	$GLOBALS['_OPTIONS']['CREATE_DOC']['ville_contact'] = $this->ville_livraison;
	$GLOBALS['_OPTIONS']['CREATE_DOC']['id_pays_contact'] = $this->id_pays_livraison;
	$GLOBALS['_OPTIONS']['CREATE_DOC']['code_affaire'] = $this->code_affaire;
	$GLOBALS['_OPTIONS']['CREATE_DOC']['date_livraison'] = $this->date_livraison;
	$GLOBALS['_OPTIONS']['CREATE_DOC']['follow_commerciaux'] = 1;

	if (is_array($lines)) {
		$GLOBALS['_OPTIONS']['CREATE_DOC']['doc_lines'] = $lines;
	}

	return $this->copie_doc (3);
}
// Génère une Facture client à partir de ce devis.
public function generer_facture_client ($lines = false) {
	$GLOBALS['_OPTIONS']['CREATE_DOC']['ref_adr_contact'] = $this->ref_adr_contact;
	$GLOBALS['_OPTIONS']['CREATE_DOC']['adresse_contact'] = $this->adresse_contact;
	$GLOBALS['_OPTIONS']['CREATE_DOC']['code_postal_contact'] = $this->code_postal_contact;
	$GLOBALS['_OPTIONS']['CREATE_DOC']['ville_contact'] = $this->ville_contact;
	$GLOBALS['_OPTIONS']['CREATE_DOC']['id_pays_contact'] = $this->id_pays_contact;
	$GLOBALS['_OPTIONS']['CREATE_DOC']['code_affaire'] = $this->code_affaire;
	$GLOBALS['_OPTIONS']['CREATE_DOC']['follow_commerciaux'] = 1;

	if (is_array($lines)) {
		$GLOBALS['_OPTIONS']['CREATE_DOC']['doc_lines'] = $lines;
	}

	return $this->copie_doc (4);
}



// Génère un autre devis client à partir de celui-ci.
public function generer_devis_client ($lines = false) {
	$GLOBALS['_OPTIONS']['CREATE_DOC']['date_echeance'] 	= $this->date_echeance;
	$GLOBALS['_OPTIONS']['CREATE_DOC']['date_livraison'] 	= $this->date_livraison;

	$GLOBALS['_OPTIONS']['CREATE_DOC']['ref_adr_livraison'] = $this->ref_adr_livraison;
	$GLOBALS['_OPTIONS']['CREATE_DOC']['adresse_livraison'] = $this->adresse_livraison;
	$GLOBALS['_OPTIONS']['CREATE_DOC']['code_postal_livraison'] = $this->code_postal_livraison;
	$GLOBALS['_OPTIONS']['CREATE_DOC']['ville_livraison'] = $this->ville_livraison;
	$GLOBALS['_OPTIONS']['CREATE_DOC']['id_pays_livraison'] = $this->id_pays_livraison;
	$GLOBALS['_OPTIONS']['CREATE_DOC']['code_affaire'] = $this->code_affaire;

	if (is_array($lines)) {
		$GLOBALS['_OPTIONS']['CREATE_DOC']['doc_lines'] = $lines;
	}

	return $this->copie_doc (1);
}



// *************************************************************************************************************
// FONCTIONS DE RECOPIE D'UN DOCUMENT
// *************************************************************************************************************

protected function create_info_copie_line_texte ($doc_source) { 
	return "Votre référence: ".$this->ref_doc_externe; 
}


// *************************************************************************************************************
// FONCTIONS LIEES A L'EDITION D'UN DOCUMENT 
// *************************************************************************************************************
// Edition
protected function edit_doc ($id_edition_mode, $infos) {
	global $bdd;

	// Si édition d'un devis en saisie, le devis est pret!
	if ($this->id_etat_doc == 1) {
		$this->maj_etat_doc(3);
	}
	
	return parent::edit_doc($id_edition_mode, $infos);
}



// *************************************************************************************************************
// FONCTIONS LIEES A LA RECHERCHE D'ARTICLE POUR INSERTION DANS LE DOCUMENT 
// *************************************************************************************************************
public function auto_search_articles ($id_type_recherche) {
	$query_more['query_join']		= "";
	$query_more['query_where']	= " && a.date_creation > '".date("Y-m-d H:i:s", time()-7*24*3600)."'";
	
	return $query_more;
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
 
function getDate_livraison () {
	return $this->date_livraison;
}

function getId_magasin () {
	return $this->id_magasin;
}

function getId_livraison_mode () {
	return $this->id_livraison_mode;
}

}

?>