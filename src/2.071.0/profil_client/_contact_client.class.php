<?php
// *************************************************************************************************************
// CLASSE PERMETTANT LA GESTION D'UN CONTACT AYANT LE PROFIL [CLIENT]  
// *************************************************************************************************************

class contact_client extends contact_profil  {
	private $ref_contact;							// Référence du contact

  private $id_client_categ; 				// Identifiant de la catégorie du client
  private $type_client; 						// type de client
  private $id_tarif;								// Identifiant de la grille tarifaire
  private $ref_commercial;					// Ref_contact du commercial de ce client
 
  private $ref_adr_livraison; 			// Adresse de livraison
  private $ref_adr_facturation; 		// Adresse de facturation
  private $app_tarifs; 							// Tarif affichés en HT ou TTC
  
  private $facturation_periodique;	// Nombre de facture par mois 
  private $encours;									// Crédit maximum accordé 
  private $delai_reglement;					// Délai de règlement des factures
  private $prepaiement_ratio;				// % réglé a la commande
  private $prepaiement_type;				// Acompte ou Arrhes
  private $id_reglement_mode_favori;// Mode de reglement par defaut
  private $id_cycle_relance;
  private $id_edition_mode_favori;	// Mode d'edition par defaut
  private $defaut_numero_compte;		// numéro de compte comptable par défaut
	

function __construct ($ref_contact, $action = "open") {
	global $DIR;
	global $bdd;
	global $DEFAUT_COMPTE_TIERS_VENTE;
	
	$this->ref_contact = $ref_contact;
	// Controle si la ref_contact est précisée
	if (!$ref_contact) { return false; }
	$this->ref_contact = $ref_contact;
	
	if ($action == "create") {
		return false;
	}

	$query = "SELECT ac.ref_contact, ac.id_client_categ, ac.type_client, ac.id_tarif, ac.ref_commercial, ac.ref_adr_livraison, ac.ref_adr_facturation, ac.app_tarifs, ac.facturation_periodique, ac.encours, ac.delai_reglement, 
									ac.defaut_numero_compte, ac.prepaiement_ratio, ac.prepaiement_type, ac.id_reglement_mode_favori, ac.id_relance_modele, ac.id_edition_mode_favori, 
									cc.defaut_numero_compte as categ_defaut_numero_compte	, 
									a.nom as nom_commercial		
									
						FROM annu_client ac
						LEFT JOIN clients_categories cc ON cc.id_client_categ = ac.id_client_categ
						LEFT JOIN annuaire a ON a.ref_contact = ac.ref_commercial
						LEFT JOIN plan_comptable pc ON pc.numero_compte = ac.defaut_numero_compte
						WHERE ac.ref_contact = '".$this->ref_contact."' ";	
	$resultat = $bdd->query ($query);

	// Controle si la ref_contact (client) est trouvée
	if (!$contact_client = $resultat->fetchObject()) { return false; }
	
	$this->ref_contact 			= $contact_client->ref_contact;
	$this->id_client_categ 			= $contact_client->id_client_categ;
	$this->type_client		 	= $contact_client->type_client;
	$this->id_tarif 			= $contact_client->id_tarif;
	$this->ref_commercial 			= $contact_client->ref_commercial;
	$this->nom_commercial 			= $contact_client->nom_commercial;
	$this->ref_adr_livraison 		= $contact_client->ref_adr_livraison;
	$this->ref_adr_facturation              = $contact_client->ref_adr_facturation;
	$this->app_tarifs 			= $contact_client->app_tarifs;
	$this->facturation_periodique		= $contact_client->facturation_periodique;
	$this->encours				= $contact_client->encours;
	$this->delai_reglement			= $contact_client->delai_reglement;
	$this->defaut_numero_compte             = $contact_client->defaut_numero_compte;
	$this->prepaiement_ratio		= $contact_client->prepaiement_ratio;
	$this->prepaiement_type			= $contact_client->prepaiement_type;
	$this->id_reglement_mode_favori         = $contact_client->id_reglement_mode_favori;
	$this->id_cycle_relance			= $contact_client->id_relance_modele;
	$this->id_edition_mode_favori           = $contact_client->id_edition_mode_favori;
	
	//remplissage du numéro de compte achat par soit celui de la categorie client
	if (!$this->defaut_numero_compte) {
	$this->defaut_numero_compte = $contact_client->categ_defaut_numero_compte;
	}
	//soit par celui par defaut
	if (!$this->defaut_numero_compte) {
	$this->defaut_numero_compte = $DEFAUT_COMPTE_TIERS_VENTE;
	}

	$this->profil_loaded 	= true;
}



// *************************************************************************************************************
// CREATION DES INFORMATIONS DU PROFIL [CLIENT]  
// *************************************************************************************************************
function create_infos ($infos) {
        global $DIR, $CONFIG_DIR;
        // Fichier de configuration de ce profil
	require ($CONFIG_DIR."profil_client.config.php");
	global $bdd; 
	//global $DEFAUT_ID_CLIENT_CATEG;
	global $DEFAUT_ENCOURS_CLIENT;
	global $DEFAUT_APP_TARIFS_CLIENT;
	global $COMMERCIAL_ID_PROFIL;

	// Controle si ces informations sont déjà existantes
	if ($this->profil_loaded) {
		return false;
	}

	// *************************************************
	// Controle des informations
	$this->id_client_categ = $DEFAUT_ID_CLIENT_CATEG;
	if (isset($infos['id_client_categ']) && $infos['id_client_categ'] ) {	
		$this->id_client_categ = $infos['id_client_categ']; 
	}

        $this->ref_commercial = "NULL";
        if(isset($infos['ref_commercial'])){
            $query = "SELECT ref_commercial FROM clients_categories WHERE id_client_categ = '".$this->id_client_categ."' ";
            $resultat = $bdd->query ($query);
            if ($categorie = $resultat->fetchObject()) {
                    $ref_commercial = $categorie->ref_commercial;
                    if ($ref_commercial == $infos['ref_commercial']){
                        $this->ref_commercial = "NULL";
                    }else{
                        $this->ref_commercial = $infos['ref_commercial'];
                    }
            }
            
        }

	/*$this->ref_commercial = "NULL";
	// *************************************************
	// Informations par défaut pour la catégorie
	$query = "SELECT id_tarif, ref_commercial, facturation_periodique, delai_reglement, prepaiement_ratio, prepaiement_type, id_reglement_mode_favori, id_edition_mode_favori, defaut_encours
						FROM clients_categories
						WHERE id_client_categ = '".$this->id_client_categ."' ";
	$resultat = $bdd->query ($query);
	if ($categorie = $resultat->fetchObject()) {
		$this->ref_commercial 		= $categorie->ref_commercial;
	}*/

	

	
	// grille tarifaire
	if (isset($infos['id_tarif']))
	{
		if (($infos['id_tarif']!="") && (is_numeric($infos['id_tarif'])))
			$this->id_tarif = $infos['id_tarif'];
	}

	// facturation périodique
	if (isset($infos['facturation_periodique']))
	{
		if ((is_numeric($infos['facturation_periodique'])) && ($infos['facturation_periodique'] >= 0 && $infos['facturation_periodique'] <= 5))
		 	$this->facturation_periodique =$infos['facturation_periodique'];
	} 
	
	// en cours
	if (isset($infos['encours']))
	{
		if (($infos['encours']!="") || (is_numeric($infos['encours'])))
			$this->encours = $infos['encours']; 
	}
		
	if (isset($infos['delai_reglement']))
	{
		if (($infos['delai_reglement']!="") && (is_numeric($infos['delai_reglement'])))
			$this->delai_reglement = $infos['delai_reglement'];
	}
	if (isset($infos['delai_reglement_fdm']))
	{
		if ($infos['delai_reglement_fdm'] == 1)
			$this->delai_reglement .= "FDM";
	}	

	// ratio prépaiement
	if (isset($infos['prepaiement_ratio']))
	{
		if (($infos['prepaiement_ratio']!="") && (is_numeric($infos['prepaiement_ratio'])))
			$this->prepaiement_ratio = $infos['prepaiement_ratio'];
	}
	if (isset($infos['prepaiement_type']))
	{
		if ($infos['prepaiement_type']!="")
			$this->prepaiement_type = $infos['prepaiement_type'];
	}	

	// règlement favori par
	if (isset($infos['id_reglement_mode_favori']))
	{
		if (($infos['id_reglement_mode_favori']!="") && (is_numeric($infos['id_reglement_mode_favori'])))
			$this->id_reglement_mode_favori = $infos['id_reglement_mode_favori'];
	}
	// Cycle de relance
	if (isset($infos['id_cycle_relance']))
	{
		if (($infos['id_cycle_relance']!="") && (is_numeric($infos['id_cycle_relance'])))
			$this->id_cycle_relance = $infos['id_cycle_relance'];
	}
	
	// mode édition favori
	// bac 2.0.54.0 mise à vide valeurs non obligatoires
	if (isset($infos['id_edition_mode_favori']))
	{
		if ($infos['id_edition_mode_favori']!="" || is_numeric($infos['id_edition_mode_favori']))
			$this->id_edition_mode_favori = $infos['id_edition_mode_favori'];
	}


	// afficher tarifs
	// 0 Automatique, 1 HT, 2 TTC ( par défaut ttc )
	if (isset($infos['app_tarifs']))
	{
		if (($infos['app_tarifs']=="") || ($infos['app_tarifs']==0))
			$this->app_tarifs = $this->getApp_Tarifs_Categorie();
		else
		{
			if ($infos['app_tarifs']==1)
				$this->app_tarifs = 'HT';
			else
				$this->app_tarifs = 'TTC';
		}
	}
		
	//if (isset($infos['ref_commercial']) ) {
	//	$this->ref_commercial = $infos['ref_commercial'];
		if (!empty($this->ref_commercial) &&  $this->ref_commercial != 'NULL') {
			// Modification du profil
			$new_profils = array();
			$new_profils["id_profil"] = $COMMERCIAL_ID_PROFIL;
			$contact= new contact ($this->ref_commercial);
			if (!$contact->charger_profiled_infos ($new_profils["id_profil"])) {
				$contact->create_profiled_infos ($new_profils);
			}
		}
	//}
	
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


	// *****************************************************
	// Adresse de livraison
	if (isset($infos['ref_adr_livraison'])) {
		$this->ref_adr_livraison = $infos['ref_adr_livraison'];
	}
	if (!$this->ref_adr_livraison) { $this->ref_adr_livraison = 1; }
	// Traitements complémentaires liés à la phase de création
	if (is_numeric($this->ref_adr_livraison)) {
		$query = "SELECT ref_adresse FROM adresses 
							WHERE ref_contact = '".$this->ref_contact."' 
							LIMIT ".($this->ref_adr_livraison-1).", 1 "; 
		$resultat = $bdd->query ($query);
		if ($adresse = $resultat->fetchObject()) { $this->ref_adr_livraison = $adresse->ref_adresse; }
		else { $this->ref_adr_livraison = ""; }
	}
	// *****************************************************
	// Adresse de facturation
	if (isset($infos['ref_adr_facturation'])) {
		$this->ref_adr_facturation = $infos['ref_adr_facturation'];
	}
	if (!$this->ref_adr_facturation) { $this->ref_adr_facturation = 1; }
	if (is_numeric($this->ref_adr_facturation)) {
		$query = "SELECT ref_adresse FROM adresses 
							WHERE ref_contact = '".$this->ref_contact."' 
							LIMIT ".($this->ref_adr_facturation-1).", 1 "; 
		$resultat = $bdd->query ($query);
		if ($adresse = $resultat->fetchObject()) { $this->ref_adr_facturation = $adresse->ref_adresse; }
		else { $this->ref_adr_facturation = ""; }
	}

	
	if (!isset($infos['type_client']) || !$infos['type_client'] ) {	$infos['type_client'] = "piste";}
	$this->type_client = $infos['type_client'];
	// *************************************************
	// Arret en cas d'erreur
	if (count($GLOBALS['_ALERTES'])) {
		return false;
	}

	// *************************************************
	// Insertion des données
	
	$query = "INSERT INTO annu_client
							(	ref_contact, id_client_categ, type_client, 
								id_tarif, ref_commercial, 
								ref_adr_livraison, ref_adr_facturation, 
								app_tarifs, facturation_periodique, encours, 
								delai_reglement, 
								defaut_numero_compte, 
								prepaiement_ratio, prepaiement_type,
								id_reglement_mode_favori,
								id_relance_modele,
								id_edition_mode_favori)
						VALUES ('".$this->ref_contact."', ".num_or_null($this->id_client_categ).", '".$this->type_client."', 
										".num_or_null($this->id_tarif).", ".ref_or_null($this->ref_commercial).", 
										".ref_or_null($this->ref_adr_livraison).", ".ref_or_null($this->ref_adr_facturation).", 
										'".$this->app_tarifs."', ".num_or_null($this->facturation_periodique).",  ".num_or_null($this->encours).", 
										".text_or_null($this->delai_reglement).",
										'".$this->defaut_numero_compte."',
										".num_or_null($this->prepaiement_ratio).", ".text_or_null($this->prepaiement_type).",
										".num_or_null($this->id_reglement_mode_favori).",
										".num_or_null($this->id_cycle_relance).",
										".num_or_null($this->id_edition_mode_favori).")";
	$bdd->exec($query);


	return true;
}



// *************************************************************************************************************
// MODIFICATION DES INFORMATIONS DU PROFIL [CLIENT]  
// *************************************************************************************************************
function maj_infos ($infos) {
	global $bdd;
	global $COMMERCIAL_ID_PROFIL;
        _vardump($infos);
	if (!$this->profil_loaded) {
		$GLOBALS['_ALERTES']['profil_non_chargé'] = 1;
	}

	// *************************************************
	// Controle des informations
	if (!is_numeric($infos['id_client_categ'])) {
		$GLOBALS['_ALERTES']['bad_id_client_categ'] = 1;
	}
	else
		$this->id_client_categ 	= $infos['id_client_categ'];

	if ($infos['facturation_periodique']!="")
	{
		if ($infos['facturation_periodique'] > 5 || $infos['facturation_periodique'] < 0) {
			$GLOBALS['_ALERTES']['bad_facturation_periodique'] = 1;
		}
	}

	if (($infos['delai_reglement'] != "" ) && ($infos['delai_reglement'] != 'NULL')) {
		if (!is_numeric($infos['delai_reglement'])) {
			$GLOBALS['_ALERTES']['bad_delai_reglement'] = 1;
		}
	}
	
	$query = "SELECT 	facturation_periodique, id_edition_mode_favori, delai_reglement,
						id_reglement_mode_favori, id_relance_modele, defaut_encours, prepaiement_type,
						prepaiement_ratio, id_tarif, ref_commercial
						FROM clients_categories
						WHERE id_client_categ = '".$this->id_client_categ."' ";
	$resultat = $bdd->query ($query);
	if ($categorie = $resultat->fetchObject()) {
		$this->ref_commercial 		= $categorie->ref_commercial;
	}
	
	$fdm_tmp = $infos['delai_reglement'] ;
	if($fdm_tmp=="") $fdm_tmp = 0;	// si champ vide on le force à 0 sinon pas de maj.
	if ( isset($infos['delai_reglement_fdm']))
	{
		if ($infos['delai_reglement_fdm']==1)
			$fdm_tmp .= "FDM";
	}

	$this->app_tarifs = $this->getApp_Tarifs_Categorie();
	$app_tarifs = "";
	if ( $infos['app_tarifs'] == 0 ) {$app_tarifs = $this->app_tarifs;}
	if (($infos['app_tarifs'] == 1 ) || ($infos['app_tarifs'] == 'HT' ))  $app_tarifs = 'HT';
	if (($infos['app_tarifs'] == 2 ) || ($infos['app_tarifs'] == 'TTC' )) $app_tarifs = 'TTC';

	// si champ vide on le force à 0 sinon pas de maj.
	//if ( $infos['encours'] =="") $infos['encours']=0;
	//if ( $infos['prepaiement_ratio'] =="") $infos['prepaiement_ratio']=0;
	
	// on compare les valeurs de retour avec celles de la categorie, si != on les garde, si == on les met à null
	global $GESTION_COMM_COMMERCIAUX;
	if ($GESTION_COMM_COMMERCIAUX){
		$this->ref_commercial   	= $infos['ref_commercial'];
	}

        $this->ref_adr_livraison   	        = text_or_null($infos['ref_adr_livraison']);
	$this->ref_adr_facturation              = text_or_null($infos['ref_adr_facturation']);
	$this->type_client			= ucfirst(text_or_null($infos['type_client']));
	
	$this->facturation_periodique   	= num_or_null ($infos['facturation_periodique']);
	$this->id_edition_mode_favori   	= num_or_null ($infos['id_edition_mode_favori']);
	$this->delai_reglement 		 	= text_or_null($fdm_tmp);
	$this->id_reglement_mode_favori 	= num_or_null ($infos['id_reglement_mode_favori']);
	$this->id_cycle_relance		 	= num_or_null ($infos['id_cycle_relance']);
	$this->encours 		  		= num_or_null ($infos['encours']);
	$this->prepaiement_type 		= text_or_null($infos['prepaiement_type']);
	$this->prepaiement_ratio 	 	= num_or_null ($infos['prepaiement_ratio']);
	$this->id_tarif 		     	= num_or_null ($infos['id_tarif']);
	$this->app_tarifs		     	= text_or_null($infos['app_tarifs']);

        // cas des Non définis mis à "" != NULL
        if ( $this->id_edition_mode_favori   == "'0'" ) $this->id_edition_mode_favori = "NULL";
	if ( $this->id_reglement_mode_favori == "'0'" ) $this->id_reglement_mode_favori = "NULL";
	if ( $this->id_tarif == "'0'" ) 	$this->id_tarif = "NULL";

	
	// *************************************************
	// Arret en cas d'erreur
	if (count($GLOBALS['_ALERTES'])) {
		return false;
	}
	
	// *************************************************
	// Mise à jour des données		

	$query = "UPDATE annu_client SET ";
	$query.= "id_client_categ = "	     	 .$this->id_client_categ. ", ";
	$query.= "type_client = "		 		 .$this->type_client.", ";
        $query.= "ref_commercial = "             .ref_or_null($this->ref_commercial).", ";
	$query.= "ref_adr_livraison = "  	     .$this->ref_adr_livraison.", ";
	$query.= "ref_adr_facturation = "	     .$this->ref_adr_facturation.", ";
	
	$query.= "facturation_periodique = "	 .$this->facturation_periodique.", ";
	$query.= "id_edition_mode_favori = "	 .$this->id_edition_mode_favori.", "; 
	$query.= "delai_reglement = " 			 .$this->delai_reglement.", ";
	$query.= "id_reglement_mode_favori = " 	 .$this->id_reglement_mode_favori.", ";
	$query.= "id_relance_modele = " 	     .$this->id_cycle_relance.", ";
	$query.= "encours = "				     .$this->encours.", ";
	$query.= "prepaiement_type = "		 	 .$this->prepaiement_type.", ";
	$query.= "prepaiement_ratio = "		     .$this->prepaiement_ratio.", ";
	$query.= "id_tarif = "			 	 	 .$this->id_tarif.", ";
	$query.= "app_tarifs = "		 	     .$this->app_tarifs. "";
	$query.= " WHERE ref_contact = '"		 .$this->ref_contact."' ";	
	echo $query;
	$bdd->exec($query);

	return true;
}

//mise à jour de l'adresse facturation
function maj_ref_adr_facturation ($ref_adr_facturation) {
	global $bdd;

		$this->ref_adr_facturation = $ref_adr_facturation;	
		$query = "UPDATE annu_client 
							SET ref_adr_facturation = '".$this->ref_adr_facturation."' 
							WHERE ref_contact = '".$this->ref_contact."' ";
		$bdd->exec($query);
	return true;
}
//mise à jour de l'adresse livraison
function maj_ref_adr_livraison ($ref_adr_livraison) {
	global $bdd;

		$this->ref_adr_livraison = $ref_adr_livraison;	
		$query = "UPDATE annu_client 
							SET ref_adr_livraison = '".$this->ref_adr_livraison."' 
							WHERE ref_contact = '".$this->ref_contact."' ";
		$bdd->exec($query);
	return true;
}

//mise à jour de l'app_tarif du profil
function maj_app_tarifs ($app_tarifs) {
	global $bdd;

	if ($app_tarifs == "HT" || $app_tarifs = "TTC") {
		$this->app_tarifs = $app_tarifs;	
		$query = "UPDATE annu_client 
							SET app_tarifs = '".$this->app_tarifs."' 
							WHERE ref_contact = '".$this->ref_contact."' ";
		$bdd->exec($query);
	}
	return true;
}


//mise à jour du type de client du profil depuis un document
function maj_type_client ($type_client) {
	global $bdd;

	//on empeche le changement dans certains cas
	if ($type_client == $this->type_client) { return false;	}
	if ($type_client == "prospect" && $this->type_client == "client") { return false;	}

	$this->type_client = $type_client;	
	$query = "UPDATE annu_client 
						SET type_client = '".$this->type_client."' 
						WHERE ref_contact = '".$this->ref_contact."' ";
	$bdd->exec($query);
	return true;
}

//mise à jour du defaut_numero_compte du profil
function maj_defaut_numero_compte ($defaut_numero_compte) {
	global $bdd;

		$this->defaut_numero_compte = $defaut_numero_compte;	
		$query = "UPDATE annu_client 
							SET defaut_numero_compte = '".$this->defaut_numero_compte."' 
							WHERE ref_contact = '".$this->ref_contact."' ";
		$bdd->exec($query);
	return true;
}



// *************************************************************************************************************
// SUPPRESSION DES INFORMATIONS DU PROFIL [CLIENT]  
// *************************************************************************************************************
function delete_infos () {
	global $bdd;

	// Vérifie si la suppression de ces informations est possible.
	if (count($GLOBALS['_ALERTES'])) {
		return false;
	}
	
	// Supprime les informations
	$query = "DELETE FROM annu_client WHERE ref_contact = '".$this->ref_contact."' ";
	$bdd->exec($query); 

	return true;
}



// *************************************************************************************************************
// TRANSFERT DES INFORMATIONS DU PROFIL [CLIENT]  
// *************************************************************************************************************
function transfert_infos ($new_contact, $is_already_profiled) {
	global $bdd;

	// Vérifie si le transfert de ces informations est possible.
	if (!$is_already_profiled) {
		// TRANSFERT les informations
		$query = "UPDATE annu_client SET ref_contact = '".$new_contact->getRef_contact()."' 
							WHERE ref_contact = '".$this->ref_contact."'";
		$bdd->exec($query); 
	}

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
function charger_client_CA () {
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
							WHERE d.ref_contact = '".$this->ref_contact."' && dl.ref_doc_line_parent IS NULL && d.id_etat_doc IN (16,18,19)
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

//chargement des abonnements du client 
function charger_client_abo(){
	
	global $bdd;
	
	$liste_abo = array();
	$query = "	SELECT a.lib_article, aa.ref_article, aa.id_abo, aa.date_souscription, aa.date_echeance , aa.date_preavis, aa.fin_engagement, aa.fin_abonnement, amsa.reconduction
				FROM articles_abonnes aa
					LEFT JOIN articles_modele_service_abo amsa ON amsa.ref_article = aa.ref_article
					LEFT JOIN articles a ON a.ref_article = aa.ref_article
				WHERE aa.ref_contact = '".$this->getRef_contact()."'
				ORDER BY aa.date_echeance ASC;
				;";
	$resultat = $bdd->query($query);
	while ($abo = $resultat->fetchObject()) { $liste_abo[] = $abo; }
	unset ($abo, $resultat, $query);
	
	return $liste_abo;
}

//chargement des consommation (Services pré-payés) du client 
function charger_client_conso(){
	
	global $bdd;
	
	$liste_conso = array();
	$query = "	SELECT 	acc.id_compte_credit, a.lib_article, acc.ref_article, acc.date_souscription, acc.date_echeance, acc.credits_restants
				FROM 	articles_comptes_credits acc LEFT JOIN
						articles a ON a.ref_article = acc.ref_article
				WHERE 	acc.ref_contact = '".$this->getRef_contact()."' AND
						acc.credits_restants > 0
				ORDER BY acc.date_echeance ASC ;";
	$resultat = $bdd->query($query);
	while ($conso = $resultat->fetchObject()) { $liste_conso[] = $conso; }
	unset ($conso, $resultat, $query);
	
	return $liste_conso;
}

// *************************************************************************************************************
// FONCTIONS RELATIVE AUX CATEGORIES DE CLIENT
// *************************************************************************************************************
static public function charger_clients_categories () {
	global $bdd;

	$clients_categories = array();
	$query = "SELECT cc.id_client_categ , cc.lib_client_categ, cc.id_tarif, cc.ref_commercial, cc.id_relance_modele,
					cc.facturation_periodique, cc.delai_reglement, cc.note,  cc.defaut_numero_compte, cc.defaut_encours, cc.prepaiement_ratio, cc.prepaiement_type,
					cc.id_reglement_mode_favori, cc.id_edition_mode_favori, pc.lib_compte as defaut_lib_compte,
					a.nom as nom_commercial
						FROM clients_categories cc
						LEFT JOIN plan_comptable pc ON pc.numero_compte = cc.defaut_numero_compte
						LEFT JOIN annuaire a ON a.ref_contact = cc.ref_commercial
						ORDER BY cc.lib_client_categ ";
	$resultat = $bdd->query ($query);
	while ($var = $resultat->fetchObject()) { $clients_categories[$var->id_client_categ] = $var; }

	return $clients_categories;
}


static public function create_client_categorie ($infos) {
	global $bdd;
	global $COMMERCIAL_ID_PROFIL;

	$ref_commercial = "";
	if (isset($infos['ref_commercial']) && $infos['ref_commercial']) { 
		$ref_commercial = $infos['ref_commercial'];
		// Modification du profil
		$new_profils = array();
		$new_profils["id_profil"] = $COMMERCIAL_ID_PROFIL;
		$contact= new contact ($infos['ref_commercial']);
		if (!$contact->charger_profiled_infos ($new_profils["id_profil"])) {
			$contact->create_profiled_infos ($new_profils);
		}
	}
	// *************************************************
	// Insertion des données
	$query = "INSERT INTO clients_categories  
							(lib_client_categ, id_tarif, ref_commercial,
							 facturation_periodique, delai_reglement, note,
							 defaut_encours, prepaiement_type, prepaiement_ratio,
							 id_reglement_mode_favori, id_relance_modele, id_edition_mode_favori
							  ) 
						VALUES ('".addslashes($infos['lib_client_categ'])."', ".num_or_null($infos['id_tarif']).", ".ref_or_null($ref_commercial).", 
								'".addslashes($infos['facturation_periodique'])."',	'".addslashes($infos['delai_reglement'])."', '".addslashes($infos['note'])."',
								'".$infos['defaut_encours']."', '".$infos['prepaiement_type']."', '".$infos['prepaiement_ratio']."',
								'".$infos['reglement_mode_favori']."', '".$infos['cycle_relance']."', '".$infos['edition_mode_favori']."' )"; 
	$bdd->exec($query);
        edi_event(130, $bdd->lastInsertId());

	return true;
}


static public function maj_client_categorie ($infos) {
	global $bdd;
	global $COMMERCIAL_ID_PROFIL;

	$ref_commercial = "";
	if (isset($infos['ref_commercial']) && $infos['ref_commercial']) { 
		$ref_commercial = $infos['ref_commercial'];
		// Modification du profil
		$new_profils = array();
		$new_profils["id_profil"] = $COMMERCIAL_ID_PROFIL;
		$contact= new contact ($infos['ref_commercial']);
		if (!$contact->charger_profiled_infos ($new_profils["id_profil"])) {
			$contact->create_profiled_infos ($new_profils);
		}
	}
	// *************************************************
	// Mise à jour des données
	$query = "UPDATE clients_categories  
						SET lib_client_categ = '".addslashes($infos['lib_client_categ'])."', 
								facturation_periodique = '".addslashes($infos['facturation_periodique'])."', 
								delai_reglement = '".addslashes($infos['delai_reglement'])."',
								id_tarif = ".num_or_null($infos['id_tarif']).",
								ref_commercial = ".ref_or_null($ref_commercial).",
								note = '".addslashes($infos['note'])."', 
								defaut_encours = '".$infos['defaut_encours']."',
								prepaiement_type = '".$infos['prepaiement_type']."',
								prepaiement_ratio = '".$infos['prepaiement_ratio']."',
								id_reglement_mode_favori = '".$infos['reglement_mode_favori']."',
								id_relance_modele = '".$infos['cycle_relance']."',
								id_edition_mode_favori = '".$infos['edition_mode_favori']."'
						WHERE id_client_categ = '".$infos['id_client_categ']."' ";
	$bdd->exec($query);
        edi_event(131, $infos['id_client_categ']);

	return true;
}


static public function maj_defaut_numero_compte_categories  ($infos) {
	global $bdd;
	
	// *************************************************
	// Mise à jour des données
	$query = "UPDATE clients_categories  
						SET defaut_numero_compte = '".addslashes($infos['defaut_numero_compte'])."'
						WHERE id_client_categ = '".$infos['id_client_categ']."' ";
	$bdd->exec($query);
	
	return true;
}

static public function delete_client_categorie ($id_client_categ) {
	global $bdd;
	global $DEFAUT_ID_CLIENT_CATEG;

	if ($id_client_categ == $DEFAUT_ID_CLIENT_CATEG) {
		$GLOBALS['_ALERTES']['last_id_client_categ'] = 1;
	}
	// Vérifie si la suppression de ces informations est possible.
	if (count($GLOBALS['_ALERTES'])) {
		return false;
	}
	// *************************************************
	// Suppression des données
	$query = "DELETE FROM clients_categories WHERE id_client_categ = '".$id_client_categ."' ";
	$bdd->exec($query);

	return true;
}

static public function get_Encours_dispo($ref_contact,$return_array = false){
	
	global $bdd;
	$encours_utilise = 0;
	$encours_utilise_previsionnel = 0;
	$encours_reglements = 0;
	
	if($ref_contact){
		
		$query = "SELECT ref_contact,SUM(encours_utilise) encours_utilise FROM (
	SELECT ref_contact,MAX(montant_ttc) encours_utilise FROM
		(SELECT ref_contact,SUM(ROUND(qte * pu_ht * (1-remise/100) * (1+tva/100),2)) as montant_ttc
			FROM documents d
			LEFT JOIN docs_lines dl ON d.ref_doc=dl.ref_doc
			WHERE ref_contact='".$ref_contact."' AND dl.visible=1 AND
			 (d.ref_doc in (SELECT distinct ref_doc_source FROM documents_liaisons WHERE active=1)
			 OR d.ref_doc in (SELECT distinct ref_doc_destination FROM documents_liaisons WHERE active=1))
			AND ( (id_type_doc=3 AND id_etat_doc=15) OR (id_type_doc=4 AND (id_etat_doc=18 OR id_etat_doc=16)) )
		GROUP BY ref_contact,id_type_doc
		) a GROUP BY ref_contact
	UNION
		SELECT ref_contact,MAX(montant_ttc) encours_utilise FROM
		(SELECT ref_contact,SUM(ROUND(qte * pu_ht * (1-remise/100) * (1+tva/100),2)) as montant_ttc
			FROM documents d
			LEFT JOIN docs_lines dl ON d.ref_doc=dl.ref_doc
			WHERE ref_contact='".$ref_contact."' AND dl.visible=1 AND
			 (d.ref_doc not in (SELECT distinct ref_doc_source FROM documents_liaisons WHERE active=1)
			 AND d.ref_doc not in (SELECT distinct ref_doc_destination FROM documents_liaisons WHERE active=1))
			AND ( (id_type_doc=3 AND id_etat_doc=15) OR (id_type_doc=4 AND (id_etat_doc=18 OR id_etat_doc=16)))
		GROUP BY ref_contact,id_type_doc
		) b GROUP BY ref_contact
) total
WHERE ref_contact = '".$ref_contact."'
GROUP BY ref_contact;";
		$resultat = $bdd->query($query);
		if($res = $resultat->fetchObject()){
			$encours_utilise = $res->encours_utilise;	
		}
			$query = "SELECT ref_contact,SUM(encours_utilise) encours_utilise FROM (
	SELECT ref_contact,MAX(montant_ttc) encours_utilise FROM
		(SELECT ref_contact,SUM(ROUND(qte * pu_ht * (1-remise/100) * (1+tva/100),2)) as montant_ttc
			FROM documents d
			LEFT JOIN docs_lines dl ON d.ref_doc=dl.ref_doc
			WHERE ref_contact='".$ref_contact."' AND dl.visible=1 AND
			 (d.ref_doc in (SELECT distinct ref_doc_source FROM documents_liaisons WHERE active=1)
			 OR d.ref_doc in (SELECT distinct ref_doc_destination FROM documents_liaisons WHERE active=1))
			AND ( (id_type_doc=2 AND id_etat_doc=9) OR (id_type_doc=3 AND id_etat_doc IN (11,13,14) ) )
			GROUP BY ref_contact,id_type_doc
		) a GROUP BY ref_contact
	UNION
		SELECT ref_contact,MAX(montant_ttc) encours_utilise FROM
		(SELECT ref_contact,SUM(ROUND(qte * pu_ht * (1-remise/100) * (1+tva/100),2)) as montant_ttc
			FROM documents d
			LEFT JOIN docs_lines dl ON d.ref_doc=dl.ref_doc
			WHERE ref_contact='".$ref_contact."' AND dl.visible=1 AND
			 (d.ref_doc not in (SELECT distinct ref_doc_source FROM documents_liaisons WHERE active=1)
			 AND d.ref_doc not in (SELECT distinct ref_doc_destination FROM documents_liaisons WHERE active=1))
			AND ( (id_type_doc=2 AND id_etat_doc=9) OR (id_type_doc=3 AND id_etat_doc IN (11,13,14)) )
			GROUP BY ref_contact,id_type_doc
		) b GROUP BY ref_contact
) total
WHERE ref_contact = '".$ref_contact."'
GROUP BY ref_contact;";
		$resultat = $bdd->query($query);
		if($res = $resultat->fetchObject()){
			$encours_utilise_previsionnel = $res->encours_utilise;	
		}		
		$query = "SELECT ref_contact,SUM(reglement) reglements FROM (
	SELECT r.ref_contact,IF(id_type_doc = 4 AND id_etat_doc = 19,ROUND(montant_reglement-montant,2),montant_reglement) reglement
	FROM reglements r
	LEFT JOIN reglements_docs rd ON r.ref_reglement = rd.ref_reglement
	LEFT JOIN documents d ON d.ref_doc = rd.ref_doc
	WHERE valide = 1 AND (liaison_valide = 1 OR liaison_valide IS NULL
	OR (liaison_valide = 0 AND id_etat_doc IN (7,12,17,NULL)) )
	AND r.ref_contact = '".$ref_contact."'
	AND ( id_type_doc = 2 OR  id_type_doc = 3 OR id_type_doc = 4 OR id_type_doc IS NULL )
	) reg
GROUP BY ref_contact;";
		$resultat = $bdd->query($query);
		if($res = $resultat->fetchObject()){
			$encours_reglements = $res->reglements;	
		}
		$encours_autorise = self::get_Encours_autorise($ref_contact);
		
	//echo "E: ".$encours_autorise." - ".$encours_utilise." - ".$encours_utilise_previsionnel." + ".$encours_reglements." = ".($encours_autorise - $encours_utilise + $encours_reglements)."<BR>";
	if(!$return_array){
		return round($encours_autorise - $encours_utilise + $encours_reglements,2);
	}else{
		$return[0] = $encours_autorise;
		$return[1] = $encours_utilise;
		$return[2] = $encours_utilise_previsionnel;
		$return[3] = $encours_reglements;
		return $return;
	}
	}

}

