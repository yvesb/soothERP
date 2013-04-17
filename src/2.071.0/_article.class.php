<?php
// *************************************************************************************************************
// CLASSE REGISSANT LES INFORMATIONS SUR UN ARTICLE 
// *************************************************************************************************************


/**
 * @author Administrateur
 *
 */
final class article {
	private $ref_article;				// Référence de l'article pour INFOLYEN
	private $ref_oem;						// Référence de l'article pour le constructeur
	private $ref_interne;				// Référence de l'article pour l'enterprise

	private $lib_article;				// Libellé génral du produit
	private $lib_ticket;				// Libellé imprimé sur ticket
	private $desc_courte;				// Description affichée sur les documents
	private $desc_longue;				// Description affichée sur la fiche produit
	
	private $is_achetable;				// l'article peut il être acheté
	private $is_vendable;				// l'article peut il être vendu

	private $ref_art_categ;			// Référence de la catégorie d'article
	private $lib_art_categ;			// Libellé de la catégorie d'article

	private $modele;						// Modele d'article: Matériel, Service, Service par abonnement
	private $id_modele_spe;			// Modèle spécifiques d'article
	private $lib_modele_spe;

	private $ref_constructeur;	// Référence INFOLYEN du constructeur
	private $nom_constructeur;	// Nom du constructeur

	private $prix_public_ht;		// Prix public annoncé par le constructeur
	private $prix_achat_ht;			// Prix achat envisagé
	private $paa_ht;						// Prix achat actuel
	private $paa_last_maj; 			// date de maj par l'utilisateur du paa
	private $id_tva;						// ID_TVA utilisé
	private $tva;								// Taux de TVA de l'article
	private $promo;								// Taux de TVA de l'article

	private $id_valo;						// id du mode de valorisation
	private $valo_indice;				// Pas pour l'incrémentation de la quantité

	private $lot;								// L'article est-il un lot composé d'autres articles
	private $composants;				// Liste des articles composants l'article (si il s'agit d'un Lot)
	private $composants_loaded;	// Les composants de l'article sont ils chargés ?

	private $composant;					// L'article est-il un composant pour d'autres articles.
	private $lots;							// Liste des articles lot dont l'article est composant
	private $lots_loaded;				// Les lots ont-ils été chargés

	private $liaisons;					// Articles liés à cet article
	private $liaisons_loaded;		// Les liaisons sont elles chargées ?

	private $images;						//images de l'article
	private $images_loaded;			//images de l'article chargées ?

	private $variante;					// L'article possède-t-il des variantes ? (1 = Oui, 2 = Cet article est le Modèle)
	private $variantes;					// Liste des articles variantes de l'article (si il possède des variantes)
	private $variante_master;		// si cet article est une variante esclave, on détermine la ref du maitre
	private $variante_slaves;		// si cet article est une variante maitre, on détermine la liste des articles esclaves

	private $gestion_sn;				// Un numéro de série est-il nécessaire pour identifier une occurence

	private $date_debut_dispo;	// Date de début de disponibilité de l'article
	private $date_fin_dispo;		// Date de fin de disponibilité de l'article
	private $dispo;							// L'article est-il disponible ?

	private $date_creation;			// Date de création de l'article
	private $date_modification;	// Date de modification de l'article

	// Informations spécialisées pour les matériels
	private $poids;
	private $colisage;
	private $duree_garantie;

	// Informations spécialisées pour les services
	// Informations spécialisées pour les services par abonnement
	private $duree;
	private $engagement;
	private $reconduction;
	private $preavis;

	// Informations spécialisées pour les services à la consommation (prépayés)
	private $duree_validite;
	private $nb_credits;

	private $formules_tarifs;		// Formules permettant de calculer le tarif de l'article
	private $formules_tarifs_loaded;
	// FORMULES TARIFS
		// id_tarif
		// indice_qte
		// formule_tarif

	private $tarifs;						// Prix unitaires de l'article fonction de la grille de tarif et de la quantité
	private $tarifs_loaded;
	// TARIFS
		// id_tarif
		// indice_qte
		// pu_ht

	private $taxes;							// Taxes associées à l'article
	private $taxes_loaded;
	// TAXES
		// id_taxe
		// lib_taxe
		// id_pays
		// montant_taxe

	private $caracs;						// Caractéristiques de l'article
	private $caracs_loaded;
	// CARACS										// Pas de classe spécifique
		// ref_carac
		// ref_art_categ						// Référence de la catégorie associée
		// lib_carac								// Libellé
		// unite										// Unité de mesure
		// defaut_valeur						// Valeur par défaut
		// moteur_recherche					// Cette carac sert-elle à la recherche des articles ? 0 = Non, 1 = Oui
		// affichage								// Cette carac est-elle affichée sur la fiche des articles ? 1 = Basic, 2 = Avancée
		// ref_carac_groupe					// Groupe de caractéristique
		// ordre										// Ordre d'affichage
	private $caracs_groupes;			// Groupes de caractéristiques de la catégorie d'article
	private $caracs_groupes_loaded;
	// CARACS_GROUPES							// Pas de classe spécifique
		// ref_carac_groupe
		// ref_art_categ						// Référence de la catégorie associée
		// lib_carac_groupe					// Libellé
		// ordre										// Ordre d'affichage

	private $codes_barres;				// Codes à barre de l'article
	private $codes_barres_loaded;

	private $stocks;							// Stocks de l'article
	private $stocks_loaded;

	private $emplacements;				//tableau des emplacements indexé sur l'id_stock
	
	
	private $stocks_rsv;					// Stock réservé (commande client en cours)
	private $stocks_cdf;					// Stock en commande fournisseur (réappro)
	private $stocks_tofab;		// Stock des composants permettant de fabriquer l'article (si composé)
	private $stocks_arti_sn;			//numeros de série ou de lot en stock

	private $stocks_alertes;			// Seuils d'alerte de stock de l'article avec emplacement dans le stock
	private $stocks_alertes_loaded;
	
	private $is_in_stock; 				// l'article est il en stock (tout stock confondus)

	private $last_docs;						// Derniers documents ayant intégré cet article
	private $last_docs_loaded;

	private $ref_externes;				// références fournisseurs de cet article
	private $ref_externes_loaded;

	private $tags = array();


	private $STOCK_ARTICLE_ID_REFERENCE_TAG = 16;
	
	private $code_pdf_modele;
	
