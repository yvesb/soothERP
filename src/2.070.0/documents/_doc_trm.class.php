<?php
// *************************************************************************************************************
// CLASSE REGISSANT LES INFORMATIONS SUR UN DOCUMENT DE TYPE TRANSFERT DE MARCHANDISES
// *************************************************************************************************************


final class doc_trm extends document {

	protected $id_stock_source;
	protected $id_stock_cible;
	protected $lib_stock_source;
	protected $lib_stock_cible;

	protected $id_livraison_mode;

	protected $ref_transporteur;
	protected $nom_transporteur;

	protected $ID_TYPE_DOC 					= 9;
	protected $LIB_TYPE_DOC 				= "Transfert de Marchandises";
	protected $CODE_DOC 						= "TRM";
	protected $DOC_ID_REFERENCE_TAG = 24;

	protected $DEFAUT_ID_ETAT = 36;
	protected $DEFAUT_LIB_ETAT 	= "En saisie";
	protected $GESTION_SN	 		= 1;
	protected $CONTENT_FROM		= "CATALOGUE";
	protected $PU_FROM				= "PA";
	protected $ID_ETAT_ANNULE	= 37;



public function open_doc ($select = "", $left_join = "") {
	global $bdd;

	$this->check_profils ();

	$select = ", dtr.id_stock_source, dtr.id_stock_cible, dtr.id_livraison_mode, s1.lib_stock lib_stock_source, s2.lib_stock lib_stock_cible ";
	$left_join = " LEFT JOIN doc_trm dtr ON dtr.ref_doc = d.ref_doc 
								 LEFT JOIN stocks s1 ON dtr.id_stock_source = s1.id_stock
								 LEFT JOIN stocks s2 ON dtr.id_stock_cible = s2.id_stock ";

	if (!$doc = parent::open_doc($select, $left_join)) { return false; }

	$this->id_stock_source	= $doc->id_stock_source;
	$this->id_stock_cible		= $doc->id_stock_cible;
	$this->lib_stock_source	= $doc->lib_stock_source;
	$this->lib_stock_cible	= $doc->lib_stock_cible;
	$this->id_livraison_mode 	= $doc->id_livraison_mode;

	if ($this->id_etat_doc == 39 || $this->id_etat_doc == 40) {
		$this->quantite_locked = true;
	}

	return true;
}



// *************************************************************************************************************
// FONCTIONS LIEES A LA CREATION D'UN DOCUMENT
// *************************************************************************************************************

public function create_doc () { 
	global $bdd;
	global $DEFAUT_APP_TARIFS_CLIENT;

	$this->app_tarifs = $DEFAUT_APP_TARIFS_CLIENT;

	$this->id_stock_source	= $_SESSION['magasin']->getId_stock();
	$this->lib_stock_source	= $_SESSION['magasin']->getLib_stock();
	$this->id_stock_cible		= "NULL";
	$this->lib_stock_cible	= "";

	if (isset($GLOBALS['_OPTIONS']['CREATE_DOC']['id_stock_source'])) {
		$this->id_stock_source = $GLOBALS['_OPTIONS']['CREATE_DOC']['id_stock_source'];
		if (!isset($_SESSION['stocks'][$this->id_stock_source])) {
			$GLOBALS['_ALERTES']['stock_source_not_actif'] = 1;
			return false;
		}
		$this->lib_stock_source	= $_SESSION['stocks'][$this->id_stock_source]->getLib_stock();
	}

	if (isset($GLOBALS['_OPTIONS']['CREATE_DOC']['id_stock_cible'])) {
		$this->id_stock_cible = $GLOBALS['_OPTIONS']['CREATE_DOC']['id_stock_cible'];
		if (!isset($_SESSION['stocks'][$this->id_stock_cible])) {
			$GLOBALS['_ALERTES']['stock_cible_not_actif'] = 1;
			return false;
		}
		$this->lib_stock_cible = $_SESSION['stocks'][$this->id_stock_cible]->getLib_stock();
	}

	if (!parent::create_doc()) { return false; }

	// *************************************************
	// Insertion des informations spécifiques
	$query = "INSERT INTO doc_trm (ref_doc, id_stock_source, id_stock_cible, ref_transporteur)
						VALUES ('".$this->ref_doc."', '".$this->id_stock_source."', ".num_or_null($this->id_stock_cible).", NULL) ";
	$bdd->exec ($query);

	return true;
}


// Charge les informations supplémentaire du contact
protected function load_infos_contact () {
	return true;
}



// *************************************************************************************************************
// FONCTIONS LIEES A LA MODIFICATION DE L'ETAT D'UN DOCUMENT
// *************************************************************************************************************

public function maj_id_stock_source ($id_stock_source) {
	return $this->maj_id_stock ($id_stock_source, "id_stock_source");
}


public function maj_id_stock_cible ($id_stock_cible = "NULL") {
	global $bdd;	

	if ($id_stock_cible == $this->id_stock_source) {
		$GLOBALS['_ALERTES']['cible_is_source'] = 1;
		return false; 
	}

	if (is_numeric($id_stock_cible)) {
		return $this->maj_id_stock ($id_stock_cible, "id_stock_cible");
	}

	$query = "UPDATE doc_trm 
						SET id_stock_cible = NULL
						WHERE ref_doc = '".$this->ref_doc."' ";
	$bdd->exec ($query);

	// *************************************************
	// Retour des informations
	$GLOBALS['_INFOS']['id_stock_cible'] = 0;

	return true;
}


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

