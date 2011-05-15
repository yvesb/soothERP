<?php
// *************************************************************************************************************
// CLASSE REGISSANT LES INFORMATIONS SUR UN CONTACT DE L'ANNUAIRE 
// *************************************************************************************************************


final class contact {
	private $ref_contact;

	private $id_civilite;
	private $lib_civ_court;
	private $lib_civ_long;
	private $nom;
	private $id_categorie;
	private $lib_categorie;
	private $siret;
	private $tva_intra;
	private $note;

	private $date_creation;
	private $date_modification;
	private $date_archivage;

	private $profils;
	private $profils_loaded;

	private $utilisateurs;
	private $utilisateurs_loaded;

	private $adresses;
	private $adresses_loaded;

	private $coordonnees;
	private $coordonnees_loaded;

	private $sites;
	private $sites_loaded;

	private $last_docs;							// Derniers documents concernant ce contact
	private $last_docs_loaded;

	private $evenements;							// Evénements concernant ce contact
	private $evenements_loaded;


function __construct($ref_contact = "") {
	global $bdd;
	
	// Controle si la ref_contact est précisée
	if (!$ref_contact) { return false; }
	
	// Sélection des informations générales
	$query = "SELECT a.id_civilite, lib_civ_court, lib_civ_long, nom, siret, tva_intra, a.id_categorie, note, date_creation, date_modification, date_archivage, 
							ac.lib_categorie
						FROM annuaire a
							LEFT JOIN civilites c ON a.id_civilite = c.id_civilite
							LEFT JOIN annuaire_categories ac ON a.id_categorie = ac.id_categorie
						WHERE ref_contact = '".$ref_contact."' ";
	$resultat = $bdd->query ($query);

	// Controle si la ref_contact est trouvée
	if (!$contact = $resultat->fetchObject()) { return false; }

	// Attribution des informations à l'objet
	$this->ref_contact 				= $ref_contact;
	$this->id_civilite 				= $contact->id_civilite;
	$this->lib_civ_court			= $contact->lib_civ_court;
	$this->lib_civ_long				= $contact->lib_civ_long;
	$this->nom 								= $contact->nom;
	$this->siret							= $contact->siret;
	$this->tva_intra					= $contact->tva_intra;
	$this->id_categorie				= $contact->id_categorie;
	$this->lib_categorie			= $contact->lib_categorie;
	$this->note 							= $contact->note;
	$this->date_creation 			= $contact->date_creation;
	$this->date_modification 	= $contact->date_modification;
	$this->date_archivage 	= $contact->date_archivage;
	unset ($contact);
	
	return true;
}




// *************************************************************************************************************
// FONCTIONS LIEES A LA CREATION D'UN CONTACT
// *************************************************************************************************************

// Fonction permettant la création d'un contact depuis le formulaire
final public function create ($infos_generales, $infos_profils) {
	global $CONFIG_DIR;
	global $bdd;

	$CONTACT_ID_REFERENCE_TAG = 2;


	// *************************************************
	// Controle des données transmises
	$this->id_civilite = $infos_generales['id_civilite'];
	if (!$this->id_civilite) {
		$GLOBALS['_ALERTES']['id_civilite_vide'] = 1;
	}
	$this->nom = $infos_generales['nom'];
	$this->id_categorie = $infos_generales['id_categorie'];
	if (!$this->id_categorie) {
		$GLOBALS['_ALERTES']['bad_categorie'] = 1;
	}
	$this->note 			= $infos_generales['note'];
	$this->siret 			= $infos_generales['siret'];
	$this->tva_intra 	= $infos_generales['tva_intra'];
	
	// Dates de création & modification (en cas d'import)
	$this->date_creation = date ("Y-m-d H:i:s", time());
	$this->date_modification = date ("Y-m-d H:i:s", time());
	if (isset($GLOBALS['options']['date_creation'])) {
		$this->date_creation = $GLOBALS['options']['date_creation'];
		$this->date_creation = $GLOBALS['options']['date_modification'];
	}
	
	// Adresses, sites, et coordonnées
	if (!isset($infos_generales['adresses']) || !is_array($infos_generales['adresses'])) {
		$infos_generales['adresses'] = array();
	}
	if (!isset($infos_generales['coordonnees']) || !is_array($infos_generales['coordonnees'])) {
		$infos_generales['coordonnees'] = array();
	}
	if (!isset($infos_generales['sites']) || !is_array($infos_generales['sites'])) {
		$infos_generales['sites'] = array();
	}

	// *************************************************
	// Réception des données de profil
	$this->profils = array();
	foreach ($infos_profils as $profil) { 
		if (!isset($_SESSION['profils'][$profil['id_profil']])) { 
			$GLOBALS['_ALERTES']['bad_profil'] = $profil['id_profil']; 
			break;
		}
		$this->profils[$profil['id_profil']] = $profil;
	}
	
	// *************************************************
	// Si les valeurs reçues sont incorrectes
	if (count($GLOBALS['_ALERTES'])) {
		return false;
	}
	
	// *************************************************
	// Création de la référence
	if (!isset($infos_generales['ref_contact'])) {
		$reference = new reference ($CONTACT_ID_REFERENCE_TAG);
		$this->ref_contact = $reference->generer_ref();
	} else {
		$this->ref_contact = $infos_generales['ref_contact'];
	}
	
	// *************************************************
	// Insertion dans la base
	$bdd->beginTransaction();

	// Annuaire
	$query = "INSERT INTO annuaire (ref_contact, id_civilite, nom, siret, tva_intra, id_categorie, note, date_creation, date_modification)
						VALUES ('".$this->ref_contact."', '".$this->id_civilite."', '".addslashes($this->nom)."', '".addslashes($this->siret)."', '".addslashes($this->tva_intra)."', '".$this->id_categorie."', '".addslashes($this->note)."', NOW(), NOW())";
	$bdd->exec($query);

	// Adresses
	for ($i=0; $i<count($infos_generales['adresses']); $i++) {
		$this->ajouter_adresse ($infos_generales['adresses'][$i]);
	}

	// Coordonnes
	for ($i=0; $i<count($infos_generales['coordonnees']); $i++) {
		$this->ajouter_coordonnee ($infos_generales['coordonnees'][$i]);
	}

	// Sites
	for ($i=0; $i<count($infos_generales['sites']); $i++) {
		$this->ajouter_site ($infos_generales['sites'][$i]);
	}

	// SI il y a eu des erreurs, on invalide la création
	if (count($GLOBALS['_ALERTES'])) { return false; }
	$bdd->commit();


	// Controle et insertion des données relatives aux profils
	foreach ($this->profils as $id_profil => $infos_profil) { 
		if (!$this->create_profiled_infos ($infos_profil)) {
			$GLOBALS['_ALERTES']['erreur_profil_'.$id_profil] = 1;
		}
	}
	
	// On envoie éventuellement un mail pour inviter le contact à s'inscrire
	for ($i=0; $i<count($infos_generales['coordonnees']); $i++) {
		foreach($this->getCoordonnees() as $coordonnee){
			if($coordonnee->getEmail() == $infos_generales['coordonnees'][$i]['email']){
				if($infos_generales['coordonnees'][$i]['email_user_creation']){
					$coordonnee->envoi_mail_invitation();
				}
			}
		}
	}
	
	// Si il y a eu des erreurs, on invalide la création
	if (count($GLOBALS['_ALERTES'])) {
		$this->suppression();
		return false; 
	}


	// *************************************************
	// Résultat positif de la création
	$GLOBALS['_INFOS']['Création_contact'] = $this->ref_contact;

	return true;
}



// *************************************************************************************************************
// FONCTIONS LIEES A LA MODIFICATION D'UN CONTACT
// *************************************************************************************************************

final public function modification ($infos_generales, $infos_profils = array()) {
	global $bdd;
	
	$ANNUAIRE_CATEGORIES	=	get_categories();

	// *************************************************
	// Controle des données transmises
	if (isset($infos_generales['id_civilite']) ) {
		$this->id_civilite = $infos_generales['id_civilite'];
		if (!$this->id_civilite) {
			$GLOBALS['_ALERTES']['id_civilite_vide'] = 1;
		}
		$this->nom = $infos_generales['nom'];
		if (!$this->nom) {
			$GLOBALS['_ALERTES']['nom_vide'] = 1;
		}
		$this->id_categorie = $infos_generales['id_categorie'];
		if (!$this->id_categorie) {
			$GLOBALS['_ALERTES']['bad_categorie'] = 1;
		}
		$this->siret = $infos_generales['siret'];
	}
	if (isset($infos_generales['note']) ) {
		$this->note = $infos_generales['note'];
	}

	// *************************************************
	// Réception des données de profil
	$profils = array();
	foreach ($infos_profils as $profil) { 
		if (!isset($_SESSION['profils'][$profil['id_profil']])) { 
			$GLOBALS['_ALERTES']['bad_profil'] = $profil['id_profil']; 
			break;
		}
		$profils[$profil['id_profil']] = $profil;
	}
	
	// *************************************************
	// Si les valeurs reçues sont incorrectes
	if (count($GLOBALS['_ALERTES'])) {
		return false;
	}

	// *************************************************
	// Mise à jour dans la base
	$bdd->beginTransaction();

	$query = "UPDATE annuaire 
						SET id_civilite = '".$this->id_civilite."', nom = '".addslashes($this->nom)."', siret = '".addslashes($this->siret)."', 
								id_categorie = '".$this->id_categorie."', note = '".addslashes($this->note)."', date_modification = NOW()
						WHERE ref_contact = '".$this->ref_contact."' ";
	$bdd->exec ($query);

	// Controle et mise à jour des données relatives aux profils
	foreach ($profils as $id_profil => $infos_profil) { 
		if (!$this->maj_profiled_infos ($infos_profil)) {
			$GLOBALS['_ALERTES']['erreur_profil_'.$id_profil] = 1;
			$bdd->rollBack();
			return false;
		}
	}
		
	$bdd->commit();
	
	// *************************************************
	// Résultat positif de la modification
	$GLOBALS['_INFOS']['Modification_contact'] = 1;

	return true;
}


// Mise à jour de Tva_intra
function maj_tva_intra ($tva_intra) {
	global $bdd;
	
	// *************************************************
	// Controle des données transmises
	$this->tva_intra = $tva_intra;
	
	// *************************************************
	// Si les valeurs reçues sont incorrectes
	if (count($GLOBALS['_ALERTES'])) {
		return false;
	}

	// *************************************************
	// Mise à jour dans la base
	$query = "UPDATE annuaire 
						SET tva_intra = '".addslashes($this->tva_intra)."', date_modification = NOW()
						WHERE ref_contact = '".$this->ref_contact."' ";
	$bdd->exec ($query);
	
	// *************************************************
	// Résultat positif de la modification
	$GLOBALS['_INFOS']['Modification_tva_intra'] = 1;

	return true;
}

// Mise à jour de Note
function maj_note ($note) {
	global $bdd;
	
	// *************************************************
	// Controle des données transmises
	$this->note = $note;
	
	// *************************************************
	// Si les valeurs reçues sont incorrectes
	if (count($GLOBALS['_ALERTES'])) {
		return false;
	}

	// *************************************************
	// Mise à jour dans la base
	$query = "UPDATE annuaire 
						SET note = '".addslashes($this->note)."', date_modification = NOW()
						WHERE ref_contact = '".$this->ref_contact."' ";
	$bdd->exec ($query);
	
	// *************************************************
	// Résultat positif de la modification
	$GLOBALS['_INFOS']['Modification_note'] = 1;

	return true;
}





// *************************************************************************************************************
// FONCTIONS LIEES A LA SUPPRESSION D'UN CONTACT
// *************************************************************************************************************
// Une fiche supprimée est en réalitée archivée
final public function archivage () {
	global $bdd;
	global $REF_CONTACT_ENTREPRISE;
	
	//si c'est le contact principal de l'entreprise on bloque le'archivage
	if($this->ref_contact == $REF_CONTACT_ENTREPRISE) {	$GLOBALS['_ALERTES']['contact_entreprise'] = 1; return false;}
	//passage en inactif des utilisateurs
	 $this->blocages_utilisateurs ();
	
	//archivage du contact
	$query = "UPDATE annuaire 
						SET date_archivage = NOW()
						WHERE ref_contact = '".$this->ref_contact."' ";
	$bdd->exec ($query);			
}


// Une fiche supprimée "réellement" ne peut l'etre qu'en cas d'erreur programme 
private function suppression () {
	global $bdd;

	$query = "DELETE FROM annuaire WHERE ref_contact = '".$this->ref_contact."' ";
	$bdd->exec ($query);			
}


// Fusion avec une autre fiche
public function fusion ($new_ref_contact) {
	global $bdd;
	
	// *************************************************
	// Test de la validité du nouveau contact
	$new_contact = new contact ($new_ref_contact);
	if (!$new_contact->getRef_contact()) { 
		$GLOBALS['_ALERTES']['bad_ref_contact'] = 1;
	}

	// Sélection des informations de profil
	$new_contact->charger_all_profiled_infos();
	$this->charger_all_profiled_infos();


	// *************************************************
	// Début de la mise à jour
	$bdd->beginTransaction();

	// *************************************************
	// Modification des information générales
	$new_infos['nom'] = $new_contact->getNom();
	if ($this->nom != $new_infos['nom']) {
		$new_infos['nom'].= "\n ".$this->nom;
	}
	$new_infos['id_categorie']	= $new_contact->getId_Categorie();
	$new_infos['id_civilite']		= $new_contact->getId_civilite();
	$new_infos['note'] = $new_contact->getNote();
	$new_infos['siret'] = $new_contact->getSiret();
	if ($this->note) { $new_infos['note'].= "\n ".$this->note; }
	$new_contact->modification($new_infos);

	// Date de création, pour conserver la plus ancienne
	if (strtotime($new_contact->getDate_creation()) > strtotime($this->date_creation)) {
		$query = "UPDATE annuaire SET date_creation = '".$this->date_creation."'
							WHERE ref_contact = '".$this->ref_contact."' ";
		$bdd->exec ($query);
	}

	// *************************************************
	// Transfert des informations de profil
	foreach ($this->profils as $id_profil => $profil) {
		if (!$new_contact->is_profiled ($id_profil)) {
			$query = "UPDATE annuaire_profils SET ref_contact = '".$new_ref_contact."'
								WHERE ref_contact = '".$this->ref_contact."' && id_profil = '".$id_profil."' ";
			$bdd->exec ($query);
			$this->profils[$id_profil]->transfert_infos ($new_contact, 0);
		}
		else {
			$this->profils[$id_profil]->transfert_infos ($new_contact, 1);
		}
	}

	// *************************************************
	// Transfert des adresses, coordonnées, sites 
	$query = "SELECT COUNT(ref_adresse) nb_adresses FROM adresses
						WHERE ref_contact = '".$new_ref_contact."' ";
	$resultat = $bdd->query ($query);
	$tmp = $resultat->fetchObject();
	$query = "UPDATE adresses 
						SET ref_contact = '".$new_ref_contact."', ordre = ordre + ".$tmp->nb_adresses."
						WHERE ref_contact = '".$this->ref_contact."'";
	$bdd->exec ($query);

	$query = "SELECT COUNT(ref_coord) nb_coords FROM coordonnees
						WHERE ref_contact = '".$new_ref_contact."' ";
	$resultat = $bdd->query ($query);
	$tmp = $resultat->fetchObject();
	$query = "UPDATE coordonnees SET ref_contact = '".$new_ref_contact."', ordre = ordre + ".$tmp->nb_coords."
						WHERE ref_contact = '".$this->ref_contact."'";
	$bdd->exec ($query);

	$query = "SELECT COUNT(ref_site) nb_sites FROM sites_web
						WHERE ref_contact = '".$new_ref_contact."' ";
	$resultat = $bdd->query ($query);
	$tmp = $resultat->fetchObject();
	$query = "UPDATE sites_web SET ref_contact = '".$new_ref_contact."', ordre = ordre + ".$tmp->nb_sites."
						WHERE ref_contact = '".$this->ref_contact."'";
	$bdd->exec ($query);

	// *************************************************
	// Transfert des users
	$query = "UPDATE users 
						SET ref_contact = '".$new_ref_contact."', master = 0
						WHERE ref_contact = '".$this->ref_contact."'";
	$bdd->exec ($query);

	// *************************************************
	// Transfert des documents
	$query = "UPDATE documents 
						SET ref_contact = '".$new_ref_contact."'
						WHERE ref_contact = '".$this->ref_contact."'";
	$bdd->exec ($query);

	// *************************************************
	// Transfert des règlements
	$query = "UPDATE reglements 
						SET ref_contact = '".$new_ref_contact."'
						WHERE ref_contact = '".$this->ref_contact."'";
	$bdd->exec ($query);
	
	// *************************************************
	// Transfert des commerciaux de documents
	$query = "UPDATE doc_ventes_commerciaux 
						SET ref_contact = '".$new_ref_contact."'
						WHERE ref_contact = '".$this->ref_contact."'";
	$bdd->exec ($query);


	// *************************************************
	// Suppression de l'ancienne fiche
	$query = "DELETE FROM annuaire WHERE ref_contact = '".$this->ref_contact."' ";
	$bdd->exec ($query);
	
	// *************************************************
	// Si une erreur est survenue
	if (count($GLOBALS['_ALERTES'])) {
		$bdd->rollBack();
		return false;
	}

	// *************************************************
	$bdd->commit();

	$GLOBALS['_INFOS']['fusion_ok'] = 1;
	return true;		
}





// *************************************************************************************************************
// FONCTIONS LIEES A LA GESTION DES PROFILS
// *************************************************************************************************************

// Chargement des informations spécifiques aux profils
final private function charger_all_profiled_infos () {
	global $bdd;

	$this->profils = array();

	// Sélection des informations spécifiques aux profils
	$query = "SELECT a.id_profil 
						FROM annuaire_profils a
							RIGHT JOIN profils p ON a.id_profil = p.id_profil 
						WHERE ref_contact = '".$this->ref_contact."' && p.actif != 0 ";
	$resultat = $bdd->query ($query);
	while ($var = $resultat->fetchObject()) { 
		$this->charger_profiled_infos ($var->id_profil);
	}
	$this->profils_loaded = true;
}

// Chargement des informations spécifiques a un profil
final public function charger_profiled_infos ($id_profil) {
	// Classe adaptée au profil
	$this->load_profil_class ($id_profil);

	$classe_profil = "contact_".$_SESSION['profils'][$id_profil]->getCode_profil();
	$this->profils[$id_profil] = new $classe_profil ($this->ref_contact);

	if (!$this->profils[$id_profil]->profil_loaded) {
		return false;
	}

	return true;
}


// Créé les informations sur un profil spécifique
final public function create_profiled_infos ($infos_profil) {
	global $bdd;

	$id_profil = &$infos_profil['id_profil'];

	// Classe adaptée au profil
	$this->load_profil_class ($id_profil);

	$classe_profil = "contact_".$_SESSION['profils'][$id_profil]->getCode_profil();
	$this->profils[$id_profil] = new $classe_profil ($this->ref_contact, "create");
	
	$retour = $this->profils[$id_profil]->create_infos ($infos_profil);
	
	if (!$retour) { return false; }

	$query = "INSERT INTO annuaire_profils (ref_contact, id_profil) 
						VALUES ('".$this->ref_contact."', '".$id_profil."')";
	$bdd->exec($query);
	
	//mise à jour des permissions d'utilisateurs afin de leur attribuer le nouveau profil
	utilisateur::set_users_permission ($this->ref_contact, $id_profil);
	
	return $retour;
}


// Mise à jour des informations particulières au profil
final public function maj_profiled_infos ($infos_profil) {
	$id_profil = &$infos_profil['id_profil'];

	// Chargement des informations du profil si besoin
	if (!isset($this->profils[$id_profil]) && !$this->charger_profiled_infos($id_profil)) {
		return false;
	}

	$result = $this->profils[$id_profil]->maj_infos ($infos_profil);
	return $result;
}


// MSupprime les informations particulières au profil
final public function delete_profiled_infos ($infos_profil) {
	global $bdd;

	$id_profil = &$infos_profil['id_profil'];

	// Chargement des informations du profil si besoin
	if (!isset($this->profils[$id_profil]) && !$this->charger_profiled_infos($id_profil)) {
		return false;
	}

	$result = $this->profils[$id_profil]->delete_infos ($infos_profil);
	
	if ($result) {
		$query = "DELETE FROM annuaire_profils WHERE ref_contact = '".$this->ref_contact."' && id_profil = '".$id_profil."'  ";
		$bdd->exec ($query);
	}
	//suppression des user_permissions pour les utilisateurs de ce contact pour le profil supprimé
	utilisateur::unset_users_permission ($this->ref_contact, $id_profil);

	return $result;
}


// Vérifie si le contact à tel profil
public function is_profiled ($id_profil) {
	global $bdd;

	// Déjà loadé
	if (isset($this->profils[$id_profil])) {
		return true;
	}

	// Vérification en BDD
	$query = "SELECT ref_contact FROM annuaire_profils 
						WHERE ref_contact = '".$this->ref_contact."' && id_profil = '".$id_profil."' ";
	$resultat = $bdd->query ($query);
	// Controle si le profil est trouvé
	if ($info = $resultat->fetchObject()) { return true; }

	// N'est pas de ce profil
	return false;
}


// Charge le fichier de gestion de la classe de profil
static public function load_profil_class ($id_profil) {
	global $DIR;

	global $CONFIG_DIR;
	include_once ($CONFIG_DIR."profil_".$_SESSION['profils'][$id_profil]->getCode_profil().".config.php");
	
	$file_dir  = $DIR.$_SESSION['profils'][$id_profil]->getDir_profil();
	$file_name = "_contact_".$_SESSION['profils'][$id_profil]->getCode_profil().".class.php";
	include_once ($file_dir.$file_name);
	
	return true;
}



// *************************************************************************************************************
// FONCTIONS LIEES A LA GESTION DES UTILISATEURS
// *************************************************************************************************************
// Chargement des utilisateurs
final private function charger_utilisateurs() {
	global $bdd;

	$this->utilisateurs = array();

	$query = "SELECT ref_user 
						FROM users 
						WHERE ref_contact = '".$this->ref_contact."' && actif >= 0
						ORDER BY ordre";
	$resultat = $bdd->query($query);
	while ($var = $resultat->fetchObject()) { 
		$this->utilisateurs[] = new utilisateur ($var->ref_user); 
	}

	$this->utilisateurs_loaded = 1;
}

// Ajout d'un utilisateur
final public function ajouter_utilisateur ($ref_coord_user, $pseudo, $code, $id_langage) {
	$utilisateur = new utilisateur ();
	$utilisateur->create($this->ref_contact, $ref_coord_user, $pseudo, $code, $id_langage);
	
	if ($this->utilisateurs_loaded) {
		$this->utilisateurs[] = $utilisateur;
	}
}

// Suppression d'un utilisateur
final public function suppression_utilisateur ($ref_user) {
	$utilisateur = new utilisateur ($ref_user);
	$utilisateur->suppression();
	
	$this->utilisateurs_loaded = 0;
}

// Déplacement d'un utilisateur
final public function deplacer_utilisateur ($ref_user, $new_ordre) {
	$utilisateur = new utilisateur ($ref_user);
	$utilisateur->modifier_ordre($new_ordre);
	
	$this->utilisateurs_loaded = 0;
}


// Blocage de tous les comptes utilisateurs
final public function blocages_utilisateurs () {
	global $bdd;
	
	$query = "UPDATE users SET actif = 0 WHERE ref_contact = '".$this->ref_contact."' && actif > 0";
	$bdd->exec ($query);
	
	return true;
}


// *************************************************************************************************************
// FONCTIONS LIEES A LA GESTION DES ADRESSES
// *************************************************************************************************************
// Chargement des adresses
final private function charger_adresses() {
	global $bdd;

	$this->adresses = array();
	$query = "SELECT ref_adresse 
						FROM adresses 
						WHERE ref_contact = '".$this->ref_contact."'
						ORDER BY ordre ";
	$resultat = $bdd->query($query);
	while ($var = $resultat->fetchObject()) { 
		$this->adresses[] = new adresse ($var->ref_adresse); 
	}
	$this->adresses_loaded = 1;
}

// Ajout d'une adresse
final public function ajouter_adresse ($infos_adresse) {
	// *************************************************
	// Controle des données transmises
	$lib_adresse 	= $infos_adresse['lib_adresse'];
	$text_adresse = $infos_adresse['text_adresse'];
	$code_postal	= $infos_adresse['code_postal'];
	$ville		= $infos_adresse['ville'];
	$id_pays	= $infos_adresse['id_pays'];
	$note			= $infos_adresse['note'];
	if(!empty($infos_adresse['type_adresse']))
            $type	= $infos_adresse['type_adresse'];
        else
            $type	= null;

	$ref_adresse = "";
	if (isset($infos_adresse['ref_adresse'])) {$ref_adresse = $infos_adresse['ref_adresse'];}
	
	// *************************************************
	// Création de l'adresse
	$adresse = new adresse ();
	return $adresse->create($this->ref_contact, $lib_adresse, $text_adresse,  $code_postal, $ville, $id_pays, $note, $type, $ref_adresse);
}

// Suppression d'une adresse
final public function suppression_adresse ($ref_adresse) {
	$adresse = new adresse ($ref_adresse);
	$adresse->suppression();
	
	$this->adresses_loaded = 0;
}

// Déplacement d'une adresse
final public function deplacer_adresse ($ref_adresse, $new_ordre) {
	$adresse = new adresse ($ref_adresse);
	$adresse->modifier_ordre($new_ordre);
	
	$this->adresses_loaded = 0;
}



// *************************************************************************************************************
// FONCTIONS LIEES A LA GESTION DES COORDONNEES
// *************************************************************************************************************
// Chargement des adresses
final private function charger_coordonnees() {
	global $bdd;

	$this->coordonnees = array();
	$query = "SELECT ref_coord 
						FROM coordonnees 
						WHERE ref_contact = '".$this->ref_contact."'
						ORDER BY ordre";
	$resultat = $bdd->query($query);
	while ($var = $resultat->fetchObject()) { 
		$this->coordonnees[] = new coordonnee ($var->ref_coord); 
	}
	$this->coordonnees_loaded = 1;
}

// Ajout d'une coordonnee
final public function ajouter_coordonnee ($infos_coordonnee) {
	// *************************************************
	// Controle des données transmises
	$lib_coord 	= $infos_coordonnee['lib_coord'];
	$tel1 = $infos_coordonnee['tel1'];
	$tel2 = $infos_coordonnee['tel2'];
	$fax 	= $infos_coordonnee['fax'];
	$email	= $infos_coordonnee['email'];
	$note		= $infos_coordonnee['note'];
	$ref_coord_parent			= $infos_coordonnee['ref_coord_parent'];
	$email_user_creation	= $infos_coordonnee['email_user_creation'];
        if(isset($infos_coordonnee['type_coord']))
            $type	= $infos_coordonnee['type_coord'];
        else
            $type	= null;

	$ref_coord = "";
	if (isset($infos_coordonnee['ref_coord'])) {$ref_coord = $infos_coordonnee['ref_coord'];}

	$coordonnee = new coordonnee ();
	return $coordonnee->create($this->ref_contact, $lib_coord, $tel1, $tel2, $fax,  $email, $note, $ref_coord_parent, $email_user_creation, $type, $ref_coord);
}

// Suppression d'une coordonnee
final public function suppression_coordonnee ($ref_coordonnee) {
	$coordonnee = new coordonnee ($ref_coordonnee);
	$coordonnee->suppression();
	
	$this->coordonnees_loaded = 0;
}

// Déplacement d'une coordonnee
final public function deplacer_coordonnee ($ref_coordonnee, $new_ordre) {
	$coordonnee = new coordonnee ($ref_coordonnee);
	$coordonnee->modifier_ordre($new_ordre);
	
	$this->coordonnees_loaded = 0;
}

// Liaison de 2 coordonnees
final public function lier_coordonnee ($ref_coordonnee, $ref_coord_parent) {
	$coordonnee = new coordonnee ($ref_coordonnee);
	$coordonnee->lier_ordre($ref_coord_parent);
	
	$this->coordonnees_loaded = 0;
}



// *************************************************************************************************************
// FONCTIONS LIEES A LA GESTION DES SITES
// *************************************************************************************************************
// Chargement des adresses
final private function charger_sites() {
	global $bdd;

	$this->sites = array();
	$query = "SELECT ref_site 
						FROM sites_web 
						WHERE ref_contact = '".$this->ref_contact."'
						ORDER BY ordre";
	$resultat = $bdd->query($query);
	while ($var = $resultat->fetchObject()) { 
		$this->sites[] = new site ($var->ref_site); 
	}
	$this->site_loaded = 1;
}

// Ajout d'un site
final public function ajouter_site ($infos_site) {
	// *************************************************
	// Controle des données transmises
	$lib_site_web = $infos_site['lib_site_web'];
	$url 		= $infos_site['url'];
	$login 	= $infos_site['login'];
	$pass 	= $infos_site['pass'];
	$note 	= $infos_site['note'];
        if(isset($infos_site['type_site']))
            $type	= $infos_site['type_site'];
        else
            $type       = null;

	$ref_site = "";
	if (isset($infos_site['ref_site'])) {$ref_site = $infos_site['ref_site'];}
	
	$site = new site ();
	return $site->create($this->ref_contact, $lib_site_web, $url, $login, $pass, $note, $type, $ref_site);
}

// Suppression d'un site
final public function suppression_site ($ref_site) {
	$site = new site ($ref_site);
	$site->suppression();
	
	$this->sites_loaded = 0;
}

// Déplacement d'un site
final public function deplacer_site ($ref_site, $new_ordre) {
	$site = new site ($ref_site);
	$site->modifier_ordre($new_ordre);
	
	$this->sites_loaded = 0;
}

// *************************************************************************************************************
// FONCTIONS DE GESTION DES EVENEMENTS
// *************************************************************************************************************

// Chargement des événements concernant ce contact
function charger_evenements () {
	global $bdd;

	$this->evenements = array();
	$query = "SELECT ce.id_comm_event, ce.date_event, ce.duree_event, ce.ref_user, ce.ref_contact, ce.id_comm_event_type, ce.texte, ce.date_rappel,
									 u.pseudo,
									 cet.lib_comm_event_type
						FROM comm_events ce 
							LEFT JOIN users u ON ce.ref_user = u.ref_user
							LEFT JOIN comm_events_types cet ON ce.id_comm_event_type = cet.id_comm_event_type
						WHERE ce.ref_contact = '".$this->ref_contact."' 
						ORDER BY ce.date_event DESC, ce.date_rappel DESC
						";
	$resultat = $bdd->query ($query);
	while ($evenement = $resultat->fetchObject()) { 
		$this->evenements[] = $evenement;
	}
	$this->evenements_loaded = true;
	return true;
}
// Chargement d'un événement concernant ce contact
function charger_evenement ($id_comm_event) {
	global $bdd;

	$evenement = "";
	$query = "SELECT ce.id_comm_event, ce.date_event, ce.duree_event, ce.ref_user, ce.ref_contact, ce.id_comm_event_type, ce.texte, ce.date_rappel,
									 u.pseudo,
									 cet.lib_comm_event_type
						FROM comm_events ce 
							LEFT JOIN users u ON ce.ref_user = u.ref_user
							LEFT JOIN comm_events_types cet ON ce.id_comm_event_type = cet.id_comm_event_type
						WHERE ce.ref_contact = '".$this->ref_contact."' && id_comm_event = '".$id_comm_event."' 
						";
	$resultat = $bdd->query ($query);
	if ($evt = $resultat->fetchObject()) { 
		$evenement = $evt;
	}
	return $evenement;
}

//ajout d'un événement pour ce contact
function add_evenement ($date_event, $duree_event, $ref_user, $id_comm_event_type, $texte, $date_rappel){
	global $bdd;

	$id_comm_event_type = convert_numeric($id_comm_event_type);
	if (!is_numeric($id_comm_event_type)) {
		$GLOBALS['_ALERTES']['bad_id_comm_event_type'] = 1;
	}
	
	if (!checkdate ((int)substr($date_event, 5, 2)   ,(int)substr($date_event, 8, 2)  ,(int)substr($date_event, 0, 4) ) &&$date_event ) {
		$GLOBALS['_ALERTES']['bad_date_event'] = 1;
	} 
	// *************************************************
	// Si les valeurs reçues sont incorrectes
	if (count($GLOBALS['_ALERTES'])) {
		return false;
	}
	
	//insertion dans la base de données
	$query = "INSERT INTO comm_events 
							(date_event, duree_event, ref_user, ref_contact, id_comm_event_type, texte, date_rappel)
						VALUES ( '".$date_event."', '".$duree_event."', '".$ref_user."', '".$this->ref_contact."' , 
										'".$id_comm_event_type."', '".addslashes($texte)."', '".$date_rappel."'
						)";
	$bdd->exec ($query);
	

	return true;
}

//modification d'un événement pour ce contact
function mod_evenement ($id_comm_event, $date_event, $duree_event, $ref_user, $id_comm_event_type, $texte, $date_rappel){
	global $bdd;

	$id_comm_event_type = convert_numeric($id_comm_event_type);
	if (!is_numeric($id_comm_event_type)) {
		$GLOBALS['_ALERTES']['bad_id_comm_event_type'] = 1;
	}
	
	if (!checkdate ((int)substr($date_event, 5, 2)   ,(int)substr($date_event, 8, 2)  ,(int)substr($date_event, 0, 4) ) &&$date_event ) {
		$GLOBALS['_ALERTES']['bad_date_event'] = 1;
	} 
	// *************************************************
	// Si les valeurs reçues sont incorrectes
	if (count($GLOBALS['_ALERTES'])) {
		return false;
	}
	
	//insertion dans la base de données
	$query = "UPDATE comm_events 
						SET  date_event = '".$date_event."', duree_event = '".$duree_event."', ref_user = '".$ref_user."', ref_contact = '".$this->ref_contact."' , 
									id_comm_event_type = '".$id_comm_event_type."', texte = '".addslashes($texte)."', date_rappel = '".$date_rappel."'
						WHERE id_comm_event = '".$id_comm_event."'";
	$bdd->exec ($query);
	

	return true;
}

//fin de rappel d'un événement pour ce contact
function fin_rappel_evenement ($id_comm_event){
	global $bdd;

	// *************************************************
	// Si les valeurs reçues sont incorrectes
	if (count($GLOBALS['_ALERTES'])) {
		return false;
	}
	
	//insertion dans la base de données
	$query = "UPDATE comm_events 
						SET   date_rappel = ''
						WHERE id_comm_event = '".$id_comm_event."'";
	$bdd->exec ($query);
	

	return true;
}
//supression d'un événement pour ce contact
function sup_evenement ($id_comm_event){
	global $bdd;

	// *************************************************
	// Si les valeurs reçues sont incorrectes
	if (count($GLOBALS['_ALERTES'])) {
		return false;
	}
	
	//insertion dans la base de données
	$query = "DELETE FROM comm_events WHERE id_comm_event = '".$id_comm_event."'";
	$bdd->exec ($query);
	

	return true;
}

// *************************************************************************************************************
// FONCTIONS DIVERSES 
// *************************************************************************************************************

// Chargement des derniers documents concernant ce contact
function charger_last_docs () {
	global $bdd;
	global $CONTACT_NB_LAST_DOCS_SHOWED;

	$this->last_docs = array();
	$query = "SELECT d.ref_doc, d.date_creation_doc date_creation, dt.lib_type_doc, de.lib_etat_doc, 
									 SUM(ROUND(dl.qte * dl.pu_ht * (1-dl.remise/100) * (1+dl.tva/100),2)) as montant_ttc
						FROM documents d 
							LEFT JOIN docs_lines dl ON dl.ref_doc = d.ref_doc && dl.visible = 1
							LEFT JOIN documents_types dt ON d.id_type_doc = dt.id_type_doc
							LEFT JOIN documents_etats de ON d.id_etat_doc = de.id_etat_doc
						WHERE d.ref_contact = '".$this->ref_contact."' && dl.ref_doc_line_parent IS NULL  && d.id_etat_doc NOT IN (2,7,12,17,21,26,30,33,37,43,45,48,53)
						GROUP BY d.ref_doc 
						ORDER BY date_creation DESC, d.id_type_doc ASC
						LIMIT 0,".$CONTACT_NB_LAST_DOCS_SHOWED;
	$resultat = $bdd->query ($query);
	while ($doc = $resultat->fetchObject()) { 
		$this->last_docs[] = $doc;
	}
	$this->last_docs_loaded = true;
	return true;
}


// *************************************************************************************************************
// FONCTIONS DE GESTION DES TYPES D'EVENEMENTS
// *************************************************************************************************************
// Chargement des types d'événements
static function charger_types_evenements () {
	global $bdd;

	$types_evenements = array();
	$query = "SELECT id_comm_event_type, lib_comm_event_type, systeme
						FROM comm_events_types 
						ORDER BY systeme ASC, lib_comm_event_type ASC
						";
	$resultat = $bdd->query ($query);
	while ($type_event = $resultat->fetchObject()) { 
		$types_evenements[] = $type_event;
	}
	return $types_evenements;
}

// Chargement des types d'événements par ordre alphabétique
static function charger_types_evenements_liste () {
	global $bdd;

	$types_evenements = array();
	$query = "SELECT id_comm_event_type, lib_comm_event_type, systeme
						FROM comm_events_types 
						ORDER BY lib_comm_event_type ASC
						";
	$resultat = $bdd->query ($query);
	while ($type_event = $resultat->fetchObject()) { 
		$types_evenements[] = $type_event;
	}
	return $types_evenements;
}

// ajout d'un type d'événement
static function add_types_evenements ($lib_comm_event_type, $systeme = 0) {
	global $bdd;

	// *************************************************
	// Controle des données transmises
	if (!$lib_comm_event_type) {$GLOBALS['_ALERTES']["lib_comm_event_type_vide"] = 1;}
	
	// *************************************************
	// Si les valeurs reçues sont incorrectes
	if (count($GLOBALS['_ALERTES'])) {
		return false;
	}
	
	$query = "INSERT INTO comm_events_types (lib_comm_event_type, systeme)
						VALUES ('".addslashes($lib_comm_event_type)."', '".$systeme."')
						";
	$bdd->exec ($query);
	return true;
}

// modification d'un type d'événement
static function mod_types_evenements ($id_comm_event_type, $lib_comm_event_type) {
	global $bdd;

	// *************************************************
	// Controle des données transmises
	if (!$id_comm_event_type) {$GLOBALS['_ALERTES']["bad_id_comm_event_type"] = 1;}
	if (!$lib_comm_event_type) {$GLOBALS['_ALERTES']["lib_comm_event_type_vide"] = 1;}
	
	// *************************************************
	// Si les valeurs reçues sont incorrectes
	if (count($GLOBALS['_ALERTES'])) {
		return false;
	}
	
	$query = "UPDATE comm_events_types SET lib_comm_event_type= '".addslashes($lib_comm_event_type)."'
						WHERE id_comm_event_type = '".$id_comm_event_type."'
						";
	$bdd->exec ($query);
	return true;
}

// suppression d'un type d'événement
static function sup_types_evenements ($id_comm_event_type) {
	global $bdd;

	
	$query = "SELECT id_comm_event
						FROM comm_events
						WHERE id_comm_event_type = '".$id_comm_event_type."'
						";
	$resultat = $bdd->query ($query);
	if ($exist_event = $resultat->fetchObject()) {$GLOBALS['_ALERTES']["exist_id_comm_event"] = 1; }
	
	// *************************************************
	// Si les valeurs reçues sont incorrectes
	if (count($GLOBALS['_ALERTES'])) {
		return false;
	}
	
	$query = "DELETE FROM comm_events_types WHERE id_comm_event_type = '".$id_comm_event_type."' ";
	$bdd->exec ($query);
	
	return true;
}


// *************************************************************************************************************
// FONCTIONS DE LECTURE DES DONNEES 
// *************************************************************************************************************
function getRef_contact () {
	return $this->ref_contact;
}

function getId_civilite () {
	return $this->id_civilite;
}

function getLib_civ_court () {
	return $this->lib_civ_court;
}

function getLib_civ_long () {
	return $this->lib_civ_long;
}

function getNom () {
	return $this->nom;
}

public static function _getNom ($ref_contact) {
	global $bdd;
	$query = "SELECT nom 
				FROM annuaire WHERE ref_contact=".ref_or_null($ref_contact);
	$result = $bdd->query($query );
	if ($resultat = $result->fetchObject()){
		return $resultat->nom;
	}
	return false;
}

function getSiret () {
	return $this->siret;
}

function getTva_intra () {
	return $this->tva_intra;
}

function getId_Categorie () {
	return $this->id_categorie;
}

function getLib_Categorie () {
	return $this->lib_categorie;
}

function getNote () {
	return $this->note;
}


// Retourne les profils du contact
function getProfils () {
	// Chargement des infos
	if (!$this->profils_loaded) {
		$this->charger_all_profiled_infos();
	}
	return $this->profils;
}


// Retourne les profils du contact
function getProfil ($id_profil) {
	if (isset($this->profils[$id_profil]) && $this->profils[$id_profil]->profil_loaded) {
		return $this->profils[$id_profil];
	}
	
	$this->charger_profiled_infos($id_profil);
	return $this->profils[$id_profil];
}


// Retourne les adresses du contact 
function getAdresses () {
	// Vérifier si les adresses sont chargées
	if (!$this->adresses_loaded) {
		$this->charger_adresses();
	}
	return $this->adresses;
}

// Retourne les coordonnees du contact 
function getCoordonnees () {
	// Vérifier si les adresses sont chargées
	if (!$this->coordonnees_loaded) {
		$this->charger_coordonnees();
	}
	return $this->coordonnees;
}

// Retourne les coordonnees du contact 
function getSites () {
	// Vérifier si les adresses sont chargées
	if (!$this->sites_loaded) {
		$this->charger_sites();
	}
	return $this->sites;
}

// Retourne les utilisateurs du contact 
function getUtilisateurs () {
	// Vérifier si les adresses sont chargées
	if (!$this->utilisateurs_loaded) {
		$this->charger_utilisateurs();
	}
	return $this->utilisateurs;
}



function getDate_creation () {
	$date = strtotime ($this->date_creation);
	$date = date ("d-m-Y H:i:s", $date);
	return $date;
}

function getDate_modification () {
	$date = strtotime ($this->date_modification);
	$date = date ("d-m-Y H:i:s", $date);
	return $date;
}
function getDate_archivage () {
	return $this->date_archivage;
}


function getLast_docs () {
	if (!$this->last_docs_loaded) { $this->charger_last_docs (); }
	return $this->last_docs;
}

function getEvenements () {
	if (!$this->evenements_loaded) { $this->charger_evenements (); }
	return $this->evenements;
}

function get_code_pdf_modele() {
	global $bdd;
	$query = "SELECT code_pdf_modele FROM pdf_modeles WHERE id_pdf_modele IN
		( SELECT id_pdf_modele FROM annuaire_modeles_pdf WHERE `usage` = 'defaut' AND id_profil IN
		( SELECT id_profil FROM annuaire_profils WHERE ref_contact='".$this->ref_contact."'));";
	$res = $bdd->query($query);
	//return ($res->fetchObject()) ? $res->fetchObject()->code_pdf_modele : '';
	if ($r = $res->fetchObject()) {
		$tmp = $r->code_pdf_modele;
	} else {
		$query = "SELECT code_pdf_modele FROM pdf_modeles WHERE id_pdf_type = '4';";
		$res = $bdd->query($query);
		$tmp = ($r = $res->fetchObject()) ? $r->code_pdf_modele : false;
	}
	return $tmp;
}

public function create_pdf($print = 0){
	$GLOBALS['PDF_OPTIONS']['HideToolbar'] = 0;
	$GLOBALS['PDF_OPTIONS']['AutoPrint'] = $print;
	
	$pdf = new PDF_etendu();
	$pdf->add_contact("", $this);
	return $pdf;
}

public function view_pdf($print = 0){
	$pdf = $this->create_pdf($print);
	$pdf->Output();
}

public function print_pdf(){
	$this->view_pdf(1);
}

// ************************************************************************************************
// LIAISON ENTRE CONTACTS
// ************************************************************************************************

public function suppression_liaison_conctact($ref_contact, $id_liaison_type = -1){
	if($ref_contact == "" || $id_liaison_type < 0)
	{		return false;}
	
	global $bdd;
	$query = "DELETE FROM annuaire_liaisons 
						WHERE ((ref_contact = '".$this->ref_contact."' 	&& ref_contact_lie = '".$ref_contact."') ||
									( ref_contact = '".$ref_contact."' 				&& ref_contact_lie = '".$this->ref_contact."'))
									&& id_liaison_type = ".$id_liaison_type."";
	$bdd->exec ($query);
	
	return true;
}

public function ajouter_liaison_conctact($ref_contact_lie, $id_liaison_type = -1){
	if($ref_contact_lie == "" || $id_liaison_type < 0)
	{		return false;}

	global $bdd;
	$query = "INSERT INTO annuaire_liaisons (ref_contact, ref_contact_lie, id_liaison_type)
						VALUES ('".$this->ref_contact."', '".$ref_contact_lie."', ".$id_liaison_type.")";
	$bdd->exec ($query);
	return true;
}

public function getLiaison($actif = 1, $systeme = 0){
	Contact_liaison_type::getContact_liaisons_all_type($this->ref_contact, $actif, $systeme);
	return true;
}

