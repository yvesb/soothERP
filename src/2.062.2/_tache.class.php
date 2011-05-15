<?php
// *************************************************************************************************************
// CLASSE REGISSANT LES INFORMATIONS SUR UNE TACHE D'UN COLLABORATEUR 
// *************************************************************************************************************


final class tache {
	private $id_tache;

	private $lib_tache;
	private $text_tache;
	private $importance;
	private $urgence;
	private $etat_tache;			// 0, A effectuer / 1, En cours / 2, Effetuée
	private $date_creation;
	private $date_echeance;
	private $ref_user_createur;					// Utilisateur ayant créé la tache
	private $pseudo_createur;						// Utilisateur ayant créé la tache
	private $note;											// Note de la tache

	private $collabs;										// Contacts directs assignés
	private $collabs_loaded;
	private $collabs_fonctions;						// Groupes de collaborateurs assignés
	private $collabs_fonctions_loaded;

	private $assigned_collabs;					// Contacts collaborateurs assignés à la tache
	private $assigned_collabs_loaded;


function __construct($id_tache = 0) {
	global $bdd;

	// Controle si la id_tache est précisée
	if (!$id_tache) { return false; }

	// Sélection des informations générales
	$query = "SELECT lib_tache, text_tache, importance, urgence, date_creation, date_echeance, ref_user_createur, pseudo, etat_tache, note
						FROM taches t
							LEFT JOIN users u ON t.ref_user_createur = u.ref_user
						WHERE id_tache = '".$id_tache."' ";
	$resultat = $bdd->query ($query);

	// Controle si la id_tache est trouvée
	if (!$tache = $resultat->fetchObject()) { return false; }

	// Attribution des informations à l'objet
	$this->id_tache 	= $id_tache;
	$this->lib_tache	= $tache->lib_tache;
	$this->text_tache	= $tache->text_tache;
	$this->importance	= $tache->importance;
	$this->urgence		= $tache->urgence;
	$this->date_creation	= $tache->date_creation;
	$this->date_echeance 	= $tache->date_echeance;
	$this->ref_user_createur 	= $tache->ref_user_createur;
	$this->pseudo_createur	 	= $tache->pseudo;
	$this->etat_tache	 		= $tache->etat_tache;
	$this->note	 		= $tache->note;

	return true;
}



// *************************************************************************************************************
// FONCTIONS LIEES A LA CREATION D'UNE TACHE 
// *************************************************************************************************************

public function create_tache ($lib_tache, $text_tache, $importance, $urgence, $date_echeance, $collabs, $collabs_fonctions) {
	global $bdd;

	// *************************************************
	// Controle des données transmises
	$this->lib_tache 	= trim($lib_tache);
	if (!$this->lib_tache) {
		$GLOBALS['_ALERTES']['bad_lib_tache'] = 1;
	}
	$this->text_tache = $text_tache;
	$this->importance = $importance;
	if ($importance != 1) { $importance = 0; }
	$this->urgence 		= $urgence;
	if ($urgence != 1) { $urgence = 0; }
	$this->date_echeance 		= $date_echeance;
	$this->collabs		 			= $collabs;
	$this->collabs_fonctions	= $collabs_fonctions;
	if (!is_array($collabs)) { $collabs = array(); }
	if (!is_array($collabs_fonctions)) { $collabs_fonctions = array(); }
	
	// *************************************************
	// Si les valeurs reçues sont incorrectes
	if (count($GLOBALS['_ALERTES'])) {
		return false;
	}

	// *************************************************
	// Insertion dans la base
	$query = "INSERT INTO taches 
							(lib_tache, text_tache, importance, urgence, etat_tache, date_creation, date_echeance, ref_user_createur)
						VALUES ('".addslashes($this->lib_tache)."', '".addslashes($this->text_tache)."', 
										'".$this->importance."', '".$this->urgence."', 0, NOW(), '".$this->date_echeance."', 
										'".$_SESSION['user']->getRef_user()."') ";
	$bdd->query($query);
	$this->id_tache = $bdd->lastInsertId();

	// Insertion des collaborateurs destinataires de cette tache
	foreach ($collabs as $collab) {
		$query = "INSERT INTO taches_collabs (ref_contact, id_tache)
							VALUES ('".$collab."', '".$this->id_tache."')";
		$bdd->exec ($query);
	}
	foreach ($collabs_fonctions as $fonction) {
		$query = "INSERT INTO taches_collabs_fonctions (id_fonction, id_tache)
							VALUES ('".$fonction."', '".$this->id_tache."')";
		$bdd->exec ($query);
	}

	// *************************************************
	// Résultat positif de la création
	$GLOBALS['_INFOS']['Création_tache'] = $this->id_tache;

	return true;
}


// *************************************************************************************************************
// FONCTIONS LIEES A LA MODIFICATION D'UNE TACHE
// *************************************************************************************************************

public function maj_tache ($lib_tache, $text_tache, $importance, $urgence, $date_echeance) {
	global $bdd;
	
	// *************************************************
	// Controle des données transmises
	$this->lib_tache 	= trim($lib_tache);
	if (!$this->lib_tache) {
		$GLOBALS['_ALERTES']['bad_lib_tache'] = 1;
	}
	$this->text_tache = $text_tache;
	$this->importance = $importance;
	if ($importance != 1) { $importance = 0; }
	$this->urgence 		= $urgence;
	if ($urgence != 1) { $urgence = 0; }
	$this->date_echeance 		= $date_echeance;
	
	// *************************************************
	// Si les valeurs reçues sont incorrectes
	if (count($GLOBALS['_ALERTES'])) {
		return false;
	}

	// *************************************************
	// Mise a jour de la base
	$query = "UPDATE taches 
						SET lib_tache = '".addslashes($this->lib_tache)."', text_tache = '".addslashes($this->text_tache)."', 
								importance = '".$this->importance."', urgence = '".$this->urgence."', 
								date_echeance = '".$this->date_echeance."'
						WHERE id_tache = '".$this->id_tache."' ";
	$bdd->exec ($query);

	// *************************************************
	// Résultat positif de la modification
	return true;
}


//maj de la note d'une tache
public function maj_tache_note ($new_note) {
	global $bdd;
	
	// *************************************************
	// Controle des données transmises
	$this->note 		= $new_note;

	// *************************************************
	// Mise a jour de la base
	$query = "UPDATE taches 
						SET note = '".addslashes($this->note)."'
						WHERE id_tache = '".$this->id_tache."' ";
	$bdd->exec ($query);

	// *************************************************
	// Résultat positif de la modification
	return true;
}


public function maj_etat_tache ($new_etat_tache) {
	global $bdd;

	// *************************************************
	// Controle des données transmises
	if ($new_etat_tache != 0 && $new_etat_tache != 1 && $new_etat_tache != 2) {
		return false;
	}
	if ($new_etat_tache == $this->etat_tache) {
		return false;
	}

	// *************************************************
	// Mise a jour de la base
	$query = "UPDATE taches 
						SET etat_tache = '".$new_etat_tache."'
						WHERE id_tache = '".$this->id_tache."' ";
	$bdd->exec ($query);

	// *************************************************
	// Résultat positif de la modification
	return true;
}


// *************************************************************************************************************
// SUPPRESSION D'UNE TACHE
// *************************************************************************************************************
public function delete_tache () {
	global $bdd;

	// *************************************************
	// Controle à effectuer le cas échéant

	// *************************************************
	// Suppression de l'tache
	$query = "DELETE FROM taches 
						WHERE id_tache = '".$this->id_tache."' ";
	$bdd->exec ($query);

	unset ($this);
	return true;
}



// *************************************************************************************************************
// GESTION DES COLLABORATEURS ET fonctionS ASSIGNES A LA TACHE
// *************************************************************************************************************
// Charge la liste des contacts collaborateurs assignés à la tache
protected function charger_assigned_collabs () {
	global $bdd;

	$this->assigned_collabs = array();
	$query = "SELECT ref_contact FROM taches_collabs WHERE id_tache = '".$this->id_tache."' ";
	$resultat = $bdd->query ($query);
	while ($tmp = $resultat->fetchObject()) { $this->assigned_collabs[] = $tmp->ref_contact; }

	$query = "SELECT cgc.ref_contact 
						FROM taches_collabs_fonctions tcf 
							LEFT JOIN annu_collab_fonctions f ON tcf.id_fonction = f.id_fonction
						WHERE tcg.id_tache = '".$this->id_tache."' ";
	$resultat = $bdd->query ($query);
	while ($tmp = $resultat->fetchObject()) {
		if (in_array($tmp->ref_contact, $this->assigned_collabs)) { continue; }
		$this->assigned_collabs[] = $tmp->ref_contact;
	}

	$this->assigned_collabs_loaded = true;

	return true;
}


// Charge les contacts collaborateurs assignés (en dehors des fonctions)
protected function charger_collabs () {
	global $bdd;

	$this->collabs = array();
	$query = "SELECT tc.ref_contact, a.nom
						FROM taches_collabs tc
							LEFT JOIN annuaire a ON a.ref_contact = tc.ref_contact
						WHERE tc.id_tache = '".$this->id_tache."' ";
	$resultat = $bdd->query ($query);
	while ($tmp = $resultat->fetchObject()) { $this->collabs[] = $tmp; }

	$this->collabs_loaded = true;
	return true;
}

// Assigne un collaborateur à la tache
public function add_collab ($ref_contact) {
	global $bdd;

	$query = "INSERT INTO taches_collabs (id_tache, ref_contact)
						VALUES ('".$this->id_tache."', '".$ref_contact."') ";
	$bdd->exec ($query);
	return true;
}

// Désassigne un collaborateur à la tache
public function del_collab ($ref_contact) {
	global $bdd;

	$query = "DELETE FROM taches_collabs 
						WHERE id_tache = '".$this->id_tache."' && ref_contact = '".$ref_contact."' ";
	$bdd->exec ($query);
	return true;
}


// Charge les fonctions de collaborateurs assignés à la tache
protected function charger_collabs_fonctions () {
	global $bdd;

	$this->collabs_fonctions = array();
	$query = "SELECT tcg.id_fonction , cg.lib_fonction
						FROM taches_collabs_fonctions tcg
							LEFT JOIN fonctions cg ON cg.id_fonction = tcg.id_fonction
						WHERE tcg.id_tache = '".$this->id_tache."' ";
	$resultat = $bdd->query ($query);
	while ($tmp = $resultat->fetchObject()) { $this->collabs_fonctions[] = $tmp; }

	$this->collabs_fonctions_loaded = true;
	return true;
}

// Assigne un collaborateur à la tache
public function add_fonction ($id_fonction) {
	global $bdd;

	$query = "INSERT INTO taches_collabs_fonctions (id_tache, id_fonction)
						VALUES ('".$this->id_tache."', '".$id_fonction."') ";
	$bdd->exec ($query);
	return true;
}

// Désassigne un collaborateur à la tache
public function del_fonction ($id_fonction) {
	global $bdd;

	$query = "DELETE FROM taches_collabs_fonctions 
						WHERE id_tache = '".$this->id_tache."' && id_fonction = '".$id_fonction."' ";
	$bdd->exec ($query);
	return true;
}



// *************************************************************************************************************
// FONCTIONS DE LECTURE DES DONNEES 
// *************************************************************************************************************
function getId_tache () {
	return $this->id_tache;
}

function getLib_tache () {
	return $this->lib_tache;
}

function getText_tache () {
 return $this->text_tache;
}

function getImportance () {
	return $this->importance;
}

function getUrgence () {
	return $this->urgence;
}

function getDate_creation () {
	return $this->date_creation;
}

function getDate_echeance () {
	return $this->date_echeance;
}

function getEtat_tache () {
	return $this->etat_tache;
}

function getNote () {
	return $this->note;
}

function getAssigned_collabs () {
	if (!$this->assigned_collabs_loaded) {
		$this->charger_assigned_collabs();
	}
	return $this->assigned_collabs;
}

function getCollabs () {
	if (!$this->collabs_loaded) {
		$this->charger_collabs();
	}
	return $this->collabs;
}

function getCollabs_fonctions () {
	if (!$this->collabs_fonctions_loaded) {
		$this->charger_collabs_fonctions();
	}
	return $this->collabs_fonctions;
}


}

?>