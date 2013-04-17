<?php
// *************************************************************************************************************
// CLASSE REGISSANT LES INFORMATIONS SUR UN DOCUMENT 
// *************************************************************************************************************


abstract class document {
	protected $ref_doc;

	protected $lib_type_doc;
	protected $lib_type_printed;
	protected $date_creation;

	protected $id_etat_doc;
	protected $lib_etat_doc;
	protected $is_open;

	protected $code_affaire;

	protected $ref_contact;
	protected $contact;
	protected $nom_contact;

	protected $ref_adr_contact;
	protected $adresse_contact;
	protected $code_postal_contact;
	protected $ville_contact;
	protected $id_pays_contact;
	protected $pays_contact;

	protected $app_tarifs;
	protected $description;

	protected $contenu;
	protected $contenu_loaded;
	protected $contenu_materiel;
	protected $contenu_materiel_loaded;
	protected $contenu_service_abo;
	protected $contenu_service_abo_loaded;
	protected $contenu_service_conso;
	protected $contenu_service_conso_loaded;

	protected $liaisons;
	protected $liaisons_loaded;
	protected $liaisons_possibles;
	protected $liaisons_possibles_loaded;
	
	protected $code_file; //code md5 du nom du fichier pdf généré lors de l'envois du document

	protected $events;
	protected $events_loaded;

	protected $montant_ht;
	protected $montant_tva;
	protected $montant_ttc = -1;		// Montant TTC du doc, = -1 quand non chargé
	protected $tvas;

	protected $ACCEPT_REGMT = 0;
	protected $reglements;					// Règlements rapprochés à ce document
	protected $reglements_loaded;
	protected $montant_reglements;	// Montant total des règlements (Inversé lorsqu'il s'agit d'emettre les règlements.)
	protected $montant_to_pay;			// Montant restant à payer.

	protected $echeancier;
	
	protected $commerciaux;					// commerciaux attribués à ce document
	protected $commerciaux_loaded;
	
	protected $code_pdf_modele;			// Code du modèle utilisé pour l'impression

	protected $quantite_locked;			// Les quantités pour ce document sont FIGEES


public function __construct($ref_doc = "") {
	$this->ref_doc = $ref_doc;
}



// *************************************************************************************************************
// FONCTIONS LIEES A L'OUVERTURE D'UN DOCUMENT
// *************************************************************************************************************

public function open_doc ($select = "", $left_join = "") {
	global $bdd;

	// Controle si la ref_document est précisée
	if (!$this->ref_doc) { return false; }

	$query = "SELECT d.ref_contact, d.nom_contact, d.ref_adr_contact, d.adresse_contact, d.code_postal_contact, d.ville_contact, d.id_pays_contact, d.app_tarifs, d.description, 
									 d.id_etat_doc, d.code_affaire, de.lib_etat_doc, de.is_open,
									 dt.lib_type_doc, dt.lib_type_printed, pm.code_pdf_modele, 
									 d.date_creation_doc date_creation, d.code_file,
									 p.pays pays_contact
									 ".$select."
						FROM documents d
							LEFT JOIN documents_types dt ON d.id_type_doc = dt.id_type_doc
							LEFT JOIN doc_modeles_pdf dmp ON d.id_type_doc = dmp.id_type_doc && dmp.usage = 'defaut' 
							LEFT JOIN pdf_modeles pm ON pm.id_pdf_modele = dmp.id_pdf_modele
							LEFT JOIN documents_etats de ON d.id_etat_doc = de.id_etat_doc
							LEFT JOIN pays p ON p.id_pays = d.id_pays_contact
							".$left_join."
						WHERE d.ref_doc = '".$this->ref_doc."' ";
	$resultat = $bdd->query ($query);
	if (!$doc = $resultat->fetchObject()) { return false; }

	$this->ref_contact 			= $doc->ref_contact;
	$this->nom_contact 			= $doc->nom_contact;
	$this->ref_adr_contact 	= $doc->ref_adr_contact;
	$this->adresse_contact 	= $doc->adresse_contact;
	$this->code_postal_contact 	= $doc->code_postal_contact;
	$this->ville_contact 		= $doc->ville_contact;
	$this->id_pays_contact 	= $doc->id_pays_contact;
	$this->pays_contact 		= $doc->pays_contact;
	$this->app_tarifs 			= $doc->app_tarifs;
	$this->description 			= $doc->description;
	$this->id_etat_doc 			= $doc->id_etat_doc;
	$this->lib_etat_doc 		= $doc->lib_etat_doc;
	$this->is_open			 		= $doc->is_open;
	$this->code_affaire			= $doc->code_affaire;
	$this->lib_type_doc			= $doc->lib_type_doc;
	$this->lib_type_printed	= $doc->lib_type_printed;
	$this->code_pdf_modele	= $doc->code_pdf_modele;
	$this->date_creation		= $doc->date_creation;
	$this->code_file  			= $doc->code_file;
 	$this->echeancier 			= new document_echeancier($this->getRef_doc(),$this);
	$this->quantite_locked = false;

	if(!$this->echeancier->exist()){
		$this->echeancier->create_from_ref_contact();
	}
		
	return $doc;
}



// *************************************************************************************************************
// FONCTIONS LIEES A LA CREATION D'UN DOCUMENT
// *************************************************************************************************************

public function create_doc () { 
	global $bdd;

	$this->pays_contact 	= "";
	// *************************************************
	// Type de document et etat
	$this->lib_type_doc = $this->LIB_TYPE_DOC;
	$this->id_etat_doc	= $this->DEFAUT_ID_ETAT;
	$this->lib_etat_doc = $this->DEFAUT_LIB_ETAT;
	if (isset($GLOBALS['_OPTIONS']['CREATE_DOC']['id_etat_doc'])) {
		$this->id_etat_doc = $GLOBALS['_OPTIONS']['CREATE_DOC']['id_etat_doc'];
	}

	// *************************************************
	// Valeur par défaut des informations du document
	$this->check_profils ();
	$this->ref_contact = "";
	if (isset($GLOBALS['_OPTIONS']['CREATE_DOC']['ref_contact'])) {
		$this->ref_contact = $GLOBALS['_OPTIONS']['CREATE_DOC']['ref_contact'];
	}
	
	if ($this->ref_contact) {
		// Chargement des informations de ce contact
		$this->load_infos_contact ();
	}
	else {
		$this->load_defauts_infos_contact ();
	}

	if (!$this->app_tarifs) { $this->app_tarifs = "HT"; }

	if (isset($GLOBALS['_OPTIONS']['CREATE_DOC']['code_affaire'])) {
		$this->code_affaire = $GLOBALS['_OPTIONS']['CREATE_DOC']['code_affaire'];
	}	
	
	$this->description = "";
	if (isset($GLOBALS['_OPTIONS']['CREATE_DOC']['description'])) {
		$this->description = $GLOBALS['_OPTIONS']['CREATE_DOC']['description'];
	}

	// *************************************************
	// Verification qu'il n'y a pas eu d'erreur
	if (count($GLOBALS['_ALERTES'])) {
		return false;
	}
	
	//**************************************************
	//création du code file
	$this->code_file = md5(uniqid(rand(), true));
	
	// *************************************************
	// Création de la référence
	$reference = new reference ($this->DOC_ID_REFERENCE_TAG);
	$this->ref_doc = $reference->generer_ref();
	$this->echeancier = new document_echeancier($this->getRef_doc(),$this);
	// *************************************************
	// Insertion dans la base
	$bdd->beginTransaction();

	$query = "INSERT INTO documents (ref_doc, id_type_doc, id_etat_doc, code_affaire, 
												ref_contact, nom_contact, ref_adr_contact, adresse_contact, code_postal_contact, ville_contact, id_pays_contact, app_tarifs, description, date_creation_doc, code_file)
						VALUES ('".$this->ref_doc."', '".$this->ID_TYPE_DOC."', '".$this->id_etat_doc."', '".$this->code_affaire."',
										".ref_or_null($this->ref_contact).", '".addslashes($this->nom_contact)."', 
										".ref_or_null($this->ref_adr_contact).", '".addslashes($this->adresse_contact)."',
										'".$this->code_postal_contact."', '".addslashes($this->ville_contact)."', 
										".num_or_null($this->id_pays_contact).", 
										'".$this->app_tarifs."', '".addslashes($this->description)."', NOW(), '".$this->code_file."' ) ";
	$bdd->exec ($query);
	//conditions de reglement
	if (($this->echeancier instanceof document_echeancier)) {
		if(!$this->echeancier->exist()){
			$this->echeancier->create_from_ref_contact();
		}
	}	
	
	// *************************************************
	// Ajout de l'évennement de création
	$this->add_event(1);
	
	$bdd->commit();

	$GLOBALS['_INFOS']['ref_doc'] = $this->ref_doc;

	// *************************************************
	// Informations complémentaires
	$this->date_creation	= date ("Y-m-d H:i:s");

	return true;
}


// Charge les informations supplémentaires du contact
protected function load_infos_contact () {
	//conditions de reglement

	if (($this->echeancier instanceof document_echeancier)) {
		if(!$this->echeancier->exist()){
			$this->echeancier->create_from_ref_contact();
		}
	}

	// Nom
	$this->define_nom_contact ();

	// Adresse
	$this->define_adresse_contact ();

	// Préférences d'affichage du tarif
	$this->define_aff_tarif ();
}


protected function load_defauts_infos_contact () {
	$this->define_adresse_contact ();
}


protected function load_infos_contact_client () {
	global $CLIENT_ID_PROFIL;

	if (!is_object($this->contact)) { $this->contact = new contact ($this->ref_contact); }
	if (!$this->contact->charger_profiled_infos($CLIENT_ID_PROFIL)) {
		// Creation des informations de profil CLIENT
		$infos_profil['id_profil'] = $CLIENT_ID_PROFIL;
		$this->contact->create_profiled_infos ($infos_profil);
	}
}


protected function load_infos_contact_fournisseur () {
	global $FOURNISSEUR_ID_PROFIL;

	if (!is_object($this->contact)) { $this->contact = new contact ($this->ref_contact); }
	if (!$this->contact->charger_profiled_infos($FOURNISSEUR_ID_PROFIL)) {
		// Creation des informations de profil FOURNISSEUR
		$infos_profil['id_profil'] = $FOURNISSEUR_ID_PROFIL;
		$this->contact->create_profiled_infos ($infos_profil);
	}
}


// Défini le nom du contact
protected function define_nom_contact () {
	if (isset($GLOBALS['_OPTIONS']['CREATE_DOC']['nom_contact'])) {
		$this->nom_contact = $GLOBALS['_OPTIONS']['CREATE_DOC']['nom_contact'];
	}
	else {
		$this->contact = new contact ($this->ref_contact);
		$this->nom_contact = $this->contact->getLib_civ_court()." ".$this->contact->getNom();
	}
}


// Renvoie l'adresse a utiliser dans le document pour un contact donné
protected function define_adresse_contact () {
	global $bdd;
	global $DEFAUT_ID_PAYS;

	if (isset($GLOBALS['_OPTIONS']['CREATE_DOC']['ref_adr_contact'])) {
		$this->ref_adr_contact = $GLOBALS['_OPTIONS']['CREATE_DOC']['ref_adr_contact'];
	}
	if (isset($GLOBALS['_OPTIONS']['CREATE_DOC']['adresse_contact'])) {
		$this->adresse_contact = $GLOBALS['_OPTIONS']['CREATE_DOC']['adresse_contact'];
	}
	if (isset($GLOBALS['_OPTIONS']['CREATE_DOC']['code_postal_contact'])) {
		$this->code_postal_contact = $GLOBALS['_OPTIONS']['CREATE_DOC']['code_postal_contact'];
	}
	if (isset($GLOBALS['_OPTIONS']['CREATE_DOC']['ville_contact'])) {
		$this->ville_contact = $GLOBALS['_OPTIONS']['CREATE_DOC']['ville_contact'];
	}
	if (isset($GLOBALS['_OPTIONS']['CREATE_DOC']['id_pays_contact'])) {
		$this->id_pays_contact = $GLOBALS['_OPTIONS']['CREATE_DOC']['id_pays_contact'];
	}
	
	
	if (!$this->ref_adr_contact && !$this->adresse_contact && !$this->code_postal_contact && !$this->ville_contact && !$this->id_pays_contact) {
		// Sélection de la première Adresse
		$query = "SELECT ref_adresse, text_adresse, code_postal, ville, a.id_pays, p.pays
							FROM adresses a
								LEFT JOIN pays p ON a.id_pays = p.id_pays
							WHERE ref_contact = '".$this->ref_contact."' && ordre = 1 ";
		$resultat = $bdd->query ($query);
		if (!$a = $resultat->fetchObject()) { return false; }

		$this->ref_adr_contact 			= $a->ref_adresse;
		$this->adresse_contact 			= $a->text_adresse ;
		$this->code_postal_contact 	= $a->code_postal ;
		$this->ville_contact 				= $a->ville ;
		$this->id_pays_contact 			= $a->id_pays ;
		$this->pays_contact 				= $a->pays ;
	}

	if (!$this->id_pays_contact) {$this->id_pays_contact = $DEFAUT_ID_PAYS;}
	
	return true;
}


// Renvoie l'adresse a utiliser dans le document pour un contact donné
function define_adresse_contact_et_livraison () {
	global $bdd;
	global $DEFAUT_ID_PAYS;

	$adresse_contact_ok = $adresse_livraison_ok = 0;
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

	if (isset($GLOBALS['_OPTIONS']['CREATE_DOC']['ref_adr_livraison'])) {
		$this->ref_adr_livraison = $GLOBALS['_OPTIONS']['CREATE_DOC']['ref_adr_livraison'];
		$adresse_livraison_ok = 1;
	}
	if (isset($GLOBALS['_OPTIONS']['CREATE_DOC']['adresse_livraison'])) {
		$this->adresse_livraison = $GLOBALS['_OPTIONS']['CREATE_DOC']['adresse_livraison'];
		$adresse_livraison_ok = 1;
	}
	if (isset($GLOBALS['_OPTIONS']['CREATE_DOC']['code_postal_livraison'])) {
		$this->code_postal_livraison = $GLOBALS['_OPTIONS']['CREATE_DOC']['code_postal_livraison'];
		$adresse_livraison_ok = 1;
	}
	if (isset($GLOBALS['_OPTIONS']['CREATE_DOC']['ville_livraison'])) {
		$this->ville_livraison = $GLOBALS['_OPTIONS']['CREATE_DOC']['ville_livraison'];
		$adresse_livraison_ok = 1;
	}
	if (isset($GLOBALS['_OPTIONS']['CREATE_DOC']['id_pays_livraison'])) {
		$this->id_pays_livraison = $GLOBALS['_OPTIONS']['CREATE_DOC']['id_pays_livraison'];
		$adresse_livraison_ok = 1;
	}
	
	if (!$adresse_livraison_ok && ($_SESSION['magasin']->getMode_vente() == "VAC")) {
		$this->ref_adr_livraison = "NULL";
		$this->adresse_livraison = $_SESSION['magasin']->getLib_magasin ();
	}

	
	if ( !$adresse_contact_ok || !$adresse_livraison_ok) {
		// Sélection des adresses prédéfinies
		$query = "SELECT ref_adr_livraison, a1.text_adresse ta1, a1.code_postal cp1, a1.ville v1, a1.id_pays ip1, p1.pays p1, 
										 ref_adr_facturation, a2.text_adresse ta2, a2.code_postal cp2, a2.ville v2, a2.id_pays ip2, p2.pays p2
							FROM annu_client ac
								LEFT JOIN adresses a1 ON ac.ref_adr_livraison = a1.ref_adresse
								LEFT JOIN pays p1 ON a1.id_pays = p1.id_pays
								LEFT JOIN adresses a2 ON ac.ref_adr_facturation = a2.ref_adresse
								LEFT JOIN pays p2 ON a2.id_pays = p2.id_pays
							WHERE ac.ref_contact = '".$this->ref_contact."' ";
		$resultat = $bdd->query ($query); 
		if (!$a = $resultat->fetchObject()) { return false; }
		
		if (!$adresse_contact_ok) {
			$this->ref_adr_contact 			= $a->ref_adr_facturation;
			$this->adresse_contact 			= $a->ta2;
			$this->code_postal_contact 	= $a->cp2 ;
			$this->ville_contact 				= $a->v2 ;
			$this->id_pays_contact 			= $a->ip2 ;
			$this->pays_contact 				= $a->p2 ;
		}
		if (!$adresse_livraison_ok || ($_SESSION['magasin']->getMode_vente() != "VAC")) {
			$this->ref_adr_livraison 			= $a->ref_adr_livraison;
			$this->adresse_livraison 			= $a->ta1;
			$this->code_postal_livraison 	= $a->cp1 ;
			$this->ville_livraison 				= $a->v1 ;
			$this->id_pays_livraison 			= $a->ip1 ;
			$this->pays_livraison 				= $a->p1 ;
		}
	}
	if (!$this->id_pays_contact) {$this->id_pays_contact = $DEFAUT_ID_PAYS;}
	if (!$this->id_pays_livraison) {$this->id_pays_livraison = $DEFAUT_ID_PAYS;}

	return true;
}


// Renvoie le texte précis de l'adresse qui sera affiché
protected function define_text_adresse ($text_adresse, $code_postal, $ville, $id_pays, $pays) {
	global $DEFAUT_ID_PAYS;

	$adresse_contact = $text_adresse;
	if ($code_postal  || $ville) {
		$adresse_contact .= "\n".$code_postal." ".$ville;
	}
	if ($id_pays && $id_pays != $DEFAUT_ID_PAYS ) {
		$adresse_contact .= "\n".$pays;
	}
	
	return $adresse_contact;
}


// Renvoie le type d'affichage des tarifs a utiliser (HT ou TTC) pour le document
protected function define_aff_tarif () {
	$this->define_client_aff_tarif ();
}


function define_client_aff_tarif () {
	global $DEFAUT_APP_TARIFS_CLIENT;
	global $CLIENT_ID_PROFIL;

	if (isset($GLOBALS['_OPTIONS']['CREATE_DOC']['app_tarifs'])) {
		$this->app_tarifs = $GLOBALS['_OPTIONS']['CREATE_DOC']['app_tarifs'];
	}
	else {
		$tmp = $this->contact->getProfil($CLIENT_ID_PROFIL);
		$this->app_tarifs = $tmp->getApp_tarifs();
	}
}


function define_fournisseur_aff_tarif () {
	global $DEFAUT_APP_TARIFS_FOURNISSEUR;
	global $FOURNISSEUR_ID_PROFIL;

	if (isset($GLOBALS['_OPTIONS']['CREATE_DOC']['app_tarifs'])) {
		$this->app_tarifs = $GLOBALS['_OPTIONS']['CREATE_DOC']['app_tarifs'];
	}
	else {
		$tmp = $this->contact->getProfil($FOURNISSEUR_ID_PROFIL);
		$this->app_tarifs = $tmp->getApp_tarifs();
	}
}



// *************************************************************************************************************
// FONCTIONS LIEES A LA MODIFICATION D'UN DOCUMENT
// *************************************************************************************************************
// Changement du contact d'un document
public function maj_contact ($ref_contact) {
	global $bdd;
	global $DEFAUT_APP_TARIFS_CLIENT;
	global $DEFAUT_ID_PAYS;

	if ($ref_contact == $this->ref_contact) { return false; }
	$old_ref_contact = $this->ref_contact;
	$old_nom_contact = $this->nom_contact;

	if (!$ref_contact) {$this->ref_contact = "";}
	
	if ($ref_contact) {
		$this->ref_contact = $ref_contact;
		// Chargement des informations de ce contact
		$this->contact = new contact ($ref_contact);
		$this->load_infos_contact ();
	}

	if (!is_object($this->contact) || !$this->contact->getRef_contact()) { 
		$this->ref_contact 					= "";
		$this->nom_contact 					= "";
		$this->ref_adr_contact 			= "";
		$this->adresse_contact 			= "";
		$this->code_postal_contact 	= "";
		$this->ville_contact 				= "";
		$this->id_pays_contact 			= $DEFAUT_ID_PAYS;
		$this->app_tarifs 					= $DEFAUT_APP_TARIFS_CLIENT;
	}

	// *************************************************
	// MAJ de la base
	$bdd->beginTransaction();

	$query = "UPDATE documents 
						SET ref_contact = ".ref_or_null($this->ref_contact).", nom_contact = '".addslashes($this->nom_contact)."', 
								ref_adr_contact = ".ref_or_null($this->ref_adr_contact).", 
								adresse_contact = '".addslashes($this->adresse_contact)."',
								code_postal_contact = '".$this->code_postal_contact."',
								ville_contact = '".addslashes($this->ville_contact)."',
								id_pays_contact = ".num_or_null($this->id_pays_contact).",
								app_tarifs = '".$this->app_tarifs."'
						WHERE ref_doc = '".$this->ref_doc."' ";
	$bdd->exec ($query);
	
	// MAJ du contact pour les règlements de ce document qui ne règlent pas d'autres documents du même type
	$query = "SELECT rd.ref_reglement, COUNT(rd.ref_doc) as nb_docs
						FROM reglements_docs rd
  						LEFT JOIN documents d ON d.ref_doc = rd.ref_doc
						WHERE rd.ref_reglement IN ( 
 																				SELECT ref_reglement 
 																				FROM reglements_docs rd
 																				WHERE rd.ref_doc = '".$this->ref_doc."' 
																			)
									&& rd.liaison_valide = '1'
						GROUP BY rd.ref_reglement";
	$resultat = $bdd->query ($query);
	
	$rgmts_to_update = $rgmts_to_deli = array();
	while ($rgmt = $resultat->fetchObject()) {
		//echo $rgmt->ref_reglement;
		if ($rgmt->nb_docs > 1) { $rgmts_to_deli[] 		= $rgmt->ref_reglement; }
		else { 										$rgmts_to_update[] 	= $rgmt->ref_reglement; }
	}
	if ($rgmts_to_update) {
		$list_to_update = "''";
		foreach ($rgmts_to_update as $ref_rgmt) { $list_to_update .= ",'".$ref_rgmt."'"; }
		$query = "UPDATE reglements SET ref_contact = ".ref_or_null($this->ref_contact)."
							WHERE ref_reglement IN (".$list_to_update.")";
		$bdd->exec ($query);
	}
	if ($rgmts_to_deli) {
		$list_to_deli = "''";
		foreach ($rgmts_to_deli as $ref_rgmt) { $list_to_deli .= ",'".$ref_rgmt."'"; }
		$query = "DELETE FROM reglements_docs 
							WHERE ref_reglement IN (".$list_to_deli.") && ref_doc = '".$this->ref_doc."' ";
		$resultat = $bdd->query ($query);
    if ($resultat->rowCount()) {	$this->check_etat_reglement ();	}
	}

	// Evenement
	if ($old_ref_contact) {
		$this->add_event(6, "Ancien contact   : ".$old_nom_contact." (".$old_ref_contact.")\n Nouveau contact : ".$this->nom_contact." (".$this->ref_contact.")");
	}

	$bdd->commit();

	return true;
}