	/**
	 * @var Numeros de comptes comptables
	 * associés a un article
	 */
	private $numero_compte_achat; //achat
	private $numero_compte_vente; //vente


function __construct($ref_article = "") {
	global $bdd;

	// Controle si la ref_article est précisée
	if (!$ref_article) { return false; }
	//@FIXME utilisation de modele spe
	// Sélection des informations générales
	$query = "SELECT ref_oem, ref_interne, lib_article, lib_ticket, desc_courte, desc_longue, is_achetable, is_vendable,
									 prix_public_ht, prix_achat_ht, paa_ht, paa_last_maj, id_valo, valo_indice, lot, composant, variante, gestion_sn, promo,
									 date_debut_dispo, date_fin_dispo, dispo, a.date_creation, a.date_modification,
									 a.ref_constructeur, ann.nom nom_constructeur,
									 a.ref_art_categ, ac.lib_art_categ, a.modele,
									 a.id_tva, t.tva,

									 amm.poids, amm.colisage, amm.duree_garantie,

									 amsa.duree, amsa.engagement, amsa.reconduction, amsa.preavis,

									 amsc.duree_validite, amsc.nb_credits,
									 a.id_modele_spe, acs.lib_modele_spe,
									 
									 a.numero_compte_achat, a.numero_compte_vente

						FROM articles a
							LEFT JOIN annuaire ann ON a.ref_constructeur = ann.ref_contact
							LEFT JOIN art_categs ac ON a.ref_art_categ = ac.ref_art_categ
							LEFT JOIN tvas t ON a.id_tva = t.id_tva
							LEFT JOIN articles_modele_materiel amm ON a.ref_article = amm.ref_article
							LEFT JOIN articles_modele_service ams ON a.ref_article = ams.ref_article
							LEFT JOIN articles_modele_service_abo amsa ON a.ref_article = amsa.ref_article
							LEFT JOIN articles_modele_service_conso amsc ON a.ref_article = amsc.ref_article
							LEFT JOIN art_categs_specificites acs ON acs.id_modele_spe = a.id_modele_spe


						WHERE a.ref_article = '".$ref_article."'  ";
	$resultat = $bdd->query ($query);

	$query_tags = "SELECT mot_cle FROM articles_mots_cles WHERE ref_article = '".$ref_article."';";
	$res = $bdd->query($query_tags);
    while ($tmp = $res->fetchObject()) $this->tags[] = $tmp->mot_cle;

	// Controle si la ref_article est trouvée
	if (!$article = $resultat->fetchObject()) { return false; }

	// Attribution des informations à l'objet
	$this->ref_article 		= $ref_article;
	$this->ref_oem 				= $article->ref_oem;
	$this->ref_interne		= $article->ref_interne;

	$this->lib_article		= $article->lib_article;
	$this->lib_ticket			= $article->lib_ticket;
	$this->desc_courte		= $article->desc_courte;
	$this->desc_longue		= $article->desc_longue;

	$this->is_achetable		= ($article->is_achetable)? true: false;
	$this->is_vendable		= ($article->is_vendable)? true: false;
	
	
	$this->ref_constructeur	= $article->ref_constructeur;
	$this->nom_constructeur	= $article->nom_constructeur;

	$this->prix_public_ht	= $article->prix_public_ht;
	$this->prix_achat_ht	= $article->prix_achat_ht;
	$this->paa_ht					= $article->paa_ht;
	$this->paa_last_maj		= $article->paa_last_maj;
	$this->id_tva					= $article->id_tva;
	$this->tva						= $article->tva;
	$this->promo					= $article->promo;

	$this->id_valo				= $article->id_valo;
	$this->valo_indice 		= $article->valo_indice;
	$this->lot		 				= $article->lot;

	$this->gestion_sn			= $article->gestion_sn;
	$this->composant			= $article->composant;
	$this->variante				= $article->variante;

	$this->date_debut_dispo	= $article->date_debut_dispo;
	$this->date_fin_dispo		= $article->date_fin_dispo;
	$this->dispo	 					= $article->dispo;

	$this->date_creation			= $article->date_creation;
	$this->date_modification	= $article->date_modification;

	$this->ref_art_categ 		= $article->ref_art_categ;
	$this->lib_art_categ 		= $article->lib_art_categ;
	$this->modele 					= $article->modele;
	$this->id_modele_spe		= $article->id_modele_spe;
	$this->lib_modele_spe		= $article->lib_modele_spe;

	//variable de présence globaqle de l'article en stock (basé sur la somme de tout les stocks)
	$this->is_article_in_stock ();

	// Données spécialisées MATERIEL
	$this->poids				= $article->poids;
	$this->colisage			= $article->colisage;
	$this->duree_garantie	= $article->duree_garantie;
	// Données spécialisées SERVICES ABO//
	$this->duree					= $article->duree;
	$this->engagement			= $article->engagement;
	$this->reconduction		= $article->reconduction;
	$this->preavis				= $article->preavis;
	// Données spécialisées SERVICES CONSO
	$this->duree_validite	= $article->duree_validite;
	$this->nb_credits	= $article->nb_credits;

	//cet article est une variante esclave, on dois trouver son maitre
	if ($this->variante == 1) {$this->find_my_master ();}
	//cet article est une variante maitre, on dois trouver ses esclave
	if ($this->variante == 2) {$this->find_my_slaves ();}

	// Données spécialisées SERVICE
	// Données spécialisées SERVICE PAR ABONNEMENT

	// Modèle PDF
	$this->set_default_code_pdf_modele();
	
	//Compte comptables
	$this->numero_compte_vente = $article->numero_compte_vente;
	$this->numero_compte_achat = $article->numero_compte_achat;
	
	return true;
}




// *************************************************************************************************************
// FONCTIONS LIEES A LA CREATION D'UN ARTICLE function
// *************************************************************************************************************

final public function create ($infos_generales, $infos_modele, $caracs, $formuls_tarifs, $composants, $liaisons, $ref_article = "", $is_achetable = true, $is_vendable = true) {
	global $CONFIG_DIR;
	global $bdd;

	global $BDD_MODELES;
	global $DEFAUT_ID_VALO;
	global $DEFAUT_VALO_INDICE;

	$ARTICLE_ID_REFERENCE_TAG = 1;		// Référence Tag utilisé dans la base de donnée


	// *************************************************
	// Controle des données générales
	$this->ref_oem 			= $infos_generales['ref_oem'];
	$this->ref_interne 	= $infos_generales['ref_interne'];
	if ($this->ref_interne) {
		// Doit etre unique
		$query = "SELECT ref_article FROM articles WHERE ref_interne = '".addslashes($this->ref_interne)."' ";
		$resultat = $bdd->query ($query);
		if ($resultat->fetchObject()) {
			$GLOBALS['_ALERTES']['ref_interne_exist'] = 1;
		}
	}
	$this->lib_article 	= trim($infos_generales['lib_article']);
	if (!$this->lib_article) {
		$GLOBALS['_ALERTES']['lib_article_vide'] = 1;
	}
	$this->lib_ticket 	= trim($infos_generales['lib_ticket']);
	if (!$this->lib_ticket) { $this->make_lib_ticket(); }

	$this->desc_courte 	= trim($infos_generales['desc_courte']);
	$this->desc_longue 	= $infos_generales['desc_longue'];

	if (isset($infos_generales['tags'])) {
		$this->tags = explode(";", $infos_generales['tags']);
	}
	$this->ref_art_categ 	= $infos_generales['ref_art_categ'];
	if (!$this->ref_art_categ) {
		$GLOBALS['_ALERTES']['ref_art_categ_vide'] = 1;
	}
	$this->modele = $infos_generales['modele'];
	if (!in_array($this->modele, $BDD_MODELES)) {
		$GLOBALS['_ALERTES']['bad_modele'] = 1;
	}

	$this->ref_constructeur = $infos_generales['ref_constructeur'];
	$this->prix_public_ht		= convert_numeric($infos_generales['prix_public_ht']);
	if (!is_numeric($this->prix_public_ht)) {
		$this->prix_public_ht = "NULL";
	}
	$this->prix_achat_ht		= $infos_generales['prix_achat_ht'];
	if (!is_numeric($this->prix_achat_ht)) {
		$this->prix_achat_ht = "NULL";
	}
	$this->paa_ht		= convert_numeric($infos_generales['paa_ht']);
	if (!is_numeric($this->paa_ht)) {
		$this->paa_ht = "NULL";
	}
	$this->paa_last_maj = "";
	if ($this->paa_ht) {$this->paa_last_maj = date("Y-m-d H:i:s");}

	$this->id_tva		= convert_numeric($infos_generales['id_tva']);
	$this->tva = 19.6; /////////////////////////////////////////////////////////////////////////// REMPLACER LA LIGNE !!
	//$this->tva		= convert_numeric($infos_generales['tva']);
	$this->id_valo = $infos_generales['id_valo'];
	if (!$this->id_valo) {
		$this->id_valo = $DEFAUT_ID_VALO;
	}
	$this->valo_indice = $infos_generales['valo_indice'];
	if (!is_numeric($this->valo_indice)) {
		$this->valo_indice = $DEFAUT_VALO_INDICE;
	}

	$this->lot = $infos_generales['lot'];

	$this->variante	= $infos_generales['variante'];
	if ($this->variante != 0 && $this->variante != 1 && $this->variante != 2 ) {
		$this->variante = 0;
	}
	$this->gestion_sn	= $infos_generales['gestion_sn'];
	if ($this->gestion_sn != 0 && $this->gestion_sn != 1 && $this->gestion_sn != 2) {
		$this->gestion_sn = 0;
	}
	$this->date_debut_dispo	= $infos_generales['date_debut_dispo'];
	$this->date_fin_dispo		= $infos_generales['date_fin_dispo'];
	$this->check_dispo ();

	$is_achetable = ($is_achetable)? 1 : 0;
	$is_vendable = ($is_vendable)? 1 : 0;
	$this->is_achetable = ($is_achetable)? true : false;
	$this->is_vendable  = ($is_vendable)? true : false;
		
	
	// Controle des caractéristiques
	for ($i=0; $i<count($caracs); $i++) {
		$this->caracs[$i] = $caracs[$i];
	}

	// Controle des composants
	$this->composants = array();
	if ($this->lot) {
		for ($i=0; $i<count($composants); $i++) {
			$this->composants[$i] = $composants[$i];
		}
	}

	// Controle des liaisons
	for ($i=0; $i<count($liaisons); $i++) {
		$this->liaisons[$i] = $liaisons[$i];
	}

	// Taxes
	$taxes = array();
	$query = "SELECT act.id_taxe, code_taxe, info_calcul
						FROM art_categs_taxes act
							LEFT JOIN taxes t ON t.id_taxe = act.id_taxe
						WHERE ref_art_categ = '".$this->ref_art_categ."' ";
	$resultat = $bdd->query ($query);
	while ($var = $resultat->fetchObject()) { $taxes[] = $var; }

	// Code barre
	$code_barre = $infos_generales['code_barre'];

	// Formules de tarif
	$formules_tarifs = $formules_tarifs_categ = array();
	for ($i=0; $i < count($formuls_tarifs); $i++) {
		if ($formuls_tarifs[$i]->indice_qte) {
			$formules_tarifs[] = $formuls_tarifs[$i];
			continue;
		}
		$formules_tarifs_categ[$formuls_tarifs[$i]->id_tarif] = $formuls_tarifs[$i]->formule_tarif;
	}

	// *************************************************
	// Si les valeurs reçues sont incorrectes
	if (count($GLOBALS['_ALERTES'])) {
		return false;
	}

	// *************************************************
	// Création de la référence
	if (!$ref_article) {
		$reference = new reference ($ARTICLE_ID_REFERENCE_TAG);
		$this->ref_article = $reference->generer_ref();
	} else {
		$this->ref_article = $ref_article;
	}


	// *************************************************
	// Insertion dans la base
	$bdd->beginTransaction();

	// Généralités
	$query = "INSERT INTO articles
							(ref_article, ref_oem, ref_interne, lib_article, lib_ticket, desc_courte, desc_longue,
							 ref_art_categ, modele, ref_constructeur, prix_public_ht, prix_achat_ht, paa_ht, paa_last_maj, id_tva, id_valo, valo_indice,
							 lot, variante, gestion_sn, is_achetable, is_vendable, date_debut_dispo, date_fin_dispo, dispo, date_creation, date_modification)
						VALUES ('".$this->ref_article."', '".addslashes($this->ref_oem)."',
										".text_or_null(addslashes($this->ref_interne)).",
										'".addslashes($this->lib_article)."', '".addslashes($this->lib_ticket)."',
										'".addslashes($this->desc_courte)."', '".addslashes($this->desc_longue)."',
										'".$this->ref_art_categ."', '".$this->modele."', ".ref_or_null($this->ref_constructeur).",
										".num_or_null($this->prix_public_ht).", ".num_or_null($this->prix_achat_ht).",
										".num_or_null($this->paa_ht).",  '".($this->paa_last_maj)."',
										".num_or_null($this->id_tva).", '".$this->id_valo."', '".$this->valo_indice."',
										'".$this->lot."', '".$this->variante."', '".$this->gestion_sn."',
										'".$is_achetable."', '".$is_vendable."', '".$this->date_debut_dispo."', 
										'".$this->date_fin_dispo."', '".$this->dispo."', NOW(), NOW() ) ";
	$bdd->exec ($query);

	if (is_array($this->tags) && count($this->tags) > 0) {
	  $query = "INSERT INTO articles_mots_cles (ref_article, mot_cle) VALUES";
	  foreach ($this->tags as $tag) {
	    $query .= " ('".$this->ref_article."', '".$tag."'),";
    }
	  $query = substr($query, 0, -1).";";
	  $bdd->exec($query);
	}
	// Infos du modele
	$fonction = "create_infos_modele_".$this->modele;
	$this->{$fonction}($infos_modele);

	// Composants
	for ($i=0; $i<count($this->composants); $i++) {
		$composant = &$this->composants[$i];
		if(isset($composant->ref_article)){
			$this->add_composant ($composant->ref_article, $composant->qte, $composant->niveau, $composant->ordre);
		}
	}

	// Liaisons
	for ($i=0; $i<count($this->liaisons); $i++) {
		$liaison = &$this->liaisons[$i];
		$tmp_ratio = "";
		if(isset($liaison->ratio) && is_numeric($liaison->ratio)){
			$tmp_ratio = $liaison->ratio;
		}
		if(isset($liaison->ref_article)){
			$this->add_liaison ($liaison->ref_article, $liaison->id_type_liaison, $tmp_ratio);
		}
	}

	// Taxes
	foreach ($taxes as $taxe) {
		$this->add_taxe ($taxe->id_taxe, $taxe->code_taxe, $taxe->info_calcul);
	}

	// Formules de tarif & tarifs
	for ($i=0; $i<count($formules_tarifs); $i++) {
		$formule = &$formules_tarifs[$i];
		$this->add_formule_tarif ($formule->id_tarif, $formule->indice_qte, $formule->formule_tarif);
	}
	// Vérification de l'existence d'au moins 1 tarif pour chaque grille de tarif

	if (!$this->tarifs_loaded) { $this->charger_tarifs(); }
	get_tarifs_listes();
	foreach($_SESSION['tarifs_listes'] as $tarif) {
		$tarif_define = false;
		for ($i=0; $i<count($formules_tarifs); $i++) {
			if ($formules_tarifs[$i]->id_tarif != $tarif->id_tarif) { continue; }
			$tarif_define = true;
			break;
		}
		if (!$tarif_define && isset($formules_tarifs_categ[$tarif->id_tarif])) {
			$this->create_tarif ($tarif->id_tarif, 1, $formules_tarifs_categ[$tarif->id_tarif]);
		}
	}

	// Caractéristiques
	for ($i=0; $i<count($this->caracs); $i++) {
		$this->add_carac ($this->caracs[$i]->ref_carac, $this->caracs[$i]->valeur);
	}

	// Code barre
	foreach ($code_barre as $code) {
		$this->add_code_barre($code);
	}

	$bdd->commit();

	//mise à jour des prix de ventes
	$this->tarifs_loaded = false;
	$this->maj_all_tarifs();

	// *************************************************
	// Résultat positif de la création
	$GLOBALS['_INFOS']['Création_article'] = $this->ref_article;

	//**********************************************
	// Envoi EDI
	if($this->variante != 1){
            edi_event(111,$this->ref_art_categ, $this->ref_article);
	}
	
	return true;
}




// *************************************************************************************************************
// FONCTIONS LIEES AU MODELE D'ARTICLE    MATERIEL
// *************************************************************************************************************
function create_infos_modele_materiel ($infos_modele) {
	global $bdd;

	$this->poids = $infos_modele['poids'];
	if (!$this->poids) {
		$this->poids = 0;
	}
	if (!is_numeric($this->poids)) {
		$GLOBALS['_ALERTES']['bad_poids'] = 1;
	}
	$this->colisage = $infos_modele['colisage'];
	$this->duree_garantie = $infos_modele['duree_garantie'];
	if (!is_numeric($this->duree_garantie)) {
		$GLOBALS['_ALERTES']['bad_dure_garantie'] = 1;
	}
	// Controle des seuils de stock
	for ($i=0; $i<count($infos_modele['stocks_alertes']); $i++) {
		$this->stocks_alertes[$i] = new objet_virtuel();
		$this->stocks_alertes[$i]->id_stock 		= $infos_modele['stocks_alertes'][$i]->id_stock;
		$this->stocks_alertes[$i]->seuil_alerte = $infos_modele['stocks_alertes'][$i]->seuil_alerte;
		$this->stocks_alertes[$i]->emplacement = $infos_modele['stocks_alertes'][$i]->emplacement;
	}

	// *************************************************
	// Si les valeurs reçues sont incorrectes
	if (count($GLOBALS['_ALERTES'])) {
		return false;
	}

	// *************************************************
	// Insertion des infos dans la base de donnée
	$query = "REPLACE INTO articles_modele_materiel (ref_article, poids, colisage, duree_garantie)
						VALUES ('".$this->ref_article."', '".$this->poids."', '".$this->colisage."', '".$this->duree_garantie."') ";
	$bdd->exec ($query);
	
	// Ajout des seuils de stock
	for ($i=0; $i<count($this->stocks_alertes); $i++) {
		$this->add_stock_alerte ($this->stocks_alertes[$i]->id_stock, $this->stocks_alertes[$i]->seuil_alerte);
		$this->add_emplacement_stock($this->stocks_alertes[$i]->id_stock, $this->stocks_alertes[$i]->emplacement);
	}
	
	if($this->composant>0){
		$query = "SELECT amm.ref_article 
					FROM articles_modele_materiel amm
					LEFT JOIN articles_composants ac ON amm.ref_article = ac.ref_article_lot
					WHERE ac.ref_article_composant = '".$this->ref_article."'";
		
		$resultat = $bdd->query ($query);
		while ($var = $resultat->fetchObject()){
			$art_lots[] = $var;
		}
		$this->maj_poids_compo($art_lots, "");
	}

	edi_event(115,$this->ref_article);
	return true;
}

//Fonction qui met à jour le poids des articles lots
function maj_poids_compo($tab_art_lots, $article_lot){
	global $bdd;
	
	if(!empty($tab_art_lots)){
		foreach($tab_art_lots as $art_lot){
			$query = "SELECT SUM(amm.poids * ac.qte) poids
						FROM articles_modele_materiel amm
						LEFT JOIN articles_composants ac ON amm.ref_article = ac.ref_article_composant
						WHERE ac.ref_article_lot = '".$art_lot->ref_article."'";
			$resultat = $bdd->query ($query);
			
			if ($new_pds = $resultat->fetchObject()) {
				$query = "UPDATE articles_modele_materiel 
							SET poids = '".$new_pds->poids."'
							WHERE ref_article = '".$art_lot->ref_article."'";
				$bdd->exec ($query);
			}
		}
	}
	
	if(!empty($article_lot)){
		$query = "SELECT SUM(amm.poids * ac.qte) poids
						FROM articles_modele_materiel amm
						LEFT JOIN articles_composants ac ON amm.ref_article = ac.ref_article_composant
						WHERE ac.ref_article_lot = '".$article_lot."'";
		$resultat = $bdd->query ($query);
		
		if ($new_pds = $resultat->fetchObject()) {
			$query = "UPDATE articles_modele_materiel 
						SET poids = '".$new_pds->poids."'
						WHERE ref_article = '".$article_lot."'";
			$bdd->exec ($query);
		}
	}
	
	return true;
}


// *************************************************************************************************************
// FONCTIONS LIEES AU MODELE D'ARTICLE    SERVICE
// *************************************************************************************************************
function create_infos_modele_service ($infos_modele) {}
// *************************************************************************************************************
// FONCTIONS LIEES AU MODELE D'ARTICLE    SERVICE PAR ABONNEMENT
// *************************************************************************************************************
function create_infos_modele_service_abo ($infos_modele) {
	global $bdd;

	if (isset($infos_modele['duree'])) {$this->duree = $infos_modele['duree'];}
	if (!$this->duree) {
		$this->duree = 0;
	}
	if (!is_numeric($this->duree)) {
		$GLOBALS['_ALERTES']['bad_duree'] = 1;
	}
	if (isset($infos_modele['engagement'])) {$this->engagement = $infos_modele['engagement'];}
	if (!$this->engagement) {
		$this->engagement = 0;
	}
	if (!is_numeric($this->engagement)) {
		$GLOBALS['_ALERTES']['bad_engagement'] = 1;
	}
	if (isset($infos_modele['reconduction'])) {$this->reconduction = $infos_modele['reconduction'];}
	if (!$this->reconduction) {
		$this->reconduction = 0;
	}
	if (!is_numeric($this->reconduction)) {
		$GLOBALS['_ALERTES']['bad_reconduction'] = 1;
	}
	if (isset($infos_modele['preavis'])) {$this->preavis = $infos_modele['preavis'];}
	if (!$this->preavis) {
		$this->preavis = 0;
	}
	if (!is_numeric($this->preavis)) {
		$GLOBALS['_ALERTES']['bad_preavis'] = 1;
	}
	// *************************************************
	// Si les valeurs reçues sont incorrectes
	if (count($GLOBALS['_ALERTES'])) {
		return false;
	}

	// *************************************************
	// Insertion des infos dans la base de donnée
	$query = "REPLACE INTO articles_modele_service_abo (ref_article, duree, engagement, reconduction, preavis)
						VALUES ('".$this->ref_article."', '".$this->duree."', '".$this->engagement."', '".$this->reconduction."', '".$this->preavis."') ";
	$bdd->exec ($query);



	return true;
}

//fonction de création d'une ligne d'abonnement d'un article service par abonnement
function add_ligne_article_abonnement ($ref_doc, $ref_contact, $ref_doc_line, $qte = 1) {
	global $bdd;

	$duree_eng_mois = floor(($this->engagement*$this->duree)/ (30*24*3600));
	$duree_eng_jour = floor((($this->engagement*$this->duree) - (floor(($this->engagement*$this->duree)/ (30*24*3600)) * (30*24*3600)))/ (24*3600));

	$qte_mois = floor(($qte*$this->duree)/ (30*24*3600));
	$qte_jours = floor((($qte*$this->duree) - (floor(($qte*$this->duree)/ (30*24*3600)) * (30*24*3600)))/ (24*3600));


	if (!isset($GLOBALS['_OPTIONS']['CREATE_ABO']['id_abo'])) {
		//on récupére maintenant la date de création du doc en temps que créatiuon de l'abo
		$doc_abo = open_doc($ref_doc);

		$date_echeance = date("Y-m-d H:i:s", mktime(date("H", strtotime($doc_abo->getDate_creation())), date("i", strtotime($doc_abo->getDate_creation())), date("s", strtotime($doc_abo->getDate_creation())), date("m", strtotime($doc_abo->getDate_creation()))+($qte_mois), date("d", strtotime($doc_abo->getDate_creation()))+($qte_jours), date("Y", strtotime($doc_abo->getDate_creation()))));

		$fin_engagement = date("Y-m-d H:i:s", mktime(date("H", strtotime($doc_abo->getDate_creation())), date("i", strtotime($doc_abo->getDate_creation())), date("s", strtotime($doc_abo->getDate_creation())), date("m", strtotime($doc_abo->getDate_creation()))+($duree_eng_mois), date("d", strtotime($doc_abo->getDate_creation()))+($duree_eng_jour), date("Y", strtotime($doc_abo->getDate_creation()))));

		$fin_abonnement = "";
		if (!$this->reconduction) {$fin_abonnement = $fin_engagement;}

		// *************************************************
		// Insertion des infos dans la base de donnée
		$query = "INSERT INTO articles_abonnes (ref_contact, ref_article, date_souscription, date_echeance, date_preavis, fin_engagement, fin_abonnement)
							VALUES ('".$ref_contact."', '".$this->ref_article."', '".$doc_abo->getDate_creation()."', '".$date_echeance."', '', '".$fin_engagement."', '".$fin_abonnement."') ";
		$bdd->exec ($query);

		$id_abo = $bdd->lastInsertId();

		$query = "INSERT INTO articles_abonnes_livraisons (id_abo, ref_doc, ref_doc_line, date_renouvellement, date_echeance)
							VALUES ('".$id_abo."', '".$ref_doc."', '".$ref_doc_line."', '".$doc_abo->getDate_creation()."', '".$date_echeance."') ";
		$bdd->exec ($query);

	} else {
		$query_select = " SELECT id_abo, date_echeance, fin_engagement, fin_abonnement
											FROM articles_abonnes
											WHERE id_abo = '".$GLOBALS['_OPTIONS']['CREATE_ABO']['id_abo']."' ";
		$resultat_select = $bdd->query ($query_select);
		if ($abo_info = $resultat_select->fetchObject()) {

			//calcul des dates
			$jour_suivant = (date("d", strtotime($abo_info->date_echeance))+($qte_jours));

			$mois_suivant = (date("m", strtotime($abo_info->date_echeance))+($qte_mois));
			if (!checkdate($mois_suivant, $jour_suivant, date("Y", strtotime($abo_info->date_echeance))) || (date("Y-m-d",  strtotime($abo_info->date_echeance)) ==  date("Y-m-d",  mktime(0, 0, 0, date("m", strtotime($abo_info->date_echeance))+(1), 0, date("Y", strtotime($abo_info->date_echeance)))) ) ) {	$jour_suivant = 0; $mois_suivant +=1;}

			$date_echeance = date("Y-m-d H:i:s",  mktime(date("H", strtotime($abo_info->date_echeance)), date("i", strtotime($abo_info->date_echeance)), date("s", strtotime($abo_info->date_echeance)), $mois_suivant, $jour_suivant, date("Y", strtotime($abo_info->date_echeance))) );

			$fin_engagement = $abo_info->fin_engagement;
			$fin_abonnement = $abo_info->fin_abonnement;

			if (strtotime($date_echeance) >  strtotime($fin_engagement) && $this->reconduction) {
				$qte_jours_eng = $this->reconduction*floor((($this->duree) - (floor(($this->duree)/ (30*24*3600)) * (30*24*3600)))/ (24*3600));
				$qte_mois_eng = $this->reconduction*floor(($this->duree)/ (30*24*3600));

				$jour_suivant = (date("d", strtotime($fin_engagement))+($qte_jours_eng));
				$mois_suivant = (date("m", strtotime($fin_engagement))+($qte_mois_eng));
				if (!checkdate($mois_suivant, $jour_suivant, date("Y", strtotime($fin_engagement)) )  || (date("Y-m-d",  strtotime($fin_engagement)) ==  date("Y-m-d",  mktime(0, 0, 0, date("m", strtotime($fin_engagement))+(1), 0, date("Y", strtotime($fin_engagement)))) )) {	$jour_suivant = 0; $mois_suivant +=1;}


				$fin_engagement = date("Y-m-d H:i:s",  mktime(date("H", strtotime($fin_engagement)), date("i", strtotime($fin_engagement)), date("s", strtotime($fin_engagement)), $mois_suivant, $jour_suivant , date("Y", strtotime($fin_engagement))) );

			}

			if (strtotime($date_echeance) >  strtotime($fin_abonnement) && $fin_abonnement != "0000-00-00 00:00:00" ) {
				$date_echeance = $fin_abonnement;
			}


		}
		if (isset($date_echeance)) {
			$query = "UPDATE articles_abonnes
								SET date_echeance = '".$date_echeance."' , fin_engagement = '".$fin_engagement."' , fin_abonnement = '".$fin_abonnement."'
								WHERE id_abo = '".$GLOBALS['_OPTIONS']['CREATE_ABO']['id_abo']."' ";
			$bdd->exec ($query);

			$query2 = "INSERT INTO articles_abonnes_livraisons (id_abo, ref_doc, ref_doc_line, date_renouvellement, date_echeance)
								VALUES ('".$abo_info->id_abo."', '".$ref_doc."', '".$ref_doc_line."', NOW(), '".$date_echeance."') ";
			$bdd->exec ($query2);
		}
	}

	return true;
}


//Maj des infos d'un abonnement
function maj_infos_abonnement ($infos) {
	global $bdd;

			$query = "UPDATE articles_abonnes
								SET date_souscription = '".$infos["date_souscription"]."' ,date_echeance = '".$infos["date_echeance"]."' , fin_engagement = '".$infos["fin_engagement"]."' , fin_abonnement = '".$infos["fin_abonnement"]."' , date_preavis = '".$infos["date_preavis"]."'
								WHERE id_abo = '".$infos["id_abo"]."' ";
			$bdd->exec ($query);
	return true;
}


//Maj du préavis d'un abonnement
function maj_preavis_abonnement ($infos) {
	global $bdd;

	$qte_mois = floor(($this->duree)/ (30*24*3600));
	$qte_jours = floor((($this->duree) - (floor(($this->duree)/ (30*24*3600)) * (30*24*3600)))/ (24*3600));

	$nb_mois_preavis = floor($this->preavis/ (30*24*3600));
	$nb_jour_preavis = floor(($this->preavis - (floor($this->preavis/ (30*24*3600)) * (30*24*3600)))/ (24*3600));

	$query_select = " SELECT id_abo, date_echeance, fin_engagement, fin_abonnement
										FROM articles_abonnes
										WHERE id_abo = '".$infos["id_abo"]."' ";
	$resultat_select = $bdd->query ($query_select);
	if ($abo_info = $resultat_select->fetchObject()) {
		//on calcul la date de fin de preavis

		$jour_suivant = date("d", strtotime($infos["date_preavis"]))+($nb_jour_preavis);
		$mois_suivant = date("m", strtotime($infos["date_preavis"]))+($nb_mois_preavis);
		if (!checkdate($mois_suivant, $jour_suivant, date("Y", strtotime($infos["date_preavis"])) ) || (date("Y-m-d",  strtotime($infos["date_preavis"])) ==  date("Y-m-d",  mktime(0, 0, 0, date("m", strtotime($infos["date_preavis"]))+(1), 0, date("Y", strtotime($infos["date_preavis"])))) )) {	$jour_suivant = 0; $mois_suivant +=1;}

		$fin_preavis = date("Y-m-d H:i:s",  mktime(date("H", strtotime($infos["date_preavis"])), date("i", strtotime($infos["date_preavis"])), date("s", strtotime($infos["date_preavis"])), $mois_suivant, $jour_suivant , date("Y", strtotime($infos["date_preavis"]))) );

		$fin_engagement = $abo_info->fin_engagement;
		$fin_abonnement = $abo_info->fin_abonnement;
		//si le préavis dépasse la fin d'abonnement on recalcul en fonction des reconductions
		if (strtotime($fin_preavis) >  strtotime($fin_engagement) && $this->reconduction) {
			$qte_jours_eng = $this->reconduction*$qte_jours;
			$qte_mois_eng = $this->reconduction*$qte_mois;

			$jour_suivant = (date("d", strtotime($fin_engagement))+($qte_jours_eng));
			$mois_suivant = (date("m", strtotime($fin_engagement))+($qte_mois_eng));
			if (!checkdate($mois_suivant, $jour_suivant, date("Y", strtotime($fin_engagement)) ) || (date("Y-m-d",  strtotime($fin_engagement)) ==  date("Y-m-d",  mktime(0, 0, 0, date("m", strtotime($fin_engagement))+(1), 0, date("Y", strtotime($fin_engagement)))) )) {	$jour_suivant = 0; $mois_suivant +=1;}

			$fin_abonnement = $fin_engagement = date("Y-m-d H:i:s",  mktime(date("H", strtotime($fin_engagement)), date("i", strtotime($fin_engagement)), date("s", strtotime($fin_engagement)), $mois_suivant, $jour_suivant , date("Y", strtotime($fin_engagement))) );

		} else {
			if (strtotime($fin_preavis) <  strtotime($fin_engagement)) {
				$fin_abonnement = $fin_engagement;
			} else {
				$fin_abonnement = $fin_preavis;
			}
		}

		$query = "UPDATE articles_abonnes
							SET fin_engagement = '".$fin_engagement."' , fin_abonnement = '".$fin_abonnement."' , date_preavis = '".$infos["date_preavis"]."'
							WHERE id_abo = '".$infos["id_abo"]."' ";
		$bdd->exec ($query);
	}
	return true;
}


function calcul_prorata_abonnement ($id_abo, $qte_defaut = 1) {
	global $bdd;
	global $TARIFS_NB_DECIMALES;

	$nb_mois_duree = floor($this->duree/ (30*24*3600));
	$nb_jour_duree = floor(($this->duree - (floor($this->duree/ (30*24*3600)) * (30*24*3600)))/ (24*3600));

	//sinon, on calcul en cas de préavis la quantité à livre
	$query_select = " SELECT id_abo, date_echeance, fin_engagement, fin_abonnement, date_preavis
										FROM articles_abonnes
										WHERE id_abo = '".$id_abo."' ";
	$resultat_select = $bdd->query ($query_select);
	if ($abo_info = $resultat_select->fetchObject()) {

		//si l'abonnement se reconduit automatiquement et qu'aucun préavis n'est déposé, on ne calcul pas de prorata
		if ($this->reconduction && $abo_info->date_preavis == "0000-00-00 00:00:00") { return $qte_defaut;}
		//on calcul la date de renouvellement
		$qte_jours = $qte_defaut*$nb_jour_duree;
		$qte_mois = $qte_defaut*$nb_mois_duree;

		$jour_suivant = date("d", strtotime($abo_info->date_echeance))+($qte_jours);
		$mois_suivant = date("m", strtotime($abo_info->date_echeance))+($qte_mois);
		if (!checkdate($mois_suivant, $jour_suivant, date("Y", strtotime($abo_info->date_echeance)) )) {	$jour_suivant = 0; $mois_suivant +=1;}

		$new_date_echeance = date("Y-m-d H:i:s",  mktime(date("H", strtotime($abo_info->date_echeance)), date("i", strtotime($abo_info->date_echeance)), date("s", strtotime($abo_info->date_echeance)), $mois_suivant, $jour_suivant, date("Y", strtotime($abo_info->date_echeance))) );


		//si la nouvelle echeance dépasse la fin d'echeance, on calcul la qté au prorata des durées
		if (strtotime($new_date_echeance) >  strtotime($abo_info->fin_engagement)) {
			$qte_defaut = number_format((strtotime($abo_info->fin_engagement)-(strtotime($abo_info->fin_engagement)) * $qte_defaut) / (strtotime($new_date_echeance)-strtotime($abo_info->fin_engagement)), $TARIFS_NB_DECIMALES, ".", ""	);
		}

	}
	return $qte_defaut;
}


//fonction de suppression d'une ligne d'abonnement d'un article service par abonnement
function del_ligne_article_abonnement ($ref_doc, $ref_contact, $ref_doc_line) {
	global $bdd;

	//on recherche quelle ligne d'abonnement est concernée
	//afin de supprimer

	$query_select = " SELECT id_abo, date_echeance
										FROM articles_abonnes_livraisons
										WHERE ref_doc = '".$ref_doc."' && ref_doc_line = '".$ref_doc_line."' ";
	$resultat = $bdd->query ($query_select);
	//si l'enregistrement existe toujours
	if ($aal_info = $resultat->fetchObject()) {
		$count_livraisons = 0;
		// si il existe plusieurs livraison
		$query_select0 = " SELECT COUNT(id_abo) nb_livraison
											FROM articles_abonnes_livraisons
											WHERE id_abo = '".$aal_info->id_abo."'  ";
		$resultat_select0 = $bdd->query ($query_select0);
		if ($aal1_info = $resultat_select0->fetchObject()) {$count_livraisons = $aal1_info->nb_livraison;}

		//Si il existe plusieurs livraisons alors on supprime la livraison qui nous concerne
		if ($count_livraisons > 1) {
			//on supprime notre livraison
			$query = "DELETE FROM articles_abonnes_livraisons
								WHERE id_abo = '".$aal_info->id_abo."' &&  ref_doc = '".$ref_doc."' && ref_doc_line = '".$ref_doc_line."'  ";
			$bdd->exec ($query);
			//on récupére la dernière date d'echeance
			$query_select1 = " SELECT date_echeance
												FROM articles_abonnes_livraisons
												WHERE id_abo = '".$aal_info->id_abo."'
												ORDER BY date_echeance DESC
												LIMIT 1";
			$resultat_select1 = $bdd->query ($query_select1);
			if ($aal_date_info = $resultat_select1->fetchObject()) {
				//si la date echeance supprimée est la dernière livrée alors on met à jour
				if (strtotime($aal_info->date_echeance) > strtotime($aal_date_info->date_echeance)) {
					//on met à jour avec la dernier date echeance notre abonnement
					$query = "UPDATE articles_abonnes
										SET date_echeance = '".$aal_date_info->date_echeance."'
										WHERE id_abo = '".$aal_info->id_abo."' ";
					$bdd->exec ($query);
				}
			}
		} else {
			// sinon c'est le dernier livraison alors on supprime tout
			$query = "DELETE FROM articles_abonnes
								WHERE id_abo = '".$aal_info->id_abo."'  ";
			$bdd->exec ($query);
			$query = "DELETE FROM articles_abonnes_livraisons
								WHERE id_abo = '".$aal_info->id_abo."' &&  ref_doc = '".$ref_doc."' && ref_doc_line = '".$ref_doc_line."'  ";
			$bdd->exec ($query);
		}
	}
	return true;
}


//fonction de comptage des abonnemés
function compte_service_abo_nb_abonnes () {
	global $bdd;

	$nb_abonnes = 0;
	$query = " SELECT ref_contact
						FROM articles_abonnes
						WHERE ref_article = '".$this->ref_article."'  && date_echeance > NOW()
						ORDER BY date_echeance DESC
						";
	$resultat = $bdd->query ($query);
	while ($info = $resultat->fetchObject()) {
		 $nb_abonnes ++;
	}
	return $nb_abonnes;

}


//fonction de comptage des abonnements à renouveller
function compte_service_abo_a_renouveller () {
	global $bdd;

	$nb_mois_preavis = floor($this->preavis/ (30*24*3600));
	$nb_jour_preavis = floor(($this->preavis - (floor($this->preavis/ (30*24*3600)) * (30*24*3600)))/ (24*3600));


	$nb_abo_areounv = 0;
	$query = " SELECT aa.id_abo
						FROM articles_abonnes aa
						WHERE ref_article = '".$this->ref_article."' && (aa.fin_abonnement > NOW() || aa.fin_abonnement = '0000-00-00 00:00:00') && aa.date_echeance < NOW()
						ORDER BY aa.date_echeance DESC";
	$resultat = $bdd->query ($query);
	while ($info = $resultat->fetchObject()) {
		 $nb_abo_areounv ++;
	}
	return $nb_abo_areounv;
}

//fonction de comptage des abonnements echu
function compte_service_abo_echu () {
	global $bdd;

	$nb_abo_echu = 0;
	$query = "SELECT aa.id_abo
						FROM articles_abonnes aa
						WHERE  ref_article = '".$this->ref_article."' && aa.fin_abonnement < NOW() && fin_abonnement != '0000-00-00 00:00:00'
						ORDER BY aa.date_echeance DESC";
	$resultat = $bdd->query ($query);
	while ($info = $resultat->fetchObject()) {
		 $nb_abo_echu ++;
	}
	return $nb_abo_echu;
}

//chargement d'un abonnement
function charger_abonnement ($id_abo) {
	global $bdd;

	$query = "SELECT id_abo, aa.ref_contact, ref_article, date_souscription, date_echeance, date_preavis, fin_engagement, fin_abonnement,
						a.nom
						FROM articles_abonnes aa
						LEFT JOIN annuaire a ON a.ref_contact = aa.ref_contact
						WHERE  id_abo = '".$id_abo."'
						";
	$resultat = $bdd->query ($query);
	if ($info = $resultat->fetchObject()) {
		//chargements de la liste des documents liés
		$query_doc = "SELECT id_abo, aal.ref_doc, ref_doc_line, date_renouvellement, date_echeance,

												( SELECT SUM(qte * pu_ht * (1-remise/100) * (1+tva/100))
													FROM docs_lines dl
													WHERE aal.ref_doc = dl.ref_doc && ISNULL(dl.ref_doc_line_parent) && visible = 1 ) as montant
									FROM articles_abonnes_livraisons aal
									WHERE id_abo = '".$info->id_abo."' ";
		$resultat_doc = $bdd->query ($query_doc);
		$info->docs = array();
		while ($info_doc = $resultat_doc->fetchObject()) {$info->docs[] = $info_doc;}

		return $info;
	}
}


// *************************************************************************************************************
// FONCTIONS LIEES AU MODELE D'ARTICLE    SERVICE A LA CONSOMMATION
// *************************************************************************************************************
function create_infos_modele_service_conso ($infos_modele) {
	global $bdd;

	if (isset($infos_modele['duree_validite'])) {$this->duree_validite = $infos_modele['duree_validite'];}
	if (!$this->duree_validite) {
		$this->duree_validite = 0;
	}
	if (isset($infos_modele['nb_credits'])) {$this->nb_credits = $infos_modele['nb_credits'];}
	if (!$this->nb_credits) {
		$this->nb_credits = 1;
	}

	if (!is_numeric($this->duree_validite)) {
		$GLOBALS['_ALERTES']['bad_duree_validite'] = 1;
	}
	// *************************************************
	// Si les valeurs reçues sont incorrectes
	if (count($GLOBALS['_ALERTES'])) {
		return false;
	}

	// *************************************************
	// Insertion des infos dans la base de donnée
	$query = "REPLACE INTO articles_modele_service_conso (ref_article, duree_validite, nb_credits)
						VALUES ('".$this->ref_article."', '".$this->duree_validite."', '".$this->nb_credits."') ";
	$bdd->exec ($query);

	return true;
}


//fonction de création d'une ligne de consommation d'un article Service prepayés
function add_ligne_article_consommation ($ref_contact, $qte = 1) {
	global $bdd;

	$qte_mois = floor(($this->duree_validite)/ (30*24*3600));
	$qte_jours = floor((($this->duree_validite) - (floor(($this->duree_validite)/ (30*24*3600)) * (30*24*3600)))/ (24*3600));


	$query = "SELECT id_compte_credit, ref_article, date_souscription, date_echeance, credits_restants
						FROM articles_comptes_credits acc
						WHERE  ref_contact = '".$ref_contact."' && ref_article = '".$this->ref_article."' ";
	$resultat = $bdd->query ($query);
	if ($conso = $resultat->fetchObject()) {
		//on ajoute les crédits à l'existant
		$date_echeance = date("Y-m-d H:i:s", mktime(date("H", strtotime($conso->date_echeance)), date("i", strtotime($conso->date_echeance)), date("s", strtotime($conso->date_echeance)), date("m", strtotime($conso->date_echeance))+($qte_mois), date("d", strtotime($conso->date_echeance))+($qte_jours), date("Y", strtotime($conso->date_echeance))));
		$query2 = "UPDATE articles_comptes_credits
							SET date_echeance = '".$date_echeance."' , credits_restants = '".($conso->credits_restants+$qte*$this->nb_credits)."'
							WHERE id_compte_credit = '".$conso->id_compte_credit."' ";
		$bdd->exec ($query2);
	} else {
		$date_echeance = date("Y-m-d H:i:s", mktime(date("H"), date("i"), date("s"), date("m")+($qte_mois), date("d")+($qte_jours), date("Y")));
		//il sagit d'une ajout.. on
		// *************************************************
		// Insertion des infos dans la base de donnée
		$query = "INSERT INTO articles_comptes_credits (ref_contact, ref_article, date_souscription, date_echeance, credits_restants)
							VALUES ('".$ref_contact."', '".$this->ref_article."', NOW(), '".$date_echeance."', '".$qte*$this->nb_credits."') ";
		$bdd->exec ($query);
	}
	return true;
}


//Maj des infos d'un article à la conso
function maj_infos_consommation ($infos) {
	global $bdd;

	$query = "UPDATE articles_comptes_credits
						SET date_souscription = '".$infos["date_souscription"]."' ,date_echeance = '".$infos["date_echeance"]."' , credits_restants = '".$infos["credits_restants"]."'
						WHERE id_compte_credit = '".$infos["id_compte_credit"]."' ";
	$bdd->exec ($query);
	return true;
}


//Maj des infos d'un article à la conso
function add_credits_consommation ($infos) {
	global $bdd;

	$query = "INSERT INTO articles_comptes_credits_consos ( id_compte_credit, date_conso, credit_used)
						VALUES ('".$infos["id_compte_credit"]."', NOW(), '".$infos["credit_used"]."' )  ";
	$bdd->exec ($query);
	$query = "UPDATE articles_comptes_credits
						SET  credits_restants = credits_restants-".$infos["credit_used"]."
						WHERE id_compte_credit = '".$infos["id_compte_credit"]."' ";
	$bdd->exec ($query);
	return true;
}

//fonction de suppression d'une ligne de service à la cosommation
function del_ligne_article_consommation ($ref_contact, $qte) {
	global $bdd;

	$qte_mois = floor(($this->duree_validite)/ (30*24*3600));
	$qte_jours = floor((($this->duree_validite) - (floor(($this->duree_validite)/ (30*24*3600)) * (30*24*3600)))/ (24*3600));


	$query = "SELECT id_compte_credit, ref_article, date_souscription, date_echeance, credits_restants
						FROM articles_comptes_credits acc
						WHERE  ref_contact = '".$ref_contact."' && ref_article = '".$this->ref_article."' ";
	$resultat = $bdd->query ($query);
	if ($conso = $resultat->fetchObject()) {
		$date_echeance = date("Y-m-d H:i:s", mktime(date("H", strtotime($conso->date_echeance)), date("i", strtotime($conso->date_echeance)), date("s", strtotime($conso->date_echeance)), date("m", strtotime($conso->date_echeance))-($qte_mois), date("d", strtotime($conso->date_echeance))-($qte_jours), date("Y", strtotime($conso->date_echeance))));
		if (strtotime($date_echeance) > strtotime($conso->date_souscription)) {

			//on supprime les crédits à l'existant
					$query2 = "UPDATE articles_comptes_credits
								SET date_echeance = '".$date_echeance."' , credits_restants = '".($conso->credits_restants-$qte)."'
								WHERE id_compte_credit = '".$conso->id_compte_credit."' ";
			$bdd->exec ($query2);
		} else {
			// on supprime tout
			$query = "DELETE FROM articles_comptes_credits
								WHERE ref_article = '".$this->ref_article."' && ref_contact = '".$ref_contact."'  ";
			$bdd->exec ($query);
		}
	}
	return true;
}

//fonction de comptage des clients en compte
function compte_service_conso_nb_abonnes () {
	global $bdd;

	$nb_abonnes = 0;
	$query = " SELECT DISTINCT ref_contact
						FROM articles_comptes_credits
						WHERE ref_article = '".$this->ref_article."'  && credits_restants > 0  && date_echeance > NOW()
						ORDER BY date_echeance DESC
						";
	$resultat = $bdd->query ($query);
	while ($info = $resultat->fetchObject()) {
		 $nb_abonnes ++;
	}
	return $nb_abonnes;

}


//fonction de comptage des clients en compte expirés
function compte_service_conso_nb_abonnes_expire () {
	global $bdd;

	$nb_abonnes = 0;
	$query = " SELECT DISTINCT ref_contact
						FROM articles_comptes_credits
						WHERE ref_article = '".$this->ref_article."'  && credits_restants > 0  && date_echeance < NOW()
						ORDER BY date_echeance DESC
						";
	$resultat = $bdd->query ($query);
	while ($info = $resultat->fetchObject()) {
		 $nb_abonnes ++;
	}
	return $nb_abonnes;

}

//fonction de comptage des crédits à consommer
function compte_service_conso_a_consommer () {
	global $bdd;

	$nb_credits = 0;
	$query = " SELECT SUM(credits_restants) as credits_restants
						FROM articles_comptes_credits
						WHERE ref_article = '".$this->ref_article."'   && credits_restants > 0 && date_echeance > NOW()
						";
	$resultat = $bdd->query ($query);
	$info = $resultat->fetchObject();
	if ($info->credits_restants) {
		$nb_credits = $info->credits_restants;
	}
	return $nb_credits;
}

//fonction de comptage des crédits consommés
function compte_service_conso_vide () {
	global $bdd;

	$nb_abonnes = 0;
	$query = " SELECT ref_contact
						FROM articles_comptes_credits
						WHERE ref_article = '".$this->ref_article."' && credits_restants <= 0
						";
	$resultat = $bdd->query ($query);
	while ($info = $resultat->fetchObject()) {
		 $nb_abonnes ++;
	}
	return $nb_abonnes;
}

//fonction de comptage des crédits expiré
function compte_service_conso_expire () {
	global $bdd;

	$nb_abonnes = 0;
	$query = " SELECT ref_contact
						FROM articles_comptes_credits
						WHERE ref_article = '".$this->ref_article."' && date_echeance < NOW()
						";
	$resultat = $bdd->query ($query);
	$info = $resultat->fetchObject();
	while ($info = $resultat->fetchObject()) {
		 $nb_abonnes ++;
	}
	return $nb_abonnes;
}

//chargement d'un consommation
function charger_consommation ($id_compte_credit) {
	global $bdd;

	$query = "SELECT id_compte_credit, acc.ref_contact, ref_article, date_souscription, date_echeance, credits_restants,
						a.nom
						FROM articles_comptes_credits acc
						LEFT JOIN annuaire a ON a.ref_contact = acc.ref_contact
						WHERE  id_compte_credit = '".$id_compte_credit."'
						";
	$resultat = $bdd->query ($query);
	if ($info = $resultat->fetchObject()) {
		//chargements de la liste des consommations liées
		$query_doc = "SELECT id_compte_credit, date_conso, credit_used
									FROM articles_comptes_credits_consos accc
									WHERE id_compte_credit = '".$info->id_compte_credit."' ";
		$resultat_doc = $bdd->query ($query_doc);
		$info->consos = array();
		while ($info_conso = $resultat_doc->fetchObject()) {$info->consos[] = $info_conso;}

		return $info;
	}
}

// Création du libellé sur ticket
function make_lib_ticket () {
	$this->lib_ticket = $this->lib_article;
}

// *************************************************************************************************************
// FONCTIONS LIEES A LA DUPLICATION D'UN ARTICLE
// *************************************************************************************************************

//duplication de l'article maitre pour création des esclaves passés en paramètre
final public function generer_variantes ($variantes) {
	global $bdd;
	global $ARTICLE_VARIANTE_NOM;

	$infos_generales = array();
	//récupérer les infos de base de l'article maitre
	if (!$this->stocks_alertes_loaded) { $this->charger_stocks_alertes(); }
	$stocks_alertes = $this->stocks_alertes;
	$infos_generales['modele']	=	$this->modele;
	$infos_modele = array();
	switch ($this->modele) {
	case "materiel":
		$infos_modele['poids']	=	$this->poids;
		$infos_modele['colisage']	=	$this->colisage;
		$infos_modele['duree_garantie']	=	$this->duree_garantie;
		$infos_modele['stocks_alertes']	=	$stocks_alertes;
		break;
	case "service":
		break;
	case "service_abo":
		$infos_modele['duree']	=	$this->duree;
		$infos_modele['engagement']	=	$this->engagement;
		$infos_modele['reconduction']	=	$this->reconduction;
		$infos_modele['preavis']	=	$this->preavis;
		break;
	case "service_conso":
		$infos_modele['duree_validite'] = $this->duree_validite;
		break;
	}


	$infos_generales['ref_art_categ'] 		= $this->ref_art_categ;
	$infos_generales['lib_article'] 			= $this->lib_article;
	$infos_generales['desc_courte'] 			= $this->desc_courte;
	$infos_generales['lib_ticket']				= $this->lib_ticket;
	$infos_generales['desc_longue'] 			= $this->desc_longue;
	$infos_generales['ref_interne'] 			= ''; //la référence interne doit être unique et ne peut donc pas être recopier sur les variantes
	$infos_generales['ref_oem'] 					= $this->ref_oem;
	$infos_generales['ref_constructeur'] 	= $this->ref_constructeur;
	$infos_generales['id_valo'] 					= $this->id_valo;
	$infos_generales['valo_indice'] 			= $this->valo_indice;
	$infos_generales['lot'] 							= $this->lot;
	$infos_generales['gestion_sn'] 				= $this->gestion_sn;
	$infos_generales['id_tva'] 						= $this->id_tva;
	$infos_generales['tva'] 							= $this->tva;
	$infos_generales['variante'] 					= "1";
	$infos_generales['date_debut_dispo'] 	= substr($this->date_debut_dispo, 0, 10);
	$infos_generales['date_fin_dispo'] 		= substr($this->date_fin_dispo, 0, 10);

	$infos_generales['prix_public_ht']		= $this->prix_public_ht;
	$infos_generales['prix_achat_ht']			= $this->prix_achat_ht;
	$infos_generales['paa_ht']						=	$this->paa_ht;



	if (!$this->formules_tarifs_loaded) { $this->charger_formules_tarifs(); }
	$formules_tarifs	= $this->formules_tarifs;


	$liaisons	=	array();
	if (!$this->liaisons_loaded) { $this->charger_liaisons(); }
	foreach ($this->liaisons as $tmp_liaison) {
		if ($tmp_liaison->systeme) {continue;}
		$liais = new stdclass;
		$liais->ref_article	= $tmp_liaison->ref_article_lie;
    $liais->id_type_liaison	= $tmp_liaison->id_liaison_type;
    $liaisons[] = $liais;
	}


	$composants	=	array();
	$this->composants = get_article_composants ($this->ref_article);
	foreach ($this->composants as $tmp_composant) {
		$compo = new stdclass;
		$compo->ref_article	= $tmp_composant->ref_article_composant;
    $compo->qte	= $tmp_composant->qte;
    $compo->niveau	= $tmp_composant->niveau;
    $compo->ordre	= $tmp_composant->ordre;
    $composants[] = $compo;
	}

	if (!$this->images_loaded) { $this->charger_images(); }
	$images =  $this->images;

	$this->charger_caracs();

	foreach ($variantes as $tmp_var) {
		$infos_generales['lib_article'] 			= $this->lib_article;
		$infos_generales['desc_courte'] 			= $this->desc_courte;

		$infos_generales['code_barre'] 				= array();
		if (isset($tmp_var->code_barre)) {
			$infos_generales['code_barre'][] = $tmp_var->code_barre;
		}

		$caracs	=	array();

		foreach($this->caracs as $master_carac) {
			if ($master_carac->variante){continue;}
			$carac = new stdclass;
			$carac->ref_carac	= $master_carac->ref_carac;
			$carac->valeur		= $master_carac->valeur;
			$caracs[] = $carac;
		}

		foreach ($tmp_var->caracs as $key_carac=>$var_carac) {
			$ajout = true;
			for($i = 0; $i < count($caracs); $i++){
				if($caracs[$i]->ref_carac == $key_carac){
					$ajout = false;
					$caracs[$i]->valeur = $var_carac;
				}
			}
			if($ajout){
				$carac = new stdclass;
				$carac->ref_carac	= $key_carac;
				$carac->valeur		= $var_carac;
				$caracs[] = $carac;
			}
			//evolution du nom en fonction du nom des carac
			foreach($this->caracs as $master_carac) {
				if($master_carac->ref_carac == $key_carac){$lib_carac = $master_carac->lib_carac;}
			}
			switch ($ARTICLE_VARIANTE_NOM	) {
				case 1:
					$infos_generales['lib_article']	.=	" ".$var_carac;
					break;
				case 2:
					$infos_generales['lib_article']	.=	", ".$lib_carac." ".$var_carac;
					break;
				case 3:
					$infos_generales['desc_courte']	.=	", ".$lib_carac." ".$var_carac;
					break;
			}
		}

		//création de l'article esclave
		$variante_article = new article ();
		$variante_article->create ($infos_generales, $infos_modele, $caracs, $formules_tarifs, $composants, $liaisons);
		//ajout des images
		foreach ($images as $image){
			$variante_article->add_image ($image->lib_file);
		}
		//création de la liaison type 5 (variantes de cet article)
		$this->add_liaison ($variante_article->getRef_article(), 5);
		//*******************************************
		// EDI EVENT
		edi_event(112,$this->ref_article,$variante_article->getRef_article());
	}
	return true;
}

//duplication de l'article maitre pour création de co article maitre
final public function generer_masters ($maj_ref_carac, $maj_valeur, $update_liaisons, $ref_article_main_master) {
	global $bdd;


	$infos_generales = array();
	//récupérer les infos de base de l'article maitre
	if (!$this->stocks_alertes_loaded) { $this->charger_stocks_alertes(); }
	$stocks_alertes = $this->stocks_alertes;
	$infos_generales['modele']	=	$this->modele;
	$infos_modele = array();
	switch ($this->modele) {
	case "materiel":
		$infos_modele['poids']	=	$this->poids;
		$infos_modele['colisage']	=	$this->colisage;
		$infos_modele['duree_garantie']	=	$this->duree_garantie;
		$infos_modele['stocks_alertes']	=	$stocks_alertes;
		break;
	case "service":
		break;
	case "service_abo":
		$infos_modele['duree']	=	$this->duree;
		$infos_modele['engagement']	=	$this->engagement;
		$infos_modele['reconduction']	=	$this->reconduction;
		$infos_modele['preavis']	=	$this->preavis;
		break;
	case "service_conso":
		$infos_modele['duree_validite'] = $this->duree_validite;
		break;
	}


	$infos_generales['ref_art_categ'] 		= $this->ref_art_categ;
	$infos_generales['lib_article'] 			= $this->lib_article;
	$infos_generales['desc_courte'] 			= $this->desc_courte;
	$infos_generales['lib_ticket']				= $this->lib_ticket;
	$infos_generales['desc_longue'] 			= $this->desc_longue;
	$infos_generales['ref_interne'] 			= $this->ref_interne;
	$infos_generales['ref_oem'] 					= $this->ref_oem;
	$infos_generales['ref_constructeur'] 	= $this->ref_constructeur;
	$infos_generales['id_valo'] 					= $this->id_valo;
	$infos_generales['valo_indice'] 			= $this->valo_indice;
	$infos_generales['lot'] 							= $this->lot;
	$infos_generales['gestion_sn'] 				= $this->gestion_sn;
	$infos_generales['id_tva'] 						= $this->id_tva;
	$infos_generales['tva'] 							= $this->tva;
	$infos_generales['variante'] 					= "2";
	$infos_generales['date_debut_dispo'] 	= substr($this->date_debut_dispo, 0, 10);
	$infos_generales['date_fin_dispo'] 		= substr($this->date_fin_dispo, 0, 10);

	$infos_generales['prix_public_ht']		= $this->prix_public_ht;
	$infos_generales['prix_achat_ht']			= $this->prix_achat_ht;
	$infos_generales['paa_ht']						=	$this->paa_ht;
	$infos_generales['code_barre'] 				= array();


	if (!$this->formules_tarifs_loaded) { $this->charger_formules_tarifs(); }
	$formules_tarifs	= $this->formules_tarifs;

	$liaisons	=	array();
	if (!$this->liaisons_loaded) { $this->charger_liaisons(); }
	foreach ($this->liaisons as $tmp_liaison) {
		if ($tmp_liaison->systeme) {continue;}
		$liais = new stdclass;
		$liais->ref_article	= $tmp_liaison->ref_article_lie;
    $liais->id_type_liaison	= $tmp_liaison->id_liaison_type;
    $liaisons[] = $liais;
	}


	$composants	=	array();
	$this->composants = get_article_composants ($this->ref_article);
	foreach ($this->composants as $tmp_composant) {
		$compo = new stdclass;
		$compo->ref_article	= $tmp_composant->ref_article_composant;
    $compo->qte	= $tmp_composant->qte;
    $compo->niveau	= $tmp_composant->niveau;
    $compo->ordre	= $tmp_composant->ordre;
    $composants[] = $compo;
	}

	if (!$this->images_loaded) { $this->charger_images(); }
	$images =  $this->images;

	if (!$this->caracs_loaded) { $this->charger_caracs(); }

	$caracs	=	array();

	foreach($this->caracs as $master_carac) {
		$carac = new stdclass;
		$carac->ref_carac	= $master_carac->ref_carac;
		$carac->valeur		= $master_carac->valeur;
		$caracs[] = $carac;
	}

	//création de l'article maitre
	$master_article = new article ();
	$master_article->create ($infos_generales, $infos_modele, $caracs, $formules_tarifs, $composants, $liaisons);
	//ajout des images
	foreach ($images as $image){

		$master_article->add_image ($image->lib_file);
	}

	$master_article->maj_carac ($maj_ref_carac, $maj_valeur);

	//mise à jour des liaisons systeme
	if (count($update_liaisons)) {
		$list_to_update = "''";
		foreach ($update_liaisons as $ref_art) {
			if ($list_to_update){$list_to_update .= ",";}
			$list_to_update .= "'".$ref_art->ref_article_lie."'";
		}
		$query = "UPDATE articles_liaisons SET ref_article = '".$master_article->getRef_article()."'
							WHERE ref_article = '".$ref_article_main_master."' && ref_article_lie IN (".$list_to_update.") && id_liaison_type = '5'";
		$bdd->exec ($query);
	}

	return true;
}
//gestion des articles maitres en cas de suppression ou de passage en variante =0 d'une caractéristique de l'art_categ
//cette fonction est lancée depuis l'art_categ si des carac variantes existent encore.
final public function gestion_master ($ref_carac) {
	global $bdd;

	//chargement des différentes valeurs
	$query = "SELECT ac.ref_carac, ac.valeur
						FROM articles_caracs ac
						WHERE ac.ref_article = '".$this->ref_article."' && ac.ref_carac = '".$ref_carac."'
						";
	$resultat = $bdd->query ($query);
	if (!$carac_del = $resultat->fetchObject()) {return false;}

	$tmp_carac_lib = explode(";", $carac_del->valeur);

	if (count($tmp_carac_lib) < 1 ) { return true;}

	$variantes_toupdate = array();
	foreach ($tmp_carac_lib as $carac_lib) {
		$variantes_toupdate[$carac_lib] = array();
	}

	//répartition des différentes variantes en fonctions des valeurs de la carac modifiée
	$this->find_my_slaves ();
	foreach ($this->variante_slaves as $variante_slave) {
		foreach ($variante_slave->caracs as $carac_key_slave=>$carac_value_slave) {
			if ($ref_carac == $carac_key_slave) {$variantes_toupdate[$carac_value_slave][] = $variante_slave; break;}
		}
	}
	//print_r($this->variante_slaves);
	//print_r($variantes_toupdate); return true;
	//mise à jour et création des  maitres
	$pass_first = 0;
	foreach ($variantes_toupdate as $key_up=>$var_update) {
		print_r($var_update);
		// on passe le premier qui gardera le maitre d'origine
		if (!$pass_first) {$pass_first = 1; $this->maj_carac ($ref_carac, $key_up);continue;}
		//on généres les co-maitres
		$this->generer_masters($ref_carac, $key_up, $var_update, $this->ref_article);
	}
 return true;
}

//recherche du maitre de l'article variante
final public function find_my_master () {
	global $bdd;
	//l'id de la liaison de type variante est 5
	$query = "SELECT al.ref_article, al.ref_article_lie, al.id_liaison_type, a.lib_article, alt.lib_liaison_type, alt.systeme
						FROM articles_liaisons al
							LEFT JOIN articles a ON a.ref_article = al.ref_article_lie
							LEFT JOIN art_liaisons_types alt ON alt.id_liaison_type = al.id_liaison_type
						WHERE al.ref_article_lie = '".$this->ref_article."' && alt.id_liaison_type = 5  && alt.systeme = 1
						LIMIT 0,1";
	$resultat = $bdd->query($query);
	if ($tmp = $resultat->fetchObject()) { $this->variante_master = $tmp->ref_article; }


}

public function find_my_slaves () {
	global $bdd;

	$this->variante_slaves = array();

	$query = "SELECT al.ref_article_lie, al.id_liaison_type, a.lib_article, alt.lib_liaison_type, alt.systeme,
										a.dispo
						FROM articles_liaisons al
							LEFT JOIN articles a ON a.ref_article = al.ref_article_lie
							LEFT JOIN articles_caracs ac ON ac.ref_article = al.ref_article_lie
							LEFT JOIN art_liaisons_types alt ON alt.id_liaison_type = al.id_liaison_type

						WHERE al.ref_article = '".$this->ref_article."' && alt.id_liaison_type = 5  && alt.systeme = 1
						ORDER BY alt.ordre, a.lib_article ";
	$resultat = $bdd->query($query);
	while ($tmp = $resultat->fetchObject()) {
		$tmp->caracs = array();

		$query_carac = "SELECT ac.ref_carac,  ac.valeur
							FROM articles_caracs ac
							LEFT JOIN art_categs_caracs acc ON acc.ref_carac = ac.ref_carac
							WHERE ac.ref_article = '".$tmp->ref_article_lie."'  && acc.variante = '1'
							";
		$resultat_carac = $bdd->query ($query_carac);
		while ($var_carac = $resultat_carac->fetchObject()) { $tmp->caracs[$var_carac->ref_carac] = $var_carac->valeur; }
		$this->variante_slaves[] = $tmp;
	}

	return true;
}
// *************************************************************************************************************
// FONCTIONS LIEES A LA MODIFICATION D'UN ARTICLE
// *************************************************************************************************************

final public function modification1 ($infos_generales) {
	global $CONFIG_DIR;
	global $bdd;


	// *************************************************
	// Controle des données transmises
	$this->ref_oem 			= $infos_generales['ref_oem'];
	$this->ref_interne 	= $infos_generales['ref_interne'];
	if ($this->ref_interne) {
		// Doit etre unique
		$query = "SELECT ref_article FROM articles
							WHERE ref_interne = '".addslashes($this->ref_interne)."' && ref_article != '".$this->ref_article."' ";
		$resultat = $bdd->query ($query);
		if ($resultat->fetchObject()) {
			$GLOBALS['_ALERTES']['ref_interne_exist'] = 1;
		}
	}
	$this->lib_article 	= trim($infos_generales['lib_article']);
	if (!$this->lib_article) {
		$GLOBALS['_ALERTES']['lib_article_vide'] = 1;
	}
	$this->lib_ticket 	= trim($infos_generales['lib_ticket']);
	if (!$this->lib_ticket) { $this->make_lib_ticket(); }

	$this->desc_courte 	= trim($infos_generales['desc_courte']);
	$this->desc_longue 	= $infos_generales['desc_longue'];

	$this->ref_constructeur = $infos_generales['ref_constructeur'];


	// *************************************************
	// Si les valeurs reçues sont incorrectes
	if (count($GLOBALS['_ALERTES'])) {
		return false;
	}

	// *************************************************
	// Modification dans la base
	$query = "UPDATE articles
						SET ref_oem = '".addslashes($this->ref_oem)."', ref_interne = ".text_or_null(addslashes($this->ref_interne)).",
								lib_article = '".addslashes($this->lib_article)."', lib_ticket = '".addslashes($this->lib_ticket)."',
								desc_courte = '".addslashes($this->desc_courte)."', desc_longue = '".addslashes($this->desc_longue)."',
						 		ref_constructeur = ".ref_or_null($this->ref_constructeur).", date_modification = NOW()
						WHERE ref_article = '".$this->ref_article."' ";
	$bdd->exec ($query);


	// *************************************************
	// Résultat positif de la modification
	$GLOBALS['_INFOS']['Modification_article'] = 1;

    //**********************************************
	// Envoi EDI
	edi_event(115,$this->ref_article);
}

final public function modification2 ($infos_generales, $infos_modele) {
	global $CONFIG_DIR;
	global $bdd;

	global $DEFAUT_ID_VALO;
	global $DEFAUT_VALO_INDICE;

	// *************************************************
	// Controle des données transmises
	$this->id_valo = $infos_generales['id_valo'];
	if (!$this->id_valo) {
		$this->id_valo = $DEFAUT_ID_VALO;
	}
	$this->valo_indice = $infos_generales['valo_indice'];
	if (!is_numeric($this->valo_indice)) {
		$this->valo_indice = $DEFAUT_VALO_INDICE;
	}
	$this->gestion_sn	= $infos_generales['gestion_sn'];
	if ($this->gestion_sn != 0 && $this->gestion_sn != 1 && $this->gestion_sn != 2) {
		$this->gestion_sn = 0;
	}
	$this->lot	= $infos_generales['lot'];

	$this->date_debut_dispo	= $infos_generales['date_debut_dispo'];
	$this->date_fin_dispo		= $infos_generales['date_fin_dispo'];
	$this->check_dispo ();

	$this->modele = $infos_generales['modele'];


	// *************************************************
	// Si les valeurs reçues sont incorrectes
	if (count($GLOBALS['_ALERTES'])) {
		return false;
	}

	// *************************************************
	// Modification dans la base
	$bdd->beginTransaction();

	$query = "UPDATE articles
						SET id_valo = '".$this->id_valo."', valo_indice = '".$this->valo_indice."',
								gestion_sn = '".$this->gestion_sn."', lot = '".$this->lot."',
								date_debut_dispo = '".$this->date_debut_dispo."', date_fin_dispo = '".$this->date_fin_dispo."',
						 		dispo = '".$this->dispo."', date_modification = NOW()
						WHERE ref_article = '".$this->ref_article."' ";
	$bdd->exec ($query);

	// Infos du modele
	$fonction = "create_infos_modele_".$this->modele;
	$this->{$fonction}($infos_modele);

	$bdd->commit();

	// *************************************************
	// Résultat positif de la modification
	$GLOBALS['_INFOS']['Modification_article'] = 1;
}


final public function modification_view_0 ($infos_generales) {
	global $CONFIG_DIR;
	global $bdd;

	global $DEFAUT_ID_VALO;
	global $DEFAUT_VALO_INDICE;


	// *************************************************
	// Controle des données transmises
	$this->lib_article 	= trim($infos_generales['lib_article']);
	if (!$this->lib_article) {
		$GLOBALS['_ALERTES']['lib_article_vide'] = 1;
	}
	$this->lib_ticket 	= trim($infos_generales['lib_ticket']);
	if (!$this->lib_ticket) { $this->make_lib_ticket(); }

	$this->id_valo = $infos_generales['id_valo'];
	if (!$this->id_valo) {
		$this->id_valo = $DEFAUT_ID_VALO;
	}
	$this->valo_indice = $infos_generales['valo_indice'];
	if (!is_numeric($this->valo_indice)) {
		$this->valo_indice = $DEFAUT_VALO_INDICE;
	}
	$this->gestion_sn	= $infos_generales['gestion_sn'];
	if ($this->gestion_sn != 0 && $this->gestion_sn != 1 && $this->gestion_sn != 2) {
		$this->gestion_sn = 0;
	}
	$this->lot	= $infos_generales['lot'];

	$this->date_debut_dispo	= $infos_generales['date_debut_dispo'];
	$this->date_fin_dispo		= $infos_generales['date_fin_dispo'];
	$this->check_dispo ();

	// *************************************************
	// Si les valeurs reçues sont incorrectes
	if (count($GLOBALS['_ALERTES'])) {
		return false;
	}

	// *************************************************
	// Modification dans la base
	$query = "UPDATE articles
						SET lib_article = '".addslashes($this->lib_article)."', lib_ticket = '".addslashes($this->lib_ticket)."',
								id_valo = '".$this->id_valo."', valo_indice = '".$this->valo_indice."',
								gestion_sn = '".$this->gestion_sn."', lot = '".$this->lot."',
								date_debut_dispo = '".$this->date_debut_dispo."', date_fin_dispo = '".$this->date_fin_dispo."',
						 		dispo = '".$this->dispo."', date_modification = NOW()
						WHERE ref_article = '".$this->ref_article."' ";
	$bdd->exec ($query);


	// *************************************************
	// Résultat positif de la modification
	$GLOBALS['_INFOS']['Modification_article'] = 1;
	
	//**********************************************
	// Envoi EDI
	if($this->variante != 1){
		edi_event(115,$this->ref_article);
	}
	
}

final public function modification_view_1 ($infos_generales) {
	global $CONFIG_DIR;
	global $bdd;


	// *************************************************
	// Controle des données transmises
	$this->ref_oem 			= $infos_generales['ref_oem'];
	$this->ref_interne 	= $infos_generales['ref_interne'];
	if ($this->ref_interne) {
		// Doit etre unique
		$query = "SELECT ref_article FROM articles
							WHERE ref_interne = '".addslashes($this->ref_interne)."' && ref_article != '".$this->ref_article."' ";
		$resultat = $bdd->query ($query);
		if ($resultat->fetchObject()) {
			$GLOBALS['_ALERTES']['ref_interne_exist'] = 1;
		}
	}

	$this->desc_courte 	= trim($infos_generales['desc_courte']);

	$this->ref_constructeur = $infos_generales['ref_constructeur'];


	// *************************************************
	// Si les valeurs reçues sont incorrectes
	if (count($GLOBALS['_ALERTES'])) {
		return false;
	}

	// *************************************************
	// Modification dans la base
	$query = "UPDATE articles
						SET ref_oem = '".addslashes($this->ref_oem)."', ref_interne = ".text_or_null(addslashes($this->ref_interne)).",
								desc_courte = '".addslashes($this->desc_courte)."',
						 		ref_constructeur = ".ref_or_null($this->ref_constructeur).", date_modification = NOW()
						WHERE ref_article = '".$this->ref_article."' ";
	$bdd->exec ($query);

	if (isset($infos_generales['tags'])) { $this->maj_mots_clefs($infos_generales['tags'] );}
	// *************************************************
	// Résultat positif de la modification
	$GLOBALS['_INFOS']['Modification_article'] = 1;
	
	//**********************************************
	// Envoi EDI
	edi_event(115,$this->ref_article);
}

final public function maj_mots_clefs ($mots_clefs) {
	global $bdd;

	$this->tags = explode(";", $mots_clefs);

	$query_del = "DELETE FROM articles_mots_cles WHERE ref_article = '".$this->ref_article."'";
	$bdd->exec($query_del);

	if (is_array($this->tags) && count($this->tags) > 0) {
	  $query = "INSERT INTO articles_mots_cles (ref_article, mot_cle) VALUES";
	  foreach ($this->tags as $tag) {
	    $query .= " ('".$this->ref_article."', '".$tag."'),";
    }
	  $query = substr($query, 0, -1).";";
	  $bdd->exec($query);
	}
}


//modification  du modèle
final public function modification_view_2 ($infos_generales, $infos_modele) {
	global $CONFIG_DIR;
	global $bdd;


	// *************************************************
	// Modification dans la base
	$bdd->beginTransaction();

	$query = "UPDATE articles
						SET date_modification = NOW()
						WHERE ref_article = '".$this->ref_article."' ";
	$bdd->exec ($query);

	// Infos du modele
	$fonction = "create_infos_modele_".$this->modele;
	$this->{$fonction}($infos_modele);

	$bdd->commit();

	// *************************************************
	// Résultat positif de la modification
	$GLOBALS['_INFOS']['Modification_article'] = 1;
}

//
final function getValeursCaracs($indice_carac, $carac_sel, $valeur_sel){
	global $bdd;
	$query = "SELECT ac.ref_carac
				FROM articles_caracs ac
				WHERE ac.ref_article = '" . $this->ref_article . "'
				ORDER BY ac.ref_carac ASC
				LIMIT " . $indice_carac . ",1;";
	$resultat = $bdd->query($query);
	if(!$tmp = $resultat->fetchObject()){
		return false;
	}
	
	$query = "SELECT ac.valeur
				FROM articles_caracs ac
					JOIN articles_liaisons al ON al.ref_article_lie = ac.ref_article 
					JOIN stocks_articles sa ON sa.ref_article = ac.ref_article
					JOIN art_categs_caracs acc ON acc.ref_carac = ac.ref_carac
				WHERE al.ref_article = '" . $this->ref_article . "' 
				AND ac.ref_carac = '" . $tmp->ref_carac . "' 
				AND (SELECT COUNT(ref_article) FROM articles_caracs ac2 
						WHERE ac.ref_article = ac2.ref_article 
						AND ac2.ref_carac = '" . $carac_sel . "' 
						AND ac2.valeur = '" . $valeur_sel . "') > 0
				GROUP BY sa.ref_article
				ORDER BY ac.ref_carac ASC, ac.valeur ASC;";
	$resultat = $bdd->query($query);
	$valeurs = array();
	while($tmp = $resultat->fetchObject()){
		$valeurs[] = $tmp->valeur;
	}
	return $valeurs;
}

// Fonction qui va rechercher les articles fils avec les différentes variantes et le stock associé
final function findVariantesStock($annonce_ruptures = false){
	global $bdd;
	$query = "SELECT ac.ref_article, ac.ref_carac, ac.valeur, sa.qte, sa.id_stock, acc.lib_carac 
				FROM articles_caracs ac
					JOIN articles_liaisons al ON al.ref_article_lie = ac.ref_article 
					JOIN stocks_articles sa ON sa.ref_article = ac.ref_article
					JOIN art_categs_caracs acc ON acc.ref_carac = ac.ref_carac
				WHERE al.ref_article = '" . $this->ref_article . "' 
				AND acc.variante = '1' 
				ORDER BY ac.ref_carac ASC, ac.valeur ASC;";
	/*$query1 = "SELECT ac.ref_carac, acc.lib_carac, acc.unite, a.ref_art_categ
				FROM articles a
					JOIN articles_caracs ac ON a.ref_article = ac.ref_article
					JOIN art_categs_caracs acc ON acc.ref_carac = ac.ref_carac
				WHERE a.ref_article = '" . $this->ref_article . "' 
				AND acc.variante = '1'
				ORDER BY acc.ordre;";
	$query = "SELECT ref_article_variante
				FROM articles_variantes av
				WHERE ref_article_modele = '" . $this->ref_article . "'";*/
	$resultat = $bdd->query($query);
	$retour = array();
	while($tmp = $resultat->fetchObject()){
		$retour[] = $tmp;
	}
	if($annonce_ruptures){
                $caracs = array();
                //1er parcours pour récupérer les caractéristiques
                foreach($retour as $art){
                        if(!in_array($art->ref_carac, $caracs)){
                                $caracs[$art->ref_carac] = $art->lib_carac;
                        }
                }
                $arbre = $this->construct_arbre_caracs_stocks();
		//print_r($arbre);
	}
	return $retour;
}

function construct_arbre_caracs_stock($id_stock){
    global $bdd;
    $arbre = array();

    $caracs = $this->getCaracs_variantes();
    //print_r($caracs);
    
    $select = array();
    $join = array();
    $order = array();
    for($i=0; $i<count($caracs); $i++){
        $order[] = "valeur_carac".$i;
        $select[] = "ac".$i.".valeur AS valeur_carac".$i;
        $join[] = "LEFT JOIN articles_caracs ac".$i." ON ac".$i.".ref_article = al.ref_article_lie && ac".$i.".ref_carac = '".$caracs[$i]->ref_carac."'";
    }
    $query = "SELECT al.ref_article_lie, sa.qte, ".implode(", ", $select)."
               FROM articles_liaisons al
               ".implode(" \n", $join)."
               LEFT JOIN stocks_articles sa ON al.ref_article_lie = sa.ref_article AND id_stock = '".$id_stock."'
               WHERE al.ref_article = '" . $this->ref_article . "'
               AND al.id_liaison_type = 5
               ORDER BY ".implode(", ", $order); 

    //print_r($query);
    $resultat = $bdd->query($query);
    $articles = array();
    while($tmp = $resultat->fetchObject()){
            $articles[] = $tmp;
    }
    foreach($articles as $art){
        /* @todo faire le cas général for(...) */
        $var = '$arbre';
        for($i=0; $i<count($caracs); $i++){
            $var .= '[$art->valeur_carac'.$i.']';
        }
        eval($var."['qte'] = \$art->qte;");
        eval($var."['ref'] = \$art->ref_article_lie;");
    }
    //print_r($articles);
    return $arbre;
}


// Fonction permettant de changer la catégorie d'article
function maj_categorie ($new_ref_categ, $infos_modele) {
	global $bdd;
	global $BDD_MODELES;
	global $MAJ_PV;

	// ********************************
	// Controle des données recues
	if (!isset($infos_modele['modele'], $BDD_MODELES)) {
		$GLOBALS['_ALERTES']['bad_modele'] = 1;
		exit();
	}

	$bdd->beginTransaction();

	// Suppression des caractéristiques
	$query = "DELETE FROM articles_caracs WHERE ref_article = '".$this->ref_article."' ";
	$bdd->exec ($query);

	// Suppression des informations de modèle
	$query = "DELETE FROM articles_modele_".$this->modele." WHERE ref_article = '".$this->ref_article."' ";
	$bdd->exec ($query);

	// Mise à jour de l'article
	$query = "UPDATE articles a
						SET a.ref_art_categ = '".$new_ref_categ."', a.modele = '".$infos_modele['modele']."', a.date_modification = NOW()
						WHERE a.ref_article = '".$this->ref_article."'  ";
	$bdd->exec ($query);

	// Infos du modele
	$fonction = "create_infos_modele_".$infos_modele['modele'];
	$this->{$fonction}($infos_modele);
        edi_event(117, "force", $this->ref_article);

	if (count($GLOBALS['_ALERTES'])) {
		return false;
	}
	// Mise à jour des tarifs
	$this->maj_all_tarifs ();

	$bdd->commit();
}


//mise à jour de l'article en id_modele_spe
public function maj_article_modele_spe ($id_modele_spe) {
	//@FIXME utilisation de modele spe
	global $bdd;

	// *************************************************
	// Controle des données transmises
	if ($id_modele_spe == $this->id_modele_spe ) {
		return false;
	}
	$this->id_modele_spe		= $id_modele_spe;

	if (!is_numeric($this->id_modele_spe) ) {
		return false;
	}

	// *************************************************
	// Mise a jour de la base
	$query = "UPDATE articles
						SET id_modele_spe = ".$this->id_modele_spe."
						WHERE ref_article = '".$this->ref_article."' ";
	$bdd->exec ($query);

	return true;
}


//mise à jour des informations pour un article spécifique
final public function maj_art_spe($infos_generales) {
	global $bdd;

	$this->lib_article = $infos_generales["lib_article"];
	$this->lib_ticket = $infos_generales["lib_ticket"];
	$this->ref_constructeur = $infos_generales["ref_constructeur"];
	// ********************
	// Modification dans la base
	$query = "UPDATE articles
						SET	lib_article = '".addslashes($this->lib_article)."',	lib_ticket = '".addslashes($this->lib_ticket)."',	ref_constructeur = ".ref_or_null($this->ref_constructeur).", date_modification = NOW()
						WHERE ref_article = '".$this->ref_article."' ";
	$bdd->exec ($query);

}


//mise à jour de la description longue de l'article
final public function maj_description_longue ($desc_longue) {
	global $bdd;

	$this->desc_longue = $desc_longue;
	// ********************
	// Modification dans la base
	$query = "UPDATE articles
						SET	desc_longue = '".addslashes($this->desc_longue)."', date_modification = NOW()
						WHERE ref_article = '".$this->ref_article."' ";
	$bdd->exec ($query);

	//**********************************************
	// Envoi EDI
	if($this->variante != 1){
		edi_event(115,$this->ref_article);
	}
}



// Mise à jour du taux de tva
function maj_tva ($id_tva) {
	global $bdd;
	global $MAJ_PV;


	// Si aucun changement, inutile d'aller plus loin
	if ($this->id_tva == $id_tva) { return false; }

	$this->id_tva = convert_numeric($id_tva);


	// *************************************************
	// Si les valeurs reçues sont incorrectes
	if (count($GLOBALS['_ALERTES'])) {
		return false;
	}

	// *************************************************
	// Modification dans la base
	$query = "UPDATE articles
						SET id_tva = ".num_or_null($this->id_tva).",
								date_modification = NOW()
						WHERE ref_article = '".$this->ref_article."' ";
	$bdd->exec ($query);

	// *************************************************
	// Mise à jour des prix de vente pour cet article
	if ($MAJ_PV == "2") {	$this->maj_all_tarifs ();}

	// *************************************************
	// Résultat positif de la modification
	$GLOBALS['_INFOS']['Modification_tva'] = 1;
}
// Mise à jour de promo
function maj_promo ($promo) {
	global $bdd;

	// Si aucun changement, inutile d'aller plus loin
	if ($this->promo == $promo) { return false; }
	
	$this->promo = $promo;


	// *************************************************
	// Si les valeurs reçues sont incorrectes
	if (count($GLOBALS['_ALERTES'])) {
		return false;
	}

	// *************************************************
	// Modification dans la base
	$query = "UPDATE articles
						SET promo = ".$this->promo.",
								date_modification = NOW()
						WHERE ref_article = '".$this->ref_article."' ";
	$bdd->exec ($query);

	// *************************************************
	// Résultat positif de la modification
	$GLOBALS['_INFOS']['Modification_promo'] = 1;
}


// Mise à jour du prix d'achat et / ou public
function maj_prix ($prix) {
	global $bdd;
	global $MAJ_PV;

	$old_pp = $this->prix_public_ht;
	$new_pp = convert_numeric($prix['prix_public_ht']);
	if (is_numeric($new_pp)) {
		$this->prix_public_ht = $new_pp;
	}
	$old_pa = $this->prix_achat_ht;
	$new_pa = convert_numeric($prix['prix_achat_ht']);
	if (is_numeric($new_pa)) {
		$this->prix_achat_ht = $new_pa;
	}
	$this->id_tva = convert_numeric($prix['id_tva']);

	// *************************************************
	// Si les valeurs reçues sont incorrectes
	if (count($GLOBALS['_ALERTES'])) {
		return false;
	}

	// Si aucun changement, inutile d'aller plus loin
	//if (($new_pa == $old_pa) && ($new_pp == $old_pp)) { return false; }

	//archivage du pa
	if ($new_pa != $old_pa) {
		$this->pa_archive ($new_pa);
	}

	// *************************************************
	// Modification dans la base
	$query = "UPDATE articles
						SET prix_public_ht = ".num_or_null($this->prix_public_ht).",
								prix_achat_ht = ".num_or_null($this->prix_achat_ht).",
								id_tva = ".num_or_null($this->id_tva).",
								date_modification = NOW()
						WHERE ref_article = '".$this->ref_article."' ";
	$bdd->exec ($query);

	// *************************************************
	// Mise à jour des prix de vente pour cet article
	if ($MAJ_PV == "2") {	$this->maj_all_tarifs ();}

	// on vas tester si notre article en compose un autre pour mettre à jour les prix de cet article
	$this->chek_my_lot();

	// *************************************************
	// Résultat positif de la modification
	$GLOBALS['_INFOS']['Modification_prix'] = 1;
	
	//**********************************************
	// Envoi EDI
	edi_event(115,$this->ref_article);
}


// Mise à jour du prix public
function maj_prix_public_ht ($prix_public_ht) {
	global $bdd;
	global $MAJ_PV;

	$old_pp = $this->prix_public_ht;
	$new_pp = convert_numeric($prix_public_ht);
	if (is_numeric($new_pp)) {
		$this->prix_public_ht = $new_pp;
	}

	// *************************************************
	// Si les valeurs reçues sont incorrectes
	if (count($GLOBALS['_ALERTES'])) {
		return false;
	}

	// Si aucun changement, inutile d'aller plus loin
	if ($new_pp == $old_pp) { return false; }

	// *************************************************
	// Modification dans la base
	$query = "UPDATE articles
						SET prix_public_ht = ".num_or_null($this->prix_public_ht).",
								date_modification = NOW()
						WHERE ref_article = '".$this->ref_article."' ";
	$bdd->exec ($query);

	// *************************************************
	// Mise à jour des prix de vente pour cet article
	if ($MAJ_PV == "2") {	$this->maj_all_tarifs ();}

	// *************************************************
	// Résultat positif de la modification
	$GLOBALS['_INFOS']['Modification_prix_public_ht'] = 1;
	
	//**********************************************
	// Envoi EDI
	edi_event(115,$this->ref_article);
}


// Mise à jour du prix d'achat
function maj_prix_achat_ht ($prix_achat_ht, $qte_recu = "") {
	global $bdd;
	global $MAJ_PV;
	global $CALCUL_VAS;

	$old_pa = $this->prix_achat_ht;
	$new_pa = convert_numeric($prix_achat_ht);
	if (!is_numeric($new_pa)) {return false;}

	switch ($CALCUL_VAS) {
		case "1":
			if ($qte_recu){
				if (!$this->stocks_loaded) {$this->charger_stocks ();}
				$sum_stock = 0;
				foreach ($_SESSION["stocks"] as $id_stock=>$stock_obj) {
					if (isset($this->stocks[$id_stock]->qte)) {$sum_stock += $this->stocks[$id_stock]->qte;}
				}
				if ($sum_stock > 0 && ($sum_stock + $qte_recu) > 0 ) {
					$this->prix_achat_ht = ($sum_stock * $old_pa + $qte_recu * $new_pa)/($sum_stock + $qte_recu);
				} else {
					$this->prix_achat_ht = $new_pa;
				}
			} else {
				$this->prix_achat_ht = $new_pa;
			}
		break;
		case "2":
			$this->prix_achat_ht = $new_pa;
		break;
		case "3":
			$this->prix_achat_ht = $new_pa;
		break;
	}
	// *************************************************
	// Si les valeurs reçues sont incorrectes
	if (count($GLOBALS['_ALERTES'])) {
		return false;
	}

	// Si aucun changement, inutile d'aller plus loin
	if ($new_pa == $old_pa) { return false; }

	//archivage du pa
	$this->pa_archive ($new_pa);
	// *************************************************
	// Modification dans la base
	$query = "UPDATE articles
						SET prix_achat_ht = ".num_or_null($this->prix_achat_ht).",
								date_modification = NOW()
						WHERE ref_article = '".$this->ref_article."' ";
	$bdd->exec ($query);

	// *************************************************
	// Mise à jour des prix de vente pour cet article
	if ($MAJ_PV == "2") {	$this->maj_all_tarifs ();}

	// on vas tester si notre article en compose un autre pour mettre à jour les prix de cet article
	$this->chek_my_lot();
	// *************************************************
	// Résultat positif de la modification
	$GLOBALS['_INFOS']['Modification_prix_achat_ht'] = 1;

	return true;
}



// Annule la Mise à jour du prix d'achat pour un PMP
function annule_maj_prix_achat_ht ($prix_achat_ht, $qte_recu = "") {
	global $bdd;
	global $MAJ_PV;
	global $CALCUL_VAS;

	$old_pa = $this->prix_achat_ht;
	$new_pa = convert_numeric($prix_achat_ht);
	if (!is_numeric($new_pa)) {return false;}

	switch ($CALCUL_VAS) {
		case "1":
			if ($qte_recu){
				if (!$this->stocks_loaded) {$this->charger_stocks ();}
				$sum_stock = 0;
				foreach ($_SESSION["stocks"] as $id_stock=>$stock_obj) {
					if (isset($this->stocks[$id_stock]->qte)) {$sum_stock += $this->stocks[$id_stock]->qte;}
				}
				if ($sum_stock > 0 && ($sum_stock - $qte_recu) != 0 ) {
					$this->prix_achat_ht = ($old_pa * $sum_stock - $qte_recu * $new_pa)/($sum_stock - $qte_recu) ;
				} else {
					$this->prix_achat_ht = 0;
				}
			} else {
				return false;
			}
		break;
		case "2":
			return false;
		break;
		case "3":
			return false;
		break;
	}
	// *************************************************
	// Si les valeurs reçues sont incorrectes
	if (count($GLOBALS['_ALERTES'])) {
		return false;
	}

	// Si aucun changement, inutile d'aller plus loin
	if ($new_pa == $old_pa) { return false; }

	//archivage du pa
	$this->pa_archive ($new_pa);
	// *************************************************
	// Modification dans la base
	$query = "UPDATE articles
						SET prix_achat_ht = ".num_or_null($this->prix_achat_ht).",
								date_modification = NOW()
						WHERE ref_article = '".$this->ref_article."' ";
	$bdd->exec ($query);

	// *************************************************
	// Mise à jour des prix de vente pour cet article
	if ($MAJ_PV == "2") {	$this->maj_all_tarifs ();}

	// on vas tester si notre article en compose un autre pour mettre à jour les prix de cet article
	$this->chek_my_lot();

	// *************************************************
	// Résultat positif de la modification
	$GLOBALS['_INFOS']['Modification_prix_achat_ht'] = 1;

	return true;
}


// Mise à jour du prix d'achat actuel
function maj_prix_achat_actuel_ht ($paa_ht = "") {
	global $bdd;
	global $CALCUL_VAA;
	global $DUREE_VALIDITE_PAF;
	global $CALCUL_VAS;
	global $MAJ_PV;


	$old_paa = $this->paa_ht;
	$add_query = ", paa_last_maj = NOW()";
	// si pas de paa transmis on le défini par les régles de VAA
	if (!$paa_ht) {
		$add_query = "";

		$date_paa_query = " && date_pa > '".$this->paa_last_maj."' ";
		//si la dernier maj paa ne permet pas de récupérer un tarif fournisseur valide
		if ($this->paa_last_maj > date("Y-m-d", mktime(0,0,0,  date("m"),date("d")-$DUREE_VALIDITE_PAF, date("Y")))) {
			$query = "SELECT pa_unitaire FROM articles_ref_fournisseur WHERE ref_article = '".$this->ref_article."' && date_pa > '".date("Y-m-d", mktime(0,0,0,  date("m"),date("d")-$DUREE_VALIDITE_PAF, date("Y")))."' && pa_unitaire != 0 ";
			$resultat = $bdd->query ($query);
			if ($tmp = $resultat->fetchObject()) { $date_paa_query = "";}
		}

		switch  ($CALCUL_VAA) {
			case "1":
				$query = "SELECT MIN(pa_unitaire) as paf FROM articles_ref_fournisseur WHERE ref_article = '".$this->ref_article."'  ".$date_paa_query." &&  date_pa > '".date("Y-m-d", mktime(0,0,0,  date("m"),date("d")-$DUREE_VALIDITE_PAF, date("Y")))."' && pa_unitaire != 0 ";
			break;
			case "2":
				$query = "SELECT AVG(pa_unitaire) as paf FROM articles_ref_fournisseur WHERE ref_article = '".$this->ref_article."'   ".$date_paa_query." &&  date_pa > '".date("Y-m-d", mktime(0,0,0,  date("m"),date("d")-$DUREE_VALIDITE_PAF, date("Y")))."' && pa_unitaire != 0  ";
			break;
			case "3":
				$query = "SELECT MAX(pa_unitaire) as paf FROM articles_ref_fournisseur WHERE ref_article = '".$this->ref_article."'   ".$date_paa_query." &&  date_pa > '".date("Y-m-d", mktime(0,0,0, date("m"), date("d")-$DUREE_VALIDITE_PAF, date("Y")))."' && pa_unitaire != 0 ";
			break;
		}

		$resultat = $bdd->query ($query);
		if ($tmp = $resultat->fetchObject()) { $paa_ht = $tmp->paf; }

	}

	if (!$paa_ht) { $paa_ht = $this->paa_ht;}


	$new_paa = convert_numeric($paa_ht);
	if (is_numeric($new_paa)) {
		$this->paa_ht = $new_paa;
	} else {return false;}

	// *************************************************
	// Si les valeurs reçues sont incorrectes
	if (count($GLOBALS['_ALERTES'])) {
		return false;
	}

	// Si aucun changement, inutile d'aller plus loin
	if ($new_paa == $old_paa && !$add_query) {return false; }

	//archivage du pa
	$this->paa_archive ($new_paa);
	// *************************************************
	// Modification dans la base
	$query = "UPDATE articles
						SET paa_ht = ".num_or_null($this->paa_ht).",
								date_modification = NOW() ".$add_query."
						WHERE ref_article = '".$this->ref_article."' ";

	$bdd->exec ($query);

	// *************************************************
	// Mise à jour du prix d'achat stocké pour cet article
	if ($CALCUL_VAS == "3") {
		$this->maj_prix_achat_ht ($this->paa_ht);
	} else {
		// *************************************************
		// Mise à jour des prix de vente pour cet article
		if ($MAJ_PV == "2") {	$this->maj_all_tarifs ();}

		// on vas tester si notre article en compose un autre pour mettre à jour les prix de cet article
		$this->chek_my_lot();
	}
	// *************************************************
	// Résultat positif de la modification
	$GLOBALS['_INFOS']['Modification_paa_ht'] = 1;
	
	return true;
}




// *************************************************************************************************************
// FONCTIONS LIEES A LA SUPRESSION D'UN ARTICLE
// *************************************************************************************************************
// La fonction de suppression d'un article n'est normalement pas appellée
final public function suppression () {
	global $bdd;

	// *************************************************
	// Vérification que l'article n'appartient pas a un lot
	if ($this->composant) {
		$GLOBALS['_ALERTES']['appartenance_lot'] = 1;
		return false;
	}


	// *************************************************
	// Suppression de l'article
	$bdd->beginTransaction();

	$query = "DELETE FROM articles
						WHERE ref_article = '".$this->ref_article."' ";
	$bdd->exec ($query);

	switch ($this->modele) {
		case "materiel":
			$query = "DELETE FROM articles_modele_materiel
								WHERE ref_article = '".$this->ref_article."' ";
			$bdd->exec ($query);
			break;

		case "service":
			$query = "DELETE FROM articles_modele_service
								WHERE ref_article = '".$this->ref_article."' ";
			$bdd->exec ($query);
			break;

		case "service_abo":
			$query = "DELETE FROM articles_modele_service_abo
								WHERE ref_article = '".$this->ref_article."' ";
			$bdd->exec ($query);
			break;
	}
	$bdd->commit();
        edi_event(119,$this->ref_article);
	unset ($this);
}

//suppression d'un article de type maitre
final public function suppression_master () {
	global $bdd;

	$this->find_my_slaves ();
	foreach ($this->variante_slaves as $variante_slave) {
		$query = "UPDATE articles
							SET variante = 0,
									date_modification = NOW()
							WHERE ref_article = '".$variante_slave->ref_article_lie."' ";
		$bdd->exec ($query);
	}


	// *************************************************
	// Suppression de l'article
	$bdd->beginTransaction();

	switch ($this->modele) {
		case "materiel":
			$query = "DELETE FROM articles_modele_materiel
								WHERE ref_article = '".$this->ref_article."' ";
			$bdd->exec ($query);
			break;

		case "service":
			$query = "DELETE FROM articles_modele_service
								WHERE ref_article = '".$this->ref_article."' ";
			$bdd->exec ($query);
			break;

		case "service_abo":
			$query = "DELETE FROM articles_modele_service_abo
								WHERE ref_article = '".$this->ref_article."' ";
			$bdd->exec ($query);
			break;
	}

	$query = "DELETE FROM articles
						WHERE ref_article = '".$this->ref_article."' ";
	$bdd->exec ($query);

	$bdd->commit();

	unset ($this);
}


final public function stop_article () {
	global $bdd;

	$this->date_fin_dispo = date("Y-m-d H:i:s", time());
	if ($this->check_dispo()) {
		$GLOBALS['_ALERTES']['still_dispo'] = 1;
	}

	if ($this->variante == 2 && !$this->dispo) {
		$this->find_my_slaves ();
		$liste_esclaves = $this->variante_slaves;
		$esclaves_tjr_dispo = 0;
		foreach ($liste_esclaves as $esclave){
			if($esclave->dispo) {
				$tmp_article_slave = new article($esclave->ref_article_lie);
				$tmp_article_slave->stop_article ();
				if ($tmp_article_slave->getDispo ()) {
					$esclaves_tjr_dispo = 1;
				}
			}
		}
		if ($esclaves_tjr_dispo) {$this->dispo = 1; return true;}
	}

	// Mise à jour de l'article
	$query_set = "";
	//si plus dispo raz de la ref_interne
	if (!$this->dispo) { $query_set = " ,ref_interne = NULL";}

	$query = "UPDATE articles SET date_fin_dispo = '".$this->date_fin_dispo."', dispo = '".$this->dispo."', date_modification = NOW()".$query_set."
						WHERE ref_article = '".$this->ref_article."' ";
	$bdd->exec ($query);

	//gestion des cas variantes
	//on récupére le maitre et on vérifie que tout les esclaves sont non dispo
	if ($this->variante == 1 && !$this->dispo) {
		$master = new article($this->variante_master);
		$liste_esclaves = $master->getVariante_slaves ();
		$esclaves_tjr_dispo = 0;
		foreach ($liste_esclaves as $esclave){
			if($esclave->dispo) {$esclaves_tjr_dispo = 1; break;}
		}
		if (!$esclaves_tjr_dispo) {$master->stop_article ();}
		return true;
	}


	return true;
}


// Fusion avec un autre article
public function fusion ($second_ref_article) {
	global $bdd;

	if (!$second_ref_article) {
	 return false;
	}
	$second_article = new article($second_ref_article);

	// Mise à jour des lignes de document
	$query = "UPDATE docs_lines
						SET ref_article = '".$this->ref_article."'
						WHERE ref_doc_line = '".$second_ref_article."'  ";
	$bdd->exec ($query);

	//mise à jour des documents de fabrication et désassemblage
	$query = "UPDATE doc_fab
						SET ref_article = '".$this->ref_article."'
						WHERE ref_article = '".$second_ref_article."'  ";
	$bdd->exec ($query);
	$query = "UPDATE doc_des
						SET ref_article = '".$this->ref_article."'
						WHERE ref_article = '".$second_ref_article."'  ";
	$bdd->exec ($query);

	//modification des images du second article vers le premier
	$second_images = $second_article->getImages();

	$query = "SELECT MAX(ordre) ordre FROM articles_images WHERE ref_article = '".$this->ref_article."' ";
	$resultat = $bdd->query ($query);
	if ($tmp = $resultat->fetchObject ()) {$ordre = $tmp->ordre+1;}

	foreach ($second_images as $image) {
		$query = "UPDATE articles_images
							SET ref_article = '".$this->ref_article."' , ordre = '".$ordre."'
							WHERE ref_article = '".$second_ref_article."' && id_image = '".$image->id_image."' ";
		$bdd->exec ($query);
		$ordre++;
	}


	//mise à jour des stocks et tranfert des sn
	$ref_stock_article = "";

	//On récupère tout les stock de l'article qui sera archivé
	$query = "SELECT ref_stock_article, qte, id_stock
						FROM stocks_articles
						WHERE ref_article = '".$second_ref_article."'  ";
	$resultat = $bdd->query($query);
	while ($tmp = $resultat->fetchObject()) {$ref_stock_article = $tmp->ref_stock_article;

		//on les transfères dans l'article conservé
		$query_stock_art = "UPDATE stocks_articles
							SET qte = qte + ".$tmp->qte."
							WHERE ref_article = '".$this->ref_article."' && id_stock = '".$tmp->id_stock."' ";
		$resultat_stock_art = $bdd->query($query_stock_art);
		if (!$resultat_stock_art->rowCount()) {
			// La ligne n'existe pas dans le stock, il faut la créer
			$reference = new reference ($this->STOCK_ARTICLE_ID_REFERENCE_TAG);
			$new_ref_stock_article = $reference->generer_ref();
			$query = "INSERT INTO stocks_articles (ref_stock_article, id_stock, ref_article, qte)
								VALUES ('".$new_ref_stock_article."', '".$tmp->id_stock."', '".$this->ref_article."', '".$tmp->qte."') ";
			$bdd->exec ($query);
		}
		unset ($reference, $query_stock_art, $resultat_stock_art);
		// on récupère la ref_stock_article afin de transférer les sn vers cette ref
		$query_sa = "SELECT ref_stock_article
							FROM stocks_articles
							WHERE ref_article = '".$this->ref_article."' && id_stock = '".$tmp->id_stock."' ";
		$resultat_sa = $bdd->query($query_sa);
		$stock_article = $resultat_sa->fetchObject();

		//on met à jour tout les numéro de série en stock
		$query = "UPDATE stocks_articles_sn
							SET ref_stock_article = '".$stock_article->ref_stock_article."'
							WHERE ref_stock_article = '".$ref_stock_article."' ";
		$bdd->exec($query);

		//on supprime les anciens ref_stock_article
		$query = "DELETE FROM stocks_articles
							WHERE ref_stock_article = '".$ref_stock_article."' ";
		$bdd->exec($query);

		//on génére les mouvements de stocks
		if ($_SESSION['stocks'][$tmp->id_stock]->genere_move_stock (NULL, $this->ref_article, $tmp->qte)) {}
		if ($_SESSION['stocks'][$tmp->id_stock]->genere_move_stock (NULL, $second_ref_article, -$tmp->qte)){}

		unset ($stock_article, $resultat_sa, $query_sa);
	}
	$second_article->stop_article ();
	return true;
}


// *************************************************************************************************************
// FONCTIONS DE GESTION DES CARACTERISTIQUES
// *************************************************************************************************************
// Chargements des caractéristiques de l'article
public function charger_caracs () {
	global $bdd;

	$this->caracs = array();
	$query = "SELECT acc.ref_carac, acc.lib_carac, acc.unite, acc.ref_carac_groupe, acc.allowed_values, acc.variante,
									 acc.moteur_recherche, acc.affichage, acc.default_value, ac.valeur
						FROM art_categs_caracs acc
							LEFT JOIN articles_caracs ac ON acc.ref_carac = ac.ref_carac && ac.ref_article = '".$this->ref_article."'
							LEFT JOIN art_categs_caracs_groupes accg ON acc.ref_carac_groupe = accg.ref_carac_groupe
						WHERE acc.ref_art_categ = '".$this->ref_art_categ."'
						ORDER BY accg.ordre, acc.ordre ";
	$resultat = $bdd->query ($query);
	while ($var = $resultat->fetchObject()) { $this->caracs[] = $var; }

	$this->caracs_loaded = true;
	$this->charger_caracs_groupes ();
	return true;
}


// Chargement des groupes de caractéristiques de la catégorie d'article
public function charger_caracs_groupes () {
	global $bdd;

	$this->caracs_groupes = array();
	$query = "SELECT ref_carac_groupe, lib_carac_groupe
						FROM art_categs_caracs_groupes
						WHERE ref_art_categ = '".$this->ref_art_categ."'
						ORDER BY ordre ";
	$resultat = $bdd->query ($query);
	while ($var = $resultat->fetchObject()) { $this->caracs_groupes[] = $var; }

	$this->caracs_groupes_loaded = true;
	return true;
}


// Ajout d'une caractéristique
public function add_carac ($ref_carac, $valeur) {
	global $bdd;

	// verification que la ref_carac existe
	$query = "SELECT ref_carac
                        FROM art_categs_caracs
                        WHERE ref_carac = '".$ref_carac."'
                        LIMIT 0,1";
	$resultat = $bdd->query ($query);
	if (!$var = $resultat->fetchObject()) {
		$GLOBALS['_ALERTES']['not_exist_ref_carac'] = $ref_carac;
	}
	if (count($GLOBALS['_ALERTES'])) {
		return false;
	}

	$query = "INSERT INTO articles_caracs (ref_article, ref_carac, valeur)
						VALUES ('".$this->ref_article."', '".$ref_carac."', '".addslashes($valeur)."' )";
	$bdd->exec ($query);

	// *************************************************
	// Modification dans la base de la date de modification
	$query = "UPDATE articles
                        SET date_modification = NOW()
                        WHERE ref_article = '".$this->ref_article."' ";
	$bdd->exec ($query);
        if($this->variante != 1){
                edi_event(114,$this->ref_article, $ref_carac);
        }

	return true;
}


// modif d'une caractéristique
/**
 * @param <type> $ref_carac - référence de la carac à modifier
 * @param <type> $valeur - nouvelle valeur
 * @param <type> $variante - si renseigné ne modifie la carac que si $variante ( 0 ou 1 ) que si la carac est variante ou pas
 * @return <type> true or false
 */
public function maj_carac ($ref_carac, $valeur, $variante = "") {
	global $bdd;


	// verification que la ref_carac existe
	$query = "SELECT ref_carac, variante
						FROM art_categs_caracs
						WHERE ref_carac = '".$ref_carac."'
						LIMIT 0,1";
	$resultat = $bdd->query ($query);
	if (!$var = $resultat->fetchObject()) {
		$GLOBALS['_ALERTES']['not_exist_ref_carac'] = $ref_carac;
	}
	if (count($GLOBALS['_ALERTES'])) {
		return false;
	}
    if($variante == "" || $var->variante == $variante){
            $query = "SELECT ref_article, ref_carac
                                                    FROM articles_caracs
                                                    WHERE ref_article = '".$this->ref_article."' && ref_carac = '".$ref_carac."'
                                                    LIMIT 0,1";
            $resultat = $bdd->query ($query);
            if ($var = $resultat->fetchObject()) {
                    $query = "UPDATE articles_caracs
                                                                    SET valeur = '".addslashes($valeur)."'
                                                            WHERE ref_article = '".$this->ref_article."' && ref_carac = '".$ref_carac."' ";
                    $bdd->exec ($query);
            } else {
                    $query = "INSERT INTO articles_caracs (ref_article, ref_carac, valeur)
                                                            VALUES ('".$this->ref_article."', '".$ref_carac."', '".addslashes($valeur)."' )";
                    $bdd->exec ($query);
            }

            // *************************************************
            // Modification dans la base de la date de modification
            $query = "UPDATE articles
                                                    SET date_modification = NOW()
                                                    WHERE ref_article = '".$this->ref_article."' ";
            $bdd->exec ($query);

             //**********************************************
            // Envoi EDI
            if($this->variante != 1){
                    edi_event(118,$this->ref_article, $ref_carac);
            }

    }
	return true;
}


// RAZ d'une caractéristique
public function del_carac ($ref_carac) {
	global $bdd;

	$query = "DELETE FROM articles_caracs
						WHERE ref_article = '".$this->ref_article."' && ref_carac = '".$ref_carac."' ";
	$bdd->exec ($query);

	// *************************************************
	// Modification dans la base de la date de modification
	$query = "UPDATE articles
						SET date_modification = NOW()
						WHERE ref_article = '".$this->ref_article."' ";
	$bdd->exec ($query);

	return true;
}


// RAZ de toutes les caractéristiques
public function del_all_carac () {
	global $bdd;

	$query = "DELETE FROM articles_caracs
						WHERE ref_article = '".$this->ref_article."' ";
	$bdd->exec ($query);

	return true;
}



// *************************************************************************************************************
// FONCTIONS DE GESTION DES FORMULES DE TARIF
// *************************************************************************************************************
// Chargements des formules de tarif
public function charger_formules_tarifs () {
	global $bdd;

	$query = "SELECT id_tarif, indice_qte, formule_tarif
						FROM articles_formules_tarifs
						WHERE ref_article = '".$this->ref_article."'
						ORDER BY indice_qte ";
	$resultat = $bdd->query($query);
	while ($var = $resultat->fetchObject()) { $this->formules_tarifs[] = $var; }

	$this->formules_tarifs_loaded = 1;
	return true;
}


// Ajout d'une formule de tarif
public function add_formule_tarif ($id_tarif, $indice_qte, $formule_tarif) {
	global $bdd;

	if (!$indice_qte) { return false; }

	// *************************************************
	// Controles des données
	if (!formule_tarif::check_formule($formule_tarif)) {
		$GLOBALS['_ALERTES']['bad_formule_tarif'] = 1;
	}

	if (!is_numeric($id_tarif)) {
		$GLOBALS['_ALERTES']['bad_id_tarif'] = 1;
	}
	if (!is_numeric($indice_qte)) {
		$GLOBALS['_ALERTES']['bad_indice_qte'] = 1;
	}

	// *************************************************
	// Si les valeurs reçues sont incorrectes
	if (count($GLOBALS['_ALERTES'])) {
		return false;
	}

	// Insertion dans la bdd
	$query = "REPLACE INTO articles_formules_tarifs (ref_article, id_tarif, indice_qte, formule_tarif)
						VALUES ('".$this->ref_article."', '".$id_tarif."', '".$indice_qte."', '".$formule_tarif."') ";
	$bdd->exec ($query);

	// *************************************************
	// Calcul et création du tarif correspondant
	$this->create_tarif ($id_tarif, $indice_qte, $formule_tarif);

	return true;
}


// Suppression d'une formule de tarif
public function delete_formule_tarif ($id_tarif, $indice_qte) {
	global $bdd;

	// Si aucun tarif spécifié, on supprime tous les tarifs (toute la ligne)
	$query_where = "";
	if ($id_tarif) {
		$query_where = "&& id_tarif = '".$id_tarif."' ";
	}

	// Suppression de la formule
	$query = "DELETE FROM articles_formules_tarifs
						WHERE ref_article = '".$this->ref_article."' ".$query_where." && indice_qte = '".$indice_qte."' ";
	$bdd->exec ($query);

	// Suppression du tarif correspondant
	$this->delete_tarif ($id_tarif, $indice_qte);
	return true;
}



// Choix de la formule de tarif applicable pour la détermination d'un prix
function select_formule_tarif ($id_tarif, $indice_qte) {
	global $bdd;

	// ************************************
	// Recherche des formules disponibles
	$formules_dispos = array();

	// Pour l'article en priorité
	if (!$this->formules_tarifs_loaded) {
		$this->charger_formules_tarifs();
	}

	for ($i=0; $i<count($this->formules_tarifs); $i++) {
		if ($this->formules_tarifs[$i]->id_tarif != $id_tarif) { continue; }
		if ($this->formules_tarifs[$i]->indice_qte > $indice_qte) { continue; }
		$formules_dispos[] = $this->formules_tarifs[$i];
	}
	// Sélection des formules de la catégorie si besoin
	if (!count($formules_dispos)) {
		$query = "SELECT formule_tarif
							FROM art_categs_formules_tarifs
							WHERE ref_art_categ = '".$this->ref_art_categ."' && id_tarif = '".$id_tarif."' ";
		$resultat = $bdd->query($query);
		if ($var = $resultat->fetchObject()) { $formules_dispos[] = $var; }
	}

	// Prise en compte de la marge par défaut si il n'existe rien.
	if (!count($formules_dispos)) {
		$query = "SELECT marge_moyenne formule_tarif FROM tarifs_listes
							WHERE id_tarif = '".$id_tarif."' ";
		$resultat = $bdd->query($query);
		if ($var = $resultat->fetchObject()) { $formules_dispos[] = $var; }
	}

	// ************************************
	// Sélection de la formule la plus adaptée
	if (!count($formules_dispos)) {
		$GLOBALS['_ALERTES']['aucune_formule_dispo'] = 1;
		return false;
	}
	$formule_tarif = $formules_dispos[count($formules_dispos)-1]->formule_tarif;

	return $formule_tarif;
}



// *************************************************************************************************************
// FONCTIONS DE GESTION DES TARIFS
// *************************************************************************************************************

// Chargements des tarifs
public function charger_tarifs () {
	global $bdd;

	$this->tarifs = array();
	$query = "SELECT id_tarif, indice_qte, pu_ht
						FROM articles_tarifs
						WHERE ref_article = '".$this->ref_article."'
						ORDER BY indice_qte ";
	$resultat = $bdd->query($query);
	while ($var = $resultat->fetchObject()) { $this->tarifs[] = $var; }

	// Controle qu'il existe bien un tarif par article
	$everything_ok = 1;
	get_tarifs_listes();
	$tarifs_ok = array();
	foreach ($this->tarifs as $tarif) {
		$tarifs_ok[$tarif->id_tarif] = 1;
	}
	foreach ($_SESSION['tarifs_listes'] as $tarif_liste) {
		if (isset($tarifs_ok[$tarif_liste->id_tarif])) { continue; }
		$everything_ok = 0;
		break;
	}

	if (!$everything_ok) {
		$this->check_tarif ();
		return $this->charger_tarifs ();
	}

	$this->tarifs_loaded = 1;
	return true;
}


// Création d'un tarif
function create_tarif ($id_tarif, $indice_qte, $formule_tarif) {
	global $bdd;
	global $CALCUL_VAS;

	// *************************************************
	// Calcul du prix de vente HT
	$used_pa = $this->prix_achat_ht;

	switch ($CALCUL_VAS) {
		case "1":	case "2":
			if (!$this->stocks_loaded) {$this->charger_stocks ();}
			$sum_stock = 0;
			foreach ($_SESSION["stocks"] as $id_stock=>$stock_obj) {
				if (isset($this->stocks[$id_stock]->qte)) {$sum_stock += $this->stocks[$id_stock]->qte;}
			}
			if (!$sum_stock) {
				$used_pa = $this->paa_ht;
			}
		break;
	}

	if (!$this->prix_achat_ht || $this->prix_achat_ht == "NULL") { $used_pa = $this->paa_ht;}


	$formule = new formule_tarif ($formule_tarif);
	$formule->calcul_tarif_article ($indice_qte, $used_pa, $this->prix_public_ht, $this->tva);
	$pu_ht = $formule->tarifs['PU_HT'];

	//on récupère les informations du tarif (sans passer par le $tarif_loaded qui pause problème à la création d'un article
	$query = "SELECT id_tarif, indice_qte, pu_ht
						FROM articles_tarifs
						WHERE ref_article = '".$this->ref_article."' && id_tarif = '".$id_tarif."'
						ORDER BY indice_qte ";
	$resultat = $bdd->query($query);
	if ($var = $resultat->fetchObject()) {
		//on archive le tarifs si le pu_ht est modifié
		if ($var->indice_qte == $indice_qte && $indice_qte == 1 && $pu_ht != $var->pu_ht) {
			$var->pu_ht = $pu_ht;
			$var->id_tarif = $id_tarif;
			$this->pv_archive ($var);
		}
	}

	// *************************************************
	// Insertion dans la BDD
	$query = "REPLACE INTO articles_tarifs (ref_article, id_tarif, indice_qte, pu_ht)
						VALUES ('".$this->ref_article."', '".$id_tarif."', '".$indice_qte."', '".$pu_ht."') ";
	$bdd->exec ($query);

	return $pu_ht;
}


// Suppresion d'un tarif
function delete_tarif ($id_tarif, $indice_qte) {
	global $bdd;

	// Si aucun tarif spécifié, on supprime tous les tarifs (toute la ligne)
	$query_where = "";
	if ($id_tarif) {
		$query_where = "&& id_tarif = '".$id_tarif."' ";
	}
	// *************************************************
	// Suppression dans la BDD
	$query = "DELETE FROM articles_tarifs
						WHERE ref_article = '".$this->ref_article."' ".$query_where." && indice_qte = '".$indice_qte."' ";
	$bdd->exec ($query);

	$this->check_tarif($id_tarif);
	return true;
}


// Suppresion d'un tarif
function maj_tarif ($id_tarif, $indice_qte) {
	global $bdd;

	// *************************************************
	// Recherche de la formule adaptée
	$formule = $this->select_formule_tarif ($id_tarif, $indice_qte);

	// *************************************************
	// Création du tarif de l'article
	if (!$formule) { return false; }
	$this->create_tarif($id_tarif, $indice_qte, $formule);

    //**********************************************
	// Envoi EDI
	edi_event(115,$this->ref_article);
	return true;
}


// Vérifie que chaque tarif pour l'article est défini
protected function check_tarif ($id_tarif = 0) {
	global $bdd;

	// Si aucune grille de tarif précisée, "check" de chacun des tarifs
	if (!$id_tarif) {
		get_tarifs_listes ();
		foreach ($_SESSION['tarifs_listes'] as $tarif) {
			$this->check_tarif($tarif->id_tarif);
		}
		return true;
	}

	// Vérification
	$query = "SELECT COUNT(pu_ht) tarif_exist
						FROM articles_tarifs
						WHERE ref_article = '".$this->ref_article."' && id_tarif = '".$id_tarif."' ";
	$resultat = $bdd->query ($query);
	$tmp = $resultat->fetchObject();
	if ($tmp->tarif_exist) {
		return true;
	}

	// Création d'un tarif à partir de la catégorie
	$query = "SELECT formule_tarif
						FROM art_categs_formules_tarifs
						WHERE ref_art_categ = '".$this->ref_art_categ."' && id_tarif = '".$id_tarif."' ";
	$resultat = $bdd->query ($query);
	if ($formule = $resultat->fetchObject()) {
		$this->create_tarif ($id_tarif, 1, $formule->formule_tarif);
	}
	else { // Ou tu tarif par défaut de la grille de tarif.
		$query = "SELECT marge_moyenne FROM tarifs_listes
							WHERE id_tarif = '".$id_tarif."' ";
		$resultat = $bdd->query ($query);
		$tarif_liste = $resultat->fetchObject();
		$this->create_tarif ($id_tarif, 1, $tarif_liste->marge_moyenne);
	}

	return true;
}


protected function maj_all_tarifs () {
	if (!$this->tarifs_loaded) { $this->charger_tarifs(); }

	foreach ($this->tarifs as $tarif) {
		$this->maj_tarif($tarif->id_tarif, $tarif->indice_qte);
	}
}

public function call_maj_all_tarifs () {
	$this->maj_all_tarifs();
}


//fonction d'archivage du prix d'achat en cas de mise à jour
protected function pa_archive ($pa) {
	global $bdd;

	$query = "INSERT INTO articles_pa_archive (ref_article, date_maj, prix_achat_ht)
						VALUES ('".$this->ref_article."', NOW(), ".num_or_null($pa).") ";
	$bdd->exec ($query);
	return true;
}

//fonction d'archivage du prix d'achat actuel en cas de mise à jour
protected function paa_archive ($paa) {
	global $bdd;

	$query = "INSERT INTO articles_paa_archive (ref_article, date_maj, prix_achat_actuel_ht)
						VALUES ('".$this->ref_article."', NOW(), ".num_or_null($paa).") ";
	$bdd->exec ($query);
	return true;
}

//fonction d'archivage des prix de vente en cas de mise à jour
protected function pv_archive ($tarif) {
	global $bdd;

	$query = "INSERT INTO articles_pv_archive (ref_article, date_maj, id_tarif, pu_ht)
						VALUES ('".$this->ref_article."', NOW(), '".$tarif->id_tarif."', '".$tarif->pu_ht."') ";
	$bdd->exec ($query);

	return true;
}

protected function chargerpv_last_maj () {
	global $bdd;

	$query = "SELECT date_maj
						FROM articles_pv_archive
						WHERE ref_article = '".$this->ref_article."'
						ORDER BY date_maj DESC ";
	$resultat = $bdd->query ($query);
	if ($tmp = $resultat->fetchObject()) {
		return $tmp->date_maj;
	}
}

// *************************************************************************************************************
// FONCTIONS DE GESTION DES TAXES
// *************************************************************************************************************

// Chargement des taxes associées à l'article
public function charger_taxes () {
	global $bdd;

	$this->taxes = array();
	$query = "SELECT at.id_taxe, at.montant_taxe, t.lib_taxe, t.code_taxe, t.id_pays, t.visible
						FROM articles_taxes at
							LEFT JOIN taxes t ON at.id_taxe = t.id_taxe
						WHERE at.ref_article = '".$this->ref_article."' ";
	$resultat = $bdd->query($query);
	while ($tmp = $resultat->fetchObject()) { $this->taxes[] = $tmp; }

	$this->taxes_loaded = true;
	return true;
}


// Ajoute une taxe
function add_taxe ($id_taxe, $code_taxe, $info_calcul) {
	global $bdd;
	global $DIR;

        $taxe = new taxe($id_taxe);

        //TEST si existant
	$query = "SELECT at.id_taxe, at.montant_taxe, t.lib_taxe, t.code_taxe, t.id_pays, t.visible
						FROM articles_taxes at
							LEFT JOIN taxes t ON at.id_taxe = t.id_taxe
						WHERE at.ref_article = '".$this->ref_article."' && at.id_taxe = '".$id_taxe."'";
	$resultat = $bdd->query($query);
	if ($tmp = $resultat->fetchObject()) {
                //si existant mise à jour
		$this->maj_montant_taxe($id_taxe, $info_calcul);
                return true;
	}


        $montant_taxe = $taxe->calculMontant_taxe($this, $info_calcul);
	
	// *************************************************
	// Insertion dans la base
	$query = "INSERT INTO articles_taxes (ref_article, id_taxe, montant_taxe)
						VALUES ('".$this->ref_article."', '".$id_taxe."', '".$montant_taxe."') ";
	$bdd->exec ($query);

	return true;
}

// remplacer le montant_taxe
function maj_montant_taxe ($id_taxe, $info_calcul) {
	global $bdd;
	global $DIR;

        $taxe = new taxe($id_taxe);

        $montant_taxe = $taxe->calculMontant_taxe($this, $info_calcul);

	// *************************************************
	// Insertion dans la base
	$query = "REPLACE INTO articles_taxes (ref_article, id_taxe, montant_taxe)
						VALUES ('".$this->ref_article."', '".$id_taxe."', '".$montant_taxe."') ";
	$bdd->exec ($query);

	return true;
}

// *************************************************************************************************************
// FONCTIONS DE GESTION DES IMAGES
// *************************************************************************************************************
public function getImagesLocation(){
	global $bdd;
	$query = "SELECT lib_file FROM images_articles WHERE id_image IN
		(SELECT id_image FROM articles_images WHERE ref_article='".$this->ref_article."');";
	$res = $bdd->query($query);
	return $res->fetchAll();
}

// Chargement des images
public function charger_images () {
	global $bdd;

	$this->images = array();

	$query = "SELECT ai.ref_article, ai.id_image, ai.ordre, ia.lib_file
						FROM articles_images ai
							LEFT JOIN images_articles ia ON ai.id_image = ia.id_image
						WHERE ai.ref_article = '".$this->ref_article."'
						ORDER BY ai.ordre ASC";
	$resultat = $bdd->query($query);
	while ($tmp = $resultat->fetchObject()) { $this->images[] = $tmp; }

	$this->images_loaded = true;
	return true;
}

// Ajout d'une image
public function add_image ($lib_file) {
	global $bdd;

	// *************************************************
	// Controle des données générales


	// *************************************************
	// Si les valeurs reçues sont incorrectes
	if (count($GLOBALS['_ALERTES'])) {
		return false;
	}


	// Recherche de l'ordre actuel
	$query = "SELECT MAX(ordre) ordre FROM articles_images WHERE ref_article = '".$this->ref_article."' ";
	$resultat = $bdd->query ($query);
	if ($tmp = $resultat->fetchObject ()) {$ordre = $tmp->ordre+1;}

	// Insertion dans la BDD
	$query = "INSERT INTO images_articles (lib_file)
						VALUES ( '".$lib_file."')";
	$bdd->exec ($query);

	//on récupère le dernier id_image créé
	$id_image = $bdd->lastInsertId();

	$query = "INSERT INTO articles_images (ref_article, id_image, ordre)
						VALUES ('".$this->ref_article."', '".$id_image."', '".$ordre."')";
	$bdd->exec ($query);

	// *************************************************
	// Modification dans la base de la date de modification
	$query = "UPDATE articles
						SET date_modification = NOW()
						WHERE ref_article = '".$this->ref_article."' ";
	$bdd->exec ($query);
	
	if($this->variante != 1 ){
		edi_event(113,$this->ref_article,$id_image);
	}
	

	return true;
}


// Suppression d'une image
public function sup_image ($id_image) {
	global $bdd;
	global $ARTICLES_IMAGES_DIR;
	global $ARTICLES_MINI_IMAGES_DIR;

	// *************************************************
	// Controle des données générales

	// *************************************************
	// Si les valeurs reçues sont incorrectes
	if (count($GLOBALS['_ALERTES'])) {
		return false;
	}

	$lib_file = "";
	// Recherche de l'ordre actuel et on récupère le lib de l'image pour supprimer les fichiers
	$query = "SELECT ai.ordre , ia.lib_file
						FROM articles_images ai
							LEFT JOIN images_articles ia ON ai.id_image = ia.id_image
						WHERE ref_article = '".$this->ref_article."' && ai.id_image = '".$id_image."' ";
	$resultat = $bdd->query ($query);
	if ($tmp = $resultat->fetchObject ()) {$ordre = $tmp->ordre; $lib_file = $tmp->lib_file;}
	if (!$ordre) {$ordre = 1;}

	// Décalage des ordres
	$query2 = "UPDATE articles_images
						SET ordre = ordre - 1
						WHERE ref_article = '".$this->ref_article."' &&
									ordre >= '".$ordre."'  ";
	$bdd->exec ($query2);

	// Suppression dans la BDD
	$query = "DELETE FROM articles_images
						WHERE id_image = '".$id_image."' ";
	$bdd->exec ($query);

	$query = "DELETE FROM images_articles
						WHERE id_image = '".$id_image."' ";
	$bdd->exec ($query);

	//suppression de fichiers
	if ($lib_file) {
		if (file_exists($ARTICLES_IMAGES_DIR.$lib_file)) {
			@unlink($ARTICLES_IMAGES_DIR.$lib_file);
		}
		if (file_exists($ARTICLES_MINI_IMAGES_DIR.$lib_file)) {
			@unlink($ARTICLES_MINI_IMAGES_DIR.$lib_file);
		}
	}

	// *************************************************
	// Modification dans la base de la date de modification
	$query4 = "UPDATE articles
						SET date_modification = NOW()
						WHERE ref_article = '".$this->ref_article."' ";
	$bdd->exec ($query4);

        edi_event(120, $id_image);

	return true;
}

// Changement d'ordre d'affichage d'une image
final public function image_maj_ordre ($id_image, $new_ordre) {
	global $bdd;

	if (!is_numeric($new_ordre)) {
		$GLOBALS['_ALERTES']['bad_ordre'] = 1;
	}

	// *************************************************
	// Si les valeurs reçues sont incorrectes
	if (count($GLOBALS['_ALERTES'])) {
		return false;
	}

	// Recherche de l'ordre actuel
	$query = "SELECT ordre FROM articles_images WHERE id_image = '".$id_image."' ";
	$resultat = $bdd->query ($query);
	$tmp = $resultat->fetchObject ();
	$ordre = $tmp->ordre;


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
	// MAJ BDD
	$bdd->beginTransaction();

	// Mise à jour des autres composants
	$query = "UPDATE articles_images
						SET ordre = ordre ".$variation." 1
						WHERE ref_article = '".$this->ref_article."' &&
									ordre ".$symbole1." '".$ordre."' && ordre ".$symbole2." '".$new_ordre."' ";
	$bdd->exec ($query);

	// Mise à jour de ce composant
	$query = "UPDATE articles_images
						SET ordre = '".$new_ordre."'
						WHERE id_image = '".$id_image."'  ";
	$bdd->exec ($query);

	$bdd->commit();

	// *************************************************
	// Résultat positif de la modification
	return true;
}


// *************************************************************************************************************
// FONCTIONS DE GESTION DES COMPOSANTS
// *************************************************************************************************************
// Chargement des composants
public function charger_composants () {
	global $bdd;

	$this->composants = array();
	if (!$this->lot) { return false; }

	$this->composants = get_article_composants ($this->ref_article);

	$this->composants_loaded = true;
	return true;
}


// Ajout d'un composant
public function add_composant ($ref_article_composant, $qte, $niveau, $ordre) {
	global $bdd;
	global $DEFAUT_LOT;

	$COMPOSANT_ID_REFERENCE_TAG = 10;

	// *************************************************
	// Controle des données générales
	if (!is_numeric($qte)) {
		$GLOBALS['_ALERTES']['bad_qte'] = 1;
	}
	if (!is_numeric($niveau)) {
		$GLOBALS['_ALERTES']['bad_niveau'] = 1;
	}
	if (!is_numeric($ordre)) {
		$GLOBALS['_ALERTES']['bad_ordre'] = 1;
	}

	$query = "SELECT ref_article
						FROM articles
						WHERE ref_article = '".$ref_article_composant."'
						LIMIT 0,1";
	$resultat = $bdd->query($query);
	if  (!$tmp = $resultat->fetchObject()) {
		$GLOBALS['_ALERTES']['not_exist_ref_article_composant'] = $ref_article_composant;
	}
	// *************************************************
	// Si les valeurs reçues sont incorrectes
	if (count($GLOBALS['_ALERTES'])) {
		return false;
	}

	// *************************************************
	// Création de la référence
	$reference = new reference ($COMPOSANT_ID_REFERENCE_TAG);
	$ref_lot_contenu = $reference->generer_ref();


	if ($bdd->beginTransaction()) { $transac = 1; } else { $transac = 0; }

	// Décalage des ordres
	$query = "UPDATE articles_composants
						SET ordre = ordre + 1
						WHERE ref_article_lot = '".$this->ref_article."' &&
									ordre >= '".$ordre."'  ";
	$bdd->exec ($query);

	// Insertion dans la BDD
	$query = "INSERT INTO articles_composants (ref_lot_contenu, ref_article_lot, ref_article_composant, qte, niveau, ordre)
						VALUES ('".$ref_lot_contenu."', '".$this->ref_article."', '".addslashes($ref_article_composant)."',
										'".$qte."', '".$niveau."', '".$ordre."')";
	$bdd->exec ($query);

	// Mise à jour du composant
	$query = "UPDATE articles SET composant = composant + 1
						WHERE ref_article = '".$ref_article_composant."' ";
	$bdd->exec ($query);

	if (!$this->lot) {
		$this->lot = $DEFAUT_LOT;
		$query = "UPDATE articles SET lot = ".$DEFAUT_LOT." WHERE ref_article = '".$this->ref_article."' ";
		$bdd->exec ($query);
	}

	// *************************************************
	// Modification dans la base de la date de modification
	$query = "UPDATE articles
						SET date_modification = NOW()
						WHERE ref_article = '".$this->ref_article."' ";
	$bdd->exec ($query);
	
	$this->maj_poids_compo("", $this->ref_article);

	if ($transac) { $bdd->commit(); }

	return true;
}

// Modification d'un composant
public function maj_composant ($ref_lot_contenu, $qte, $niveau) {
	global $bdd;

	// *************************************************
	// Controle des données générales
	if (!is_numeric($qte)) {
		$GLOBALS['_ALERTES']['bad_qte'] = 1;
	}
	if (!is_numeric($niveau)) {
		$GLOBALS['_ALERTES']['bad_niveau'] = 1;
	}

	// *************************************************
	// Si les valeurs reçues sont incorrectes
	if (count($GLOBALS['_ALERTES'])) {
		return false;
	}

	// *************************************************
	// MAJ de la BDD
	$query = "UPDATE articles_composants SET qte = '".$qte."', niveau = '".$niveau."'
						WHERE ref_lot_contenu = '".addslashes($ref_lot_contenu)."' ";
	$bdd->exec ($query);

	// *************************************************
	// Modification dans la base de la date de modification
	$query = "UPDATE articles
						SET date_modification = NOW()
						WHERE ref_article = '".$this->ref_article."' ";
	$bdd->exec ($query);
	
	$this->maj_poids_compo("", $this->ref_article);

	return true;
}


// Suppression d'une ligne de composant
public function del_composant ($ref_lot_contenu) {
	global $bdd;

	// Recherche d'autres composants, afin de savoir si cet article reste un lot
	$query = "SELECT COUNT(ref_article_composant) nb_composants
						FROM articles_composants
						WHERE ref_article_lot = '".$this->ref_article."' ";
	$resultat = $bdd->query ($query);
	$lot = $resultat->fetchObject ();
	if (!$lot->nb_composants) {
		$this->lot = 0;
	}

	// Recherche de l'ordre actuel
	$query = "SELECT ref_article_composant, ordre FROM articles_composants
						WHERE ref_lot_contenu = '".$ref_lot_contenu."' ";
	$resultat = $bdd->query ($query);
	$tmp = $resultat->fetchObject ();
	$ref_article_composant 	= $tmp->ref_article_composant;
	$ordre 									= $tmp->ordre;


	$bdd->beginTransaction ();

	$query = "DELETE FROM articles_composants
						WHERE ref_lot_contenu = '".addslashes($ref_lot_contenu)."' ";
	$bdd->exec ($query);

	// Mise à jour du composant
	$query = "UPDATE articles SET composant = composant - 1
						WHERE ref_article = '".$ref_article_composant."' ";
	$bdd->exec ($query);

	// Décalage des ordres
	$query = "UPDATE articles_composants
						SET ordre = ordre - 1
						WHERE ref_article_lot = '".$this->ref_article."' &&
									ordre > '".$ordre."'  ";
	$bdd->exec ($query);

	if (!$this->lot) {
		$query = "UPDATE articles SET lot = 0 WHERE ref_article = '".$this->ref_article."' ";
		$bdd->exec ($query);
	}

	// *************************************************
	// Modification dans la base de la date de modification
	$query = "UPDATE articles
						SET date_modification = NOW()
						WHERE ref_article = '".$this->ref_article."' ";
	$bdd->exec ($query);
	
	$this->maj_poids_compo("", $this->ref_article);

	$bdd->commit();

	return true;
}


// Suppression d'une ligne de composant
public function del_all_composants () {
	global $bdd;

	// Selection
	$composants = "";
	$query = "SELECT ref_article_composant FROM articles_composants
						WHERE ref_article_lot = '".$this->ref_article."' ";
	$resultat = $bdd->query ($query);
	while ($tmp = $resultat->fetchObject ()) {
		if ($composants) { $composants .= ","; }
		$composants .= "'".$tmp->ref_article_composant."'";
	}

	// ********************************
	// Mise à jour de la BDD
	$bdd->beginTransaction ();

	// Suppression des composants
	$query = "DELETE FROM articles_composants
						WHERE ref_article_lot = '".$this->ref_article."' ";
	$bdd->exec ($query);

	// Mise a jour du lot
	$query = "UPDATE articles SET lot = 0
						WHERE ref_article = '".$this->ref_article."' ";
	$bdd->exec ($query);
	$this->lot = 0;

	// Mise a jour des composants
	if ($composants) {
		$query = "UPDATE articles SET composant = composant-1
						WHERE ref_article IN (".$composants.") ";
		$bdd->exec ($query);
	}

	$bdd->commit();

	// Maj des données de session
	$this->composants_loaded = 1;
	$this->composants = array();

	return true;
}


// Changement d'ordre d'affichage d'un composant
final public function composant_maj_ordre ($ref_lot_contenu, $new_ordre) {
	global $bdd;

	if (!is_numeric($new_ordre)) {
		$GLOBALS['_ALERTES']['bad_ordre'] = 1;
	}

	// *************************************************
	// Si les valeurs reçues sont incorrectes
	if (count($GLOBALS['_ALERTES'])) {
		return false;
	}

	// Recherche de l'ordre actuel
	$query = "SELECT ordre FROM articles_composants WHERE ref_lot_contenu = '".$ref_lot_contenu."' ";
	$resultat = $bdd->query ($query);
	$tmp = $resultat->fetchObject ();
	$ordre = $tmp->ordre;


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
	// MAJ BDD
	$bdd->beginTransaction();

	// Mise à jour des autres composants
	$query = "UPDATE articles_composants
						SET ordre = ordre ".$variation." 1
						WHERE ref_article_lot = '".$this->ref_article."' &&
									ordre ".$symbole1." '".$ordre."' && ordre ".$symbole2." '".$new_ordre."' ";
	$bdd->exec ($query);

	// Mise à jour de ce composant
	$query = "UPDATE articles_composants
						SET ordre = '".$new_ordre."'
						WHERE ref_lot_contenu = '".$ref_lot_contenu."'  ";
	$bdd->exec ($query);

	$bdd->commit();

	// *************************************************
	// Résultat positif de la modification
	return true;
}

//fonction de mise à jour des pa pour un article de type lot 1 ou lot 2
function check_composant_pa ($ref_article_composant_origine) {
	global $bdd;
	global $CALCUL_TARIFS_NB_DECIMALS;

	// si l'article à l'origine de la maj pa est le même que celui-ci, ont s'arrete
	if ($ref_article_composant_origine == $this->ref_article) {return false;}
	//vérification du type de lot
	if ($this->lot != 1 && $this->lot != 2 ) { return false; }
	//si ce lot est lui même composant on empeche la maj pa pour ne pas créer de boucle infine
	if ($this->composant) { return false; }

	//on charge lescomposant + prix_achat + paa +qté en stock
	$composants = array();
	$query = "SELECT ac.ref_article_lot, ac.ref_lot_contenu, ac.ref_article_composant, ac.qte, ac.niveau, ac.ordre,
									 a.lib_article, a.lot, a.valo_indice, a.paa_ht, a.prix_achat_ht,
									 (SELECT SUM(sa.qte)
									 	FROM stocks_articles sa WHERE sa.ref_article = ac.ref_article_composant ) as qte_stock
						FROM articles_composants ac
							LEFT JOIN articles a ON a.ref_article = ac.ref_article_composant
						WHERE ac.ref_article_lot = '".$this->ref_article."'
						ORDER BY ac.niveau, ac.ordre ";
	$resultat = $bdd->query($query);
	while ($tmp = $resultat->fetchObject()) { $composants[] = $tmp; }
	$article_paa_ht = 0;
	foreach ($composants as $composant) {
		if ($composant->qte_stock) {
			$article_paa_ht += number_format($composant->qte*$composant->prix_achat_ht, $CALCUL_TARIFS_NB_DECIMALS, ".", ""	);
		} else {
			$article_paa_ht += number_format($composant->qte*$composant->paa_ht, $CALCUL_TARIFS_NB_DECIMALS, ".", ""	);
		}
	}
	$this->maj_prix_achat_actuel_ht ($article_paa_ht);

}
// *************************************************************************************************************
// FONCTIONS DE GESTION DES LOTS
// *************************************************************************************************************
// vérifie que l'article en cours compose un autre article et lance la maj des pa
function chek_my_lot() {
	global $bdd;

	if (!$this->lots_loaded) { $this->charger_lots(); }
	if (!count($this->lots)) { return false;}

	foreach ($this->lots as $lot) {
		$tmp_article = new article ($lot->ref_article_lot);
		$tmp_article->check_composant_pa($this->ref_article);
	}
	return true;
}

// Chargement des lots
function charger_lots () {
	global $bdd;

	$this->lots = array();
	if (!$this->composant) { return false; }

	$query = "SELECT ac.ref_article_lot, ac.ref_lot_contenu, a.lib_article
						FROM articles_composants ac
							LEFT JOIN articles a ON a.ref_article = ac.ref_article_lot
						WHERE ac.ref_article_composant = '".$this->ref_article."'
						ORDER BY a.lib_article";
	$resultat = $bdd->query($query);
	while ($tmp = $resultat->fetchObject()) { $this->lots[] = $tmp; }

	$this->lots_loaded = true;
	return true;
}



// *************************************************************************************************************
// FONCTIONS DE GESTION DES REF EXTERNES FOURNISSEURS
// *************************************************************************************************************
// Chargement des ref_externes
public function charger_ref_externes () {
	global $bdd;

	$this->ref_externes = array();

	$query = "SELECT arf.ref_article, arf.ref_fournisseur, arf.ref_article_externe, arf.lib_article_externe,
									 arf.pa_unitaire, arf.date_pa,
									 a.nom
						FROM articles_ref_fournisseur  arf
							LEFT JOIN annuaire a ON a.ref_contact = arf.ref_fournisseur
						WHERE arf.ref_article = '".$this->ref_article."'
						ORDER BY a.nom DESC ";
	$resultat = $bdd->query($query);
	while ($tmp = $resultat->fetchObject()) { $this->ref_externes[] = $tmp; }

	$this->ref_externes_loaded = true;
	return true;
}

// Chargement des ref_externes d'un fournisseur
public function charger_ref_article_externe_fournisseur ($ref_fournisseur) {
	global $bdd;

	$ref_articles_externes = array();

	$query = "SELECT arf.ref_article, arf.ref_fournisseur, arf.ref_article_externe, arf.lib_article_externe,
									 arf.pa_unitaire, arf.date_pa,
									 a.nom
						FROM articles_ref_fournisseur  arf
							LEFT JOIN annuaire a ON a.ref_contact = arf.ref_fournisseur
						WHERE arf.ref_article = '".$this->ref_article."' && arf.ref_fournisseur = '".$ref_fournisseur."'
						ORDER BY a.nom DESC ";
	$resultat = $bdd->query($query);
	while ($tmp = $resultat->fetchObject()) { $ref_articles_externes[] = $tmp; }

	return $ref_articles_externes;
}




// Ajout d'une ref_externe
public function add_ref_article_externe ($ref_fournisseur, $ref_article_externe, $lib_article_externe, $pa_unitaire, $date_pa) {
	global $bdd;
	global $CALCUL_VAS;

	// *************************************************
	// Controle des données générales
	if (!is_numeric($pa_unitaire)) {
		$GLOBALS['_ALERTES']['bad_pa_unitaire'] = 1;
	}
	if (!($ref_fournisseur)) {
		$GLOBALS['_ALERTES']['bad_ref_fournisseur'] = 1;
	}
	$query = "SELECT ref_article_externe
						FROM articles_ref_fournisseur
						WHERE ref_article = '".$this->ref_article."' && ref_fournisseur = '".$ref_fournisseur."' && ref_article_externe = '".$ref_article_externe."'
						LIMIT 0,1";
	$resultat = $bdd->query($query);
	if ($resultat->rowCount()) {
		$GLOBALS['_ALERTES']['exist_ref_article_externe'] = $ref_article_externe;
	}

	// *************************************************
	// Si les valeurs reçues sont incorrectes
	if (count($GLOBALS['_ALERTES'])) {
		return false;
	}
	
	// On archive le nouveau tarif fourni par le fournisseur
	$this->add_articles_paf_archive($ref_fournisseur, $date_pa, $pa_unitaire);

	// Insertion dans la BDD
	$query = "INSERT INTO articles_ref_fournisseur (ref_article, ref_fournisseur, ref_article_externe, lib_article_externe, pa_unitaire, date_pa)
						VALUES ('".$this->ref_article."', '".addslashes($ref_fournisseur)."', '".addslashes($ref_article_externe)."', '".addslashes($lib_article_externe)."', '".addslashes($pa_unitaire)."', '".$date_pa." 00:00:00')";
	$bdd->exec ($query);
	$this->maj_prix_achat_actuel_ht();

	if ($CALCUL_VAS == "2" && $pa_unitaire != 0) {	$this->maj_prix_achat_ht ($pa_unitaire); }

	return true;
}

// modification d'une ref_externe
public function mod_ref_article_externe ($ref_fournisseur, $old_ref_fournisseur, $ref_article_externe, $old_ref_article_externe, $lib_article_externe, $pa_unitaire, $date_pa) {
	global $bdd;
	global $CALCUL_VAS;
	
	unset($GLOBALS['_ALERTES']['bad_pa_unitaire'], $GLOBALS['_ALERTES']['bad_ref_fournisseur'], $GLOBALS['_ALERTES']['exist_ref_article_externe']);

	// *************************************************
	// Controle des données générales
	if (!is_numeric($pa_unitaire)) {
		$GLOBALS['_ALERTES']['bad_pa_unitaire'] = 1;
	}
	if (!($ref_fournisseur)) {
		$GLOBALS['_ALERTES']['bad_ref_fournisseur'] = 1;
	}
	
	// On archive le nouveau tarif fourni par le fournisseur
	$this->add_articles_paf_archive($ref_fournisseur, $date_pa, $pa_unitaire);
	
	$query = "SELECT *
				FROM articles_ref_fournisseur
				WHERE ref_article = '".$this->ref_article."' && ref_fournisseur = '".addslashes($ref_fournisseur)."' && ref_article_externe = '".addslashes($ref_article_externe)."'
				LIMIT 0,1";
	$resultat = $bdd->query($query);
	if ($resultat->rowCount() && $ref_article_externe != $old_ref_article_externe) {
		$GLOBALS['_ALERTES']['exist_ref_article_externe'] = $ref_article_externe;
	}

	// *************************************************
	// Si les valeurs reçues sont incorrectes
	if (count($GLOBALS['_ALERTES'])) {
		return false;
	}
	
	// MAJ dans la BDD
	$query = "UPDATE articles_ref_fournisseur 
					SET ref_fournisseur = '".addslashes($ref_fournisseur)."', ref_article_externe = '".addslashes($ref_article_externe)."', 
						lib_article_externe = '".addslashes($lib_article_externe)."', pa_unitaire = '".addslashes($pa_unitaire)."', date_pa = '".$date_pa." 00:00:00'
					WHERE ref_article = '".$this->ref_article."' && ref_fournisseur = '".addslashes($old_ref_fournisseur)."' 
						&& ref_article_externe = '".addslashes($old_ref_article_externe)."' ";
	$bdd->exec ($query);

	$this->maj_prix_achat_actuel_ht();

	if ($CALCUL_VAS == "2" && $pa_unitaire != 0) {	$this->maj_prix_achat_ht ($pa_unitaire); }

	return true;
}


// maj d'une ref_externe depuis un document
public function maj_ref_article_externe ($ref_fournisseur, $ref_article_externe, $old_ref_article_externe, $pa_unitaire, $date_pa) {
	global $bdd;

	// *************************************************
	// Controle des données générales
	if (!($ref_fournisseur)) {
		$GLOBALS['_ALERTES']['bad_ref_fournisseur'] = 1;
	}

	// *************************************************
	// Si les valeurs reçues sont incorrectes
	if (count($GLOBALS['_ALERTES'])) {
		return false;
	}
	
	// On archive le nouveau tarif fourni par le fournisseur
	$this->add_articles_paf_archive($ref_fournisseur, $date_pa, $pa_unitaire);

	$query0 = "SELECT ref_article_externe
						FROM articles_ref_fournisseur
						WHERE ref_article = '".$this->ref_article."' && ref_fournisseur = '".$ref_fournisseur."' && ref_article_externe = '".$ref_article_externe."'
						LIMIT 0,1";
	$resultat0 = $bdd->query($query0);
	if ($resultat0->rowCount()) {
		//la ref externe existe déjà donc on vas en fait mettre à jour cette ref_externe
		$old_ref_article_externe = $ref_article_externe;
		// maj dans la BDD
		$query = "UPDATE articles_ref_fournisseur SET ref_fournisseur = '".addslashes($ref_fournisseur)."', ref_article_externe = '".addslashes($ref_article_externe)."' , pa_unitaire = '".addslashes($pa_unitaire)."', date_pa = '".$date_pa."'
							WHERE ref_article = '".$this->ref_article."' && ref_fournisseur = '".addslashes($ref_fournisseur)."' && ref_article_externe = '".addslashes($old_ref_article_externe)."' ";
		$bdd->exec ($query);

	} else  {
		//sinon il se peut que l'on mette à jour une ancienne ref_externe
		$query1 = "SELECT ref_article_externe
							FROM articles_ref_fournisseur
							WHERE ref_article = '".$this->ref_article."' && ref_fournisseur = '".$ref_fournisseur."' && ref_article_externe = '".$old_ref_article_externe."'
							LIMIT 0,1";
		$resultat1 = $bdd->query($query1);
		if ($resultat1->rowCount()) {
			// on vas mettre à jour l'ancienne ref_externe
			// maj dans la BDD
			$query3 = "UPDATE articles_ref_fournisseur SET ref_fournisseur = '".addslashes($ref_fournisseur)."', ref_article_externe = '".addslashes($ref_article_externe)."' , pa_unitaire = '".addslashes($pa_unitaire)."', date_pa = '".$date_pa."'
								WHERE ref_article = '".$this->ref_article."' && ref_fournisseur = '".addslashes($ref_fournisseur)."' && ref_article_externe = '".addslashes($old_ref_article_externe)."' ";
			$bdd->exec ($query3);
		} else {
			// La ligne n'existe pas il faut la créer
			$query2 = "INSERT INTO articles_ref_fournisseur (ref_article, ref_article_externe, ref_fournisseur, pa_unitaire, date_pa)
								VALUES ('".$this->ref_article."', '".addslashes($ref_article_externe)."', '".addslashes($ref_fournisseur)."', '".addslashes($pa_unitaire)."', '".($date_pa)."') ";
			$bdd->exec ($query2);
		}
	}
	$this->maj_prix_achat_actuel_ht();
	return true;
}


/**
 * @param bool $isAchetable
 * @param bool $isVendable
 * @return int retourne le nombre de ligne mise à jour dans la table, devrait retourner 1 si tout c'est bien passé
 */
public function maj_restriction($isAchetable, $isVendable){
	global $bdd;
	
	$this->is_achetable = ($isAchetable)? true: false;
	$this->is_vendable = ($isVendable)? true: false;

	
	$query = "UPDATE articles SET 
					is_achetable =  '".(($this->is_achetable)? '1': '0')."',
					is_vendable =  '".(($this->is_vendable)? '1': '0')."'
				WHERE ref_article = '$this->ref_article' ;";
	echo $query;
	return $bdd->exec($query);
				
}

/**
 * @param bool $isAchetable
 * @return int retourne le nombre de ligne mise à jour dans la table, devrait retourner 1 si tout c'est bien passé
 */
public function maj_achetable($isAchetable){
	global $bdd;
	
	$this->is_achetable = ($isAchetable)? true: false;
	
	$query = "UPDATE articles SET 
					is_achetable =  '".(($this->is_achetable)? '1': '0')."'
				WHERE ref_article = '$this->ref_article' ;";
	echo $query;
	return $bdd->exec($query);
				
}

/**
 * @param bool $isVendable
 * @return int retourne le nombre de ligne mise à jour dans la table, devrait retourner 1 si tout c'est bien passé
 */
public function maj_vendable($isVendable){
	global $bdd;
	
	$this->is_vendable = ($isVendable)? true: false;
	
	$query = "UPDATE articles SET 
					is_vendable =  '".(($this->is_vendable)? '1': '0')."'
				WHERE ref_article = '$this->ref_article' ;";
	echo $query;
	return $bdd->exec($query);
				
}



// Suppression d'une ref_externe
public function del_ref_article_externe ($ref_fournisseur, $ref_article_externe) {
	global $bdd;
	$query = "DELETE FROM articles_ref_fournisseur
						WHERE ref_article = '".$this->ref_article."' && ref_fournisseur = '".addslashes($ref_fournisseur)."' && ref_article_externe = '".addslashes($ref_article_externe)."'";
	$bdd->exec ($query);
	$this->maj_prix_achat_actuel_ht();
	return true;
}

// Archivage du prix d'achat de l'article chez un fournisseur
public function add_articles_paf_archive($ref_fournisseur, $date_tarif, $pa_ht){
	global $bdd;
	
	$query = "SELECT * 
				FROM articles_paf_archive 
				WHERE ref_article = '" . $this->ref_article . "' AND ref_fournisseur = '" . $ref_fournisseur . "' 
					AND date_tarif = '" . $date_tarif . "' AND pa_ht = '" . $pa_ht . "';";
	$resultat = $bdd->query($query);
	if($resultat->rowCount()){
		return false;
	}
	$query = "INSERT INTO articles_paf_archive(ref_article, ref_fournisseur, date_tarif, pa_ht) 
				VALUES('" . $this->ref_article . "', '" . $ref_fournisseur . "', '" . $date_tarif . "', '" . $pa_ht . "')";
	$bdd->exec($query);
	unset($query, $resultat);
	return true;
}


// *************************************************************************************************************
// FONCTIONS DE GESTION DES LIAISONS
// *************************************************************************************************************
// Chargement des liaisons

public function charger_liaisons () {
	global $bdd;

	$this->liaisons = array();

	$query = "SELECT al.ref_article_lie, al.id_liaison_type, al.ratio, a.lib_article, alt.lib_liaison_type, alt.systeme, alt.ordre
						FROM articles_liaisons al
							LEFT JOIN articles a ON a.ref_article = al.ref_article_lie
							LEFT JOIN art_liaisons_types alt ON alt.id_liaison_type = al.id_liaison_type
						WHERE al.ref_article = '".$this->ref_article."'
						ORDER BY alt.ordre, a.lib_article ";
	$resultat = $bdd->query($query);
	while ($tmp = $resultat->fetchObject()) { $this->liaisons[] = $tmp; }
	$query = "SELECT al.ref_article, al.id_liaison_type, al.ratio, a.lib_article, alt.lib_liaison_type, alt.systeme, alt.ordre
						FROM articles_liaisons al
							LEFT JOIN articles a ON a.ref_article = al.ref_article
							LEFT JOIN art_liaisons_types alt ON alt.id_liaison_type = al.id_liaison_type
						WHERE al.ref_article_lie = '".$this->ref_article."' AND al.id_liaison_type=7
						ORDER BY alt.ordre, a.lib_article ";
	$resultat = $bdd->query($query);
	while ($tmp = $resultat->fetchObject()) { $this->liaisons[] = $tmp; }
	$this->liaisons_loaded = true;
	return true;
}

// Ajout d'une liaison
public function add_liaison ($ref_article_lie, $id_liaison_type, $ratio = "") {
	global $bdd;

	// *************************************************
	// Controle des données générales
	if (!is_numeric($id_liaison_type)) {
		$GLOBALS['_ALERTES']['bad_id_liaison_type'] = 1;
	}
	
	if (!$ratio) {$ratio = 1;}
	if (!is_numeric($ratio)) {$ratio = 1;}
	
	$query = "SELECT ref_article
						FROM articles
						WHERE ref_article = '".$ref_article_lie."'
						LIMIT 0,1";
	$resultat = $bdd->query($query);
	if (!$tmp = $resultat->fetchObject()) {
		$GLOBALS['_ALERTES']['not_exist_ref_article_lie'] = $ref_article_lie;
	}

	// *************************************************
	// Si les valeurs reçues sont incorrectes
	if (count($GLOBALS['_ALERTES'])) {
		return false;
	}

	// Insertion dans la BDD
	$query = "INSERT INTO articles_liaisons (ref_article, ref_article_lie, id_liaison_type, ratio)
						VALUES ('".$this->ref_article."', '".addslashes($ref_article_lie)."', '".$id_liaison_type."', '".$ratio."')";
	$bdd->exec ($query);

	// *************************************************
	// Modification dans la base de la date de modification
	$query = "UPDATE articles
						SET date_modification = NOW()
						WHERE ref_article = '".$this->ref_article."' ";
	$bdd->exec ($query);

	return true;
}

// Modification d'une liaison
public function maj_liaison ($ref_article_lie, $id_type_liaison, $ratio = 1) {
	global $bdd;

	// *************************************************
	// Controle des données générales
	if (!is_numeric($id_type_liaison)) {
		$GLOBALS['_ALERTES']['bad_id_liaison_type'] = 1;
	}

	// *************************************************
	// Si les valeurs reçues sont incorrectes
	if (count($GLOBALS['_ALERTES'])) {
		return false;
	}

	// Modification
	$query = "UPDATE articles_liaisons SET id_liaison_type = '".$id_type_liaison."', ratio = '".$ratio."'
						WHERE ref_article = '".$this->ref_article."' && ref_article_lie = '".addslashes($ref_article_lie)."' ";
	$bdd->exec ($query);

	// *************************************************
	// Modification dans la base de la date de modification
	$query = "UPDATE articles
						SET date_modification = NOW()
						WHERE ref_article = '".$this->ref_article."' ";
	$bdd->exec ($query);

	return true;
}


// Suppression d'une liaison
public function del_liaison ($ref_article_lie, $id_liaison_type) {
	global $bdd;

	$query = "DELETE FROM articles_liaisons
						WHERE ( (	ref_article = '".$this->ref_article."' && ref_article_lie = '".$ref_article_lie."' ) ||
									  (	ref_article = '".$ref_article_lie."'   && ref_article_lie = '".$this->ref_article."')		 ) &&
									id_liaison_type = ".$id_liaison_type." ";
	$bdd->exec ($query);

	// *************************************************
	// Modification dans la base de la date de modification
	$query = "UPDATE articles
						SET date_modification = NOW()
						WHERE ref_article = '".$this->ref_article."' ";
	$bdd->exec ($query);

	return true;
}

// Supprimer toutes les liaisons
public function del_all_liaisons () {
	global $bdd;
	$query = "DELETE FROM articles_liaisons
						WHERE ref_article = '".$this->ref_article."' ";
	$bdd->exec ($query);
	return true;
}

//
final function getRef_art_lie($vals_choix, $ref_caracs){
	global $bdd;
	$query = "SELECT al.ref_article_lie 
				FROM articles_liaisons al ";
	foreach($vals_choix as $key_choix=>$value_choix){
		$query .= "	JOIN articles_caracs ac" . $key_choix . " ON (ac" . $key_choix . ".ref_article = al.ref_article_lie 
						AND ac" . $key_choix . ".ref_carac = '" . $ref_caracs[$key_choix] . "' 
						AND ac" . $key_choix . ".valeur = '" . $value_choix . "') ";
	}
	$query .= "	WHERE al.ref_article = '" . $this->ref_article . "';";
	$resultat = $bdd->query($query);
	if(!$tmp = $resultat->fetchObject()){
		return false;
	}
	return $tmp->ref_article_lie;
}
// ****************************************************************************
// FONCTIONS DE GESTION DES LIAISONS																			FIN *
// ****************************************************************************



