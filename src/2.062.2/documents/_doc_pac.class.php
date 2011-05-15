<?php
// *************************************************************************************************************
// CLASSE REGISSANT LES INFORMATIONS SUR UN DOCUMENT DE TYPE DEVIS CLIENT
// *************************************************************************************************************


final class doc_pac extends document {

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

	protected $ID_TYPE_DOC 					= 10;
	protected $LIB_TYPE_DOC 				= "Panier Client";
	protected $CODE_DOC 						= "PAC";
	protected $DOC_ID_REFERENCE_TAG = 26;

	protected $DEFAUT_ID_ETAT 	= 41;
	protected $DEFAUT_LIB_ETAT 	= "En saisie";
	protected $GESTION_SN	 		= 0;
	protected $CONTENT_FROM		= "CATALOGUE";
	protected $PU_FROM				= "PV";
	protected $ID_ETAT_ANNULE	= 43;



public function open_doc ($select = "", $left_join = "") {
	global $bdd;

	$this->check_profils ();

	$select = ", dp.id_magasin, dp.ref_adr_livraison, dp.adresse_livraison, dp.code_postal_livraison, dp.ville_livraison, dp.id_pays_livraison, dp.id_livraison_mode, pl.pays ";
	$left_join = " LEFT JOIN doc_pac dp ON dp.ref_doc = d.ref_doc 
								 LEFT JOIN pays pl ON pl.id_pays = dp.id_pays_livraison
								";

	if (!$doc = parent::open_doc($select, $left_join)) { return false; }

	$this->id_magasin 				= $doc->id_magasin;
	$this->ref_adr_livraison 	= $doc->ref_adr_livraison;
	$this->adresse_livraison 	= $doc->adresse_livraison;
	$this->code_postal_livraison 	= $doc->code_postal_livraison;
	$this->ville_livraison 		= $doc->ville_livraison;
	$this->id_pays_livraison 	= $doc->id_pays_livraison;
	$this->pays_livraison 		= $doc->pays;
	$this->id_livraison_mode 	= $doc->id_livraison_mode;

	return true;
}



// *************************************************************************************************************
// FONCTIONS LIEES A LA CREATION D'UN DOCUMENT
// *************************************************************************************************************

public function create_doc () { 
	global $bdd;
	global $PANIER_CLIENT_LT;
	global $DEFAUT_APP_TARIFS_CLIENT;
	global $DEFAUT_ID_MAGASIN;
	global $ID_MAGASIN;

	$this->app_tarifs = $DEFAUT_APP_TARIFS_CLIENT;
	$this->ref_adr_livraison = "NULL";
	$this->adresse_livraison = "";
	$this->code_postal_livraison 	= "";
	$this->ville_livraison 	= "";
	$this->id_pays_livraison 	= "";
	$this->pays_livraison 	= "";
	
	$this->id_magasin 			= $_SESSION['magasin']->getId_magasin (); //$DEFAUT_ID_MAGASIN
	
	//on récupère le magasin défini par defaut pour l'interface
	
	if (isset($ID_MAGASIN)) {$this->id_magasin = $ID_MAGASIN;}
	
	
	if ($_SESSION['magasins'][$this->id_magasin]->getMode_vente() == "VAC") {
		$this->ref_adr_livraison = "NULL";
		$this->adresse_livraison = $_SESSION['magasins'][$this->id_magasin]->getLib_magasin ();
	}

	if (!parent::create_doc()) { return false; }

	$query = "INSERT INTO doc_pac (ref_doc, id_magasin,  ref_adr_livraison, adresse_livraison, code_postal_livraison, ville_livraison, id_pays_livraison)
						VALUES ('".$this->ref_doc."', '".$this->id_magasin."', 
										".ref_or_null($this->ref_adr_livraison).", '".addslashes($this->adresse_livraison)."', '".($this->code_postal_livraison)."', '".addslashes($this->ville_livraison)."', ".num_or_null($this->id_pays_livraison).") ";
	$bdd->exec ($query);

	return true;
}



// Charge les informations supplémentaire du contact
protected function load_infos_contact () {
	$this->load_infos_contact_client ();
	parent::load_infos_contact();
}


// Renvoie l'adresse a utiliser dans le document pour un contact donné
function define_adresse_contact () {
	return parent::define_adresse_contact_et_livraison ();
}




// *************************************************************************************************************
// FONCTIONS LIEES A LA MODIFICATION D'UN DOCUMENT
// *************************************************************************************************************
// Met à jour l' id_magasin pour ce panier
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
	$query = "UPDATE doc_pac 
						SET id_magasin = '".$this->id_magasin."'
						WHERE ref_doc = '".$this->ref_doc."' ";
	$bdd->exec ($query);