public function maj_nom_contact ($nom_contact) {
	global $bdd;

	$this->nom_contact = $nom_contact;

	// *************************************************
	// MAJ de la base
	$query = "UPDATE documents 
						SET nom_contact = '".addslashes($this->nom_contact)."'
						WHERE ref_doc = '".$this->ref_doc."' ";
	$bdd->exec ($query);
}



public function maj_adresse_contact ($ref_adresse) {
	global $bdd;
	global $DEFAUT_ID_PAYS;

	if (is_numeric($ref_adresse)) {
		$query = "SELECT lib_stock FROM stocks
							WHERE id_stock = '".addslashes($ref_adresse)."' ";
		$resultat = $bdd->query ($query);
		if (!$s = $resultat->fetchObject()) { return false; }

		$this->ref_adr_contact = "NULL";
		$this->adresse_contact = $s->lib_stock; 
		$this->code_postal_contact = "";
		$this->ville_contact = "";
		$this->id_pays_contact = $DEFAUT_ID_PAYS;
		$this->pays_contact = "";
		if (isset($_SESSION['stocks'][$ref_adresse])) {
			$adresse = $_SESSION['stocks'][$ref_adresse]->getAdresse ();
			$this->id_pays_contact 			= $adresse->getId_pays();
		}
	}
	else {
		// Sélection de l'Adresse
		$query = "SELECT ref_adresse, text_adresse, code_postal, ville, a.id_pays, p.pays
							FROM adresses a
								LEFT JOIN pays p ON a.id_pays = p.id_pays
							WHERE ref_adresse = '".$ref_adresse."' ";
		$resultat = $bdd->query ($query);
		if (!$a = $resultat->fetchObject()) { return false; }

		$this->ref_adr_contact = $a->ref_adresse;
		$this->adresse_contact = $a->text_adresse;
		$this->code_postal_contact = $a->code_postal;
		$this->ville_contact = $a->ville;
		$this->id_pays_contact = $a->id_pays;
		$this->pays_contact = $a->pays;
	}

	// *************************************************
	// MAJ de la base
	$query = "UPDATE documents 
						SET ref_adr_contact = ".ref_or_null($this->ref_adr_contact).", 
								adresse_contact = '".addslashes($this->adresse_contact)."', 
								code_postal_contact = '".($this->code_postal_contact)."', 
								ville_contact = '".addslashes($this->ville_contact)."', 
								id_pays_contact = ".num_or_null($this->id_pays_contact)."
						WHERE ref_doc = '".$this->ref_doc."' ";
	$bdd->exec ($query);

	return true;
}


public function maj_text_adresse_contact ($text_adresse) {
	global $bdd;

	$this->adresse_contact = $text_adresse;

	// *************************************************
	// MAJ de la base
	$query = "UPDATE documents 
						SET adresse_contact = '".addslashes($this->adresse_contact)."'
						WHERE ref_doc = '".$this->ref_doc."' ";
	$bdd->exec ($query);	
}

public function maj_text_code_postal_contact ($text_code_postal) {
	global $bdd;

	$this->code_postal_contact = $text_code_postal;

	// *************************************************
	// MAJ de la base
	$query = "UPDATE documents 
						SET code_postal_contact = '".$this->code_postal_contact."'
						WHERE ref_doc = '".$this->ref_doc."' ";
	$bdd->exec ($query);	
}

public function maj_text_ville_contact ($text_ville) {
	global $bdd;

	$this->ville_contact = $text_ville;

	// *************************************************
	// MAJ de la base
	$query = "UPDATE documents 
						SET ville_contact = '".addslashes($this->ville_contact)."'
						WHERE ref_doc = '".$this->ref_doc."' ";
	$bdd->exec ($query);	
}

public function maj_text_id_pays_contact ($text_id_pays) {
	global $bdd;

	$this->id_pays_contact = $text_id_pays;

	// *************************************************
	// MAJ de la base
	$query = "UPDATE documents 
						SET id_pays_contact = ".num_or_null($this->id_pays_contact)."
						WHERE ref_doc = '".$this->ref_doc."' ";
	$bdd->exec ($query);	
}


public function maj_adresse_livraison ($ref_adresse) {
	global $bdd;
	global $DEFAUT_ID_PAYS;

	if (is_numeric($ref_adresse)) {
		$query = "SELECT lib_stock FROM stocks
							WHERE id_stock = '".addslashes($ref_adresse)."' ";$resultat = $bdd->query ($query);
		if (!$s = $resultat->fetchObject()) { return false; }

		$this->ref_adr_livraison = "NULL";
		$this->adresse_livraison = $s->lib_stock;
		$this->code_postal_livraison 	= "" ;
		$this->ville_livraison 				= "" ;
		$this->id_pays_livraison 			= $DEFAUT_ID_PAYS ;
		$this->pays_livraison 				= "" ;
		if (isset($_SESSION['stocks'][$ref_adresse])) {
			$adresse = $_SESSION['stocks'][$ref_adresse]->getAdresse ();
			$this->id_pays_livraison 			= $adresse->getId_pays();
		}
	}
	else {
		// Sélection de l'Adresse
		$query = "SELECT ref_adresse, text_adresse, code_postal, ville, a.id_pays, p.pays
							FROM adresses a
								LEFT JOIN pays p ON a.id_pays = p.id_pays
							WHERE ref_adresse = '".$ref_adresse."' ";
		$resultat = $bdd->query ($query);
		if (!$a = $resultat->fetchObject()) { return false; }

		$this->ref_adr_livraison 			= $a->ref_adresse;
		$this->adresse_livraison 			= $a->text_adresse ;
		$this->code_postal_livraison 	= $a->code_postal ;
		$this->ville_livraison 				= $a->ville ;
		$this->id_pays_livraison 			= $a->id_pays ;
		$this->pays_livraison 				= $a->pays ;
	}

	// *************************************************
	// MAJ de la base
	$query = "UPDATE doc_".strtolower($this->CODE_DOC)." 
						SET ref_adr_livraison = ".ref_or_null($this->ref_adr_livraison).", 
								adresse_livraison = '".addslashes($this->adresse_livraison)."', 
								code_postal_livraison = '".$this->code_postal_livraison."', 
								ville_livraison = '".addslashes($this->ville_livraison)."', 
								id_pays_livraison = ".num_or_null($this->id_pays_livraison)."
						WHERE ref_doc = '".$this->ref_doc."' ";
	$bdd->exec ($query);

	return true;
}


public function maj_text_adresse_livraison ($text_adresse) {
	global $bdd;

	$this->adresse_livraison = $text_adresse;

	// *************************************************
	// MAJ de la base
	$query = "UPDATE doc_".strtolower($this->CODE_DOC)." 
						SET adresse_livraison = '".addslashes($this->adresse_livraison)."'
						WHERE ref_doc = '".$this->ref_doc."' ";
	$bdd->exec ($query);
	return true;
}


public function maj_text_code_postal_livraison ($text_code_postal) {
	global $bdd;

	$this->code_postal_livraison = $text_code_postal;

	// *************************************************
	// MAJ de la base
	$query = "UPDATE doc_".strtolower($this->CODE_DOC)." 
						SET code_postal_livraison = '".$this->code_postal_livraison."'
						WHERE ref_doc = '".$this->ref_doc."' ";
	$bdd->exec ($query);
	return true;
}


public function maj_text_ville_livraison ($text_ville) {
	global $bdd;

	$this->ville_livraison = $text_ville;

	// *************************************************
	// MAJ de la base
	$query = "UPDATE doc_".strtolower($this->CODE_DOC)." 
						SET ville_livraison = '".addslashes($this->ville_livraison)."'
						WHERE ref_doc = '".$this->ref_doc."' ";
	$bdd->exec ($query);
	return true;
}


public function maj_text_id_pays_livraison ($text_id_pays) {
	global $bdd;

	$this->id_pays_livraison = $text_id_pays;

	// *************************************************
	// MAJ de la base
	$query = "UPDATE doc_".strtolower($this->CODE_DOC)." 
						SET id_pays_livraison = ".num_or_null($this->id_pays_livraison)."
						WHERE ref_doc = '".$this->ref_doc."' ";
	$bdd->exec ($query);
	return true;
}


static function maj_description ($ref_doc, $new_description) {
	global $bdd;
	
	$query = "UPDATE documents SET description = '".addslashes($new_description)."'
						WHERE ref_doc = '".$ref_doc."' ";
	$bdd->exec ($query);
	
	// $this->description = $new_description;
}


function maj_app_tarifs ($new_app_tarifs) {
	global $bdd;
	global $CLIENT_ID_PROFIL;

	// Controle
	if ($new_app_tarifs != "HT") {
		$new_app_tarifs == "TTC";
	}
	$this->app_tarifs = $new_app_tarifs;
	
	// Maj de la base de données
	$query = "UPDATE documents SET app_tarifs = '".$this->app_tarifs."'
						WHERE ref_doc = '".$this->ref_doc."' ";
	$bdd->exec ($query);
	
//fonction de mise à jour de l'app_tarif du contact en cas de changement d'app_tarif du document par défaut le profil client (seul les class de doc spéciales fournisseur forceront l'app_tarifs du profil fournisseur
	if (!is_object($this->contact)) { $this->contact = new contact ($this->ref_contact); }
	if ($this->contact->charger_profiled_infos($CLIENT_ID_PROFIL)) {
		$profil_tmp = $this->contact->getProfil($CLIENT_ID_PROFIL);
		$profil_tmp->maj_app_tarifs ($this->app_tarifs);
	}
}


public function maj_id_stock ($id_stock, $lib_var = "") {
	global $bdd;	

	if (!$lib_var) { $lib_var = "id_stock"; }

	// Vérification de l'existence du stock
	$found = 0;
	foreach ($_SESSION['stocks'] as $stock) {
		if ($stock->getId_stock() != $id_stock) { continue; }
		$found = 1;
		break;
	}
	if (!$found) {
		$GLOBALS['_ALERTES']['bad_'.$lib_var] = 1;
	}
	// Vérification de la possibilité de changer l'id_stock (expédiant ou recevant)
	if (!$this->is_open) {
		$GLOBALS['_ALERTES']['doc_is_closed'] = 1;
	}

	if (count($GLOBALS['_ALERTES'])) {
		return false;
	}
	$this->{$lib_var} = $id_stock;

	// *************************************************
	// MAJ de la base
	$query = "UPDATE doc_".strtolower($this->CODE_DOC)." 
						SET ".$lib_var." = '".$this->{$lib_var}."'
						WHERE ref_doc = '".$this->ref_doc."' ";
	$bdd->exec ($query);

	// *************************************************
	// Retour des informations
	$GLOBALS['_INFOS'][$lib_var] = $this->{$lib_var};

	return true;
}


// Fusion de documents
public function fusion_doc ($second_ref_doc) {
	
	global $bdd;
	if (!isset($second_ref_doc)) { return false;}
	
	$second_document = open_doc($second_ref_doc);
	
	if (!$this->check_allow_fusion ($second_document)) { return false; }
	
	//Début de la fusion
	
	$GLOBALS['_OPTIONS']['FUSION'] = 1;
	
	//insertion de la ligne d'info 
	$infos['type_of_line'] = "information";
	$infos['titre'] = "Contenu issu de la fusion avec ".$second_document->getRef_doc ();
	$infos['texte'] = "";
	$infos['visible'] = 0;
	$this->add_line ($infos);
	
	//copie du contenu
	$second_document->copie_content ($this);
	
	
	//changement des liaisons existantes du second document vers le premier
	$query = "UPDATE documents_liaisons SET ref_doc_destination = '".$this->ref_doc."'
						WHERE ref_doc_destination = '".$second_document->getRef_doc ()."' ";
	$bdd->exec ($query);
	
	$query = "UPDATE documents_liaisons SET ref_doc_source = '".$this->ref_doc."' 
						WHERE ref_doc_source = '".$second_document->getRef_doc ()."' ";
	$bdd->exec ($query);
	
	//liaison non active prouvant la liaison entre les docs
	$this->link_from_doc_set_active ($second_document->getRef_doc (), 0) ;
	
	//renvoi des règlements vers le premier document
	$query = "UPDATE reglements_docs SET ref_doc = '".$this->ref_doc."'
						WHERE ref_doc = '".$second_document->getRef_doc ()."' ";
	$bdd->exec ($query);

	// Annulation du second document
	$second_document->maj_etat_doc ($this->ID_ETAT_ANNULE);
	
	$this->add_event(5, "avec ".$second_document->getRef_doc ());
	$second_document->add_event(5, "vers ".$this->ref_doc);
	
	return true;
}

// Liste des documents pouvant être fusionner
public function check_allow_fusion ($second_document) {
	
	return true;
}


// Liste des documents pouvant être fusionner
public function liste_doc_fusion () {
	
	return true;
}

// *************************************************************************************************************
// FONCTIONS LIEES A LA MODIFICATION DE L'ETAT D'UN DOCUMENT
// *************************************************************************************************************
// Changement de l'état du document
final public function maj_etat_doc ($new_etat_doc) {
	global $bdd;

	if ($this->id_etat_doc == $new_etat_doc) 		{ return false; }
	if (!$new_etat_doc = $this->check_maj_etat($new_etat_doc)) 	{ return false; }

	// Mise à jour des liaisons avec d'autres documents le cas échéant
	if ($new_etat_doc == $this->ID_ETAT_ANNULE) {
		$this->maj_etat_liaisons(0);
	}
	elseif ($this->id_etat_doc == $this->ID_ETAT_ANNULE) {
		$this->maj_etat_liaisons(1);
	}
	
	// Mise à jour des liaisons avec les règlements le cas échéant
	if ($new_etat_doc == $this->ID_ETAT_ANNULE) {
		$this->maj_etat_reglements(0);
	}
	elseif ($this->id_etat_doc == $this->ID_ETAT_ANNULE) {
		$this->maj_etat_reglements(1);
	}

	// Action a effectuer avant toute chose (Controles, etc.)
	$this->action_before_maj_etat ($new_etat_doc);

	// Sélection du libellé du nouvel état
	$query = "SELECT lib_etat_doc FROM documents_etats
						WHERE id_etat_doc = '".$new_etat_doc."' ";
	$resultat = $bdd->query ($query);
	$info = $resultat->fetchObject();

	// Changements sur l'objet
	$old_etat_doc 			= $this->id_etat_doc;
	$this->id_etat_doc 	= $new_etat_doc;
	$this->lib_etat_doc = $info->lib_etat_doc;

	// *************************************************
	// Maj dans la BDD
	$query = "UPDATE documents SET id_etat_doc = '".$new_etat_doc."'
						WHERE ref_doc = '".$this->ref_doc."' ";
	$bdd->exec ($query);
	
	// Enregistrement de l'évennement
	$id_event_type = 2; 
	$event = $this->lib_etat_doc;
	$this->add_event($id_event_type, $event);

	// Action a effectuer apres la mise a jour de l'etat.
	$this->action_after_maj_etat ($old_etat_doc);
		
	return true;
}


// Vérification de la possibilité de changer l'état du document
protected function check_maj_etat ($new_etat_doc) {
	if (!is_numeric($new_etat_doc)) { return false; }
	return $new_etat_doc;
}


// Action avant de changer l'état du document
protected function action_before_maj_etat ($new_etat_doc) {
	return true;
}


// Action après de changer l'état du document
protected function action_after_maj_etat ($old_etat_doc) {
	return true;
}


protected function maj_etat_liaisons ($active = 1) {
	global $bdd;

	$query = "UPDATE documents_liaisons SET active = '".$active."'
						WHERE ref_doc_source = '".$this->ref_doc."' || ref_doc_destination = '".$this->ref_doc."' ";
	$bdd->exec ($query);
	return true;
}


// *************************************************************************************************************
// FONCTIONS DE GESTION DU CONTENU
// *************************************************************************************************************
// Chargement du contenu du document
public function charger_contenu () {
	global $bdd;
	global $CALCUL_TARIFS_NB_DECIMALS;
	global $TARIFS_NB_DECIMALES;
	global $GESTION_SN;
	global $DOC_AFF_QTE_SN;

	$query_infos_supp = $this->doc_line_infos_supp ();

	// *****************************************
	// Chargement du contenu
	$this->contenu = $tmp_contenu = array();
	$query = "SELECT dl.ref_doc_line, dl.ref_article, dl.lib_article, dl.desc_article, 
									 dl.qte, round(dl.pu_ht,".$CALCUL_TARIFS_NB_DECIMALS.") as pu_ht, dl.remise, dl.tva, 
									 dl.ordre, dl.ref_doc_line_parent, dl.visible, dl.pa_ht, dl.pa_forced,
									 a.ref_oem, a.ref_interne, a.id_valo, a.valo_indice, a.gestion_sn, ac.modele, a.lot, av.abrev_valo
									 ".$query_infos_supp['select']."
						FROM docs_lines dl
							LEFT JOIN articles a ON dl.ref_article = a.ref_article
							LEFT JOIN articles_valorisations av ON av.id_valo = a.id_valo
							LEFT JOIN art_categs ac ON a.ref_art_categ = ac.ref_art_categ
							".$query_infos_supp['left_join']."
						WHERE ref_doc = '".$this->ref_doc."' 
						ORDER BY ordre ";
	$resultat = $bdd->query ($query);
	while ($doc_line = $resultat->fetchObject()) {
		$doc_line->type_of_line = define_type_of_line($doc_line->ref_article);
		$tmp_contenu[] = $doc_line;
	}
	for ($i=0; $i<count($tmp_contenu); $i++) {
		if ($tmp_contenu[$i]->ref_doc_line_parent) { continue; }
		$this->contenu[] = $tmp_contenu[$i];
		for ($j=0; $j<count($tmp_contenu); $j++) {
			if ($tmp_contenu[$j]->ref_doc_line_parent != $tmp_contenu[$i]->ref_doc_line) { continue; }
			$this->contenu[] = $tmp_contenu[$j];
		}
	}

	$this->contenu_loaded = true;


	// *****************************************
	// Calcul des montants HT et TTC, des TVAS et des TAXES
	$this->montant_ht = $this->montant_tva = 0;
	$this->tvas = array();
	for ($i=0; $i<count($this->contenu); $i++) {
		if ( $this->contenu[$i]->type_of_line != "article" || !$this->contenu[$i]->visible) { 
			continue; 
		}

		$this->contenu[$i]->pu_ht = round($this->contenu[$i]->pu_ht, $CALCUL_TARIFS_NB_DECIMALS);
		$montant_ht = round ($this->contenu[$i]->pu_ht * $this->contenu[$i]->qte * (1-$this->contenu[$i]->remise/100), $CALCUL_TARIFS_NB_DECIMALS);
		$tva = round($montant_ht * ($this->contenu[$i]->tva/100), $TARIFS_NB_DECIMALES) ;

		$this->montant_ht 	+= $montant_ht;
		$this->montant_tva 	+= $tva;

		if (!isset($this->tvas[$this->contenu[$i]->tva])) { $this->tvas[$this->contenu[$i]->tva] = 0; }
		$this->tvas[$this->contenu[$i]->tva] += $tva;
	}
	$this->montant_ttc = $this->montant_ht + $this->montant_tva;

	// *****************************************
	// Chargement des numéros de serie
	if (!$GESTION_SN || !$this->GESTION_SN) { return true; }
	$query_sn_infos_supp = $this->doc_line_sn_infos_supp ();

	$numeros = array();
	$contenu_liste = "";
	foreach ($this->contenu as $doc_line) {
		if (!$doc_line->gestion_sn) { continue; }
		if ($doc_line->gestion_sn == 2) {
			unset($GLOBALS['_OPTIONS']['CREATE_DOC']['no_charge_all_sn']);
			$GLOBALS['_OPTIONS']['CREATE_DOC']['group_sn'] = 1;
		}
		if ($contenu_liste) {$contenu_liste .= ",";}
		$contenu_liste .= "'".$doc_line->ref_doc_line."'";
	}
	if (!$contenu_liste) { return true; }

	$query = "SELECT dls.ref_doc_line, dls.numero_serie, dls.sn_qte ".$query_sn_infos_supp['select']."
						FROM docs_lines_sn dls ".$query_sn_infos_supp['left_join']."
						WHERE dls.ref_doc_line IN (".$contenu_liste.") 
						ORDER BY dls.numero_serie ASC";
	
	if (isset($GLOBALS['_OPTIONS']['CREATE_DOC']['no_charge_all_sn'])  ) {
		$query .= " LIMIT ".($DOC_AFF_QTE_SN+1);
		
	}
	if (isset($GLOBALS['_OPTIONS']['CREATE_DOC']['group_sn'])  ) {
		
	$query = "SELECT dls.ref_doc_line, dls.numero_serie, dls.sn_qte 
						FROM docs_lines_sn dls 
						WHERE dls.ref_doc_line IN (".$contenu_liste.") 
						ORDER BY dls.numero_serie ASC";
		
	}
	$resultat = $bdd->query ($query); 
	while ($sn = $resultat->fetchObject()) { $numeros[] = $sn; }

	// Association des numéros de série au contenu
	for ($i=0; $i<count($this->contenu); $i++) {
		// Création du tableau de numéros de série
		if ($this->contenu[$i]->gestion_sn) { $this->contenu[$i]->sn = array(); }
		// Remplissage du tableau
		foreach ($numeros as $sn) {
			if ($this->contenu[$i]->ref_doc_line != $sn->ref_doc_line) { continue; }
			$this->contenu[$i]->sn[] = $sn;
		}
	}

	return true;
}