	// ************************************************************************************************
}	// FIN CLASSE contact
	// ************************************************************************************************


//modele pdf par défaut
function defaut_contact_modele_pdf ($id_profil, $id_pdf_modele) {
	global $bdd;
	
	$query = "UPDATE annuaire_modeles_pdf
						SET  `usage` = 'actif'
						WHERE id_profil = '".$id_profil."' && `usage` != 'inactif' 
						";
	$bdd->exec ($query);
	
	$query = "UPDATE annuaire_modeles_pdf
						SET  `usage` = 'defaut'
						WHERE id_profil = '".$id_profil."' && id_pdf_modele = '".$id_pdf_modele."' 
						";
	$bdd->exec ($query);
	return true;
}

//activation d'un modele pdf
function active_contact_modele_pdf ($id_profil, $id_pdf_modele) {
	global $bdd;
	
/*	$query = "UPDATE annuaire_modeles_pdf
						SET  `usage` = 'actif'
						WHERE id_profil = '".$id_profil."' && id_pdf_modele = '".$id_pdf_modele."' 
						";
	$bdd->exec ($query);
	return true;
*/


	$query = "SELECT COUNT(`usage`) as nb FROM annuaire_modeles_pdf
		WHERE id_profil='".$id_profil."' AND id_pdf_modele='".$id_pdf_modele."';";
	$res = $bdd->query($query);
	if ($res->fetchobject()->nb > 0) {
	  $query = "UPDATE annuaire_modeles_pdf
						SET  `usage` = 'actif'
						WHERE id_profil = '".$id_profil."' && id_pdf_modele = '".$id_pdf_modele."' 
						";	  
	} else {
	  $query = "INSERT INTO annuaire_modeles_pdf
	  	(id_pdf_modele, id_profil, `usage`) VALUES ('".$id_pdf_modele."', '".$id_profil."', 'actif');";
	}
	$bdd->exec ($query);
	
	$query = "SELECT COUNT(`usage`) as nb FROM annuaire_modeles_pdf
		WHERE id_profil='".$id_profil."' AND `usage` IN ('actif', 'defaut');";
	$res = $bdd->query($query);

	if ($tmp=$res->fetchobject()->nb == 1) {
	  defaut_contact_modele_pdf ($id_profil, $id_pdf_modele);
	}
	return true;

}