	// *************************************************
	// Retour des informations
	$GLOBALS['_INFOS']['id_magasin'] = $this->id_magasin;

	return true;
}


public function maj_contact ($ref_contact) {
	global $bdd;

	parent::maj_contact ($ref_contact);

	// *************************************************
	// MAJ de la base
	$query = "UPDATE doc_pac 
						SET ref_adr_livraison = ".ref_or_null($this->ref_adr_livraison).", 
								adresse_livraison = '".addslashes($this->adresse_livraison)."', 
								code_postal_livraison = '".($this->code_postal_livraison)."', 
								ville_livraison = '".addslashes($this->ville_livraison)."', 
								id_pays_livraison = ".num_or_null($this->id_pays_livraison)."
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

	$query = "UPDATE doc_pac SET id_livraison_mode = ".num_or_null($this->id_livraison_mode)."
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
	
	// Si passage a un état Panier Validé, création du bon de commande lié
	if ($this->id_etat_doc == 42) { 
		$this->generer_commande_client();
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

function empty_lines () {
	global $bdd;
	
	$query = "DELETE FROM docs_lines WHERE ref_doc = '".$this->ref_doc."' ";
	$bdd->exec ($query);

	return true;

}

// *************************************************************************************************************
// FONCTIONS SPECIFIQUES AU TYPE DE DOC 
// *************************************************************************************************************

// Génère une commande client à partir de ce panier.
public function generer_commande_client ($lines = false) {
	$GLOBALS['_OPTIONS']['CREATE_DOC']['ref_adr_livraison'] = $this->ref_adr_livraison;
	$GLOBALS['_OPTIONS']['CREATE_DOC']['adresse_livraison'] = $this->adresse_livraison;
	$GLOBALS['_OPTIONS']['CREATE_DOC']['code_postal_livraison'] = $this->code_postal_livraison;
	$GLOBALS['_OPTIONS']['CREATE_DOC']['ville_livraison'] = $this->ville_livraison;
	$GLOBALS['_OPTIONS']['CREATE_DOC']['id_pays_livraison'] = $this->id_pays_livraison;
	$GLOBALS['_OPTIONS']['CREATE_DOC']['description'] = $this->description;
	$GLOBALS['_OPTIONS']['CREATE_DOC']['info_line_pac'] = 1;
	//mise à jour de l'état de la commande à commande en cours
	$GLOBALS['_OPTIONS']['CREATE_DOC']['maj_etat_copie_doc'] = 8;
	
	if (is_array($lines)) {
		$GLOBALS['_OPTIONS']['CREATE_DOC']['doc_lines'] = $lines;
	}

	return $this->copie_doc (2);
}


// Génère un autre devis client à partir de ce panier.
public function generer_devis_client ($lines = false) {
	$GLOBALS['_OPTIONS']['CREATE_DOC']['ref_adr_livraison'] = $this->ref_adr_livraison;
	$GLOBALS['_OPTIONS']['CREATE_DOC']['adresse_livraison'] = $this->adresse_livraison;
	$GLOBALS['_OPTIONS']['CREATE_DOC']['code_postal_livraison'] = $this->code_postal_livraison;
	$GLOBALS['_OPTIONS']['CREATE_DOC']['ville_livraison'] = $this->ville_livraison;
	$GLOBALS['_OPTIONS']['CREATE_DOC']['id_pays_livraison'] = $this->id_pays_livraison;
	$GLOBALS['_OPTIONS']['CREATE_DOC']['description'] = $this->description;

	if (is_array($lines)) {
		$GLOBALS['_OPTIONS']['CREATE_DOC']['doc_lines'] = $lines;
	}

	return $this->copie_doc (1);
}



// *************************************************************************************************************
// FONCTIONS DE RECOPIE D'UN DOCUMENT
// *************************************************************************************************************



// *************************************************************************************************************
// FONCTIONS LIEES A L'EDITION D'UN DOCUMENT 
// *************************************************************************************************************
// Edition
protected function edit_doc ($id_edition_mode, $infos) {
	global $bdd;

	// Si édition d'un devis en saisie, le devis est pret!
	if ($this->id_etat_doc == 41) {
		$this->maj_etat_doc(42);
	}
	
	return parent::edit_doc($id_edition_mode, $infos);
}



// *************************************************************************************************************
// FONCTIONS LIEES A LA RECHERCHE D'ARTICLE POUR INSERTION DANS LE DOCUMENT 
// *************************************************************************************************************


// *************************************************************************************************************
// FONCTIONS DE RESTITUTION DES DONNEES 
// *************************************************************************************************************

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

function getId_magasin () {
	return $this->id_magasin;
}

function getId_livraison_mode () {
	return $this->id_livraison_mode;
}

}

?>