protected function charger_line ($ref_doc_line) {
	global $bdd;
	global $GESTION_SN;
	global $CALCUL_TARIFS_NB_DECIMALS;

	$query_infos_supp = $this->doc_line_infos_supp ();


	// Sélection des informations
	$query = "SELECT dl.ref_doc_line, dl.ref_article, dl.lib_article, dl.desc_article, 
									 dl.qte, round(dl.pu_ht,".$CALCUL_TARIFS_NB_DECIMALS.") as pu_ht, dl.remise, dl.tva, 
									 dl.ordre, dl.ref_doc_line_parent, dl.visible, dl.pa_ht, dl.pa_forced,
									 a.ref_oem, a.ref_interne, a.id_valo, a.valo_indice, a.gestion_sn, ac.modele, a.lot, av.abrev_valo
									 ".$query_infos_supp['select']."
						FROM docs_lines dl
							LEFT JOIN articles a ON dl.ref_article = a.ref_article
							LEFT JOIN articles_valorisations av ON av.id_valo = a.id_valo
							LEFT JOIN art_categs ac ON a.ref_art_categ = ac.ref_art_categ
							".$query_infos_supp['left_join']."
						WHERE dl.ref_doc_line = '".addslashes($ref_doc_line)."' "; 
	$bdd->query ($query);
	$resultat = $bdd->query ($query);
	if (!$doc_line = $resultat->fetchObject()) { return false; }

	$doc_line->type_of_line = define_type_of_line($doc_line->ref_article);


	// *****************************************
	// Chargement des numéros de serie
	if (!$GESTION_SN || !$this->GESTION_SN || !$doc_line->gestion_sn) { return $doc_line; }
	$query_sn_infos_supp = $this->doc_line_sn_infos_supp ();

	$doc_line->sn = array();

	$query = "SELECT dls.ref_doc_line, dls.numero_serie ".$query_sn_infos_supp['select']."
						FROM docs_lines_sn dls ".$query_sn_infos_supp['left_join']."
						WHERE dls.ref_doc_line = '".$ref_doc_line."' ";

	if ($doc_line->gestion_sn == 2) {
	
	$query = "SELECT dls.ref_doc_line, dls.numero_serie 
						FROM docs_lines_sn dls 
						WHERE dls.ref_doc_line = '".$ref_doc_line."' ";
	}
	$resultat = $bdd->query ($query);
	while ($sn = $resultat->fetchObject()) { $doc_line->sn[] = $sn; }

	return $doc_line;
}



// Chargement du contenu "matériel" du document
public function charger_contenu_materiel () {
	global $bdd;
	global $GESTION_SN;

	$query_infos_supp = $this->doc_line_infos_supp ();

	// *****************************************
	// Chargement du contenu
	$this->contenu_materiel = array();
	$query = "SELECT dl.ref_doc_line, dl.ref_article, dl.qte, dl.pa_ht, dl.pa_forced, a.gestion_sn
									 ".$query_infos_supp['select']."
						FROM docs_lines dl
							LEFT JOIN articles a ON dl.ref_article = a.ref_article
							LEFT JOIN art_categs ac ON a.ref_art_categ = ac.ref_art_categ
							".$query_infos_supp['left_join']."
						WHERE ref_doc = '".$this->ref_doc."' && a.modele = 'materiel' && a.lot != '2'";
	$resultat = $bdd->query ($query);
	while ($doc_line = $resultat->fetchObject()) {
		$this->contenu_materiel[] = $doc_line;
	}
	$this->contenu_materiel_loaded = true;

	// *****************************************
	// Chargement des numéros de serie
	if (!$GESTION_SN || !$this->GESTION_SN) { return true; }
	$query_sn_infos_supp = $this->doc_line_sn_infos_supp ();

	$contenu_liste = "''";
	foreach ($this->contenu_materiel as $doc_line) {
		if (!$doc_line->gestion_sn) { continue; }
		if ($doc_line->gestion_sn == 2) {
			unset($GLOBALS['_OPTIONS']['CREATE_DOC']['no_charge_all_sn']);
			$GLOBALS['_OPTIONS']['CREATE_DOC']['group_sn'] = 1;
		}
		if ($contenu_liste) {$contenu_liste .= ",";}
		$contenu_liste .= "'".$doc_line->ref_doc_line."'";
	}
	if (!$contenu_liste) { return true; }

	$query = "SELECT dls.ref_doc_line, dls.numero_serie, dls.sn_qte ".$query_sn_infos_supp['select']."
						FROM docs_lines_sn dls ".$query_sn_infos_supp['left_join']."
						WHERE dls.ref_doc_line IN (".$contenu_liste.") ";

	if (isset($GLOBALS['_OPTIONS']['CREATE_DOC']['group_sn'])  ) {
		
	$query = "SELECT dls.ref_doc_line, dls.numero_serie, dls.sn_qte 
						FROM docs_lines_sn dls 
						WHERE dls.ref_doc_line IN (".$contenu_liste.") ";
		
	}
	$resultat = $bdd->query ($query);
	$numeros = array();
	while ($sn = $resultat->fetchObject()) { 
		$numeros[] = $sn; 
	}

	// Association des numéros de série au contenu
	for ($i=0; $i<count($this->contenu_materiel); $i++) {
		// Création du tableau de numéros de série
		if ($this->contenu_materiel[$i]->gestion_sn) { $this->contenu_materiel[$i]->sn = array(); }
		// Remplissage du tableau
		foreach ($numeros as $sn) {
			if ($this->contenu_materiel[$i]->ref_doc_line != $sn->ref_doc_line) { continue; }
			$this->contenu_materiel[$i]->sn[] = $sn;
		}
	}

	return true;
}

// Chargement du contenu "service_abo" du document
public function charger_contenu_service_abo () {
	global $bdd;
	global $GESTION_SN;

	$query_infos_supp = $this->doc_line_infos_supp ();

	// *****************************************
	// Chargement du contenu
	$this->contenu_service_abo = array();
	$query = "SELECT dl.ref_doc_line, dl.ref_article, dl.qte, dl.pa_ht, dl.pa_forced, a.gestion_sn
									 ".$query_infos_supp['select']."
						FROM docs_lines dl
							LEFT JOIN articles a ON dl.ref_article = a.ref_article
							LEFT JOIN art_categs ac ON a.ref_art_categ = ac.ref_art_categ
							".$query_infos_supp['left_join']."
						WHERE ref_doc = '".$this->ref_doc."' && a.modele = 'service_abo' && a.lot != '2'";
	$resultat = $bdd->query ($query);
	while ($doc_line = $resultat->fetchObject()) {
		$this->contenu_service_abo[] = $doc_line;
	}
	$this->contenu_service_abo_loaded = true;

	return true;
}

// Chargement du contenu "service_conso" du document
public function charger_contenu_service_conso () {
	global $bdd;
	global $GESTION_SN;

	$query_infos_supp = $this->doc_line_infos_supp ();

	// *****************************************
	// Chargement du contenu
	$this->contenu_service_conso = array();
	$query = "SELECT dl.ref_doc_line, dl.ref_article, dl.qte, dl.pa_ht, dl.pa_forced, a.gestion_sn
									 ".$query_infos_supp['select']."
						FROM docs_lines dl
							LEFT JOIN articles a ON dl.ref_article = a.ref_article
							LEFT JOIN art_categs ac ON a.ref_art_categ = ac.ref_art_categ
							".$query_infos_supp['left_join']."
						WHERE ref_doc = '".$this->ref_doc."' && a.modele = 'service_conso' && a.lot != '2'";
	$resultat = $bdd->query ($query);
	while ($doc_line = $resultat->fetchObject()) {
		$this->contenu_service_conso[] = $doc_line;
	}
	$this->contenu_service_conso_loaded = true;

	return true;
}

// Défini les informations supplémentaires a charger avec une ligne de document
protected function doc_line_infos_supp () {
	$query['select']		= "";
	$query['left_join'] = "";
	return $query;
}


// Chargement des informations supplémentaires concernant les numéros de série
protected function doc_line_sn_infos_supp () {
	$query['select']		= "";
	$query['left_join'] = "";
	return $query;
}


// Supprime une ligne de contenu
public function delete_line ($ref_doc_line) {
	global $bdd;
	
	// On récupère l'article de la ligne
	$query = "SELECT ref_article FROM docs_lines WHERE ref_doc_line = '".$ref_doc_line."';";
	$res = $bdd->query($query);
	if($enr = $res->fetchObject()){
		$article = new article($enr->ref_article);
		// On supprime les lignes de taxes
		$taxes = $article->getTaxes();
		foreach ($taxes as $taxe) {
			$query = "DELETE FROM docs_lines 
						WHERE ref_article = 'TAXE " . $taxe->code_taxe . "'
						AND ref_doc_line_parent = '" . $ref_doc_line . "';";
			$bdd->exec($query);
		}
	}
	
	$query = "DELETE FROM docs_lines WHERE ref_doc_line = '".$ref_doc_line."' ";
	$bdd->exec ($query);

	return true;
}

// Supprime toutes les lignes de contenu
public function delete_all_line () {
	global $bdd;

	$query = "DELETE FROM docs_lines WHERE ref_doc = '".$this->ref_doc."' ";
	$bdd->exec ($query);

	return true;
}




// *************************************************************************************************************
// FONCTIONS D'AJOUT DU CONTENU
// *************************************************************************************************************

// Ajout d'une ligne au document
public function add_line ($infos) {
	switch($infos['type_of_line']) {
		case "article" :
			return $this->add_line_article ($infos);
		break;
	case "information": 
		return $this->add_line_info ($infos);
		break;	
	case "soustotal":
		return $this->add_line_ss_total ($infos);
		break;	
	case "taxe":
		return $this->add_line_taxe ($infos);
		break;	
	}
}


// Ajout d'un article depuis le catalogue
protected function add_line_article ($infos) {
	global $bdd;
	global $GESTION_SN;
	global $DOC_LINE_ID_REFERENCE_TAG;
	global $ASSUJETTI_TVA;
	global $DEVIS_CLIENT_ID_TYPE_DOC;
	global $COMMANDE_CLIENT_ID_TYPE_DOC;
	global $LIVRAISON_CLIENT_ID_TYPE_DOC;
	global $FACTURE_FOURNISSEUR_ID_TYPE_DOC;
	global $INVENTAIRE_ID_TYPE_DOC;
	global $DEFAUT_ID_PAYS;
	
	// *************************************************
	// Sélection des informations sur l'article
	$ref_article 	= $infos['ref_article'];
	$article = new article ($ref_article);

	// *************************************************
	// Verification
	if (!$article->getRef_article()) {
		return false;
	}
	$qte = $infos['qte'];
	
	// Si on est sur un inventaire, on n'affiche pas les compositions internes
	if($article->getLot() == 2 && $this->ID_TYPE_DOC == $INVENTAIRE_ID_TYPE_DOC){
		return false;
	}


	// *************************************************
	// Réception des autres variables
	if (isset($infos['pu_ht'])) 								{		$pu_ht = $infos['pu_ht']; }
	else { $pu_ht = $this->select_article_pu ($article, $qte); }

	if (isset($infos['pa_ht']) && !empty($infos['pa_forced'])) {
		$pa_ht = $infos['pa_ht'];
	}
	else {
					$pa_ht = $article->getPaa_ht();
	}
		if (isset($infos['remise'])) 							{
            $remise = floatval($infos['remise']); }
	else {
            if(!$res =$this->select_infos_article_pcotation($article, $qte))
                 $remise = 0;
            else
                $remise = floatval($res->remise);
        }
	if (isset($infos['ref_doc_line_parent'])) 	{ 	$ref_doc_line_parent = $infos['ref_doc_line_parent']; }
	else { $ref_doc_line_parent = ""; }
	$visible = 1;
	if ($ref_doc_line_parent || (isset($infos['visible']) && $infos['visible'])) 	{ $visible = 0; }

	// *************************************************
	// Création de la référence et de l'ordre
	$ref_doc_line = $this->create_ref_doc_line ();
	$ordre = $this->new_line_order ($ref_doc_line_parent);
	
	//gestion du taux de tva
	if(isset($infos['tva']) && is_numeric($infos['tva'])){
		$article_taux_tva = $infos['tva'];
	}else{
		$article_taux_tva = $article->getTva();
		if (!$ASSUJETTI_TVA && ($this->ID_TYPE_DOC == $DEVIS_CLIENT_ID_TYPE_DOC || $this->ID_TYPE_DOC == $COMMANDE_CLIENT_ID_TYPE_DOC || $this->ID_TYPE_DOC == $LIVRAISON_CLIENT_ID_TYPE_DOC || $this->ID_TYPE_DOC == $FACTURE_FOURNISSEUR_ID_TYPE_DOC)) {$article_taux_tva = 0;}
		
		//mise à zéro du taux de tva si pays client != pays defaut (GESTION TVA INTERNATTIONNAL)
                if (isset($this->id_pays_contact)) {
                    if ( $this->id_pays_contact != $DEFAUT_ID_PAYS) {
                        $article_taux_tva = 0;
                    }
                }
	}

	
	//description courte
	$desc_courte = (isset($infos['desc_courte']) && is_string($infos['desc_courte']))? $infos['desc_courte'] : $article->getDesc_courte() ;
	$desc_courte =  addslashes(str_replace("¤", "€", $desc_courte ));
	
	
	// *************************************************
	// Insertion dans la base
	$query = "INSERT INTO docs_lines 
							(ref_doc_line, ref_doc, ref_article, lib_article, desc_article, qte, pu_ht, tva, ordre, 
							 ref_doc_line_parent, visible, pa_ht)
						VALUES ('".$ref_doc_line."', '".$this->ref_doc."', '".$article->getRef_article()."',
                                                                                '".addslashes(str_replace("¤", "€", $article->getLib_article()))."', '".addslashes(str_replace("¤", "€", $article->getDesc_courte()))."',
										'".$qte."', '".$pu_ht."', '".$article_taux_tva."', '".$ordre."', 
										".ref_or_null($ref_doc_line_parent).", '".$visible."', ".  num_or_null($pa_ht).") ";
	$bdd->exec ($query);
	/*
	$retour['type_of_line'] = "article";
	$retour['ref_doc_line'] = $ref_doc_line;
	$retour['ref_doc_line_parent'] = $ref_doc_line_parent;
	$retour['ref_article'] 	= $article->getRef_article();
	$retour['lib_article'] 	= $article->getLib_article();
	$retour['desc_article'] = $article->getDesc_courte();
	$retour['qte'] 					= $qte;
	$retour['pu_ht'] 				= $pu_ht;
	$retour['tva'] 					= $article->getTva();
	$retour['ordre'] 				= $ordre;
	$retour['visible'] 			= $visible; 
	*/

	// Numeros de sï¿½rie
	if (isset($infos['sn']) && is_array($infos['sn']) && $GESTION_SN && $this->GESTION_SN) {
		$inserted_sn = "";
		foreach ($infos['sn'] as $numero_serie) {
                        // Si numero de Lots
                        if ($article->getGestion_sn() == 2){
                            if ($inserted_sn) { $inserted_sn .= ","; }
                            $inserted_sn .= "('".$ref_doc_line."', '".addslashes($numero_serie["nl"])."','".addslashes($numero_serie["qte"])."')";
                        }else{
			if ($inserted_sn) { $inserted_sn .= ","; }
			$inserted_sn .= "('".$ref_doc_line."', '".addslashes($numero_serie)."',1)";
                        }
		}
		if ($inserted_sn) {
			$query = "INSERT INTO docs_lines_sn (ref_doc_line, numero_serie, sn_qte)
								VALUES ".$inserted_sn;
			$bdd->exec ($query);
		}
	}

	//ajout des informations supplementaire de ligne
	$this->add_line_article_info_supp ($ref_doc_line, $article->getRef_article());
	
	// *************************************************
	// Retour des informations
	$GLOBALS['_INFOS']['new_lines'][] = $this->charger_line ($ref_doc_line);

		// *************************************************
	// Taxes
	if (!$ref_doc_line_parent && $this->ID_TYPE_DOC != $INVENTAIRE_ID_TYPE_DOC) {
		$taxes = $article->getTaxes();
		foreach ($taxes as $taxe) {
			$t['code_taxe'] 		= $taxe->code_taxe;
			$t['lib_taxe'] 			= $taxe->lib_taxe;
			$t['montant_taxe'] 	= $taxe->montant_taxe;
			$t['visible'] 			= $taxe->visible;
			$t['qte'] = $qte;
			$t['tva'] = $article_taux_tva;
			$t['ref_doc_line_parent'] = $ref_doc_line;
			$this->add_line_taxe ($t);
		}
	}

		
	// *************************************************
	// composition
	if (!$ref_doc_line_parent && $article->getLot() == 2 && $this->ID_TYPE_DOC != $INVENTAIRE_ID_TYPE_DOC) {
		$composants = $article->getComposants();
		foreach ($composants as $composant) {
			$acomp['ref_article']		=	$composant->ref_article_composant;
			$acomp['qte']						=	$composant->qte * $qte;
			$acomp['visible'] 			= "1";
			$acomp['ref_doc_line_parent'] 	= $ref_doc_line;
			$this->add_line_article ($acomp);
		}
	}
	return true;
}

//fonction d'ajout des infos supp d'une ligne article
public function add_line_article_info_supp ($ref_doc_line, $ref_article) {
	global $bdd;
	return true;
}


// Ajoute une ligne d'information au document
protected function add_line_info ($infos) {
	global $bdd;
	global $DOC_LINE_ID_REFERENCE_TAG;

	// *************************************************
	// Réception des variables
	$titre_info 	= $infos['titre'];
	$texte_info 	= $infos['texte'];

	$visible = 1;
	if (isset($infos['visible'])) { $visible = $infos['visible'];};
	// *************************************************
	// Création de la référence et de l'ordre
	$ref_doc_line = $this->create_ref_doc_line ();
	$ordre = $this->new_line_order ();

	// *************************************************
	// Insertion dans la base
	$query = "INSERT INTO docs_lines 
							(ref_doc_line, ref_doc, ref_article, lib_article, desc_article, qte, pu_ht, tva, ordre, 
							 ref_doc_line_parent, visible)
						VALUES ('".$ref_doc_line."', '".$this->ref_doc."', 'INFORMATION', 
										'".addslashes($titre_info)."', '".addslashes($texte_info)."', 0, 0, 0, '".$ordre."', NULL, ".$visible.") ";
	$bdd->exec ($query);

	// *************************************************
	// Retour des informations
	$GLOBALS['_INFOS']['new_lines'][] = $this->charger_line ($ref_doc_line);
	
	/*
	$retour['type_of_line'] = "information";
	$retour['ref_doc_line'] = $ref_doc_line;
	$retour['ref_doc_line_parent'] = "";
	$retour['ref_article'] 	= "INFORMATION";
	$retour['lib_article'] 	= $titre_info;
	$retour['desc_article'] = $texte_info;
	$retour['qte'] 					= 0;
	$retour['pu_ht'] 				= 0;
	$retour['tva'] 					= 0;
	$retour['ordre'] 				= $ordre;
	$retour['visible'] 			= 1;
	*/
	
	return true;
}


// Ajoute une ligne de sous total
protected function add_line_ss_total () {
	global $bdd;

	// *************************************************
	// Création de la référence et de l'ordre
	$ref_doc_line = $this->create_ref_doc_line ();
	$ordre = $this->new_line_order ();

	// *************************************************
	// Insertion dans la base
	$query = "INSERT INTO docs_lines 
							(ref_doc_line, ref_doc, ref_article, lib_article, desc_article, qte, pu_ht, tva, ordre, 
							 ref_doc_line_parent, visible)
						VALUES ('".$ref_doc_line."', '".$this->ref_doc."', 'SSTOTAL', '', '', 0, 0, 0, '".$ordre."', NULL, 1) ";
	$bdd->exec ($query);

	// *************************************************
	// Retour des informations
	$GLOBALS['_INFOS']['new_lines'][] = $this->charger_line ($ref_doc_line);


	/*
	$retour['type_of_line'] = "soustotal";
	$retour['ref_doc_line'] = $ref_doc_line;
	$retour['ref_doc_line_parent'] = "";
	$retour['ref_article'] 	= "SSTOTAL";
	$retour['lib_article'] 	= "";
	$retour['desc_article'] = "";
	$retour['qte'] 					= 0;
	$retour['pu_ht'] 				= 0;
	$retour['tva'] 					= 0;
	$retour['ordre'] 				= $ordre;
	$retour['visible'] 			= 1;
	*/
	
	return true;
}


