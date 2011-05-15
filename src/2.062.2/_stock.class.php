<?php
// *************************************************************************************************************
// CLASSE REGISSANT LES INFORMATIONS SUR UN STOCK DE LA SOCIETE
// *************************************************************************************************************


final class stock {
	private $id_stock;

	private $lib_stock;			// Nom du lieu de stockage
	private $abrev_stock;			// Abréviation du Nom du lieu de stockage
	private $ref_adr_stock;	// Ref_adresse du lieu de stockage
	private $actif;					// 1 si le stock est actif (sinon aucnu mouvmeent possible)

	private $adresse;				// Objet adresse complet

	private $STOCK_ARTICLE_ID_REFERENCE_TAG = 16;
	private $STOCK_MOVE_ID_REFERENCE_TAG 		= 17;
	
	private static $code_pdf_modele = "stock_etat"; // code pour la class d'impression de l'etat du stock


function __construct ($id_stock = 0, $infos_stock = NULL) {
	global $bdd;

	// Controle si objet créé depuis une requete
	if (isset($infos_stock)) {
		$this->charger_from_object($infos_stock);
		return true;
	}
	
	// Controle si le id_stock est précisé
	if (!$id_stock) { return false; }

	// Sélection des informations générales
	$query = "SELECT lib_stock, abrev_stock, ref_adr_stock, actif
						FROM stocks s
						WHERE id_stock = '".$id_stock."' ";
	$resultat = $bdd->query ($query);

	// Controle si le id_stock est trouvé
	if (!$stock = $resultat->fetchObject()) { return false; }

	// Attribution des informations à l'objet
	$this->id_stock 			= $id_stock;
	$this->lib_stock			= $stock->lib_stock;
	$this->abrev_stock		= $stock->abrev_stock;
	$this->ref_adr_stock	= $stock->ref_adr_stock;
	$this->actif					= $stock->actif;

	stock::charge_defaut_modele_pdf();
	return true;
}


function charger_from_object($stock) {	
	// Attribution des informations 
	$this->id_stock				= $stock->id_stock;
	$this->lib_stock			= $stock->lib_stock;
	$this->abrev_stock		= $stock->abrev_stock;
	$this->ref_adr_stock	= $stock->ref_adr_stock;
	$this->actif					= $stock->actif;

	return true;
}

// Charge l'adresse complete
function charger_adresse() {
	$this->adresse = new adresse($this->ref_adr_stock);
}


// *************************************************************************************************************
// FONCTIONS LIEES A LA CREATION D'UN STOCK 
// *************************************************************************************************************

final public function create ($lib_stock, $abrev_stock, $ref_adr_stock, $actif) {
	global $bdd;

	// *************************************************
	// Controle des données transmises
	$this->lib_stock 	= $lib_stock;
	if (!$this->lib_stock) { 
		$GLOBALS['_ALERTES']['lib_stock_vide'] = 1; 
	}
	$this->ref_adr_stock = $ref_adr_stock;
	$this->actif 			= $actif;
	
	$this->abrev_stock= $abrev_stock;
	if (!$this->abrev_stock) { 
		$this->abrev_stock = substr($this->lib_stock , 0, 3);
	}
	// *************************************************
	// Si les valeurs reçues sont incorrectes
	if (count($GLOBALS['_ALERTES'])) {
		return false;
	}

	// *************************************************
	// Insertion dans la base
	$query = "INSERT INTO stocks (lib_stock, abrev_stock, ref_adr_stock, actif)
						VALUES ('".addslashes($this->lib_stock)."', '".addslashes($this->abrev_stock)."', 
										".ref_or_null($this->ref_adr_stock).",  '".$actif."')";
	$bdd->exec($query);
	$this->id_stock = $bdd->lastInsertId();
	
	//on demande à ce que la session soit mise à jour lors de l'ouverture des prochaines pages
	serveur_maj_file();
	
	// *************************************************
	// Résultat positif de la création
	$GLOBALS['_INFOS']['Création_stock'] = $this->id_stock;

	return true;
}



// *************************************************************************************************************
// FONCTIONS LIEES A LA MODIFICATION D'UN STOCK
// *************************************************************************************************************

final public function modification ($lib_stock, $abrev_stock, $ref_adr_stock, $actif) {
	global $bdd;
	
	// *************************************************
	// Controle des données transmises
	$this->lib_stock 	= $lib_stock;
	if (!$this->lib_stock) { 
		$GLOBALS['_ALERTES']['lib_stock_vide'] = 1; 
	}
	$this->ref_adr_stock = $ref_adr_stock;
	
	$this->abrev_stock= $abrev_stock;
	if (!$this->abrev_stock) { 
		$this->abrev_stock = substr($this->lib_stock , 0, 3);
	}
	// Controle si inactivation du stock
	if ($this->actif && !$actif) {
		// Qu'il n'est pas utilisé par un document en cours
		$query = "SELECT d.ref_doc FROM documents d
							LEFT JOIN doc_blc dblc ON d.ref_doc = dblc.ref_doc 
							LEFT JOIN doc_cdc dcdc ON d.ref_doc = dcdc.ref_doc 
							LEFT JOIN doc_def ddef ON d.ref_doc = ddef.ref_doc 
							LEFT JOIN doc_blf dblf ON d.ref_doc = dblf.ref_doc 
							LEFT JOIN doc_cdf dcdf ON d.ref_doc = dcdf.ref_doc 
							LEFT JOIN doc_trm dtrm ON d.ref_doc = dtrm.ref_doc 
							LEFT JOIN doc_inv dinv ON d.ref_doc = dinv.ref_doc 
							LEFT JOIN doc_des ddes ON d.ref_doc = ddes.ref_doc 
							LEFT JOIN doc_fab dfab ON d.ref_doc = dfab.ref_doc 
		
							WHERE  (d.id_etat_doc IN (6,9) && dblc.id_stock = '".$this->id_stock."') 
									|| (d.id_etat_doc IN (11,13,14) && dcdc.id_stock = '".$this->id_stock."') 
									|| (d.id_etat_doc IN (20,22) && ddef.id_stock = '".$this->id_stock."') 
									|| (d.id_etat_doc IN (25,27) && dblf.id_stock = '".$this->id_stock."') 
									|| (d.id_etat_doc IN (29) && dcdf.id_stock = '".$this->id_stock."') 
									|| (d.id_etat_doc IN (36,38,39) && dtrm.id_stock_source = '".$this->id_stock."' && dtrm.id_stock_cible = '".$this->id_stock."') 
									|| (d.id_etat_doc IN (44) && dinv.id_stock = '".$this->id_stock."') 
									|| (d.id_etat_doc IN (47,49,50) && dfab.id_stock = '".$this->id_stock."') 
									|| (d.id_etat_doc IN (52,54,55) && ddes.id_stock = '".$this->id_stock."') 
									";
		$resultat = $bdd->query ($query);
		while ($document = $resultat->fetchObject()) {$GLOBALS['_ALERTES']['documents_using_stock'][] = $document->ref_doc;}
		if (isset($GLOBALS['_ALERTES']['documents_using_stock'])) { 
			return false;
		}
		// Qu'il n'est pas utilisé par un magasin actif
		$query = "SELECT id_magasin FROM magasins WHERE actif = 1 && id_stock = '".$this->id_stock."' ";
		$resultat = $bdd->query ($query);
		if ($magasin = $resultat->fetchObject()) { 
			$GLOBALS['_ALERTES']['magasin_using_stock'] = 1;
			return false;
		}
		// Que ce ne soit pas le seul actif
		$query = "SELECT COUNT(id_stock) nb_stocks FROM stocks WHERE actif = 1 ";
		$resultat = $bdd->query ($query);
		$stock = $resultat->fetchObject();
		if ($stock->nb_stocks <= 1) {
			$GLOBALS['_ALERTES']['last_active_stock'] = 1;
			return false;
		}
	}
	$this->actif = $actif;

	// *************************************************
	// Si les valeurs reçues sont incorrectes
	if (count($GLOBALS['_ALERTES'])) {
		return false;
	}

	// *************************************************
	// Mise a jour de la base
	$query = "UPDATE stocks 
						SET lib_stock = '".addslashes($this->lib_stock)."', abrev_stock = '".addslashes($this->abrev_stock)."', ref_adr_stock = ".ref_or_null($this->ref_adr_stock).",
								actif = '".$actif."'
						WHERE id_stock = '".$this->id_stock."' ";
	$bdd->exec ($query);

	//on demande à ce que la session soit mise à jour lors de l'ouverture des prochaines pages
	serveur_maj_file();
	// *************************************************
	// Résultat positif de la modification
	return true;
}

// *************************************************************************************************************
// FONCTIONS LIEES A LA SUPPRESSION DU STOCK 
// *************************************************************************************************************
//verification de l'utilisation du stock par un magasin
public function check_used_stock () {
	global $bdd;
		
	// Qu'il n'est pas utilisé par un document en cours
	$query = "SELECT d.ref_doc FROM documents d
						LEFT JOIN doc_blc dblc ON d.ref_doc = dblc.ref_doc 
						LEFT JOIN doc_cdc dcdc ON d.ref_doc = dcdc.ref_doc 
						LEFT JOIN doc_def ddef ON d.ref_doc = ddef.ref_doc 
						LEFT JOIN doc_blf dblf ON d.ref_doc = dblf.ref_doc 
						LEFT JOIN doc_cdf dcdf ON d.ref_doc = dcdf.ref_doc 
						LEFT JOIN doc_trm dtrm ON d.ref_doc = dtrm.ref_doc 
						LEFT JOIN doc_inv dinv ON d.ref_doc = dinv.ref_doc 
						LEFT JOIN doc_des ddes ON d.ref_doc = ddes.ref_doc 
						LEFT JOIN doc_fab dfab ON d.ref_doc = dfab.ref_doc 
	
						WHERE  (d.id_etat_doc IN (6,9) && dblc.id_stock = '".$this->id_stock."') 
								|| (d.id_etat_doc IN (11,13,14) && dcdc.id_stock = '".$this->id_stock."') 
								|| (d.id_etat_doc IN (20,22) && ddef.id_stock = '".$this->id_stock."') 
								|| (d.id_etat_doc IN (25,27) && dblf.id_stock = '".$this->id_stock."') 
								|| (d.id_etat_doc IN (29) && dcdf.id_stock = '".$this->id_stock."') 
								|| (d.id_etat_doc IN (36,38,39) && dtrm.id_stock_source = '".$this->id_stock."' && dtrm.id_stock_cible = '".$this->id_stock."') 
								|| (d.id_etat_doc IN (44) && dinv.id_stock = '".$this->id_stock."') 
								|| (d.id_etat_doc IN (47,49,50) && dfab.id_stock = '".$this->id_stock."') 
								|| (d.id_etat_doc IN (52,54,55) && ddes.id_stock = '".$this->id_stock."') 
								";
	$resultat = $bdd->query ($query);
	while ($document = $resultat->fetchObject()) {$GLOBALS['_ALERTES']['documents_using_stock'][] = $document->ref_doc;}
	if (isset($GLOBALS['_ALERTES']['documents_using_stock'])) { 
		return false;
	}
	// Qu'il n'est pas utilisé par un magasin actif
	$query = "SELECT id_magasin FROM magasins WHERE actif = 1 && id_stock = '".$this->id_stock."' ";
	$resultat = $bdd->query ($query);
	if ($magasin = $resultat->fetchObject()) { 
		$GLOBALS['_ALERTES']['magasin_using_stock'] = 1;
		return false;
	}
	// Que ce ne soit pas le seul actif
	$query = "SELECT COUNT(id_stock) nb_stocks FROM stocks WHERE actif = 1 ";
	$resultat = $bdd->query ($query);
	$stock = $resultat->fetchObject();
	if ($stock->nb_stocks <= 1) {
		$GLOBALS['_ALERTES']['last_active_stock'] = 1;
		return false;
	}
	return true;
}

//supression du stock avec transfere des articles en stock vers un lieu de stockage différent
public function supprime_stock_transferer ($new_id_stock) {
	global $bdd;
	global $TRANSFERT_ID_TYPE_DOC;
	global $DOCUMENTS_ARTICLES_LINES_GENERER;
	
	$new_stock = new stock ($new_id_stock);
	$GLOBALS['_OPTIONS']['CREATE_DOC']['id_stock_source'] = $this->id_stock;
	$GLOBALS['_OPTIONS']['CREATE_DOC']['id_stock_cible'] = $new_id_stock;
	
	$count_nbs_article = 0;
	//on selectionne l'ensemble des articles du stock pour générer des TRM vers le nouveau stock
	$query = "SELECT ref_stock_article, ref_article, qte FROM stocks_articles  WHERE id_stock = '".$this->id_stock."' && qte > 0 ";
	$resultat = $bdd->query ($query);
	while ($articles = $resultat->fetchObject()) {
		if ($count_nbs_article == 0) {
			$document = create_doc ($TRANSFERT_ID_TYPE_DOC);
			$infos = array();
			$infos['type_of_line']	=	"information";
			$infos['titre']	=	"Transfert du stock ".$this->lib_stock." vers le stock ".$new_stock->getLib_stock()."";
			$infos['texte']	=	"Liquidation du stock  ".$this->lib_stock;
			$document->add_line ($infos);
		}
		
		$infos = array();
		$infos['type_of_line']	=	"article";
		$infos['sn']						= array();
		$query_sn = "SELECT numero_serie FROM stocks_articles_sn  WHERE ref_stock_article = '".$articles->ref_stock_article."' ";
		$resultat_sn = $bdd->query ($query_sn);
		while ($articles_sn = $resultat_sn->fetchObject()) {
			$infos['sn'][]				=	$articles_sn->numero_serie;
		}
		$infos['ref_article']		=	$articles->ref_article;
		$infos['qte']						=	$articles->qte;
		$document->add_line ($infos);
		
		
		$count_nbs_article++;
		if ($count_nbs_article == $DOCUMENTS_ARTICLES_LINES_GENERER) {
			$document->maj_etat_doc(40);
			$count_nbs_article = 0;
		}
	}
	if (isset($document) && $document->getRef_doc ()) {$document->maj_etat_doc(40);}
	
	//on change l'id_stock des magasins qui utilisent ce stock
	$id_stock_remplacement = 0;
	$query = "SELECT id_stock
						FROM stocks
						WHERE actif >= 1 && id_stock != ".$this->id_stock;
	$resultat = $bdd->query ($query);
	if ($stocks_liste = $resultat->fetchObject()) {
		foreach ($stocks_liste as $lstock) {
			if ($lstock == $this->id_stock) {continue;}
			$id_stock_remplacement = $lstock;
		}
	}
	
	$query = "UPDATE magasins
						SET id_stock = ".$id_stock_remplacement."
						WHERE id_stock = '".$this->id_stock."' ";
	$resultat = $bdd->query($query);
	
	//on supprime les articles restant en stocks (articles en stock négatifs) du stock en cours
	$query = "DELETE FROM stocks_articles  
						WHERE id_stock = '".$this->id_stock."' ";
	$bdd->exec($query);
	
	//on rend innactif le stock en cours
	$query = "UPDATE stocks 
						SET actif = '0'
						WHERE id_stock = '".$this->id_stock."' ";
	//a revoir car soucis avec les stocks inactifs
	$bdd->exec($query);
	unset ($_SESSION['stocks'][$this->id_stock], $this);
	
	//on demande à ce que la session soit mise à jour lors de l'ouverture des prochaines pages
	serveur_maj_file();
	
	return true;
}

//suppression du stock avec livraison des articles en stock à un contact
public function supprime_stock_livrer ($ref_contact) {
	global $bdd;
	global $LIVRAISON_CLIENT_ID_TYPE_DOC;
	global $DOCUMENTS_ARTICLES_LINES_GENERER;
	
	$GLOBALS['_OPTIONS']['CREATE_DOC']['id_stock'] = $this->id_stock;
	$GLOBALS['_OPTIONS']['CREATE_DOC']['ref_contact'] = $ref_contact;
	$GLOBALS['_OPTIONS']['CREATE_DOC']['not_generer_facture'] = 1;
	
	$count_nbs_article = 0;
	//on selectionne l'ensemble des articles du stock pour générer des BLC vers le nouveau stock
	$query = "SELECT ref_stock_article, ref_article, qte FROM stocks_articles  WHERE id_stock = '".$this->id_stock."' && qte > 0 ";
	$resultat = $bdd->query ($query);
	while ($articles = $resultat->fetchObject()) {
		if ($count_nbs_article == 0) {
			$document = create_doc ($LIVRAISON_CLIENT_ID_TYPE_DOC);
			$infos = array();
			$infos['type_of_line']	=	"information";
			$infos['titre']	=	"Liquidation du stock  ".$this->lib_stock;
			$infos['texte']	=	"";
			$document->add_line ($infos);
		}
		
		$infos = array();
		$infos['type_of_line']	=	"article";
		$infos['sn']						= array();
		$query_sn = "SELECT numero_serie FROM stocks_articles_sn  WHERE ref_stock_article = '".$articles->ref_stock_article."' ";
		$resultat_sn = $bdd->query ($query_sn);
		while ($articles_sn = $resultat_sn->fetchObject()) {
			$infos['sn'][]				=	$articles_sn->numero_serie;
		}
		$infos['ref_article']		=	$articles->ref_article;
		$infos['qte']						=	$articles->qte;
		$document->add_line ($infos);
		
		
		$count_nbs_article++;
		if ($count_nbs_article == $DOCUMENTS_ARTICLES_LINES_GENERER) {
			$document->maj_etat_doc(15);
			$count_nbs_article = 0;
		}
	}
	if (isset($document) && $document->getRef_doc ()) {$document->maj_etat_doc(15);}
	
	//on change l'id_stock des magasins qui utilisent ce stock
	$id_stock_remplacement = 0;
	$query = "SELECT id_stock
						FROM stocks
						WHERE actif >= 1 && id_stock != ".$this->id_stock;
	$resultat = $bdd->query ($query);
	if ($stocks_liste = $resultat->fetchObject()) {
		foreach ($stocks_liste as $lstock) {
			if ($lstock == $this->id_stock) {continue;}
			$id_stock_remplacement = $lstock;
		}
	}
	
	$query = "UPDATE magasins
						SET id_stock = ".$id_stock_remplacement."
						WHERE id_stock = '".$this->id_stock."' ";
	$resultat = $bdd->query($query);
	
	//on supprime les articles restant en stocks (articles en stock négatifs) du stock en cours
	$query = "DELETE FROM stocks_articles  
						WHERE id_stock = '".$this->id_stock."' ";
	$bdd->exec($query);
	
	//on rend innactif le stock en cours
	$query = "UPDATE stocks 
						SET actif = '0'
						WHERE id_stock = '".$this->id_stock."' ";
	//a revoir car soucis avec les stocks inactifs
	$bdd->exec($query);
	unset ($_SESSION['stocks'][$this->id_stock], $this);
	
	//on demande à ce que la session soit mise à jour lors de l'ouverture des prochaines pages
	serveur_maj_file();
	
	return true;
}
// *************************************************************************************************************
// FONCTIONS DE GESTION DU STOCK 
// *************************************************************************************************************
// Ajoute une ligne de document au stock
public function add_to_stock ($doc_line, $ref_doc) {
	global $bdd;

	$ref_article = $doc_line->ref_article;
	$qte 	= $doc_line->qte;
	$sn 	= array();
	if (isset($doc_line->sn)) { $sn = $doc_line->sn; }

	if (!$qte) 		{ return false; }
	if ($qte < 0) { 
		$doc_line->qte = - $doc_line->qte;
		$this->del_from_stock ($doc_line, $ref_doc); 
	return true;
	}


	$ref_stock_article = "";

	// *************************************************
	// MAJ du stock
	$query = "UPDATE stocks_articles
						SET qte = qte + ".$qte."
						WHERE ref_article = '".$ref_article."' && id_stock = '".$this->id_stock."' ";
	$resultat = $bdd->query($query);
	if (!$resultat->rowCount()) {
		// La ligne n'existe pas dans le stock, il faut la créer
		$reference = new reference ($this->STOCK_ARTICLE_ID_REFERENCE_TAG);
		$ref_stock_article = $reference->generer_ref();
		$query = "INSERT INTO stocks_articles (ref_stock_article, id_stock, ref_article, qte)
							VALUES ('".$ref_stock_article."', '".$this->id_stock."', '".$ref_article."', '".$qte."') ";
		$bdd->exec ($query);
		unset ($reference, $resultat);
	}


	// *************************************************
	// Enregistrement du mouvement
	$reference = new reference ($this->STOCK_MOVE_ID_REFERENCE_TAG);
	$ref_stock_move = $reference->generer_ref();
	$query = "INSERT INTO stocks_moves (ref_stock_move, id_stock, ref_article, qte, ref_doc, date)
						VALUES ('".$ref_stock_move."', '".$this->id_stock."', '".$ref_article."', '".$qte."', '".$ref_doc."', NOW()) ";
	$bdd->exec ($query);

	
	// *************************************************
	// Numéros de série
	if (!count($sn)) { return true; }

	// Ligne du stock
	if (!$ref_stock_article) {
		$query = "SELECT ref_stock_article FROM stocks_articles 
							WHERE ref_article = '".$ref_article."' && id_stock = '".$this->id_stock."' ";
		$resultat = $bdd->query($query);
		$stock_article = $resultat->fetchObject();
		$ref_stock_article = $stock_article->ref_stock_article;
		unset ($stock_article, $resultat);
	}
	
	if ($doc_line->gestion_sn == 1) {
		// Préparation de la requete
		$query_sn = "";
		foreach ($sn as $numero) {
			if ($query_sn) { $query_sn .= ","; }
			$query_sn .= "('".$ref_stock_article."','".$numero->numero_serie."','$numero->sn_qte')";
		}
	
		// Insertion des numéros de série dans le stock
		$query = "INSERT INTO stocks_articles_sn (ref_stock_article, numero_serie, sn_qte)
							VALUES ".$query_sn;
		$bdd->exec($query);
	}
	if ($doc_line->gestion_sn == 2) {
		// Préparation de la requete
		$query_sn = "";
		foreach ($sn as $numero) {
			$query = "SELECT sn_qte from stocks_articles_sn
								WHERE ref_stock_article = '".$ref_stock_article."' && numero_serie IN ('".$numero->numero_serie."') LIMIT 1";
			$resultat = $bdd->query($query);
			if($stock_article = $resultat->fetchObject()){
					$query = "UPDATE stocks_articles_sn set sn_qte = sn_qte + ".$numero->sn_qte." 
										WHERE ref_stock_article = '".$ref_stock_article."' && numero_serie IN ('".$numero->numero_serie."') LIMIT 1";
					$bdd->exec($query);
			}else{
					$query = "INSERT INTO stocks_articles_sn (ref_stock_article, numero_serie, sn_qte)
										VALUES ('".$ref_stock_article."','".$numero->numero_serie."','".$numero->sn_qte."');";
					$bdd->exec($query);
			}
		}
	}
	return true;
}


// Supprime une ligne de document du stock
public function del_from_stock ($doc_line, $ref_doc) {
	global $bdd;

	$ref_article = $doc_line->ref_article;
	$qte 	= $doc_line->qte;
	$sn 	= array();
	if (isset($doc_line->sn)) { $sn = $doc_line->sn; }


	if (!$qte) 		{ return false; }
	if ($qte < 0) { 
		$doc_line->qte = - $doc_line->qte;
		$this->add_to_stock ($doc_line, $ref_doc); 
	return true;
	}


	// *************************************************
	// MAJ du stock
	$ref_stock_article = "";
	$query = "UPDATE stocks_articles
						SET qte = qte - ".$qte."
						WHERE ref_article = '".$ref_article."' && id_stock = '".$this->id_stock."' ";
	$resultat = $bdd->query($query);
	if (!$resultat->rowCount()) {
		// La ligne n'existe pas dans le stock, il faut la créer
		$reference = new reference ($this->STOCK_ARTICLE_ID_REFERENCE_TAG);
		$ref_stock_article = $reference->generer_ref();
		$query = "INSERT INTO stocks_articles (ref_stock_article, id_stock, ref_article, qte)
							VALUES ('".$ref_stock_article."', '".$this->id_stock."', '".$ref_article."', '-".$qte."') ";
		$bdd->exec ($query);
		unset ($reference, $resultat);
	}


	// *************************************************
	// Enregistrement du mouvement
	$reference = new reference ($this->STOCK_MOVE_ID_REFERENCE_TAG);
	$ref_stock_move = $reference->generer_ref();
	$query = "INSERT INTO stocks_moves (ref_stock_move, id_stock, ref_article, qte, ref_doc, date)
						VALUES ('".$ref_stock_move."', '".$this->id_stock."', '".$ref_article."', '-".$qte."', '".$ref_doc."', NOW()) ";
	$bdd->exec ($query);

	// *************************************************
	// Numéros de série
	if (!count($sn)) { return true; }

	// Ligne du stock
	if (!$ref_stock_article) {
		$query = "SELECT ref_stock_article FROM stocks_articles 
							WHERE ref_article = '".$ref_article."' && id_stock = '".$this->id_stock."' ";
		$resultat = $bdd->query($query);
		$stock_article = $resultat->fetchObject();
		$ref_stock_article = $stock_article->ref_stock_article;
		unset ($stock_article, $resultat);
	}
	//supression de SN
	if ($doc_line->gestion_sn == 1) {
		// Préparation de la requete
		$query_sn = "";
		foreach ($sn as $numero) {
			if ($query_sn) { $query_sn .= ","; }
			$query_sn .= "'".$numero->numero_serie."'";
		}
	
		// Suppression des numéros de série dans le stock
		$query = "DELETE FROM stocks_articles_sn 
							WHERE ref_stock_article = '".$ref_stock_article."' && numero_serie IN (".$query_sn.")";
		$bdd->exec($query);
	}
	
	//supression des lots
	if ($doc_line->gestion_sn == 2) {
		// Préparation de la requete
		$query_sn = "";
		foreach ($sn as $numero) {
			$query = "SELECT sn_qte from stocks_articles_sn
								WHERE ref_stock_article = '".$ref_stock_article."' && numero_serie IN ('".$numero->numero_serie."') LIMIT 1";
			$resultat = $bdd->query($query);
			if($stock_article = $resultat->fetchObject()){
				if($numero->sn_qte >= $stock_article->sn_qte){
					$query = "DELETE FROM stocks_articles_sn 
										WHERE ref_stock_article = '".$ref_stock_article."' && numero_serie IN ('".$numero->numero_serie."') LIMIT 1";
					$bdd->exec($query);
				}else{
					$query = "UPDATE stocks_articles_sn set sn_qte = sn_qte - ".$numero->sn_qte." 
										WHERE ref_stock_article = '".$ref_stock_article."' && numero_serie IN ('".$numero->numero_serie."') LIMIT 1";
					$bdd->exec($query);
				}
			}
		}
	}
	return true;
}

// Ajoute un article au stock
public function insert_to_stock ($ref_doc, $ref_article, $qte, $sn) {
	global $bdd;
	
	$ref_stock_article = "";
	
	$query = "SELECT ref_stock_article
						FROM stocks_articles
						WHERE ref_article = '".$ref_article."' && id_stock = '".$this->id_stock."' ";
	$resultat = $bdd->query($query);
	while ($tmp = $resultat->fetchObject()) {$ref_stock_article = $tmp->ref_stock_article;}
	
	$query = "UPDATE stocks_articles
						SET qte = qte + ".$qte."
						WHERE ref_article = '".$ref_article."' && id_stock = '".$this->id_stock."' ";
	$resultat = $bdd->query($query);
	if (!$resultat->rowCount()) {
		// La ligne n'existe pas dans le stock, il faut la créer
		$reference = new reference ($this->STOCK_ARTICLE_ID_REFERENCE_TAG);
		$ref_stock_article = $reference->generer_ref();
		$query = "INSERT INTO stocks_articles (ref_stock_article, id_stock, ref_article, qte)
							VALUES ('".$ref_stock_article."', '".$this->id_stock."', '".$ref_article."', '".$qte."') ";
		$bdd->exec ($query);
		unset ($reference, $resultat);
	}
	// Préparation de la requete
	$query_sn = "";
	foreach ($sn as $numero) {
		if ($query_sn) { $query_sn .= ","; }
		$query_sn .= "('".$ref_stock_article."', '".$numero->numero_serie."', '".$numero->sn_qte."')";
	}
	if (count($sn)) {
		// Ajout des numéros de série dans le stock
		$query = "INSERT INTO stocks_articles_sn (ref_stock_article, numero_serie,sn_qte)
							VALUES ".$query_sn."";
		$bdd->exec($query);
	}
	
	// Inscription dans le mouvement de stock
	$this->genere_move_stock ($ref_doc, $ref_article, $qte );
	
	return true;
}

// Supprimer un article au stock
public function supprimer_to_stock ($ref_doc, $ref_article, $qte, $sn ) {
	global $bdd;
	
	$ref_stock_article = "";
	
	$query = "SELECT ref_stock_article
						FROM stocks_articles
						WHERE ref_article = '".$ref_article."' && id_stock = '".$this->id_stock."' ";
	$resultat = $bdd->query($query);
	while ($tmp = $resultat->fetchObject()) {$ref_stock_article = $tmp->ref_stock_article;}
	
	$query = "UPDATE stocks_articles
						SET qte = qte - ".$qte."
						WHERE ref_article = '".$ref_article."' && id_stock = '".$this->id_stock."' ";
	$resultat = $bdd->query($query);
	if (!$resultat->rowCount()) {
		// La ligne n'existe pas dans le stock, il faut la créer
		$reference = new reference ($this->STOCK_ARTICLE_ID_REFERENCE_TAG);
		$ref_stock_article = $reference->generer_ref();
		$query = "INSERT INTO stocks_articles (ref_stock_article, id_stock, ref_article, qte)
							VALUES ('".$ref_stock_article."', '".$this->id_stock."', '".$ref_article."', '-".$qte."') ";
		$bdd->exec ($query);
		unset ($reference, $resultat);
	}
	
	
	if (count($sn)) {
		// Préparation de la requete
		$tmp_article = new article($ref_article);
		//supression de SN
		if ($tmp_article->getGestion_sn() == 1) {
			// Préparation de la requete
			$query_sn = "";
			foreach ($sn as $numero) {
				if ($query_sn) { $query_sn .= ","; }
				$query_sn .= "'".$numero."'";
			}
		
			// Suppression des numéros de série dans le stock
			$query = "DELETE FROM stocks_articles_sn 
								WHERE ref_stock_article = '".$ref_stock_article."' && numero_serie IN (".$query_sn.")";
			$bdd->exec($query);
		}
		
		//supression des lots
		if ($tmp_article->getGestion_sn() == 2) {
			// Préparation de la requete
			foreach ($sn as $numero) {
				$query = "SELECT sn_qte FROM stocks_articles_sn 
									WHERE ref_stock_article = '".$ref_stock_article."' && numero_serie IN ('".$numero->numero_serie."')";
				$resultat = $bdd->query($query);
				if ($lot = $resultat->fetchObject()){
					if ($numero->sn_qte >= $lot->sn_qte ){
						$query = "DELETE FROM stocks_articles_sn 
											WHERE ref_stock_article = '".$ref_stock_article."' && numero_serie IN ('".$numero->numero_serie."')";
						$bdd->exec($query);
					}else{
						$query = "UPDATE stocks_articles_sn
											SET sn_qte = sn_qte - ".$numero->sn_qte." 
											WHERE ref_stock_article = '".$ref_stock_article."' && numero_serie IN ('".$numero->numero_serie."')";
						$bdd->exec($query);
					}
				}
			}
		}
	}
	// Inscription dans le mouvement de stock
	$this->genere_move_stock ($ref_doc, $ref_article, -$qte);
	
	return true;
}


// Générer un mouvement de stock
public function genere_move_stock ($ref_doc, $ref_article, $qte) {
	global $bdd;
	// *************************************************
	// Enregistrement du mouvement
	$reference = new reference ($this->STOCK_MOVE_ID_REFERENCE_TAG);
	$ref_stock_move = $reference->generer_ref();
	$query = "INSERT INTO stocks_moves (ref_stock_move, id_stock, ref_article, qte, ref_doc, date)
						VALUES ('".$ref_stock_move."', '".$this->id_stock."', '".$ref_article."', '".$qte."', ".ref_or_null($ref_doc).", NOW()) ";
	$bdd->exec ($query);
	return true;
}



// valeur du stock
public function valeur_stock () {
	global $bdd;
	
	$stock_valeur = 0;
	
	$query = "SELECT sa.ref_stock_article, sa.ref_article, sa.id_stock, sa.qte, a.prix_achat_ht
						FROM stocks_articles sa 
						LEFT JOIN articles a ON sa.ref_article = a.ref_article
						WHERE  sa.qte > 0 && sa.id_stock = '".$this->id_stock."' ";
	$resultat = $bdd->query ($query);
	while ($stock_articles = $resultat->fetchObject()) { 
		$stock_valeur +=  $stock_articles->prix_achat_ht *$stock_articles->qte;
	}
	return $stock_valeur;
						
}
// dernier inventaire du stock
public function last_inventaire_stock () {
	global $bdd;
	
	
	$query = "SELECT MAX(d.date_creation_doc) as date_creation
						FROM documents d  
						LEFT JOIN doc_inv di ON di.ref_doc = d.ref_doc 
						WHERE  di.id_stock = '".$this->id_stock."' && d.id_etat_doc = '46' ";
	$resultat = $bdd->query ($query);
	if  ($stock_inv = $resultat->fetchObject()) { 
		return  $stock_inv->date_creation;
	}
						
}


// erreurs du stock
public function erreurs_stock () {
	global $bdd;
	
	$stock_erreurs = array();
	
	$query = "SELECT sa.ref_stock_article, sa.ref_article, sa.id_stock, sa.qte
						FROM stocks_articles sa 
						WHERE  sa.qte < 0 && sa.id_stock = '".$this->id_stock."' ";
	$resultat = $bdd->query ($query);
	while ($stock_articles = $resultat->fetchObject()) { 
		$stock_erreurs [] =  $stock_articles;
	}
	return $stock_erreurs;
						
}

// *************************************************************************************************************
// FONCTIONS DIVERSES 
// *************************************************************************************************************
static function getArticles_sn ($id_stock, $ref_article) {
	global $bdd;

	$numeros = array();
	$query = "SELECT numero_serie, sn_qte
						FROM stocks_articles_sn sas
							LEFT JOIN stocks_articles sa ON sa.ref_stock_article = sas.ref_stock_article
						WHERE sa.ref_article = '".$ref_article."' && sa.id_stock = '".$id_stock."' ";
	$resultat = $bdd->query($query);
	while ($sn = $resultat->fetchObject()) { $numeros[] = $sn; }
	
	return $numeros;
}

//charge les numéros de lot
static function getArticles_nl ($id_stock, $ref_article) {
	global $bdd;

	$numeros = array();
	$query = "SELECT numero_serie, sn_qte
						FROM stocks_articles_sn sas
							LEFT JOIN stocks_articles sa ON sa.ref_stock_article = sas.ref_stock_article
						WHERE sa.ref_article = '".$ref_article."' && sa.id_stock = '".$id_stock."'
						ORDER BY numero_serie ASC ";
	$resultat = $bdd->query($query);
	while ($sn = $resultat->fetchObject()) {
		if (!isset($numeros[$sn->numero_serie])) {$numeros[$sn->numero_serie] = 0; }
		$numeros[$sn->numero_serie] += $sn->sn_qte; 
	}
	
	return $numeros;
}



//fonction v?rifiant l'existance d'un article en stock (tout stocks confondus)
static function still_in_stock ($ref_article) {
	global $bdd;

	// Recherche
	$query = "SELECT sa.ref_article
						FROM stocks_articles sa
						WHERE sa.ref_article = '".$ref_article."' && sa.qte > 0";
	$resultat = $bdd->query($query);
	if ($article = $resultat->fetchObject()) { return true; }
	
	return false;
}
// *************************************************************************************************************
// FONCTIONS RELATIVE AU PDF
// *************************************************************************************************************
public static function get_code_pdf_modele () {
    return stock::$code_pdf_modele;
}

//changement du code_pdf_modele
public static function change_code_pdf_modele ($code_pdf_mod) {
	stock::$code_pdf_modele = $code_pdf_mod;
} 

//chargement des infos du modeles pdf par defaut
public static function charge_defaut_modele_pdf() {
	global $bdd;
	$query = "SELECT pm.code_pdf_modele
			FROM stocks_modeles_pdf smp 
			LEFT JOIN pdf_modeles pm ON smp.id_pdf_modele = pm.id_pdf_modele
			WHERE smp.usage = 'defaut';
			";
	$resultat = $bdd->query ($query);
	if ($modele_pdf = $resultat->fetchObject()) {
		stock::$code_pdf_modele = $modele_pdf->code_pdf_modele;
		return stock::$code_pdf_modele;
	}
	return false;
}

//chargement des infos d'un modele pdf
public static function charge_modele_pdf() {
	global $bdd;
	$modeles_liste	= array();
	$query = "SELECT id_pdf_modele, id_pdf_type, lib_modele, desc_modele , code_pdf_modele
							FROM pdf_modeles  
							WHERE id_pdf_type = '6'
							";
	$resultat = $bdd->query ($query);
	while ($modele_pdf = $resultat->fetchObject()) { $modeles_liste[] = $modele_pdf;}
	return $modeles_liste;
}

public static function getListePdf(){
	global $bdd;
	
	$liste = array();
	$query = "SELECT smp.id_pdf_modele, smp.usage, pm.lib_modele, pm.desc_modele
		FROM stocks_modeles_pdf smp
		LEFT JOIN pdf_modeles pm ON smp.id_pdf_modele = pm.id_pdf_modele
		WHERE pm.id_pdf_type = '6'
		ORDER BY pm.lib_modele ASC, smp.usage ASC;";
	$res = $bdd->query($query);
	while ($r = $res->fetchObject()) { $liste[] = $r;}
	return $liste;
}

//modele pdf par d?ut
public static function defaut_modele_pdf ($id_pdf_modele) {
	global $bdd;
	
	$query = "UPDATE stocks_modeles_pdf
						SET  `usage` = 'actif'
						WHERE `usage` = 'defaut' 
						";
	$bdd->exec ($query);
	
	$query = "UPDATE stocks_modeles_pdf
						SET  `usage` = 'defaut'
						WHERE id_pdf_modele = '".$id_pdf_modele."' 
						";
	$bdd->exec ($query);
	return true;
}
public static function active_modele_pdf($id_pdf_modele) {
	global $bdd;
	
	$query = "UPDATE stocks_modeles_pdf
						SET  `usage` = 'actif'
						WHERE id_pdf_modele = '".$id_pdf_modele."' 
						";
	$bdd->exec ($query);
	return true;
}
public static function desactive_modele_pdf($id_pdf_modele) {
	global $bdd;
	
	$query = "UPDATE stocks_modeles_pdf
						SET  `usage` = 'inactif'
						WHERE id_pdf_modele = '".$id_pdf_modele."' 
						";
	echo $query;
	$bdd->exec ($query);
	return true;
}


//fonction d'impression des états des stocks
//$infos["id_stock"] contient la liste des id de stocks séparé par une virgule
public static function imprimer_etat_stocks ($infos, $print = 0) {
	global $bdd;
	global $PDF_MODELES_DIR;
	
	
	//diden
	$tab = explode(",",$infos["id_stocks"]);
	// Recherche des resultats
	$fiches = array();
	// Préparation de la requete
	$query_select = "";
	$query_join 	= "";
	$query_where 	= " dispo = 1 && a.lot != '2' && a.modele = 'materiel'  ";
	$query_group	= "";

	// Catégorie
	if ($infos['ref_art_categ']) { 
		$query_where 	.= " && a.ref_art_categ = '".$infos['ref_art_categ']."'";
	}
	// Constructeur
	if ($infos['ref_constructeur']) { 
		$query_where 	.= " && a.ref_constructeur = '".$infos['ref_constructeur']."'";
	}
	// prix d'achat
	if ($infos['aff_pa']) {
		$query_select 	.= ",  a.prix_achat_ht, a.paa_ht ";
	}

	// Sélection des stocks disponibles
	$where_stock = "";
	$where_stock .= " && (";
	$bool = false;
	foreach($tab as $id_stock ) {
		if($bool){ $where_stock .= " || "; }
		$bool =  true;
	$where_stock .= " sa.id_stock = '".$id_stock."'"; 
		
	}
	$where_stock .= ")";
		
	// stock non null
	if ($infos['in_stock'] == 1) {
		$query_join 	.= " LEFT JOIN stocks_articles sa ON a.ref_article = sa.ref_article";
		$query_where 	.=  " && sa.qte < 0 ".$where_stock." ";
		$query_group	.= "GROUP BY a.ref_article, sa.ref_article ";
	}
	// stock positif
	if ($infos['in_stock'] == 2) {
		$query_join 	.= " LEFT JOIN stocks_articles sa ON a.ref_article = sa.ref_article";
		$query_where 	.=  " && sa.qte > 0 ".$where_stock." ";
		$query_group	.= "GROUP BY a.ref_article, sa.ref_article ";
	}
	// Ajustement pour faire fonctionner le comptage

	// Recherche
	$query = "SELECT a.ref_article, a.ref_oem, a.ref_art_categ, a.ref_interne, a.lib_article, 
									 a.ref_constructeur, 
									 ac.lib_art_categ, ac.ref_art_categ_parent
									 ".$query_select."

						FROM articles a
							LEFT JOIN annuaire ann ON a.ref_constructeur = ann.ref_contact 
							LEFT JOIN art_categs ac ON a.ref_art_categ = ac.ref_art_categ 
							".$query_join."
						WHERE ".$query_where."
						".$query_group."
						ORDER BY a.lib_article ASC";
	$resultat = $bdd->query($query);
	while ($fiche = $resultat->fetchObject()) {
		//echo "//".$fiche->ref_article."     ";
		//$leStock = new stock($id_stock);
		//$laquantite = $leStock->getArticle_qte_instock ($fiche->ref_article, $this->$id_stock);
		//$libel = $leStock->getLib_stock();
		//echo $libel;
		$fiche->stocks = array();
		
		$query = "SELECT sa.id_stock, sa.qte
							FROM stocks_articles sa 
							WHERE sa.ref_article = '".$fiche->ref_article."' ".$where_stock;
						
		$resultat2 = $bdd->query ($query);
		while ($var = $resultat2->fetchObject()) { 
			$fiche->qte[$var->id_stock] = $var->qte; 
		}
		$fiches[] = $fiche; 
	}
	unset ($fiche, $resultat, $query);
	
	
	if (isset($fiches)) {
		$list_art_categ = get_articles_categories();
		$lib_indentation = "";
		$last_indentation = 0;
		$compte_indentation = array();
		
		foreach ($list_art_categ as $art_categ) {
			$compte_indentation[$art_categ->indentation] = $art_categ->lib_art_categ;
			$fiches_tmp = array();
			foreach ($fiches as $fiche) {
			
				if ($fiche->ref_art_categ == $art_categ->ref_art_categ) {
				
					$lib_indentation = "";
					for ($i = 0; $i <= $art_categ->indentation; $i++) {
						if ($i != 0) {$lib_indentation .= " => ";}
						$lib_indentation .= $compte_indentation[$i];
					}
					$fiche->lib_art_categ = $lib_indentation;
					
				}
				$fiches_tmp[] = $fiche;
				
			}
		}
	}
	$fiches = $fiches_tmp; 
	
	// Affichage du pdf
	// Préférences et options
	$GLOBALS['PDF_OPTIONS']['HideToolbar'] = 0;
	$GLOBALS['PDF_OPTIONS']['AutoPrint'] = $print;

	$code_model_pdf = stock::get_code_pdf_modele();
	include_once ($PDF_MODELES_DIR.$code_model_pdf.".class.php");
	$class = "pdf_".$code_model_pdf;
	$pdf = new $class;
	
	// Création
	if($pdf->create_pdf($tab, $fiches, $infos)){
		// Sortie
		$pdf->Output();
	}

}

// *************************************************************************************************************
// FONCTIONS DE LECTURE DES DONNEES 
// *************************************************************************************************************
function getId_stock () {
	return $this->id_stock;
}

function getLib_stock () {
	return $this->lib_stock;
}

function getAbrev_stock () {
	return $this->abrev_stock;
}

function getRef_adr_stock () {
 return $this->ref_adr_stock;
}

function getActif () {
	return $this->actif;
}

function getAdresse () {
	$this->charger_adresse();
	return $this->adresse;
}



}

