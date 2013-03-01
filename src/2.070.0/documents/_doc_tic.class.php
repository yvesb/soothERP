<?php
// *************************************************************************************************************
// CLASSE REGISSANT LES INFORMATIONS SUR UN DOCUMENT DE TYPE TICKET DE CAISSE
// *************************************************************************************************************


class doc_tic extends document {

	//@TODO renseigner $id_caisse
	protected $id_caisse = 1;
	
	//voir table `magasins`
	protected $id_magasin;
	
	//voir table `stocks`
	protected $id_stock;
	protected $lib_stock;
	protected $ref_adr_stock;

	//voir table `documents_types`
	protected $ID_TYPE_DOC 			= 15;
	protected $LIB_TYPE_DOC 		= "Ticket de caisse";
	protected $CODE_DOC 				= "TIC";
	
	//voir table `references_tags`
	protected $DOC_ID_REFERENCE_TAG = 31;

	//voir table `documents_etats`
	protected $DEFAUT_ID_ETAT 	= 59;
	protected $DEFAUT_LIB_ETAT 	= "En saisie";
	protected $ID_ETAT_ANNULE	= 60;
	
	//@TODO : $GESTION_SN = ???
	protected $GESTION_SN	 		= 1;
	protected $CONTENT_FROM		= "STOCK";
	protected $PU_FROM				= "PV";
	protected $ACCEPT_REGMT		= 1;
	
	protected $client_facturation;
	protected $client_encours;
	protected $a_facturer = false;