//désactivation d'un modele pdf
function desactive_contact_modele_pdf ($id_profil, $id_pdf_modele) {
	global $bdd;
	
	$query = "UPDATE annuaire_modeles_pdf
						SET  `usage` = 'inactif'
						WHERE id_profil = '".$id_profil."' && id_pdf_modele = '".$id_pdf_modele."' 
						";
	$bdd->exec ($query);
	return true;
}

function getListeOnByProfil($profil, &$def) {
  global $bdd;
  
  $query = "SELECT id_pdf_modele FROM annuaire_modeles_pdf
  	WHERE `usage` IN ('defaut','actif') AND id_profil='".$profil."';";
  $res = $bdd->query($query);
  $out = array();
  while ($tmp = $res->fetchObject()) { $out[] = $tmp->id_pdf_modele; }
  
  $query = "SELECT id_pdf_modele FROM annuaire_modeles_pdf
  	WHERE `usage`='defaut' AND id_profil='".$profil."';";
  $res = $bdd->query($query);
  if ($tmp = $res->fetchObject()) { $def = $tmp->id_pdf_modele; }
  
  return $out; 
}

function charge_modele_pdf_annuaire () {
	global $bdd;
	$modeles_liste	= array();
	$query = "SELECT id_pdf_modele, id_pdf_type, lib_modele, desc_modele , code_pdf_modele
							FROM pdf_modeles  
							WHERE id_pdf_type = '4'
							";
	$resultat = $bdd->query ($query);
	while ($modele_pdf = $resultat->fetchObject()) { $modeles_liste[] = $modele_pdf;}
	return $modeles_liste;
}

function getListePdfContact(){
	global $bdd;
	
	$liste = array();
	$query = "SELECT p.id_profil, p.lib_profil, amp.id_pdf_modele, amp.usage, pm.lib_modele, pm.desc_modele
		FROM profils p
		LEFT JOIN annuaire_modeles_pdf amp ON p.id_profil = amp.id_profil
		LEFT JOIN pdf_modeles pm ON amp.id_pdf_modele = pm.id_pdf_modele
		WHERE pm.id_pdf_type = '4'
		ORDER BY p.lib_profil ASC, amp.usage ASC;";
	$res = $bdd->query($query);
	while ($r = $res->fetchObject()) { $liste[] = $r;}
	return $liste;
}
?>
