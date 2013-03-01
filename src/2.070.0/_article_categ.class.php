<?php
// *************************************************************************************************************
// CLASSE REGISSANT LES INFORMATIONS SUR UNE CATEGORIE D'ARTICLE 
// *************************************************************************************************************


final class art_categ {
	private $ref_art_categ;			// Référence de la catégorie d'article
	private $lib_art_categ;
	private $desc_art_categ;
	private $defaut_id_tva;			// Taux de TVA par défaut
	private $ref_art_categ_parent;	// Référence de la catagorie d'article parent, permettant de créer une hierarchie
	private $duree_dispo;				//durée de vie des articles de la catégorie à la création

	private $restrict_to_achats;		// la catégorie peut-elle contenir des articles disponibles à l'achat
	private $restrict_to_ventes;		// la catégorie peut-elle contenir des articles disponbiles à la vente
	
	private $modele;						// Modèle d'article associé aux articles de cette catégorie
	private $id_modele_spe;				// Modèle spécifiques d'article associé aux articles de cette catégorie
	private $lib_modele_spe;

	private $caracs;						// Caractéristiques (complètes) des articles de cette catégorie
	private $caracs_loaded;			// Défini si les caractéristiques sont chargées
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

	private $caracs_groupes;						// Groupes de caractéristiques des articles de cette catégorie
	private $caracs_groupes_loaded;			// Défini si les groupes de caractéristiques sont chargées
	// CARACS_GROUPES						// Pas de classe spécifique
		// ref_carac_groupe
		// ref_art_categ					// Référence de la catégorie associée
		// lib_carac_groupe				// Libellé
		// ordre									// Ordre d'affichage

	private $formules_tarifs;			// Formules de tarif
	private $formules_tarifs_loaded;
	// FORMULES TARIFS
		// id_tarif
		// formule_tarif

	private $taxes;							// Taxes applicables aux articles de cette catégorie
	private $taxes_loaded;			// Défini si les taxes applicables sont chargées
	