static public function get_Encours_autorise($ref_contact){
	
	global $bdd;
	
	$query = "SELECT encours FROM annu_client WHERE ref_contact = '".$ref_contact."';";
	$resultat = $bdd->query($query);
	if($res = $resultat->fetchObject()){
		return $res->encours;
	}
	
}


// *************************************************************************************************************
// FONCTIONS DE LECTURE DES DONNEES 
// *************************************************************************************************************
function getRef_contact () {
	return $this->ref_contact;
}

function getId_client_categ () {
	return $this->id_client_categ;
}

function getType_client () {
	return $this->type_client;
}

function getId_tarif ($raw = true) {
    if(is_null($this->id_tarif) && $raw){
		$client_categories = self::charger_clients_categories();
		if(isset($client_categories[$this->getId_client_categ()])){
			return $client_categories[$this->getId_client_categ()]->id_tarif;
		}
    }
    return $this->id_tarif;
}

function getRef_commercial ($raw = true) {
    if(is_null($this->ref_commercial) && $raw){
		$client_categories = self::charger_clients_categories();
		if(isset($client_categories[$this->getId_client_categ()])){
			return $client_categories[$this->getId_client_categ()]->ref_commercial;
		}
    }
    return $this->ref_commercial;
}

function getNom_commercial ($raw = true) {
    if(is_null($this->nom_commercial) && $raw){
		$client_categories = self::charger_clients_categories();
		if(isset($client_categories[$this->getId_client_categ()])){
			return $client_categories[$this->getId_client_categ()]->nom_commercial;
		}
    }
    return $this->nom_commercial;
}