// *************************************************************************************************************
// FONCTIONS DE GESTION DES ALERTES DE STOCK
// *************************************************************************************************************
public function charger_stocks_alertes () {
	global $bdd;

	$this->stocks_alertes = array();
	$query = "SELECT id_stock, seuil_alerte, emplacement 
				FROM articles_stocks_alertes
				WHERE ref_article = '".$this->ref_article."';";
	$resultat = $bdd->query ($query);
	while ($var = $resultat->fetchObject()) { 
		$this->stocks_alertes[] = $var;
		$this->emplacements[$var->id_stock] = $var->emplacement;
	}

	$this->stocks_alertes_loaded = true;
	return true;
}


public function add_stock_alerte ($id_stock, $seuil_alerte) {
	global $bdd;

	// *************************************************
	// Controle des données générales
	if (!is_numeric($id_stock)) {
		$GLOBALS['_ALERTES']['bad_id_stock'] = 1;
	}
	if (!is_numeric($seuil_alerte)) {
		$GLOBALS['_ALERTES']['bad_seuil_alerte'] = 1;
	}

	// *************************************************
	// Si les valeurs reçues sont incorrectes
	if (count($GLOBALS['_ALERTES'])) {
		return false;
	}

	// Insertion dans la BDD
	$query = "SELECT * 
				FROM articles_stocks_alertes 
				WHERE ref_article = '" . $this->ref_article . "' 
					AND id_stock = '" . $id_stock . "';";
	$res = $bdd->query($query);
	unset($query);
	if($res->rowCount()){
		$query = "UPDATE articles_stocks_alertes 
					SET seuil_alerte = '" . $seuil_alerte . "' 
					WHERE ref_article = '" . $this->ref_article . "' 
					AND id_stock = '" . $id_stock . "';";
	}else{
		$query = "INSERT INTO articles_stocks_alertes(ref_article, id_stock, seuil_alerte) 
					VALUES('" . $this->ref_article . "', '" . $id_stock . "', '" . $seuil_alerte . "');";
	}
	$bdd->exec ($query);

	return true;
}

