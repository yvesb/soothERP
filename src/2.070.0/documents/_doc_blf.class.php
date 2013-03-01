<?php
// *************************************************************************************************************
// CLASSE REGISSANT LES INFORMATIONS SUR UN DOCUMENT DE TYPE BON DE RECEPTION FOURNISSEUR
// *************************************************************************************************************


final class doc_blf extends document {

	protected $id_stock;
	protected $lib_stock;
	protected $ref_doc_externe;

	protected $ID_TYPE_DOC 					= 7;
	protected $LIB_TYPE_DOC 				= "Bon de Livraison Fournisseur";
	protected $CODE_DOC 						= "BLF";
	protected $DOC_ID_REFERENCE_TAG = 21;

	protected $DEFAUT_ID_ETAT = 29;
	protected $DEFAUT_LIB_ETAT 	= "En saisie";
	protected $GESTION_SN	 		= 1;
	protected $CONTENT_FROM		= "CATALOGUE";
	protected $PU_FROM				= "PA";
	protected $ID_ETAT_ANNULE	= 30;

	protected $doc_fusion_dispo;
	protected $doc_fusion_dispo_loaded;



public function open_doc ($select = "", $left_join = "") {
	global $bdd;

	$this->check_profils ();

	$select = ", db.id_stock, s.lib_stock, db.ref_doc_externe ";
	$left_join = " LEFT JOIN doc_blf db ON db.ref_doc = d.ref_doc 
								 LEFT JOIN stocks s ON db.id_stock = s.id_stock";

	if (!$doc = parent::open_doc($select, $left_join)) { return false; }

	$this->id_stock 				= $doc->id_stock;
	$this->lib_stock 				= $doc->lib_stock;
	$this->ref_doc_externe	= $doc->ref_doc_externe;

	if ($this->id_etat_doc == 31) {
		$this->quantite_locked = true;
	}

	return true;
}



// *************************************************************************************************************
// FONCTIONS LIEES A LA CREATION D'UN DOCUMENT
// *************************************************************************************************************

public function create_doc () { 
	global $bdd;
	global $DEFAUT_APP_TARIFS_FOURNISSEUR;

	$this->app_tarifs = $DEFAUT_APP_TARIFS_FOURNISSEUR;

	$this->id_stock 	= $_SESSION['magasin']->getId_stock();
	$this->lib_stock 	= $_SESSION['magasin']->getLib_stock();
	if (isset($GLOBALS['_OPTIONS']['CREATE_DOC']['id_stock']) && 
			isset($_SESSION['stocks'][$GLOBALS['_OPTIONS']['CREATE_DOC']['id_stock']])) {
		$this->id_stock		= $GLOBALS['_OPTIONS']['CREATE_DOC']['id_stock'];
		$this->lib_stock	= $_SESSION['stocks'][$this->id_stock]->getLib_stock();
	}
	if (isset($GLOBALS['_OPTIONS']['CREATE_DOC']['code_affaire'])) {
		$this->code_affaire = $GLOBALS['_OPTIONS']['CREATE_DOC']['code_affaire'];
	}
	if (isset($GLOBALS['_OPTIONS']['CREATE_DOC']['ref_doc_externe'])) {
		$this->ref_doc_externe = $GLOBALS['_OPTIONS']['CREATE_DOC']['ref_doc_externe'];
	}

	if (!parent::create_doc()) { return false; }

	// *************************************************
	// Insertion des informations spécifiques
	$query = "INSERT INTO doc_blf (ref_doc, id_stock, ref_doc_externe)
						VALUES ('".$this->ref_doc."', '".$this->id_stock."', '".$this->ref_doc_externe."') ";
	$bdd->exec ($query);

	return true;
}


// Charge les informations supplémentaire du contact
protected function load_infos_contact () {
	$this->load_infos_contact_fournisseur();
	parent::load_infos_contact();
}

// Renvoie le type d'afichage des tarifs a utiliser (HT ou TTC) pour le document
protected function define_aff_tarif () {
	$this->define_fournisseur_aff_tarif();
}

// *************************************************************************************************************
// FONCTIONS LIEES A LA MODIFICATION DE L'ETAT D'UN DOCUMENT
// *************************************************************************************************************


//fonction de mise à jour de l'app_tarif du contact en cas de changement d'app_tarif du document
public function maj_app_tarifs ($new_app_tarifs) {
	global $bdd;
	global $FOURNISSEUR_ID_PROFIL;

	// Controle
	if ($new_app_tarifs != "HT") {
		$new_app_tarifs == "TTC";
	}
	$this->app_tarifs = $new_app_tarifs;
	
	// Maj de la base de données
	$query = "UPDATE documents SET app_tarifs = '".$this->app_tarifs."'
						WHERE ref_doc = '".$this->ref_doc."' ";
	$bdd->exec ($query);
	
	//on met à jour l'app_tarif du contact en fonction du profil / doc dans le même temps
	if (!is_object($this->contact)) { $this->contact = new contact ($this->ref_contact); }
	if ($this->contact->charger_profiled_infos($FOURNISSEUR_ID_PROFIL)) {
		$profil_tmp = $this->contact->getProfil($FOURNISSEUR_ID_PROFIL);
		$profil_tmp->maj_app_tarifs ($this->app_tarifs);
	}
}

// Liste des documents pouvant être fusionner
public function check_allow_fusion ($second_document) {
	//verifcation que l'état des document permet la fusion
	if (($this->id_etat_doc != "29") && ($second_document->getId_etat_doc () != "29")) {
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
						WHERE d.id_etat_doc = '29' && d.ref_contact = '".$this->ref_contact."' && d.ref_doc != '".$this->ref_doc."'
						GROUP BY d.ref_doc
						ORDER BY date_doc DESC ";
	$resultat = $bdd->query ($query);
	while ($doc = $resultat->fetchObject()) {$this->doc_fusion_dispo[] = $doc;}
	
	$this->doc_fusion_dispo_loaded = true;
	return true;
}




// Met à jour la ref_doc_externe
public function maj_ref_doc_externe ($ref_doc_externe) {
	global $bdd; 
 
	$this->ref_doc_externe = $ref_doc_externe;
 
	// *************************************************
	// MAJ de la base
	$query = "UPDATE doc_blf
						SET ref_doc_externe = '".addslashes($this->ref_doc_externe)."'
						WHERE ref_doc = '".$this->ref_doc."' ";
	$bdd->exec ($query);

	return true;
}



// *************************************************************************************************************
// FONCTIONS DE GESTION DU CONTENU
// *************************************************************************************************************
protected function doc_line_infos_supp () {
	$query['select']			= ", dl_blf.ref_doc_line_cdf, dl_blf.ref_article_externe";
	$query['left_join'] 	= " LEFT JOIN doc_lines_blf dl_blf ON dl_blf.ref_doc_line = dl.ref_doc_line";
	return $query;
}

//affichage dans les résultat du prix achat fournisseur ou de la valeur d'achat actuelle
protected function select_article_pa ($article) {

	$ref_externes = $article->charger_ref_article_externe_fournisseur($this->ref_contact);
	
	if (isset($ref_externes[0])) {return $ref_externes[0]->pa_unitaire;}
	return $article->getPaa_ht();

}

//fonction d'ajout des infos supp d'une ligne article
public function add_line_article_info_supp ($ref_doc_line, $ref_article) {
	global $bdd;
	
	$article = new article ($ref_article);
	$ref_article_externe = "";
	$ref_externes = $article->charger_ref_article_externe_fournisseur($this->ref_contact);
	
	if (isset($ref_externes[0])) {$ref_article_externe = $ref_externes[0]->ref_article_externe;}
	
	$query = "UPDATE doc_lines_blf SET ref_article_externe = '".$ref_article_externe."' 
						WHERE ref_doc_line = '".$ref_doc_line."' ";
	$resultat = $bdd->query ($query);
	if (!$resultat->rowCount()) {
		// La ligne n'existe pas il faut la créer
		$query = "INSERT INTO doc_lines_blf (ref_doc_line, ref_article_externe)
							VALUES ('".$ref_doc_line."', '".$ref_article_externe."') ";
		$bdd->exec ($query);
	}


	return true;
}

//fonction de maj de la ref_article_externe
public function maj_line_ref_article_externe ($ref_doc_line , $ref_article_externe, $old_ref_article_externe = "", $ref_article) {
	global $bdd;
	
	//si le document n'est pas annulé ou en cours de saisie, on met à jour les ref_externes de l'article
	switch ($this->id_etat_doc) {
	case 31:
			//si un contact est défini et que na nouvelle ref_article_externe n'est pas vide
			if ($this->ref_contact) {
				//chargement de la ligne
				$line = $this->charger_line ($ref_doc_line);
				// on charge l'article
				$article = new article ($ref_article);
				$article->maj_ref_article_externe ($this->ref_contact, $ref_article_externe, $old_ref_article_externe, $line->pu_ht, $this->date_creation);
				
				// en cas d'erreur, on ne met pas à jour la ref_externe dans la ligne de document
				if (count($GLOBALS['_ALERTES'])) {
					return false;
				}
			}
		break;
	}
	
	// pas de mise à jour si  les ref_articles_externes sont identiques
	if ($ref_article_externe == $old_ref_article_externe) {return true;}
	//mise à jour de la ligne article si pas de problème concernant la mise à jour
	$query = "UPDATE doc_lines_blf SET ref_article_externe = '".$ref_article_externe."' 
						WHERE ref_doc_line = '".$ref_doc_line."' ";
	$resultat = $bdd->query ($query);
	if (!$resultat->rowCount()) {
		// La ligne n'existe pas il faut la créer
		$query = "INSERT INTO doc_lines_blf (ref_doc_line, ref_article_externe)
							VALUES ('".$ref_doc_line."', '".$ref_article_externe."') ";
		$bdd->exec ($query);
	}

	$GLOBALS['_INFOS']['ref_article_externe'] = $ref_article_externe;

	return true;
}




// *************************************************************************************************************
// FONCTIONS LIEES A LA MODIFICATION DE L'ETAT D'UN DOCUMENT
// *************************************************************************************************************

// Action avant de changer l'état du document
protected function action_before_maj_etat ($new_etat_doc) {
global $CALCUL_VAS;
	switch ($this->id_etat_doc) {
		case 29: case 30:
			if ($new_etat_doc == 31) {
				//mise à jour des ref_articles externes 
					if (!$this->contenu_loaded) { $this->charger_contenu(); }
					
					for ($i=0; $i<count($this->contenu); $i++) {
						if ($this->contenu[$i]->type_of_line != 'article') { continue;}
						// on charge l'article
						$article = new article ($this->contenu[$i]->ref_article);
						if ($this->ref_contact) {
							$article->maj_ref_article_externe ($this->ref_contact, $this->contenu[$i]->ref_article_externe, $this->contenu[$i]->ref_article_externe, $this->contenu[$i]->pu_ht, $this->date_creation);
						}
						if (($CALCUL_VAS != "3" || !$this->ref_contact) && $this->contenu[$i]->pu_ht != 0) {
							$article->maj_prix_achat_ht( $this->contenu[$i]->pu_ht,  $this->contenu[$i]->qte);
						}
					}
				
				
				$this->add_content_to_stock();
				
			}
		break;
		case 31:
			if ($new_etat_doc == 29 || $new_etat_doc == 30) {
				if (!$this->contenu_loaded) { $this->charger_contenu(); }
				for ($i=0; $i<count($this->contenu); $i++) {
					if ($this->contenu[$i]->type_of_line != 'article') { continue;}
					// on charge l'article
					$article = new article ($this->contenu[$i]->ref_article);
					if ($CALCUL_VAS == "1") {
						$article->annule_maj_prix_achat_ht( $this->contenu[$i]->pu_ht,  $this->contenu[$i]->qte);
					}
				}
				$this->del_content_from_stock();
			}
		break;
	}
	return true;
}


// Action après de changer l'état du document
protected function action_after_maj_etat ($old_etat_doc) {
	global $bdd;

	switch ($old_etat_doc) {
		case 29: case 30:
			if ($this->id_etat_doc == 31) {
				// Préciser dans la commande associée que la qté est reçue
				$this->maj_cdf_qte_recue (1);
				
				if (!$this->contenu_materiel_loaded) { $this->charger_contenu_materiel (); }
				foreach ($this->contenu_materiel as $doc_line) {
					edi_event(116,$doc_line->ref_article); 
				}
				
			}
		break;
		case 31:
			// Préciser dans la commande associée que la qté n'est pas reçue
			$this->maj_cdf_qte_recue (-1);
		break;
	}

	if ($this->id_etat_doc == 31) {
		$this->quantite_locked = true;
	} else {
		$this->quantite_locked = false;
	}

	return true;
}






// *************************************************************************************************************
// FONCTIONS DIVERSES 
// *************************************************************************************************************

// PROFILS DE CONTACT NECESSAIRE POUR UTILISER CE TYPE DE DOCUMENT
function check_profils () {
	return $this->check_profil_fournisseur();
}



//fonctions de mise à jour lignes si non bloquée 
protected function add_line_article ($infos) {
	if (!$this->quantite_locked) {
		parent::add_line_article ($infos);
	}
}

public function delete_line ($ref_doc_line) {
	if (!$this->quantite_locked) {
		parent::delete_line ($ref_doc_line);
	}
	
}

public function maj_line_qte ($ref_doc_line, $new_qte) {
	if (!$this->quantite_locked) {
		parent::maj_line_qte ($ref_doc_line, $new_qte);
	}
}

public function maj_line_pu_ht ($ref_doc_line, $new_pu_ht) {
	if (!$this->quantite_locked) {
		parent::maj_line_pu_ht ($ref_doc_line, $new_pu_ht);
	}
}
public function maj_line_tva ($ref_doc_line, $new_tva) {
	if (!$this->quantite_locked) {
		parent::maj_line_tva ($ref_doc_line, $new_tva);
	}
}

public function maj_line_remise ($ref_doc_line, $new_remise) {
	if (!$this->quantite_locked) {
		parent::maj_line_remise ($ref_doc_line, $new_remise);
	}
}

public function set_line_visible ($ref_doc_line) {
	if (!$this->quantite_locked) {
		parent::set_line_visible ($ref_doc_line);
	}
}

public function set_line_invisible ($ref_doc_line) {
	if (!$this->quantite_locked) {
		parent::set_line_invisible ($ref_doc_line);
	}
}




// *************************************************************************************************************
// FONCTIONS SPECIFIQUES AU TYPE DE DOC 
// *************************************************************************************************************

// Génère une facture fournisseur à partir de ce bl.
public function generer_fa_fournisseur ($lines = false) {
	$GLOBALS['_OPTIONS']['CREATE_DOC']['ref_adr_contact'] = $this->ref_adr_contact;
	$GLOBALS['_OPTIONS']['CREATE_DOC']['adresse_contact'] = $this->adresse_contact;
	$GLOBALS['_OPTIONS']['CREATE_DOC']['code_postal_contact'] = $this->code_postal_contact;
	$GLOBALS['_OPTIONS']['CREATE_DOC']['ville_contact'] = $this->ville_contact;
	$GLOBALS['_OPTIONS']['CREATE_DOC']['id_pays_contact'] = $this->id_pays_contact;
	$GLOBALS['_OPTIONS']['CREATE_DOC']['code_affaire'] = $this->code_affaire;

	if (is_array($lines)) {
		$GLOBALS['_OPTIONS']['CREATE_DOC']['doc_lines'] = $lines;
	}
	return $this->copie_doc (8);
}


// Génère un retour des produits sélectionnés
public function generer_retour_fournisseur ($lines = false) {
	// Possible uniquement si le BL est recu
	if ($this->id_etat_doc != 31) { return false; }
	
	if (is_array($lines)) {
		$GLOBALS['_OPTIONS']['CREATE_DOC']['doc_lines'] = $lines;
	}
	$GLOBALS['_OPTIONS']['CREATE_DOC']['code_affaire'] = $this->code_affaire;

	return $this->copie_doc (7);
}



// *************************************************************************************************************
// FONCTIONS DE RECOPIE D'UN DOCUMENT
// *************************************************************************************************************
// Lors de la copie vers un Bon de Livraison, la Quantité à livrer est inversée si il s'agit d'un retour
function action_before_copie_line_to_doc ($doc, $line) {
	if ($doc->getID_TYPE_DOC() != 7 || isset($GLOBALS['_OPTIONS']['FUSION'])) { return true; }

	$line->qte = -$line->qte;

	return true;
}

// Liaison entre les lignes des documents de la BLC et du BLC
function action_after_copie_line_to_doc ($new_doc, $line) {
	global $bdd;
	//en cas de fusion on met à jour les doc_lines_blc pour correspondance avec les CDC
  if (isset($GLOBALS['_OPTIONS']['FUSION'])) {
		$query = "UPDATE doc_lines_blf SET ref_doc_line = '".$line->ref_doc_line."'
							WHERE  ref_doc_line = '".$line->old_ref_doc_line."' ";
		$bdd->exec ($query);
		
		 return true; 
	}
	
	if ($new_doc->getID_TYPE_DOC () != 8) { return true; }
	
	if (isset($line->type_of_line) && $line->type_of_line != "article") { return true; }
	
	$ref_article_externe = "";
	if (isset($line->ref_article_externe)) {	$ref_article_externe = $line->ref_article_externe;}
	$query = "INSERT INTO doc_lines_faf (ref_doc_line, ref_article_externe)
						VALUES ('".$line->ref_doc_line."', '".$ref_article_externe."') ";
	$bdd->exec ($query);


	return true;
}


public function action_after_copie_line_from_line ($line) {
	global $bdd;

	if (isset($line->type_of_line) && $line->type_of_line != "article") { return true; }
	$ref_article_externe = "";
	if (isset($line->ref_article_externe)) {	$ref_article_externe = $line->ref_article_externe;}
	$query = "INSERT INTO doc_lines_blf (ref_doc_line, ref_article_externe)
						VALUES ('".$line->ref_doc_line."', '".$ref_article_externe."') ";
	$bdd->exec ($query);

	return true;

}

// *************************************************************************************************************
// FONCTIONS LIEES A L'EDITION D'UN DOCUMENT 
// *************************************************************************************************************
protected function check_allow_maj_line_qte () { 
	if ($this->quantite_locked) { return false; }
	return true; 
}


// *************************************************************************************************************
// FONCTIONS DE LIAISON ENTRE DOCUMENTS 
// *************************************************************************************************************
// Chargement les Bon de commande (6) "en cours" (27), non liés à une livraison (7), sauf annulée (30)
public function charger_liaisons_possibles () {
	global $bdd;

	$this->liaisons_possibles = array();
	if ($this->id_etat_doc == 30 || $this->id_etat_doc == 31) {$this->liaisons_possibles_loaded = true; return true;}
	
	$query = "SELECT d.ref_doc, d.id_type_doc, dt.lib_type_doc, d.id_etat_doc, de.lib_etat_doc,
									 d.date_creation_doc date_creation
						FROM documents d
							LEFT JOIN documents_types dt ON d.id_type_doc = dt.id_type_doc 
							LEFT JOIN documents_etats de ON d.id_etat_doc = de.id_etat_doc 
							LEFT JOIN documents_liaisons dl ON d.ref_doc = dl.ref_doc_source && dl.active = 1
							LEFT JOIN documents d2 ON d2.ref_doc = dl.ref_doc_destination && d2.id_type_doc = 7  
						WHERE d.ref_contact = ".ref_or_null($this->ref_contact)." 
									&& (d.id_type_doc = 6 && d.id_etat_doc = 27 ) && d2.ref_doc != '".$this->ref_doc."' 
						ORDER BY date_creation  "; 
// && d2.ref_doc IS NULL 
	$resultat = $bdd->query($query); 
	while ($tmp = $resultat->fetchObject()) { $this->liaisons_possibles[] = $tmp; }

	$this->liaisons_possibles_loaded = true;

	return true;
}


// Action en cas de rupture d'une liaison
protected function action_before_break_liaison ($ref_doc) {
	global $bdd;

	// *************************************************
	// Actions spéciales uniquement en cas de rupture d'une liaison avec une CDF
	$query = "SELECT id_type_doc FROM documents WHERE ref_doc = '".$this->ref_doc."'";
	$resultat = $bdd->query ($query);
	if (!$doc = $resultat->fetchObject()) { return false; }
	if ($doc->id_type_doc != 6) { return false; }

	// *************************************************
	// Diminution des quantités livrées le cas échéant
	if ($this->id_etat_doc == 31) {
		$this->maj_cdf_qte_recue(-1);
	}

	// *************************************************
	// Suppression de la liaison ligne à ligne
	$query = "UPDATE doc_lines_blf dl_blf, docs_lines dl1, docs_lines dl2
						SET dl_blf.ref_doc_line_cdf = NULL 
						WHERE dl1.ref_doc = '".$ref_doc."' && dl2.ref_doc = '".$this->ref_doc."' &&
									dl_blf.ref_doc_line_cdf = dl1.ref_doc_line && dl_blf.ref_doc_line = dl2.ref_doc_line ";
	$bdd->exec ($query);

	return true;
}



// *************************************************************************************************************
// FONCTIONS DE GESTION DES REGLEMENTS
// *************************************************************************************************************
protected function need_infos_facturation () {
	// Si la réception a eu lieu, ou si elle est annulée, les informations de facturation seront gérées dans la facture.
	if ($this->id_etat_doc == $this->ID_ETAT_ANNULE || $this->id_etat_doc == 31) { return false; }
	return true;
}



// *************************************************************************************************************
// FONCTIONS DIVERSES
// *************************************************************************************************************
function maj_cdf_qte_recue ($add = 1) {
	global $bdd;

	$signe = "+";
	if ($add != 1) { $signe = "-"; }

	if (!$this->contenu_loaded) { $this->charger_contenu(); }

	$liste_of_lines = "''";
	for ($i=0; $i<count($this->contenu); $i++) {
		if (isset($this->contenu[$i]->type_of_line) && $this->contenu[$i]->type_of_line != "article") { continue; }
		if (!$this->contenu[$i]->ref_doc_line_cdf || !$this->contenu[$i]->qte) { continue; }

		$query = "UPDATE doc_lines_cdf SET qte_recue = qte_recue ".$signe." ".$this->contenu[$i]->qte." 
							WHERE ref_doc_line = '".$this->contenu[$i]->ref_doc_line_cdf."' ";
		$resultat = $bdd->query ($query);
		if (!$resultat->rowCount()) {
			// La ligne n'existe pas il faut la créer
			$query = "INSERT INTO doc_lines_cdf (ref_doc_line, qte_recue)
								VALUES ('".$this->contenu[$i]->ref_doc_line_cdf."', '".$this->contenu[$i]->qte."') ";
			$bdd->exec ($query);
		}

		$liste_of_lines .= ",'".$this->contenu[$i]->ref_doc_line_cdf."'";
	}

	// Vérification de l'état des commandes livrées
	$query = "SELECT DISTINCT(ref_doc) ref_doc
						FROM docs_lines 
						WHERE ref_doc_line IN (".$liste_of_lines.") ";
	$resultat = $bdd->query ($query);
	$docs_cdf = array();
	while ($var = $resultat->fetchObject()) { 
		$cdf = open_doc ($var->ref_doc); 
		$cdf->check_if_traitee ();
	}
}


// *************************************************************************************************************
// FONCTIONS DE RESTITUTION DES DONNEES 
// *************************************************************************************************************

function getId_Stock () {
	return $this->id_stock;
}

function getRef_doc_externe () {
	return $this->ref_doc_externe;
}

function getDoc_fusion_dispo () {
	if (!$this->doc_fusion_dispo_loaded) {$this->liste_doc_fusion ();}
	return  $this->doc_fusion_dispo;
}
 


}

?>