	private $defaut_numero_compte_vente;	// numéro de compte comptable vente HT par defaut 
	private $defaut_numero_compte_achat;	// numéro de compte comptable achat HT par defaut 


function __construct($ref_art_categ = "") {
	global $bdd;

	// Controle si la ref_art_categ est précisée
	if (!$ref_art_categ) { return false; }

	// Sélection des informations générales
	$query = "SELECT ref_art_categ, lib_art_categ, modele, ac.id_modele_spe, desc_art_categ, defaut_id_tva, restriction, duree_dispo, 
										defaut_numero_compte_vente, defaut_numero_compte_achat, ref_art_categ_parent,
										acs.lib_modele_spe
						FROM art_categs ac
						LEFT JOIN art_categs_specificites acs ON acs.id_modele_spe = ac.id_modele_spe
						WHERE ref_art_categ = '".$ref_art_categ."' ";
	$resultat = $bdd->query ($query);

	// Controle si la ref_art_categ est trouvée
	if (!$art_categ = $resultat->fetchObject()) { return false; }

	// Attribution des informations à l'objet
	$this->ref_art_categ 		= $ref_art_categ;
	$this->lib_art_categ		= $art_categ->lib_art_categ;
	$this->modele						= $art_categ->modele;
	$this->desc_art_categ		= $art_categ->desc_art_categ;
	$this->defaut_id_tva		= $art_categ->defaut_id_tva;
	$this->duree_dispo			= $art_categ->duree_dispo;
	$this->defaut_numero_compte_vente	= $art_categ->defaut_numero_compte_vente;
	$this->defaut_numero_compte_achat		= $art_categ->defaut_numero_compte_achat;
	$this->ref_art_categ_parent	= $art_categ->ref_art_categ_parent;
	$this->id_modele_spe	= $art_categ->id_modele_spe;
	$this->lib_modele_spe	= $art_categ->lib_modele_spe;
	
	$this->setRestriction($art_categ->restriction);
	
	return true;
}



// *************************************************************************************************************
// FONCTIONS LIEES A LA CREATION D'UNE CATEGORIE D'ARTICLE 
// *************************************************************************************************************

final public function create ($lib_art_categ, $desc_art_categ, $ref_art_categ_parent, $modele, $defaut_id_tva,  $duree_dispo, $ref_art_categ = "", $restriction = "aucune") {
	global $DEFAUT_ID_TVA;
	global $bdd;

	$ART_CATEG_ID_REFERENCE_TAG = 4;		// Référence Tag utilisé dans la base de donnée

	// *************************************************
	// Controle des données transmises
	if (!$lib_art_categ) {$GLOBALS['_ALERTES']['lib_vide'] = 1;}
	$this->lib_art_categ		= $lib_art_categ;
	$this->desc_art_categ		= $desc_art_categ;
	$this->ref_art_categ_parent	= $ref_art_categ_parent;
	$this->modele						= $modele;
	$this->defaut_id_tva		= $defaut_id_tva;
	$this->duree_dispo			= $duree_dispo;
	
	if($restriction != "achat" && $restriction != "vente"){ $restriction = "aucune"; }
	$this->setRestriction($restriction);
	
	
	//Verification de la ref_art_categ si passée en parametre
	if (!$ref_art_categ) { 
	
		// Création de la référence
		$reference = new reference ($ART_CATEG_ID_REFERENCE_TAG);
		$this->ref_art_categ = $reference->generer_ref();
		
	} else {
	
		// Sélection des informations générales
		$query = "SELECT ref_art_categ
							FROM art_categs 
							WHERE ref_art_categ = '".$ref_art_categ."' ";
		$resultat = $bdd->query ($query);
		if (!$art_categ = $resultat->fetchObject()) {
			$this->ref_art_categ = $ref_art_categ;
		} else {
		$GLOBALS['_ALERTES']["ref_art_categ_exist"] = 1;
		}
		
	}
	
	// *************************************************
	// Si les valeurs reçues sont incorrectes
	if (count($GLOBALS['_ALERTES'])) {
		return false;
	}

	// *************************************************
	// Insertion dans la base
	$query = "INSERT INTO art_categs (ref_art_categ, lib_art_categ, modele, desc_art_categ, defaut_id_tva, restriction, duree_dispo, ref_art_categ_parent)
						VALUES ('".$this->ref_art_categ."', '".addslashes($this->lib_art_categ)."', 
										'".$this->modele."', '".addslashes($this->desc_art_categ)."', 
										".num_or_null($this->defaut_id_tva).", '".$restriction ."','".$this->duree_dispo."', ".ref_or_null($this->ref_art_categ_parent)." ) ";
										echo $query;
	$bdd->exec ($query);

	
	// *************************************************
	// Résultat positif de la création
	$GLOBALS['_INFOS']['Création_art_categ'] = $this->ref_art_categ;

	//**********************************************
	// Envoi EDI
	//edi_event(101,ref_or_null($this->ref_art_categ_parent), $this->ref_art_categ);
	
	
	return true;
}



// *************************************************************************************************************
// FONCTIONS LIEES A LA MODIFICATION D'UNE CATEGORIE D'ARTICLE
// *************************************************************************************************************

final public function modification ($lib_art_categ, $desc_art_categ, $ref_art_categ_parent, $modele, $defaut_id_tva, $duree_dispo) {
	global $bdd;
	
	// *************************************************
	// Controle des données transmises
	if ($lib_art_categ != $this->lib_art_categ || $this->ref_art_categ_parent != $ref_art_categ_parent) {
		$GLOBALS['_INFOS']['reload_liste_categ'] = 1;
	}
	if (!$lib_art_categ) {$GLOBALS['_ALERTES']['lib_vide'] = 1;}
	$this->lib_art_categ		= $lib_art_categ;
	$this->desc_art_categ		= $desc_art_categ;
	$this->ref_art_categ_parent	= $ref_art_categ_parent;
	$this->defaut_id_tva		= $defaut_id_tva;
	$this->duree_dispo			= $duree_dispo;

	if ($this->modele != $modele) {
		// Vérification qu'il n'y ai pas deja des articles créé, sinon c'est trop tard.
		$query = "SELECT COUNT(ref_article) nb_articles FROM articles WHERE ref_art_categ = '".$this->ref_art_categ."' ";
		$resultat = $bdd->query ($query);
		$tmp = $resultat->fetchObject();
		if ($tmp->nb_articles) { $GLOBALS['_ALERTES']['cant_change_modele'] = 1; }
	}
	$this->modele = $modele;


	// *************************************************
	// Si les valeurs reçues sont incorrectes
	if (count($GLOBALS['_ALERTES'])) {
		return false;
	}

	// *************************************************
	// Mise a jour de la base
	$query = "UPDATE art_categs 
						SET lib_art_categ = '".addslashes($this->lib_art_categ)."', modele = '".$this->modele."', 
								desc_art_categ = '".addslashes($this->desc_art_categ)."', 
								defaut_id_tva = ".num_or_null($this->defaut_id_tva).",  
								duree_dispo = '".$this->duree_dispo."',  
								ref_art_categ_parent = ".ref_or_null($this->ref_art_categ_parent)."
						WHERE ref_art_categ = '".$this->ref_art_categ."' ";
	$bdd->exec ($query);

        edi_event(105, $this->ref_art_categ);
}


//mise à jour du numéro de compte vente par défaut
public function maj_defaut_numero_compte_vente ($defaut_numero_compte_vente) {
	global $bdd;
	
	// *************************************************
	// Controle des données transmises
	if ($defaut_numero_compte_vente == $this->defaut_numero_compte_vente ) {
		return false;
	}
	$this->defaut_numero_compte_vente		= $defaut_numero_compte_vente;

	// *************************************************
	// Si les valeurs reçues sont incorrectes
	if (count($GLOBALS['_ALERTES'])) {
		return false;
	}

	// *************************************************
	// Mise a jour de la base
	$query = "UPDATE art_categs 
						SET defaut_numero_compte_vente = '".addslashes($this->defaut_numero_compte_vente)."'
						WHERE ref_art_categ = '".$this->ref_art_categ."' ";
	$bdd->exec ($query);
	
	return true;
}
//mise à jour de l'art_categ en id_modele_spe
public function maj_art_categ_modele_spe ($id_modele_spe) {
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
	$query = "UPDATE art_categs 
						SET id_modele_spe = ".$this->id_modele_spe." 
						WHERE ref_art_categ = '".$this->ref_art_categ."' ";
	$bdd->exec ($query);
	
	return true;
}


//mise à jour du numéro de compte achat par défaut
public function maj_defaut_numero_compte_achat ($defaut_numero_compte_achat) {
	global $bdd;
	
	// *************************************************
	// Controle des données transmises
	if ($defaut_numero_compte_achat == $this->defaut_numero_compte_achat ) {
		return false;
	}
	$this->defaut_numero_compte_achat		= $defaut_numero_compte_achat;

	// *************************************************
	// Si les valeurs reçues sont incorrectes
	if (count($GLOBALS['_ALERTES'])) {
		return false;
	}

	// *************************************************
	// Mise a jour de la base
	$query = "UPDATE art_categs 
						SET defaut_numero_compte_achat = '".addslashes($this->defaut_numero_compte_achat)."'
						WHERE ref_art_categ = '".$this->ref_art_categ."' ";
	$bdd->exec ($query);
	
	return true;
}

/**
 * @param enum('aucune','achat','vente') $restriction
 * @return boolean true si la modification s'est bien passé, false sinon
 */
public function maj_restriction($restriction){
	global $bdd; 
	
	$return = true;
	if(!$this->setRestriction($restriction)){
		$restriction = 'aucune';
		$return = false;
	}
	
	$query = "UPDATE art_categs
				SET restriction = '$restriction'
				WHERE ref_art_categ = '$this->ref_art_categ' ;";
	$return = $bdd->exec($query) && $return;
	
	//**************************************************
	// Mise à jour des articles de la catégorie
	$list =& $this->getList_articles();
	
	if( $this->restrict_to_achats ){  
		foreach($list as $article){
			$article->maj_vendable(false);
		}
	}
	if($this->restrict_to_ventes){
		foreach($list as $article){
			$article->maj_achetable(false);
		}
	}
	
	return $return;
	
}


// *************************************************************************************************************
// FONCTIONS LIEES A LA SUPPRESSION D'UNE CATEGORIE D'ARTICLE
// *************************************************************************************************************
final public function suppression ($new_ref_art_categ_parent = "") {
	global $bdd;

	// *************************************************
	// Controle de l'existance d'un article de cette catégorie
	//$query = "SELECT ref_article FROM articles
	//					WHERE ref_art_categ = '".$this->ref_art_categ."' LIMIT 0,1";
	//$resultat = $bdd->query ($query);
	//if ($article = $resultat->fetchObject()) { 
	//	$GLOBALS['_ALERTES']['articles_existants'] = 1;
	//}
	if (!$new_ref_art_categ_parent) { return false;}
	// Controle de l'existance d'une catégorie d'article enfant
	$query = "SELECT ref_art_categ FROM art_categs
						WHERE ref_art_categ_parent = '".$this->ref_art_categ."' LIMIT 0,1";
	$resultat = $bdd->query ($query);
	if ($art_categ = $resultat->fetchObject()) { 
		// Controle de la ref_art_categ_parent de remplacement pour les enfants
		$query = "SELECT ref_art_categ FROM art_categs
							WHERE ref_art_categ = '".$new_ref_art_categ_parent."' LIMIT 0,1";
		$resultat = $bdd->query ($query);
		if (!($art_categ = $resultat->fetchObject())) { 
			$GLOBALS['_ALERTES']['bad_new_ref_art_categ_parent'] = 1;
		}
	}
	// *************************************************
	// Si les valeurs reçues sont incorrectes
	if (count($GLOBALS['_ALERTES'])) {
		return false;
	}

	// *************************************************
	// Suppression de la catégorie
	
	$bdd->beginTransaction();

	// Changement des articles
	$query = "UPDATE articles SET ref_art_categ = '".$new_ref_art_categ_parent."'  
						WHERE ref_art_categ = '".$this->ref_art_categ."' ";
	$bdd->exec ($query);
	
	// Changement des catégories enfants
	$query = "UPDATE art_categs SET ref_art_categ_parent = ".ref_or_null($new_ref_art_categ_parent)."
						WHERE ref_art_categ_parent = '".$this->ref_art_categ."' ";
	$bdd->exec ($query);
	
	// Suppression de la catégorie
	$query = "DELETE FROM art_categs 
						WHERE ref_art_categ = '".$this->ref_art_categ."' ";
	$bdd->exec ($query);
	
	$bdd->commit();

	unset ($this);
}



// *************************************************************************************************************
// FONCTIONS LIEES A LA GESTION DES CARACTERISTIQUES
// *************************************************************************************************************
// Charge les caractéristiques
final public function charger_caracs () {
	global $bdd;

	$this->caracs = array();
	$this->caracs_loaded = 0;

	$query = "SELECT ref_carac, lib_carac, unite, allowed_values, default_value, moteur_recherche, variante, affichage, 
									 acc.ref_carac_groupe, acc.ordre, accg.lib_carac_groupe
						FROM art_categs_caracs acc
							LEFT JOIN art_categs_caracs_groupes accg ON acc.ref_carac_groupe = accg.ref_carac_groupe
						WHERE acc.ref_art_categ = '".$this->ref_art_categ."' 
						ORDER BY accg.ordre ASC, acc.ordre ASC";
						//accg.ordre ASC, enlevé car rend impossible le changement d'ordre au niveau de l'utilisateur
	$resultat = $bdd->query ($query);
	while ($carac = $resultat->fetchObject()) { $this->caracs[] = $carac; }

	$this->caracs_loaded = 1;
	return true;
}


// Ajout d'une caractéristique
final public function create_carac ($lib_carac, $unite, $allowed_values, $default_value, $moteur_recherche, $variante, $affichage, $ref_carac_groupe, $ordre = "", $ref_carac = "") {
	global $bdd;

	$CARAC_ID_REFERENCE_TAG = 8;

	// *************************************************
	// Vérifications des données
	if (!$lib_carac) {
		$GLOBALS['_ALERTES']['lib_carac_vide'] = 1;
	}
	if (!is_numeric($moteur_recherche) || $moteur_recherche<0 || $moteur_recherche>2) {
		$GLOBALS['_ALERTES']['bad_moteur_recherche'] = 1;
	}
	if (!is_numeric($affichage) || $affichage<1 || $affichage>2) {
		$GLOBALS['_ALERTES']['bad_affichage'] = 1;
	}
	if (!is_numeric($variante) || $variante<0 || $variante>1) {
		$GLOBALS['_ALERTES']['bad_variante'] = 1;
	}
	
	//si la ref_carac existe déjà on n'enregistre pas
	if ($ref_carac) {
		$query = "SELECT ref_carac
							FROM art_categs_caracs
							WHERE ref_carac = '".$ref_carac_groupe."' 
							";
		$resultat = $bdd->query ($query);
		if ($carac = $resultat->fetchObject()) { 
			return false;
		}
	}
	// *************************************************
	// Si les valeurs reçues sont incorrectes
	if (count($GLOBALS['_ALERTES'])) {
		return false;
	}
	
	// *************************************************
	// Ordre d'affichage de la caractéristique
	if (!$ordre) {
		$query = "SELECT MAX(ordre) ordre FROM art_categs_caracs WHERE ref_art_categ = '".$this->ref_art_categ."' ";
		$resultat = $bdd->query($query);
		$tmp = $resultat->fetchObject();
		$ordre = $tmp->ordre+1;
		unset ($query, $resultat, $tmp);
	}

	
	// *************************************************
	// Création de la référence
	if (!$ref_carac) {
		$reference = new reference ($CARAC_ID_REFERENCE_TAG);
		$ref_carac = $reference->generer_ref();
	}

	// Création
	$query = "INSERT INTO art_categs_caracs 
							( ref_carac, ref_art_categ, lib_carac, unite, allowed_values, default_value, 
								moteur_recherche, variante, affichage, ref_carac_groupe, ordre )
						VALUES ('".$ref_carac."', '".$this->ref_art_categ."', '".addslashes($lib_carac)."', '".addslashes($unite)."', 
										'".addslashes($allowed_values)."', '".addslashes($default_value)."', '".$moteur_recherche."', 
										'".$variante."', '".$affichage."', ".ref_or_null($ref_carac_groupe).", '".$ordre."' )";
	$bdd->exec ($query);
	
	
	//gestion des articles variantes
	//si on cré une carac variante = 1
//	if ($variante) {
//		//alors si cette carac contient une ou plusieurs valeur par defaut
//		$tmp_default_value = explode(";",$default_value);
//		if (count($tmp_default_value)) {
//			$premiere_valeur = $tmp_default_value[0];
//			//on vas attribuer à tout les articles maitre ou esclave de l'art_categ la carac avec la premiere valeur
//			
//			$query2 =  "SELECT a.ref_article, a.ref_art_categ, a.variante
//									FROM articles a
//									WHERE a.ref_art_categ = '".$this->ref_art_categ."' && a.variante != 0";
//								
//			$resultat2 = $bdd->query($query2);
//			while ($articles = $resultat2->fetchObject()) {
//				$var_article = new article ($articles->ref_article);
//				$var_article->add_carac ($ref_carac, $premiere_valeur);
//			}
//		}
//	}

	//**********************************************
	// Envoi EDI
	edi_event(102,$this->ref_art_categ,$ref_carac);
	
	return true;
}


// Modifie une caractéristique
final public function maj_carac ($ref_carac, $lib_carac, $unite, $allowed_values, $default_value, $moteur_recherche, $variante, $affichage, $ref_carac_groupe) {
	global $bdd;

	// *************************************************
	// Vérifications des données
	if (!$lib_carac) {
		$GLOBALS['_ALERTES']['lib_carac_vide'] = 1;
	}
	if (!is_numeric($moteur_recherche) || $moteur_recherche<0 || $moteur_recherche>2) {
		$GLOBALS['_ALERTES']['bad_moteur_recherche'] = 1;
	}
	if (!is_numeric($affichage) || $affichage<1 || $affichage>2) {
		$GLOBALS['_ALERTES']['bad_affichage'] = 1;
	}
	if (!is_numeric($variante) || $variante<0 || $variante>1) {
		$GLOBALS['_ALERTES']['bad_variante'] = 1;
	}
	// Si la caractéristique est une variante, il faut agir sur les articles qui en sont issus.
	$query = "SELECT variante FROM art_categs_caracs
						WHERE ref_carac = '".$ref_carac."' ";
	$resultat = $bdd->query ($query);
	// Controle si la ref_carac est trouvée
	if (!$carac = $resultat->fetchObject()) { return false; }	
	
	// *************************************************
	// Si les valeurs reçues sont incorrectes
	if (count($GLOBALS['_ALERTES'])) {
		return false;
	}
	if ($carac->variante) {
		
		//si on maj une carac variante = 0
		if (!$variante && $carac->variante) {
			//si notre carac variante est la dernière dans la categorie
			$query2 = "SELECT COUNT(ref_carac) as nb_carac FROM art_categs_caracs
								WHERE ref_art_categ = '".$this->ref_art_categ."' && variante = 1 ";
			$resultat2 = $bdd->query ($query2);
			$test_carac = $resultat2->fetchObject();
			//c'est la dernière des carac variantes, on vas alors supprimer les articles maitres
			if ($test_carac->nb_carac == 1) {
			
				$query3 =  "SELECT a.ref_article, a.ref_art_categ, a.variante
										FROM articles a
										WHERE a.ref_art_categ = '".$this->ref_art_categ."' && a.variante = 2";
				$resultat3 = $bdd->query($query3);
				while ($articles = $resultat3->fetchObject()) {
					$var_article = new article ($articles->ref_article);
					$var_article->suppression_master ();
				}
			}
			//il reste des carac variantes, on vas alors séparer les articles variantes avec différents maitres
			if ($test_carac->nb_carac > 1) {
				$query3 =  "SELECT a.ref_article, a.ref_art_categ, a.variante
										FROM articles a
										WHERE a.ref_art_categ = '".$this->ref_art_categ."' && a.variante = 2";
									
				$resultat3 = $bdd->query($query3);
				while ($articles = $resultat3->fetchObject()) {
					$var_article = new article ($articles->ref_article);
					$var_article->gestion_master ($ref_carac);
				}
			}
		}
	
	}

	// Mise à jour
	$query = "UPDATE art_categs_caracs
						SET lib_carac = '".addslashes($lib_carac)."', unite = '".addslashes($unite)."', 
								allowed_values = '".addslashes($allowed_values)."', default_value = '".addslashes($default_value)."', 
								moteur_recherche = '".$moteur_recherche."', variante = '".$variante."', affichage = '".$affichage."', 
								ref_carac_groupe = ".ref_or_null($ref_carac_groupe)."
						WHERE ref_carac = '".$ref_carac."' ";
	$bdd->exec ($query);
	
	//gestion des articles variantes
	//si on maj une carac variante = 1
	//if ($variante && !$carac->variante) {
//		//alors si cette carac contient une ou plusieurs valeur par defaut
//		$tmp_default_value = explode(";",$default_value);
//		if (count($tmp_default_value)) {
//			$premiere_valeur = $tmp_default_value[0];
//			//on vas attribuer à tout les articles maitre ou esclave de l'art_categ la carac avec la premiere valeur
//			
//			$query2 =  "SELECT a.ref_article, a.ref_art_categ, a.variante
//									FROM articles a
//									WHERE a.ref_art_categ = '".$this->ref_art_categ."' && a.variante != 0";
//								
//			$resultat2 = $bdd->query($query2);
//			while ($articles = $resultat2->fetchObject()) {
//				$var_article = new article ($articles->ref_article);
//				$var_article->maj_carac ($ref_carac, $premiere_valeur);
//			}
//		}
//	}
	
	
	return true;
}


// Changement d'ordre
final public function modifier_carac_ordre ($ref_carac, $new_ordre) {
	global $bdd;

	if (!is_numeric($new_ordre)) {
		$GLOBALS['_ALERTES']['bad_ordre'] = 1;
	}
	
	// Sélection de l'ordre actuel
	$query = "SELECT ordre FROM art_categs_caracs WHERE ref_carac = '".$ref_carac."' ";
	$resultat = $bdd->query ($query);
	if (!($carac = $resultat->fetchObject())) { 
		$GLOBALS['_ALERTES']['bad_ref_carac'] = 1;
	}
	
	// *************************************************
	// Si les valeurs reçues sont incorrectes
	if (count($GLOBALS['_ALERTES'])) {
		return false;
	}

	$ordre_actu = $carac->ordre;

	if ($new_ordre == $ordre_actu) { return false; }
	elseif ($new_ordre < $ordre_actu) {
		$variation = "+";
		$symbole1 = "<";
		$symbole2 = ">=";
	}
	else {
		$variation = "-";
		$symbole1 = ">";
		$symbole2 = "<=";
	}

	$bdd->beginTransaction();

	// Mise à jour des autres caractéristiques
	$query = "UPDATE art_categs_caracs
						SET ordre = ordre ".$variation." 1
						WHERE ref_art_categ = '".$this->ref_art_categ."' && 
									ordre ".$symbole1." '".$ordre_actu."' && ordre ".$symbole2." '".$new_ordre."' ";
	$bdd->exec ($query);
	
	// Mise à jour de cette caractéristiques
	$query = "UPDATE art_categs_caracs
						SET ordre = '".$new_ordre."'
						WHERE ref_carac = '".$ref_carac."'  ";
	$bdd->exec ($query);
	
	$bdd->commit();

	return true;
}


// Suppression une caractéristique
final public function delete_carac ($ref_carac) {
	global $bdd;

	// *************************************************
	// Vérification de la possibilité de supprimer la caractéristique
	// Si la caractéristique est une variante, il faut agir sur les articles qui en sont issus.
	$query = "SELECT variante FROM art_categs_caracs
						WHERE ref_carac = '".$ref_carac."' ";
	$resultat = $bdd->query ($query);
	// Controle si la ref_carac est trouvée
	if (!$carac = $resultat->fetchObject()) { return false; }	
	if ($carac->variante) {
		//si notre carac variante est la dernière dans la categorie
		$query2 = "SELECT COUNT(ref_carac) as nb_carac FROM art_categs_caracs
							WHERE ref_art_categ = '".$this->ref_art_categ."' && variante = 1 ";
		$resultat2 = $bdd->query ($query2);
		$test_carac = $resultat2->fetchObject();
		//il reste des carac variantes, on vas alors séparer les articles variantes avec différents maitres
		if ($test_carac->nb_carac >1) {
			$query2 =  "SELECT a.ref_article, a.ref_art_categ, a.variante
									FROM articles a
									WHERE a.ref_art_categ = '".$this->ref_art_categ."' && a.variante = 2";
								
			$resultat2 = $bdd->query($query2);
			while ($articles = $resultat2->fetchObject()) {
				$var_article = new article ($articles->ref_article);
				$var_article->gestion_master ($ref_carac);
			}
		}
		//c'est la dernière des carac variantes, on vas alors supprimer les articles maitres
		if ($test_carac->nb_carac == 1) {
			$query2 =  "SELECT a.ref_article, a.ref_art_categ, a.variante
									FROM articles a
									WHERE a.ref_art_categ = '".$this->ref_art_categ."' && a.variante = 2";
								
			$resultat2 = $bdd->query($query2);
			while ($articles = $resultat2->fetchObject()) {
				$var_article = new article ($articles->ref_article);
				$var_article->suppression_master ();
			}
		}
	}

	// *************************************************
	// Si il y a eu un problème
	if (count($GLOBALS['_ALERTES'])) {
		return false;
	}

	// Suppression
	$query = "DELETE FROM art_categs_caracs
						WHERE ref_carac = '".$ref_carac."' ";
	$bdd->exec ($query);
	
	return true;
}


// *************************************************************************************************************
// FONCTIONS LIEES A LA GESTION DES GROUPES DE CARACTERISTIQUES
// *************************************************************************************************************
// Charge les caractéristiques
final public function charger_caracs_groupes () {
	global $bdd;
	
	$this->caracs_groupes = array();

	$query = "SELECT ref_carac_groupe, lib_carac_groupe, ordre
						FROM art_categs_caracs_groupes
						WHERE ref_art_categ = '".$this->ref_art_categ."' 
						ORDER BY ordre ";
	$resultat = $bdd->query ($query);
	while ($groupe = $resultat->fetchObject()) { $this->caracs_groupes[] = $groupe; }

	return true;
}


// Modifie une caractéristique
final public function create_carac_groupe ($lib_carac_groupe, $ordre = "", $ref_carac_groupe = "") {
	global $bdd;

	$CARAC_GROUPE_ID_REFERENCE_TAG = 9;

	// *************************************************
	// Vérifications des données
	if (!$lib_carac_groupe) {
		$GLOBALS['_ALERTES']['lib_carac_groupe_vide'] = 1;
	}

	//si la ref_carac_groupe existe déjà on n'enregistre pas
	
	if ($ref_carac_groupe) {
		$query = "SELECT ref_carac_groupe
							FROM art_categs_caracs_groupes
							WHERE ref_carac_groupe = '".$ref_carac_groupe."' 
							";
		$resultat = $bdd->query ($query);
		if ($groupe = $resultat->fetchObject()) { 
			return false;
		}
	}
	// *************************************************
	// Si les valeurs reçues sont incorrectes
	if (count($GLOBALS['_ALERTES'])) {
		return false;
	}

	// *************************************************
	// Ordre d'affichage de la caractéristique
	if (!$ordre) {
		$query = "SELECT MAX(ordre) ordre FROM art_categs_caracs_groupes WHERE ref_art_categ = '".$this->ref_art_categ."' ";
		$resultat = $bdd->query($query);
		$tmp = $resultat->fetchObject();
		$ordre = $tmp->ordre+1;
		unset ($query, $resultat, $tmp);
	}

	// *************************************************
	// Création de la référence
	if (!$ref_carac_groupe) {
		$reference = new reference ($CARAC_GROUPE_ID_REFERENCE_TAG);
		$ref_carac_groupe = $reference->generer_ref();
	}

	// Création
	$query = "INSERT INTO art_categs_caracs_groupes
							(ref_carac_groupe, ref_art_categ, lib_carac_groupe, ordre)
						VALUES ('".$ref_carac_groupe."', '".$this->ref_art_categ."', '".addslashes($lib_carac_groupe)."', '".$ordre."') ";
	$bdd->exec ($query);
	
	return true;
}


// Modifie un groupe de carac
final public function maj_carac_groupe ($ref_carac_groupe, $lib_carac_groupe) {
	global $bdd;

	// *************************************************
	// Vérifications des données
	if (!$lib_carac_groupe) {
		$GLOBALS['_ALERTES']['lib_carac_groupe_vide'] = 1;
	}
	
	// *************************************************
	// Si les valeurs reçues sont incorrectes
	if (count($GLOBALS['_ALERTES'])) {
		return false;
	}

	// Mise à jour
	$query = "UPDATE art_categs_caracs_groupes
						SET lib_carac_groupe = '".addslashes($lib_carac_groupe)."'
						WHERE ref_carac_groupe = '".$ref_carac_groupe."' ";
	$bdd->exec ($query);

	return true;
}


// Changement d'ordre
final public function modifier_carac_groupe_ordre ($ref_carac_groupe, $new_ordre) {
	global $bdd;

	if (!is_numeric($new_ordre)) {
		$GLOBALS['_ALERTES']['bad_ordre'] = 1;
	}
	
	// Sélection de l'ordre actuel
	$query = "SELECT ordre FROM art_categs_caracs_groupes WHERE ref_carac_groupe = '".$ref_carac_groupe."' ";
	$resultat = $bdd->query ($query);
	if (!($carac_groupe = $resultat->fetchObject())) { 
		$GLOBALS['_ALERTES']['bad_ref_carac_groupe'] = 1;
	}
	
	// *************************************************
	// Si les valeurs reçues sont incorrectes
	if (count($GLOBALS['_ALERTES'])) {
		return false;
	}
	$ordre_actu = $carac_groupe->ordre;

	if ($new_ordre == $ordre_actu) { return false; }
	elseif ($new_ordre < $ordre_actu) {
		$variation = "+";
		$symbole1 = "<";
		$symbole2 = ">=";
	}
	else {
		$variation = "-";
		$symbole1 = ">";
		$symbole2 = "<=";
	}

	$bdd->beginTransaction();
	
	// Mise à jour des autres groupes
	$query = "UPDATE art_categs_caracs_groupes
						SET ordre = ordre ".$variation." 1
						WHERE ref_art_categ = '".$this->ref_art_categ."' && 
									ordre ".$symbole1." '".$ordre_actu."' && ordre ".$symbole2." '".$new_ordre."' ";
	$bdd->exec ($query);
	
	// Mise à jour de ce groupe
	$query = "UPDATE art_categs_caracs_groupes
						SET ordre = '".$new_ordre."'
						WHERE ref_carac_groupe = '".$ref_carac_groupe."'  ";
	$bdd->exec ($query);
	
	$bdd->commit();

	return true;
}


// Suppression une caractéristique
final public function delete_carac_groupe ($ref_carac_groupe) {
	global $bdd;

	// *************************************************
	// Vérification de la possibilité de supprimer le groupe
	
	// *************************************************
	// Si il y a eu un problème
	if (count($GLOBALS['_ALERTES'])) {
		return false;
	}

	// Suppression
	$query = "DELETE FROM art_categs_caracs_groupes
						WHERE ref_carac_groupe = '".$ref_carac_groupe."' ";
	$bdd->exec ($query);
	
	return true;
}



// *************************************************************************************************************
// FONCTIONS DE GESTION DES TARIFS
// *************************************************************************************************************
// Chargements des formules de tarif
public function charger_formules_tarifs () {
	global $bdd;
	
	$query = "SELECT id_tarif, formule_tarif
						FROM art_categs_formules_tarifs
						WHERE ref_art_categ = '".$this->ref_art_categ."'";
	$resultat = $bdd->query($query);
	while ($var = $resultat->fetchObject()) { $this->formules_tarifs[] = $var; }

	$this->formules_tarifs_loaded = 1;
	return true;
}

// Ajout d'une formule de tarif
public function add_formule_tarif ($id_tarif, $formule_tarif) {
	global $bdd;

	// *************************************************
	// Controles des données
	if (!formule_tarif::check_formule($formule_tarif)) { 
		$GLOBALS['_ALERTES']['bad_formule_tarif'] = 1;
	}

	if (!is_numeric($id_tarif)) {
		$GLOBALS['_ALERTES']['bad_id_tarif'] = 1;
	}

	// *************************************************
	// Si les valeurs reçues sont incorrectes
	if (count($GLOBALS['_ALERTES'])) {
		return false;
	}

	// *************************************************
	// Maj de la base de données
	$query = "REPLACE INTO art_categs_formules_tarifs (ref_art_categ, id_tarif, formule_tarif)
						VALUES ('".$this->ref_art_categ."', '".$id_tarif."', '".$formule_tarif."' ) ";
	$bdd->exec ($query);

	// Déclaration pour mise à jour globale du catalogue
	declare_articles_maj ($id_tarif, "MAJ_TARIF_CATEG", $this->ref_art_categ);
	return true;
}


// Mise à jour d'une formule de tarif
public function maj_formule_tarif ($id_tarif, $formule_tarif) {
	return $this->add_formule_tarif ($id_tarif, $formule_tarif);
}


// Suppression d'une formule de tarif
public function delete_formule_tarif ($id_tarif) {
	global $bdd;

	$query = "DELETE FROM art_categs_formules_tarifs
						WHERE ref_art_categ = '".$this->ref_art_categ."' && id_tarif = '".$id_tarif."' ";
	$bdd->exec ($query);

	// Déclaration pour mise à jour globale du catalogue
	declare_articles_maj ($id_tarif, "MAJ_TARIF_CATEG", $this->ref_art_categ);
	return true;
}






// *************************************************************************************************************
// FONCTIONS LIEES A LA GESTION DES TAXES
// *************************************************************************************************************

// Charge les taxes associées à cette catégorie d'article
function charger_taxes () {
	global $bdd;

	$this->taxes = array();
	$this->taxes_loaded = 0;

	$query = "SELECT act.id_taxe, lib_taxe, id_pays, t.code_taxe, t.info_calcul
						FROM art_categs_taxes act
							LEFT JOIN taxes t ON act.id_taxe = t.id_taxe
						WHERE ref_art_categ = '".$this->ref_art_categ."' ";
	$resultat = $bdd->query ($query);
	while ($taxe = $resultat->fetchObject()) { $this->taxes[] = $taxe; }

	$this->taxes_loaded = 1;
	return true;
}


// Ajout d'une taxe
function ajouter_taxe ($id_taxe) {
	global $bdd;

	$query = "INSERT INTO art_categs_taxes (ref_art_categ, id_taxe)
						VALUES ('".$this->ref_art_categ."', '".$id_taxe."')";
	$bdd->exec ($query);

	return true;
}


// Suppression d'une taxe
function supprimer_taxe ($id_taxe) {
	global $bdd;

	$query = "DELETE FROM art_categs_taxes 
						WHERE ref_art_categ = '".$this->ref_art_categ."' && id_taxe = '".$id_taxe."' 
						LIMIT 1";
	$bdd->exec ($query);
	
	return true;
}

// *************************************************************************************************************
// FONCTIONS DIVERSES
// *************************************************************************************************************
// renvois de la ref_carac en fonction de l'ordre
static function getRef_carac_from_ordre ($ref_art_categ, $ordre) {
	global $bdd;
	
	$ref_carac = "";
	$query = "SELECT ref_carac
						FROM art_categs_caracs
						WHERE ref_art_categ = '".$ref_art_categ."' 
						AND ordre = ".$ordre." 
						LIMIT 1"	;
	$resultat = $bdd->query ($query);
	if ($carac = $resultat->fetchObject()) { $ref_carac = $carac->ref_carac; }
	return $ref_carac;
}

// renvois de la ref_carac_groupe en fonction de l'ordre
static function getRef_carac_groupe_from_ordre ($ref_art_categ, $ordre) {
	global $bdd;
	
	$ref_carac_groupe = "";
	$query = "SELECT ref_carac_groupe
						FROM art_categs_caracs_groupes
						WHERE ref_art_categ = '".$ref_art_categ."' 
						AND ordre = ".$ordre." 
						LIMIT 1"	;
	$resultat = $bdd->query ($query);
	if ($carac_groupe = $resultat->fetchObject()) { $ref_carac_groupe = $carac_groupe->ref_carac_groupe; }
	return $ref_carac_groupe;
}

// *************************************************************************************************************
// FONCTIONS DE MODIFCATION DES DONNEES
// *************************************************************************************************************

/**
 * Cette fonction ne met pas à jour la BDD, pour mettre à jour la bdd utiliser maj_restriction
 * @param enum('aucune','achat','vente') $restriction
 * @return boolean true si la modification s'est bien passé, false sinon
 */
private function setRestriction($restriction){
		
	switch($restriction){
		case 'aucune':
			$this->restrict_to_achats = $this->restrict_to_ventes = false;
			return true;
		case 'achat':
			$this->restrict_to_achats = true;
			$this->restrict_to_ventes = false;
			return true;
		case 'vente':
			$this->restrict_to_achats = false;
			$this->restrict_to_ventes = true;
			return true;
		default:
			if(empty($this->restrict_to_achats)){$this->restrict_to_achats = false; } 
			if(empty($this->restrict_to_ventes)){$this->restrict_to_ventes = false; } 	
			return false; 
	}
	
}
// *************************************************************************************************************
// FONCTIONS DE LECTURE DES DONNEES 
// *************************************************************************************************************
function getRef_art_categ () {
	return $this->ref_art_categ;
}

function getLib_art_categ () {
	return $this->lib_art_categ;
}

function getDesc_art_categ () {
	return $this->desc_art_categ;
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

function getDuree_dispo () {
	return $this->duree_dispo;
}

function getRef_art_categ_parent () {
	return $this->ref_art_categ_parent;
}

function getTaxes () {
	if (!$this->taxes_loaded) { $this->charger_taxes(); }
	return $this->taxes;
}

function getCarac_groupes () {
	if (!$this->caracs_groupes_loaded) { $this->charger_caracs_groupes(); }
	return $this->caracs_groupes;
}

function getCarac () {
	if (!$this->caracs_loaded) { $this->charger_caracs(); }
	return $this->caracs;
}

function getFormules_tarifs () {
	if (!$this->formules_tarifs_loaded) { $this->charger_formules_tarifs(); }
	return $this->formules_tarifs;
}

function getDefaut_id_tva () {
	return $this->defaut_id_tva;
}

function getDefaut_numero_compte_vente () {
	return $this->defaut_numero_compte_vente;
}

function getDefaut_numero_compte_achat () {
	return $this->defaut_numero_compte_achat;
}

/**
 * @return array(article) retourne un tableau d'article contenant tous les articles de la catégorie
 */
public function &getList_articles(){
	global $bdd;
	
	$list_article = array();
	
	$query =  "SELECT ref_article
					FROM articles 
					WHERE ref_art_categ = '".$this->ref_art_categ."' ";
								
	$statement = $bdd->query($query);
	if(is_object($statement)){
		while($art = $statement->fetchObject()){
			$list_article[] = new article($art->ref_article);
		}
	}
	
	return $list_article;
}

/**
 * @return boolean
 */
public function isRestrict_to_achats(){
	return $this->restrict_to_achats;
}

/**
 * @return boolean
 */
public function isRestrict_to_ventes(){
	return $this->restrict_to_ventes;
}

}
?>