	$query = "UPDATE doc_trm SET id_livraison_mode = ".num_or_null($this->id_livraison_mode)."
						WHERE ref_doc = '".$this->ref_doc."' ";
	$bdd->exec ($query);
	
	//calcul et insertion pour ce document des frais de port (calcul effectué depuis la class livraison mode)
	$livraison_mode->calcul_frais_livraison_doc ($this);
	
	return true;
}

// *************************************************************************************************************
// FONCTIONS DE GESTION DU CONTENU
// *************************************************************************************************************
protected function doc_line_infos_supp () {
	$query['select']			= ", sa.qte stock";
	$query['left_join'] 	= " LEFT JOIN stocks_articles sa ON sa.ref_article = dl.ref_article && 
																			sa.id_stock = '".$this->id_stock_source."' ";
	return $query;
}

// Chargement des informations supplémentaires concernant les numéros de série 
protected function doc_line_sn_infos_supp () {
	$query['select']		= ", IF (ISNULL(sas.numero_serie), 0, 1) as sn_exist";
	$query['left_join'] = " LEFT JOIN stocks_articles_sn sas ON sas.numero_serie = dls.numero_serie";
	return $query;
}






// *************************************************************************************************************
// FONCTIONS LIEES A LA MODIFICATION DE L'ETAT D'UN DOCUMENT
// *************************************************************************************************************

// Action avant de changer l'état du document
protected function action_before_maj_etat ($new_etat_doc) {
	// Aucun changement possible tant que le stock de destination n'est pas terminé
	if (!$this->id_stock_cible) {
		$GLOBALS['_ALERTES']['id_stock_cible_not_defined'] = 1;
	}

	switch ($this->id_etat_doc) {
		case 36: case 37: case 38:
			if ($new_etat_doc == 39 || $new_etat_doc == 40) {
				$this->del_content_from_stock($this->id_stock_source);
			}
			if ($new_etat_doc == 40) {
				$this->add_content_to_stock($this->id_stock_cible);
			}
		break;
		case 39: 
			if ($new_etat_doc == 36 || $new_etat_doc == 37 || $new_etat_doc == 38) {
				$this->add_content_to_stock($this->id_stock_source);
			}
			elseif ($new_etat_doc == 40) {
				$this->add_content_to_stock($this->id_stock_cible);
			}
		break;
		case 40:
			if ($new_etat_doc == 36 || $new_etat_doc == 37 || $new_etat_doc == 38 || $new_etat_doc == 39) {
				$this->del_content_from_stock($this->id_stock_cible);
			}
			if ($new_etat_doc == 36 || $new_etat_doc == 37 || $new_etat_doc == 38) {
				$this->add_content_to_stock($this->id_stock_source);
			}
		break;
	}
	return true;
}


protected function action_after_maj_etat ($old_etat_doc) {
	if ($this->id_etat_doc == 39 || $this->id_etat_doc == 40) {
		$this->quantite_locked = true;
	} else {
		$this->quantite_locked = false;
	}
}


// *************************************************************************************************************
// FONCTIONS DIVERSES 
// *************************************************************************************************************

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



// *************************************************************************************************************
// FONCTIONS DE RECOPIE D'UN DOCUMENT
// *************************************************************************************************************




// *************************************************************************************************************
// FONCTIONS LIEES A L'EDITION D'UN DOCUMENT 
// *************************************************************************************************************



// *************************************************************************************************************
// FONCTIONS DE LIAISON ENTRE DOCUMENTS 
// *************************************************************************************************************



// *************************************************************************************************************
// FONCTIONS DE RESTITUTION DES DONNEES 
// *************************************************************************************************************

function getId_stock_source () {
	return $this->id_stock_source;
}

function getId_stock_cible () {
	return $this->id_stock_cible;
}

function getRef_transporteur () {
	return $this->ref_transporteur;
}

function getNom_transporteur () {
	return $this->nom_transporteur;
}

function getId_livraison_mode () {
	return $this->id_livraison_mode;
}


}

?>