function getRef_adr_livraison () {
	return $this->ref_adr_livraison;
}

function getRef_adr_facturation () {
	return $this->ref_adr_facturation;
}

function getApp_tarifs () {
	return $this->app_tarifs;
}

function getFactures_par_mois ($raw = true) {
    if(is_null($this->facturation_periodique) && $raw){
		$client_categories = self::charger_clients_categories();
		if(isset($client_categories[$this->getId_client_categ()])){
			return $client_categories[$this->getId_client_categ()]->facturation_periodique;
		}
    }
    return $this->facturation_periodique;
}

function getEncours ($raw = true) {
    if(is_null($this->encours) && $raw){
		$client_categories = self::charger_clients_categories();
		if(isset($client_categories[$this->getId_client_categ()])){
			return $client_categories[$this->getId_client_categ()]->defaut_encours;
		}
    }
    return $this->encours;
}

function getDefaut_numero_compte ($raw = true) {
    if(is_null($this->defaut_numero_compte) && $raw){
		$client_categories = self::charger_clients_categories();
		if(isset($client_categories[$this->getId_client_categ()])){
			return $client_categories[$this->getId_client_categ()]->defaut_numero_compte;
		}
    }
    return $this->defaut_numero_compte;
}

function getId_cycle_relance ($raw = true) {
    if(is_null($this->id_cycle_relance) && $raw){
		$client_categories = self::charger_clients_categories();
		if(isset($client_categories[$this->getId_client_categ()])){
			return $client_categories[$this->getId_client_categ()]->id_relance_modele;
		}
    }
    return $this->id_cycle_relance;
}