// Ajoute une ligne de taxe
protected function add_line_taxe ($infos) {
	global $bdd;
		global $TAXE_IN_PU;

	// *************************************************
	// Recuperation des informations sur la taxe

        //Si la taxe n'est pas comprise dans le prix unitaire
        if($TAXE_IN_PU == 0){
            $code_taxe 		= $infos['code_taxe'];
            $tva 		= $infos['tva'];
        }
        //Si la taxe est comprise dans le prix unitaire
        else if(!empty($TAXE_IN_PU) && $TAXE_IN_PU == 1)
        {
            $code_taxe 		= "TAXE ".$infos['code_taxe'];
            $tva 		= $infos['tva'];
        }
        $lib_taxe 		= $infos['lib_taxe'];
        $montant_taxe           = $infos['montant_taxe'];
        $qte                    = $infos['qte'];
	$ref_doc_line_parent 	= $infos['ref_doc_line_parent'];
	$visible 	= $infos['visible'];

	// *************************************************
	// Création de la référence et de l'ordre
	$ref_doc_line = $this->create_ref_doc_line ();
	$ordre = $this->new_line_order ($ref_doc_line_parent);

	// *************************************************
	// Insertion dans la base
	$query = "INSERT INTO docs_lines 
							(ref_doc_line, ref_doc, ref_article, lib_article, desc_article, qte, pu_ht, tva, ordre, 
							 ref_doc_line_parent, visible)
						VALUES ('".$ref_doc_line."', '".$this->ref_doc."', '".$code_taxe."', '".$lib_taxe."', '', 
										'".$qte."', '".$montant_taxe."', '".$tva."', '".$ordre."', '".$ref_doc_line_parent."', '".$visible."')";
	$bdd->exec ($query);

	// *************************************************
	// Retour des informations
	$GLOBALS['_INFOS']['new_lines'][] = $this->charger_line ($ref_doc_line);
	
	/*
	$retour['type_of_line'] = "taxe";
	$retour['ref_doc_line'] = $ref_doc_line;
	$retour['ref_doc_line_parent'] = $ref_doc_line_parent;
	$retour['ref_article'] 	= $code_taxe;
	$retour['lib_article'] 	= $lib_taxe;
	$retour['desc_article'] = "";
	$retour['qte'] 					= $qte;
	$retour['pu_ht'] 				= $montant_taxe;
	$retour['tva'] 					= $tva;
	$retour['ordre'] 				= $ordre;
	$retour['visible'] 			= $visible;
	*/

	return true;
}

//Savoir si c'est une taxe (suivant le lib_taxe)
public function is_taxe($lib_taxe)
{
    global $bdd;

    $query ="SELECT code_taxe FROM taxes WHERE lib_taxe=".$bdd->quote($lib_taxe)." ";
    $resultat = $bdd->query($query);
    $tmp = $resultat->fetchObject();
    if(!empty($tmp->code_taxe))
            return true;
    else
        return false;
}

// Créé la ref_doc_line pour une ligne de document
protected function create_ref_doc_line () {
	global $bdd;

	$DOC_LINE_ID_REFERENCE_TAG = 12;

	// *************************************************
	// Création de la référence
	$reference = new reference ($DOC_LINE_ID_REFERENCE_TAG);
	$ref_doc_line = $reference->generer_ref();

	return $ref_doc_line;
}

// Recherche l'ordre pour une nouvelle ligne
protected function new_line_order ($ref_doc_line_parent = "") {
	global $bdd;

        //Correction rapide ref_or_null renvoie une ref ou null ou is null
        if($ref_doc_line_parent==null)
        {
            $query = "SELECT MAX(ordre) ordre FROM docs_lines
						WHERE ref_doc = '".$this->ref_doc."' && ref_doc_line_parent IS NULL ";
        }
        else
        {
            $query = "SELECT MAX(ordre) ordre FROM docs_lines
						WHERE ref_doc = '".$this->ref_doc."' && ref_doc_line_parent ='".$ref_doc_line_parent."' ";
        }
	/*$query = "SELECT MAX(ordre) ordre FROM docs_lines
						WHERE ref_doc = '".$this->ref_doc."' && ref_doc_line_parent ".ref_or_null($ref_doc_line_parent, 1)." ";*/
	$resultat = $bdd->query($query);
	$tmp = $resultat->fetchObject();
	$ordre = $tmp->ordre+1;

	return $ordre;
}



// *************************************************************************************************************
// FONCTIONS DE MODIFICATION DU CONTENU
// *************************************************************************************************************
static public function maj_line_lib_article ($ref_doc_line, $new_lib_article) {
	global $bdd;

	$query = "UPDATE docs_lines SET lib_article = '".addslashes($new_lib_article)."'
						WHERE ref_doc_line = '".$ref_doc_line."' ";
	$bdd->exec ($query);

	/*
	if ($this->contenu_loaded) {
		for ($i=0; $i<count($this->contenu); $i++) {
			if ($ref_doc_line != $this->contenu[$i]->ref_doc_line) { continue; }
			$this->contenu[$i]->lib_article != $new_lib_article;
			break;
		}
	}
	*/
}


static public function maj_line_desc_article ($ref_doc_line, $new_desc_article) {
	global $bdd;
	
	$query = "UPDATE docs_lines SET desc_article = '".addslashes($new_desc_article)."'
						WHERE ref_doc_line = '".$ref_doc_line."' ";
	$bdd->exec ($query);

	/*
	if ($this->contenu_loaded) {
		for ($i=0; $i<count($this->contenu); $i++) {
			if ($ref_doc_line != $this->contenu[$i]->ref_doc_line) { continue; }
			$this->contenu[$i]->desc_article != $new_desc_article;
			break;
		}
	}
	*/
}


public function maj_line_qte ($ref_doc_line, $new_qte) {
	global $bdd;

	if (!$this->check_allow_maj_line_qte ()) { return false; }

	if (!is_numeric($new_qte)) { 
		$GLOBALS['_ALERTES']['bad_qte'] = 1;
		return false; 
	}
	
	$query = "UPDATE docs_lines SET qte = '".$new_qte."'
						WHERE ref_doc_line = '".$ref_doc_line."' ";
	$bdd->exec ($query);

	//on lance la fonction supprimant les numéros de série qui seraient en trop pour la ref_doc_line par rapport à la qté
	$this->del_unused_line_sn ($ref_doc_line, $new_qte);
	
	/*
	if ($this->contenu_loaded) {
		for ($i=0; $i<count($this->contenu); $i++) {
			if ($ref_doc_line != $this->contenu[$i]->ref_doc_line) { continue; }
			$this->contenu[$i]->new_qte != $new_qte;
			break;
		}
	}
	*/
	
	// On met à jour les lignes liées (taxe, composition, ...)
	$query = "UPDATE docs_lines SET qte = '".$new_qte."'
				WHERE ref_doc_line_parent = '".$ref_doc_line."' ";
	$bdd->exec ($query);
	$this->charger_contenu();
}

//mise à jour des ref_article_externe
public function maj_line_ref_article_externe ($ref_doc_line , $ref_article_externe, $old_ref_article_externe, $ref_article) {

}


protected function check_allow_maj_line_qte () {
	if ($this->quantite_locked) { return false;}
	return true;
}


public function maj_line_pu_ht ($ref_doc_line, $new_pu_ht) {
	global $bdd;
	
	if (!is_numeric($new_pu_ht)) { 
		$GLOBALS['_ALERTES']['bad_pu_ht'] = 1;
		return false;
	}

	$query = "UPDATE docs_lines SET pu_ht = '".$new_pu_ht."'
						WHERE ref_doc_line = '".$ref_doc_line."' ";
	$bdd->exec ($query); 

	/*
	if ($this->contenu_loaded) {
		for ($i=0; $i<count($this->contenu); $i++) {
			if ($ref_doc_line != $this->contenu[$i]->ref_doc_line) { continue; }
			$this->contenu[$i]->pu_ht != $new_pu_ht;
			break;
		}
	}
	*/
}


public function maj_line_remise ($ref_doc_line, $new_remise) {
	global $bdd;
	
	if (!is_numeric($new_remise)) { 
		$GLOBALS['_ALERTES']['bad_remise'] = 1;
		return false;
	}
	
	$query = "UPDATE docs_lines SET remise = '".$new_remise."'
						WHERE ref_doc_line = '".$ref_doc_line."' ";
	$bdd->exec ($query);

	/*
	if ($this->contenu_loaded) {
		for ($i=0; $i<count($this->contenu); $i++) {
			if ($ref_doc_line != $this->contenu[$i]->ref_doc_line) { continue; }
			$this->contenu[$i]->remise != $new_remise;
			break;
		}
	}
	*/
}


public function maj_line_tva ($ref_doc_line, $new_tva) {
	global $bdd;
	
	if (!is_numeric($new_tva)) { 
		$GLOBALS['_ALERTES']['bad_tva'] = 1;
		return false;
	}
	
	$query = "UPDATE docs_lines SET tva = '".$new_tva."'
						WHERE ref_doc_line = '".$ref_doc_line."' ";
	$bdd->exec ($query);

	/*
	if ($this->contenu_loaded) {
		for ($i=0; $i<count($this->contenu); $i++) {
			if ($ref_doc_line != $this->contenu[$i]->ref_doc_line) { continue; }
			$this->contenu[$i]->tva != $new_tva;
			break;
		}
	}
	*/
}
public function maj_line_pa_ht($ref_doc_line, $new_pa_ht) {
		global $bdd;

		$query = "UPDATE docs_lines SET pa_ht = '" . (float) $new_pa_ht . "', pa_forced = 1
 	                            WHERE ref_doc_line = '" . $ref_doc_line . "' ";
		$bdd->exec($query);
	}

public function set_line_visible ($ref_doc_line) {
	global $bdd;
	
	$query = "UPDATE docs_lines SET visible = 1
						WHERE ref_doc_line = '".$ref_doc_line."' ";
	$bdd->exec ($query);

	/*
	if ($this->contenu_loaded) {
		for ($i=0; $i<count($this->contenu); $i++) {
			if ($ref_doc_line != $this->contenu[$i]->ref_doc_line) { continue; }
			$this->contenu[$i]->visible != 1;
			break;
		}
	}
	*/
}
public function set_line_invisible ($ref_doc_line) {
	global $bdd;
	
	$query = "UPDATE docs_lines SET visible = 0
						WHERE ref_doc_line = '".$ref_doc_line."' ";
	$bdd->exec ($query);

	/*
	if ($this->contenu_loaded) {
		for ($i=0; $i<count($this->contenu); $i++) {
			if ($ref_doc_line != $this->contenu[$i]->ref_doc_line) { continue; }
			$this->contenu[$i]->visible != 0;
			break;
		}
	}
	*/
}


static public function maj_line_ordre ($ref_doc_line, $new_ordre) {
	global $bdd;

	if (!is_numeric($new_ordre)) {
		$GLOBALS['_ALERTES']['bad_ordre'] = 1;
	}
	
	// *************************************************
	// Si les valeurs reçues sont incorrectes
	if (count($GLOBALS['_ALERTES'])) {
		return false;
	}

	// Recherche de l'ordre et du document, et du parent actuel
	$query = "SELECT ref_doc, ref_doc_line_parent, ordre FROM docs_lines WHERE ref_doc_line = '".$ref_doc_line."' ";
	$resultat = $bdd->query ($query);
	$tmp = $resultat->fetchObject ();
	$ref_doc 							= $tmp->ref_doc;
	$ref_doc_line_parent 	= $tmp->ref_doc_line_parent;
	$ordre 								= $tmp->ordre;


	if ($new_ordre == $ordre) { return true; }
	elseif ($new_ordre < $ordre) {
		$variation = "+";
		$symbole1 = "<";
		$symbole2 = ">=";
	}
	else {
		$variation = "-";
		$symbole1 = ">";
		$symbole2 = "<=";
	}

	// *************************************************
	// MAJ de la BDD
	$bdd->beginTransaction();
	
	// Mise à jour des autres lignes
	$query = "UPDATE docs_lines
						SET ordre = ordre ".$variation." 1
						WHERE ref_doc = '".$ref_doc."' && ref_doc_line_parent ".ref_or_null($ref_doc_line_parent, 1)." && 
									ordre ".$symbole1." '".$ordre."' && ordre ".$symbole2." '".$new_ordre."' ";
	$bdd->exec ($query);

	// Mise à jour de cette ligne
	$query = "UPDATE docs_lines
						SET ordre = '".$new_ordre."'
						WHERE ref_doc_line = '".$ref_doc_line."'  ";
	$bdd->exec ($query);

	$bdd->commit();	


	// *************************************************
	// Résultat positif de la modification
	return true;
}


// Mise à jour de l'information "qte_livree" d'une ligne de document
static function maj_line_infos_supp ($ref_doc_line, $table, $maj_donnees=NULL) {
	global $bdd;

	$query = "UPDATE ".$table." 
						SET ".$maj_donnees."
						WHERE ref_doc_line = '".addslashes($ref_doc_line)."' ";
	$bdd->exec ($query);
}

// retourne la ref_article d'une ref_doc_line
public function return_infos_from_ref_doc_line ($ref_doc_line) {
	global $bdd;

	$infos_doc_line = "";
	$query = "SELECT ref_article , qte
						FROM docs_lines dl
						WHERE ref_doc_line = '".$ref_doc_line."'";
	$resultat = $bdd->query ($query);
	if ($tmp = $resultat->fetchObject()) {$infos_doc_line = $tmp;}
	
	return $infos_doc_line;
}

// Ajoute un numéro de série à une ligne
public function add_line_sn ($ref_doc_line, $numero_serie) {
	global $bdd;

	// *************************************************
	// Vérification du numéro de série
	$numero_serie = trim ($numero_serie);
	if (!$numero_serie) { return false; }

	$sn_exist = 0;
	$query = "SELECT numero_serie 
						FROM stocks_articles_sn sas
						WHERE sas.numero_serie = '".addslashes($numero_serie)."'";
	$resultat = $bdd->query ($query);
	if ($tmp = $resultat->fetchObject()) {
		$sn_exist = 1;
	}

	// *************************************************
	// Insertion
	$query = "INSERT INTO docs_lines_sn (ref_doc_line, numero_serie)
						VALUES ('".addslashes($ref_doc_line)."', '".addslashes($numero_serie)."') ";
	$bdd->exec ($query);

	$GLOBALS['_INFOS']['sn'] = $numero_serie;
	$GLOBALS['_INFOS']['sn_exist'] = $sn_exist;
	return true;
}


// Supprimer un numéro de série à une ligne
static function del_line_sn ($ref_doc_line, $numero_serie) {
	global $bdd;

	$numero_serie = trim ($numero_serie);
	if (!$numero_serie) { return false; }

	// *************************************************
	// Suppression
	$query = "DELETE FROM docs_lines_sn 
						WHERE ref_doc_line = '".addslashes($ref_doc_line)."' && numero_serie = '".addslashes($numero_serie)."' 
						LIMIT 1";
	$bdd->exec ($query);

	return true;
}


// Supprimer un numéro de lot à une ligne
static function del_line_nl ($ref_doc_line, $numero_lot, $qte_lot) {
	global $bdd;

	$numero_lot = trim ($numero_lot);
	if (!$numero_lot) { return false; }

	// *************************************************
	// Suppression
	$query = "DELETE FROM docs_lines_sn 
						WHERE ref_doc_line = '".addslashes($ref_doc_line)."' && numero_serie = '".addslashes($numero_lot)."' 
						LIMIT ".$qte_lot;
	$bdd->exec ($query);

	return true;
}


//fonction supprimant les numéros de série suppérieurs à la quantité indiquée dans la ref_doc_line
static function del_unused_line_sn ($ref_doc_line, $qte) {
	global $bdd;


	$doc_line_sn = array();

	$query = "SELECT dls.ref_doc_line, dls.numero_serie 
						FROM docs_lines_sn dls 
						WHERE dls.ref_doc_line = '".$ref_doc_line."' ";
	$resultat = $bdd->query ($query);
	$i = 1;
	while ($sn = $resultat->fetchObject()) { 
		if ($i > $qte) {
			$query = "DELETE FROM docs_lines_sn 
								WHERE ref_doc_line = '".addslashes($sn->ref_doc_line)."' && numero_serie = '".addslashes($sn->numero_serie)."' 
								LIMIT 1";
			$bdd->exec ($query);
		}
		$i++;
	}
}


// Supprimer un numéro de série à une ligne
static function maj_line_sn ($ref_doc_line, $old_sn, $new_sn) {
	global $bdd;

	$numero_serie = trim ($new_sn);
	if (!$numero_serie) { return false; }

	$sn_exist = 0;
	$query = "SELECT numero_serie 
						FROM stocks_articles_sn sas
						WHERE sas.numero_serie = '".addslashes($numero_serie)."'";
	$resultat = $bdd->query ($query);
	if ($tmp = $resultat->fetchObject()) {
		$sn_exist = 1;
	}

	// *************************************************
	// MAJ
	$query = "UPDATE docs_lines_sn SET numero_serie = '".addslashes($numero_serie)."'
						WHERE ref_doc_line = '".addslashes($ref_doc_line)."' && numero_serie = '".addslashes($old_sn)."' 
						LIMIT 1";
	$bdd->exec ($query);

	$GLOBALS['_INFOS']['sn'] = $numero_serie;
	$GLOBALS['_INFOS']['sn_exist'] = $sn_exist;
	return true;
}


// Supprimer un numéro de série à une ligne
static function maj_line_nl ($ref_doc_line, $old_nl, $new_nl, $old_qte_nl, $new_qte_nl) {
	global $bdd;

	$numero_serie = trim ($new_nl);
	if (!$numero_serie) { return false; }
	if (!$new_qte_nl ||!is_numeric($new_qte_nl)) { return false; }

	$sn_exist = 0;
	
	if ($old_qte_nl && is_numeric($old_qte_nl)) {  
		$query = "DELETE FROM docs_lines_sn
							WHERE ref_doc_line = '".addslashes($ref_doc_line)."' && numero_serie = '".addslashes($old_nl)."' 
							";
		$bdd->exec ($query);
	}
	// *************************************************
	// MAJ
	$query = "INSERT INTO docs_lines_sn (ref_doc_line, numero_serie, sn_qte)
						VALUES ";
//	for ($i=0; $i< $new_qte_nl; $i++) {
//		if ($i) { $query .= " , "; }
		$query .= " ('".addslashes($ref_doc_line)."', '".addslashes($numero_serie)."', '".addslashes($new_qte_nl)."') ";
//	}
	$bdd->exec ($query);

	$GLOBALS['_INFOS']['sn'] = $numero_serie;
	$GLOBALS['_INFOS']['sn_exist'] = $sn_exist;
	return true;
}





// *************************************************************************************************************
// FONCTIONS DE GESTION DES ACTIONS MULTIPLES
// *************************************************************************************************************

// Génère une liste (MySQL) pour les fonctions de gestion du contenu
static function get_liste_of_lines ($lines) {
	if (!count($lines)) { return false; }

	// Création d'une liste à partir du tableau des lignes
	$liste_lines = "";
	foreach ($lines as $line) {
		if ($liste_lines) { $liste_lines .= ","; }
		$liste_lines .= "'".$line."'";
	}

	return $liste_lines;
}


// Supprime plusieurs lignes de contenu
public function delete_multiples_lines ($lines) {
	global $bdd;

	if (!$liste_lines = $this->get_liste_of_lines ($lines)) { return false; }

	// Suppression dans la BDD
	$query = "DELETE FROM docs_lines WHERE ref_doc_line IN (".$liste_lines.") ";
	$bdd->exec ($query);

	return true;
}


// Reset le prix unitaire d'une ligne
public function reset_pu_ht ($lines) {
	global $bdd;

	if (!$liste_lines = $this->get_liste_of_lines ($lines)) { return false; }

	// Sélection de la ref_article et de la qté pour ces lignes
	$query = "SELECT ref_doc_line, ref_article, qte FROM docs_lines
						WHERE ref_doc_line IN (".$liste_lines.") ";
	$resultat = $bdd->query ($query);
	while ($tmp = $resultat->fetchObject()) {
		if (define_type_of_line ($tmp->ref_article) != "article") {continue;}
		// Sélection des caractéristiques de l'article
		$article = new article ($tmp->ref_article);
		$new_pu_ht = $this->select_article_pu ($article, $tmp->qte);
		$this->maj_line_pu_ht ($tmp->ref_doc_line, $new_pu_ht);
	}
	
	return true;
}