	//protected $doc_fusion_dispo;
	//protected $doc_fusion_dispo_loaded;


public function open_doc ($select = "", $left_join = "") {
	global $bdd;

	$this->check_profils ();

	$select = ", dtic.id_caisse, dtic.id_stock, s.lib_stock, s.ref_adr_stock, ac.facturation_periodique, ac.encours, dtic.id_magasin ";
	$left_join = " LEFT JOIN doc_tic dtic ON dtic.ref_doc = d.ref_doc 
								 LEFT JOIN stocks s ON dtic.id_stock = s.id_stock
								 LEFT JOIN annu_client ac ON ac.ref_contact = d.ref_contact";

	if (!$doc = parent::open_doc($select, $left_join)) { return false; }

	$this->id_caisse	 			= $doc->id_caisse;
	$this->id_stock 				= $doc->id_stock;
	$this->ref_adr_stock 		= $doc->ref_adr_stock;
	$this->lib_stock 				= $doc->lib_stock;
	$this->id_magasin 			= $doc->id_magasin;

	$this->client_facturation = "immediate";
	$this->client_encours = $doc->encours;

	
	if ($this->id_etat_doc != 59) //59 = en saisie
				{$this->quantite_locked = true;}
	else 	{$this->quantite_locked = false;}

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
	
	if (!parent::create_doc()) { return false; }

	$query = "INSERT INTO doc_tic (ref_doc, id_stock, id_magasin, id_caisse)
						VALUES ('".$this->ref_doc."', '".$this->id_stock."', '".$this->id_magasin."', '".$this->id_caisse."') ";
	$bdd->exec ($query);
	
	//$this->attribution_commercial ($this->commerciaux);

	
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

/*
// Met à jour l' id_magasin pour ce ticket de caisse
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
*/

/*
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
*/

/*
// Liste des documents pouvant être fusionner
public function check_allow_fusion ($second_document) {
	//verifcation que l'état des document permet la fusion
	if (($this->id_etat_doc != "11" && $this->id_etat_doc != "13") && ($second_document->getId_etat_doc () != "11" && $second_document->getId_etat_doc () != "13")) {
		return false;
	}
	return true;
}
*/

/*
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

*/

// *************************************************************************************************************
// FONCTIONS DE GESTION DU CONTENU
// *************************************************************************************************************
/*
protected function doc_line_infos_supp () {
	$query['select']			= ", dl_blc.ref_doc_line_cdc, sa.qte stock";
	$query['left_join'] 	= " LEFT JOIN doc_lines_blc dl_blc ON dl_blc.ref_doc_line = dl.ref_doc_line
														LEFT JOIN stocks_articles sa ON sa.ref_article = dl.ref_article && 
																			sa.id_stock = '".$this->id_stock."' ";
	return $query;
}
*/

/*
// Chargement des informations supplémentaires concernant les numéros de série 
protected function doc_line_sn_infos_supp () {
	$query['select']		= ", IF (ISNULL(sas.numero_serie), 0, 1) as sn_exist";
	$query['left_join'] = " LEFT JOIN stocks_articles_sn sas ON sas.numero_serie = dls.numero_serie";
	return $query;
}
*/


// *************************************************************************************************************
// FONCTIONS LIEES A LA MODIFICATION DE L'ETAT D'UN DOCUMENT
// *************************************************************************************************************

//(`id_etat_doc`,`id_type_doc`,`lib_etat_doc`,`ordre`,`is_open`) VALUES
//(59, 						15, 					'En saisie', 		1, 			1)
//(60, 						15,						'Annulé', 			2, 			0)
//(61, 						15,						'En Attente', 	3, 			0)
//(62, 						15, 					'Encaissé', 		4, 			0)

// Action avant de changer l'état du document
protected function action_before_maj_etat ($new_etat_doc) {
	return true;
}


// Action après de changer l'état du document
protected function action_after_maj_etat ($old_etat_doc) {
	if (!$this->liaisons_loaded) { $this->charger_liaisons () ; }
	foreach ($this->liaisons['dest'] as $dest) {
		//si le TIC est déjà lié avec une facture (et la liaison valide), alors on ne facture pas
		if ($dest->active ) { $GLOBALS['_OPTIONS']['CREATE_DOC']['not_generer_facture'] = 1;}
	}

	if (($this->id_etat_doc == 62)  && !isset($GLOBALS['_OPTIONS']['CREATE_DOC']['not_generer_facture'])) { //62 = encaissé
		$this->generer_bl_client();
	}

	if ($this->id_etat_doc != 59) //59 = en saisie
				{$this->quantite_locked = true;}
	else 	{$this->quantite_locked = false;}

	return true;
}



// Génère un BL Client à partir de cette commande.
public function generer_bl_client ($lines = false) {	//@TODO champs a renseigner
	$GLOBALS['_OPTIONS']['CREATE_DOC']['ref_adr_contact'] = $this->ref_adr_contact; //adresse de livraison
	$GLOBALS['_OPTIONS']['CREATE_DOC']['adresse_contact'] = $this->getAdresse_contact();
	$GLOBALS['_OPTIONS']['CREATE_DOC']['code_postal_contact'] = $this->getCode_postal_contact();
	$GLOBALS['_OPTIONS']['CREATE_DOC']['ville_contact'] =  $this->getVille_contact();
	$GLOBALS['_OPTIONS']['CREATE_DOC']['id_pays_contact'] = $this->getId_pays_contact();
	
	if (!isset($GLOBALS['_OPTIONS']['CREATE_DOC']['ref_adr_contact'])) {$GLOBALS['_OPTIONS']['CREATE_DOC']['ref_adr_contact'] = "";}
		
	if (is_array($lines)) {
		$GLOBALS['_OPTIONS']['CREATE_DOC']['doc_lines'] = $lines;
	}
	$GLOBALS['_OPTIONS']['CREATE_DOC']['info_line_cdc'] = 1;
	
	$GLOBALS['_OPTIONS']['CREATE_DOC']['follow_reglement'] = 1;
	$GLOBALS['_OPTIONS']['CREATE_DOC']['follow_commerciaux'] = 1;

	return $this->copie_doc (3);
}

// *************************************************************************************************************
// FONCTIONS DIVERSES 
// *************************************************************************************************************

// PROFILS DE CONTACT NECESSAIRE POUR UTILISER CE TYPE DE DOCUMENT
function check_profils () {
	return $this->check_profil_client ();
}

// *************************************************************************************************************
// FONCTIONS LIEES A L'EDITION D'UN DOCUMENT 
// *************************************************************************************************************

// *************************************************************************************************************
// FONCTIONS DE GESTION DES REGLEMENTS
// *************************************************************************************************************
//@TODO ???
protected function need_infos_facturation () {
	// Si le ticket a été encaissé, ou si il est annulée, les informations de facturation seront gérées dans la facture.
	if ($this->id_etat_doc == $this->ID_ETAT_ANNULE || $this->id_etat_doc == 62) { return false; }
	return true;
}

// *************************************************************************************************************
// FONCTIONS DE RESTITUTION DES DONNEES 
// *************************************************************************************************************
 
function getId_Stock () {
	return $this->id_stock;
}

//@TODO ???
function getClient_encours () {
	return $this->client_encours;
}

//@TODO ???
function getClient_facturation () {
	return $this->client_facturation;
}

//@TODO ???
function getA_facturer () {
	if ($this->id_etat_doc != 62) {
		$this->a_facturer = false;
		return $this->a_facturer;
	}

	// Sinon le BLC est a facturer sauf si l'on trouve une facture (non annulée) liée
	$this->a_facturer = true;
	if (!$this->liaisons_loaded) { $this->charger_liaisons(); }

	foreach ($this->liaisons['dest'] as $liaison) {
		//@TODO ???????????
		if ($liaison->id_type_doc != 4 || $liaison->id_etat_doc == 17) { continue; }
		$this->a_facturer = false;
		break;
	}
	return $this->a_facturer;
}

function getId_magasin () {
	return $this->id_magasin;
}

}

?>