function getLib_cycle_relance () {
	global $bdd;
        $query = "SELECT lib_echeancier_modele FROM echeanciers_modeles WHERE id_echeancier_modele = '".$this->getId_cycle_relance()."' ";
        $retour = $bdd->query($query);
        if($lib = $retour->fetchObject()){
            return $lib->lib_echeancier_modele;
        }
}

function getPrepaiement_ratio ($raw = true) {
	
	if(is_null($this->prepaiement_ratio) && $raw){
		$client_categories = self::charger_clients_categories();
		if(isset($client_categories[$this->getId_client_categ()])){
			return $client_categories[$this->getId_client_categ()]->prepaiement_ratio;
		}
	}
	return $this->prepaiement_ratio;
}

function getPrepaiement_type ($raw = true) {
	if(is_null($this->prepaiement_type) && $raw){
		$client_categories = self::charger_clients_categories();
		if(isset($client_categories[$this->getId_client_categ()])){
			return $client_categories[$this->getId_client_categ()]->prepaiement_type;
		}
	}
	return $this->prepaiement_type;
}

function getDelai_reglement ($raw = true) {
	if(is_null($this->delai_reglement) && $raw){
		$client_categories = self::charger_clients_categories();
		if(isset($client_categories[$this->getId_client_categ()])){
			return $client_categories[$this->getId_client_categ()]->delai_reglement;
		}
	}
	return $this->delai_reglement;
}



