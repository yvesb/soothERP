<?php
// *************************************************************************************************************
// CLASSE REGISSANT LES INFORMATIONS SUR UN DOCUMENT DE TYPE DEVIS FOURNISSEUR / COTATION
// *************************************************************************************************************


final class doc_def extends document {

	protected $ref_doc_externe;
	protected $date_echeance;
	protected $id_stock;

	protected $ID_TYPE_DOC 					= 5;
	protected $LIB_TYPE_DOC 				= "Devis Fournisseur";
	protected $CODE_DOC 						= "DEF";
	protected $DOC_ID_REFERENCE_TAG = 19;

	protected $DEFAUT_ID_ETAT = 20;
	protected $DEFAUT_LIB_ETAT = "En saisie";
	protected $GESTION_SN	 		= 0;
	protected $CONTENT_FROM		= "CATALOGUE";
	protected $PU_FROM				= "PA";
	protected $ID_ETAT_ANNULE	= 21;



public function open_doc ($select = "", $left_join = "") {
	global $bdd;

	$this->check_profils ();

	$select = ", dd.ref_doc_externe, dd.date_echeance, dd.id_stock ";
	$left_join = " LEFT JOIN doc_def dd ON dd.ref_doc = d.ref_doc ";

	if (!$doc = parent::open_doc($select, $left_join)) { return false; }

	$this->ref_doc_externe		= $doc->ref_doc_externe;
	$this->date_echeance			= $doc->date_echeance;
	$this->id_stock	= $doc->id_stock;

	return true;
}



// *************************************************************************************************************
// FONCTIONS LIEES A LA CREATION D'UN DOCUMENT
// *************************************************************************************************************

public function create_doc () { 
	global $bdd;
	global $DEVIS_FOURNISSEUR_LT;
	global $FOURNISSEUR_ID_PROFIL;
	global $DEFAUT_APP_TARIFS_FOURNISSEUR;

	$this->app_tarifs = $DEFAUT_APP_TARIFS_FOURNISSEUR;

	if (!parent::create_doc()) { return false; }

	if (isset($GLOBALS['_OPTIONS']['CREATE_DOC']['ref_doc_externe'])) {
		$this->ref_doc_externe = $GLOBALS['_OPTIONS']['CREATE_DOC']['ref_doc_externe'];
	}
	if (isset($GLOBALS['_OPTIONS']['CREATE_DOC']['code_affaire'])) {
		$this->code_affaire = $GLOBALS['_OPTIONS']['CREATE_DOC']['code_affaire'];
	}
	$this->date_echeance 	= date ("Y-m-d", time()+$DEVIS_FOURNISSEUR_LT);
	if (isset($GLOBALS['_OPTIONS']['CREATE_DOC']['date_echeance'])) {
		$this->date_echeance = $GLOBALS['_OPTIONS']['CREATE_DOC']['date_echeance'];
	}

	$this->id_stock = $_SESSION['magasin']->getId_stock();
	if (isset($GLOBALS['_OPTIONS']['CREATE_DOC']['id_stock'])) {
		$this->id_stock = $GLOBALS['_OPTIONS']['CREATE_DOC']['id_stock'];
	}
	elseif (is_object($this->contact)) { // Stock de livraison par défaut pour ce fournisseur
		$infos_fournisseur = $this->contact->getProfil($FOURNISSEUR_ID_PROFIL);
		if ($infos_fournisseur->getId_stock_livraison()) {
			$this->id_stock = $infos_fournisseur->getId_stock_livraison();
		}
	}

	$query = "INSERT INTO doc_def (ref_doc, ref_doc_externe, date_echeance, id_stock)
						VALUES ('".$this->ref_doc."', '".addslashes($this->ref_doc_externe)."', '".$this->date_echeance."', 
										'".$this->id_stock."') ";
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
// FONCTIONS LIEES A LA MODIFICATION D'UN DOCUMENT
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

// Met à jour la ref_doc_externe
public function maj_ref_doc_externe ($ref_doc_externe) {
	global $bdd;	

	$this->ref_doc_externe = $ref_doc_externe;

	// *************************************************
	// MAJ de la base
	$query = "UPDATE doc_def 
						SET ref_doc_externe = '".addslashes($this->ref_doc_externe)."'
						WHERE ref_doc = '".$this->ref_doc."' ";
	$bdd->exec ($query);
	
	return true;
}




//fonction de maj de la ref_article_externe
public function maj_line_ref_article_externe ($ref_doc_line , $ref_article_externe, $old_ref_article_externe = "", $ref_article) {
	global $bdd;
	
	//si le document n'est pas annulé ou en cours de saisie, on met à jour les ref_externes de l'article
	switch ($this->id_etat_doc) {
	case 22: case 23:
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
	if ($ref_article_externe == $old_ref_article_externe) {return false;}
	//mise à jour de la ligne article si pas de problème concernant la mise à jour
	$query = "UPDATE doc_lines_def SET ref_article_externe = '".$ref_article_externe."' 
						WHERE ref_doc_line = '".$ref_doc_line."' ";
	$resultat = $bdd->query ($query);
	if (!$resultat->rowCount()) {
		// La ligne n'existe pas il faut la créer
		$query = "INSERT INTO doc_lines_def (ref_doc_line, ref_article_externe)
							VALUES ('".$ref_doc_line."', '".$ref_article_externe."') ";
		$bdd->exec ($query);
	}

	$GLOBALS['_INFOS']['ref_article_externe'] = $ref_article_externe;

	return true;
}




// Met à jour la date d'échéance du devis
public function maj_date_echeance ($new_date_echeance) {
	global $bdd;
	
	$this->date_echeance = $new_date_echeance;
	
	$query = "UPDATE doc_def SET date_echeance = '".addslashes($this->date_echeance)."'
						WHERE ref_doc = '".$this->ref_doc."' ";
	$bdd->exec ($query);
	
	return true;
}




// *************************************************************************************************************
// FONCTIONS DE GESTION DU CONTENU
// *************************************************************************************************************

protected function doc_line_infos_supp () {
	$query['select']			= ", dl_def.ref_article_externe";
	$query['left_join'] 	= " LEFT JOIN doc_lines_def dl_def ON dl_def.ref_doc_line = dl.ref_doc_line";
	return $query;
}

//fonction d'ajout des infos supp d'une ligne article
public function add_line_article_info_supp ($ref_doc_line, $ref_article) {
	global $bdd;
	
	$article = new article ($ref_article);
	$ref_article_externe = "";
	$ref_externes = $article->charger_ref_article_externe_fournisseur($this->ref_contact);
	
	if (isset($ref_externes[0])) {$ref_article_externe = $ref_externes[0]->ref_article_externe;}
	
	$query = "UPDATE doc_lines_def SET ref_article_externe = '".$ref_article_externe."' 
						WHERE ref_doc_line = '".$ref_doc_line."' ";
	$resultat = $bdd->query ($query);
	if (!$resultat->rowCount()) {
		// La ligne n'existe pas il faut la créer
		$query = "INSERT INTO doc_lines_def (ref_doc_line, ref_article_externe)
							VALUES ('".$ref_doc_line."', '".$ref_article_externe."') ";
		$bdd->exec ($query);
	}

	return true;
}

//affichage dans les résultat du prix achat fournisseur ou de la valeur d'achat actuelle
protected function select_article_pa ($article) {

	$ref_externes = $article->charger_ref_article_externe_fournisseur($this->ref_contact);
	
	if (isset($ref_externes[0])) {return $ref_externes[0]->pa_unitaire;}
	return $article->getPaa_ht();

}

// *************************************************************************************************************
// FONCTIONS LIEES A LA MODIFICATION DE L'ETAT D'UN DOCUMENT
// *************************************************************************************************************

// Action après de changer l'état du document
protected function action_after_maj_etat ($old_etat_doc) {
	
	// Si passage a un état Devis Accepté, création du bon de commande lié
	if ($this->id_etat_doc == 23) {
		$this->generer_commande_fournisseur();
	}
	
	if ($this->id_etat_doc == 22 || $this->id_etat_doc == 23 ) {
		//mise à jour des ref_articles externes 
		if ($this->ref_contact) {
			if (!$this->contenu_loaded) { $this->charger_contenu(); }
			
			for ($i=0; $i<count($this->contenu); $i++) {
			if ($this->contenu[$i]->type_of_line != 'article') { continue;}
			// on charge l'article
			$article = new article ($this->contenu[$i]->ref_article);
			$article->maj_ref_article_externe ($this->ref_contact, $this->contenu[$i]->ref_article_externe, $this->contenu[$i]->ref_article_externe, $this->contenu[$i]->pu_ht, $this->date_creation);
			}
		}
	}
	return true;
}



// *************************************************************************************************************
// FONCTIONS DIVERSES 
// *************************************************************************************************************

// PROFILS DE CONTACT NECESSAIRE POUR UTILISER CE TYPE DE DOCUMENT
function check_profils () {
	return $this->check_profil_fournisseur ();
}



// *************************************************************************************************************
// FONCTIONS SPECIFIQUES AU TYPE DE DOC 
// *************************************************************************************************************

// Génère une commande fournisseur à partir de ce devis.
public function generer_commande_fournisseur ($lines = false) {

	$GLOBALS['_OPTIONS']['CREATE_DOC']['id_stock'] = $this->id_stock;
	$GLOBALS['_OPTIONS']['CREATE_DOC']['code_affaire'] = $this->code_affaire;
	if (is_array($lines)) {
		$GLOBALS['_OPTIONS']['CREATE_DOC']['doc_lines'] = $lines;
	}
	return $this->copie_doc (6);
}


// Génère une devis fournisseur à partir de ce devis.
public function generer_devis_fournisseur ($lines = false) {

	$GLOBALS['_OPTIONS']['CREATE_DOC']['id_stock'] = $this->id_stock;
	$GLOBALS['_OPTIONS']['CREATE_DOC']['code_affaire'] = $this->code_affaire;
	if (is_array($lines)) {
		$GLOBALS['_OPTIONS']['CREATE_DOC']['doc_lines'] = $lines;
	}
	
	return $this->copie_doc (5);
}


// *************************************************************************************************************
// FONCTIONS DE RECOPIE D'UN DOCUMENT
// *************************************************************************************************************

// Liaison entre les lignes des documents
function action_after_copie_line_to_doc ($new_doc, $line) {
	global $bdd;

	if ($new_doc->getID_TYPE_DOC () != 6) { return true; }
	
	if (isset($line->type_of_line) && $line->type_of_line != "article") { return true; }
	
	$ref_article_externe = "";
	if (isset($line->ref_article_externe)) {	$ref_article_externe = $line->ref_article_externe;}
	$query = "INSERT INTO doc_lines_cdf (ref_doc_line, ref_article_externe)
						VALUES ('".$line->ref_doc_line."', '".$ref_article_externe."') ";
	$bdd->exec ($query);

	return true;
}


public function action_after_copie_line_from_line ($line) {
	global $bdd;


	if (isset($line->type_of_line) && $line->type_of_line != "article") { return true; }
	
	$ref_article_externe = "";
	if (isset($line->ref_article_externe)) {	$ref_article_externe = $line->ref_article_externe;}
	$query = "INSERT INTO doc_lines_def (ref_doc_line, ref_article_externe)
						VALUES ('".$line->ref_doc_line."', '".$ref_article_externe."') ";
	$bdd->exec ($query);

	return true;

}


// *************************************************************************************************************
// FONCTIONS LIEES A L'EDITION D'UN DOCUMENT 
// *************************************************************************************************************
// Edition
protected function edit_doc ($id_edition_mode, $infos) {
	global $bdd;

	// Si édition d'un devis en saisie, le devis est pret!
	if ($this->id_etat_doc == 20) {
		$this->maj_etat_doc(22);
	}
	
	return parent::edit_doc($id_edition_mode, $infos);
}


// *************************************************************************************************************
// FONCTIONS LIEES A LA RECHERCHE D'ARTICLE POUR INSERTION DANS LE DOCUMENT 
// *************************************************************************************************************
public function auto_search_articles ($id_type_recherche) {
	global $search;
	
	switch ($id_type_recherche) {
	case 1: // Recherche des articles à recommander

	$query_more['query_select']	= "	, zasa.seuil_alerte, zsa.qte ";
	$query_more['query_join']		= "
							LEFT JOIN articles_stocks_alertes zasa ON  zasa.ref_article = a.ref_article
							LEFT JOIN stocks_articles zsa ON zsa.ref_article = zasa.ref_article && zsa.id_stock = '".$search['id_stock']."'";
	$query_more['query_where']	= " && zasa.id_stock = '".$search['id_stock']."'  && ( zasa.seuil_alerte > zsa.qte || (ISNULL(zsa.qte) && zasa.seuil_alerte > 0))";
	break;
	
	case 2: // Recherche des articles en commande
		$query_more['query_select'] = ", SUM(dlc.qte_livree) as qte_livree, SUM(dl.qte) as qte ";
		$query_more['query_join']  = " LEFT JOIN documents d ON (d.id_type_doc = 2 && d.id_etat_doc = 9 )
																	 LEFT JOIN docs_lines dl ON (d.ref_doc = dl.ref_doc  && dl.ref_article = a.ref_article)
																	 LEFT JOIN doc_lines_cdc dlc ON dl.ref_doc_line = dlc.ref_doc_line";
		$query_more['query_where'] = " && !ISNULL(dl.qte) && dl.qte>0";
   
		$query_more['query_group'] = "";
	break;
	}
	
	
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

function getId_stock () {
	return $this->id_stock;
}


}

?>