// Reset le prix unitaire d'une ligne en spécifiant un id_tarif
public function set_pu_ht_to_id_tarif ($lines, $id_tarif) {
	global $bdd;

	if (!$liste_lines = $this->get_liste_of_lines ($lines)) { return false; }

	// Sélection de la ref_article et de la qté pour ces lignes
	$query = "SELECT ref_doc_line, ref_article, qte FROM docs_lines
						WHERE ref_doc_line IN (".$liste_lines.") ";
	$resultat = $bdd->query ($query);
	while ($tmp = $resultat->fetchObject()) {
		if (define_type_of_line ($tmp->ref_article) != "article") {continue;}
		// Sélection des caractéristiques de l'article
		$article = new article ($tmp->ref_article);
		// Sélection du tarif applicable
		$query = "SELECT pu_ht, indice_qte
							FROM articles_tarifs
							WHERE ref_article = '".$article->getRef_article()."' && id_tarif = '".$id_tarif."' 
							ORDER BY indice_qte DESC";
		$resultat2 = $bdd->query($query);
		$pu_ht = 0;
		while ($tmp2 = $resultat2->fetchObject()) {
			$pu_ht = $tmp2->pu_ht;
			if ($tmp->qte >= $tmp2->indice_qte) { break; }
		}
		$new_pu_ht = $pu_ht;
		
		$this->maj_line_pu_ht ($tmp->ref_doc_line, $new_pu_ht);
	}
	
	return true;
}




// *************************************************************************************************************
// FONCTIONS DE GESTION DES PRIX
// *************************************************************************************************************

// Selectionne le prix unitaire d'un article pour le document
public function select_article_pu ($article, $qte) {
	
	if(!$prix_cotation = $this->select_article_pcotation($article, $qte)){	
		if (isset($this->PU_FROM) && $this->PU_FROM == "PA") {
			return $this->select_article_pa($article);
		}
		else {
			return $this->select_article_pv($article, $qte);
		}
	}else{
		return $prix_cotation;
	}
}


// Sélection du prix d'achat pour cet article
protected function select_article_pa ($article) {
	$pu = $article->getPrix_achat_ht();
	return $pu;
}


// Sélection du prix de vente adapté au contact
protected function select_article_pv ($article, $qte) {
	global $bdd;

	// Tarif par défaut pour le magasin en cours
	$id_tarif = $_SESSION['magasin']->getId_tarif();
	$pu_ht = 0;

	// Sélection de la grille tarifaire particulière à ce client, si définie
	if ($this->ref_contact) {
            $query = "SELECT id_tarif, id_client_categ FROM annu_client
                                                    WHERE ref_contact = '".$this->ref_contact."' ";
            $resultat = $bdd->query($query);
            $tmp = $resultat->fetchObject();
            if (isset($tmp->id_tarif) && $tmp->id_tarif) {
                $id_tarif = $tmp->id_tarif;
            }else{
                $query = "SELECT id_tarif FROM clients_categories
                                                        WHERE id_client_categ = '".$tmp->id_client_categ."' ";
                $resultat = $bdd->query($query);
                $tmp = $resultat->fetchObject();
                if (!is_null($tmp->id_tarif)){
                    $id_tarif = $tmp->id_tarif;
                }
            }
	}

	// Sélection du tarif applicable
	$query = "SELECT pu_ht, indice_qte
						FROM articles_tarifs
						WHERE ref_article = '".$article->getRef_article()."' && id_tarif = '".$id_tarif."' 
						ORDER BY indice_qte DESC";
	$resultat = $bdd->query($query);
	while ($tmp = $resultat->fetchObject()) {
		$pu_ht = $tmp->pu_ht;
		if ($qte >= $tmp->indice_qte) { break; }
	}

	return $pu_ht;
}

// Sélection du prix de vente adapté au contact
public function select_article_pcotation ($article, $qte) {
	global $bdd;
	global $USE_COTATIONS;
	
	if($USE_COTATIONS){
		// Tarif par défaut pour le magasin en cours
		$id_tarif = $_SESSION['magasin']->getId_tarif();
		$cotation_ok = false;
		$pu_ht = 0;

		$query = "SELECT ref_contact,id_type_doc,id_etat_doc,ref_article,qte,pu_ht,date_creation_doc,date_echeance
							FROM documents d
							RIGHT JOIN docs_lines dl ON d.ref_doc = dl.ref_doc
							RIGHT JOIN doc_cot dc ON d.ref_doc = dc.ref_doc
							WHERE date_echeance>= CURDATE() AND id_type_doc=16 AND id_etat_doc=64 AND d.ref_contact = '".$this->ref_contact."' AND ref_article = '".$article->getRef_article()."'
							ORDER BY ref_article ASC, qte DESC, date_creation_doc DESC; ";	
		$resultat = $bdd->query($query);
		while ($tmp = $resultat->fetchObject()) {
			echo "$qte:".$tmp->qte."-".$tmp->pu_ht."<BR>";
			if ($qte >= $tmp->qte) { 
				$pu_ht = $tmp->pu_ht;
				$cotation_ok = true;
				break; 
			}
		}
		if ($cotation_ok){
			return $pu_ht;
		}else{
			return false;
		}
	}	else{return false;}
}

// Selection du prix de vente adaptï¿½ au contact
public function select_infos_article_pcotation ($article, $qte) {
	global $bdd;
	global $USE_COTATIONS;

	if($USE_COTATIONS){
		// Tarif par dï¿½faut pour le magasin en cours
		$id_tarif = $_SESSION['magasin']->getId_tarif();
		$cotation_ok = false;
		$pu_ht = 0;

		$query = "SELECT ref_contact,id_type_doc,id_etat_doc,remise,ref_article,qte,pu_ht,date_creation_doc,date_echeance
							FROM documents d
							RIGHT JOIN docs_lines dl ON d.ref_doc = dl.ref_doc
							RIGHT JOIN doc_cot dc ON d.ref_doc = dc.ref_doc
							WHERE date_echeance>= CURDATE() AND id_type_doc=16 AND id_etat_doc=64
                                                                AND d.ref_contact = '".$this->ref_contact."' AND ref_article = '".$article->getRef_article()."'
							ORDER BY ref_article ASC, qte DESC, date_creation_doc DESC; ";
		$resultat = $bdd->query($query);
		while ($tmp = $resultat->fetchObject()) {
			echo "$qte:".$tmp->qte."-".$tmp->pu_ht."<BR>";
			if ($qte >= $tmp->qte) {
                            $cotation_article = $tmp;
				$cotation_ok = true;
				break;
			}
		}
                if(!empty($cotation_article))
                    return $cotation_article;
                else
                    return false;

	}	else{return false;}
}

// *************************************************************************************************************
// FONCTIONS DE GESTION DES EVENNEMENTS 
// *************************************************************************************************************
protected function charger_events() {
	global $bdd;
	
	$this->events = array();
 	$query = "SELECT de.ref_doc_event, date_event, de.id_event_type, det.lib_event_type, de.event, de.ref_user, u.pseudo
						FROM documents_events de
							LEFT JOIN documents_events_types det ON de.id_event_type = det.id_event_type
							LEFT JOIN users u ON de.ref_user = u.ref_user
						WHERE ref_doc = '".$this->ref_doc."'
						ORDER BY date_event ASC ";
	$resultat = $bdd->query($query);
	while ($tmp = $resultat->fetchObject()) { $this->events[] = $tmp; }

	$this->events_loaded = true;

	return true;
}


// Ajoute un évennement
protected function add_event($id_event_type, $event = "") {
	global $bdd;

	$DOC_EVENT_ID_REFERENCE_TAG = 13;
	
	// *************************************************
	// Controles
	if (!is_numeric($id_event_type)) {
		$GLOBALS['_ALERTES']['bad_id_event_type'] = 1;
	}
	
	if (count($GLOBALS['_ALERTES'])) { return false; }

	if (!$_SESSION['user']->getRef_user()) { return false; }
	
	// *************************************************
	// Création de la référence
	$reference = new reference ($DOC_EVENT_ID_REFERENCE_TAG);
	$ref_doc_event = $reference->generer_ref();

	// *************************************************
	// Insertion dans la BDD
	$query = "INSERT INTO documents_events (ref_doc_event, ref_doc, date_event, id_event_type, event, ref_user)
						VALUES ('".$ref_doc_event."', '".$this->ref_doc."', NOW(), 
										'".$id_event_type."', '".addslashes($event)."', '".$_SESSION['user']->getRef_user()."') ";
	$bdd->exec ($query);

	if ($this->events_loaded) {
		$this->events_loaded = false;
	}

	return true;	
}


// Modifie un évennement
protected function maj_event ($ref_doc_event, $date_event, $id_event_type, $event) {
	global $bdd;
	
	// *************************************************
	// Controles
	if (!is_numeric($id_event_type)) {
		$GLOBALS['_ALERTES']['bad_id_event_type'] = 1;
	}

	if (count($GLOBALS['_ALERTES'])) { return false; }

	// *************************************************
	// Insertion dans la BDD
	$query = "UPDATE documents_events 
						SET date_event = '".$date_event."', id_event_type = '".$id_event_type."', event = '".addslashes($event)."'
						WHERE ref_doc_event = '".$ref_doc_event."' ";
	$bdd->exec ($query);

	if ($this->events_loaded) {
		$this->events_loaded = false;
	}
	
	return true;
}


// Supprime un évennement
protected function del_event ($ref_doc_event) {
	global $bdd;

	// *************************************************
	// Controles
	$query = "SELECT id_event_type FROM documents_events 
						WHERE ref_doc_event = '".$ref_doc_event."' ";
	$resultat = $bdd->query($query);
	$tmp = $resultat->fetchObject();
	if ($tmp->id_event_type == 1) {
		$GLOBALS['_ALERTES']['event_creation'] = 1;
	}
	
	if (count($GLOBALS['_ALERTES'])) { return false; }
	
	// *************************************************
	// Action dans la BDD
	$query = "DELETE FROM documents_event 
						WHERE ref_doc_event = '".$ref_doc_event."' ";
	$bdd->exec ($query);

	if ($this->events_loaded) {
		$this->events_loaded = false;
	}
	
	return true;
}


public function maj_date_creation ($new_date_creation) {
	global $bdd;

	$query = "SELECT ref_doc, date_creation_doc
						FROM documents 
						WHERE ref_doc = '".$this->ref_doc."' ";
	$resultat = $bdd->query ($query);
	if (!$creation = $resultat->fetchObject()) {
		return false;
	}

	// *************************************************
	// Mise à jour et création d'un évennement de controle
	$bdd->beginTransaction();

	$query = "UPDATE documents
						SET date_creation_doc = '".$new_date_creation."'
						WHERE ref_doc = '".$creation->ref_doc."' ";
	$bdd->exec ($query);
	
	$this->add_event(4, "Changement de la date de creation au : ".date_Us_to_Fr ($new_date_creation));

	$bdd->commit();

	$this->date_creation = $new_date_creation;
	return true;
}

// Met à jour le code_affaire
public function maj_code_affaire ($code_affaire) {
	global $bdd;	

	$this->code_affaire = $code_affaire;

	// *************************************************
	// MAJ de la base
	$query = "UPDATE documents 
						SET code_affaire = '".addslashes($this->code_affaire)."'
						WHERE ref_doc = '".$this->ref_doc."' ";
	$bdd->exec ($query);
	
	return true;
}

// *************************************************************************************************************
// FONCTIONS LIEES A L'EDITION D'UN DOCUMENT 
// *************************************************************************************************************

// Edition
protected function edit_doc ($id_edition_mode, $infos) {
	global $bdd;

	// *************************************************
	// Réception des informations spécifiques afin de réaliser l'édition
	switch ($id_edition_mode) {
		case "1": // IMPRESSION
		
		break;
	}

	if (count($GLOBALS['_ALERTES'])) { return false; }


	// *************************************************
	// Enregistrement dans la BDD
	$query = "INSERT INTO documents_editions (ref_doc, id_edition_mode, information, date_edition, ref_user)
						VALUES ('".$this->ref_doc."', '".$id_edition_mode."', '".$infos."', NOW(), '".$this->ref_user."') ";
	$bdd->exec ($query);

	return true;
}



// *************************************************************************************************************
// FONCTIONS DE LIAISON ENTRE DOCUMENTS 
// *************************************************************************************************************
// Chargement des documents liés
public function charger_liaisons () {
	global $bdd;

	$this->liaisons = self::charger_liaisons_doc($this->ref_doc);

	$this->liaisons_loaded = true;
	
	return true;
}

public static function charger_liaisons_doc ($ref_doc) {
	global $bdd;

	$ref_doc = ref_or_null($ref_doc);
	$liaisons = array ( 'source' => array(), 'dest' => array() );
	
	$query = "SELECT ref_doc_source, dl.active, d.id_type_doc, dt.lib_type_doc, d.id_etat_doc, de.lib_etat_doc,
									 d.date_creation_doc date_creation
						FROM documents_liaisons dl
							LEFT JOIN documents d ON d.ref_doc = dl.ref_doc_source 
							LEFT JOIN documents_types dt ON d.id_type_doc = dt.id_type_doc 
							LEFT JOIN documents_etats de ON d.id_etat_doc = de.id_etat_doc 
						WHERE ref_doc_destination = ".$ref_doc." 
						GROUP BY ref_doc_source 
						ORDER BY date_creation ";
	$resultat = $bdd->query($query);
	while ($tmp = $resultat->fetchObject()) { $liaisons['source'][] = $tmp; }

	$query = "SELECT ref_doc_destination, dl.active, d.id_type_doc, dt.lib_type_doc, d.id_etat_doc, de.lib_etat_doc,
									 d.date_creation_doc date_creation
						FROM documents_liaisons dl
							LEFT JOIN documents d ON d.ref_doc = dl.ref_doc_destination 
							LEFT JOIN documents_types dt ON d.id_type_doc = dt.id_type_doc 
							LEFT JOIN documents_etats de ON d.id_etat_doc = de.id_etat_doc 
						WHERE ref_doc_source = ".$ref_doc." 
						GROUP BY ref_doc_destination 
						ORDER BY date_creation";
	$resultat = $bdd->query($query);
	while ($tmp = $resultat->fetchObject()) { $liaisons['dest'][] = $tmp; }
	
	return $liaisons;
}


// Chargement des documents à lier potentiellement
public function charger_liaisons_possibles () { 
	$this->liaisons_possibles = array();
	$this->liaisons_possibles_loaded = true;
}


// Lie un document à celui-ci
public function link_to_doc ($ref_doc) {
	global $bdd;
	
	$query = "INSERT INTO documents_liaisons (ref_doc_source, ref_doc_destination)
						VALUES ('".$this->ref_doc."', '".$ref_doc."') ";
	$bdd->exec ($query);

	return true;
}


// Lie ce document à un autre, en reprennant son contenu
public function link_from_doc ($ref_doc_source) {
	global $bdd;

	// Liaison
	$query = "INSERT INTO documents_liaisons (ref_doc_source, ref_doc_destination)
						VALUES ('".$ref_doc_source."', '".$this->ref_doc."') ";
	$bdd->exec ($query);

	// Ouverture du document source
	$doc_source = open_doc ($ref_doc_source);

	// Ligne d'information
	$this->create_info_copie_line($doc_source);

	// Copie du contenu
	$doc_source_contenu = $doc_source->getContenu();
	for ($i=0; $i<count($doc_source_contenu); $i++) {
		$new_ref_doc_line = $doc_source->copie_line_to_doc ($this, $doc_source_contenu[$i]);
		if (!$new_ref_doc_line) { continue; }
		//$GLOBALS['_INFOS']['new_lines'][] = $this->charger_line ($new_ref_doc_line);
	}

	// *************************************************
	// Copie des règlements
	$doc_source->charger_reglements();
	foreach ($doc_source->reglements as $reglement) {
		$query = "SELECT ref_reglement,ref_doc,montant
							FROM reglements_docs
							WHERE liaison_valide=1 && ref_reglement='".$reglement->ref_reglement."' && ref_doc='".$this->ref_doc."'";
		$resultat = $bdd->query($query);
		if($reg_exist = $resultat->fetchObject()){
			$montant = $reg_exist->montant+$reglement->montant_on_doc;
			$query = "UPDATE reglements_docs
								SET montant = ".$montant."
								WHERE liaison_valide=1 && ref_reglement='".$reglement->ref_reglement."' && ref_doc='".$this->ref_doc."'";
			$bdd->exec ($query);
		}else{		
		$query = "INSERT INTO reglements_docs (ref_reglement, ref_doc, montant)
							VALUES ('".$reglement->ref_reglement."', '".$this->ref_doc."', '".$reglement->montant_on_doc."')";
		$bdd->exec ($query);
		}
		$query = "UPDATE reglements_docs 
							SET liaison_valide=0
							WHERE ref_reglement='".$reglement->ref_reglement."' && ref_doc='".$doc_source->ref_doc."'";
		$bdd->exec ($query);
	}
	if ($this->reglements_loaded) { 
		$this->reglements_loaded = false; 
	}
	return true;
}


// Lie ce document à un autre, en definisant l'etat de la liaison
public function link_from_doc_set_active ($ref_doc_source, $active = 1) {
	global $bdd;

	// Liaison
	$query = "INSERT INTO documents_liaisons (ref_doc_source, ref_doc_destination, active)
						VALUES ('".$ref_doc_source."', '".$this->ref_doc."', '".$active."') ";
	$bdd->exec ($query);

	return true;
}

// Supprime une liaison
public function break_liaison ($ref_doc) {
	global $bdd;

	// *************************************************
	// Controle de la possibilité de rompre une liaison

	// *************************************************
	// Action avant la rupture de la liaison
	$this->action_before_break_liaison ($ref_doc);

	// Suppression dans la BDD
	$query = "DELETE FROM documents_liaisons 
						WHERE (ref_doc_source = '".$this->ref_doc."' && ref_doc_destination = '".$ref_doc."') || 
									(ref_doc_source = '".$ref_doc."' && ref_doc_destination = '".$this->ref_doc."')  ";
	$bdd->exec ($query);

	if ($this->liaisons_loaded) { 
		$this->liaisons_loaded = false; 
	}

	return true;
}

// Actions spécifiques en cas de rupture d'une liaison
protected function action_before_break_liaison ($ref_doc) {}



// *************************************************************************************************************
// FONCTIONS DIVERSES 
// *************************************************************************************************************

// PROFILS DE CONTACT NECESSAIRE POUR UTILISER CE TYPE DE DOCUMENT
protected function check_profils () {
	return true;
}


protected function check_profil_client () {
	global $CLIENT_ID_PROFIL;
	if (!isset($_SESSION['profils'][$CLIENT_ID_PROFIL])) {
		$erreur = "L'utilisation du document de type ".$this->lib_type_doc." nécessite le profil CLIENT actif";
		alerte_dev ($erreur);
	}
	return true;
}


protected function check_profil_fournisseur () {
	global $FOURNISSEUR_ID_PROFIL;
	if (!isset($_SESSION['profils'][$FOURNISSEUR_ID_PROFIL])) {
		$erreur = "L'utilisation du document de type ".$this->lib_type_doc." nécessite le profil FOURNISSEUR actif";
		alerte_dev ($erreur);
	}
	return true;
}