// bac 18/05/2010 v 2.0.54.0 ajout accesseurs règlement favori, mode d'édition favori
function getDelai_reglement_client () {
	return $this->delai_reglement;
}
  
function getId_reglement_mode_favori ($raw = true) {
	if(is_null($this->id_reglement_mode_favori) && $raw){
		$client_categories = self::charger_clients_categories();
		if(isset($client_categories[$this->getId_client_categ()])){
			return $client_categories[$this->getId_client_categ()]->id_reglement_mode_favori;
		}
	}
	return $this->id_reglement_mode_favori;
}

function getId_edition_mode_favori_client ($raw = true) {
    	if(is_null($this->id_edition_mode_favori) && $raw){
		$client_categories = self::charger_clients_categories();
		if(isset($client_categories[$this->getId_client_categ()])){
			return $client_categories[$this->getId_client_categ()]->id_edition_mode_favori;
		}
	}
	return $this->id_edition_mode_favori;
}

function getId_edition_mode_favori ($raw = true) {
	if(is_null($this->id_edition_mode_favori) && $raw){
		$client_categories = self::charger_clients_categories();
		if(isset($client_categories[$this->getId_client_categ()])){
			return $client_categories[$this->getId_client_categ()]->id_edition_mode_favori;
		}
	}
	return $this->id_edition_mode_favori;
}

