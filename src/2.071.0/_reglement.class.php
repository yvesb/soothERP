<?php
// *************************************************************************************************************
// CLASSE REGISSANT LES INFORMATIONS SUR UN REGLEMENT 
// *************************************************************************************************************


final class reglement {
	protected $ref_reglement;
	protected $ref_contact;
	protected $date_reglement;

        protected $id_reglement_mode;
	protected $lib_reglement_mode;
	protected $abrev_reglement_mode;
	
	protected $type_reglement;

	protected $montant_reglement;
	protected $valide;

	protected $montant_lettrages;
	protected $montant_disponible;
	protected $montant_dispo_loaded;

	protected $documents_lettrages = array();
	protected $documents_lettrages_loaded;


	// Informations complémentaires fonction du mode de règlement
	protected $date_echeance;

	protected $id_compte_bancaire_source;
	protected $id_compte_bancaire_dest;

	protected $id_compte_caisse_source;
	protected $id_compte_caisse_dest;
	protected $id_compte_caisse_move;
	protected $id_compte_tpe_dest;
	protected $id_compte_cb_source;
	protected $id_compte_tpv_dest;

	protected $numero_cheque;
	protected $info_banque;
	protected $info_compte;

	protected $ref_reglement_comp;				// Référence du règlement utilisé en compensation d'un avoir AVC ou AVF
	protected $ref_avc;
	protected $ref_avf;


public function __construct ($ref_reglement = "") {
	global $bdd;
	global $CALCUL_TARIFS_NB_DECIMALS;
	
	if (!$ref_reglement) { return false; }
	
	$query = "SELECT r.ref_contact, r.date_reglement, r.date_echeance, r.date_saisie, r.id_reglement_mode, round(r.montant_reglement, ".$CALCUL_TARIFS_NB_DECIMALS.") as  montant_reglement, r.valide,
									 rm.lib_reglement_mode, rm.abrev_reglement_mode, rm.type_reglement
						FROM reglements r
							LEFT JOIN reglements_modes rm ON r.id_reglement_mode = rm.id_reglement_mode
						WHERE ref_reglement = '".$ref_reglement."' ";
	$resultat = $bdd->query ($query);
	if (!$reglement = $resultat->fetchObject()) { return false; }
	
	$this->ref_reglement 				= $ref_reglement;
	$this->ref_contact 					= $reglement->ref_contact;
	$this->date_reglement 			= $reglement->date_reglement;
	$this->date_saisie 					= $reglement->date_saisie;
	$this->date_echeance 				= $reglement->date_echeance;
	$this->id_reglement_mode		= $reglement->id_reglement_mode;
	$this->lib_reglement_mode		= $reglement->lib_reglement_mode;
	$this->abrev_reglement_mode	= $reglement->abrev_reglement_mode;
	$this->type_reglement				= $reglement->type_reglement;
	$this->montant_reglement		= $reglement->montant_reglement;
	$this->valide 							= $reglement->valide;
	
	return true;
}




// *************************************************************************************************************
// FONCTIONS LIEES A LA CREATION D'UN REGLEMENT
// *************************************************************************************************************

public function create_reglement ($infos) { 
	global $bdd;
	global $REF_CONTACT_ENTREPRISE;
	global $COOKIE_SYSTEME_LT;

	global $ESP_E_ID_REGMT_MODE;
	global $ESP_S_ID_REGMT_MODE;
	global $CHQ_E_ID_REGMT_MODE;
	global $CHQ_S_ID_REGMT_MODE;
	global $CB_E_ID_REGMT_MODE;
	global $CB_S_ID_REGMT_MODE;
	global $VIR_E_ID_REGMT_MODE;
	global $VIR_S_ID_REGMT_MODE;
	global $LCR_E_ID_REGMT_MODE;
	global $LCR_S_ID_REGMT_MODE;
	global $PRB_E_ID_REGMT_MODE;
	global $PRB_S_ID_REGMT_MODE;
	global $AVC_E_ID_REGMT_MODE;
	global $AVF_S_ID_REGMT_MODE;
	global $COMP_S_ID_REGMT_MODE;
	global $COMP_E_ID_REGMT_MODE;
	global $TPV_E_ID_REGMT_MODE;
	global $LC_E_ID_REGMT_MODE;
	global $LC_S_ID_REGMT_MODE;
	
	global $DEFAUT_COMPTE_BANQUES; // "512101";
	global $DEFAUT_ID_JOURNAL_BANQUES; // "9";
	global $DEFAUT_COMPTE_TIERS_VENTE; // 41
	global $DEFAUT_COMPTE_TIERS_ACHAT; // 40
	
	global $CLIENT_ID_PROFIL;
	global $FOURNISSEUR_ID_PROFIL;
	
	
	$REGLEMENT_ID_REFERENCE_TAG = 23;
	// Direction du reglement
	$reglement_entrant = 1;
	if ($infos['direction_reglement'] == "sortant") {
		$reglement_entrant = 0;
	}

	// *************************************************
	// Réception des données
	$this->ref_contact 		= $infos['ref_contact'];
	$this->id_reglement_mode = $infos['id_reglement_mode'];
	if (!is_numeric($this->id_reglement_mode)) {
		$GLOBALS['_ALERTES']['bad_id_reglement_mode'] = 1;
	}
	$this->date_reglement	= $infos['date_reglement'];
	$this->date_echeance	= $infos['date_echeance'];

	$this->valide = 1;

	// *************************************************
	// Controle du Montant
	$this->montant_reglement = round($infos['montant_reglement'],2);
	if (!is_numeric($this->montant_reglement) || $this->montant_reglement <= 0) {
		$GLOBALS['_ALERTES']['bad_montant_reglement'] = 1;
	}

	// *************************************************
	// Réception des données spécifiques au mode de règlement
	switch ($this->id_reglement_mode) {
		case $ESP_E_ID_REGMT_MODE: 
			$this->id_compte_caisse_dest = $infos['id_compte_caisse_dest'];
		break;

		case $CHQ_E_ID_REGMT_MODE: 
			$this->id_compte_caisse_dest = $infos['id_compte_caisse_dest'];
			$this->numero_cheque = $infos['numero_cheque'];
			$this->info_banque = $infos['info_banque'];
			$this->info_compte = $infos['info_compte'];
		break;

		case $CB_E_ID_REGMT_MODE:
			$this->id_compte_caisse_dest 	= $infos['id_compte_caisse_dest'];
			$this->id_compte_tpe_dest 		= $infos['id_compte_tpe_dest'];
		break;

		case $VIR_E_ID_REGMT_MODE: 
			$this->id_compte_bancaire_dest = $infos['id_compte_bancaire_dest'];
		break;

		case $LCR_E_ID_REGMT_MODE: 
			$this->id_compte_bancaire_source 	= $infos['id_compte_bancaire_source'];
			$this->id_compte_bancaire_dest 		= $infos['id_compte_bancaire_dest'];
		break;

		case $PRB_E_ID_REGMT_MODE: 
			$this->id_compte_bancaire_source 	= $infos['id_compte_bancaire_source'];
			$this->id_compte_bancaire_dest 		= $infos['id_compte_bancaire_dest'];
		break;


		case $ESP_S_ID_REGMT_MODE: 
			$this->id_compte_caisse_source = $infos['id_compte_caisse_source'];
		break;

		case $CHQ_S_ID_REGMT_MODE: 
			$this->id_compte_bancaire_source = $infos['id_compte_bancaire_source'];
			$this->numero_cheque = $infos['numero_cheque'];
		break;

		case $CB_S_ID_REGMT_MODE: 
			$this->id_compte_cb_source	= $infos['id_compte_cb_source'];
		break;

		case $VIR_S_ID_REGMT_MODE: 
			$this->id_compte_bancaire_source 	= $infos['id_compte_bancaire_source'];
			$this->id_compte_bancaire_dest 		= $infos['id_compte_bancaire_dest'];
		break;

		case $LCR_S_ID_REGMT_MODE: 
			$this->id_compte_bancaire_source 	= $infos['id_compte_bancaire_source'];
		break;

		case $PRB_S_ID_REGMT_MODE: 
			$this->id_compte_bancaire_source 	= $infos['id_compte_bancaire_source'];
		break;


		case $COMP_S_ID_REGMT_MODE:
		case $COMP_E_ID_REGMT_MODE:
		break;

		case $AVC_E_ID_REGMT_MODE:
		case $AVF_S_ID_REGMT_MODE:
			$this->ref_reglement_comp = $infos['ref_reglement_comp'];
		break;
		
		case $TPV_E_ID_REGMT_MODE:
			$this->id_compte_tpv_dest 		= $infos['id_compte_tpv_dest'];
		break;
		
		case $LC_E_ID_REGMT_MODE:
			$this->id_compte_bancaire_source 	= $infos['id_compte_bancaire_source'];
			$this->id_compte_bancaire_dest 		= $infos['id_compte_bancaire_dest'];
		break;

		default: exit();
	}
	if (count($GLOBALS['_ALERTES'])) {
		return false;
	}

	// *************************************************
	// Création de la référence
	$reference = new reference ($REGLEMENT_ID_REFERENCE_TAG);
	$this->ref_reglement = $reference->generer_ref();

	// *************************************************
	// Insertion dans la bdd
	$bdd->beginTransaction();
	$query = "INSERT INTO reglements 
							(ref_reglement, ref_contact, date_saisie, date_reglement, date_echeance, 
							 id_reglement_mode, montant_reglement, valide)
						VALUES ('".$this->ref_reglement."', ".ref_or_null($this->ref_contact).", NOW(), '".$this->date_reglement."', 
										'".$this->date_echeance."', '".$this->id_reglement_mode."', '".$this->montant_reglement."', 
										'".$this->valide."')"; 
	$bdd->exec ($query);

	switch ($this->id_reglement_mode) {
		case $ESP_E_ID_REGMT_MODE: 
			$this->id_compte_caisse_move = NULL;
			compte_caisse::create_compte_caisse_move ($this->id_compte_caisse_dest, 1, $this->id_reglement_mode, $this->montant_reglement, $this->ref_reglement);
			compte_caisse::maj_esp_compte_caisse_contenu ($this->id_compte_caisse_dest, $this->id_reglement_mode, $this->montant_reglement);
			
			if (isset($GLOBALS['_INFOS']['create_id_comptes_caisses_moves'])) {
				$this->id_compte_caisse_move = $GLOBALS['_INFOS']['create_id_comptes_caisses_moves'];
			}
			$query = "INSERT INTO regmt_e_esp (ref_reglement, id_compte_caisse_move) 
								VALUES ('".$this->ref_reglement."', '".$this->id_compte_caisse_move."') ";
			$bdd->exec ($query);
			setcookie ("id_compte_caisse_dest", "", time() - 3600);
			setcookie('last_id_compte_caisse_dest',  $this->id_compte_caisse_dest, time() + $COOKIE_SYSTEME_LT, "/");
		break;

		case $CHQ_E_ID_REGMT_MODE: 
			$this->id_compte_caisse_move = NULL;
			compte_caisse::create_compte_caisse_move ($this->id_compte_caisse_dest, 1, $this->id_reglement_mode, $this->montant_reglement, $this->ref_reglement);
			compte_caisse::add_compte_caisse_contenu (array(array("id_compte_caisse"=>$this->id_compte_caisse_dest, "id_reglement_mode"=>$this->id_reglement_mode, "montant_contenu"=>$this->montant_reglement, "infos_supp"=>$this->ref_reglement, "controle"=>0)));
			if (isset($GLOBALS['_INFOS']['create_id_comptes_caisses_moves'])) {
				$this->id_compte_caisse_move = $GLOBALS['_INFOS']['create_id_comptes_caisses_moves'];
			}
			$query = "INSERT INTO regmt_e_chq (ref_reglement, id_compte_caisse_move, numero_cheque, info_banque, info_compte) 
								VALUES ('".$this->ref_reglement."', '".$this->id_compte_caisse_move."', '".addslashes($this->numero_cheque)."',
												'".addslashes($this->info_banque)."', '".addslashes($this->info_compte)."') ";
			setcookie ("id_compte_caisse_dest", "", time() - 3600);
			setcookie('last_id_compte_caisse_dest',  $this->id_compte_caisse_dest, time() + $COOKIE_SYSTEME_LT, "/");
			$bdd->exec ($query);
		break;

		case $CB_E_ID_REGMT_MODE:
			$this->id_compte_caisse_move = NULL;
			if ($this->id_compte_caisse_dest) {
			compte_caisse::create_compte_caisse_move ($this->id_compte_caisse_dest, 1, $this->id_reglement_mode, $this->montant_reglement, $this->ref_reglement);
				if (isset($GLOBALS['_INFOS']['create_id_comptes_caisses_moves'])) {
					$this->id_compte_caisse_move = $GLOBALS['_INFOS']['create_id_comptes_caisses_moves'];
				}
			}
			compte_tpe::add_compte_tp_contenu (array(array("id_compte_tp"=>$this->id_compte_tpe_dest, "tp_type"=>"TPE", "montant_contenu"=>$this->montant_reglement, "id_compte_caisse"=>$this->id_compte_caisse_dest,  "infos_supp"=>$this->ref_reglement, "controle"=>0)));
			$query = "INSERT INTO regmt_e_cb (ref_reglement, id_compte_tpe_dest, id_compte_caisse_move) 
								VALUES ('".$this->ref_reglement."', '".$this->id_compte_tpe_dest."', ".num_or_null($this->id_compte_caisse_move).") ";
			$bdd->exec ($query);
			setcookie ("id_compte_tpe_dest", "", time() - 3600);
			setcookie('last_id_compte_tpe_dest',  $this->id_compte_tpe_dest, time() + $COOKIE_SYSTEME_LT, "/");
			setcookie ("id_compte_caisse_cb_dest", "", time() - 3600);
			setcookie('last_id_compte_caisse_cb_dest',  $this->id_compte_caisse_dest, time() + $COOKIE_SYSTEME_LT, "/");
		break;

		case $VIR_E_ID_REGMT_MODE: 
			$query = "INSERT INTO regmt_e_vir (ref_reglement, id_compte_bancaire_dest) 
								VALUES ('".$this->ref_reglement."', '".$this->id_compte_bancaire_dest."') ";
			$bdd->exec ($query);
			
			//création de l'opération dans le journal de banque correspondant
			$compte_bancaire_cible = new compte_bancaire ($this->id_compte_bancaire_dest);
			//vérification du journal correspondant au compte
			$journal_banque_arrivee = compta_journaux::check_exist_journaux ($DEFAUT_ID_JOURNAL_BANQUES, $compte_bancaire_cible->getDefaut_numero_compte ());
			// récupération du compte tier vente
			$numero_compte_comptable = $DEFAUT_COMPTE_TIERS_VENTE;
			if (isset($infos["doc_ACCEPT_REGMT"]) && $infos["doc_ACCEPT_REGMT"] == "-1") {$numero_compte_comptable = $DEFAUT_COMPTE_TIERS_ACHAT;}
			$tmp_contact = new contact ($this->ref_contact);
			if ($tmp_contact->getRef_contact()) {
				$profils 	= $tmp_contact->getProfils ();
				//gestion des cas ambigus entre profils et sens de règlement
				if (isset($profils[$CLIENT_ID_PROFIL]) && !isset($profils[$FOURNISSEUR_ID_PROFIL]) ) { $ID_PROFIL = $CLIENT_ID_PROFIL;}
				if (!isset($profils[$CLIENT_ID_PROFIL]) && isset($profils[$FOURNISSEUR_ID_PROFIL]) ) { $ID_PROFIL = $FOURNISSEUR_ID_PROFIL;}
				
				if (isset($profils[$CLIENT_ID_PROFIL]) && isset($profils[$FOURNISSEUR_ID_PROFIL]) ) { 
					$ID_PROFIL = $CLIENT_ID_PROFIL;
					if (isset($infos["doc_ACCEPT_REGMT"]) && $infos["doc_ACCEPT_REGMT"] == "-1") {$ID_PROFIL = $FOURNISSEUR_ID_PROFIL;}
				}
				$numero_compte_comptable = $profils[$ID_PROFIL]->getDefaut_numero_compte ();
			} 
			//création des opérations de journaux		
			$journal_banque_arrivee->create_operation ($numero_compte_comptable, $this->montant_reglement, $this->ref_reglement, $this->date_reglement, 5); 

		break;

		case $LCR_E_ID_REGMT_MODE: 
			$query = "INSERT INTO regmt_e_lcr (ref_reglement, id_compte_bancaire_source, id_compte_bancaire_dest) 
								VALUES ('".$this->ref_reglement."', 
												'".$this->id_compte_bancaire_source."', '".$this->id_compte_bancaire_dest."') ";
			$bdd->exec ($query);
			
			//création de l'opération dans le journal de banque correspondant
			$compte_bancaire_cible = new compte_bancaire ($this->id_compte_bancaire_dest);
			//vérification du journal correspondant au compte
			$journal_banque_arrivee = compta_journaux::check_exist_journaux ($DEFAUT_ID_JOURNAL_BANQUES, $compte_bancaire_cible->getDefaut_numero_compte ());
			// récupération du compte tier vente
			$numero_compte_comptable = $DEFAUT_COMPTE_TIERS_VENTE;
			if (isset($infos["doc_ACCEPT_REGMT"]) && $infos["doc_ACCEPT_REGMT"] == "-1") {$numero_compte_comptable = $DEFAUT_COMPTE_TIERS_ACHAT;}
			$tmp_contact = new contact ($this->ref_contact);
			if ($tmp_contact->getRef_contact()) {
				$profils 	= $tmp_contact->getProfils ();
				//gestion des cas ambigus entre profils et sens de règlement
				if (isset($profils[$CLIENT_ID_PROFIL]) && !isset($profils[$FOURNISSEUR_ID_PROFIL]) ) { $ID_PROFIL = $CLIENT_ID_PROFIL;}
				if (!isset($profils[$CLIENT_ID_PROFIL]) && isset($profils[$FOURNISSEUR_ID_PROFIL]) ) { $ID_PROFIL = $FOURNISSEUR_ID_PROFIL;}
				
				if (isset($profils[$CLIENT_ID_PROFIL]) && isset($profils[$FOURNISSEUR_ID_PROFIL]) ) { 
					$ID_PROFIL = $CLIENT_ID_PROFIL;
					if (isset($infos["doc_ACCEPT_REGMT"]) && $infos["doc_ACCEPT_REGMT"] == "-1") {$ID_PROFIL = $FOURNISSEUR_ID_PROFIL;}
				}
				$numero_compte_comptable = $profils[$ID_PROFIL]->getDefaut_numero_compte ();
			} 
			//création des opérations de journaux		
			$journal_banque_arrivee->create_operation ($numero_compte_comptable, $this->montant_reglement, $this->ref_reglement, $this->date_reglement, 5); 

		break;

		case $PRB_E_ID_REGMT_MODE: 
			$query = "INSERT INTO regmt_e_prb (ref_reglement, id_compte_bancaire_source, id_compte_bancaire_dest) 
								VALUES ('".$this->ref_reglement."', 
												'".$this->id_compte_bancaire_source."', '".$this->id_compte_bancaire_dest."') ";
			$bdd->exec ($query);
			//création de l'opération dans le journal de banque correspondant
			$compte_bancaire_cible = new compte_bancaire ($this->id_compte_bancaire_dest);
			//vérification du journal correspondant au compte
			$journal_banque_arrivee = compta_journaux::check_exist_journaux ($DEFAUT_ID_JOURNAL_BANQUES, $compte_bancaire_cible->getDefaut_numero_compte ());
			// récupération du compte tier vente
			$numero_compte_comptable = $DEFAUT_COMPTE_TIERS_VENTE;
			if (isset($infos["doc_ACCEPT_REGMT"]) && $infos["doc_ACCEPT_REGMT"] == "-1") {$numero_compte_comptable = $DEFAUT_COMPTE_TIERS_ACHAT;}
			$tmp_contact = new contact ($this->ref_contact);
			if ($tmp_contact->getRef_contact()) {
				$profils 	= $tmp_contact->getProfils ();
				//gestion des cas ambigus entre profils et sens de règlement
				if (isset($profils[$CLIENT_ID_PROFIL]) && !isset($profils[$FOURNISSEUR_ID_PROFIL]) ) { $ID_PROFIL = $CLIENT_ID_PROFIL;}
				if (!isset($profils[$CLIENT_ID_PROFIL]) && isset($profils[$FOURNISSEUR_ID_PROFIL]) ) { $ID_PROFIL = $FOURNISSEUR_ID_PROFIL;}
				
				if (isset($profils[$CLIENT_ID_PROFIL]) && isset($profils[$FOURNISSEUR_ID_PROFIL]) ) { 
					$ID_PROFIL = $CLIENT_ID_PROFIL;
					if (isset($infos["doc_ACCEPT_REGMT"]) && $infos["doc_ACCEPT_REGMT"] == "-1") {$ID_PROFIL = $FOURNISSEUR_ID_PROFIL;}
				}
				$numero_compte_comptable = $profils[$ID_PROFIL]->getDefaut_numero_compte ();
			} 
			//création des opérations de journaux		
			$journal_banque_arrivee->create_operation ($numero_compte_comptable, $this->montant_reglement, $this->ref_reglement, $this->date_reglement, 5); 
		break;


		case $ESP_S_ID_REGMT_MODE: 
			$this->id_compte_caisse_move = NULL;
			compte_caisse::create_compte_caisse_move ($this->id_compte_caisse_source, 1, $this->id_reglement_mode, -$this->montant_reglement, $this->ref_reglement);
			compte_caisse::maj_esp_compte_caisse_contenu ($this->id_compte_caisse_source, $ESP_E_ID_REGMT_MODE, -$this->montant_reglement);
			if (isset($GLOBALS['_INFOS']['create_id_comptes_caisses_moves'])) {
				$this->id_compte_caisse_move = $GLOBALS['_INFOS']['create_id_comptes_caisses_moves'];
			}
			$query = "INSERT INTO regmt_s_esp (ref_reglement, id_compte_caisse_move) 
								VALUES ('".$this->ref_reglement."', '".$this->id_compte_caisse_move."') ";
			$bdd->exec ($query);
			setcookie ("id_compte_caisse_source", "", time() - 3600);
			setcookie('last_id_compte_caisse_source',  $this->id_compte_caisse_source, time() + $COOKIE_SYSTEME_LT, "/");
		break;

		case $CHQ_S_ID_REGMT_MODE: 
			$query = "INSERT INTO regmt_s_chq (ref_reglement, id_compte_bancaire_source, numero_cheque) 
								VALUES ('".$this->ref_reglement."', '".$this->id_compte_bancaire_source."', '".$this->numero_cheque."') ";
			$bdd->exec ($query);
			setcookie ("id_compte_bancaire_source", "", time() - 3600);
			setcookie('last_id_compte_bancaire_source',  $this->id_compte_bancaire_source, time() + $COOKIE_SYSTEME_LT, "/");
			
			
			//création de l'opération dans le journal de banque correspondant
			$compte_bancaire_cible = new compte_bancaire ($this->id_compte_bancaire_source);
			//vérification du journal correspondant au compte
			$journal_banque_arrivee = compta_journaux::check_exist_journaux ($DEFAUT_ID_JOURNAL_BANQUES, $compte_bancaire_cible->getDefaut_numero_compte ());
			// récupération du compte tier vente
			$numero_compte_comptable = $DEFAUT_COMPTE_TIERS_ACHAT;
			if (isset($infos["doc_ACCEPT_REGMT"]) && $infos["doc_ACCEPT_REGMT"] == "1") {$numero_compte_comptable = $DEFAUT_COMPTE_TIERS_VENTE;}
			$tmp_contact = new contact ($this->ref_contact);
			if ($tmp_contact->getRef_contact()) {
				$profils 	= $tmp_contact->getProfils ();
				//gestion des cas ambigus entre profils et sens de règlement
				if (isset($profils[$CLIENT_ID_PROFIL]) && !isset($profils[$FOURNISSEUR_ID_PROFIL]) ) { $ID_PROFIL = $CLIENT_ID_PROFIL;}
				if (!isset($profils[$CLIENT_ID_PROFIL]) && isset($profils[$FOURNISSEUR_ID_PROFIL]) ) { $ID_PROFIL = $FOURNISSEUR_ID_PROFIL;}
				
				if (isset($profils[$CLIENT_ID_PROFIL]) && isset($profils[$FOURNISSEUR_ID_PROFIL]) ) { 
					$ID_PROFIL = $FOURNISSEUR_ID_PROFIL;
					if (isset($infos["doc_ACCEPT_REGMT"]) && $infos["doc_ACCEPT_REGMT"] == "1") {$ID_PROFIL = $CLIENT_ID_PROFIL;}
				}
				$numero_compte_comptable = $profils[$ID_PROFIL]->getDefaut_numero_compte ();
			} 
			//création des opérations de journaux		
			$journal_banque_arrivee->create_operation ($numero_compte_comptable, -$this->montant_reglement, $this->ref_reglement, $this->date_reglement, 6); 
			
		break;

		case $CB_S_ID_REGMT_MODE: 
			$query = "INSERT INTO regmt_s_cb (ref_reglement, id_compte_cb) 
								VALUES ('".$this->ref_reglement."', '".$this->id_compte_cb_source."') ";
			$bdd->exec ($query);
			setcookie ("id_compte_cb_source", "", time() - 3600);
			setcookie('last_id_compte_cb_source',  $this->id_compte_cb_source, time() + $COOKIE_SYSTEME_LT, "/");
			
			//récuperation du compte bancaire lié à la carte
			$compte_cb = new compte_cb ($this->id_compte_cb_source);
			//création de l'opération dans le journal de banque correspondant
			$compte_bancaire_cible = new compte_bancaire ($compte_cb->getId_compte_bancaire ());
			//vérification du journal correspondant au compte
			$journal_banque_arrivee = compta_journaux::check_exist_journaux ($DEFAUT_ID_JOURNAL_BANQUES, $compte_bancaire_cible->getDefaut_numero_compte ());
			// récupération du compte tier vente
			$numero_compte_comptable = $DEFAUT_COMPTE_TIERS_ACHAT;
			if (isset($infos["doc_ACCEPT_REGMT"]) && $infos["doc_ACCEPT_REGMT"] == "1") {$numero_compte_comptable = $DEFAUT_COMPTE_TIERS_VENTE;}
			$tmp_contact = new contact ($this->ref_contact);
			if ($tmp_contact->getRef_contact()) {
				$profils 	= $tmp_contact->getProfils ();
				//gestion des cas ambigus entre profils et sens de règlement
				if (isset($profils[$CLIENT_ID_PROFIL]) && !isset($profils[$FOURNISSEUR_ID_PROFIL]) ) { $ID_PROFIL = $CLIENT_ID_PROFIL;}
				if (!isset($profils[$CLIENT_ID_PROFIL]) && isset($profils[$FOURNISSEUR_ID_PROFIL]) ) { $ID_PROFIL = $FOURNISSEUR_ID_PROFIL;}
				
				if (isset($profils[$CLIENT_ID_PROFIL]) && isset($profils[$FOURNISSEUR_ID_PROFIL]) ) { 
					$ID_PROFIL = $FOURNISSEUR_ID_PROFIL;
					if (isset($infos["doc_ACCEPT_REGMT"]) && $infos["doc_ACCEPT_REGMT"] == "1") {$ID_PROFIL = $CLIENT_ID_PROFIL;}
				}
				$numero_compte_comptable = $profils[$ID_PROFIL]->getDefaut_numero_compte ();
			} 
			//création des opérations de journaux		
			$journal_banque_arrivee->create_operation ($numero_compte_comptable, -$this->montant_reglement, $this->ref_reglement, $this->date_reglement, 6); 
		break;

		case $VIR_S_ID_REGMT_MODE: 
			$query = "INSERT INTO regmt_s_vir (ref_reglement, id_compte_bancaire_source, id_compte_bancaire_dest) 
								VALUES ('".$this->ref_reglement."', 
												'".$this->id_compte_bancaire_source."', '".$this->id_compte_bancaire_dest."') ";
			$bdd->exec ($query);
			
			//création de l'opération dans le journal de banque correspondant
			$compte_bancaire_cible = new compte_bancaire ($this->id_compte_bancaire_source);
			//vérification du journal correspondant au compte
			$journal_banque_arrivee = compta_journaux::check_exist_journaux ($DEFAUT_ID_JOURNAL_BANQUES, $compte_bancaire_cible->getDefaut_numero_compte ());
			// récupération du compte tier vente
			$numero_compte_comptable = $DEFAUT_COMPTE_TIERS_ACHAT;
			if (isset($infos["doc_ACCEPT_REGMT"]) && $infos["doc_ACCEPT_REGMT"] == "1") {$numero_compte_comptable = $DEFAUT_COMPTE_TIERS_VENTE;}
			$tmp_contact = new contact ($this->ref_contact);
			if ($tmp_contact->getRef_contact()) {
				$profils 	= $tmp_contact->getProfils ();
				//gestion des cas ambigus entre profils et sens de règlement
				if (isset($profils[$CLIENT_ID_PROFIL]) && !isset($profils[$FOURNISSEUR_ID_PROFIL]) ) { $ID_PROFIL = $CLIENT_ID_PROFIL;}
				if (!isset($profils[$CLIENT_ID_PROFIL]) && isset($profils[$FOURNISSEUR_ID_PROFIL]) ) { $ID_PROFIL = $FOURNISSEUR_ID_PROFIL;}
				
				if (isset($profils[$CLIENT_ID_PROFIL]) && isset($profils[$FOURNISSEUR_ID_PROFIL]) ) { 
					$ID_PROFIL = $FOURNISSEUR_ID_PROFIL;
					if (isset($infos["doc_ACCEPT_REGMT"]) && $infos["doc_ACCEPT_REGMT"] == "1") {$ID_PROFIL = $CLIENT_ID_PROFIL;}
				}
				$numero_compte_comptable = $profils[$ID_PROFIL]->getDefaut_numero_compte ();
			} 
			//création des opérations de journaux		
			$journal_banque_arrivee->create_operation ($numero_compte_comptable, -$this->montant_reglement, $this->ref_reglement, $this->date_reglement, 6); 
		break;

		case $LCR_S_ID_REGMT_MODE: 
			$query = "INSERT INTO regmt_s_lcr (ref_reglement, id_compte_bancaire_source) 
								VALUES ('".$this->ref_reglement."', '".$this->id_compte_bancaire_source."') ";
			$bdd->exec ($query);
			
			//création de l'opération dans le journal de banque correspondant
			$compte_bancaire_cible = new compte_bancaire ($this->id_compte_bancaire_source);
			//vérification du journal correspondant au compte
			$journal_banque_arrivee = compta_journaux::check_exist_journaux ($DEFAUT_ID_JOURNAL_BANQUES, $compte_bancaire_cible->getDefaut_numero_compte ());
			// récupération du compte tier vente
			$numero_compte_comptable = $DEFAUT_COMPTE_TIERS_ACHAT;
			if (isset($infos["doc_ACCEPT_REGMT"]) && $infos["doc_ACCEPT_REGMT"] == "1") {$numero_compte_comptable = $DEFAUT_COMPTE_TIERS_VENTE;}
			$tmp_contact = new contact ($this->ref_contact);
			if ($tmp_contact->getRef_contact()) {
				$profils 	= $tmp_contact->getProfils ();
				//gestion des cas ambigus entre profils et sens de règlement
				if (isset($profils[$CLIENT_ID_PROFIL]) && !isset($profils[$FOURNISSEUR_ID_PROFIL]) ) { $ID_PROFIL = $CLIENT_ID_PROFIL;}
				if (!isset($profils[$CLIENT_ID_PROFIL]) && isset($profils[$FOURNISSEUR_ID_PROFIL]) ) { $ID_PROFIL = $FOURNISSEUR_ID_PROFIL;}
				
				if (isset($profils[$CLIENT_ID_PROFIL]) && isset($profils[$FOURNISSEUR_ID_PROFIL]) ) { 
					$ID_PROFIL = $FOURNISSEUR_ID_PROFIL;
					if (isset($infos["doc_ACCEPT_REGMT"]) && $infos["doc_ACCEPT_REGMT"] == "1") {$ID_PROFIL = $CLIENT_ID_PROFIL;}
				}
				$numero_compte_comptable = $profils[$ID_PROFIL]->getDefaut_numero_compte ();
			} 
			//création des opérations de journaux		
			$journal_banque_arrivee->create_operation ($numero_compte_comptable, -$this->montant_reglement, $this->ref_reglement, $this->date_reglement, 6); 
		break;

		case $PRB_S_ID_REGMT_MODE: 
			$query = "INSERT INTO regmt_s_prb (ref_reglement, id_compte_bancaire_source) 
								VALUES ('".$this->ref_reglement."', '".$this->id_compte_bancaire_source."') ";
			$bdd->exec ($query);
			
			//création de l'opération dans le journal de banque correspondant
			$compte_bancaire_cible = new compte_bancaire ($this->id_compte_bancaire_source);
			//vérification du journal correspondant au compte
			$journal_banque_arrivee = compta_journaux::check_exist_journaux ($DEFAUT_ID_JOURNAL_BANQUES, $compte_bancaire_cible->getDefaut_numero_compte ());
			// récupération du compte tier vente
			$numero_compte_comptable = $DEFAUT_COMPTE_TIERS_ACHAT;
			if (isset($infos["doc_ACCEPT_REGMT"]) && $infos["doc_ACCEPT_REGMT"] == "1") {$numero_compte_comptable = $DEFAUT_COMPTE_TIERS_VENTE;}
			$tmp_contact = new contact ($this->ref_contact);
			if ($tmp_contact->getRef_contact()) {
				$profils 	= $tmp_contact->getProfils ();
				//gestion des cas ambigus entre profils et sens de règlement
				if (isset($profils[$CLIENT_ID_PROFIL]) && !isset($profils[$FOURNISSEUR_ID_PROFIL]) ) { $ID_PROFIL = $CLIENT_ID_PROFIL;}
				if (!isset($profils[$CLIENT_ID_PROFIL]) && isset($profils[$FOURNISSEUR_ID_PROFIL]) ) { $ID_PROFIL = $FOURNISSEUR_ID_PROFIL;}
				
				if (isset($profils[$CLIENT_ID_PROFIL]) && isset($profils[$FOURNISSEUR_ID_PROFIL]) ) { 
					$ID_PROFIL = $FOURNISSEUR_ID_PROFIL;
					if (isset($infos["doc_ACCEPT_REGMT"]) && $infos["doc_ACCEPT_REGMT"] == "1") {$ID_PROFIL = $CLIENT_ID_PROFIL;}
				}
				$numero_compte_comptable = $profils[$ID_PROFIL]->getDefaut_numero_compte ();
			} 
			//création des opérations de journaux		
			$journal_banque_arrivee->create_operation ($numero_compte_comptable, -$this->montant_reglement, $this->ref_reglement, $this->date_reglement, 6); 
		break;

		case $COMP_S_ID_REGMT_MODE:
			$infos_avc['ref_contact'] 			= $this->ref_contact;
			$infos_avc['id_reglement_mode'] = $AVC_E_ID_REGMT_MODE;
			$infos_avc['date_reglement']	= $this->date_reglement;
			$infos_avc['date_echeance']		= $this->date_echeance;
			$infos_avc['direction_reglement'] = "sortant";
			$infos_avc['montant_reglement'] = $this->montant_reglement;
			$infos_avc['ref_reglement_comp'] = $this->ref_reglement;
			$avc = new reglement();
			$avc->create_reglement($infos_avc);
			$this->ref_avc = $avc->getRef_reglement();

			$query = "INSERT INTO regmt_avc (ref_reglement_avc, ref_reglement_comp) 
								VALUES ('".$this->ref_avc."', '".$this->ref_reglement."') ";
			$bdd->exec ($query);
		break;

		case $COMP_E_ID_REGMT_MODE:
			$infos_avf['ref_contact'] 			= $this->ref_contact;
			$infos_avf['id_reglement_mode'] = $AVF_S_ID_REGMT_MODE;
			$infos_avf['date_reglement']	= $this->date_reglement;
			$infos_avf['date_echeance']		= $this->date_echeance;
			$infos_avf['direction_reglement'] = "sortant";
			$infos_avf['montant_reglement'] = abs($this->montant_reglement);
			$infos_avf['ref_reglement_comp'] = $this->ref_reglement;
			$avf = new reglement();
			$avf->create_reglement($infos_avf);
			$this->ref_avf = $avf->getRef_reglement();

			$query = "INSERT INTO regmt_avf (ref_reglement_avf, ref_reglement_comp)
								VALUES ('".$this->ref_avf."', '".$this->ref_reglement."') ";
			$bdd->exec ($query);
		break;

		case $AVC_E_ID_REGMT_MODE:
		case $AVF_S_ID_REGMT_MODE:
		break;
		
		case $TPV_E_ID_REGMT_MODE:
		
			compte_tpv::add_compte_tp_contenu (array(array("id_compte_tp"=>$this->id_compte_tpv_dest, "tp_type"=>"TPV", "montant_contenu"=>$this->montant_reglement, "id_compte_caisse"=>NULL,  "infos_supp"=>$this->ref_reglement, "controle"=>0)));
		
			$query = "INSERT INTO regmt_e_tpv (ref_reglement, id_compte_tpv_dest) 
								VALUES ('".$this->ref_reglement."', '".$this->id_compte_tpv_dest."') ";
			$bdd->exec ($query);
		break;
		
		 case $LC_E_ID_REGMT_MODE:
						$query = "INSERT INTO regmt_e_lcr (ref_reglement, id_compte_bancaire_source, id_compte_bancaire_dest)
								VALUES ('".$this->ref_reglement."',
												'".$this->id_compte_bancaire_source."', '".$this->id_compte_bancaire_dest."') ";
			$bdd->exec ($query);

			//création de l'opération dans le journal de banque correspondant
			$compte_bancaire_cible = new compte_bancaire ($this->id_compte_bancaire_dest);
			//vérification du journal correspondant au compte
			$journal_banque_arrivee = compta_journaux::check_exist_journaux ($DEFAUT_ID_JOURNAL_BANQUES, $compte_bancaire_cible->getDefaut_numero_compte ());
			// récupération du compte tier vente
			$numero_compte_comptable = $DEFAUT_COMPTE_TIERS_VENTE;
			if (isset($infos["doc_ACCEPT_REGMT"]) && $infos["doc_ACCEPT_REGMT"] == "-1") {$numero_compte_comptable = $DEFAUT_COMPTE_TIERS_ACHAT;}
			$tmp_contact = new contact ($this->ref_contact);
			if ($tmp_contact->getRef_contact()) {
				$profils 	= $tmp_contact->getProfils ();
				//gestion des cas ambigus entre profils et sens de règlement
				if (isset($profils[$CLIENT_ID_PROFIL]) && !isset($profils[$FOURNISSEUR_ID_PROFIL]) ) { $ID_PROFIL = $CLIENT_ID_PROFIL;}
				if (!isset($profils[$CLIENT_ID_PROFIL]) && isset($profils[$FOURNISSEUR_ID_PROFIL]) ) { $ID_PROFIL = $FOURNISSEUR_ID_PROFIL;}

				if (isset($profils[$CLIENT_ID_PROFIL]) && isset($profils[$FOURNISSEUR_ID_PROFIL]) ) {
					$ID_PROFIL = $CLIENT_ID_PROFIL;
					if (isset($infos["doc_ACCEPT_REGMT"]) && $infos["doc_ACCEPT_REGMT"] == "-1") {$ID_PROFIL = $FOURNISSEUR_ID_PROFIL;}
				}
				$numero_compte_comptable = $profils[$ID_PROFIL]->getDefaut_numero_compte ();
			}
			//création des opérations de journaux
			$journal_banque_arrivee->create_operation ($numero_compte_comptable, $this->montant_reglement, $this->ref_reglement, $this->date_reglement, 5);
		break;
		
		default: exit();
	}
	
	$bdd->commit();
	
	return true;
}



// *************************************************************************************************************
// FONCTIONS LIEES A LA MODIFICATION D'UN REGLEMENT
// *************************************************************************************************************


public function delete_reglement () {
	global $bdd;
	
	global $ESP_E_ID_REGMT_MODE;
	global $ESP_S_ID_REGMT_MODE;
	global $CHQ_E_ID_REGMT_MODE;
	global $CHQ_S_ID_REGMT_MODE;
	global $CB_E_ID_REGMT_MODE;
	global $CB_S_ID_REGMT_MODE;
	global $VIR_E_ID_REGMT_MODE;
	global $VIR_S_ID_REGMT_MODE;
	global $LCR_E_ID_REGMT_MODE;
	global $LCR_S_ID_REGMT_MODE;
	global $PRB_E_ID_REGMT_MODE;
	global $PRB_S_ID_REGMT_MODE;
	global $AVC_E_ID_REGMT_MODE;
	global $AVF_S_ID_REGMT_MODE;
	global $COMP_S_ID_REGMT_MODE;
	global $COMP_E_ID_REGMT_MODE;
	global $TPV_E_ID_REGMT_MODE;
	global $LC_E_ID_REGMT_MODE;

	// *************************************************
	// Controle de la possibilité de supprimer le règlement
	
	//si le reglement est du type espece cheque ou cB
	if (($this->id_reglement_mode == $ESP_E_ID_REGMT_MODE) || ($this->id_reglement_mode == $ESP_S_ID_REGMT_MODE) || ($this->id_reglement_mode == $CHQ_E_ID_REGMT_MODE) || ($this->id_reglement_mode == $CB_E_ID_REGMT_MODE) ) {
		
		$reg_infos = get_infos_reglement_type ($this->id_reglement_mode, $this->ref_reglement);
		
		$id_compte_caisse = load_caisse_move ($reg_infos->id_compte_caisse_move);
		if (count($reg_infos)) {
			switch ($this->id_reglement_mode) {
				case $ESP_E_ID_REGMT_MODE:
					// on cré un mouvement de caisse inverse
					compte_caisse::create_compte_caisse_move ($id_compte_caisse, 1, $this->id_reglement_mode, -$this->montant_reglement, $this->ref_reglement);
					//on cherche à supprimer du contenu de caisse le règlement
					compte_caisse::maj_esp_compte_caisse_contenu ($id_compte_caisse, $ESP_E_ID_REGMT_MODE, -$this->montant_reglement);
				break;
				case $ESP_S_ID_REGMT_MODE:
					// on cré un mouvement de caisse inverse
					compte_caisse::create_compte_caisse_move ($id_compte_caisse, 1, $this->id_reglement_mode, $this->montant_reglement, $this->ref_reglement);
					//on cherche à supprimer du contenu de caisse le règlement
					compte_caisse::maj_esp_compte_caisse_contenu ($id_compte_caisse, $ESP_E_ID_REGMT_MODE, $this->montant_reglement);
				break;
				case $CHQ_E_ID_REGMT_MODE:
					// on cré un mouvement de caisse inverse
					compte_caisse::create_compte_caisse_move ($id_compte_caisse, 1, $this->id_reglement_mode, -$this->montant_reglement, $this->ref_reglement);
					//on cherche à supprimer du contenu de caisse le règlement
					compte_caisse::del_line_compte_caisse_contenu (array("id_compte_caisse_source"=>$id_compte_caisse, "id_reglement_mode"=>$this->id_reglement_mode,"montant_contenu"=>$this->montant_reglement, "infos_supp"=>$this->ref_reglement)) ;
				break;
				case $CB_E_ID_REGMT_MODE:
					// on cré un mouvement de caisse inverse
					compte_caisse::create_compte_caisse_move ($id_compte_caisse, 1, $this->id_reglement_mode, -$this->montant_reglement, $this->ref_reglement);
					//on cherche à supprimer du contenu de tp le règlement
					compte_tpe::del_line_compte_tp_contenu (array("id_compte_caisse_source"=>$id_compte_caisse, "montant_contenu"=>$this->montant_reglement, "infos_supp"=>$this->ref_reglement)) ;
				break;
				case $LC_E_ID_REGMT_MODE:
					// on cré un mouvement de caisse inverse
					compte_caisse::create_compte_caisse_move ($id_compte_caisse, 1, $this->id_reglement_mode, -$this->montant_reglement, $this->ref_reglement);
					//on cherche à supprimer du contenu de tp le règlement
					compte_tpe::del_line_compte_tp_contenu (array("id_compte_caisse_source"=>$id_compte_caisse, "montant_contenu"=>$this->montant_reglement, "infos_supp"=>$this->ref_reglement)) ;				
				break;
			}
	
		}
	}
	//si le reglement est du type TPV
	if ($this->id_reglement_mode == $TPV_E_ID_REGMT_MODE) {
		//on cherche à supprimer du contenu de tp le règlement
		compte_tpv::del_line_compte_tp_contenu (array("id_compte_caisse_source"=>"", "montant_contenu"=>$this->montant_reglement, "infos_supp"=>$this->ref_reglement)) ;
	}
	//supression des lignes comptables dans journaux de caisse ou banque
	switch ($this->id_reglement_mode) {
		case $VIR_E_ID_REGMT_MODE: case $LCR_E_ID_REGMT_MODE: case $PRB_E_ID_REGMT_MODE: 
			compta_journaux::suppression_operation ($this->ref_reglement, 5);
		break;

case $CHQ_S_ID_REGMT_MODE: case $CB_S_ID_REGMT_MODE: case $VIR_S_ID_REGMT_MODE: case $LCR_S_ID_REGMT_MODE: case $PRB_S_ID_REGMT_MODE:
			compta_journaux::suppression_operation ($this->ref_reglement, 6);
		break;
	}
	
	//on supprime le règlement
	$query = "DELETE FROM reglements WHERE ref_reglement = '".$this->ref_reglement."' ";
	$bdd->exec ($query);
	
	return true;
}




// *************************************************************************************************************
// FONCTIONS LIEES AU LETTRAGE D'UN REGLEMENT
// *************************************************************************************************************
protected function charger_lettrages () {
	global $bdd;
	global $CALCUL_TARIFS_NB_DECIMALS;

	$this->documents_lettrages = array();
	$query = "SELECT ref_doc, round(montant, ".$CALCUL_TARIFS_NB_DECIMALS.") as  montant , liaison_valide
						FROM reglements_docs
						WHERE ref_reglement = '".$this->ref_reglement."'  ";
	$resultat = $bdd->query ($query);
	while ($tmp = $resultat->fetchObject()) { $this->documents_lettrages[] = $tmp; }
	$this->documents_lettrages_loaded = true;

	return true;
}


protected function charger_montant_lettrages () {
	global $bdd;

	$this->montant_lettrages	= 0;
	$this->montant_disponible = $this->montant_reglement;
	$this->montant_dispo_loaded = false; 

	$query = "SELECT SUM(montant) montant_lettrages
						FROM reglements_docs
						WHERE ref_reglement = '".$this->ref_reglement."' && liaison_valide = 1 ";
	$resultat = $bdd->query ($query);
	$tmp = $resultat->fetchObject();

	$this->montant_lettrages	= $tmp->montant_lettrages;
	$this->montant_disponible	= $this->montant_reglement - $this->montant_lettrages;
	$this->montant_dispo_loaded = true;

	if ($this->montant_disponible < 0) {
	//	alerte_dev ("Un reglement a été lettré pour plus que son montant : ".$this->ref_reglement);
	}

	return true;
}




// *************************************************************************************************************
// FONCTIONS DE RESTITUTION DES DONNEES 
// *************************************************************************************************************

function getRef_reglement () {
	return $this->ref_reglement;
}

function getRef_contact () {
	return $this->ref_contact;
}

function getDate_reglement () {
	return $this->date_reglement;
}

function getId_reglement_mode () {
	return $this->id_reglement_mode;
}

function getLib_reglement_mode () {
	return $this->lib_reglement_mode;
}

function getAbrev_reglement_mode () {
	return $this->abrev_reglement_mode;
}

function getType_reglement () {
	return $this->type_reglement	;
}

function getMontant_reglement () {
	return $this->montant_reglement;
}

function getValide () {
	return $this->valide;
}

function getLettrages () {
	if (!$this->documents_lettrages_loaded) { $this->charger_lettrages(); }
	return $this->documents_lettrages;
}

function getMontant_lettrages () {
	$this->charger_montant_lettrages();
	return $this->montant_lettrages;
}

function getMontant_disponible () {
	if (!$this->montant_dispo_loaded) {	$this->charger_montant_lettrages(); }
	$this->charger_montant_lettrages();
	return $this->montant_disponible;
}


// *************************************************************************************************************
// Informations complémentaires fonction du mode de règlement
function getDate_echeance () {
	return $this->date_echeance;
}

function getId_compte_bancaire_source () {
	return $this->id_compte_bancaire_source;
}

function getId_compte_bancaire_dest () {
	return $this->id_compte_bancaire_dest;
}

function getRef_avc () {
	return $this->ref_avc;
}
function getRef_avf () {
	return $this->ref_avf;
}


//******************************************************************************
// Fonctions informative (fonctionne pour les chèques)

public function getInfos_depot(){
    global $bdd;

    if($this->getId_reglement_mode() == $GLOBALS['CHQ_E_ID_REGMT_MODE']){
        $query = "SELECT ccd.id_compte_bancaire_destination, ccd.date_depot  
                    FROM comptes_caisses_depots_montants ccdm
                      LEFT JOIN comptes_caisses_depots ccd ON ccd.id_compte_caisse_depot = ccdm.id_compte_caisse_depot 
                    WHERE infos_depot LIKE '".$this->getRef_reglement()."%' ;";
        $stt = $bdd->query($query);
        if(is_object($stt) && $depot = $stt->fetchObject()){
            $compte = new compte_bancaire($depot->id_compte_bancaire_destination);
            $date_depot = $depot->date_depot; 
            $stt->closeCursor();
            return "Chèque remisé le ".date_Us_to_Fr($date_depot)." (".$compte->getLib_compte().").";
        }
        
        $reglements_infos = get_infos_reglement_type ($this->getId_reglement_mode(), $this->getRef_reglement());
        $caisse = new compte_caisse(load_caisse_move($reglements_infos->id_compte_caisse_move));
        return "Chèque en caisse (".$caisse->getLib_caisse().").";
    }
    return "";
}


}