//fonction qui retourne la quantité d'un article en stock (indication de quantité lors de la maj_qte de certains documents
function getArticle_qte_instock ($ref_article, $id_stock) {
	global $bdd;
	
	$query = "SELECT qte
							FROM stocks_articles 
						WHERE ref_article = '".$ref_article."' && id_stock = '".$id_stock."' ";
	$resultat = $bdd->query ($query); 
	
	return $resultat->fetchObject();
	
}

//fonction retournant la liste des stocks
function fetch_all_stocks () {
	global $bdd;
	
	$stocks_liste	= array();
	$query = "SELECT id_stock, lib_stock, abrev_stock, ref_adr_stock, actif
						FROM stocks
						ORDER BY actif DESC, lib_stock ASC";
	$resultat = $bdd->query ($query);
	while ($stock = $resultat->fetchObject()) { $stocks_liste[$stock->id_stock] = $stock; }
	return $stocks_liste;
	
}


// valeur du stock par art_categ
function valeur_stock_art_categ ($id_stock, $ref_art_categ) {
	global $bdd;
	
	$stock_valeur = 0;
	
	$query = "SELECT sa.ref_stock_article, sa.ref_article, sa.id_stock, sa.qte, a.prix_achat_ht
						FROM stocks_articles sa 
						LEFT JOIN articles a ON sa.ref_article = a.ref_article
						WHERE  sa.qte > 0 && sa.id_stock = '".$id_stock."' && a.ref_art_categ = '".$ref_art_categ."' ";
	$resultat = $bdd->query ($query);
	while ($stock_articles = $resultat->fetchObject()) { 
		$stock_valeur +=  $stock_articles->prix_achat_ht *$stock_articles->qte;
	}
	return $stock_valeur;
						
}
?>