// rend le tarif de l'annuaire catégorie ( particulier, société ) -> HT , TTC 
function getApp_Tarifs_Categorie (){
	global $bdd;
	// Si App_tarifs en automatique on récupére l'app_tarifs le l'annuaire_categorie du contact
	$app_tarifs_categorie = null;	
	$query = "SELECT ac.app_tarifs 
						FROM annuaire a
							LEFT JOIN annuaire_categories ac ON a.id_categorie = ac.id_categorie
						WHERE ref_contact = '".$this->ref_contact."' ";
	$resultat = $bdd->query ($query);
	if ($annuaire_categories = $resultat->fetchObject()) {
		$app_tarifs_categorie= $annuaire_categories->app_tarifs; 
	}
	return $app_tarifs_categorie;
}

// rend le tarif de l'annuaire catégorie entré( particulier, société, .. ) -> HT , TTC 
public static function getApp_Tarifs_Categorie_definie ($id_categorie){
	global $bdd;
	// Si App_tarifs en automatique on récupére l'app_tarifs le l'annuaire_categorie du contact
	$app_tarifs_categorie = null;
	if (!(( $id_categorie=="" ) || is_null($id_categorie) || (!is_numeric($id_categorie))))
	{  	
		$query = "SELECT app_tarifs FROM annuaire_categories where id_categorie = ".$id_categorie;
		$resultat = $bdd->query ($query);
		if ($annuaire_categories = $resultat->fetchObject()) {
			$app_tarifs_categorie= $annuaire_categories->app_tarifs; 
		}
	}
	return $app_tarifs_categorie;
}
// bac .


}

?>