// *************************************************************************************************************
// Fonctions permettant de retourner la liste des moyens de paiement disponible
function getReglements_modes ($type = "entrant") {
	global $bdd;

  if ($type != "entrant") {
		$query_where = " type_reglement = 'sortant' ";
	}
	else {
		$query_where = " type_reglement = 'entrant' ";
  }

	// Liste des modes de reglements
	$reglements_modes = array();
	$query = "SELECT id_reglement_mode, lib_reglement_mode, abrev_reglement_mode, emission, destination, allow_date_echeance
						FROM reglements_modes
						WHERE ".$query_where." && id_reglement_mode !=13 && id_reglement_mode != 14 && id_reglement_mode !=15 && id_reglement_mode != 16 && id_reglement_mode != 17
						ORDER BY id_reglement_mode ASC";
	$resultat = $bdd->query ($query);
	while ($modes = $resultat->fetchObject()) { $reglements_modes[] = $modes; }

	return $reglements_modes;
}

function getReglements_modes_date_echeance ($id_reglement_mode) {
	global $bdd;

	$reglements_modes	= array();
	$query = "SELECT allow_date_echeance
						FROM reglements_modes 
						WHERE id_reglement_mode = '".$id_reglement_mode."' ";
	$resultat = $bdd->query ($query);
	while ($modes = $resultat->fetchObject()) { $reglements_modes = $modes; }
	return $reglements_modes;
}


