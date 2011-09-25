<?php
// *************************************************************************************************************
// CLASSE REGISSANT LES INFORMATIONS SUR UN DOCUMENT DE TYPE BON DE FABRICATION
// *************************************************************************************************************


final class doc_fab extends document {

	protected $id_stock;

	protected $ref_adr_stock;
	protected $lib_stock;
	protected $ref_article;		//réf de l'article fabriqué
	protected $qte_fab;

	protected $ID_TYPE_DOC 					= 12;
	protected $LIB_TYPE_DOC 				= "Bon de Fabrication";
	protected $CODE_DOC 						= "FAB";
	protected $DOC_ID_REFERENCE_TAG = 28;

	protected $DEFAUT_ID_ETAT 	= 47;
	protected $DEFAUT_LIB_ETAT 	= "En saisie";
	protected $GESTION_SN	 		= 1;
	protected $CONTENT_FROM		= "STOCK";
	protected $PU_FROM				= "PA";
	protected $ACCEPT_REGMT		= 0;
	protected $ID_ETAT_ANNULE	= 48;

	protected $client_facturation;
	protected $client_encours;
	protected $a_facturer = false;
	
	protected $fab_sn; //liste des numéro de série de l'article à fabriquer
	protected $fab_sn_loaded; 
	protected $fab_nl; //liste des numéro de lot de l'article à fabriquer
	protected $fab_nl_loaded; 
	

public function __construct($ref_doc = "") {
	$this->ref_doc = $ref_doc;
}

public function open_doc ($select = "", $left_join = "") {
	global $bdd;

	$this->check_profils ();

	$select = ", df.id_stock, s.lib_stock, df.ref_article, df.qte_fab";
	$left_join = " LEFT JOIN doc_fab df ON df.ref_doc = d.ref_doc 
								 LEFT JOIN stocks s ON df.id_stock = s.id_stock";

	if (!$doc = parent::open_doc($select, $left_join)) { return false; }

	$this->id_stock 				= $doc->id_stock;
	$this->lib_stock 				= $doc->lib_stock;
	$this->ref_article 			=	$doc->ref_article;
	$this->qte_fab 			=	$doc->qte_fab;

	// Blocage des quantités
	if ($this->id_etat_doc == 51) {
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

	$this->id_stock 	= $_SESSION['magasin']->getId_stock();
	$this->lib_stock 	= $_SESSION['magasin']->getLib_stock();

	if (isset($GLOBALS['_OPTIONS']['CREATE_DOC']['id_stock'])) {
		$this->id_stock = $GLOBALS['_OPTIONS']['CREATE_DOC']['id_stock'];
		if (!isset($_SESSION['stocks'][$this->id_stock])) {
			$GLOBALS['_ALERTES']['stock_not_actif'] = 1;
			return false;
		}
		$this->lib_stock = $_SESSION['stocks'][$this->id_stock]->getLib_stock();
	}
	
	$this->ref_article = '';
	if (isset($GLOBALS['_OPTIONS']['CREATE_DOC']['ref_article'])) {$this->ref_article = $GLOBALS['_OPTIONS']['CREATE_DOC']['ref_article'];}
	$this->qte_fab = 0;
	if (isset($GLOBALS['_OPTIONS']['CREATE_DOC']['qte_fab'])) {$this->qte_fab = $GLOBALS['_OPTIONS']['CREATE_DOC']['qte_fab'];}

	if (!parent::create_doc()) { return false; }

	$query = "INSERT INTO doc_fab (ref_doc, id_stock, ref_article, qte_fab)
						VALUES ('".$this->ref_doc."', '".$this->id_stock."', ".ref_or_null($this->ref_article).", ".$this->qte_fab.") ";
	$bdd->exec ($query);

	if (isset($GLOBALS['_OPTIONS']['CREATE_DOC']['ref_article']) && isset($GLOBALS['_OPTIONS']['CREATE_DOC']['qte_fab'])) {
		$this->define_ref_article ($this->ref_article, $this->qte_fab);
	}
	
	return true;
}

// *************************************************************************************************************
// FONCTIONS LIEES A LA MODIFICATION D'UN DOCUMENT
// *************************************************************************************************************
//definition de l'article à fabriquer
public function define_ref_article ($ref_article = "", $qte_fab = 0) {
	global $bdd;
	
	if (!$ref_article) {return false;}
	$this->ref_article = $ref_article;
	$this->qte_fab = $qte_fab;

	$query = "UPDATE doc_fab
						SET ref_article = '". $this->ref_article."', qte_fab = '".$this->qte_fab."'
						WHERE ref_doc = '".$this->ref_doc."' && id_stock = '".$this->id_stock."'";
	$bdd->exec ($query);

	// on supprime les sn qui existeraient deja pour ce document (en cas de changement d'article à fabriquer)
	$this->del_all_fab_sn ();
	
	if (isset($GLOBALS['_OPTIONS']['CREATE_DOC']['fill_content']) && $GLOBALS['_OPTIONS']['CREATE_DOC']['fill_content']) {
		$this->fill_content();
	}
	
	return true;
}


//Modification de la qté de l'article à fabriquer
public function maj_qte_fab ($qte_fab = 0) {
	global $bdd;
	
	if (!$qte_fab) {return false;}
	$this->qte_fab = $qte_fab;

	$query = "UPDATE doc_fab
						SET ref_article = '". $this->ref_article."', qte_fab = '".$this->qte_fab."'
						WHERE ref_doc = '".$this->ref_doc."' && id_stock = '".$this->id_stock."'";
	$bdd->exec ($query);

	// on supprime les sn qui existeraient deja pour ce document
	$this->del_all_fab_sn ();
	
	if (isset($GLOBALS['_OPTIONS']['CREATE_DOC']['fill_content']) && $GLOBALS['_OPTIONS']['CREATE_DOC']['fill_content']) {
		$this->fill_content();
	}
	
	return true;
}




// *************************************************************************************************************
// FONCTIONS DE GESTION DU CONTENU
// *************************************************************************************************************
// remplissage du document
protected function fill_content() {
	global $bdd;


	if (!$this->contenu_loaded) { $this->charger_contenu (); }
	foreach ($this->contenu as $doc_line) {
		$this->delete_line ($doc_line->ref_doc_line);
	}
	
	
	$article = new article ($this->ref_article);
	$article_composant = $article->getComposants();
	
	//insertion des articles composants
	foreach ($article_composant as $composant) {
	
			$infos = array();
			$infos['type_of_line']	=	"article";
			//numero de série
			$infos['sn']						= array();
			$infos['ref_article']		=	$composant->ref_article_composant;
			$infos['qte']						=	$this->qte_fab * $composant->qte;
			$this->add_line ($infos);
		
	}
	$this->charger_contenu ();
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
	global $CALCUL_VAS;
	global $bdd;
	
	switch ($this->id_etat_doc) {
		case 47: case 49: case 50: 
			if ($new_etat_doc == 51) {
				
				if (!$this->fab_nl_loaded) {$this->charger_fab_nl();}
				// ajout de l'article dans le stock
				$_SESSION['stocks'][$this->id_stock]->insert_to_stock ($this->ref_doc, $this->ref_article, $this->qte_fab, $this->fab_nl );
				
				if (!$this->contenu_loaded) { $this->charger_contenu(); }
				//mise à jour du prix d'achat de l'article fabriqué
				$article = new article ($this->ref_article);
				$article->maj_prix_achat_actuel_ht ($this->montant_ht/$this->qte_fab);
				
				if (($CALCUL_VAS == "2") && ($this->montant_ht/$this->qte_fab) != 0) {
					$article->maj_prix_achat_ht(($this->montant_ht/$this->qte_fab));
				}
				if (($CALCUL_VAS == "1") && ($this->montant_ht/$this->qte_fab) != 0) {
					$article->maj_prix_achat_ht(($article->getPrix_achat_ht ()+($this->montant_ht/$this->qte_fab))/2);
				}
				// Validation de la fabrication donc suppression du stock
				$this->del_content_from_stock ($this->id_stock);
				
			}
		break;
		case 51: 
			// Livraison du INV donc mise à zéro du stock
			if ($new_etat_doc == 48) {
				$this->add_content_to_stock ($this->id_stock);
				// supression de l'article dans le stock
				if (!$this->fab_sn_loaded) {$this->charger_fab_sn();}
				$_SESSION['stocks'][$this->id_stock]->supprimer_to_stock ($this->ref_doc, $this->ref_article, $this->qte_fab, $this->fab_sn);
			}
		break;
	}
	return true;
}


// Action après de changer l'état du document
protected function action_after_maj_etat ($old_etat_doc) {
	global $bdd;

	if ($this->id_etat_doc == 47) {
		if ($old_etat_doc == 48 && $this->ref_article != "") {
		//	$this->maj_etat_doc (50);
		}
	}

	if ($this->id_etat_doc == 51) {
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
	return $this->check_profil_client ();
}



// *************************************************************************************************************
// FONCTIONS SPECIFIQUES AU TYPE DE DOC 
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
// FONCTIONS LIEES A L'EDITION D'UN DOCUMENT 
// *************************************************************************************************************
protected function check_allow_maj_line_qte () { 
	if ($this->id_etat_doc == 51) { return false; }
	return true; 
}


// *************************************************************************************************************
// FONCTIONS DE LIAISON ENTRE DOCUMENTS 
// *************************************************************************************************************


// *************************************************************************************************************
// FONCTIONS DE GESTION DES NUMÉRO DE SÉRIE DE L'ARTICLE À FABRIQUER
// *************************************************************************************************************
//charger les numéros de série de l'article à fabriquer
public function charger_fab_sn () {
	global $bdd;

	$this->fab_sn = array();
	$query = "SELECT numero_serie 
						FROM doc_fab_sn 
						WHERE ref_doc = '".$this->ref_doc."' ";
	$resultat = $bdd->query ($query);
	while ($tmp = $resultat->fetchObject()) {$this->fab_sn[] = $tmp->numero_serie;}
	$this->fab_sn_loaded = true;
	
	return true;
}

public function charger_fab_nl () {
	global $bdd;

	$this->fab_nl = array();
	$query = "SELECT numero_serie, sn_qte 
						FROM doc_fab_sn 
						WHERE ref_doc = '".$this->ref_doc."' 
						ORDER BY numero_serie ASC";
	$resultat = $bdd->query ($query);
	while ($tmp = $resultat->fetchObject()) {$this->fab_nl[] = $tmp;}
	$this->fab_nl_loaded = true;
	
	return true;
}

// Ajoute un numéro de série à une ligne
public function add_fab_sn ($numero_serie) {
	global $bdd;

	// *************************************************
	// Vérification du numéro de série
	$numero_serie = trim ($numero_serie);
	if (!$numero_serie) { return false; }

	$sn_exist = 0;
	$query = "SELECT numero_serie  
						FROM doc_fab_sn 
						WHERE ref_doc = '".$this->ref_doc."' && numero_serie = '".addslashes($numero_serie)."'";
	$resultat = $bdd->query ($query);
	if ($tmp = $resultat->fetchObject()) {
		$sn_exist = 1;
	}
	$query2 = "SELECT numero_serie  
						FROM stocks_articles_sn  
						WHERE numero_serie = '".addslashes($numero_serie)."'";
	$resultat2 = $bdd->query ($query2);
	if ($tmp2 = $resultat2->fetchObject()) {
		$sn_exist = 1;
	}

	// *************************************************
	// Insertion
	$query = "INSERT INTO doc_fab_sn (ref_doc, numero_serie)
						VALUES ('".$this->ref_doc."', '".addslashes($numero_serie)."') ";
	$bdd->exec ($query);

	$GLOBALS['_INFOS']['fab_sn'] = $numero_serie;
	$GLOBALS['_INFOS']['fab_sn_exist'] = $sn_exist;
	return true;
}


// Supprimer un numéro de série à une ligne
public function del_fab_sn ($numero_serie) {
	global $bdd;

	$numero_serie = trim ($numero_serie);
	if (!$numero_serie) { return false; }

	// *************************************************
	// Suppression
	$query = "DELETE FROM doc_fab_sn 
						WHERE ref_doc = '".$this->ref_doc."' && numero_serie = '".addslashes($numero_serie)."' 
						LIMIT 1";
	$bdd->exec ($query);

	return true;
}


// Mettre à jour un numéro de série d'une article à fabriquer
public function maj_fab_sn ($old_sn, $new_sn) {
	global $bdd;

	$numero_serie = trim ($new_sn);
	if (!$numero_serie) { return false; }

	$sn_exist = 0;
	$query = "SELECT numero_serie  
						FROM doc_fab_sn 
						WHERE ref_doc = '".$this->ref_doc."' && numero_serie = '".addslashes($numero_serie)."'";
	$resultat = $bdd->query ($query);
	if ($tmp = $resultat->fetchObject()) {
		$sn_exist = 1;
	}
	$query2 = "SELECT numero_serie  
						FROM stocks_articles_sn  
						WHERE numero_serie = '".addslashes($numero_serie)."'";
	$resultat2 = $bdd->query ($query2);
	if ($tmp2 = $resultat2->fetchObject()) {
		$sn_exist = 1;
	}

	// *************************************************
	// MAJ
	$query = "UPDATE doc_fab_sn SET numero_serie = '".addslashes($numero_serie)."'
						WHERE ref_doc = '".$this->ref_doc."' && numero_serie = '".addslashes($old_sn)."' 
						LIMIT 1";
	$bdd->exec ($query);

	$GLOBALS['_INFOS']['fab_sn'] = $numero_serie;
	$GLOBALS['_INFOS']['fab_sn_exist'] = $sn_exist;
	return true;
}

// Supprimer les numéros de série de l'article à fabriquer
public function del_all_fab_sn () {
	global $bdd;

	// *************************************************
	// Suppression
	$query = "DELETE FROM doc_fab_sn 
						WHERE ref_doc = '".$this->ref_doc."' ";
	$bdd->exec ($query);

	return true;
}


// Mettre à jour un numéro de lot d'une article à fabriquer
public function maj_fab_nl ($old_nl, $new_nl, $old_qte_nl, $new_qte_nl) {
	global $bdd;
	$numero_serie = trim ($new_nl);
	if (!$numero_serie) { return false; }

	$sn_exist = 0;
	$query = "SELECT numero_serie  
						FROM doc_fab_sn 
						WHERE ref_doc = '".$this->ref_doc."' && numero_serie = '".addslashes($numero_serie)."'";
	$resultat = $bdd->query ($query);
	if ($tmp = $resultat->fetchObject()) {
		$sn_exist = 1;
	}
	$query2 = "SELECT numero_serie  
						FROM stocks_articles_sn  
						WHERE numero_serie = '".addslashes($numero_serie)."'";
	$resultat2 = $bdd->query ($query2);
	if ($tmp2 = $resultat2->fetchObject()) {
		$sn_exist = 1;
	}

	// *************************************************
	// MAJ
	
	if ($old_qte_nl && is_numeric($old_qte_nl)) {  
		$query = "DELETE FROM doc_fab_sn
							WHERE ref_doc = '".$this->ref_doc."' && numero_serie = '".addslashes($old_nl)."' 
							LIMIT ".$old_qte_nl;
		$bdd->exec ($query);
	}
	// *************************************************
	// MAJ
	
	if ($new_qte_nl && is_numeric($new_qte_nl)) {  
		$query = "INSERT INTO doc_fab_sn (ref_doc, numero_serie, sn_qte)
							VALUES ";
//		for ($i=0; $i< $new_qte_nl; $i++) {
//			if ($i) { $query .= " , "; }
			$query .= " ('".$this->ref_doc."', '".addslashes($numero_serie)."', '".$new_qte_nl."' ) ";
//		}
		$bdd->exec ($query);
	}
	$GLOBALS['_INFOS']['fab_sn'] = $numero_serie;
	$GLOBALS['_INFOS']['fab_sn_exist'] = $sn_exist;
	return true;
}



// Supprimer un numéro de lot à une ligne
public function del_fab_nl ($numero_serie, $qte) {
	global $bdd;

	$numero_serie = trim ($numero_serie);
	if (!$numero_serie) { return false; }

	// *************************************************
	// Suppression
	if ($qte && is_numeric($qte)) { 
		$query = "SELECT sn_qte
							FROM doc_fab_sn
							WHERE ref_doc = '".$this->ref_doc."' && numero_serie = '".addslashes($numero_serie)."' ";
		$resultat = $bdd->query($query);
		if($lot = $resultat->fetchObject()){
			if($qte >= $lot->sn_qte){
				$query = "DELETE FROM doc_fab_sn
									WHERE ref_doc = '".$this->ref_doc."' && numero_serie = '".addslashes($numero_serie)."'";
				$bdd->exec ($query);
			}else{
				$query = "UPDATE doc_fab_sn
									SET sn_qte = sn_qte - ".$qte." 
									WHERE ref_doc = '".$this->ref_doc."' && numero_serie = '".addslashes($numero_serie)."'";
				$bdd->exec ($query);
			}
	} else {
		$query = "DELETE FROM doc_fab_sn
							WHERE ref_doc = '".$this->ref_doc."' && numero_serie = '".addslashes($numero_serie)."' 
							";
		$bdd->exec ($query);
		}
	}
	return true;
}


// *************************************************************************************************************
// FONCTIONS DIVERSES
// *************************************************************************************************************


// *************************************************************************************************************
// FONCTIONS DE RESTITUTION DES DONNEES 
// *************************************************************************************************************
 
function getId_Stock () {
	return $this->id_stock;
}
function getRef_article () {
	return $this->ref_article;
}
function getQte_fab() {
	return $this->qte_fab;
}
function getFab_sn() {
	if (!$this->fab_sn_loaded) { $this->charger_fab_sn(); }
	return $this->fab_sn;
}
function getFab_nl() {
	if (!$this->fab_nl_loaded) { $this->charger_fab_nl(); }
	return $this->fab_nl;
}
}

?>