// *************************************************************************************************************
// FONCTIONS DE RECOPIE D'UN DOCUMENT
// *************************************************************************************************************
// Recopie un document
protected function copie_doc ($id_type_doc) {
	global $bdd;

	// *************************************************
	// Options de copie d'un document
	if (!isset($GLOBALS['_OPTIONS']['CREATE_DOC']['ref_contact'])) {
		$GLOBALS['_OPTIONS']['CREATE_DOC']['ref_contact'] = $this->ref_contact;
	}
	if (!isset($GLOBALS['_OPTIONS']['CREATE_DOC']['nom_contact'])) {
		$GLOBALS['_OPTIONS']['CREATE_DOC']['nom_contact'] = $this->nom_contact;
	}
	if (!isset($GLOBALS['_OPTIONS']['CREATE_DOC']['ref_adr_contact'])) {
		$GLOBALS['_OPTIONS']['CREATE_DOC']['ref_adr_contact'] = $this->ref_adr_contact;
	}
	if (!isset($GLOBALS['_OPTIONS']['CREATE_DOC']['adresse_contact'])) {
		$GLOBALS['_OPTIONS']['CREATE_DOC']['adresse_contact'] = $this->adresse_contact;
	}
	if (!isset($GLOBALS['_OPTIONS']['CREATE_DOC']['code_postal_contact'])) {
		$GLOBALS['_OPTIONS']['CREATE_DOC']['code_postal_contact'] = $this->code_postal_contact;
	}
	if (!isset($GLOBALS['_OPTIONS']['CREATE_DOC']['ville_contact'])) {
		$GLOBALS['_OPTIONS']['CREATE_DOC']['ville_contact'] = $this->ville_contact;
	}
	if (!isset($GLOBALS['_OPTIONS']['CREATE_DOC']['id_pays_contact'])) {
		$GLOBALS['_OPTIONS']['CREATE_DOC']['id_pays_contact'] = $this->id_pays_contact;
	}
	if (!isset($GLOBALS['_OPTIONS']['CREATE_DOC']['app_tarifs'])) {
		$GLOBALS['_OPTIONS']['CREATE_DOC']['app_tarifs'] = $this->app_tarifs;
	}
	if (isset($GLOBALS['_OPTIONS']['CREATE_DOC']['code_affaire'])) {
		$this->code_affaire = $GLOBALS['_OPTIONS']['CREATE_DOC']['code_affaire'];
	}	
	
	// *************************************************
	// Création du nouveau document
	$doc_cible = create_doc ($id_type_doc);

	// *************************************************
	// Liaison entre les documents
	$this->link_to_doc ($doc_cible->getRef_doc());

	// Ligne d'information
	if (isset($GLOBALS['_OPTIONS']['CREATE_DOC']['info_line'])) {
		$doc_cible->create_info_copie_line($this);
	}
	if (isset($GLOBALS['_OPTIONS']['CREATE_DOC']['info_line_cdc'])) {
		$doc_cible->create_info_copie_line_cdc($this);
	}
	if (isset($GLOBALS['_OPTIONS']['CREATE_DOC']['info_line_pac'])) {
		$doc_cible->create_info_copie_line_pac($this);
	}
        if (isset($GLOBALS['_OPTIONS']['CREATE_DOC']['follow_commerciaux'])) {
            $commerciaux_doc = $this->getCommerciaux();
            if(!empty($commerciaux_doc)){
                $doc_cible->attribution_commercial($commerciaux_doc);
            }
            unset($commerciaux_doc);
        }

	// *************************************************
	// Copie du Contenu
	$this->copie_content ($doc_cible);

	// *************************************************
	// Copie des règlements
	if (isset($GLOBALS['_OPTIONS']['CREATE_DOC']['follow_reglement'])) {
		$this->charger_reglements();
		foreach ($this->reglements as $reglement) {
				// Création d'une liaison entre le document cible et ces règlements
//				if($reglement->montant_on_doc > $this->getMontant_ttc()){
//					$tmp_montant = $this->getMontant_ttc();
//				}else{
//					$tmp_montant = $reglement->montant_on_doc;
//				}
				$tmp_montant = $reglement->montant_on_doc;
				$query = "INSERT INTO reglements_docs (ref_reglement, ref_doc, montant)
									VALUES ('".$reglement->ref_reglement."', '".$doc_cible->getRef_doc()."', '".$tmp_montant."')";
				$bdd->exec ($query);
				// Invalidation de la liaison entre ces règlements et le document source (pour ne le comptabiliser qu'une seule fois)
				$query = "UPDATE reglements_docs SET liaison_valide = 0 
									WHERE ref_reglement = '".$reglement->ref_reglement."' && ref_doc = '".$this->ref_doc."' ";
				$bdd->exec ($query);
		}
	}

	// *************************************************
	// Copie de l' Echeancier
	if (!($this->echeancier instanceof document_echeancier)) { $this->echeancier = new document_echeancier($this->getRef_doc(),$this); }
	$this->echeancier->copie_to_doc($doc_cible->getRef_doc());
	
	// *************************************************
	// Evennement de création
	$this->add_event(3, $doc_cible->getLIB_TYPE_DOCUMENT()." - Ref. ".$doc_cible->getRef_doc());
	$doc_cible->check_after_creation ();

	if (isset($GLOBALS['_OPTIONS']['CREATE_DOC']['maj_etat_copie_doc'])) {
		$doc_cible->maj_etat_doc($GLOBALS['_OPTIONS']['CREATE_DOC']['maj_etat_copie_doc']);
	}
	$GLOBALS['_INFOS']['ref_doc_copie'] = $doc_cible->getRef_doc();
	return true;
}


protected function check_after_creation () {}


public function copie_content ($doc_cible) {
	// Chargement du contenu
	if (!$this->contenu_loaded) { $this->charger_contenu(); }

	// *************************************************
	// Si l'élément "doc_lines" n'est pas défini, la copie porte sur l'ensemble du contenu.
	if (!isset($GLOBALS['_OPTIONS']['CREATE_DOC']['doc_lines']) || !is_array($GLOBALS['_OPTIONS']['CREATE_DOC']['doc_lines'])) {
		$GLOBALS['_OPTIONS']['CREATE_DOC']['doc_lines'] = array();
		for ($i=0; $i<count($this->contenu); $i++) { 
			$GLOBALS['_OPTIONS']['CREATE_DOC']['doc_lines'][] = $this->contenu[$i]->ref_doc_line;
		}
	}

	for ($i=0; $i<count($this->contenu); $i++) {
		if (!in_array($this->contenu[$i]->ref_doc_line, $GLOBALS['_OPTIONS']['CREATE_DOC']['doc_lines']) && !in_array($this->contenu[$i]->ref_doc_line_parent, $GLOBALS['_OPTIONS']['CREATE_DOC']['doc_lines'])) { continue; }
		$this->copie_line_to_doc ($doc_cible, $this->contenu[$i]);
	}
}


public function create_info_copie_line ($doc_source) {
	$infos['type_of_line'] = "information";
	$infos['titre'] = $doc_source->getRef_doc()." du ".date_Us_to_Fr ($doc_source->getDate_creation());
	$infos['texte'] = $this->create_info_copie_line_texte ($doc_source);
	$this->add_line ($infos);
}

protected function create_info_copie_line_texte ($doc_source) { return ""; }


// Recopie une ligne dans un autre document $doc 
// $line correspond à une ligne provennant de charger_contenu
public function copie_line_to_doc ($doc, $line) {
	global $bdd;
	global $GESTION_SN;
	global $ASSUJETTI_TVA;
	global $DEVIS_CLIENT_ID_TYPE_DOC;
	global $COMMANDE_CLIENT_ID_TYPE_DOC;
	global $LIVRAISON_CLIENT_ID_TYPE_DOC;
	global $FACTURE_FOURNISSEUR_ID_TYPE_DOC;
	global $FACTURE_CLIENT_ID_TYPE_DOC;
	static $tab_correspondance = array();
	global $CALCUL_TARIFS_NB_DECIMALS;

	// *************************************************
	// Informations pour la ligne
	$new_line = $line;
	$new_line->old_ref_doc_line = $line->ref_doc_line;
	$new_line->old_ref_doc_line_parent = $line->ref_doc_line_parent;

	$new_line->ref_doc_line = $doc->create_ref_doc_line ();
	$new_line->ref_doc_line_parent = "";
	$new_line->ordre = $doc->new_line_order ();
	$new_line->type_of_line = define_type_of_line($new_line->ref_article);

	// PU_HT
		$article = new article ($new_line->ref_article);
	if (isset($GLOBALS['_OPTIONS']['COPIE_LINE']['RESET_PU_HT'])) {
		$new_line->pu_ht = $this->select_article_pu ($article, $new_line->qte);
	}
	// invertion de la quantité
	if (isset($GLOBALS['_OPTIONS']['COPIE_LINE']['INVERT_QTE'])) {
		$new_line->qte = -1 * $new_line->qte;
	}

	// Entretien du tableau de correspondance des ref_doc_line
	$tab_correspondance[$new_line->old_ref_doc_line] = $new_line->ref_doc_line;
	if ($new_line->old_ref_doc_line_parent && isset($tab_correspondance[$new_line->old_ref_doc_line_parent])) {
		$new_line->ref_doc_line_parent = $tab_correspondance[$new_line->old_ref_doc_line_parent];
	} 
	
	//on n'ajoute pas les lignes de taxes qui n'ont pas de parent
	if ($new_line->type_of_line == "taxe" && !$new_line->ref_doc_line_parent) {return false;}

	// Informations supplémentaires pour la ligne
	if (!$this->action_before_copie_line_to_doc ($doc, $line)) { unset($tab_correspondance[$new_line->old_ref_doc_line]) ; return false; }

	//gestion du taux de tva
	if (!$ASSUJETTI_TVA && ($this->ID_TYPE_DOC == $DEVIS_CLIENT_ID_TYPE_DOC || $this->ID_TYPE_DOC == $COMMANDE_CLIENT_ID_TYPE_DOC || $this->ID_TYPE_DOC == $LIVRAISON_CLIENT_ID_TYPE_DOC || $this->ID_TYPE_DOC == $FACTURE_CLIENT_ID_TYPE_DOC)) {$new_line->tva = 0;}

	// gestion du pa_ht
	if(empty($new_line->pa_forced)) {$new_line->pa_ht = $article->getPaa_ht (); $new_line->pa_forced = 0 ; }

	// *************************************************
	// Insertion dans la base
	$query = "INSERT INTO docs_lines 
							(ref_doc_line, ref_doc, ref_article, lib_article, desc_article, qte, pu_ht, remise, tva, ordre, 
							 ref_doc_line_parent, visible, pa_ht, pa_forced)
						VALUES ('".$new_line->ref_doc_line."', '".$doc->getRef_doc()."', '".$new_line->ref_article."', 
										'".addslashes($new_line->lib_article)."', '".addslashes($new_line->desc_article)."',
										'".$new_line->qte."', '".$new_line->pu_ht."', '".$new_line->remise."', '".$new_line->tva."', 
										'".$new_line->ordre."', ".ref_or_null($new_line->ref_doc_line_parent).", '".$new_line->visible."',
										".num_or_null($new_line->pa_ht).", ".num_or_null($new_line->pa_forced)." ) ";
	$bdd->exec ($query);
	
	// Informations supplémentaires pour la ligne
	$this->action_after_copie_line_to_doc ($doc, $new_line);

	// Numéros de série
	if (isset($line->sn) && is_array($line->sn) && $GESTION_SN && $doc->getGESTION_SN()) {
		$inserted_sn = "";
		foreach ($line->sn as $line_sn) {
			if ($inserted_sn) { $inserted_sn .= ","; }
			$inserted_sn .= "('".$new_line->ref_doc_line."', '".addslashes($line_sn->numero_serie)."','".$line_sn->sn_qte."')";
		}
		if ($inserted_sn) {
			$query = "INSERT INTO docs_lines_sn (ref_doc_line, numero_serie,sn_qte)
								VALUES ".$inserted_sn;
			$bdd->exec ($query);
		}
	}

        // Abonnements
        if (isset($new_line->modele) && $new_line->modele == "service_abo"){
            //Récupération des infos
            $duree_abo = new duree_abo($new_line->old_ref_doc_line);
            $date_deb_abo = $duree_abo->getDate_debut();
            $duree = $duree_abo->getDuree();

            //traitement de récup des infos 
            $duree_mois_abo = substr($duree,0,strpos($duree,'M'));
            $duree_jours_abo = substr($duree,strpos($duree,'M')+1,strpos($duree,'J')- strpos($duree,'M')-1);
            $duree_abo_new_line = new duree_abo($new_line->ref_doc_line);
            $duree_abo_new_line->create_duree_abo($new_line->ref_doc_line, date_Us_to_Fr($date_deb_abo), $duree_mois_abo, $duree_jours_abo);
        }
        
    $GLOBALS['_INFOS']['new_lines'][] = $this->charger_line ($new_line->ref_doc_line);
	return $new_line->ref_doc_line;
}


// Fonction permetant d'insérer les informations complémentaires d'une ligne lors d'une copie
protected function action_before_copie_line_to_doc ($new_doc, $line) { return true; }
protected function action_after_copie_line_to_doc  ($new_doc, $line) { }


public function copie_line_from_lines ($lines, $new_ref_doc_line_parent = "", $old_ref_doc = "") {
	global $bdd;
	global $GESTION_SN;
	global $ASSUJETTI_TVA;
	global $DEVIS_CLIENT_ID_TYPE_DOC;
	global $COMMANDE_CLIENT_ID_TYPE_DOC;
	global $LIVRAISON_CLIENT_ID_TYPE_DOC;
	global $FACTURE_FOURNISSEUR_ID_TYPE_DOC;
	static $tab_correspondance = array();
	global $CALCUL_TARIFS_NB_DECIMALS;

	
	$query_infos_supp = $this->doc_line_infos_supp ();
	
	if ($document_source = open_doc($old_ref_doc)) {$query_infos_supp = $document_source->getDoc_line_infos_supp () ;}
	// *************************************************
	// Informations sur les lignes à copier
	$liste_lines = "''";
	if (!count($lines)) { return false; }
	for ($i=0; $i<count($lines); $i++) {
		$liste_lines .= ",'".$lines[$i]."'";
	}
	$query = "SELECT dl.ref_doc_line, dl.ref_article, dl.lib_article, dl.desc_article, dl.qte, round(dl.pu_ht,".$CALCUL_TARIFS_NB_DECIMALS.") as pu_ht, dl.remise, dl.tva, dl.ordre, dl.ref_doc_line_parent, dl.visible, dl.pa_ht
	
									 ".$query_infos_supp['select']."
						FROM docs_lines dl
							".$query_infos_supp['left_join']."
						WHERE dl.ref_doc_line IN (".$liste_lines.")
						ORDER BY ref_doc_line_parent, ordre";
	$resultat1 = $bdd->query($query);


	// Numéros de séries des lignes à copier
	$sns = array();
	$query = "SELECT ref_doc_line, numero_serie
						FROM docs_lines_sn dls
						WHERE dls.ref_doc_line IN (".$liste_lines.")";
	$resultat2 = $bdd->query($query);
	while ($tmp = $resultat2->fetchObject()) { $sns[$tmp->ref_doc_line][] = $tmp->numero_serie; }
	unset($tmp, $resultat2, $query, $lines);

	while ($line = $resultat1->fetchObject()) {
		$new_line = $line;
		$new_line->ref_old_line	= $line->ref_doc_line;
		$new_line->ref_article 	= $line->ref_article;
		$new_line->lib_article 	= $line->lib_article;
		$new_line->desc_article = $line->desc_article;
		$new_line->qte 					= $line->qte;
		$new_line->pu_ht 				= $line->pu_ht;
		$new_line->remise				= $line->remise;
		$new_line->tva					= $line->tva;
		//gestion du taux de tva
		if (!$ASSUJETTI_TVA && ($this->ID_TYPE_DOC == $DEVIS_CLIENT_ID_TYPE_DOC || $this->ID_TYPE_DOC == $COMMANDE_CLIENT_ID_TYPE_DOC || $this->ID_TYPE_DOC == $LIVRAISON_CLIENT_ID_TYPE_DOC || $this->ID_TYPE_DOC == $FACTURE_FOURNISSEUR_ID_TYPE_DOC)) {$new_line->tva = 0;}
		
		$new_line->visible			= $line->visible;
		$new_line->type_of_line = define_type_of_line($line->ref_article);
		if (isset($sns[$new_line->ref_old_line])) {
			$new_line->sn = $sns[$new_line->ref_old_line];
		}
		$new_line->ref_doc_line_parent = $new_ref_doc_line_parent;
	
		// *************************************************
		// Création de la référence et de l'ordre
		$new_line->ref_doc_line = $this->create_ref_doc_line ();
		$new_line->ordre 				= $this->new_line_order ();

		// Entretien du tableau de correspondance des ref_doc_line
		$tab_correspondance[$line->ref_doc_line] = $new_line->ref_doc_line;
		if (isset($tab_correspondance[$line->ref_doc_line_parent])) {
			$new_line->ref_doc_line_parent = $tab_correspondance[$line->ref_doc_line_parent];
		}
		$article = new article($new_line->ref_article);
		if(empty($new_line->pa_forced)) {$new_line->pa_ht = $article->getPaa_ht ();$new_line->pa_forced = 0;}

		// *************************************************
		// Insertion dans la base
		$query = "INSERT INTO docs_lines 
								(ref_doc_line, ref_doc, ref_article, lib_article, desc_article, qte, pu_ht, remise, tva, ordre, 
								 ref_doc_line_parent, visible, pa_ht, pa_forced)
							VALUES ('".$new_line->ref_doc_line."', '".$this->ref_doc."', '".$new_line->ref_article."', 
											'".addslashes($new_line->lib_article)."', '".addslashes($new_line->desc_article)."',
											'".$new_line->qte."', '".$new_line->pu_ht."', '".$new_line->remise."', '".$new_line->tva."', 
											'".$new_line->ordre."', ".ref_or_null($new_line->ref_doc_line_parent).", '".$new_line->visible."',
												".  num_or_null($new_line->pa_ht).", ".  num_or_null($new_line->pa_forced).") ";
		$bdd->exec ($query);

		// Informations supplémentaires pour la ligne
		$this->action_after_copie_line_from_line ($new_line);
		
		// Numéros de série
		if (isset($new_line->sn) && $GESTION_SN && $this->GESTION_SN) {
			$inserted_sn = "";
			foreach ($new_line->sn  as $line_sn) {
				if ($inserted_sn) { $inserted_sn .= ","; }
				$inserted_sn .= "('".$new_line->ref_doc_line."', '".addslashes($line_sn->numero_serie)."','".$line_sn->sn_qte."')";
			}
			if ($inserted_sn) {
				$query = "INSERT INTO docs_lines_sn (ref_doc_line, numero_serie,sn_qte)
									VALUES ".$inserted_sn;
				$bdd->exec ($query);
			}
		}

		// Copie des lignes enfants
		$lines_enfant = array();
		$query = "SELECT ref_doc_line
							FROM docs_lines 
							WHERE ref_doc_line_parent = '".$new_line->ref_old_line."'";
		$resultat3 = $bdd->query($query);
		while ($tmp = $resultat3->fetchObject()) { $lines_enfant[] = $tmp->ref_doc_line; }
		if (count($lines_enfant)) { $this->copie_line_from_lines ($lines_enfant, $new_line->ref_doc_line); }
	}

	return true;
}


public function action_after_copie_line_from_line ($line) {}

// *************************************************************************************************************
// FONCTIONS LIEES AU STOCK
// *************************************************************************************************************
// Ajoute le contenu au stock
public function add_content_to_stock ($id_stock = 0) {
	if (!$id_stock) { $id_stock = $this->id_stock; }
	if (!$this->contenu_materiel_loaded) { $this->charger_contenu_materiel (); }
	
	foreach ($this->contenu_materiel as $doc_line) {
		$_SESSION['stocks'][$id_stock]->add_to_stock ($doc_line, $this->ref_doc);
	}
}


// Supprime le contenu du stock
public function del_content_from_stock ($id_stock = 0) {
	if (!$id_stock) { $id_stock = $this->id_stock; }
	if (!$this->contenu_materiel_loaded) { $this->charger_contenu_materiel (); }

	foreach ($this->contenu_materiel as $doc_line) {
		$_SESSION['stocks'][$id_stock]->del_from_stock ($doc_line, $this->ref_doc);
	}
}

//fonctions liées au services par abonnement
// Ajoute le service par abo
public function add_service_abo () {
	if (!$this->contenu_service_abo_loaded) { $this->charger_contenu_service_abo (); }
	
	foreach ($this->contenu_service_abo as $doc_line) {
		$tmp_article = new article ($doc_line->ref_article);
		$tmp_article->add_ligne_article_abonnement ($this->ref_doc, $this->ref_contact, $doc_line->ref_doc_line, $doc_line->qte);
	}
}

// Supprime le service par abo
public function del_service_abo () {
	if (!$this->contenu_service_abo_loaded) { $this->charger_contenu_service_abo (); }
	
	foreach ($this->contenu_service_abo as $doc_line) {
		$tmp_article = new article ($doc_line->ref_article);
		$tmp_article->del_ligne_article_abonnement ($this->ref_doc, $this->ref_contact, $doc_line->ref_doc_line);
	}
}

//fonctions liées au services à la consommation
// Ajoute le service a la conso
public function add_service_conso () {
	if (!$this->contenu_service_conso_loaded) { $this->charger_contenu_service_conso (); }
	
	foreach ($this->contenu_service_conso as $doc_line) {
		$tmp_article = new article ($doc_line->ref_article);
		$tmp_article->add_ligne_article_consommation ( $this->ref_contact, $doc_line->qte);
	}
}

// Supprime le service a la conso
public function del_service_conso () {
	if (!$this->contenu_service_conso_loaded) { $this->charger_contenu_service_conso (); }
	
	foreach ($this->contenu_service_conso as $doc_line) {
		$tmp_article = new article ($doc_line->ref_article);
		$tmp_article->del_ligne_article_consommation ($this->ref_contact, $doc_line->qte);
	}
}


// *************************************************************************************************************
// FONCTIONS DE GESTION DES COMMERCIAUX
// *************************************************************************************************************
// Chargement des commerciaux attribués à ce document
protected function charger_commerciaux () {
	global $bdd;
	
	$this->commerciaux = array();
	$query = "SELECT dvc.ref_contact, dvc.ref_doc, dvc.part, 
									 a.nom, 
									 ac.id_commission_regle,
									 cr.lib_comm, cr.formule_comm
									  
						FROM doc_ventes_commerciaux  dvc
							LEFT JOIN annuaire a ON a.ref_contact = dvc.ref_contact
							LEFT JOIN annu_commercial ac ON ac.ref_contact = dvc.ref_contact
							LEFT JOIN  commissions_regles  cr ON cr.id_commission_regle = ac.id_commission_regle
						WHERE dvc.ref_doc = '".$this->ref_doc."' 
						ORDER BY dvc.part DESC ";
	$resultat = $bdd->query ($query);
	while ($tmp = $resultat->fetchObject ()) {
		$this->commerciaux[] = $tmp; 
	}

	$this->commerciaux_loaded = true;
	return true;
}


// Attribution de commerciaux pour ce document
public function attribution_commercial ($commerciaux) {
	global $bdd;

	// Si aucune référence
	if (!is_array($commerciaux)) {
		return false;
	}

	//supression des enregistrements existants
	$query = "DELETE FROM doc_ventes_commerciaux
						WHERE ref_doc = '".$this->ref_doc."' ";
	$bdd->exec ($query);
	
	foreach ($commerciaux as $commercial) {		
		// Insertion de l'attribution dans la bdd
		$query = "INSERT INTO doc_ventes_commerciaux (ref_contact, ref_doc, part)	
							VALUES ('".$commercial->ref_contact."', '".$this->ref_doc."', '".$commercial->part."') ";
		$bdd->exec ($query);
	}
	$this->commerciaux_loaded = false;
        
	return true;
}