function get_infos_reglement_type ($id_reglement_mode, $ref_reglement) {
	global $bdd;
	
	//liste des correspondance entre les mode de règlement et les infos correspondantes au règlement
	$reglements_correspond = array (1=>"regmt_e_esp" , 2=>"regmt_e_chq" , 3=>"regmt_e_cb" , 4=>"regmt_e_vir" , 5=>"regmt_e_lcr" , 6=>"regmt_e_prb" , 7=>"regmt_s_esp" , 8=>"regmt_s_chq" , 9=>"regmt_s_cb" , 10=>"regmt_s_vir" , 11=>"regmt_s_lcr" , 12=>"regmt_s_prb" , 13=>"regmt_avc" , 15=>"regmt_avf" , 17=>"regmt_e_tpv" , 18=>"regmt_e_lcr");
	
	$colum_correspond = array(1=>"" , 2=>"" , 3=>"" , 4=>"" , 5=>"" , 6=>"" , 7=>"" , 8=>"" , 9=>"" , 10=>"" , 11=>"" , 12=>"" , 13=>"_avc" , 15=>"_avf" , 17=>"" , 18=>"" )
	;
	
	$reglement_infos = array();
	
	if (isset($reglements_correspond[$id_reglement_mode])) {
	$query = "SELECT *
						FROM ".$reglements_correspond[$id_reglement_mode]." 
						WHERE ref_reglement".$colum_correspond[$id_reglement_mode]." = '".$ref_reglement."' ";
	$resultat = $bdd->query ($query);
	while ($infos = $resultat->fetchObject()) { $reglement_infos = $infos; }
	}

	return $reglement_infos; 
}

/*
Information sur la gestion des avoirs
Un Avoir Client est avant tout une facture d'avoir. Une facture ayant un montant négatif.
Cette facture d'avoir peut soit donner lieu à un remboursement (espèce, chèque, etc.)
Cette facture d'avoir peut aussi etre déduite des règlements dus pour une autre facture.
- Dans ce dernier cas, on génère une "Compensation" depuis l'avoir.
Cette compensation est considéré comme un moyen de régler (solder) la facture d'avoir.
Dans le meme temps, il est créé un règlement appelé Avoir Client (AVC) qui lui sera utilisé comme un règlement standard.
*/

?>