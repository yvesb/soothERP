<?php
// *************************************************************************************************************
// CLASSE PERMETTANT LA GESTION D'UN CONTACT AYANT LE PROFIL [FOURNISSEUR]  
// *************************************************************************************************************

class contact_fournisseur extends contact_profil {

	private $ref_fournisseur; 				// Référence du contact
  private $id_fournisseur_categ; 		// Identifiant de la catégorie du fournisseur
  private $code_client;							// Code client de la société chez ce fournisseur 
  private $ref_acheteur;						// Ref_contact du collab acheteur auprès de ce fournisseur 
  private $conditions_commerciales; // Conditions commerciales
  private $id_stock_livraison;			// Stock de livraison par défaut
  private $defaut_numero_compte;		// numéro de compte comptable par défaut
  private $delai_livraison;					// Délai habituel de livraison



function __construct ($ref_fournisseur = "", $action = "open") {
	global $bdd;
	global $DEFAUT_COMPTE_TIERS_ACHAT;

	// Controle si la ref_contact est précisée
	if (!$ref_fournisseur) { return false; }
	$this->ref_fournisseur = $ref_fournisseur;
	
	if ($action == "create") {
		return false;
	}

	$query = "SELECT af.ref_fournisseur, af.id_fournisseur_categ, code_client, af.ref_acheteur, af.conditions_commerciales,
									 af.id_stock_livraison, af.delai_livraison, af.app_tarifs, af.defaut_numero_compte,
									fc.defaut_numero_compte as categ_defaut_numero_compte					
					FROM annu_fournisseur af
						LEFT JOIN fournisseurs_categories fc ON fc.id_fournisseur_categ = af.id_fournisseur_categ
						LEFT JOIN plan_comptable pc ON pc.numero_compte = fc.defaut_numero_compte
						WHERE ref_fournisseur = '".$this->ref_fournisseur."' ";	
	$resultat = $bdd->query ($query);

	// Controle si la ref_contact (fournisseur) est trouvée
	if (!$contact_fournisseur = $resultat->fetchObject()) { return false; }
	
	$this->ref_fournisseur 			= $contact_fournisseur->ref_fournisseur;
	$this->id_fournisseur_categ = $contact_fournisseur->id_fournisseur_categ;
	$this->code_client 					= $contact_fournisseur->code_client;
	$this->ref_acheteur 				= $contact_fournisseur->ref_acheteur;
	$this->conditions_commerciales 	= $contact_fournisseur->conditions_commerciales;
  $this->id_stock_livraison		= $contact_fournisseur->id_stock_livraison;
  $this->delai_livraison			= $contact_fournisseur->delai_livraison;
	$this->app_tarifs 					= $contact_fournisseur->app_tarifs;
	$this->defaut_numero_compte = $contact_fournisseur->defaut_numero_compte;
	//remplissage du numéro de compte achat par soit celui de la ctegorie fournisseur
	if (!$this->defaut_numero_compte) {
	$this->defaut_numero_compte = $contact_fournisseur->categ_defaut_numero_compte;
	}
	//soit par celui par defaut
	if (!$this->defaut_numero_compte) {
	$this->defaut_numero_compte = $DEFAUT_COMPTE_TIERS_ACHAT;
	}
	$this->ref_contact 					= $this->ref_fournisseur;

	$this->profil_loaded 	= true;
}



// *************************************************************************************************************
// CREATION DES INFORMATIONS DU PROFIL [FOURNISSEUR]  
// *************************************************************************************************************
function create_infos ($infos) {
	global $DIR, $CONFIG_DIR;
	global $bdd;
	global $DEFAUT_ID_FOURNISSEUR_CATEG;
	global $DEFAUT_ID_STOCK_LIVRAISON;
	global $DEFAUT_APP_TARIFS_FOURNISSEUR;

	// Controle si ces informations sont déjà existantes
	if ($this->profil_loaded) {
		return false;
	}

	// Fichier de configuration de ce profil
	include_once ($CONFIG_DIR."profil_fournisseur.config.php");
		
	// *************************************************
	// Controle des informations
	$this->id_fournisseur_categ = $DEFAUT_ID_FOURNISSEUR_CATEG; 
	if (isset($infos['id_fournisseur_categ']) && $infos['id_fournisseur_categ']) {	
		$this->id_fournisseur_categ = $infos['id_fournisseur_categ']; 
	}

	$this->code_client = "";
	if (isset($infos['code_client']) && $infos['code_client']) { 
		$this->code_client = $infos['code_client'];
	}
	/*
	if (isset($infos['ref_acheteur']) && $infos['ref_acheteur']) { 
		$this->ref_acheteur = $infos['ref_acheteur'];
	}
	else {
		// *************************************************
		// Informations par défaut pour la catégorie
		$query = "SELECT ref_acheteur
							FROM fournisseurs_categories
							WHERE id_fournisseur_categ = '".$this->id_fournisseur_categ."' ";
		$resultat = $bdd->query ($query);
		$categorie = $resultat->fetchObject();
		$this->ref_acheteur = $categorie->ref_acheteur;
	}
	*/
	$this->conditions_commerciales = "";
	if (isset($infos['conditions_commerciales'])) { 
		$this->conditions_commerciales = $infos['conditions_commerciales'];
	}
	$this->id_stock_livraison = $DEFAUT_ID_STOCK_LIVRAISON;
	if (isset($infos['id_stock_livraison']) && is_numeric($infos['id_stock_livraison'])) { 
		$this->id_stock_livraison = $infos['id_stock_livraison'];
	}
	if (isset($infos['delai_livraison']) && is_numeric($infos['delai_livraison'])) { 
		$this->delai_livraison = $infos['delai_livraison'];
	}
	$this->app_tarifs = $DEFAUT_APP_TARIFS_FOURNISSEUR;
	if (isset($infos['app_tarifs']) && $infos['app_tarifs']) {
		$this->app_tarifs = $infos['app_tarifs'];
	}
	//$this->ref_acheteur 			= $infos['ref_acheteur'];

	
	$this->defaut_numero_compte = "";
	if (isset($infos['defaut_numero_compte']) ) { 
		$this->defaut_numero_compte = substr($infos['defaut_numero_compte'], 0, 10);
		
		$compte_plan_general = new compta_plan_general ();
		$tmp_ctpinfos = array();
		$tmp_ctpinfos['numero_compte'] 	= $this->defaut_numero_compte;
		$tmp_ctpinfos['lib_compte'] 		= $this->defaut_numero_compte;
		$tmp_ctpinfos['favori'] 		= 1;
		//création du compte
		$compte_plan_general->create_compte_plan_comptable ($tmp_ctpinfos);
		//on supprime le global alerte que peut générer la cration du compte pour ne pas bloquer la création du contact
		if (isset($GLOBALS['_ALERTES']['numero_compte_vide'])) {unset($GLOBALS['_ALERTES']['numero_compte_vide']);}
		if (isset($GLOBALS['_ALERTES']['exist_numero_compte'])) {unset($GLOBALS['_ALERTES']['exist_numero_compte']);}
	}

	// *************************************************
	// Arret en cas d'erreur
	if (count($GLOBALS['_ALERTES'])) {
		return false;
	}

	// *************************************************
	// Insertion des données
	$query = "INSERT INTO annu_fournisseur 
							(ref_fournisseur, id_fournisseur_categ, code_client, ref_acheteur, conditions_commerciales, 
							 id_stock_livraison, delai_livraison, app_tarifs, defaut_numero_compte )
						VALUES ('".$this->ref_fournisseur."', ".num_or_null($this->id_fournisseur_categ).",
						 				'".addslashes($this->code_client)."', NULL, '".addslashes($this->conditions_commerciales)."',
						  			".num_or_null($this->id_stock_livraison).", '".$this->delai_livraison."', '".$this->app_tarifs."', '".$this->defaut_numero_compte."')";
	$bdd->exec($query);

	return true;
}



// *************************************************************************************************************
// MODIFICATION DES INFORMATIONS DU PROFIL [FOURNISSEUR]  
// *************************************************************************************************************
function maj_infos ($infos) {
	global $bdd;
	global $DEFAUT_ID_FOURNISSEUR_CATEG;
	global $DEFAUT_ID_STOCK_LIVRAISON;

	if (!$this->profil_loaded) {
		$GLOBALS['_ALERTES']['profil_non_chargé'] = 1;
	}

	// *************************************************
	// Controle des informations
	$this->id_fournisseur_categ = $DEFAUT_ID_FOURNISSEUR_CATEG; 
	if (isset($infos['id_fournisseur_categ']) && $infos['id_fournisseur_categ']) {	
		$this->id_fournisseur_categ = $infos['id_fournisseur_categ']; 
	}

	if ($infos['app_tarifs'] != "HT" && $infos['app_tarifs'] != "TTC") {
		$GLOBALS['_ALERTES']['bad_app_tarifs'] = 1;
	}
	
	$this->code_client = "";
	if (isset($infos['code_client']) && $infos['code_client']) { 
		$this->code_client = $infos['code_client'];
	}
	/*
	if (isset($infos['ref_acheteur']) && $infos['ref_acheteur']) { 
		$this->ref_acheteur = $infos['ref_acheteur'];
	}
	else {
		// *************************************************
		// Informations par défaut pour la catégorie
		$query = "SELECT ref_acheteur
							FROM fournisseurs_categories
							WHERE id_fournisseur_categ = '".$this->id_fournisseur_categ."' ";
		$resultat = $bdd->query ($query);
		$categorie = $resultat->fetchObject();
		$this->ref_acheteur = $categorie->ref_acheteur;
	}
	*/
	$this->conditions_commerciales = "";
	if (isset($infos['conditions_commerciales'])) { 
		$this->conditions_commerciales = $infos['conditions_commerciales'];
	}
	$this->id_stock_livraison = $DEFAUT_ID_STOCK_LIVRAISON;
	if (isset($infos['id_stock_livraison']) && is_numeric($infos['id_stock_livraison'])) { 
		$this->id_stock_livraison = $infos['id_stock_livraison'];
	}
	if (isset($infos['delai_livraison']) && is_numeric($infos['delai_livraison'])) { 
		$this->delai_livraison = $infos['delai_livraison'];
	}


	$this->id_fournisseur_categ = $infos['id_fournisseur_categ'];
	$this->code_client 					= $infos['code_client'];
	//$this->ref_acheteur 			= $infos['ref_acheteur'];
	$this->conditions_commerciales 	= $infos['conditions_commerciales'];
  $this->id_stock_livraison		= $infos['id_stock_livraison'];
  $this->delai_livraison			= $infos['delai_livraison'];
	$this->app_tarifs 					= $infos['app_tarifs'];

	// Si App_tarifs en automatique on récupére l'app_tarifs le l'annuaire_categorie du contact
	if (!$this->app_tarifs) {	
		$query = "SELECT ac.app_tarifs
							FROM annuaire a
								LEFT JOIN annuaire_categories ac ON a.id_categorie = ac.id_categorie
							WHERE ref_contact = '".$this->ref_contact."' ";
		$resultat = $bdd->query ($query);
		if ($annuaire_categories = $resultat->fetchObject()) {
			$this->app_tarifs = $annuaire_categories->app_tarifs; 
		}
	}
	// *************************************************
	// Arret en cas d'erreur
	if (count($GLOBALS['_ALERTES'])) {
		return false;
	}


	// *************************************************
	// Mise à jour des données
	$query = "UPDATE annu_fournisseur 
						SET id_fournisseur_categ = ".num_or_null($this->id_fournisseur_categ).", 
								code_client = '".addslashes($this->code_client)."', ref_acheteur = NULL, 
								conditions_commerciales = '".addslashes($this->conditions_commerciales)."',
								id_stock_livraison = ".num_or_null($this->id_stock_livraison).", 
								delai_livraison = '".$this->delai_livraison."', 
								app_tarifs = '".$this->app_tarifs."' 
						WHERE ref_fournisseur = '".$this->ref_fournisseur."' ";
	$bdd->exec($query);

	return true;
}

//mise à jour de l'app_tarif du profil
function maj_app_tarifs ($app_tarifs) {
	global $bdd;

	if ($app_tarifs == "HT" || $app_tarifs = "TTC") {
		$this->app_tarifs = $app_tarifs;	
		$query = "UPDATE annu_fournisseur 
							SET app_tarifs = '".$this->app_tarifs."' 
							WHERE ref_fournisseur = '".$this->ref_fournisseur."' ";
		$bdd->exec($query);
	}
	return true;
}


//mise à jour du defaut_numero_compte du profil
function maj_defaut_numero_compte ($defaut_numero_compte) {
	global $bdd;

		$this->defaut_numero_compte = $defaut_numero_compte;	
		$query = "UPDATE annu_fournisseur 
							SET defaut_numero_compte = '".$this->defaut_numero_compte."' 
							WHERE ref_fournisseur = '".$this->ref_fournisseur."' ";
		$bdd->exec($query);
	return true;
}




// *************************************************************************************************************
// SUPPRESSION DES INFORMATIONS DU PROFIL [FOURNISSEUR]  
// *************************************************************************************************************
function delete_infos () {
	global $bdd;

	// Vérifie si la suppression de ces informations est possible.

	// Supprime les informations
	$query = "DELETE FROM annu_fournisseur WHERE ref_fournisseur = '".$this->ref_fournisseur."' ";
	$bdd->exec($query); 


	if (count($GLOBALS['_ALERTES'])) {
		return false;
	}

	return true;
}



// *************************************************************************************************************
// TRANSFERT DES INFORMATIONS DU PROFIL [FOURNISSEUR]  
// *************************************************************************************************************
function transfert_infos ($new_contact, $is_already_profiled) {
	global $bdd;

	// Vérifie si le transfert de ces informations est possible.
	if (!$is_already_profiled) {
		// TRANSFERT les informations
		$query = "UPDATE annu_fournisseur SET ref_fournisseur = '".$new_contact->getRef_contact()."' 
							WHERE ref_fournisseur = '".$this->ref_contact."'";
		$bdd->exec($query); 
	}

	$query = "UPDATE articles_ref_fournisseur SET ref_fournisseur = '".$new_contact->getRef_contact()."'
						WHERE ref_fournisseur = '".$this->ref_contact."'";
	$bdd->exec($query); 

	// *************************************************
	// Arret en cas d'erreur
	if (count($GLOBALS['_ALERTES'])) {
		return false;
	}

	return true;
}


// *************************************************************************************************************
// FONCTIONS DIVERSES 
// *************************************************************************************************************

// Chargement des derniers documents en cours concernant ce client
function charger_last_docs ($id_type_doc , $is_open = 0) {
	global $bdd;
	global $CONTACT_NB_LAST_DOCS_SHOWED;

	$last_docs = array();
	$query = "SELECT d.ref_doc, d.date_creation_doc date_creation, dt.lib_type_doc, de.lib_etat_doc, 
									 SUM(ROUND(dl.qte * dl.pu_ht * (1-dl.remise/100) * (1+dl.tva/100),2)) as montant_ttc
						FROM documents d 
							LEFT JOIN docs_lines dl ON dl.ref_doc = d.ref_doc && dl.visible = 1
							LEFT JOIN documents_types dt ON d.id_type_doc = dt.id_type_doc
							LEFT JOIN documents_etats de ON d.id_etat_doc = de.id_etat_doc
						WHERE d.ref_contact = '".$this->ref_contact."' && dl.ref_doc_line_parent IS NULL && de.is_open = '".$is_open."' && d.id_type_doc = '".$id_type_doc."' 
						GROUP BY d.ref_doc 
						ORDER BY date_creation DESC, d.id_type_doc ASC
						LIMIT 0,".$CONTACT_NB_LAST_DOCS_SHOWED;
	$resultat = $bdd->query ($query);
	while ($doc = $resultat->fetchObject()) { 
		$last_docs[] = $doc;
	}
	return $last_docs;
}


//chargement du CA du client
function charger_fournisseur_CA () {
	global $bdd;
	
	$last_exercices = compta_exercices::charger_compta_exercices ();
	$liste_CA = array();
	for ($i = 0; $i < 3 ; $i++) {
		$montant_CA = 0;
		if (!isset($last_exercices[$i])) { break;}
		$query = "SELECT SUM(ROUND(dl.qte * dl.pu_ht * (1-dl.remise/100) ,2)) as montant_ttc
							FROM documents d 
								LEFT JOIN docs_lines dl ON dl.ref_doc = d.ref_doc && dl.visible = 1
								LEFT JOIN documents_types dt ON d.id_type_doc = dt.id_type_doc
								LEFT JOIN documents_etats de ON d.id_etat_doc = de.id_etat_doc
							WHERE d.ref_contact = '".$this->ref_contact."' && dl.ref_doc_line_parent IS NULL && d.id_etat_doc IN (32, 34 , 35)
										&& date_creation_doc < '".$last_exercices[$i]->date_fin."' && date_creation_doc > '".$last_exercices[$i]->date_debut."' 
							GROUP BY d.ref_doc 
							ORDER BY date_creation_doc DESC, d.id_type_doc ASC
							";
		$resultat = $bdd->query ($query);
		while ($doc = $resultat->fetchObject()) { 
			$montant_CA += $doc->montant_ttc;
		}
		$liste_CA[$i] = $montant_CA;
	}
	
	
	return $liste_CA;
}
// *************************************************************************************************************
// FONCTIONS DE GESTION DES CATEGORIES DE FOURNISSEUR
// *************************************************************************************************************
static public function charger_fournisseurs_categories  () {
	global $bdd;
	
	$fournisseurs_categories = array();
	$query = "SELECT id_fournisseur_categ , lib_fournisseur_categ, ref_acheteur, defaut_numero_compte, note,
									pc.lib_compte as defaut_lib_compte
						FROM fournisseurs_categories 
						LEFT JOIN plan_comptable pc ON pc.numero_compte = defaut_numero_compte
						ORDER BY lib_fournisseur_categ ";
	$resultat = $bdd->query ($query);
	while ($var = $resultat->fetchObject()) { $fournisseurs_categories[] = $var; }

	return $fournisseurs_categories;
}


static public function create_fournisseurs_categories ($infos) {
	global $bdd;

	// *************************************************
	// Insertion des données
	$query = "INSERT INTO fournisseurs_categories (lib_fournisseur_categ, ref_acheteur, note) 
						VALUES ('".addslashes($infos['lib_fournisseur_categ'])."', NULL,  '".addslashes($infos['note'])."')"; 
	$bdd->exec($query);

	return true;
}


static public function maj_infos_fournisseurs_categories  ($infos) {
	global $bdd;
	
	// *************************************************
	// Mise à jour des données
	$query = "UPDATE fournisseurs_categories  
						SET lib_fournisseur_categ = '".addslashes($infos['lib_fournisseur_categ'])."', 
						ref_acheteur = NULL, 
						note = '".addslashes($infos['note'])."' 
						WHERE id_fournisseur_categ = '".$infos['id_fournisseur_categ']."' ";
	$bdd->exec($query);
	
	return true;
}

static public function maj_defaut_numero_compte_categories  ($infos) {
	global $bdd;
	
	// *************************************************
	// Mise à jour des données
	$query = "UPDATE fournisseurs_categories  
						SET defaut_numero_compte = '".addslashes($infos['defaut_numero_compte'])."'
						WHERE id_fournisseur_categ = '".$infos['id_fournisseur_categ']."' ";
	$bdd->exec($query);
	
	return true;
}


static public function delete_infos_fournisseurs_categories  ($id_fournisseur_categ) {
	global $bdd;
	global $DEFAUT_ID_FOURNISSEUR_CATEG;
	
	echo $DEFAUT_ID_FOURNISSEUR_CATEG; 
	if ($id_fournisseur_categ == $DEFAUT_ID_FOURNISSEUR_CATEG) {
		$GLOBALS['_ALERTES']['last_id_fournisseur_categ'] = 1;
	}
	// Vérifie si la suppression de ces informations est possible.
	if (count($GLOBALS['_ALERTES'])) {
		return false;
	}
	// *************************************************
	// Mise à jour des données
	$query = "DELETE FROM fournisseurs_categories WHERE id_fournisseur_categ = '".$id_fournisseur_categ."' ";
	$bdd->exec($query);
	
	return true;
}



// *************************************************************************************************************
// FONCTIONS DE LECTURE DES DONNEES 
// *************************************************************************************************************
function getRef_fournisseur () {
	return $this->ref_fournisseur;
}

function getId_fournisseur_categ () {
	return $this->id_fournisseur_categ;
}

function getCode_client () {
	return $this->code_client;
}

function getRef_acheteur () {
	return $this->ref_acheteur;
}

function getApp_tarifs () {
	return $this->app_tarifs;
}

function getDefaut_numero_compte () {
	return $this->defaut_numero_compte;
}

function getConditions_commerciales () {
	return $this->conditions_commerciales;
}

function getId_stock_livraison () {
	return $this->id_stock_livraison;
}

function getDelai_livraison () {
	return $this->delai_livraison;
}




}

?>