public function add_emplacement_stock ($id_stock, $emplacement) {
	global $bdd;

	// *************************************************
	// Controle des données générales
	if (!is_numeric($id_stock)) {
		$GLOBALS['_ALERTES']['bad_id_stock'] = 1;
	}

	// *************************************************
	// Si les valeurs reçues sont incorrectes
	if (count($GLOBALS['_ALERTES'])) {
		return false;
	}
	
	// Insertion dans la BDD
	$query = "SELECT * 
				FROM articles_stocks_alertes 
				WHERE ref_article = '" . $this->ref_article . "' 
					AND id_stock = '" . $id_stock . "';";
	$res = $bdd->query($query);
	unset($query);
	if($res->rowCount()){
		$query = "UPDATE articles_stocks_alertes 
					SET emplacement = '" . $emplacement . "' 
					WHERE ref_article = '" . $this->ref_article . "' 
					AND id_stock = '" . $id_stock . "';";
	}else{
		$query = "INSERT INTO articles_stocks_alertes(ref_article, id_stock, emplacement) 
					VALUES('" . $this->ref_article . "', '" . $id_stock . "', '" . $emplacement . "');";
	}
	$bdd->exec ($query);

	return true;
}

public function delete_stock_alerte ($id_stock) {
	global $bdd;

	$query = "DELETE FROM articles_stocks_alertes
						WHERE ref_article = '".$this->ref_article."' && id_stock = '".$id_stock."' ";
	$bdd->exec ($query);

	return true;
}