// *************************************************************************************************************
// FONCTIONS DE GESTION DES REGLEMENTS
// *************************************************************************************************************
// Chargement des règlements rapprochés à ce document
protected function charger_reglements () {
	global $bdd;
	global $CALCUL_TARIFS_NB_DECIMALS;

	$this->reglements = array();
	$query = "SELECT r.ref_reglement, r.ref_contact, r.date_reglement, round(r.montant_reglement,".$CALCUL_TARIFS_NB_DECIMALS.") as montant_reglement, r.valide, 
									 rm.lib_reglement_mode, rm.abrev_reglement_mode, rm.type_reglement, round(rd.montant,".$CALCUL_TARIFS_NB_DECIMALS.") as  montant_on_doc, rd.liaison_valide,
									 montant_on_all_doc
						FROM reglements r
							LEFT JOIN reglements_modes rm ON r.id_reglement_mode = rm.id_reglement_mode
							LEFT JOIN reglements_docs rd ON r.ref_reglement = rd.ref_reglement
							LEFT JOIN (SELECT ref_reglement,round(sum(montant),".$CALCUL_TARIFS_NB_DECIMALS.") montant_on_all_doc from reglements_docs where liaison_valide=1 group by ref_reglement) sum ON r.ref_reglement = sum.ref_reglement
						WHERE rd.ref_doc = '".$this->ref_doc."' 
						ORDER BY r.date_reglement ";
	$resultat = $bdd->query ($query);
	$montant_total_reglements = 0;
	$resultat = $bdd->query ($query);
	while ($tmp = $resultat->fetchObject ()) {
            $doc_get_montant_ttc = $this->getMontant_ttc();
		$tmp->imputations = $tmp->montant_on_all_doc-$tmp->montant_on_doc;
		if ($this->ACCEPT_REGMT ==  1 && $tmp->type_reglement != "entrant") {
                       $tmp->montant_reglement = -$tmp->montant_reglement;
                       $tmp->montant_on_doc = -$tmp->montant_on_doc;
                       $tmp->montant_on_all_doc = -$tmp->montant_on_all_doc;
                       }
		if ($this->ACCEPT_REGMT == -1 && $tmp->type_reglement != "sortant") {
                       $tmp->montant_reglement = -$tmp->montant_reglement;
                       $tmp->montant_on_doc = -$tmp->montant_on_doc;
                       $tmp->montant_on_all_doc = -$tmp->montant_on_all_doc;
                       }
                      
// Si il reste de la dipo sur le reglement on l'utilise			
		if(($tmp->montant_reglement - $tmp->montant_on_all_doc) > 0 && ($doc_get_montant_ttc - $montant_total_reglements) > 0 && $tmp->liaison_valide){
			$tmp->montant_on_doc += ($tmp->montant_reglement - $tmp->montant_on_all_doc);
			$updatequery = "UPDATE reglements_docs 
					SET montant='".abs($tmp->montant_on_doc)."'
					WHERE ref_reglement='".$tmp->ref_reglement."' && ref_doc='".$this->ref_doc."' && liaison_valide=1";
			$resultquery = $bdd->query ($updatequery);
		}
		
// On corrige les erreurs d'imputations		
		if ($tmp->imputations > 0 && $tmp->liaison_valide){
			$montant = abs($tmp->montant_reglement)-$tmp->imputations;
			$updatequery = "UPDATE reglements_docs 
					SET montant='".$montant."'
					WHERE ref_reglement='".$tmp->ref_reglement."' && ref_doc='".$this->ref_doc."' && liaison_valide=1";
			$resultquery = $bdd->query ($updatequery);
			$tmp->montant_on_doc = $montant;
		}
// On libere le reglement en trop		
		if (abs($tmp->montant_on_doc) > abs($doc_get_montant_ttc) && $tmp->liaison_valide) {
			$updatequery = "UPDATE reglements_docs 
					SET montant='".abs($doc_get_montant_ttc)."'
					WHERE ref_reglement='".$tmp->ref_reglement."' && ref_doc='".$this->ref_doc."' && liaison_valide=1";
			$resultquery = $bdd->query ($updatequery);
			$tmp->montant_on_doc = abs($this->getMontant_ttc());
			}
// On libere le dernier reglement en date si le document en couvert par les reglements actuels			
			if(abs($montant_total_reglements+$tmp->montant_on_doc) > abs($doc_get_montant_ttc) && $tmp->liaison_valide){
                            $montant = $tmp->montant_on_doc - ($montant_total_reglements+$tmp->montant_on_doc - abs($doc_get_montant_ttc));
                        $updatequery = "UPDATE reglements_docs 
					SET montant='".$montant."'
					WHERE ref_reglement='".$tmp->ref_reglement."' && ref_doc='".$this->ref_doc."' && liaison_valide=1";
			$resultquery = $bdd->query ($updatequery);
			$tmp->montant_on_doc = $montant;
			$montant_total_reglements+=$tmp->montant_on_doc;
			}else{
				$montant_total_reglements+=$tmp->montant_on_doc;
			}
		$this->reglements[] = $tmp; 
	}

	$this->reglements_loaded = true;

	return true;
}



// Calcul du montant TTC du document
protected function calcul_montant_to_pay () {
	global $bdd;
	global $CALCUL_TARIFS_NB_DECIMALS;
	global $TARIFS_NB_DECIMALES;
	global $TAXE_IN_PU;

        if(isset($TAXE_IN_PU) && $TAXE_IN_PU ==0)
        {$query_where = "(ISNULL(dl.ref_doc_line_parent) || dl.lib_article IN(SELECT distinct lib_taxe FROM taxes))";}
        else
        {$query_where = "ISNULL(dl.ref_doc_line_parent)";}

	// Montant total du document. La somme est effectuée sur les arrondis présentés pour ne pas entraîner d'erreur d'arrondi et sur le montant total HT (par type de TVA)
	$query = "SELECT SUM(ROUND(subquerybytva.montant_ht*(1+(subquerybytva.tva/100)),".$TARIFS_NB_DECIMALES.")) as montant_ttc from ( 
SELECT SUM( ROUND( qte * ROUND( pu_ht, ".$CALCUL_TARIFS_NB_DECIMALS." ) * ( 1 - remise /100 ) , ".$CALCUL_TARIFS_NB_DECIMALS." ) ) as montant_ht, tva
FROM docs_lines dl
WHERE dl.ref_doc = '".$this->ref_doc."' && ".$query_where." && visible =1
GROUP BY tva
) subquerybytva";

	$resultat = $bdd->query ($query);
	$tmp = $resultat->fetchObject ();
	$this->montant_ttc = abs($tmp->montant_ttc);

	// Montant total des règlements
	$this->montant_reglements = 0;
	$query = "SELECT SUM(ROUND(rd.montant,".$CALCUL_TARIFS_NB_DECIMALS.")) as montant_reglements, rm.type_reglement
						FROM reglements_docs rd
							LEFT JOIN reglements r ON r.ref_reglement = rd.ref_reglement
							LEFT JOIN reglements_modes rm ON r.id_reglement_mode = rm.id_reglement_mode
						WHERE rd.ref_doc = '".$this->ref_doc."' && r.valide = 1 
						GROUP BY rm.type_reglement";
	$resultat = $bdd->query ($query);
	while ($tmp = $resultat->fetchObject ()) { 
		if (	($this->ACCEPT_REGMT ==  1 && $tmp->type_reglement == "entrant") ||
					($this->ACCEPT_REGMT == -1 && $tmp->type_reglement == "sortant")		) {
			$this->montant_reglements += $tmp->montant_reglements;
		}
		else {
			$this->montant_reglements += $tmp->montant_reglements;
		}
	}
	$this->montant_to_pay = $this->montant_ttc - $this->montant_reglements;
	return true;
}


// Appelle les fonction de reglement partiel et total, afin de vérifier l'etat du document en fonction des règlements effectués
protected function check_etat_reglement () { 
	$this->calcul_montant_to_pay ();

	if (($this->montant_ttc >= 0 && $this->montant_to_pay <= 0.01) || ($this->montant_ttc <= 0 && $this->montant_to_pay >= -0.01)) {
		$this->reglement_total();
		return true;
	}

	if ($this->montant_reglements) {
		$this->reglement_partiel();
		return true;
	}

	$this->reglement_inexistant();
	return true;
}


// Création d'un règlement pour ce document
public function rapprocher_reglement ($reglement) {
	global $bdd;

	// Si aucune référence, le règlement est invalide
	if (!$reglement->getRef_reglement()) {
		return false;
	}

	if ($reglement->getMontant_disponible() <= 0) {
		return false;
	}

	$this->calcul_montant_to_pay ();
        if ( abs($this->montant_to_pay) - abs($reglement->getMontant_disponible()) > 0.01 ) {
		// Montant à régler supérieur au montant réglé, la totalité de ce reglement est attribuée au document
		$montant_rapprochement = abs($reglement->getMontant_disponible());
		$reglement_total = 0;
	}
	else {
		// Montant à régler inférieur ou égal au montant réglé, seul le montant à régler est attribuée au document
		$montant_rapprochement = abs($this->montant_to_pay);
		$reglement_total = 1;
	}
	// Insertion du rapprochement dans la bdd
	$query = "INSERT INTO reglements_docs (ref_reglement, ref_doc, montant, liaison_valide)	
						VALUES ('".$reglement->getRef_reglement()."', '".$this->ref_doc."', '".$montant_rapprochement."', 1) ";
    $bdd->exec ($query);
        // Actions supplémentaires.
	$this->reglement_partiel();
	if ($reglement_total) {
		$this->reglement_total();
	}
	// Retour des informations
	$GLOBALS['_INFOS']['reglement_doc'][$reglement->getRef_reglement()] = $montant_rapprochement;
	return true;
}


// Vérifie si il est utile de charger les informations de facturation
protected function need_infos_facturation () {
	return false;
}


// Va rechercher les factures à régler, les avoirs en cours, et les règlements non lettrés
public function get_infos_facturation ($montant_positif = 1) {
	global $bdd;

	// Initialisation
	$this->factures_to_pay	= array();	// Factures à payer pour une FAC+ ou une FAF+
	$this->avoirs_to_use		= array();	// Avoirs à utiliser pour une FA+ / Avoirs à cumuler pour une FA-
	$this->regmnt_to_use		= array();	// Règlements entrants (si FAC+ ou FAF-) ou sortants (si FAF+ ou FAC-) à associer au doc

	// Vérification de la nécessité de charger ces informations
	if (!$this->need_infos_facturation()) {
		$GLOBALS['_ALERTES']['infos_non_utiles'] = 1;
		return false;
	}

	if (!$this->ref_contact) {
		$GLOBALS['_ALERTES']['infos_non_utiles'] = 1;
	 return true; 
	}

	// Type de document
	switch ($this->ID_TYPE_DOC) {
		case 1: case 2: case 3: case 4: case 15:	$type = "FAC";		break;
		case 5: case 6: case 7: case 8: 			$type = "FAF";		break;
	}
	// Montant positif ou négatif
	switch ($montant_positif) {
		case 1: case -1: break;
		default:
			if (getMontant_ttc () >= 0) { $montant_positif = 1;	}
			else { $montant_positif = -1; }
			break;
	}

	// **************************************************
	// Cas d'une facture client 
	if ($type == "FAC") {
		// Recherche des FAC- (avoirs) à utiliser ou en saisie
		$query = "SELECT d.ref_doc, d.id_etat_doc, d.date_creation_doc date_creation,
										 SUM(dl.qte * dl.pu_ht * (1-dl.remise/100) * (1+dl.tva/100)) as montant_ttc,
										 ( SELECT SUM(montant)
										 	 FROM reglements_docs rd
										 	 	LEFT JOIN reglements r ON r.ref_reglement = rd.ref_reglement
										 	 WHERE d.ref_doc = rd.ref_doc && r.valide = 1
										 ) as montant_reglements
							FROM documents d
								LEFT JOIN doc_fac df ON d.ref_doc = df.ref_doc 
								LEFT JOIN docs_lines dl ON d.ref_doc = dl.ref_doc && ISNULL(dl.ref_doc_line_parent) && dl.visible = 1
							WHERE d.ref_contact = '".$this->ref_contact."' && d.ref_doc != '".$this->ref_doc."' && 

							(d.id_etat_doc = 16 || d.id_etat_doc = 18)
							GROUP BY d.ref_doc
							HAVING montant_ttc < 0
							ORDER BY date_creation ASC";
		$resultat = $bdd->query($query); 
		while ($tmp = $resultat->fetchObject()) { $this->avoirs_to_use[] = $tmp; }
if ($montant_positif == -1) {
    $query = "SELECT r.ref_reglement, r.montant_reglement, r.date_reglement, rm.lib_reglement_mode, rd.liaison_valide,
												SUM(rd.montant) as montant_used
								FROM reglements r
									LEFT JOIN reglements_docs rd ON r.ref_reglement = rd.ref_reglement && (rd.liaison_valide = 1 || ISNULL(rd.liaison_valide))
									LEFT JOIN reglements_modes rm ON rm.id_reglement_mode = r.id_reglement_mode
								WHERE r.ref_contact = '".$this->ref_contact."' && r.valide = 1 && rm.type_reglement = 'sortant'
								GROUP BY r.ref_reglement
								HAVING ABS(ABS(montant_reglement) - ABS(montant_used)) > 0.02 || ISNULL(montant_used)
								ORDER BY r.date_reglement ASC";
			$resultat = $bdd->query($query);
			while ($tmp = $resultat->fetchObject()) {
				if (!$tmp->montant_used) { $tmp->montant_used = 0; }
				$this->regmnt_to_use[] = $tmp;
			}
		}
    
		if ($montant_positif == 1) {
			// Recherche des FAC+ à régler
			$query = "SELECT d.ref_doc, d.id_etat_doc, de.lib_etat_doc, d.date_creation_doc date_creation, df.date_echeance,
											 SUM(dl.qte * dl.pu_ht * (1-dl.remise/100) * (1+dl.tva/100)) as montant_ttc,
											 ( SELECT SUM(montant)
											 	 FROM reglements_docs rd
											 	 	LEFT JOIN reglements r ON r.ref_reglement = rd.ref_reglement
											 	 WHERE d.ref_doc = rd.ref_doc && r.valide = 1
											 ) as montant_reglements
								FROM documents d
									LEFT JOIN doc_fac df ON d.ref_doc = df.ref_doc 
									LEFT JOIN documents_etats de ON d.id_etat_doc = de.id_etat_doc 
									LEFT JOIN docs_lines dl ON d.ref_doc = dl.ref_doc && ISNULL(dl.ref_doc_line_parent) && dl.visible = 1
								WHERE d.ref_contact = '".$this->ref_contact."' && d.ref_doc != '".$this->ref_doc."' && 
											(d.id_etat_doc = 16 || d.id_etat_doc = 18)
								GROUP BY d.ref_doc
								HAVING montant_ttc >= 0
								ORDER BY date_creation ASC";
			$resultat = $bdd->query($query); 
			while ($tmp = $resultat->fetchObject()) { $this->factures_to_pay[] = $tmp; }

			 // Règlements à utiliser (non lettrés totalement)
			$query = "SELECT r.ref_reglement, r.montant_reglement, r.date_reglement, rm.lib_reglement_mode, rd.liaison_valide,
												SUM(rd.montant) as montant_used
								FROM reglements r
									LEFT JOIN reglements_docs rd ON r.ref_reglement = rd.ref_reglement && (rd.liaison_valide = 1 || ISNULL(rd.liaison_valide))
									LEFT JOIN reglements_modes rm ON rm.id_reglement_mode = r.id_reglement_mode
								WHERE r.ref_contact = '".$this->ref_contact."' && r.valide = 1 && rm.type_reglement = 'entrant' 
								GROUP BY r.ref_reglement
								HAVING ABS(ABS(montant_reglement) - ABS(montant_used)) > 0.02 || ISNULL(montant_used)
								ORDER BY r.date_reglement ASC";
			$resultat = $bdd->query($query);
			while ($tmp = $resultat->fetchObject()) {
				if (!$tmp->montant_used) { $tmp->montant_used = 0; }
				$this->regmnt_to_use[] = $tmp; 
			}
		}
	}
	// **************************************************
	// Cas d'une facture fournisseur 
	if ($type == "FAF") {
		// Recherche des FAF- (avoirs) à utiliser ou en saisie
		$query = "SELECT d.ref_doc, d.id_etat_doc, d.date_creation_doc date_creation,
										 SUM(dl.qte * dl.pu_ht * (1-dl.remise/100) * (1+dl.tva/100)) as montant_ttc,
										 ( SELECT SUM(montant)
										 	 FROM reglements_docs rd
										 	 	LEFT JOIN reglements r ON r.ref_reglement = rd.ref_reglement
										 	 WHERE d.ref_doc = rd.ref_doc && r.valide = 1
										 ) as montant_reglements
							FROM documents d
								LEFT JOIN doc_faf df ON d.ref_doc = df.ref_doc 
								LEFT JOIN docs_lines dl ON d.ref_doc = dl.ref_doc && ISNULL(dl.ref_doc_line_parent) && dl.visible = 1
							WHERE d.ref_contact = '".$this->ref_contact."' && d.ref_doc != '".$this->ref_doc."' && 

							(d.id_etat_doc = 32 || d.id_etat_doc = 34)
							GROUP BY d.ref_doc
							HAVING montant_ttc < 0
							ORDER BY date_creation ASC";
		$resultat = $bdd->query($query); 
		while ($tmp = $resultat->fetchObject()) { $this->avoirs_to_use[] = $tmp; }

		if ($montant_positif == 1) {
			// Recherche des FAF+ à régler
			$query = "SELECT d.ref_doc, d.id_etat_doc, de.lib_etat_doc, d.date_creation_doc date_creation, df.date_echeance,
											 SUM(dl.qte * dl.pu_ht * (1-dl.remise/100) * (1+dl.tva/100)) as montant_ttc,
											 ( SELECT SUM(montant)
											 	 FROM reglements_docs rd
											 	 	LEFT JOIN reglements r ON r.ref_reglement = rd.ref_reglement
											 	 WHERE d.ref_doc = rd.ref_doc && r.valide = 1
											 ) as montant_reglements
								FROM documents d
									LEFT JOIN doc_faf df ON d.ref_doc = df.ref_doc 
									LEFT JOIN documents_etats de ON d.id_etat_doc = de.id_etat_doc 
									LEFT JOIN docs_lines dl ON d.ref_doc = dl.ref_doc && ISNULL(dl.ref_doc_line_parent) && dl.visible = 1
								WHERE d.ref_contact = '".$this->ref_contact."' && d.ref_doc != '".$this->ref_doc."' && 
											(d.id_etat_doc = 32 || d.id_etat_doc = 34)
								GROUP BY d.ref_doc
								HAVING montant_ttc >= 0
								ORDER BY date_creation ASC";
			$resultat = $bdd->query($query); 
			while ($tmp = $resultat->fetchObject()) { $this->factures_to_pay[] = $tmp; }

			 // Règlements à utiliser (non lettrés totalement)
			$query = "SELECT r.ref_reglement, r.montant_reglement, r.date_reglement, rm.lib_reglement_mode, rd.liaison_valide,
												SUM(rd.montant) as montant_used
								FROM reglements r
									LEFT JOIN reglements_docs rd ON r.ref_reglement = rd.ref_reglement && (rd.liaison_valide = 1 || ISNULL(rd.liaison_valide))
									LEFT JOIN reglements_modes rm ON rm.id_reglement_mode = r.id_reglement_mode
								WHERE r.ref_contact = '".$this->ref_contact."' && r.valide = 1 && rm.type_reglement = 'sortant' 
								GROUP BY r.ref_reglement
								HAVING ABS(ABS(montant_reglement) - ABS(montant_used)) > 0.02 || ISNULL(montant_used)
								ORDER BY r.date_reglement ASC";
			$resultat = $bdd->query($query);
			while ($tmp = $resultat->fetchObject()) {
				if (!$tmp->montant_used) { $tmp->montant_used = 0; }
				$this->regmnt_to_use[] = $tmp; 
			}
		}
	}
}


// Défait la liaison entre un document et un règlement
public function delier_reglement ($ref_reglement) {
	global $bdd;

	if (!$reglement = new reglement($ref_reglement)) {
		$GLOBALS['_ALERTES']['bad_ref_reglement'] = 1;
		return false;
	}

	// Suppression du rapprochement dans la bdd
	$query = "DELETE FROM reglements_docs 
						WHERE ref_reglement = '".$reglement->getRef_reglement()."' && ref_doc = '".$this->ref_doc."'  ";
	$bdd->exec ($query);

	// Vérification de l'état
	$this->check_etat_reglement ();

	return true;
}


// Invalide la liaison avec un règlement (celui-ci n'est donc plus comptabilisé lors du calcul des sommes utilisées)
protected function maj_etat_reglements ($active = 1) {
	global $bdd;

	$query = "UPDATE reglements_docs SET liaison_valide = '".$active."'
						WHERE ref_doc = '".$this->ref_doc."' ";
	$bdd->exec ($query);
	return true;
}



