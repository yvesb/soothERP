<?php
// *************************************************************************************************************
// CLASSE REGISSANT LES INFORMATIONS SUR UN DOCUMENT DE TYPE INVENTAIRE
// *************************************************************************************************************


final class doc_inv extends document {

	protected $id_stock;

	protected $ref_adr_stock;
	protected $lib_stock;
	protected $art_categs;		//liste des art_categ de l'inventaire
	protected $art_categs_constructeurs;		//liste des contstructeurs par art_categ de l'inventaire

	protected $ID_TYPE_DOC 					= 11;
	protected $LIB_TYPE_DOC 				= "Inventaire";
	protected $CODE_DOC 						= "INV";
	protected $DOC_ID_REFERENCE_TAG = 27;

	protected $DEFAUT_ID_ETAT 	= 44;
	protected $DEFAUT_LIB_ETAT 	= "En saisie";
	protected $GESTION_SN	 		= 1;
	protected $CONTENT_FROM		= "STOCK";
	protected $PU_FROM				= "PA";
	protected $ACCEPT_REGMT		= 0;
	protected $ID_ETAT_ANNULE	= 45;

	protected $client_facturation;
	protected $client_encours;
	protected $a_facturer = false;



public function open_doc ($select = "", $left_join = "") {
	global $bdd;

	$this->check_profils ();

	$select = ", di.id_stock, s.lib_stock, di.art_categs";
	$left_join = " LEFT JOIN doc_inv di ON di.ref_doc = d.ref_doc 
								 LEFT JOIN stocks s ON di.id_stock = s.id_stock";

	if (!$doc = parent::open_doc($select, $left_join)) { return false; }

	$this->id_stock 				= $doc->id_stock;
	$this->lib_stock 				= $doc->lib_stock;
	$tmp_liste_categ_const 	= explode(";", $doc->art_categs);
	$tmp_art_categ = array();
	$tmp_constructeur = array();
	foreach ($tmp_liste_categ_const as $categ_const) {
		$tmp = explode(":", $categ_const);
		if (isset($tmp[0])) {$tmp_art_categ[] 					= $tmp[0];}
		if (isset($tmp[1])) {$tmp_constructeur[$tmp[0]] = $tmp[1];}
	}
	$this->art_categs 							=	$tmp_art_categ;
	$this->art_categs_constructeurs =	$tmp_constructeur;

	// Blocage des quantités
	if ($this->id_etat_doc == 46) {
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
	
	$this->art_categs = array();

	if (!parent::create_doc()) { return false; }

	$query = "INSERT INTO doc_inv (ref_doc, id_stock, art_categs)
						VALUES ('".$this->ref_doc."', '".$this->id_stock."', '') ";
	$bdd->exec ($query);


	return true;
}

// *************************************************************************************************************
// FONCTIONS LIEES A LA MODIFICATION D'UN DOCUMENT
// *************************************************************************************************************
//definition des art_categ
public function define_art_categ ($art_categs = array()) {
	global $bdd;
	
	
	$tmp_art_categ = array();
	$tmp_constructeur = array();
	foreach ($art_categs as $categ_const) {
		$tmp = explode(":", $categ_const);
		if (isset($tmp[0])) {$tmp_art_categ[] 					= $tmp[0];}
		if (isset($tmp[1])) {$tmp_constructeur[$tmp[0]] = $tmp[1];}
	}
	$this->art_categs 							=	$tmp_art_categ;
	$this->art_categs_constructeurs =	$tmp_constructeur;

	if (count($art_categs)) {
		$query = "UPDATE doc_inv
							SET art_categs = '".implode(";", $art_categs)."'
							WHERE ref_doc = '".$this->ref_doc."' && id_stock = '".$this->id_stock."'";
		$bdd->exec ($query);
	
		if (isset($GLOBALS['_OPTIONS']['CREATE_DOC']['pre_remplir'])) {
		$this->liste_art_categ = get_articles_categories();
			foreach ($this->art_categs as $art_categ) {
				$this->pre_remplir($art_categ);
			}
		}
	}
	return true;
}

//definition des art_categ
public function insert_art_categ ($art_categ = "", $art_categ_constructeur = "") {
	global $bdd;
	
	if (!$art_categ) {return false;}
	$this->art_categs[] = $art_categ;
	if ($art_categ_constructeur != "") {
		$this->art_categs_constructeurs[$art_categ] = $art_categ_constructeur;
	}
	
	$liste_tmp = array();
	foreach ($this->art_categs as $categ) {
		$tmp = $categ;
		if (isset($this->art_categs_constructeurs[$categ])) {$tmp .= ":".$this->art_categs_constructeurs[$categ];}
		$liste_tmp[] = $tmp;
	}

	if (count($liste_tmp)) {
		$query = "UPDATE doc_inv
							SET art_categs = '".implode(";", $liste_tmp)."'
							WHERE ref_doc = '".$this->ref_doc."' && id_stock = '".$this->id_stock."'";
		$bdd->exec ($query);
	
		if (isset($GLOBALS['_OPTIONS']['CREATE_DOC']['pre_remplir'])) {
			$this->liste_art_categ = get_articles_categories();
			$this->pre_remplir($art_categ);
		}
	}
	return true;
}

//supression d'une art_categ (sans supprimer les articles saisis)
public function supprime_art_categ ($art_categ) {
	global $bdd;
	
	if (in_array($art_categ , $this->art_categs)) {
		if (isset($this->art_categs_constructeurs[$art_categ])) {unset($this->art_categs_constructeurs[$art_categ]);}
		unset($this->art_categs[array_search($art_categ , $this->art_categs)]);
	}
	
	$liste_tmp = array();
	foreach ($this->art_categs as $categ) {
		$tmp = $categ;
		if (isset($this->art_categs_constructeurs[$categ])) {$tmp .= ":".$this->art_categs_constructeurs[$categ];}
		$liste_tmp[] = $tmp;
	}

	$query = "UPDATE doc_inv
						SET art_categs = '".implode(";", $liste_tmp)."'
						WHERE ref_doc = '".$this->ref_doc."' && id_stock = '".$this->id_stock."'";
	$bdd->exec ($query);

	return true;

}


// *************************************************************************************************************
// FONCTIONS DE GESTION DU CONTENU
// *************************************************************************************************************

//inderdit les quantités négatives
public function maj_line_qte ($ref_doc_line, $new_qte) {
	global $bdd;

	if (!$this->quantite_locked) {
		if (!is_numeric($new_qte) || $new_qte < 0) { 
			$GLOBALS['_ALERTES']['bad_qte'] = 1;
			$query = "SELECT dl.qte
								FROM docs_lines dl
								WHERE ref_doc_line = '".$ref_doc_line."' ";
			$resultat = $bdd->query ($query);
			if ($doc_line = $resultat->fetchObject()) {
				$GLOBALS['_ALERTES']['bad_qte'] = $doc_line->qte;	
			}
			return false; 
		}
		parent::maj_line_qte($ref_doc_line, $new_qte);
	}
}


// pre_remplissage du document
protected function pre_remplir($art_categ) {
	global $bdd;
	
	$where = "";
	//insertion des lignes infos pour les différentes catégories
	$infos = array();
	$infos['type_of_line']	=	"information";
	$infos['titre']	=	$this->liste_art_categ[$art_categ]->lib_art_categ;
	if (isset($this->art_categs_constructeurs[$art_categ]) ) {
		$tmp_contact = new contact ($this->art_categs_constructeurs[$art_categ]);
		if ($tmp_contact->getRef_contact()) {	
			$infos['titre']	.= "\nConstructeur: ".$tmp_contact->getNom(); 
			$where = " && a.ref_constructeur = '".$tmp_contact->getRef_contact()."' ";
		} else {
			$infos['titre']	.= "\nSans constructeur";
			$where = " && ISNULL(a.ref_constructeur) ";
		}
	}
	$infos['texte']	=	"";
	$this->add_line ($infos);
	
	//on charge le contenu actuel du doc pour comparer et n'enregistrer que les articles non encore insérés 
	$exist_articles = array();
	if (!$this->contenu_materiel_loaded) { $this->charger_contenu_materiel (); }
	foreach ($this->contenu_materiel as $doc_line) {
		$exist_articles[$doc_line->ref_article] = $doc_line->ref_article;
	}
	//insertion des articles correspondant à la catégorie
	/*
	$query = "SELECT sa.ref_stock_article, a.ref_article, SUM(sa.qte) qte
					FROM articles a
						LEFT JOIN art_categs ac ON a.ref_art_categ = ac.ref_art_categ 
						LEFT JOIN stocks_articles sa ON a.ref_article = sa.ref_article && sa.id_stock = '".$this->id_stock."'
					WHERE dispo=1  && a.ref_art_categ = '".$art_categ."' && sa.id_stock = '".$this->id_stock."' ".$where."
					GROUP BY a.ref_article, sa.ref_article ";
	*/
	$query = "SELECT sa.ref_stock_article, a.ref_article, SUM(sa.qte) qte
					FROM articles a
						LEFT JOIN art_categs ac ON a.ref_art_categ = ac.ref_art_categ 
						LEFT JOIN stocks_articles sa ON a.ref_article = sa.ref_article && sa.id_stock = '".$this->id_stock."'
					WHERE dispo=1  && a.ref_art_categ = '".$art_categ."' ".$where."
					GROUP BY a.ref_article, sa.ref_article ";
	$resultat = $bdd->query($query);
	while ($article = $resultat->fetchObject()) {
		if (!in_array($article->ref_article, $exist_articles)) {
			$infos = array();
			$infos['type_of_line']	=	"article";
			//numero de série
			$infos['sn']						= array();
			$limit= "";
			if ($article->qte > 0) {$limit= "LIMIT 0, ".$article->qte;}
			$query = "SELECT numero_serie,sn_qte
								FROM stocks_articles_sn 
								WHERE ref_stock_article = '".$article->ref_stock_article."' 
								".$limit."
								";
								//echo $query;
			$resultat2 = $bdd->query ($query);
			while ($var = $resultat2->fetchObject()) { $infos['sn'][] =	 $var->numero_serie; }
			
			$infos['ref_article']		=	$article->ref_article;
			$infos['qte']						=	$article->qte;
			$this->add_line ($infos);
		}
	}
}

// Chargement des informations supplémentaires concernant les numéros de série 
protected function doc_line_sn_infos_supp () {
	$query['select']		= ", IF (ISNULL(sas.numero_serie), 0, 1) as sn_exist";
	$query['left_join'] = " LEFT JOIN stocks_articles_sn sas ON sas.numero_serie = dls.numero_serie";
	return $query;
}

// Chargement des informations supplémentaires concernant les lignes
protected function doc_line_infos_supp () {
	$query['select']		= ", sa.ref_stock_article, sa.qte as qte_en_stock";
	$query['left_join'] = " LEFT JOIN stocks_articles sa ON a.ref_article = sa.ref_article && sa.id_stock = '".$this->id_stock."'";
	return $query;
}
// *************************************************************************************************************
// FONCTIONS LIEES A LA MODIFICATION DE L'ETAT D'UN DOCUMENT
// *************************************************************************************************************

// Action avant de changer l'état du document
protected function action_before_maj_etat ($new_etat_doc) {
	global $bdd;
	
	switch ($this->id_etat_doc) {
		case 44: case 45: 
			// Livraison du INV donc mise à zéro du stock
			if ($new_etat_doc == 46) {
				//supression des articles non liés à une catégorie
				if (!$this->contenu_materiel_loaded) { $this->charger_contenu_materiel (); }
			
				foreach ($this->contenu_materiel as $doc_line) {
						//supression des articles dans le stock
						$query = "DELETE FROM stocks_articles 
											WHERE ref_stock_article = '".$doc_line->ref_stock_article."' ";
						$bdd->exec ($query);
						$query = "DELETE FROM stocks_articles_sn 
											WHERE ref_stock_article = '".$doc_line->ref_stock_article."' ";
						$bdd->exec ($query);
						// Inscription dans le mouvement de stock
						if ($doc_line->qte_en_stock) {
							$_SESSION['stocks'][$this->id_stock]->genere_move_stock ($this->ref_doc, $doc_line->ref_article, -$doc_line->qte_en_stock );
						} else {
								$_SESSION['stocks'][$this->id_stock]->genere_move_stock ($this->ref_doc, $doc_line->ref_article, 0 );
								
						
						}
				}
				
				//	suppression du stock des articles des categories
				foreach ($this->art_categs as $art_categ) {
				
					$where = "";
					if (isset($this->art_categs_constructeurs[$art_categ])) {
						$tmp_contact = new contact ($this->art_categs_constructeurs[$art_categ]);
						if ($tmp_contact->getRef_contact()) {	
							$where = " && a.ref_constructeur = '".$tmp_contact->getRef_contact()."' ";
						} else {
							$where = " && ISNULL(a.ref_constructeur) ";
						}
					}
					$query = "SELECT sa.ref_stock_article, a.ref_article, sa.qte
		
										FROM articles a
											LEFT JOIN art_categs ac ON a.ref_art_categ = ac.ref_art_categ 
											LEFT JOIN stocks_articles sa ON a.ref_article = sa.ref_article && sa.id_stock = '".$this->id_stock."'
											
										WHERE dispo=1  && a.ref_art_categ = '".$art_categ."' && sa.id_stock = '".$this->id_stock."' ".$where."
										GROUP BY sa.ref_stock_article ";
					$resultat = $bdd->query($query);
					while ($article = $resultat->fetchObject()) {
						//supression des articles dans le stock
						$query = "DELETE FROM stocks_articles 
											WHERE ref_stock_article = '".$article->ref_stock_article."' ";
						$bdd->exec ($query);
						$query = "DELETE FROM stocks_articles_sn 
											WHERE ref_stock_article = '".$article->ref_stock_article."' ";
						$bdd->exec ($query);
						// Inscription dans le mouvement de stock pour remise à zéro du stock
						$_SESSION['stocks'][$this->id_stock]->genere_move_stock ($this->ref_doc, $article->ref_article, -$article->qte );
						
						//pour tout les articles ne fesant pas partie de l'inventaire on vas créer un mouvement de stock vers zéro pour indiquer son traitement dans l'inventaire	
						$set_article_to_zero = true;
						foreach ($this->contenu_materiel as $doc_line) {
							if ($article->ref_article == $doc_line->ref_article) { $set_article_to_zero = false; break;}
						}
						if ($set_article_to_zero) {
						$_SESSION['stocks'][$this->id_stock]->genere_move_stock ($this->ref_doc, $article->ref_article, 0 );
						}
					}
				}
				
				
				//ajout du contenu de l'inventaire dans le stock
				$this->add_content_to_stock();
			}
		break;
	}
	return true;
}


// Action après de changer l'état du document
protected function action_after_maj_etat ($old_etat_doc) {
	global $bdd;


	if ($this->id_etat_doc == 46 && $old_etat_doc !=45) { 
		
	}

	if ($this->id_etat_doc == 46) {
		if (!$this->contenu_materiel_loaded) { $this->charger_contenu_materiel (); }
		foreach ($this->contenu_materiel as $doc_line) {
			edi_event(116,$doc_line->ref_article); 
		}
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
	if ($this->id_etat_doc == 46) { return false; }
	return true; 
}


// *************************************************************************************************************
// FONCTIONS DE LIAISON ENTRE DOCUMENTS 
// *************************************************************************************************************


// *************************************************************************************************************
// FONCTIONS DE GESTION DES REGLEMENTS
// *************************************************************************************************************




// *************************************************************************************************************
// FONCTIONS DIVERSES
// *************************************************************************************************************


// *************************************************************************************************************
// FONCTIONS DE RESTITUTION DES DONNEES 
// *************************************************************************************************************
 
function getId_Stock () {
	return $this->id_stock;
}
function getLib_stock() {
        return $this->lib_stock;
}
function getArt_categs () {
	return $this->art_categs;
}


}

?>