public function charger_stocks () {
	global $bdd;

	// Sélection des stocks disponibles
	$this->stocks = array();
	$query = "SELECT id_stock, qte
						FROM stocks_articles
						WHERE ref_article = '".$this->ref_article."' ";
	$resultat = $bdd->query ($query);
	while ($var = $resultat->fetchObject()) { $this->stocks[$var->id_stock] = $var; }

	// Sélection des stocks réservés (CDC "en cours")
	$this->stocks_rsv = array();
	$query = "SELECT SUM(dl.qte) qte, SUM(dlc.qte_livree) qte_livree, id_stock
						FROM docs_lines dl
							LEFT JOIN doc_lines_cdc dlc ON dl.ref_doc_line = dlc.ref_doc_line
							LEFT JOIN documents d ON d.ref_doc = dl.ref_doc
							LEFT JOIN doc_cdc dc ON d.ref_doc = dc.ref_doc
						WHERE dl.ref_article = '".$this->ref_article."' && d.id_etat_doc = 9
						GROUP BY dc.id_stock ";
	$resultat = $bdd->query ($query);
	while ($var = $resultat->fetchObject()) { $this->stocks_rsv[$var->id_stock] = $var; }

	// Sélection des réappro en cours
	$this->stocks_cdf = array();
	$query = "SELECT SUM(dl.qte) qte, SUM(dlf.qte_recue) qte_recue, id_stock,
									 MIN(dc.date_livraison) date_livraison
						FROM docs_lines dl
							LEFT JOIN doc_lines_cdf dlf ON dl.ref_doc_line = dlf.ref_doc_line
							LEFT JOIN documents d ON d.ref_doc = dl.ref_doc
							LEFT JOIN doc_cdf dc ON d.ref_doc = dc.ref_doc
						WHERE dl.ref_article = '".$this->ref_article."' && d.id_etat_doc = 27
						GROUP BY dc.id_stock";
	$resultat = $bdd->query ($query);
	while ($var = $resultat->fetchObject()) { $this->stocks_cdf[$var->id_stock] = $var; }

	//qté des articles composant permettant la fabrication de l'article
	$this->stocks_tofab = array();
		if (!$this->composants_loaded) {$this->charger_composants ();}
		foreach ($this->composants as $composant) {
			$query = "SELECT id_stock, qte as qte_stock
								FROM stocks_articles
								WHERE ref_article = '".$composant->ref_article_composant."' ";
			$resultat = $bdd->query ($query);
			while ($var = $resultat->fetchObject()) { $this->stocks_tofab[$var->id_stock][$composant->ref_lot_contenu] = $var; }

	}


	//qté sn
	$this->stocks_arti_sn = array();
			$query = "SELECT sa.ref_stock_article, id_stock, qte as qte_stock
								FROM stocks_articles  sa
								LEFT JOIN stocks_articles_sn sas ON sas.ref_stock_article = sa.ref_stock_article
								WHERE ref_article = '".$this->ref_article."' ";
			$resultat = $bdd->query ($query);
			while ($var = $resultat->fetchObject()) {
			$var->sn = array();
			$query_sn = "SELECT DISTINCT SUM(sn_qte) as cpt_sn, numero_serie
								FROM stocks_articles_sn
								WHERE ref_stock_article = '".$var->ref_stock_article."'
								GROUP BY numero_serie  ";
			$resultat_sn = $bdd->query ($query_sn);
			while ($var_sn = $resultat_sn->fetchObject()) {
				$var->sn[$var_sn->numero_serie] = $var_sn->cpt_sn;
			}
			$this->stocks_arti_sn[$var->id_stock] = $var;
			}

	$this->stocks_loaded = true;
	return true;
}


