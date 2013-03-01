<?php
// *************************************************************************************************************
// CLASSE REGISSANT LES INFORMATIONS SUR UN MODE DE LIVRAISON
// *************************************************************************************************************


final class livraison_modes {
	private $id_livraison_mode;			// Identifiant du mode de livraison
	private $ref_article;
	private $article;


function __construct($id_livraison_mode = "") {
	global $bdd;

	// Controle si la id_livraison_mode est précisée
	if (!$id_livraison_mode) { return false; }

	// Sélection des informations générales
	$query = "SELECT id_livraison_mode, ref_article
						FROM livraisons_modes 
						WHERE id_livraison_mode = '".$id_livraison_mode."' ";
	$resultat = $bdd->query ($query);

	// Controle si la id_art_modele est trouvée
	if (!$liv_mode = $resultat->fetchObject()) { return false; }

	// Attribution des informations à l'objet
	$this->id_livraison_mode 		= $id_livraison_mode;
	$this->ref_article					= $liv_mode->ref_article;
	$this->article						= new article($this->ref_article);

	return true;
}


function create($lib_livraison_mode, $abrev_livraison_mode, $ref_transporteur) {
	global $bdd;
	global $DEFAUT_ID_TVA;
	global $LIVRAISON_MODE_ART_CATEG;
	global $MODELE_SPE_LIVRAISON;
	global $CONSTRUCTEUR_ID_PROFIL;


	if (!$lib_livraison_mode) {
		$GLOBALS['_ALERTES']['lib_livraison_mode_vide'] = 1;
	}
	if (!$ref_transporteur) {
		$GLOBALS['_ALERTES']['ref_transporteur_vide'] = 1;
	}
	// *************************************************
	// Si les valeurs reçues sont incorrectes
	if (count($GLOBALS['_ALERTES'])) {
		return false;
	}
	
	//établir notre transporteur comme constructeur de l'article (donc lui attribuer le profil constructeur
	$this->check_transporteur_as_constructeur ($ref_transporteur);

	//verification d'un art_categ définie par défaut pour le mode de livraison
	if (!$LIVRAISON_MODE_ART_CATEG) {
		$LIVRAISON_MODE_ART_CATEG = $this->check_art_categ_livraison_exist ();
	}
	
	//création de l'article
	$stocks_alertes = array();
	$code_barre = array();
	$infos_generales['modele']	=	"service";
	$infos_modele = array();

	$infos_generales['ref_art_categ'] 		= $LIVRAISON_MODE_ART_CATEG;
	$infos_generales['lib_article'] 			= trim($lib_livraison_mode);
	$infos_generales['lib_ticket']				= $abrev_livraison_mode;
	$infos_generales['desc_courte'] 			= "";
	$infos_generales['desc_longue'] 			= "";
	$infos_generales['ref_interne'] 			= "";
	$infos_generales['ref_oem'] 					= "";
	$infos_generales['ref_constructeur'] 	= $ref_transporteur;
	$infos_generales['variante'] 					= "";
	$infos_generales['id_valo'] 					= 1;
	$infos_generales['valo_indice'] 			= 1;
	$infos_generales['lot'] 							= 0;
	$infos_generales['gestion_sn'] 				= 0;
	$infos_generales['code_barre'] 				= $code_barre;
	$infos_generales['id_tva']						=	"";
	if ($DEFAUT_ID_TVA) {$infos_generales['id_tva'] =	$DEFAUT_ID_TVA;}
	$infos_generales['tva'] 							= "";
	
	$infos_generales['date_debut_dispo'] 	= date("Y-m-d");;
	$infos_generales['date_fin_dispo'] 		= "2200/01/01";
	
	$infos_generales['prix_public_ht']	=	0;
	$infos_generales['prix_achat_ht']	= 0;			
	$infos_generales['paa_ht']	=	0;
	
	$formules_tarifs	=	array();
	$caracs	=	array();
	$liaisons	=	array();
	$composants	=	array();

	$this->article = new article ();
	$this->article->create($infos_generales, $infos_modele, $caracs, $formules_tarifs, $composants, $liaisons);
	$this->article->maj_article_modele_spe ($MODELE_SPE_LIVRAISON);
	
	//création du mode de livraison
	$query = "INSERT INTO livraisons_modes (ref_article)
						VALUES ('".$this->article->getRef_article()."') ";
	$bdd->exec ($query);

	return true;
	
}



function modifier($lib_livraison_mode, $abrev_livraison_mode, $ref_transporteur) {
	global $bdd;
	global $DEFAUT_ID_TVA;
	global $LIVRAISON_MODE_ART_CATEG;
	global $MODELE_SPE_LIVRAISON;
	global $CONSTRUCTEUR_ID_PROFIL;


	if (!$lib_livraison_mode) {
		$GLOBALS['_ALERTES']['lib_livraison_mode_vide'] = 1;
	}
	if (!$ref_transporteur) {
		$GLOBALS['_ALERTES']['ref_transporteur_vide'] = 1;
	}
	// *************************************************
	// Si les valeurs reçues sont incorrectes
	if (count($GLOBALS['_ALERTES'])) {
		return false;
	}
	
	//établir notre transporteur comme constructeur de l'article (donc lui attribuer le profil constructeur
	$this->check_transporteur_as_constructeur ($ref_transporteur);

	//verification d'un art_categ définie par défaut pour le mode de livraison
	if (!$LIVRAISON_MODE_ART_CATEG) {
		$LIVRAISON_MODE_ART_CATEG = $this->check_art_categ_livraison_exist ();
	}
	
	//mise à jour de l'article associé
	$infos_generales = array();
	$infos_generales['lib_article'] 			= trim($lib_livraison_mode);
	$infos_generales['lib_ticket']				= $abrev_livraison_mode;
	$infos_generales['ref_constructeur'] 	= $ref_transporteur;

	$this->article->maj_art_spe($infos_generales);
	
	return true;
	
}

function supprimer() {
	global $bdd;
	
	$this->article->stop_article ();
	
	$query = "DELETE FROM livraisons_modes 
						WHERE  id_livraison_mode = '".$this->id_livraison_mode."'  ";
	$bdd->exec ($query);

	return true;
	
}

function create_zone($liste_cp, $id_pays) {
	global $bdd;

	//création de la zone de livraison
	$query = "INSERT INTO livraisons_modes_zones (id_livraison_mode, id_pays, liste_cp)
						VALUES ('".$this->id_livraison_mode."', '".$id_pays."', '".$liste_cp."') ";
	$bdd->exec ($query);

	return true;
}

function modifier_zone($id_livraison_zone, $liste_cp, $id_pays) {
	global $bdd;

	//modification de la zone de livraison
	$query = "UPDATE livraisons_modes_zones SET id_pays = '".$id_pays."', liste_cp = '".$liste_cp."'
						WHERE id_livraison_mode = '".$this->id_livraison_mode."' &&  id_livraison_zone = '".$id_livraison_zone."' ";
	$bdd->exec ($query);

	return true;
}

function supprimer_zone($id_livraison_zone) {
	global $bdd;

	//suppression de la zone de livraison
	$query = "DELETE FROM livraisons_modes_zones 
						WHERE id_livraison_mode = '".$this->id_livraison_mode."' &&  id_livraison_zone = '".$id_livraison_zone."' ";
	$bdd->exec ($query);

	return true;
}
//cout de transport général
function create_cost($base_calcul, $liste_cost) {
	global $bdd;

	//suppression des tarifs de livraison
	$query = "DELETE FROM livraisons_modes_tarifs 
						WHERE id_livraison_mode = '".$this->id_livraison_mode."' ";
	$bdd->exec ($query);
	
	foreach ($liste_cost as $cost) {
		$query = "INSERT INTO livraisons_modes_tarifs (id_livraison_mode, base_calcul, indice_min, formule)
							VALUES ('".$this->id_livraison_mode."', '".$base_calcul."', '".$cost->indice_min."', '".$cost->formule."') ";
		$bdd->exec ($query);
		
	}


	return true;
}

//cout de transport par art_categ
function create_cost_ref_art_categ($ref_art_categ , $base_calcul, $liste_cost) {
	global $bdd;

	//suppression des tarifs de livraison
	$query = "DELETE FROM livraisons_tarifs_art_categ
						WHERE id_livraison_mode = '".$this->id_livraison_mode."' && ref_art_categ = '".$ref_art_categ."' ";
	$bdd->exec ($query);
	
	foreach ($liste_cost as $cost) {
		$query = "INSERT INTO livraisons_tarifs_art_categ (ref_art_categ, id_livraison_mode, base_calcul, indice_min, formule)
							VALUES ('".$ref_art_categ."', '".$this->id_livraison_mode."', '".$base_calcul."', '".$cost->indice_min."', '".$cost->formule."') ";
		$bdd->exec ($query);
		
	}

	return true;
}

//cout de transport par articles
function create_cost_ref_article($ref_article , $base_calcul, $liste_cost) {
	global $bdd;

	//suppression des tarifs de livraison
	$query = "DELETE FROM livraisons_tarifs_articles
						WHERE id_livraison_mode = '".$this->id_livraison_mode."' && ref_article = '".$ref_article."' ";
	$bdd->exec ($query);
	
	foreach ($liste_cost as $cost) {
		$query = "INSERT INTO livraisons_tarifs_articles (ref_article, id_livraison_mode, base_calcul, indice_min, formule)
							VALUES ('".$ref_article."', '".$this->id_livraison_mode."', '".$base_calcul."', '".$cost->indice_min."', '".$cost->formule."') ";
		$bdd->exec ($query);
		
	}

	return true;
}
// *************************************************************************************************************
// FONCTIONS DE CHARGEMENTS DES ZONES ET TARIFS 
// *************************************************************************************************************
function charger_livraisons_modes_zone() {
	global $bdd;


	$liste_livraison_zones = array();
	// Sélection des informations générales
	$query = "SELECT id_livraison_zone, id_livraison_mode, id_pays, liste_cp
						FROM livraisons_modes_zones 
						WHERE id_livraison_mode = '".$this->id_livraison_mode."'
						 ";
	$resultat = $bdd->query ($query);

	// Controle si la id_art_modele est trouvée
	while ($liv_zone = $resultat->fetchObject()) { 
		$liste_livraison_zones[] = $liv_zone;
	}
	return $liste_livraison_zones;

}

function charger_livraisons_modes_cost() {
	global $bdd;


	$liste_livraison_tarifs = array();
	// Sélection des informations générales
	$query = "SELECT id_livraison_mode, base_calcul, indice_min, formule
						FROM livraisons_modes_tarifs 
						WHERE id_livraison_mode = '".$this->id_livraison_mode."'
						ORDER BY indice_min ASC
						 ";
	$resultat = $bdd->query ($query);

	// Controle si la id_art_modele est trouvée
	while ($liv_tarifs = $resultat->fetchObject()) { 
		$liste_livraison_tarifs[] = $liv_tarifs;
	}
	return $liste_livraison_tarifs;

}

// *************************************************************************************************************
// FONCTIONS DIVERSES
// *************************************************************************************************************
function check_transporteur_as_constructeur ($ref_transporteur) {
	global $CONSTRUCTEUR_ID_PROFIL;
	
	$contact= new contact ($ref_transporteur);
	$profils 	= $contact->getProfils();
	
	if ($CONSTRUCTEUR_ID_PROFIL != 0 && !isset($profils[$CONSTRUCTEUR_ID_PROFIL]) ) {	
		$infos_profils = array();
		$id_profil = $CONSTRUCTEUR_ID_PROFIL;
		$infos_profils[$id_profil]['id_profil'] = $CONSTRUCTEUR_ID_PROFIL;
		$infos_profils[$id_profil]['identifiant_revendeur'] = "";
		$infos_profils[$id_profil]['conditions_garantie'] = "";
		
		// *************************************************
		// Modification du profil
		$contact->create_profiled_infos ($infos_profils[$id_profil]);
	}
}

function check_art_categ_livraison_exist () {
	global $bdd;
	global $DIR;
	global $DEFAUT_ID_TVA;
	global $LIVRAISON_MODE_ART_CATEG;
	global $MODELE_SPE_LIVRAISON;
	global $CONSTRUCTEUR_ID_PROFIL;

	$query = "SELECT ref_art_categ, lib_art_categ, modele, id_modele_spe, desc_art_categ, defaut_id_tva, duree_dispo, 
										defaut_numero_compte_vente, defaut_numero_compte_achat, ref_art_categ_parent
						FROM art_categs ac
						WHERE id_modele_spe = '".$LIVRAISON_MODE_ART_CATEG."' ";
	$resultat = $bdd->query ($query);
	
	// Controle si la ref_art_categ est trouvée
	if (!$art_categ = $resultat->fetchObject()) { 
		//on cré alors la ref_art_categ
		
		$lib_art_categ				= "Frais de transport et de livraison";
		$modele 							= "service";
		$desc_art_categ				= "";
		$ref_art_categ_parent	=	"";
		$defaut_id_tva_art				=	"";
		if ($DEFAUT_ID_TVA) {$defaut_id_tva_art	=	$DEFAUT_ID_TVA;}
		
		$duree_dispo 					= 0;
		
		// *************************************************
		// Création de la catégorie
		$art_categ = new art_categ ();
		$art_categ->create ($lib_art_categ, $desc_art_categ, $ref_art_categ_parent, $modele, $defaut_id_tva_art, $duree_dispo);
		$art_categ->maj_art_categ_modele_spe ($MODELE_SPE_LIVRAISON);
		
		$LIVRAISON_MODE_ART_CATEG = $art_categ->getRef_art_categ();
		//mise à jour de la vairable systeme
		maj_configuration_file ("config_systeme.inc.php", "maj_line", "\$LIVRAISON_MODE_ART_CATEG =", "\$LIVRAISON_MODE_ART_CATEG = \"".$art_categ->getRef_art_categ()."\";", $DIR."config/");
	}
		
	return $LIVRAISON_MODE_ART_CATEG;

}

//Calcul livraison pour document
function calcul_frais_livraison_doc($document) {
	
	$infos = array();
	$infos['type_of_line']	=	"article";
	$infos['sn']						= array();
	$infos['ref_article']		=	$this->getRef_article();
	$infos['pu_ht']					=	$this->contenu_calcul_frais_livraison ($document);
	$infos['qte']						=	1;
	$document->add_line ($infos);
}

//calcul du frais de port pour les articles d'un contenu de document
function contenu_calcul_frais_livraison($document){
	global $bdd;
	global $LIVRAISON_CLIENT_ID_TYPE_DOC;
	global $COMMANDE_CLIENT_ID_TYPE_DOC;
	global $DEVIS_CLIENT_ID_TYPE_DOC;
	global $PANIER_CLIENT_ID_TYPE_DOC;
	global $TRANSFERT_ID_TYPE_DOC;
	global $BASE_CALCUL_LIVRAISON;
	global $CALCUL_TARIFS_NB_DECIMALS;
	
	//récupération du code postal et de l'idpays du document
	$id_type_doc = $document->getId_type_doc();
	$code_postal = "";
	$id_pays = "";

	switch ($id_type_doc) {
		case $COMMANDE_CLIENT_ID_TYPE_DOC: case $DEVIS_CLIENT_ID_TYPE_DOC: case $PANIER_CLIENT_ID_TYPE_DOC:
			$code_postal = trim($document->getCode_postal_livraison());
			$id_pays = $document->getId_pays_livraison();
		break;
		case $LIVRAISON_CLIENT_ID_TYPE_DOC:
			$code_postal = trim($document->getCode_postal_contact());
			$id_pays = $document->getId_pays_contact();
		break;
		case $TRANSFERT_ID_TYPE_DOC:
			if (isset($_SESSION['stocks'][$document->getId_stock_cible()])) {
				$adresse = $_SESSION['stocks'][$document->getId_stock_cible()]->getAdresse ();
				$code_postal = trim($adresse->getCode_postal());
				$id_pays = $adresse->getId_pays();
			}
		break;
	}
	
	
	//si pas de zone définie alors calcul impossible
	if ((!trim($code_postal) || !is_numeric($code_postal)) && !$id_pays) {
		$GLOBALS['_INFOS']['calcul_livraison_mode_nozone'] = 1;
		return "0";
	}
	
	//chargement des zones de livraison
	$zones_livrables = $this->charger_livraisons_modes_zone();
	foreach ($zones_livrables as $zone_liv) {
		$listecp_zone = explode(";", trim($zone_liv->liste_cp));
		if ($zone_liv->id_pays == $id_pays && count($listecp_zone)<=1) { $id_zone = $zone_liv->id_livraison_zone; break;}
		foreach ($listecp_zone as $cp) {
			if (!$cp) {continue;}
			if ( substr_count(substr($code_postal, 0 , strlen($cp)), $cp) ) { $id_zone = $zone_liv->id_livraison_zone; break;}
		}
	}
	//si pas de zone définie alors calcul impossible
	if (!isset($id_zone)) {
		$GLOBALS['_INFOS']['calcul_livraison_mode_impzone'] = 1;
		return "0";
	}
	
	//chargement tarification de la livraison
	$tarifs_livraison = $this->charger_livraisons_modes_cost();
	
	//constuction conteneur de résultat
	$livraison_cost_result = array();
	//tableau des formules utilisées
	$formules_liste = array();
	
	$prix_fraisport = 0;
	
	foreach ($BASE_CALCUL_LIVRAISON as $base=>$calcul) {
		$livraison_cost_result[$base] = array();
		$formules_liste[$base] = array();
	}
	
	$liste_contenu = $document->getContenu ();
	foreach ($liste_contenu as $contenu) {
		if ($contenu->type_of_line != "article") {continue;}
		if ($contenu->ref_article == $this->ref_article) {continue;}
		
		$tmp_article = new article($contenu->ref_article);
		
		$article_regle_cost = $tarifs_livraison;
		$article_livraisons_tarifs = array();
		$art_categ_livraisons_tarifs = array();
		//
		$query_tmp = "SELECT ref_article ,id_livraison_mode , base_calcul ,indice_min,formule
									FROM livraisons_tarifs_articles  
									WHERE ref_article = '".$contenu->ref_article."' && id_livraison_mode = '".$this->id_livraison_mode."'
								";
		$resultat_tmp = $bdd->query($query_tmp);
		while ($regle_tmp = $resultat_tmp->fetchObject()) {
			$article_livraisons_tarifs[] = $regle_tmp;
		} 
		if (count($article_livraisons_tarifs)) {$article_regle_cost = $article_livraisons_tarifs;}
		//
		if (!count($article_livraisons_tarifs)) {
			$query_tmp = "SELECT ref_art_categ ,id_livraison_mode , base_calcul ,indice_min,formule
										FROM livraisons_tarifs_art_categ  
										WHERE ref_art_categ = '".$tmp_article->getRef_art_categ()."' && id_livraison_mode = '".$this->id_livraison_mode."'
									";
			$resultat_tmp = $bdd->query($query_tmp);
			while ($regle_tmp = $resultat_tmp->fetchObject()) {
				$art_categ_livraisons_tarifs[] = $regle_tmp;
			} 
			if (count($art_categ_livraisons_tarifs)) {$article_regle_cost = $art_categ_livraisons_tarifs;}
		}
		//si aprés tout ça rien ne resort (aucun tarif défini) on est en ND
		if (!isset($article_regle_cost[0])) { $GLOBALS['_INFOS']['calcul_livraison_mode_ND'] = 1; return "0";}
		$article_base = $article_regle_cost[0]->base_calcul;
		$clef_liste_formule = "";
		foreach ($article_regle_cost as $liv_cost_art) {$clef_liste_formule .= $liv_cost_art->formule;}
		
		switch ($article_base) {
			case "POIDS": 
				$poids_unit =  $tmp_article->getPoids();
				if (!$poids_unit || !is_numeric($poids_unit)) {$poids_unit = 0 ;} 
				$article_valeur_indice = $contenu->qte * $poids_unit;
				//on injecte pour mémoire l'objet des tarifs
				if ( !isset($formules_liste[$article_base][$clef_liste_formule]) ) {
					$formules_liste[$article_base][$clef_liste_formule] = $article_regle_cost;
				} 
				if ( !isset($livraison_cost_result[$article_base][$clef_liste_formule]) ) {
					$livraison_cost_result[$article_base][$clef_liste_formule] = $article_valeur_indice;
				} else {
					$livraison_cost_result[$article_base][$clef_liste_formule] += $article_valeur_indice;
				}
			break;
			case "QTE": 
				$article_valeur_indice = $contenu->qte;
				//on injecte pour mémoire l'objet des tarifs
				if ( !isset($formules_liste[$article_base][$clef_liste_formule]) ) {
					$formules_liste[$article_base][$clef_liste_formule] = $article_regle_cost;
				} 
				if ( !isset($livraison_cost_result[$article_base][$clef_liste_formule]) ) {
					$livraison_cost_result[$article_base][$clef_liste_formule] = $article_valeur_indice;
				} else {
					$livraison_cost_result[$article_base][$clef_liste_formule] += $article_valeur_indice;
				}
			break;
			case "PRIX": 
				$article_valeur_indice = round ($contenu->pu_ht * $contenu->qte * (1-$contenu->remise/100), $CALCUL_TARIFS_NB_DECIMALS);
				//on injecte pour mémoire l'objet des tarifs
				if ( !isset($formules_liste[$article_base][$clef_liste_formule]) ) {
					$formules_liste[$article_base][$clef_liste_formule] = $article_regle_cost;
				} 
				if ( !isset($livraison_cost_result[$article_base][$clef_liste_formule]) ) {
					$livraison_cost_result[$article_base][$clef_liste_formule] = $article_valeur_indice;
				} else {
					$livraison_cost_result[$article_base][$clef_liste_formule] += $article_valeur_indice;
				}
			break;
			case "COLIS": 
				$tmp_liste_colisage = explode(";", $tmp_article->getColisage());
				$article_valeur_indice = 0;
				array_multisort  ($tmp_liste_colisage, SORT_NUMERIC, SORT_DESC);
				
				foreach ($tmp_liste_colisage as $colis) {
				if (!$colis) {continue;}
					if ($colis > $contenu->qte) {continue;}
					$article_valeur_indice = ceil($contenu->qte/$colis); break;
				}
				if (!$article_valeur_indice) { $article_valeur_indice = $contenu->qte; }
				//on injecte pour mémoire l'objet des tarifs
				if ( !isset($formules_liste[$article_base][$clef_liste_formule]) ) {
					$formules_liste[$article_base][$clef_liste_formule] = $article_regle_cost;
				} 
				if ( !isset($livraison_cost_result[$article_base][$clef_liste_formule]) ) {
					$livraison_cost_result[$article_base][$clef_liste_formule] = $article_valeur_indice;
				} else {
					$livraison_cost_result[$article_base][$clef_liste_formule] += $article_valeur_indice;
				}
			break;
		}
		//$GLOBALS['_INFOS']['calcul_livraison_mode_ND'] = 1;
	}
	
	//calcul du total
	foreach ($livraison_cost_result as $kbase=>$vbase) {
		foreach ($vbase as $kformule=>$vindice) {
			$tmp_cost = $formules_liste[$kbase][$kformule];
			foreach ($tmp_cost as $obj_cost) {
				if ($obj_cost->indice_min > $vindice) {break;}
				$tmpobj_cost = $obj_cost;
			}
			$cal = eval("return $tmpobj_cost->formule;");
			if (!isset($tmpobj_cost) || $cal < 0) { 
				$GLOBALS['_INFOS']['calcul_livraison_mode_ND'] = 1; return "0";
			} else {
				$prix_fraisport += eval("return $tmpobj_cost->formule * $vindice;");
			}
			
		}
	}
	
	return $prix_fraisport;

}

// *************************************************************************************************************
// FONCTIONS DE LECTURE DES DONNEES 
// *************************************************************************************************************
function getId_livraison_mode () {
	return $this->id_livraison_mode;
}

function getRef_article () {
	return $this->ref_article;
}

function getArticle () {
	return $this->article;
}



}

function charger_livraisons_modes () {	
	global $bdd;

	$liste_livraison_modes = array();
	// Sélection des informations générales
	$query = "SELECT id_livraison_mode, ref_article
						FROM livraisons_modes 
						 ";
	$resultat = $bdd->query ($query);

	// Controle si la id_art_modele est trouvée
	while ($liv_mode = $resultat->fetchObject()) { 
		$liv_mode->article = new article($liv_mode->ref_article);
		$liste_livraison_modes[] = $liv_mode;
	}
	return $liste_livraison_modes;
}

?>