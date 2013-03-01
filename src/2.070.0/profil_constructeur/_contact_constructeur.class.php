<?php
// *************************************************************************************************************
// CLASSE PERMETTANT LA GESTION D'UN CONTACT AYANT LE PROFIL [CONSTRUCTEUR]  
// *************************************************************************************************************

class contact_constructeur extends contact_profil {
	private $identifiant_revendeur;
	private $conditions_garantie;


function __construct ($ref_contact, $action = "open") {
	global $bdd;

	$this->ref_contact = $ref_contact;
	
	if ($action == "create") {
		return false;
	}

	$query = "SELECT identifiant_revendeur, conditions_garantie 
						FROM annu_constructeur
						WHERE ref_contact = '".$this->ref_contact."' ";	
	$resultat = $bdd->query ($query);

	// Controle si la ref_contact est trouvée
	if (!$contact_constructeur = $resultat->fetchObject()) { return false; }
	
	$this->identifiant_revendeur 		= $contact_constructeur->identifiant_revendeur;
	$this->conditions_garantie	 		= $contact_constructeur->conditions_garantie;
	$this->profil_loaded 	= true;
}



// *************************************************************************************************************
// CREATION DES INFORMATIONS DU PROFIL [CONSTRUCTEUR]  
// *************************************************************************************************************
function create_infos ($infos) {
	global $DIR, $CONFIG_DIR;
	global $bdd;

	// Controle si ces informations sont déjà existantes
	if ($this->profil_loaded) {
		return false;
	}

	// Fichier de configuration de ce profil
	include_once ($CONFIG_DIR."profil_constructeur.config.php");

	// *************************************************
	// Controle des informations
	$this->identifiant_revendeur 		= $infos['identifiant_revendeur'];
	$this->conditions_garantie	 		= $infos['conditions_garantie'];

	// *************************************************
	// Arret en cas d'erreur
	if (count($GLOBALS['_ALERTES'])) {
		return false;
	}

	// *************************************************
	// Insertion des données
	$query = "INSERT INTO annu_constructeur 
							(ref_contact, identifiant_revendeur, conditions_garantie) 
						VALUES ('".$this->ref_contact."', '".addslashes($this->identifiant_revendeur)."', '".addslashes($this->conditions_garantie)."' )"; 
	$bdd->exec($query);

	return true;
}



// *************************************************************************************************************
// MODIFICATION DES INFORMATIONS DU PROFIL [CONSTRUCTEUR]  
// *************************************************************************************************************
function maj_infos ($infos) {
	
	global $bdd;

	if (!$this->profil_loaded) {
		$GLOBALS['_ALERTES']['profil_non_chargé'] = 1;
	}

	// *************************************************
	// Controle des informations
	$this->identifiant_revendeur 		= $infos['identifiant_revendeur'];
	$this->conditions_garantie	 		= $infos['conditions_garantie'];

	// *************************************************
	// Arret en cas d'erreur
	if (count($GLOBALS['_ALERTES'])) {
		return false;
	}

	// *************************************************
	// Mise à jour des données
	$query = "UPDATE annu_constructeur 
						SET identifiant_revendeur = '".addslashes($this->identifiant_revendeur)."' ,
								conditions_garantie = '".addslashes($this->conditions_garantie)."' 
						WHERE ref_contact = '".$this->ref_contact."' ";
	$bdd->exec($query);

	return true;
}



// *************************************************************************************************************
// SUPPRESSION DES INFORMATIONS DU PROFIL [CONSTRUCTEUR]  
// *************************************************************************************************************
function delete_infos () {
	global $bdd;
	
	
	// Vérifie si la suppression de ces informations est possible.
	
	// Supprime les informations
	$query = "DELETE FROM annu_constructeur WHERE ref_contact = '".$this->ref_contact."' ";
	$bdd->exec($query); 
	
	
	if (count($GLOBALS['_ALERTES'])) {
		return false;
	}

	return true;
}


//chargement du CA des articles vendu du constructeur
function charger_constructeur_vente_CA () {
	global $bdd;
	
	$last_exercices = compta_exercices::charger_compta_exercices ();
	$liste_CA = array();
	for ($i = 0; $i < 3 ; $i++) {
		$montant_CA = 0;
		if (!isset($last_exercices[$i])) { break;}
		$query = "SELECT SUM(ROUND(dl.qte * dl.pu_ht * (1-dl.remise/100) ,2)) as montant_ttc
							FROM  docs_lines dl
								LEFT JOIN documents d ON dl.ref_doc = d.ref_doc
								LEFT JOIN articles a ON a.ref_article = dl.ref_article
								LEFT JOIN documents_types dt ON d.id_type_doc = dt.id_type_doc
								LEFT JOIN documents_etats de ON d.id_etat_doc = de.id_etat_doc
							WHERE a.ref_constructeur = '".$this->ref_contact."' && dl.ref_doc_line_parent IS NULL && d.id_etat_doc IN (16,18,19) && dl.visible = 1
										&& date_creation_doc < '".$last_exercices[$i]->date_fin."' && date_creation_doc > '".$last_exercices[$i]->date_debut."' 
							GROUP BY dl.ref_doc_line 
							ORDER BY date_creation DESC, d.id_type_doc ASC
							";
		$resultat = $bdd->query ($query);
		while ($doc = $resultat->fetchObject()) { 
			$montant_CA += $doc->montant_ttc;
		}
		$liste_CA[$i] = $montant_CA;
	}
	
	
	return $liste_CA;
}

//chargement du CA des articles achetés au constructeur
function charger_constructeur_achat_CA () {
	global $bdd;
	
	$last_exercices = compta_exercices::charger_compta_exercices ();
	$liste_CA = array();
	for ($i = 0; $i < 3 ; $i++) {
		$montant_CA = 0;
		if (!isset($last_exercices[$i])) { break;}
		$query = "SELECT SUM(ROUND(dl.qte * dl.pu_ht * (1-dl.remise/100) ,2)) as montant_ttc
							FROM  docs_lines dl
								LEFT JOIN documents d ON dl.ref_doc = d.ref_doc
								LEFT JOIN articles a ON a.ref_article = dl.ref_article
								LEFT JOIN documents_types dt ON d.id_type_doc = dt.id_type_doc
								LEFT JOIN documents_etats de ON d.id_etat_doc = de.id_etat_doc
							WHERE a.ref_constructeur = '".$this->ref_contact."' && dl.ref_doc_line_parent IS NULL && d.id_etat_doc IN (32, 34 , 35) && dl.visible = 1
										&& date_creation_doc < '".$last_exercices[$i]->date_fin."' && date_creation_doc > '".$last_exercices[$i]->date_debut."' 
							GROUP BY dl.ref_doc_line 
							ORDER BY date_creation_doc DESC, d.id_type_doc ASC
							";
		$resultat = $bdd->query ($query);
		while ($doc = $resultat->fetchObject()) { 
			$montant_CA += $doc->montant_ttc;
		}
		$liste_CA[$i] = $montant_CA;
	}
	
	
	return $liste_CA;
}

//décompte du nombre d'articles en catalogue de ce construteur
function count_constructeur_articles () {
	global $bdd;
	
	$count_articles = 0;
	$query = "SELECT a.ref_article
						FROM  articles a
						WHERE a.ref_constructeur = '".$this->ref_contact."'  && dispo = 1
						GROUP BY a.ref_article
						";
	$resultat = $bdd->query ($query);
	while ($art = $resultat->fetchObject()) { 
		$count_articles  ++;
	}
	
	return $count_articles;
}

//décompte du nombre de categories de ce construteur
function count_constructeur_art_categ () {
	global $bdd;
	
	$count_art_categ = 0;
	$query = "SELECT a.ref_art_categ
						FROM  articles a
						WHERE a.ref_constructeur = '".$this->ref_contact."'  && dispo = 1
						GROUP BY a.ref_art_categ
						";
	$resultat = $bdd->query ($query);
	while ($art_categ = $resultat->fetchObject()) { 
		$count_art_categ  ++;
	}
	
	return $count_art_categ;
}

//Liste des fournisseurs de ce constructeur
function charger_constructeur_fournisseurs_liste () {
	global $bdd;
	
		$liste_fournisseur = array();
		$query = "SELECT d.ref_doc, dl.ref_doc_line, af.ref_fournisseur, an.nom
							FROM  docs_lines dl
								LEFT JOIN documents d ON dl.ref_doc = d.ref_doc
								LEFT JOIN articles a ON a.ref_article = dl.ref_article
								LEFT JOIN annu_fournisseur af ON af.ref_fournisseur = d.ref_contact
								LEFT JOIN annuaire an ON af.ref_fournisseur = an.ref_contact
								LEFT JOIN documents_types dt ON d.id_type_doc = dt.id_type_doc
								LEFT JOIN documents_etats de ON d.id_etat_doc = de.id_etat_doc
							WHERE a.ref_constructeur = '".$this->ref_contact."' && d.id_type_doc IN (5, 6, 7, 8)
							GROUP BY af.ref_fournisseur 
							ORDER BY an.nom DESC
							";
		$resultat = $bdd->query ($query);
		while ($fournisseur = $resultat->fetchObject()) { 
			$liste_fournisseur[] = $fournisseur;
		}
	
	
	return $liste_fournisseur;
}


//retour des derniers d'articles ajoutés au catalogue de ce construteur
function charger_last_constructeur_articles () {
	global $bdd;
	global $ARTICLE_NB_LAST_ADDED_SHOWED;
	
	$articles = array();
	$query = "SELECT a.ref_article, a.ref_oem, a.ref_interne, a.lib_article, a.desc_courte,
									 a.ref_constructeur, ann.nom nom_constructeur, a.dispo,
									 ac.lib_art_categ, t.tva, ia.lib_file, SUM(sa.qte) stock
									 

						FROM articles a
							LEFT JOIN tvas t ON t.id_tva = a.id_tva
							LEFT JOIN annuaire ann ON a.ref_constructeur = ann.ref_contact 
							LEFT JOIN art_categs ac ON a.ref_art_categ = ac.ref_art_categ 
							LEFT JOIN stocks_articles sa ON a.ref_article = sa.ref_article
							LEFT JOIN articles_images ai ON ai.ref_article = a.ref_article && ai.ordre = 1
							LEFT JOIN images_articles ia ON ia.id_image= ai.id_image
						WHERE a.ref_constructeur = '".$this->ref_contact."'  && dispo = 1
						GROUP BY a.ref_article
						ORDER BY a.date_creation DESC
						LIMIT ".$ARTICLE_NB_LAST_ADDED_SHOWED."
						";
	$resultat = $bdd->query ($query);
	while ($art = $resultat->fetchObject()) { 
		$articles[] = $art;
	}
	
	return $articles;
}

// *************************************************************************************************************
// TRANSFERT DES INFORMATIONS DU PROFIL [CONSTRUCTEUR]  
// *************************************************************************************************************
function transfert_infos ($new_contact, $is_already_profiled) {
	global $bdd;

	// Vérifie si le transfert de ces informations est possible.
	if (!$is_already_profiled) {
		// TRANSFERT les informations
		$query = "UPDATE annu_constructeur SET ref_contact = '".$new_contact->getRef_contact()."' 
							WHERE ref_contact = '".$this->ref_contact."'";
		$bdd->exec($query); 
	}

	$query = "UPDATE articles SET ref_constructeur = '".$new_contact->getRef_contact()."'
						WHERE ref_constructeur = '".$this->ref_contact."'";
	$bdd->exec($query); 

	// *************************************************
	// Arret en cas d'erreur
	if (count($GLOBALS['_ALERTES'])) {
		return false;
	}

	return true;
}


// *************************************************************************************************************
// FONCTIONS DE LECTURE DES DONNEES 
// *************************************************************************************************************
function getIdentifiant_revendeur () {
	return $this->identifiant_revendeur;
}

function getConditions_garantie () {
	return $this->conditions_garantie;
}
}

?>