public function charger_stocks_moves ($id_stock = "") {
	global $bdd;
	global $ARTICLE_NB_LAST_STOCK_MOVE_SHOWED;
	global $INVENTAIRE_ID_TYPE_DOC;

	$where = "";
	if ($id_stock) { $where =  "&& sm.id_stock = '".$id_stock."' "; }

	// Sélection des mouvements stocks
	$this->stocks_moves = array();
	$query = "SELECT sm.ref_stock_move, sm.id_stock, s.lib_stock, s.abrev_stock, sm.qte, sm.date, sm.ref_doc, d.id_etat_doc, d.id_type_doc, de.lib_etat_doc,
										a.ref_contact, a.nom,
										c.nom as nom_contact_doc,
										c.ref_contact as ref_contact_doc
						FROM stocks_moves sm
							LEFT JOIN documents d ON d.ref_doc = sm.ref_doc
							LEFT JOIN stocks s ON s.id_stock = sm.id_stock
							LEFT JOIN documents_etats de ON d.id_etat_doc = de.id_etat_doc
							LEFT JOIN documents_events dev ON d.ref_doc = dev.ref_doc
							LEFT JOIN users u ON u.ref_user = dev.ref_user
							LEFT JOIN annuaire a ON u.ref_contact = a.ref_contact
							LEFT JOIN annuaire c ON c.ref_contact = d.ref_contact
						WHERE ref_article = '".$this->ref_article."' && d.id_type_doc != ".$INVENTAIRE_ID_TYPE_DOC."  ".$where."
						GROUP BY sm.ref_stock_move
						ORDER BY sm.ref_stock_move DESC
						LIMIT 0, ".$ARTICLE_NB_LAST_STOCK_MOVE_SHOWED." ";
	$resultat = $bdd->query ($query);
	while ($var = $resultat->fetchObject()) { $this->stocks_moves[] = $var; }

	return  $this->stocks_moves;
}


