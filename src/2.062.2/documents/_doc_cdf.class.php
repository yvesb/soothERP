<?php
// *************************************************************************************************************
// CLASSE REGISSANT LES INFORMATIONS SUR UN DOCUMENT DE TYPE COMMANDE FOURNISSEUR
// *************************************************************************************************************


final class doc_cdf extends document {

	protected $ref_doc_externe;
	protected $date_livraison;
	protected $id_stock;

	protected $ID_TYPE_DOC 					= 6;
	protected $LIB_TYPE_DOC 				= "Commande Fournisseur";
	protected $CODE_DOC 						= "CDF";
	protected $DOC_ID_REFERENCE_TAG = 20;

	protected $DEFAUT_ID_ETAT 	= 25;
	protected $DEFAUT_LIB_ETAT 	= "En saisie";

	protected $GESTION_SN	 		= 0;
	protected $CONTENT_FROM		= "CATALOGUE";
	protected $PU_FROM				= "PA";
	protected $ACCEPT_REGMT		= -1;
	protected $ID_ETAT_ANNULE	= 26;
	
	protected $doc_fusion_dispo;
	protected $doc_fusion_dispo_loaded;



public function open_doc ($select = "", $left_join = "") {
	global $bdd;

	$this->check_profils ();

	$select = ", dc.ref_doc_externe, dc.date_livraison, dc.id_stock ";
	$left_join = " LEFT JOIN doc_cdf dc ON dc.ref_doc = d.ref_doc ";

	if (!$doc = parent::open_doc($select, $left_join)) { return false; }

	$this->ref_doc_externe	 	= $doc->ref_doc_externe;
	$this->date_livraison 		= $doc->date_livraison;
	$this->id_stock = $doc->id_stock;

	return true;
}



// *************************************************************************************************************
// FONCTIONS LIEES A LA CREATION D'UN DOCUMENT
// *************************************************************************************************************

public function create_doc () { 
	global $bdd;
	global $DEFAUT_APP_TARIFS_FOURNISSEUR;

	$this->app_tarifs = $DEFAUT_APP_TARIFS_FOURNISSEUR;

	if (!parent::create_doc()) { return false; }

	if (isset($GLOBALS['_OPTIONS']['CREATE_DOC']['ref_doc_externe'])) {
		$this->ref_doc_externe = $GLOBALS['_OPTIONS']['CREATE_DOC']['ref_doc_externe'];
	}
	if (isset($GLOBALS['_OPTIONS']['CREATE_DOC']['code_affaire'])) {
		$this->code_affaire = $GLOBALS['_OPTIONS']['CREATE_DOC']['code_affaire'];
	}
	if (isset($GLOBALS['_OPTIONS']['CREATE_DOC']['date_livraison'])) {
		$this->date_livraison = $GLOBALS['_OPTIONS']['CREATE_DOC']['date_livraison'];
	}

	$this->id_stock = $_SESSION['magasin']->getId_stock();
	if (isset($GLOBALS['_OPTIONS']['CREATE_DOC']['id_stock'])) {
		$this->id_stock = $GLOBALS['_OPTIONS']['CREATE_DOC']['id_stock'];
	}

	// Insertion dans la base
	$query = "INSERT INTO doc_cdf 
							(ref_doc, ref_doc_externe, date_livraison, id_stock)
						VALUES ('".$this->ref_doc."', '".addslashes($this->ref_doc_externe)."', 
										'".addslashes($this->date_livraison)."', '".$this->id_stock."' ) ";
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

// Liste des documents pouvant être fusionner
public function check_allow_fusion ($second_document) {
	//verifcation que l'état des document permet la fusion
	if (($this->id_etat_doc != "25" && $this->id_etat_doc != "27") && ($second_document->getId_etat_doc () != "25" && $second_document->getId_etat_doc () != "27")) {
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
						WHERE (d.id_etat_doc = '25' ||  d.id_etat_doc = '27' ) && d.ref_contact = '".$this->ref_contact."' && d.ref_doc != '".$this->ref_doc."'
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
	$query = "UPDATE doc_cdf 
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
	case 27: case 28:
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
	$query = "UPDATE doc_lines_cdf SET ref_article_externe = '".$ref_article_externe."' 
						WHERE ref_doc_line = '".$ref_doc_line."' ";
	$resultat = $bdd->query ($query);
	if (!$resultat->rowCount()) {
		// La ligne n'existe pas il faut la créer
		$query = "INSERT INTO doc_lines_cdf (ref_doc_line, ref_article_externe)
							VALUES ('".$ref_doc_line."', '".$ref_article_externe."') ";
		$bdd->exec ($query);
	}

	$GLOBALS['_INFOS']['ref_article_externe'] = $ref_article_externe;

	return true;
}




// Met à jour la date de livraison demandée
public function maj_date_livraison ($new_date_livraison) {
	global $bdd;
	
	$this->date_livraison = $new_date_livraison;

	$query = "UPDATE doc_cdf SET date_livraison = '".addslashes($this->date_livraison)."'
						WHERE ref_doc = '".$this->ref_doc."' ";
	$bdd->exec ($query);

	return true;
}



// *************************************************************************************************************
// FONCTIONS DE GESTION DU CONTENU
// *************************************************************************************************************

protected function doc_line_infos_supp () {
	$query['select']			= ", dl_cdf.qte_recue, dl_cdf.ref_article_externe";
	$query['left_join'] 	= " LEFT JOIN doc_lines_cdf dl_cdf ON dl_cdf.ref_doc_line = dl.ref_doc_line";
	return $query;
}


// Mise à jour de l'information "qte_recue" d'une ligne de document
static function maj_line_infos_supp ($ref_doc_line, $donnees, $maj_donnees=NULL) {
	$table = "doc_lines_cdf";
	$maj_donnees = "qte_recue = '".$donnees['qte_recue']."' ";

	parent::maj_line_infos_supp ($ref_doc_line, $table, $maj_donnees);

	return true;
}

//fonction d'ajout des infos supp d'une ligne article
public function add_line_article_info_supp ($ref_doc_line, $ref_article) {
	global $bdd;
	
	$article = new article ($ref_article);
	$ref_article_externe = "";
	$ref_externes = $article->charger_ref_article_externe_fournisseur($this->ref_contact);
	
	if (isset($ref_externes[0])) {$ref_article_externe = $ref_externes[0]->ref_article_externe;}
	
	$query = "UPDATE doc_lines_cdf SET ref_article_externe = '".$ref_article_externe."' 
						WHERE ref_doc_line = '".$ref_doc_line."' ";
	$resultat = $bdd->query ($query);
	if (!$resultat->rowCount()) {
		// La ligne n'existe pas il faut la créer
		$query = "INSERT INTO doc_lines_cdf (ref_doc_line, ref_article_externe)
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

// Vérifie si la commande est traitée
function check_if_traitee () {
	global $bdd;

	$this->charger_contenu ();

	$traitee = 1;
	foreach ($this->contenu as $line) {
		if (isset($line->type_of_line) && $line->type_of_line != "article") { continue; }
		if ($line->qte <= $line->qte_recue) { continue; }
		$traitee = 0;
		break;
	}

	if ($traitee) {
		$this->maj_etat_doc(28);
	}
	elseif ($this->id_etat_doc == 28 && !$traitee) {
		$this->maj_etat_doc(27);
	}
}



// *************************************************************************************************************
// FONCTIONS LIEES A LA MODIFICATION DE L'ETAT D'UN DOCUMENT
// *************************************************************************************************************

// Action après de changer l'état du document
protected function action_after_maj_etat ($old_etat_doc) {
	global $bdd;

	if ($this->id_etat_doc == 27 || $this->id_etat_doc == 28 ) {
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

// Génère un Bon de Réception Fournisseur à partir de cette commande.
public function generer_br_fournisseur ($lines = false) {
	$GLOBALS['_OPTIONS']['CREATE_DOC']['ref_adr_contact'] = $this->ref_adr_contact;
	$GLOBALS['_OPTIONS']['CREATE_DOC']['adresse_contact'] = $this->adresse_contact;
	$GLOBALS['_OPTIONS']['CREATE_DOC']['code_postal_contact'] = $this->code_postal_contact;
	$GLOBALS['_OPTIONS']['CREATE_DOC']['ville_contact'] = $this->ville_contact;
	$GLOBALS['_OPTIONS']['CREATE_DOC']['id_pays_contact'] = $this->id_pays_contact;
	$GLOBALS['_OPTIONS']['CREATE_DOC']['code_affaire'] = $this->code_affaire;

	// Insérer le transfert de l'info STOCK
	$GLOBALS['_OPTIONS']['CREATE_DOC']['id_stock'] = $this->id_stock;

	if (is_array($lines)) {
		$GLOBALS['_OPTIONS']['CREATE_DOC']['doc_lines'] = $lines;
	}

	$GLOBALS['_OPTIONS']['CREATE_DOC']['follow_reglement'] = 1;

	return $this->copie_doc(7);
}


// Renouvelle une commande à partir de celle-ci.
public function generer_commande_fournisseur ($lines = false) {
	$GLOBALS['_OPTIONS']['CREATE_DOC']['code_affaire'] = $this->code_affaire;
	// Possible uniquement si la commande est annulée ou traitée
	if ($this->id_etat_doc != 26 && $this->id_etat_doc != 28) { return false; }

	if (is_array($lines)) {
		$GLOBALS['_OPTIONS']['CREATE_DOC']['doc_lines'] = $lines;
	}

	return $this->copie_doc (6);
}



// *************************************************************************************************************
// FONCTIONS DE RECOPIE D'UN DOCUMENT
// *************************************************************************************************************

// Lors de la copie vers un Bon de Livraison, la Quantité à livrer est ajustée à ce qu'il manque
function action_before_copie_line_to_doc ($new_doc, $line) {
	if ($new_doc->getID_TYPE_DOC () != 7 || isset($GLOBALS['_OPTIONS']['FUSION'])) { return true; }

//	for ($i=0; $i<count($this->contenu); $i++) {
//		if ($line->old_ref_doc_line != $this->contenu[$i]->ref_doc_line) { continue; }
//		$line->qte -= $this->contenu[$i]->qte_recue;
//		break;
//	}
		$line->qte -= $line->qte_recue;

		if (!$line->qte) { return false; }
		
	return true;
}


// Liaison entre les lignes des documents
function action_after_copie_line_to_doc ($new_doc, $line) {
	global $bdd;

	//en cas de fusion on met à jour les blf lié et les qté reçues
  if (isset($GLOBALS['_OPTIONS']['FUSION'])) {
		$query = "UPDATE doc_lines_blf SET ref_doc_line_cdf = '".$line->ref_doc_line."'
							WHERE  ref_doc_line_cdf = '".$line->old_ref_doc_line."' ";
		$bdd->exec ($query);
		$query = "UPDATE doc_lines_cdf SET ref_doc_line = '".$line->ref_doc_line."'
							WHERE  ref_doc_line = '".$line->old_ref_doc_line."' ";
		$bdd->exec ($query);
		
		 return true; 
	}
	
	if ($new_doc->getID_TYPE_DOC () != 7) { return true; }
	
	if (isset($line->type_of_line) && $line->type_of_line != "article") { return true; }
	
	$ref_article_externe = "";
	if (isset($line->ref_article_externe)) {	$ref_article_externe = $line->ref_article_externe;}
	$query = "INSERT INTO doc_lines_blf (ref_doc_line, ref_doc_line_cdf, ref_article_externe)
						VALUES ('".$line->ref_doc_line."', '".$line->old_ref_doc_line."', '".$ref_article_externe."') ";
	$bdd->exec ($query);

	return true;
}


public function action_after_copie_line_from_line ($line) {
	global $bdd;

	if (isset($line->type_of_line) && $line->type_of_line != "article") { return true; }
	
	$ref_article_externe = "";
	if (isset($line->ref_article_externe)) {	$ref_article_externe = $line->ref_article_externe;}
	$query = "INSERT INTO doc_lines_cdf (ref_doc_line, ref_article_externe)
						VALUES ('".$line->ref_doc_line."', '".$ref_article_externe."') ";
	$bdd->exec ($query);
	return true;

}


// *************************************************************************************************************
// FONCTIONS LIEES A L'EDITION D'UN DOCUMENT 
// *************************************************************************************************************




// *************************************************************************************************************
// FONCTIONS DE LIAISON ENTRE DOCUMENTS 
// *************************************************************************************************************
// Chargement les Devis Fournisseur (5) "Accepté" (23), non liés à une Commande Fournisseur (6), sauf annulée (26)
public function charger_liaisons_possibles () {
	global $bdd;

	$this->liaisons_possibles = array();
	if ($this->id_etat_doc == 26 || $this->id_etat_doc == 28) {$this->liaisons_possibles_loaded = true; return true;}
	
	$query = "SELECT d.ref_doc, d.id_type_doc, dt.lib_type_doc, d.id_etat_doc, de.lib_etat_doc,
									 d.date_creation_doc date_creation
						FROM documents d
							LEFT JOIN documents_types dt ON d.id_type_doc = dt.id_type_doc 
							LEFT JOIN documents_etats de ON d.id_etat_doc = de.id_etat_doc 
							LEFT JOIN documents_liaisons dl ON d.ref_doc = dl.ref_doc_source && dl.active = 1
							LEFT JOIN documents d2 ON d2.ref_doc = dl.ref_doc_destination && d2.id_type_doc = 6
						WHERE d.ref_contact = ".ref_or_null($this->ref_contact)." && 
									(d.id_type_doc = 5 && d.id_etat_doc = 23 ) && d2.ref_doc IS NULL 
						ORDER BY date_creation "; 
	$resultat = $bdd->query($query); 
	while ($tmp = $resultat->fetchObject()) { $this->liaisons_possibles[] = $tmp; }

	$this->liaisons_possibles_loaded = true;

	return true;
}


// Action en cas de rupture d'une liaison
protected function action_before_break_liaison ($ref_doc) {
	global $bdd;

	// *************************************************
	// Actions spéciales uniquement en cas de rupture d'une liaison avec un BLF
	$query = "SELECT id_type_doc, id_etat_doc FROM documents WHERE ref_doc = '".$this->ref_doc."'";
	$resultat = $bdd->query ($query);
	if (!$doc = $resultat->fetchObject()) { return false; }

	if ($doc->id_type_doc != 7) { return false; }

	// *************************************************
	// Diminution des quantités recues le cas échéant
	if ($doc->id_etat_doc == 31) {
		$query = "UPDATE doc_lines_cdf dl_cdf, doc_lines_blf dl_blf, docs_lines dl1, docs_lines dl2
							SET dl_cdf.qte_recue -= dl2.qte 
							WHERE dl1.ref_doc = '".$this->ref_doc."' && dl2.ref_doc = '".$ref_doc."' &&
										dl_blc.ref_doc_line_cdf = dl1.ref_doc_line && dl_blf.ref_doc_line = dl2.ref_doc_line ";
		$bdd->exec ($query);
	}

	// *************************************************
	// Suppression de la liaison ligne à ligne
	$query = "UPDATE doc_lines_blf dl_blf, docs_lines dl1, docs_lines dl2
						SET dl_blc.ref_doc_line_cdf = NULL 
						WHERE dl1.ref_doc = '".$this->ref_doc."' && dl2.ref_doc = '".$ref_doc."' &&
									dl_blf.ref_doc_line_cdf = dl1.ref_doc_line && dl_blf.ref_doc_line = dl2.ref_doc_line ";
	$bdd->exec ($query);

	return true;
}


// *************************************************************************************************************
// FONCTIONS DE GESTION DES REGLEMENTS
// *************************************************************************************************************

protected function need_infos_facturation () {
	// Si la commande est annulée ou traitée, les informations de facturation ne sont pas nécessaires.
	if ($this->id_etat_doc == $this->ID_ETAT_ANNULE || $this->id_etat_doc == 28) { return false; }
	return true;
}


protected function reglement_partiel () {
	// Une commande en saisie devient "en cours" lorsqu'un règlement est enregistré.
	if ($this->id_etat_doc == 25) {
		$this->maj_etat_doc(27);
	}
	$GLOBALS['INFOS']['change_etat'] = 1;
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

/*
public function auto_search_articles ($id_type_recherche) {
	switch ($id_type_recherche) {
		case 1: // Recherche des articles en commande
			$query_more['query_select']	= " (dl.qte - dlc.qte_livree) as qte_to_command ";
			$query_more['query_join']		= " LEFT JOIN docs_lines dl ON dl.ref_article = a.ref_article
																			LEFT JOIN doc_lines_cdc dlc ON dl.ref_doc_line = dlc.ref_doc_line 
																			LEFT JOIN documents d ON d.ref_doc = dl.ref_doc ";
			$query_more['query_where']	= " && d.id_type_doc = 2 && d.id_etat_doc = 9 ";
	}
	
	return $query_more;
}*/

// *************************************************************************************************************
// FONCTIONS DE RESTITUTION DES DONNEES 
// *************************************************************************************************************

function getRef_doc_externe () {
	return $this->ref_doc_externe;
}

function getDate_livraison () {
	return $this->date_livraison;
}

function getId_stock () {
	return $this->id_stock;
}

function getDoc_fusion_dispo () {
	if (!$this->doc_fusion_dispo_loaded) {$this->liste_doc_fusion ();}
	return  $this->doc_fusion_dispo;
}

 


}

?>