// Fonctions complémentaires permettant les actions supplémentaires en cas de règlement
protected function reglement_inexistant () {}
protected function reglement_partiel () {}
protected function reglement_total () {
		
	if ($this->id_etat_doc != $this->ID_ETAT_ANNULE) { 
			
		
		if(preg_match('/^CDC-.+$/',$this->ref_doc) == 1){
				
			//liaison_edi
			edi_event(126,$this->ref_doc,19);
			
		}else if(preg_match('/^BLC-.+$/',$this->ref_doc)){
			
				if (!$this->liaisons_loaded) { $this->charger_liaisons(); }
			foreach($this->liaisons['source'] as $doc){
					
				if(preg_match('/^CDC-.+$/',$doc->ref_doc_source) == 1){
					//liaison_edi
					edi_event(126,$doc->ref_doc_source,19);
				}
			}
		}else if(preg_match('/^FAC-.+$/',$this->ref_doc) ){
			
			if (!$this->liaisons_loaded) { $this->charger_liaisons(); }
			foreach($this->liaisons['source'] as $doc){
					
				if(preg_match('/^CDC-.+$/',$doc->ref_doc_source) == 1){
					//liaison_edi
						edi_event(126,$doc->ref_doc_source,19);
				}
			}
		}else{
				
		}
	}
}



// *************************************************************************************************************
// FONCTIONS DE GENERATION D'UN PDF 
// *************************************************************************************************************
// Créé et affiche le PDF d'un document
public function create_pdf ($print = 0) {	
	// Préférences et options
	$GLOBALS['PDF_OPTIONS']['HideToolbar'] = 0;
	$GLOBALS['PDF_OPTIONS']['AutoPrint'] = $print;

	// Création du fichier
	$pdf = new PDF_etendu ();

	// Ajout du document au PDF
	$pdf->add_doc ("", $this);

	// Sortie
	return $pdf;
}


// Affiche le PDF du document
public function view_pdf ($print = 0) {
	$pdf = $this->create_pdf ($print);
	// Sortie
	$pdf->Output($this->ref_doc.".pdf", "I");
}


// Affiche le PDF du document
public function print_pdf () {
	$this->document_edition_add (1);
	$this->view_pdf (1);
}


// sauvegarde le PDF du document
public function save_pdf () {
	global $FICHIERS_DIR;

	$pdf = $this->create_pdf ();

	// Sortie
	$pdf->Output($FICHIERS_DIR."doc_tmp/".$this->ref_doc."_".$this->code_file.".pdf" , "F");

	return true;
}

//changement du code_pdf_modele
public function change_code_pdf_modele ($code_pdf_modele) {
	$this->code_pdf_modele = $code_pdf_modele;
} 

// Enregistre l'edition du document
public function document_edition_add ($id_edition_mode, $information = "") {
	global $bdd;
	
	if (!$id_edition_mode) { return false; }
	
	// Insertion du rapprochement dans la bdd
	$query = "INSERT INTO documents_editions (ref_doc, id_edition_mode, information, date_edition, ref_user)	
						VALUES ('".$this->ref_doc."', '".$id_edition_mode."', '".$information."', NOW(), '".$_SESSION['user']->getRef_user()."' ) ";
	$bdd->exec ($query);

	return true;
}


// Envoi du document par email
public function mail_document ($to , $sujet , $message) {
	global $bdd;
	global $FICHIERS_DIR;
	global $REF_CONTACT_ENTREPRISE;
	
	$this->save_pdf();
	
	$filename 	= array();
	$filename[] = $FICHIERS_DIR."doc_tmp/".$this->ref_doc."_".$this->code_file.".pdf";
	$typemime		= "application/pdf";
	$nom				= array();
	$nom[]			= $this->ref_doc."_".$this->code_file.".pdf";
	
	//on génere un nom de fichier en remplacement
	$contact_entreprise = new contact($REF_CONTACT_ENTREPRISE);
	$nom_entreprise = str_replace (CHR(13), " " ,str_replace (CHR(10), " " , $contact_entreprise->getNom()));
	$nom_aff				= array();
	$nom_aff[]			= $this->ref_doc."_".$nom_entreprise.".pdf";


	//on récupère l'email de l'utilisateur en cours pour envoyer le mail
	$reply 			= $_SESSION['user']->getEmail();
	$from 			= $_SESSION['user']->getEmail();
	
	// Envoi de l'email
	$mail = new email();
	$mail->prepare_envoi(0, 1);
	if ($mail->mail_attachement ($to , $sujet , $message , $filename , $typemime , $nom , $reply , $from, $nom_aff)) {
		$this->document_edition_add (2);
		return true;
	} 
	else {
		return false;
	}
}


public function fax_document ($to , $sujet , $message) {
	global $bdd;
	global $FICHIERS_DIR;
	global $REF_CONTACT_ENTREPRISE;
	
	$this->save_pdf();
	
	$filename 	= array();
	$filename[] = $FICHIERS_DIR."doc_tmp/".$this->ref_doc."_".$this->code_file.".pdf";
	$typemime		= "application/pdf";
	$nom				= array();
	$nom[]			= $this->ref_doc."_".$this->code_file.".pdf";
	
	//on génere un nom de fichier en remplacement
	$contact_entreprise = new contact($REF_CONTACT_ENTREPRISE);
	$nom_entreprise = str_replace (CHR(13), " " ,str_replace (CHR(10), " " , $contact_entreprise->getNom()));
	$nom_aff				= array();
	$nom_aff[]			= $this->ref_doc."_".$nom_entreprise.".pdf";


	//on récupère l'email de l'utilisateur en cours pour envoyer le mail
	$reply 			= $_SESSION['user']->getEmail();
	$from 			= $_SESSION['user']->getEmail();
	
	// Envoi de l'email
	$mail = new email();
	$mail->prepare_envoi(0, 1);
	if ($mail->mail_attachement ($to , $sujet , $message , $filename , $typemime , $nom , $reply , $from, $nom_aff)) {
		$this->document_edition_add (3);
		return true;
	} 
	else {
		return false;
	}
}

// *************************************************************************************************************
// FONCTIONS DE RESTITUTION DES DONNEES 
// *************************************************************************************************************

function getRef_doc () {
	return $this->ref_doc;
}

function getLib_type_doc () {
	return $this->lib_type_doc;
}
 
function getLib_type_printed () {
	return $this->lib_type_printed;
}
 
function getId_etat_doc () {
	return $this->id_etat_doc;
}
 
function getLib_etat_doc () {
	return $this->lib_etat_doc;
}

function getDate_creation () {
	return $this->date_creation;
}
 
function getIs_open () {
	return $this->is_open;
}

function getCode_affaire(){
	return $this->code_affaire;
}
 
function getRef_contact () {
	return $this->ref_contact;
}
 
function getContact () {
	return $this->contact;
}
 
function getNom_contact () {
	return $this->nom_contact;
}
 
function getRef_adr_contact () {
	return $this->ref_adr_contact;
}
 
function getAdresse_contact () {
	return $this->define_text_adresse ($this->adresse_contact, $this->code_postal_contact, $this->ville_contact, $this->id_pays_contact, $this->pays_contact);
}
 
function getText_adresse_contact () {
	return $this->adresse_contact;
}
 
function getCode_postal_contact () {
	return $this->code_postal_contact;
}
 
function getVille_contact () {
	return $this->ville_contact;
}
 
function getId_pays_contact () {
	return $this->id_pays_contact;
}
 
function getPays_contact () {
	return $this->pays_contact;
}

function getApp_tarifs () {
	return $this->app_tarifs;
}
 
function getDescription () {
	return $this->description;
}
 
function getContenu () {
	if (!$this->contenu_loaded) { $this->charger_contenu(); }
	return $this->contenu;
}

function get_code_pdf_modele () {
    return $this->code_pdf_modele;
}

function getTVAs () {
	if (!$this->contenu_loaded) { $this->charger_contenu(); }
	return $this->tvas;
}

function getMontant_ht () {
	if (!$this->contenu_loaded) { $this->charger_contenu(); }
	return $this->montant_ht;
}

function getMontant_tva () {
	if (!$this->contenu_loaded) { $this->charger_contenu(); }
	return $this->montant_tva;
}

function getMontant_ttc () {
	if ($this->montant_ttc == "-1") { $this->calcul_montant_to_pay (); }
	return $this->montant_ttc;
}

function getMontant_to_pay () {
	$this->calcul_montant_to_pay (); 
	return $this->montant_to_pay;
}
 
function getLiaisons () {
	if (!$this->liaisons_loaded) { $this->charger_liaisons(); }
	return $this->liaisons;
}

function getLiaisons_possibles () {
	if (!$this->liaisons_possibles_loaded) { $this->charger_liaisons_possibles(); }
	return $this->liaisons_possibles;
}
 
function getEvents () {
	if (!$this->events_loaded) { $this->charger_events(); }
	return $this->events;
}

function getReglements () {
	if (!$this->reglements_loaded) { $this->charger_reglements(); }
	return $this->reglements;
}

function getEcheancier () {
	if (!($this->echeancier instanceof document_echeancier)) { $this->echeancier = new document_echeancier($this->getRef_doc(),$this); }
	return $this->echeancier->get_echeances_etat();
}

function getEcheancierObj () {
	return $this->echeancier;
}

function getNb_echeances_restantes () {
	if (!($this->echeancier instanceof document_echeancier)) { $this->echeancier = new document_echeancier($this->getRef_doc(),$this); }
	return $this->echeancier->get_Nb_echeances_restantes();
}

function getCommerciaux () {
	if (!$this->commerciaux_loaded) { $this->charger_commerciaux(); }
	return $this->commerciaux;
}
 
function getQuantite_locked () {
	return $this->quantite_locked;
}

function getId_type_groupe () {
		global $bdd;

	$query = "SELECT id_type_groupe 
						FROM documents_types
						WHERE id_type_doc = '".$this->ID_TYPE_DOC."' ";
	$resultat = $bdd->query ($query);
	if ($tmp = $resultat->fetchObject()){
		return $tmp->id_type_groupe;
	}else{
		return false;
	}
}

static function Id_type_groupe ($id_type_doc) {
		global $bdd;

	$query = "SELECT id_type_groupe 
						FROM documents_types
						WHERE id_type_doc = '".$id_type_doc."' ";
	$resultat = $bdd->query ($query);
	if ($tmp = $resultat->fetchObject()){
		return $tmp->id_type_groupe;
	}else{
		return false;
	}
}

function getLivraison_line(){
    global $bdd;
    global $LIVRAISON_MODE_ART_CATEG;

    $query = "SELECT dl.*
            FROM docs_lines dl
            LEFT JOIN articles a ON a.ref_article = dl.ref_article
            WHERE ref_doc = '".$this->getRef_doc()."' AND a.ref_art_categ = '".$LIVRAISON_MODE_ART_CATEG."';";
    if ($resultat = $bdd->query($query)){
        if ( $livraison = $resultat->fetchObject() ){
            return $livraison;
        }
    }
    return false;
}

function getID_TYPE_DOC () {
	return $this->ID_TYPE_DOC;
}

function getLIB_TYPE_DOCUMENT () {
	return $this->LIB_TYPE_DOC;
}
 
function getCODE_DOC () {
	return $this->CODE_DOC;
}
 
function getDEFAUT_ID_ETAT () {
	return $this->DEFAUT_ID_ETAT;
}

function getID_ETAT_ANNULE () {
	return $this->ID_ETAT_ANNULE;
}

function getGESTION_SN() {
	return $this->GESTION_SN;
}

function getDOC_ID_REFERENCE_TAG() {
	return $this->DOC_ID_REFERENCE_TAG;
}

function getACCEPT_REGMT() {
	return $this->ACCEPT_REGMT;
}

function getCode_file () {
	return $this->code_file;
}

function getid_stock_search () {
	global $_SESSION;
	if (isset($this->id_stock)) {return $this->id_stock;}
	if (isset($this->id_stock_source)) {return $this->id_stock_source;}
	return $_SESSION['magasin']->getId_stock();
}

function getDoc_line_infos_supp () {
	return $this->doc_line_infos_supp ();
}


function getInfos_line ($ref_doc_line) {
	return $this->charger_line ($ref_doc_line);
}

function setAppTarifs($apptarifs) {
  $this->app_tarifs = $apptarifs;
} 

function getNb_lignes_liees($ref_doc_line){
	global $bdd;
	$query = "SELECT COUNT('ref_doc_line') AS nb 
				FROM docs_lines 
				WHERE ref_doc_line_parent = '" . $ref_doc_line . "' 
				AND ref_doc = '" . $this->ref_doc . "';";
	$res = $bdd->query($query);
	if ($tmp = $res->fetchObject()){
		return $tmp->nb;
	}else{
		return 0;
	}
}

function getMontant_echu(){
	
	$montant_echu 		= false;
	$montant_acquite 	= 0;
	$montant_terme 		= 0;
	
	$liste_reglements = $this->getReglements ();
	foreach ($liste_reglements as $liste_reglement) {
		if ($liste_reglement->valide) {
		$montant_acquite += $liste_reglement->montant_on_doc;
		}
	}
	
	$echeances = $this->getEcheancier();
	foreach ($echeances as $echeance) {
		if ($echeance->etat == 3){
			$montant_terme += $echeance->montant;
		}
	}
	$montant_echu = ($montant_terme-$montant_acquite)>=0 ? ($montant_terme-$montant_acquite):0 ;
	return $montant_echu;
}

//Affichage des echeances et des reglements effectués
public function get_conditions_reglement($line_ech_max,$line_regl_max)
{
	global $bdd;
	global $MONNAIE;
	
	//Tableau pour stocker les lignes concernant le reglement
	$resultat=array();
	$result=array();
	$document_echeances=array();
	$echeance=array();
	//Date de début de la première echeance
	$date_debut=$this->echeancier->get_Date_ref();
	$date_echeance_debut=$date_echeance_fin="";
	$delai_depuis_debut=0;
	//compteur de boucle
	$i=0;
	$doc="";
	
	//Tableau des correspondances id->abrev_mode_reglement
	$query = "SELECT abrev_reglement_mode FROM reglements_modes";
	$result = $bdd->query ($query);
	while ($tmp = $result->fetchObject()) { $doc[] = $tmp; }
	
	//Récupération des échéances et de leur état
	$echeance=$this->echeancier->get_echeances_etat();
	//Récupération du nombre d'echeances restantes
	$nb_echeances= $this->echeancier->get_Nb_echeances_restantes();
        $nb_echeances_debut = count($echeance);
	//Récupération du type de document concerné (si la facture est acquittée on affiche pas les echeances)
	if($this->getCODE_DOC()!="")
		$type_doc=$this->getCODE_DOC();
	else
		$type_doc="";

	//Si il existe un échéancier et si on souhaite l'afficher
	if(($this->echeancier->exist())&& ($line_ech_max > 0 ))
	{
		//Si le document n'est pas acquittée on affiche les echeances
                if((($this->getMontant_to_pay ()>0.01 ) || ($type_doc!="FAC") ))
		{
			foreach($echeance as $echeances)
			{
				//Déclaration d'un objet a transmettre
				$res = new stdclass;
				$res->type_reglement="";
				$res->pourcentage="";
				$res->montant="";
				$res->jour="";
				$res->echeance_restantes="";
				$res->date_solde_debut="";
				$res->date_solde_fin="";
				$res->montant_restant="";
				$res->nb_reglement_restant="";
				$res->date_reglement="";
				$res->mode_reglement="";
				
				//Récupération de l'echeance id
				$obj_echeance=new document_echeance($echeances->id_echeance);
				//Enregistrement type_reglement
				$res->type_reglement=$echeances->type_reglement;
				//1°ligne : accompte ou un arrhe affichage "'type', 'pourcent', 'soit montant'"
				if(($echeances->type_reglement=="Acompte"||$echeances->type_reglement=="Arrhes")&& $i<($line_ech_max-1))
				{
					//Pour calculer les dates
					$delai_depuis_debut+=$echeances->jour;
					$res->pourcentage=$echeances->pourcentage;
					$res->montant=price_format(round($echeances->montant,2))." $MONNAIE[0]";
					if($echeances->mode_reglement!="")
						$res->mode_reglement=$doc[$echeances->mode_reglement-1]->abrev_reglement_mode;
						
				}
				//Si c'est une Echeance ou un solde et qu'on a pas écrit plus de ligne que la limte($line_ech_max)
				else if((($echeances->type_reglement=="Echeance"||$echeances->type_reglement=="Solde") && $i<($line_ech_max-1))||($i==($line_ech_max-1)&&($i==($nb_echeances_debut-1))))
				{ 
					//Si c'est un paiement fin de mois
					if($obj_echeance->is_fdm())
					{
						$tab= explode("FDM",$echeances->jour);
						$delai_depuis_debut+=$tab[0];
						$res->jour=$tab[0]." jours fin de mois";
					}
					else
					{
						$delai_depuis_debut+=$echeances->jour;
						//Echeance à la facturation ou avec un délai
						if($echeances->jour==0)
							$res->jour=" à la facturation";
						else
                                                {
                                                    //***************************
                                                    if($echeances->date!="")
                                                    {
                                                        $res->jour=date_Us_to_Fr($echeances->date);
                                                    }
                                                    else
                                                    {
							$res->jour=$echeances->jour;
                                                    }
                                                }
							
					}
					if($echeances->pourcentage!="")
						$res->pourcentage=$echeances->pourcentage;
					$res->montant=price_format(round($echeances->montant,2))." $MONNAIE[0]";
					if($echeances->mode_reglement!="")
						$res->mode_reglement=$doc[$echeances->mode_reglement-1]->abrev_reglement_mode;
				}
				else //Si on est à la limite on résume
				{
					//Echeance restantes
					$echeances_restantes=$nb_echeances_debut-$i;
					//Calcul de la date de début d'echeance 3
					$timestamp_debut=strtotime($date_debut) + $delai_depuis_debut*24*3600;
					$date_echeance_debut=date('d-m-Y',$timestamp_debut);
					//Si on affiche qu'une ligne
					if($delai_depuis_debut==0)
						$date_echeance_debut=date("d-m-Y",strtotime($date_debut));
					
					$res->type_reglement="EcheanceResume";
						
					//Delai depuis début + durée echeance 3
					$delai_depuis_debut+=$echeances->jour;
					
					//Calculer nombre_jours jusqu'à la fin de la derniere echeance
					for($j=$i+1;$j<$nb_echeances;$j++)
					{
						//Si fin de mois ou non 
						if(strpos($echeance[$j]->jour,"FDM"))
						{
							$tab= explode("FDM",$echeance[$j]->jour);
							$delai_depuis_debut+=$tab[0];
						}
						else //pas en fin de mois 
						{
							$delai_depuis_debut+=$echeance[$j]->jour;
						}
	
					}
	
					//Calcul de la date de fin d'echeance
					$timestamp_debut=strtotime($date_debut) + $delai_depuis_debut*24*3600;
					$date_echeance_fin=date('d-m-Y',$timestamp_debut);
					$res->echeance_restantes=$echeances_restantes;
					$res->date_solde_debut=$date_echeance_debut;
					$res->date_solde_fin=$date_echeance_fin;
					//Enregistrement dans le tableau
					$resultat[$i] = $res;
					$i +=1;
					//Fin du résumé
					break;
				}
				$resultat[$i] = $res;
				$i +=1;
			}
		}
	}
	//Variables pour stockage dans tableau resultat
	if($i != 0)
		$tmp=$i;
	else
		$tmp=0;
		
	$i=0;
	$j=0;
	$montant_cumule_reglement=0;
	$montant=0;

	//Si il y a des règlements déjà effectués et si on souhaite les afficher
	if((!empty($this->reglements)) && ($type_doc!="DEV") && ($line_regl_max > 0 ))
	{
		//Compter le nombre de reglements
		foreach($this->reglements as $paiement)
		{
			if(!empty($paiement))
			{
				$j+=1;
				$montant_cumule_reglement+=round($paiement->montant_reglement,2);
			}
		}
		foreach($this->reglements as $paiement)
		{
			//Déclaration d'un objet a transmettre
			$res = new stdclass;
			$res->type_reglement="Reglement";
			$res->pourcentage="";
			$res->montant="";
			$res->jour="";
			$res->echeance_restantes="";
			$res->date_solde_debut="";
			$res->date_solde_fin="";
			$res->montant_restant="";
			$res->nb_reglement_restant="";
			$res->date_reglement="";
			$res->mode_reglement="";
				
			//Calcul de la date de reglement 
			$date_reglement=explode(" ",$paiement->date_reglement);
			$timestamp_debut=strtotime($date_reglement[0]); 
			$date_reglement=date('d-m-Y',strtotime(" 0 day",$timestamp_debut));
				
			//Si c'est un règlement normal on affiche les $line_regl_max
			if(($i<($line_regl_max-1)) || ($i==($line_regl_max-1) &&($j==$i+1)))
			{
				//Calcul montant total regle
				$montant_cumule_reglement+=round($paiement->montant_reglement,2);
				$res->date_reglement=$date_reglement;
				$res->montant=price_format(round($paiement->montant_reglement,2))." $MONNAIE[0]";
				$res->mode_reglement=$paiement->abrev_reglement_mode;
			}
			else //Résumer les reglements
			{
				$h=0;
				//Calculer le total des reglements non affichés effectués
				foreach($this->reglements as $paiement)
				{
					if((!empty($paiement))&&($h>=$i)&&($h<$j))
					{
						$montant+=$paiement->montant_reglement;
					}
					$h++;
				}
				$res->type_reglement="ReglementResume";
				$res->nb_reglement_restant=($j-$i);
				$res->montant= price_format(round($montant,2))." $MONNAIE[0]";					
				//Calcul montant total regle
				$resultat[$tmp] = $res;
				break;
			}
			$resultat[$tmp] = $res;
			$tmp+=1;
			$i+=1;
		}
	}
	//pas d'échéancier on ne modifie rien
	return $resultat;
}

}

?>