//chargemant cette article est il en stock
protected function is_article_in_stock () {
	global $bdd;

	$this->is_in_stock = false;

	//Calcul du stock actuel tout stock confondus
	if (!$this->stocks_loaded) {$this->charger_stocks ();}
	$sun_stock = 0;
	foreach ($_SESSION["stocks"] as $id_stock=>$stock_obj) {
		if (isset($this->stocks[$id_stock]->qte)) {$sun_stock += $this->stocks[$id_stock]->qte;}
	}
	if ($sun_stock > 0) {$this->is_in_stock = true;}

	return true;
}

// *************************************************************************************************************
// FONCTIONS DE GESTION DES CODES BARRES
// *************************************************************************************************************
public function charger_codes_barres () {
	global $bdd;

	$this->codes_barres = array();
	$query = "SELECT code_barre FROM articles_codes_barres
						WHERE ref_article = '".$this->ref_article."' ";
	$resultat = $bdd->query ($query);
	while ($var = $resultat->fetchObject()) { $this->codes_barres[] = $var; }

	$this->codes_barres_loaded = true;
	return true;
}


public function delete_code_barre ($code_barre) {
	global $bdd;

	$query = "DELETE FROM articles_codes_barres
						WHERE ref_article = '".$this->ref_article."' && code_barre = '".$code_barre."' ";
	$bdd->exec ($query);

	return true;
}

public function add_code_barre ($code_barre) {
	global $bdd;

	$code_barre = trim ($code_barre);
	$code_barre = str_replace("'", "", $code_barre);
	$code_barre = str_replace("\"", "", $code_barre);
	$code_barre = str_replace("`", "", $code_barre);

	if (!$code_barre) {
		$GLOBALS['_ALERTES']['code_barre_vide'] = 1;
		return false;
	}

	// Vérification que le code barre n'est pas utilisé ailleurs
	$query = "SELECT ref_article FROM articles_codes_barres
						WHERE code_barre = '".$code_barre."' ";
	$resultat = $bdd->query ($query);
	// Controle si un code barre est trouvé
	if ($article = $resultat->fetchObject()) {
		$GLOBALS['_ALERTES']['code_barre_exist'] = $article->ref_article;
		return false;
	}

	// Insertion
	$query = "INSERT INTO articles_codes_barres (ref_article, code_barre)
						VALUES ('".$this->ref_article."', '".$code_barre."') ";
	$bdd->exec ($query);

	return true;
}




// *************************************************************************************************************
// FONCTIONS DIVERSES
// *************************************************************************************************************
//Verifie la disponibilité de l'article, en fonction des dates de dispo, et du stock
function check_dispo () {
	if (strtotime($this->date_fin_dispo) && (time() < strtotime($this->date_debut_dispo) || time() >= strtotime($this->date_fin_dispo)) && !(stock::still_in_stock ($this->ref_article)) ) {
		//liaison edi
		if($this->dispo == 1){
			edi_event(119,$this->ref_article);
		}
		
		$this->dispo = 0;
		return false;
	}

	if($this->dispo == 0){
		if(!empty($this->ref_article)){
			edi_event(111,$this->ref_art_categ,$this->ref_article);
		}
	}
		
	$this->dispo = 1;
	return true;
}

// Retourne la valeur d'un nombre la plus proche, compatible avec valo_indice
function round_qte($qte) {
	$retour = round(($qte / $this->valo_indice), 0) * $this->valo_indice ;
	return $retour;
}


// Chargement des derniers documents ayant intégré cet article
function charger_last_docs () {
	global $bdd;
	global $ARTICLE_NB_LAST_DOCS_SHOWED;

	$this->last_docs = array();
	$query = "SELECT dl.ref_doc, a.nom nom_contact, d.date_creation_doc date_creation, dt.id_type_doc, dt.lib_type_doc, dt.id_type_groupe, de.lib_etat_doc,
									 SUM(dl.qte) as qte
						FROM docs_lines dl
							LEFT JOIN documents d ON d.ref_doc = dl.ref_doc
							LEFT JOIN annuaire a ON d.ref_contact = a.ref_contact
							LEFT JOIN documents_types dt ON d.id_type_doc = dt.id_type_doc
							LEFT JOIN documents_etats de ON d.id_etat_doc = de.id_etat_doc
						WHERE dl.ref_article = '".$this->ref_article."' && d.id_etat_doc NOT IN (2,7,12,17,21,26,30,33,37,43,45,48,53)
						GROUP BY d.ref_doc
						ORDER BY date_creation DESC, d.id_type_doc ASC
						LIMIT 0,".$ARTICLE_NB_LAST_DOCS_SHOWED;
	$resultat = $bdd->query ($query);
	while ($doc = $resultat->fetchObject()) {
		$this->last_docs[] = $doc;
	}

	$this->last_docs_loaded = true;
	return true;
}


// Envoi de la fiche article par email
public function mail_article ($to , $sujet , $message, $fiche_content) {
	global $bdd;


	//on récupère l'email de l'utilisateur en cours pour envoyer le mail
	$reply 			= $_SESSION['user']->getEmail();
	$from 			= $_SESSION['user']->getEmail();

	if (mail_html_message ($to , $sujet , $message."\n\n".$fiche_content , $reply , $from)) {
		return true;
	} else {
		return false;
	}
}

//chargement de l'évolution des prix sur 12 mois
function charger_pv_paa_pa_histo () {
	global $bdd;

	$id_tarif = "0";
	if (isset($_SESSION['tarifs_listes'][0])) { $id_tarif = $_SESSION['tarifs_listes'][0]->id_tarif;}
	$liste_histo = array();
	$liste_histo["pv"] = array();
	$liste_histo["pa"] = array();
	$liste_histo["paa"] = array();

	$query = "SELECT ref_article, date_maj, id_tarif, pu_ht
						FROM articles_pv_archive
						WHERE ref_article = '".$this->ref_article."' && date_maj >'".date("Y-m-d H:i:s", mktime(0,0,0, date("m")-12, date("d"), date("Y")))."' && id_tarif = '".$id_tarif."'
						ORDER BY date_maj DESC ";
	$resultat = $bdd->query ($query);
	while ($tmp = $resultat->fetchObject()) {
		$liste_histo["pv"][] = $tmp;
	}
	unset($query, $tmp, $resultat);


	$query = "SELECT ref_article, date_maj, prix_achat_ht
						FROM articles_pa_archive
						WHERE ref_article = '".$this->ref_article."' && date_maj >'".date("Y-m-d H:i:s", mktime(0,0,0, date("m")-12, date("d"), date("Y")))."'
						ORDER BY date_maj DESC ";
	$resultat = $bdd->query ($query);
	while ($tmp = $resultat->fetchObject()) {
		$liste_histo["pa"][] = $tmp;
	}
	unset($query, $tmp, $resultat);

	return $liste_histo;
}

//chargement des stats de souscription des articles par abonnement
function charger_article_abo_stats () {
	global $bdd;


	$liste_abo["abonnes_12"] = array();
	$liste_abo["souscription_12"] = array();

	//evolution mois par mois des souscriptions
	for ($i=11; $i>=0; $i--) {
		$date_min = date("Y-m-d H:i:s", mktime(0, 0, 0, date("m")-$i, 1, date("Y")));
		$date_max = date("Y-m-d H:i:s", mktime(0, 0, 0, date("m")+(1-$i), 1, date("Y")));

		$nb_abo = 0;
		$query = "SELECT COUNT(id_abo) as ns_souscription
							FROM  articles_abonnes aa
							WHERE aa.ref_article = '".$this->ref_article."'
										&& date_souscription < '".$date_max."' && date_souscription >= '".$date_min."'
							";
		$resultat = $bdd->query ($query);
		if ($art = $resultat->fetchObject()) {
			$nb_abo = $art->ns_souscription;
		}
		$liste_abo["souscription_12"][$i] = $nb_abo;
	}
	//evolution du nombre d'abonnés
	for ($i=11; $i>=0; $i--) {
		$date_min = date("Y-m-d H:i:s", mktime(0, 0, 0, date("m")-$i, 1, date("Y")));
		$date_max = date("Y-m-d H:i:s", mktime(0, 0, 0, date("m")+(1-$i), 1, date("Y")));

		$nb_abo = 0;
		$query = "SELECT COUNT(id_abo) as ns_abo
							FROM  articles_abonnes aa
							WHERE aa.ref_article = '".$this->ref_article."'
										&& ( date_souscription < '".$date_max."' && date_echeance >= '".$date_min."' )
							";
		$resultat = $bdd->query ($query);
		if ($art = $resultat->fetchObject()) {
			$nb_abo = $art->ns_abo;
		}
		$liste_abo["abonnes_12"][$i] = $nb_abo;
	}
	return $liste_abo;

}
//chargement des stats des articles à la consommation
function charger_article_conso_stats () {
	global $bdd;


	$liste_abo["abonnes_12"] = array();
	$liste_abo["consomme_12"] = array();

	//evolution mois par mois des souscriptions
	for ($i=11; $i>=0; $i--) {
		$date_min = date("Y-m-d H:i:s", mktime(0, 0, 0, date("m")-$i, 1, date("Y")));
		$date_max = date("Y-m-d H:i:s", mktime(0, 0, 0, date("m")+(1-$i), 1, date("Y")));

		$nb_abo = 0;
		$query = "SELECT COUNT(id_compte_credit) as ns_souscription
							FROM  articles_comptes_credits acc
							WHERE acc.ref_article = '".$this->ref_article."'
										&& date_souscription < '".$date_max."' && date_souscription >= '".$date_min."'
							";
		$resultat = $bdd->query ($query);
		if ($art = $resultat->fetchObject()) {
			$nb_abo = $art->ns_souscription;
		}
		$liste_abo["abonnes_12"][$i] = $nb_abo;
	}
	//evolution des consommations
	for ($i=11; $i>=0; $i--) {
		$date_min = date("Y-m-d H:i:s", mktime(0, 0, 0, date("m")-$i, 1, date("Y")));
		$date_max = date("Y-m-d H:i:s", mktime(0, 0, 0, date("m")+(1-$i), 1, date("Y")));

		$nb_abo = 0;
		$query = "SELECT SUM(credit_used) as ns_abo
							FROM  articles_comptes_credits_consos accc
							WHERE date_conso < '".$date_max."' && date_conso >= '".$date_min."'
							";
		$resultat = $bdd->query ($query);
		if ($art = $resultat->fetchObject()) {
			$nb_abo = $art->ns_abo;
		}
		$liste_abo["consomme_12"][$i] = $nb_abo;
	}
	return $liste_abo;

}
//chargement du CA de l'article
function charger_article_CA () {
	global $bdd;

	$last_exercices = compta_exercices::charger_compta_exercices ();
	$liste_CA = array();
	$liste_CA["ventes"] = array();
	$liste_CA["achats"] = array();
	$liste_CA["ventes_tri"] = array();
	$liste_CA["achats_tri"] = array();
	$liste_CA["ventes_30"] = array();
	$liste_CA["ventes_12"] = array();
	$liste_CA["stock_total"] = 0;
	$liste_CA["rotation_stock_30"] = 0;
	$liste_CA["rotation_stock_12"] = 0;

	for ($i = 0; $i < 3 ; $i++) {
		//CA des ventes
		$montant_CA = 0;
		if (!isset($last_exercices[$i])) { break;}
		$query = "SELECT SUM(ROUND(dl.qte * dl.pu_ht * (1-dl.remise/100) ,2)) as montant_ttc
							FROM  docs_lines dl
								LEFT JOIN documents d ON dl.ref_doc = d.ref_doc
								LEFT JOIN articles a ON a.ref_article = dl.ref_article
								LEFT JOIN documents_types dt ON d.id_type_doc = dt.id_type_doc
								LEFT JOIN documents_etats de ON d.id_etat_doc = de.id_etat_doc
							WHERE dl.ref_article = '".$this->ref_article."' && dl.ref_doc_line_parent IS NULL && d.id_etat_doc IN (16,18,19)
										&& dl.visible = 1
										&& date_creation_doc < '".$last_exercices[$i]->date_fin."' && date_creation_doc >= '".$last_exercices[$i]->date_debut."'
							GROUP BY dl.ref_article
							ORDER BY date_creation_doc DESC, d.id_type_doc ASC
							";
		$resultat = $bdd->query ($query);
		while ($art = $resultat->fetchObject()) {
			$montant_CA += $art->montant_ttc;
		}
		$liste_CA["ventes"][$i] = $montant_CA;

		//CA des achats
		$montant_CA = 0;
		$query = "SELECT SUM(ROUND(dl.qte * dl.pu_ht * (1-dl.remise/100) ,2)) as montant_ttc
							FROM  docs_lines dl
								LEFT JOIN documents d ON dl.ref_doc = d.ref_doc
								LEFT JOIN articles a ON a.ref_article = dl.ref_article
								LEFT JOIN documents_types dt ON d.id_type_doc = dt.id_type_doc
								LEFT JOIN documents_etats de ON d.id_etat_doc = de.id_etat_doc
							WHERE dl.ref_article = '".$this->ref_article."' && dl.ref_doc_line_parent IS NULL && d.id_etat_doc IN (32,34,35)
										&& dl.visible = 1
										&& date_creation_doc < '".$last_exercices[$i]->date_fin."' && date_creation_doc >= '".$last_exercices[$i]->date_debut."'
							GROUP BY dl.ref_article
							ORDER BY date_creation_doc DESC, d.id_type_doc ASC
							";
		$resultat = $bdd->query ($query);
		while ($art = $resultat->fetchObject()) {
			$montant_CA += $art->montant_ttc;
		}
		$liste_CA["achats"][$i] = $montant_CA;


	}

	//achats et ventes du trimestre
	for ($i = 0; $i < 3 ; $i++) {
		$date_min = date("Y-m-d H:i:s", mktime(0, 0, 0, date("m")-$i, 1, date("Y")));
		$date_max = date("Y-m-d H:i:s", mktime(0, 0, 0, date("m")+(1-$i), 1, date("Y")));
		//CA des ventes du trimestre
		$montant_CA = 0;
		$query = "SELECT SUM(ROUND(dl.qte * dl.pu_ht * (1-dl.remise/100) ,2)) as montant_ttc
							FROM  docs_lines dl
								LEFT JOIN documents d ON dl.ref_doc = d.ref_doc
								LEFT JOIN articles a ON a.ref_article = dl.ref_article
								LEFT JOIN documents_types dt ON d.id_type_doc = dt.id_type_doc
								LEFT JOIN documents_etats de ON d.id_etat_doc = de.id_etat_doc
							WHERE dl.ref_article = '".$this->ref_article."' && dl.ref_doc_line_parent IS NULL && d.id_etat_doc IN (16,18,19)
										&& dl.visible = 1
										&& date_creation_doc < '".$date_max."' && date_creation_doc >= '".$date_min."'
							GROUP BY dl.ref_article
							ORDER BY date_creation_doc DESC, d.id_type_doc ASC
							";
		$resultat = $bdd->query ($query);
		while ($art = $resultat->fetchObject()) {
			$montant_CA += $art->montant_ttc;
		}
		$liste_CA["ventes_tri"][$i] = $montant_CA;

		//CA des achats du trimestre
		$montant_CA = 0;
		$query = "SELECT SUM(ROUND(dl.qte * dl.pu_ht * (1-dl.remise/100) ,2)) as montant_ttc
							FROM  docs_lines dl
								LEFT JOIN documents d ON dl.ref_doc = d.ref_doc
								LEFT JOIN articles a ON a.ref_article = dl.ref_article
								LEFT JOIN documents_types dt ON d.id_type_doc = dt.id_type_doc
								LEFT JOIN documents_etats de ON d.id_etat_doc = de.id_etat_doc
							WHERE dl.ref_article = '".$this->ref_article."' && dl.ref_doc_line_parent IS NULL && d.id_etat_doc IN (32,34,35)
										&& dl.visible = 1
										&& date_creation_doc < '".$date_max."' && date_creation_doc >= '".$date_min."'
							GROUP BY dl.ref_article
							ORDER BY date_creation_doc DESC, d.id_type_doc ASC
							";
		$resultat = $bdd->query ($query);
		while ($art = $resultat->fetchObject()) {
			$montant_CA += $art->montant_ttc;
		}
		$liste_CA["achats_tri"][$i] = $montant_CA;


	}



	// ventes a 30 jours
	for ($i=29; $i>=0; $i--) {
		$date_min = date("Y-m-d H:i:s", mktime(0, 0, 0, date("m"), date("d")-$i, date("Y")));
		$date_max = date("Y-m-d H:i:s", mktime(0, 0, 0, date("m"), date("d")+(1-$i), date("Y")));
		//CA des ventes du trimestre
		$montant_CA = 0;
		$query = "SELECT SUM(ROUND(dl.qte * dl.pu_ht * (1-dl.remise/100) ,2)) as montant_ttc
							FROM  docs_lines dl
								LEFT JOIN documents d ON dl.ref_doc = d.ref_doc
								LEFT JOIN articles a ON a.ref_article = dl.ref_article
								LEFT JOIN documents_types dt ON d.id_type_doc = dt.id_type_doc
								LEFT JOIN documents_etats de ON d.id_etat_doc = de.id_etat_doc
							WHERE dl.ref_article = '".$this->ref_article."' && dl.ref_doc_line_parent IS NULL && d.id_etat_doc IN (16,18,19)
										&& dl.visible = 1
										&& date_creation_doc < '".$date_max."' && date_creation_doc >= '".$date_min."'
							GROUP BY dl.ref_article
							ORDER BY date_creation_doc DESC, d.id_type_doc ASC
							";
		$resultat = $bdd->query ($query);
		while ($art = $resultat->fetchObject()) {
			$montant_CA += $art->montant_ttc;
		}
		$liste_CA["ventes_30"][$i] = $montant_CA;



	}



	// ventes a 12 mois
	for ($i=11; $i>=0; $i--) {
		$date_min = date("Y-m-d H:i:s", mktime(0, 0, 0, date("m")-$i, 1, date("Y")));
		$date_max = date("Y-m-d H:i:s", mktime(0, 0, 0, date("m")+(1-$i), 1, date("Y")));
		//CA des ventes du trimestre
		$montant_CA = 0;
		$query = "SELECT SUM(ROUND(dl.qte * dl.pu_ht * (1-dl.remise/100) ,2)) as montant_ttc
							FROM  docs_lines dl
								LEFT JOIN documents d ON dl.ref_doc = d.ref_doc
								LEFT JOIN articles a ON a.ref_article = dl.ref_article
								LEFT JOIN documents_types dt ON d.id_type_doc = dt.id_type_doc
								LEFT JOIN documents_etats de ON d.id_etat_doc = de.id_etat_doc
							WHERE dl.ref_article = '".$this->ref_article."' && dl.ref_doc_line_parent IS NULL && d.id_etat_doc IN (16,18,19)
										&& dl.visible = 1
										&& date_creation_doc < '".$date_max."' && date_creation_doc >= '".$date_min."'
							GROUP BY dl.ref_article
							ORDER BY date_creation_doc DESC, d.id_type_doc ASC
							";
		$resultat = $bdd->query ($query);
		while ($art = $resultat->fetchObject()) {
			$montant_CA += $art->montant_ttc;
		}
		$liste_CA["ventes_12"][$i] = $montant_CA;
	}


	//Calcul du stock actuel tout stock confondus
	if (!$this->stocks_loaded) {$this->charger_stocks ();}
	$liste_CA["stock_total"] = 0;
	foreach ($_SESSION["stocks"] as $id_stock=>$stock_obj) {
		if (isset($this->stocks[$id_stock]->qte)) {$liste_CA["stock_total"] += $this->stocks[$id_stock]->qte;}
	}


	// stocks sortis sur 30 jours
	$liste_CA["rotation_stock_30"] = 0;

		$date_min = date("Y-m-d H:i:s", mktime(0, 0, 0, date("m"), date("d")-30, date("Y")));
		$date_max = date("Y-m-d H:i:s", mktime(23, 59, 59, date("m"), date("d"), date("Y")));
	$query = "SELECT SUM(dl.qte) qte
						FROM docs_lines dl
							LEFT JOIN doc_lines_cdc dlc ON dl.ref_doc_line = dlc.ref_doc_line
							LEFT JOIN documents d ON d.ref_doc = dl.ref_doc
							LEFT JOIN doc_cdc dc ON d.ref_doc = dc.ref_doc
						WHERE dl.ref_article = '".$this->ref_article."' && d.id_etat_doc IN (14,15,50,51)
										&& date_creation_doc < '".$date_max."' && date_creation_doc >= '".$date_min."'
						 ";
	$resultat = $bdd->query ($query);
	while ($var = $resultat->fetchObject()) { $liste_CA["rotation_stock_30"] += $var->qte; }

	// stocks sortis sur 12 mois
	$liste_CA["rotation_stock_12"] = 0;

		$date_min = date("Y-m-d H:i:s", mktime(0, 0, 0, date("m")-12, date("d"), date("Y")));
		$date_max = date("Y-m-d H:i:s", mktime(23, 59, 59, date("m"), date("d"), date("Y")));
	$query = "SELECT SUM(dl.qte) qte
						FROM docs_lines dl
							LEFT JOIN doc_lines_cdc dlc ON dl.ref_doc_line = dlc.ref_doc_line
							LEFT JOIN documents d ON d.ref_doc = dl.ref_doc
							LEFT JOIN doc_cdc dc ON d.ref_doc = dc.ref_doc
						WHERE dl.ref_article = '".$this->ref_article."' && d.id_etat_doc IN (14,15,50,51)
										&& date_creation_doc < '".$date_max."' && date_creation_doc >= '".$date_min."'
						 ";
	$resultat = $bdd->query ($query);
	while ($var = $resultat->fetchObject()) { $liste_CA["rotation_stock_12"] += $var->qte; }

	return $liste_CA;
}



// *************************************************************************************************************
// FONCTIONS DE LECTURE DES DONNEES
// *************************************************************************************************************

function getRef_article () {
	return $this->ref_article;
}

function getRef_eom () {
	return $this->ref_oem;
}

