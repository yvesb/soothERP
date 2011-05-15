<?php
// *************************************************************************************************************
// CLASSE REGISSANT LES INFORMATIONS SUR UN COMPTE BANCAIRE 
// *************************************************************************************************************


final class compte_cb {
	protected $id_compte_cb;

	protected $id_compte_bancaire;
	protected $lib_compte_bancaire;

	protected $ref_porteur;
	protected $nom_porteur;

	protected $id_cb_type;
	protected $lib_cb_type;

	protected $numero_carte;
	protected $date_expiration;
	protected $controle;

	protected $differe;

	protected $actif;
	protected $ordre;



public function __construct ($id_compte_cb = "") {
	global $bdd;
	
	if (!$id_compte_cb) { return false; }
	
	$query = "SELECT cb.id_compte_bancaire, cb.ref_porteur, cb.id_cb_type, cb.numero_carte, cb.date_expiration, cb.controle, 
									 cb.differe, cb.actif, cb.ordre, 
									 c.lib_compte lib_compte_bancaire, a.nom nom_porteur, cbt.lib_cb_type
						FROM comptes_cbs cb
							LEFT JOIN comptes_bancaires c ON c.id_compte_bancaire = cb.id_compte_bancaire
							LEFT JOIN cartes_bancaires_types cbt ON cb.id_cb_type = cbt.id_cb_type
							LEFT JOIN annuaire a ON cb.ref_porteur = a.ref_contact
						WHERE cb.id_compte_cb = '".$id_compte_cb."' ";
	$resultat = $bdd->query ($query);
	if (!$compte = $resultat->fetchObject()) { return false; }

	$this->id_compte_cb					= $id_compte_cb;
	$this->id_compte_bancaire		= $compte->id_compte_bancaire;
	$this->lib_compte_bancaire	= $compte->lib_compte_bancaire;
	$this->ref_porteur	= $compte->ref_porteur;
	$this->nom_porteur	= $compte->nom_porteur;
	$this->id_cb_type		= $compte->id_cb_type;
	$this->lib_cb_type	= $compte->lib_cb_type;
	$this->numero_carte	= $compte->numero_carte;
	$this->date_expiration = $compte->date_expiration;
	$this->controle	= $compte->controle;
	$this->differe	= $compte->differe;
	$this->actif	= $compte->actif;
	$this->ordre	= $compte->ordre;
	
	return true;
}





// *************************************************************************************************************
// FONCTIONS LIEES A LA CREATION D'UN COMPTE BANCAIRE
// *************************************************************************************************************

public function create_compte_cb ($infos) { 
	global $bdd;
	
	// *************************************************
	// Réception des données
	$this->ref_porteur = $infos['ref_porteur'];

	$this->id_compte_bancaire = $infos['id_compte_bancaire'];
	if (!is_numeric($this->id_compte_bancaire)) { 
		$GLOBALS['_ALERTES']['bad_id_compte_bancaire'] = 1; 
		return false;
	}
	$query = "SELECT lib_compte lib_compte_bancaire 
						FROM comptes_bancaires 
						WHERE id_compte_bancaire = '".$this->id_compte_bancaire."' && actif = 1";
	$resultat = $bdd->query($query);
	if (!$tmp = $resultat->fetchObject()) {
		$GLOBALS['_ALERTES']['bad_id_compte_bancaire'] = 1; 
	}

	$this->differe 	= $infos['differe'];
	if (!is_numeric($this->differe) || $this->differe < 0 || $this->differe > 31) {
		$GLOBALS['_ALERTES']['bad_differe'] = 1; 
	}

	$this->id_cb_type	= $infos['id_cb_type'];
	if (!is_numeric($this->id_cb_type)) { 
		$GLOBALS['_ALERTES']['bad_id_cb_type'] = 1; 
	}
	$this->numero_carte 		= $infos['numero_carte'];
	$this->date_expiration 	= $infos['date_expiration'];
	$this->controle = $infos['controle'];
	$this->actif 	= 1;

	// Ordre d'affichage
	$query = "SELECT MAX(ordre) ordre FROM comptes_cbs WHERE 1 ";
	$resultat = $bdd->query($query);
	if ($tmp = $resultat->fetchObject()) { $this->ordre = $tmp->ordre+1; }
	else { $this->ordre = 1; }
	unset ($query, $resultat, $tmp);

	if (count($GLOBALS['_ALERTES'])) {
		return false;
	}

	// *************************************************
	// Insertion dans la bdd
	$query = "INSERT INTO comptes_cbs 
							(id_compte_bancaire, ref_porteur, id_cb_type, numero_carte, date_expiration, controle, differe, ordre, actif)
						VALUES ('".$this->id_compte_bancaire."', ".ref_or_null($this->ref_porteur).", '".$this->id_cb_type."', 
										'".addslashes($this->numero_carte)."', '".$this->date_expiration."', 
										'".addslashes($this->controle)."', '".$this->differe."', 
										'".$this->ordre."', '".$this->actif."')"; 
	$bdd->exec ($query);
	$this->id_compte_cb = $bdd->lastInsertId();
	
	return true;
}



// *************************************************************************************************************
// FONCTIONS DE MISE A JOUR DES DONNEES 
// *************************************************************************************************************
public function maj_compte_cb ($infos) {
	global $bdd;

	// *************************************************
	// Réception des données
	$this->ref_porteur = $infos['ref_porteur'];

	$this->id_compte_bancaire = $infos['id_compte_bancaire'];
	if (!is_numeric($this->id_compte_bancaire)) { 
		$GLOBALS['_ALERTES']['bad_id_compte_bancaire'] = 1; 
		return false;
	}
	$query = "SELECT lib_compte lib_compte_bancaire 
						FROM comptes_bancaires 
						WHERE id_compte_bancaire = '".$this->id_compte_bancaire."' && actif = 1";
	$resultat = $bdd->query($query);
	if (!$tmp = $resultat->fetchObject()) {
		$GLOBALS['_ALERTES']['bad_id_compte_bancaire'] = 1; 
	}

	$this->differe 	= $infos['differe'];
	if (!is_numeric($this->differe) || $this->differe < 0 || $this->differe > 31) {
		$GLOBALS['_ALERTES']['bad_differe'] = 1; 
	}

	$this->id_cb_type	= $infos['id_cb_type'];
	if (!is_numeric($this->id_cb_type)) { 
		$GLOBALS['_ALERTES']['bad_id_cb_type'] = 1; 
	}
	$this->numero_carte 		= $infos['numero_carte'];
	$this->date_expiration 	= $infos['date_expiration'];
	$this->controle = $infos['controle'];

	if (count($GLOBALS['_ALERTES'])) {
		return false;
	}

	// *************************************************
	// MAJ de la bdd
	$query = "UPDATE comptes_cbs 
						SET id_compte_bancaire = '".$this->id_compte_bancaire."', ref_porteur = ".ref_or_null($this->ref_porteur).", 
								id_cb_type = '".$this->id_cb_type."', numero_carte = '".addslashes($this->numero_carte)."', 
								date_expiration = '".$this->date_expiration."', controle = '".addslashes($this->controle)."', 
								differe = '".$this->differe."'
						WHERE id_compte_cb = '".$this->id_compte_cb."' "; 
	$bdd->exec ($query);

	return true;
}


// Active un compte
function active_compte () {
	global $bdd;

	if ($this->actif) { return false; }

	// *************************************************
	// MAJ de la base de donnée
	$query = "UPDATE comptes_cbs 
						SET actif = 1
						WHERE id_compte_cb = '".$this->id_compte_cb."' "; 
	$bdd->exec ($query);

	$this->actif = 1;
	return true;
}

// Désactive un compte
function desactive_compte () {
	global $bdd;

	if (!$this->actif) { return false; }

	// *************************************************
	// Controle de la possibilité de désactiver ce compte 


	// *************************************************
	// MAJ de la base de donnée
	$query = "UPDATE comptes_cbs 
						SET actif = 0
						WHERE id_compte_cb = '".$this->id_compte_cb."' "; 
	$bdd->exec ($query);

	$this->actif = 0;
	return true;
}


public function modifier_ordre ($new_ordre) {
	global $bdd;
	if ($new_ordre == $this->ordre) { return false; }

	if (!is_numeric($new_ordre)) {
		$GLOBALS['_ALERTES']['bad_ordre'] = 1;
	}
	
	// *************************************************
	// Si les valeurs reçues sont incorrectes
	if (count($GLOBALS['_ALERTES'])) {
		return false;
	}

	if ($new_ordre < $this->ordre) {
		$variation = "+";
		$symbole1 = "<";
		$symbole2 = ">=";
	}
	else {
		$variation = "-";
		$symbole1 = ">";
		$symbole2 = "<=";
	}

	$bdd->beginTransaction();

	// Mise à jour des autres comptes bancaires
	$query = "UPDATE comptes_cbs
						SET ordre = ordre ".$variation." 1
						WHERE ordre ".$symbole1." '".$this->ordre."' && ordre ".$symbole2." '".$new_ordre."' ";
	$bdd->exec ($query);

	// Mise à jour de ce compte bancaire
	$query = "UPDATE comptes_cbs
						SET ordre = '".$new_ordre."'
						WHERE id_compte_cb = '".$this->id_compte_cb."'  ";
	$bdd->exec ($query);
	
	$bdd->commit();	

	$this->ordre = $new_ordre;

	// *************************************************
	// Résultat positif de la modification
	return true;
}


// Suppression d'un compte bancaire
public function suppression () {
	global $bdd;

	// *************************************************
	// Controle de la possibilité de supprimer le compte bancaire


	// Suppression dans la BDD
	$query = "DELETE FROM comptes_cbs WHERE id_compte_cb = '".$this->id_compte_cb."' ";
	$bdd->exec ($query);

	unset ($this);
	return true;
}



// *************************************************************************************************************
// FONCTIONS EXTERNES 
// *************************************************************************************************************


// Fonction permettant de charger tous les comptes bancaires
static function charger_comptes_cbs ($actif = "") {
	global $bdd;

	$query_actif = "";
	if ($actif) { $query_actif = " && c.actif = ".$actif; }
	
	$comptes = array();
	$query = "SELECT cb.id_compte_cb, cb.id_compte_bancaire, cb.ref_porteur, cb.id_cb_type, 
									 cb.numero_carte, cb.date_expiration, cb.controle, cb.differe, cb.actif, cb.ordre, 
									 c.lib_compte lib_compte_bancaire, a.nom nom_porteur, cbt.lib_cb_type
						FROM comptes_cbs cb
							LEFT JOIN comptes_bancaires c ON c.id_compte_bancaire = cb.id_compte_bancaire
							LEFT JOIN cartes_bancaires_types cbt ON cb.id_cb_type = cbt.id_cb_type
							LEFT JOIN annuaire a ON cb.ref_porteur = a.ref_contact
						WHERE 1 ".$query_actif." 
						ORDER BY ordre ASC";
	$resultat = $bdd->query ($query);
	while ($tmp = $resultat->fetchObject()) { $comptes[] = $tmp; }

	return $comptes;
}


// Charge les différents types de cartes bleu
static function get_carte_bancaire_types () {
	global $bdd;
	$comptes = array();
	$query = "SELECT id_cb_type, lib_cb_type
						FROM cartes_bancaires_types
						WHERE 1
      			ORDER BY lib_cb_type ASC";
	$resultat = $bdd->query ($query);
	while ($tmp = $resultat->fetchObject()) { $comptes[] = $tmp; }
	
	return $comptes;
}


// *************************************************************************************************************
// FONCTIONS DE RESTITUTION DES DONNEES 
// *************************************************************************************************************

function getId_compte_cb () {
	return $this->id_compte_cb;
}

function getId_compte_bancaire () {
	return $this->id_compte_bancaire;
}

function getRef_porteur () {
	return $this->ref_porteur;
}

function getNom_porteur () {
	return $this->nom_porteur;
}

function getNumero_carte () {
	return $this->numero_carte;
}

function getDate_expiration () {
	return $this->date_expiration;
}

function getControle () {
	return $this->controle;
}

function getDiffere () {
	return $this->differe;
}

function getOrdre () {
	return $this->ordre;
}

function getActif () {
	return $this->actif;
}



}





?>