function getRef_interne () {
	return $this->ref_interne;
}

function getLib_article () {
	return $this->lib_article;
}

function getLib_ticket () {
	return $this->lib_ticket;
}

function getDesc_courte () {
	return $this->desc_courte;
}

function getDesc_longue () {
	return $this->desc_longue;
}

function getRef_constructeur () {
	return $this->ref_constructeur;
}

function getNom_constructeur () {
	return $this->nom_constructeur;
}

function getPrix_public_ht () {
	return $this->prix_public_ht;
}

function getId_valo () {
	return $this->id_valo;
}

function getValo_indice () {
	return $this->valo_indice;
}

function getLot () {
	return $this->lot;
}

function getGestion_sn () {
	return $this->gestion_sn;
}

function getCode_barre () {
	return $this->code_barre;
}

function getComposant () {
	return $this->composant;
}

function getVariante () {
	return $this->variante;
}

function getVariante_master () {
	return $this->variante_master;
}

function getVariante_slaves () {
	return $this->variante_slaves;
}

function getDate_debut_dispo () {
	return $this->date_debut_dispo;
}

function getDate_fin_dispo () {
	return $this->date_fin_dispo;
}

function getDispo () {
	return $this->dispo;
}

function getDate_creation () {
	return $this->date_creation;
}

function getDate_modification () {
	return $this->date_modification;
}

function getRef_art_categ () {
	return $this->ref_art_categ;
}

function getLib_art_categ () {
	return $this->lib_art_categ;
}

function getModele () {
	return $this->modele;
}

function getId_modele_spe () {
	return $this->id_modele_spe;
}

function getLib_modele_spe () {
	return $this->lib_modele_spe;
}



// Données spécialisées MATERIEL
function getPoids () {
	return $this->poids;
}

function getColisage () {
	return $this->colisage;
}

function getDuree_garantie () {
	return $this->duree_garantie;
}

// Données spécialisées SERVICES ABO
function getDuree () {
	return $this->duree;
}

function getEngagement () {
	return $this->engagement;
}

function getReconduction () {
	return $this->reconduction;
}

function getPreavis () {
	return $this->preavis;
}

// Données spécialisées SERVICES A LA CONSO
function getDuree_validite () {
	return $this->duree_validite;
}

function getNb_credits () {
	return $this->nb_credits;
}


// Données complémentaires

function getImages () {
	if (!$this->images_loaded) { $this->charger_images(); }
	return $this->images;
}

function getComposants () {
	if (!$this->composants_loaded) { $this->charger_composants(); }
	return $this->composants;
}

function getCaracs () {
	if (!$this->caracs_loaded) { $this->charger_caracs(); }
	return $this->caracs;
}

function getCaracs_variantes() {
    global $bdd;
    $query = "SELECT ac.ref_carac, acc.lib_carac, acc.unite, a.ref_art_categ
                FROM articles a
                        JOIN articles_caracs ac ON a.ref_article = ac.ref_article
                        JOIN art_categs_caracs acc ON acc.ref_carac = ac.ref_carac
                WHERE a.ref_article = '" . $this->ref_article . "'
                AND acc.variante = '1'
                ORDER BY acc.ordre;";
    $resultat = $bdd->query($query);
    $caracs = array();
    while($tmp = $resultat->fetchObject()){
            $caracs[] = $tmp;
    }
    return $caracs;
}

function getCaracs_groupes () {
	if (!$this->caracs_groupes_loaded) { $this->charger_caracs_groupes(); }
	return $this->caracs_groupes;
}

function getRef_externes () {
	if (!$this->ref_externes_loaded) { $this->charger_ref_externes(); }
	return $this->ref_externes;
}

//exemple : 
//$this->liaisons[n] = object(stdClass)(7) {
//    ["ref_article"]=> string(14) "A-000000-00003"
//    ["id_liaison_type"]=> string(1) "7"
//    ["ratio"]=> string(1) "3"
//    ["lib_article"]=> string(15) "article de test"
//    ["lib_liaison_type"]=> string(24) "Produits de substitution"
//    ["systeme"]=> string(1) "0"
//    ["ordre"]=> string(1) "7"
//  }
function getLiaisons () {
	if (!$this->liaisons_loaded) { $this->charger_liaisons(); }
	return $this->liaisons;
}

function getFormules_tarifs () {
	if (!$this->formules_tarifs_loaded) { $this->charger_formules_tarifs(); }
	return $this->formules_tarifs;
}

function getTarifs () {
	if (!$this->tarifs_loaded) { $this->charger_tarifs(); }
	return $this->tarifs;
}

function getCodes_barres () {
	if (!$this->codes_barres_loaded) { $this->charger_codes_barres(); }
	return $this->codes_barres;
}

function getPrix_achat_ht () {
	return $this->prix_achat_ht;
}

function getPaa_ht () {
	return $this->paa_ht;
}

function getPaa_last_maj () {
	return $this->paa_last_maj;
}

function getPv_last_maj () {
	return $this->chargerpv_last_maj ();
}



function getId_tva () {
	return $this->id_tva;
}

function getTva () {
	return $this->tva;
}

function getPromo () {
	return $this->promo;
}

function getTaxes () {
	if (!$this->taxes_loaded) { $this->charger_taxes(); }
	return $this->taxes;
}

function getStocks_alertes () {
	if (!$this->stocks_alertes_loaded) { $this->charger_stocks_alertes(); }
	return $this->stocks_alertes;
}

/**
 * @return un tableau de String indéxé sur l'id_stock
 */
function getStocks_emplacements() {
	if (!$this->stocks_alertes_loaded) { $this->charger_stocks_alertes(); }
	return $this->emplacements;
}

/**
 * @return string - l'emplacement
 */
function getStocks_emplacement($id_stock) {
	if (!$this->stocks_alertes_loaded) { $this->charger_stocks_alertes(); }
	if(isset($this->emplacements[$id_stock])){
		return $this->emplacements[$id_stock];
	}
	return "";
}

function getStocks () {
	if (!$this->stocks_loaded) { $this->charger_stocks(); }
	return $this->stocks;
}

function getStocks_rsv () {
	if (!$this->stocks_loaded) { $this->charger_stocks(); }
	return $this->stocks_rsv;
}

function getStocks_cdf () {
	if (!$this->stocks_loaded) { $this->charger_stocks(); }
	return $this->stocks_cdf;
}

function getStocks_tofab () {
	if (!$this->stocks_loaded) { $this->charger_stocks(); }
	return $this->stocks_tofab;
}

function getStocks_arti_sn () {
	if (!$this->stocks_loaded) { $this->charger_stocks(); }
	return $this->stocks_arti_sn;
}

function getLast_docs () {
	if (!$this->last_docs_loaded) { $this->charger_last_docs (); }
	return $this->last_docs;
}

function getIs_in_stock() {
	return $this->is_in_stock;
}

function getTags() {
  return $this->tags;
}
/*
function get_code_pdf_modele(){
	global $bdd;
	$query = "SELECT code_pdf_modele FROM pdf_modeles WHERE id_pdf_modele IN
		( SELECT id_pdf_modele FROM art_categs_modeles_pdf WHERE `usage` = 'defaut' AND ref_art_categ IN
		( SELECT ref_art_categ FROM articles WHERE ref_article='".$this->ref_article."'));";
	$res = $bdd->query($query);
	//return ($res->fetchObject()) ? $res->fetchObject()->code_pdf_modele : '';
	if ($r = $res->fetchObject()) {
		$tmp = $r->code_pdf_modele;
	} else {
		$query = "SELECT code_pdf_modele FROM pdf_modeles WHERE id_pdf_type = '3';";
		$res = $bdd->query($query);
		$tmp = ($r = $res->fetchObject()) ? $r->code_pdf_modele : false;
	}
	return $tmp;
}
*/

public function isAchetable(){
	return $this->is_achetable;
}
public function isVendable(){
	return $this->is_vendable;
}

private function set_default_code_pdf_modele($id_type = 3){
	global $bdd;
	$query = "SELECT code_pdf_modele FROM pdf_modeles WHERE id_pdf_modele IN
		( SELECT id_pdf_modele FROM art_categs_modeles_pdf WHERE `usage` = 'defaut' AND ref_art_categ IN
		( SELECT ref_art_categ FROM articles WHERE ref_article='".$this->ref_article."'));";
	$res = $bdd->query($query);
	//return ($res->fetchObject()) ? $res->fetchObject()->code_pdf_modele : '';
	if ($r = $res->fetchObject()) {
		$tmp = $r->code_pdf_modele;
	} else {
		$query = "SELECT code_pdf_modele FROM pdf_modeles WHERE id_pdf_type = '".$id_type."';";
		$res = $bdd->query($query);
		$tmp = ($r = $res->fetchObject()) ? $r->code_pdf_modele : false;
	}
	$this->code_pdf_modele = $tmp;
	
	return true;
}

//changement du code_pdf_modele
public function change_code_pdf_modele ($code_pdf_modele) {
	$this->code_pdf_modele = $code_pdf_modele;
} 

public function get_code_pdf_modele () {
	return $this->code_pdf_modele;
}

// ******************************************
//
// ******************************************
public function create_pdf($print = 0){
	$GLOBALS['PDF_OPTIONS']['HideToolbar'] = 0;
	$GLOBALS['PDF_OPTIONS']['AutoPrint'] = $print;

	$pdf = new PDF_etendu();
	$pdf->add_art("", $this);
	return $pdf;
}

public function view_pdf($print = 0){
	$pdf = $this->create_pdf($print);
	$pdf->Output();
}

public function print_pdf(){
	$this->view_pdf(1);
}

//mise à jour du numéro de compte achat
/**
 * @param $numero_compte_achat
 * @return bool
 */
function maj_numero_compte_achat ($numero_compte_achat) {
	global $bdd;
	
	// *************************************************
	// Controle des données transmises
	if ($numero_compte_achat == $this->numero_compte_achat ) {
		return false;
	}
	$this->numero_compte_achat		= $numero_compte_achat;

	// *************************************************
	// Si les valeurs reçues sont incorrectes
	if (count($GLOBALS['_ALERTES'])) {
		return false;
	}

	// *************************************************
	// Mise a jour de la base
	$query = "UPDATE articles 
						SET numero_compte_achat = '".addslashes($numero_compte_achat)."'
						WHERE ref_article = '".$this->ref_article."' ";
	$bdd->exec ($query);
	
	return true;
}
//mise à jour du numéro de compte vente
/**
 * @param $numero_compte_vente (int or str)
 * @return bool
 */
function maj_numero_compte_vente ($numero_compte_vente) {
	global $bdd;
	
	// *************************************************
	// Controle des données transmises
	if ($numero_compte_vente == $this->numero_compte_vente ) {
		return false;
	}
	$this->numero_compte_vente		= $numero_compte_vente;

	// *************************************************
	// Si les valeurs reçues sont incorrectes
	if (count($GLOBALS['_ALERTES'])) {
		return false;
	}

	// *************************************************
	// Mise a jour de la base
	$query = "UPDATE articles 
						SET numero_compte_vente = '".addslashes($numero_compte_vente)."'
						WHERE ref_article = '".$this->ref_article."' ";
	$bdd->exec ($query);
	
	return true;
}

	//*****************************************************************************************
	//	FONCTIONS STATIQUES
	//*****************************************************************************************
	
	/**
	 * @param string $ref_interne - La référence interne de l'article recherché
	 * @return article - retourne l'article correspondant à la référence fourni ou nulle
	 */
	public static function getArticle_by_ref_interne($ref_interne){
		return article::getArticle_by('ref_interne', $ref_interne);		
	}
	
	/**
	 * @param string $ref_oem - La référence constructeur de l'article recherché
	 * @return article - retourne l'article correspondant à la référence fourni ou nulle
	 */
	public static function getArticle_by_ref_oem($ref_oem){
		return article::getArticle_by('ref_oem', $ref_oem);		
	}

	/**
	 * @param $nom_champ_type_ref 
	 * @param $ref
	 * @return article - retourne l'article correspondant à la référence fourni ou null
	 */
	protected static function getArticle_by($nom_champ_type_ref, $ref){
		global $bdd;
		
		if($nom_champ_type_ref != 'ref_oem' && $nom_champ_type_ref != 'ref_interne'){ return null; }
		if(empty($ref)){ return null; }
		
		$ref_article = "";
		$query = "SELECT ref_article FROM articles
					WHERE $nom_champ_type_ref = '$ref' LIMIT 1; ";
		$stt = $bdd->query($query);
		if(is_object($stt) && $art = $stt->fetchObject()){
			$ref_article = $art->ref_article;
		}
		$stt->closeCursor();
		
		if(empty($ref_article)){ return null; }
		return new article($ref_article);
	}

	/**
	 * récupères tous les articles dont le stock n'est pas suffisant ou n'est pas défini
	 * pour effectuer la livraison de toutes les commandes (en cours)
	 * @param string $stateDoc default'vente' : etat de document utilisé pour comparaison prepa | vente | attente
	 * @param boolean $miniStock default true : prise en compte du stock_alerte ou pas ...
	 * @return mixed soit le tableau des stocks > ref_articles > array(stock, sorties, mini) soit false si aucun article n'est retourné
	 */
	public static function getAllInsufStockByStock($stateDoc='vente', $miniStock = true) {
		$articlesInsuf = array();
		$articlesStock = self::getArticleStockInfos();
		foreach($articlesStock as $ref_article =>$v1){
			foreach($v1 as $id_stock => $stockInfo){
				$mini = ($miniStock && !empty($stockInfo['alerte'])) ? (float)$stockInfo['alerte'] : 0 ;
				$stock = (!empty($stockInfo['stock'])) ? $stockInfo['stock'] : 0;
				$stConso = (!empty($stockInfo[$stateDoc])) ? $stockInfo[$stateDoc] : 0 ;
				if(($stock-$stConso)<$mini){
					$articlesInsuf[$id_stock][$ref_article] = array("stock"=>$stock, 'sorties'=>$stConso, 'mini'=>$mini) ;
				}
			}
		}
		return (count($articlesInsuf)>0) ? $articlesInsuf : false ;
	}
	/**
	 * getLibStock retourne le libélé du stock
	 * @param int $idStock
	 * @return string | false
	 */
	public static function getLibStock($idStock){
		global $bdd;
		if($result = $bdd->query('SELECT lib_stock FROM stocks WHERE id_stock = '.(int)$idStock.'')){
			$r = $result->fetchObject();
			return $r->lib_stock ;
		}
		return false ;
	}
	/**
	 * getLibStock retourne le libélé d'u stock'un article
	 * @param string $ref_article
	 * @return string | false
	 */
	public static function getLibArticle($ref_article){
		global $bdd;
		if($result = $bdd->query('SELECT lib_article FROM articles WHERE ref_article = "'.$ref_article.'"')){
			$r = $result->fetchObject();
			return $r->lib_article ;
		}
		return false ;
	}
	/**
	 * getArticleStockInfos retourne un tableau des quantités d'articles par catégorie
	 * ref_article > id_stock > array(alerte, stock, prepa, vente, attente)
	 * @param string $ref_article ou chaine vide
	 * @return mixed tous les articles si empty($ref_article) ou les états de stocks de l'article renseigné ou false si l'article renseigné n'est pas valide
	 */
	public static function getArticleStockInfos($ref_article=""){
		if(empty($ref_article))
			return self::getAllArticleStockInfos() ;
		$articleStock = self::getAllArticleStockInfos();
		return (!empty($articleStock[$ref_article])) ? $articleStock[$ref_article] : false ;
	}
	protected static function getAllArticleStockInfos(){
		global $bdd ;
		$query = "SELECT * FROM articles WHERE modele='materiel'";//mat
		$articlesStock = array();
		if($result = $bdd->query($query)){
			$articles = array();
			while($a = $result->fetchObject()){ $articles[] = $a ;}
			foreach($articles as $article){
				$queryStock['alerte'] = "SELECT id_stock, IF(seuil_alerte, seuil_alerte, 0) as qte FROM articles_stocks_alertes WHERE ref_article='{$article->ref_article}'";
				$queryStock['stock'] = "SELECT id_stock, qte FROM stocks_articles WHERE ref_article='{$article->ref_article}'";
				$queryStock['prepa'] = "SELECT SUM(dl.qte) as qte, blc.id_stock FROM docs_lines dl
						LEFT JOIN documents d USING(ref_doc)
						LEFT JOIN doc_blc blc USING(ref_doc)
						WHERE dl.ref_article='{$article->ref_article}' AND d.id_etat_doc = 73
						GROUP BY id_stock";
				$queryStock['vente'] = "SELECT SUM(dl.qte) as qte, cdc.id_stock FROM docs_lines dl
						LEFT JOIN documents d USING(ref_doc)
						LEFT JOIN doc_cdc cdc USING(ref_doc)
						WHERE dl.ref_article='{$article->ref_article}' AND d.id_etat_doc = 9
						GROUP BY cdc.id_stock";
				$queryStock['attente'] = "SELECT SUM(dl.qte) as qte, cdc.id_stock FROM docs_lines dl
						LEFT JOIN documents d USING(ref_doc)
						LEFT JOIN doc_cdc cdc USING(ref_doc)
						WHERE dl.ref_article='{$article->ref_article}' AND d.id_etat_doc = 8
						GROUP BY cdc.id_stock";
				foreach ($queryStock as $name => $query){
					if($result = $bdd->query($query)){
						while($response = $result->fetchObject())
							$articlesStock[$article->ref_article][$response->id_stock][$name] = $response->qte ;
					}
				}
			}
		}
		return $articlesStock ;
	}

// Recupere les articles favoris
 public static function _getArticles_fav()
    {
        global $bdd;

        $ref_articles = array();
        $query = "SELECT ref_article FROM `caisse_articles_favoris`";
        $result = $bdd->query($query);
        if ($result == false)
            return (false);
        while ($res = $result->fetchObject())
                $ref_articles[] = $res->ref_article;
        return ($ref_articles);
    }

    public static function _add_article_fav($ref)
    {
        global $bdd;

        $ref = ref_or_null($ref);
        if ($ref == "NULL")
            return (false);
        $query = "INSERT INTO caisse_articles_favoris (ref_article) VALUES(".$ref.");";
        $result = $bdd->query($query);
        if ($result == false)
            return (false);
        return (true);
    }

    public static function _del_article_fav($ref)
    {
        global $bdd;

        if ($ref == "")
            return (false);
        $query = "DELETE FROM caisse_articles_favoris  WHERE ref_article = '".$ref."';";
        $result = $bdd->query($query);
        if ($result == false)
            return (false);
        return (true);
    }

	// *************************************************************************************************************
}	// FIN DE LA CLASSE
	// *************************************************************************************************************



// Fonction d'envoi d'un email HTML
function mail_html_message ($to , $sujet , $message , $reply , $from) {
	$texte = "";
	$limite = "_parties_".md5(uniqid(rand()));
	$mail_mime = "Date: ".date("r")."\n";
	$mail_mime .= "MIME-Version: 1.0\n";
	//si plusieurs destinataires, on envois en Bcc
	if (count(explode(";", $to)) > 1) {
		$mail_mime .= "Bcc: $to \n";
		$to = $from;
	}
	$mail_mime .= "Content-type: text/html; charset= iso-8859-1\n";

	//Le message en texte HTML
	$texte .= $message;
	$texte .= "\n\n";
	
	// Envoi de l'email
	$mail = new email();
	$mail->prepare_envoi(0, 0);
	return $mail->envoi($to , $sujet , $texte."\n\n" , "Reply-to: $reply\nFrom:$from\n".$mail_mime);

}

//fonction renvoyant les sous composant d'un article donné
function composant_order_by_lot (&$tab1, $tab2, $cle1, $cle2, $cle3) {
	static $tab1 = array();
	static $indentation = 0;

	for ($i=0; $i<count($tab2); $i++) {
		// Ajout de l'enregistrement en cours au tableau 1
		$tab1[$tab2[$i]->{$cle1}.$tab2[$i]->{$cle3}] = $tab2[$i];
		$tab1[$tab2[$i]->{$cle1}.$tab2[$i]->{$cle3}]->indentation = $indentation;

		if (!$tab2[$i]->{$cle2}) { continue; }
		// Ajout des enfant de l'enregistrement en cours au tableau 1
		$indentation++;
		$tab1 = composant_order_by_lot ($tab1, get_article_composants ($tab2[$i]->{$cle3}), $cle1, $cle2, $cle3);
		$indentation--;
	}

	return $tab1;
}

function charger_liste_articles_abonnement () {
	global $bdd;

	$resultats = array();
	$query = " SELECT a.ref_article, a.modele,
										a.lib_article,
										ac.lib_art_categ, ac.ref_art_categ
							FROM articles a
							LEFT JOIN art_categs ac ON ac.ref_art_categ = a.ref_art_categ
							WHERE a.modele = 'service_abo'
							ORDER BY ac.lib_art_categ DESC  ";
	$resultat = $bdd->query ($query);
	while ($art_info = $resultat->fetchObject()) {
		$nb_abonnes = 0;
		$query2 = " SELECT COUNT(ref_contact)  nb_abonnes
							FROM articles_abonnes
							WHERE ref_article = '".$art_info->ref_article."'  && date_echeance > NOW()
							ORDER BY date_echeance DESC
							LIMIT 1";
		$resultat2 = $bdd->query ($query2);
		if ($info = $resultat2->fetchObject()) {
			 $nb_abonnes = $info->nb_abonnes;
		}
		$art_info->nb_abonnes = $nb_abonnes;
		$resultats[] = $art_info;
	}
	return $resultats;
}

function charger_liste_articles_consommation () {
	global $bdd;

	$resultats = array();
	$query = " SELECT a.ref_article, a.modele,
										a.lib_article,
										ac.lib_art_categ, ac.ref_art_categ
							FROM articles a
							LEFT JOIN art_categs ac ON ac.ref_art_categ = a.ref_art_categ
							WHERE a.modele = 'service_conso'
							ORDER BY ac.lib_art_categ DESC  ";
	$resultat = $bdd->query ($query);
	while ($art_info = $resultat->fetchObject()) {
		$nb_abonnes = 0;
		$query2 = " SELECT COUNT(ref_contact) as nb_abonnes
							FROM articles_comptes_credits
							WHERE ref_article = '".$art_info->ref_article."' && credits_restants > 0 && date_echeance > NOW() ";
		$resultat2 = $bdd->query ($query2);
		if ($info2 = $resultat2->fetchObject()) {
			 $nb_abonnes = $info2->nb_abonnes;
		}
		$art_info->nb_abonnes = $nb_abonnes;
		$nb_credit_restants = 0;
		$query3 = " SELECT SUM(credits_restants) as credits_restants
							FROM articles_comptes_credits
							WHERE ref_article =  '".$art_info->ref_article."' && date_echeance > NOW()
							";
		$resultat3 = $bdd->query ($query3);
		$info3 = $resultat3->fetchObject();
		if (isset($info3->credits_restants)) {
			 $nb_credit_restants = $info3->credits_restants;
		}
		$art_info->nb_credit_restants = $nb_credit_restants;
		$resultats[] = $art_info;
	}
	return $resultats;
}

function fetch_all_categs_articles() {
	global $bdd;

	$art_categs = array();
	$query = "SELECT ref_art_categ, lib_art_categ FROM art_categs ORDER BY lib_art_categ ASC";
	$res = $bdd->query($query);
	while ($art_categ = $res->fetchObject()) { $art_categs[] = $art_categ; }

	return $art_categs;
}

function charge_modele_pdf_article () {
	global $bdd;
	$modeles_liste	= array();
	$query = "SELECT id_pdf_modele, id_pdf_type, lib_modele, desc_modele , code_pdf_modele
							FROM pdf_modeles
							WHERE id_pdf_type = '3'
							";
	$resultat = $bdd->query ($query);
	while ($modele_pdf = $resultat->fetchObject()) { $modeles_liste[] = $modele_pdf;}
	return $modeles_liste;
}

function getListePdfArt(){
	global $bdd;

	$liste = array();
	$query = "SELECT ac.ref_art_categ, ac.lib_art_categ, acmp.id_pdf_modele, acmp.usage, pm.lib_modele, pm.desc_modele
		FROM art_categs ac
		LEFT JOIN art_categs_modeles_pdf acmp ON ac.ref_art_categ = acmp.ref_art_categ
		LEFT JOIN pdf_modeles pm ON acmp.id_pdf_modele = pm.id_pdf_modele
		WHERE pm.id_pdf_type = '3'
		ORDER BY ac.lib_art_categ ASC, acmp.usage ASC;";
	$res = $bdd->query($query);
	while ($r = $res->fetchObject()) { $liste[] = $r;}
	return $liste;
}


function getListeOnByCat($categ, &$def) {
  global $bdd;

  $query = "SELECT id_pdf_modele FROM art_categs_modeles_pdf
  	WHERE `usage` IN ('defaut','actif') AND ref_art_categ='".$categ."';";
  $res = $bdd->query($query);
  $out = array();
  while ($tmp = $res->fetchObject()) { $out[] = $tmp->id_pdf_modele; }

  $query = "SELECT id_pdf_modele FROM art_categs_modeles_pdf
  	WHERE `usage`='defaut' AND ref_art_categ='".$categ."';";
  $res = $bdd->query($query);
  if ($tmp = $res->fetchObject()) { $def = $tmp->id_pdf_modele; }

  return $out;
}

function getListeOffByCat($categ, &$count) {
  global $bdd;
	$count = 0;
  $query = "SELECT id_pdf_modele FROM art_categs_modeles_pdf
  	WHERE `usage` = 'inactif' AND ref_art_categ='".$categ."';";
  $res = $bdd->query($query);
  $out = array();
  while ($tmp = $res->fetchObject()) { 
  	$out[] = $tmp->id_pdf_modele;
	$count ++;
  }
  return $out;
}

//modele pdf par défaut
function defaut_art_modele_pdf ($ref_art_categ, $id_pdf_modele) {
	global $bdd;

	$query = "UPDATE art_categs_modeles_pdf
						SET  `usage` = 'actif'
						WHERE ref_art_categ = '".$ref_art_categ."' && `usage` != 'inactif'
						";
	$bdd->exec ($query);

	$query = "UPDATE art_categs_modeles_pdf
						SET  `usage` = 'defaut'
						WHERE ref_art_categ = '".$ref_art_categ."' && id_pdf_modele = '".$id_pdf_modele."'
						";
	$bdd->exec ($query);
	return true;
}

//activation d'un modele pdf
function active_art_modele_pdf ($ref_art_categ, $id_pdf_modele) {
	global $bdd;

	$query = "SELECT COUNT(`usage`) as nb FROM art_categs_modeles_pdf
		WHERE ref_art_categ='".$ref_art_categ."' AND id_pdf_modele='".$id_pdf_modele."';";
	$res = $bdd->query($query);
	if ($res->fetchobject()->nb > 0) {
	  $query = "UPDATE art_categs_modeles_pdf
						SET  `usage` = 'actif'
						WHERE ref_art_categ = '".$ref_art_categ."' && id_pdf_modele = '".$id_pdf_modele."'
						";
	} else {
	  $query = "INSERT INTO art_categs_modeles_pdf
	  	(id_pdf_modele, ref_art_categ, `usage`) VALUES ('".$id_pdf_modele."', '".$ref_art_categ."', 'actif');";
	}
	$bdd->exec ($query);

	$query = "SELECT COUNT(`usage`) as nb FROM art_categs_modeles_pdf
		WHERE ref_art_categ='".$ref_art_categ."' AND `usage` IN ('actif', 'defaut');";
	$res = $bdd->query($query);

	if ($res->fetchobject()->nb == 1) {
	  defaut_art_modele_pdf ($ref_art_categ, $id_pdf_modele);
	}
	return true;
}

//désactivation d'un modele pdf
function desactive_art_modele_pdf ($ref_art_categ, $id_pdf_modele) {
	global $bdd;

	$query = "UPDATE art_categs_modeles_pdf
						SET  `usage` = 'inactif'
						WHERE ref_art_categ = '".$ref_art_categ."' && id_pdf_modele = '".$id_pdf_modele."'
						";
	$bdd->exec ($query);
	return true;
}

//suppression d'un modele pdf
function supprime_art_modele_pdf ($id_pdf_modele) {
	global $bdd;
	$query = "DELETE FROM pdf_modeles
						WHERE id_pdf_modele = '".$id_pdf_modele."'; 
			DELETE FROM art_categs_modeles_pdf
						WHERE id_pdf_modele = '".$id_pdf_modele."';";
	$bdd->exec ($query);
	return true;
}
?>
