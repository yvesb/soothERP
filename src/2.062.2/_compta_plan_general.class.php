<?php
// *************************************************************************************************************
// CLASSE REGISSANT LES INFORMATIONS SUR LE PLAN COMPTABLE GENERAL
// *************************************************************************************************************


final class compta_plan_general {

	protected $numero_compte;
	protected $lib_compte;

	protected $favori;


public function __construct ($numero_compte = "") {
	global $bdd;
	
	if (!$numero_compte) { return false; }
	
	$query = "SELECT numero_compte, lib_compte, favori
						FROM plan_comptable
						WHERE numero_compte = '".$numero_compte."' ";
	$resultat = $bdd->query ($query);
	if (!$compte = $resultat->fetchObject()) { return false; }

	$this->numero_compte	= $numero_compte;
	$this->lib_compte			= $compte->lib_compte;
	$this->favori					= $compte->favori;
	
	return true;
}





// *************************************************************************************************************
// FONCTIONS LIEES A LA CREATION D'UN COMPTE DE PLAN COMPTABLE
// *************************************************************************************************************

public function create_compte_plan_comptable ($infos) { 
	global $bdd;
	
	// *************************************************
	// Réception des données
	if (!$infos['numero_compte']) {$GLOBALS['_ALERTES']['numero_compte_vide'] = 1; }
	

	$this->numero_compte = $infos['numero_compte'];
	$query = "SELECT numero_compte 
						FROM plan_comptable 
						WHERE numero_compte = '".$this->numero_compte."'";
	$resultat = $bdd->query($query);
	if ($tmp = $resultat->fetchObject()) {
		$GLOBALS['_ALERTES']['exist_numero_compte'] = 1; 
	}

	
	if (count($GLOBALS['_ALERTES'])) {
		return false;
	}
	
	$this->lib_compte 	= $infos['lib_compte'];
	$this->favori	= $infos['favori'];

	// *************************************************
	// Insertion dans la bdd
	$query = "INSERT INTO plan_comptable 
							(numero_compte, lib_compte, favori)
						VALUES ('".$this->numero_compte."', '".addslashes($this->lib_compte)."', '".$this->favori."')"; 
	$bdd->exec ($query);
	
	return true;
}



// *************************************************************************************************************
// FONCTIONS DE MISE A JOUR DES DONNEES 
// *************************************************************************************************************
public function maj_compte_plan_comptable ($infos) {
	global $bdd;

	// *************************************************
	// Réception des données
	$old_numero_compte = $this->numero_compte;
	if (!$infos['numero_compte']) {$GLOBALS['_ALERTES']['numero_compte_vide'] = 1; }

	$this->numero_compte = $infos['numero_compte'];
	if ($this->numero_compte != $old_numero_compte) {
		$query = "SELECT numero_compte 
							FROM comptes_bancaires 
							WHERE numero_compte = '".$this->numero_compte."' ";
		$resultat = $bdd->query($query);
		if ($tmp = $resultat->fetchObject()) {
			$GLOBALS['_ALERTES']['exist_numero_compte'] = 1; 
		}
	}


	if (count($GLOBALS['_ALERTES'])) {
		return false;
	}
	$this->lib_compte 	= $infos['lib_compte'];
	$this->favori	= $infos['favori'];

	// *************************************************
	// MAJ de la bdd
	$query = "UPDATE plan_comptable 
						SET numero_compte = '".$this->numero_compte."', lib_compte = '".addslashes($this->lib_compte)."', 
								favori = '".$this->favori."'
						WHERE numero_compte = '".$old_numero_compte."' "; 
	$bdd->exec ($query);

	return true;
}

// supprime un compte
function supprime_compte () {
	global $bdd;

	// *************************************************
	// Controle de la possibilité de supprimer ce compte 

	$query = "SELECT numero_compte 
						FROM plan_comptable 
						WHERE numero_compte != '".$this->numero_compte."' && numero_compte LIKE '".$this->numero_compte."%'";


	$resultat = $bdd->query($query);
	if ($tmp = $resultat->fetchObject()) {
		$GLOBALS['_ALERTES']['exist_sous_numero_compte'] = 1; 
	}

	
	if (count($GLOBALS['_ALERTES'])) {
		return false;
	}
	// *************************************************
	// MAJ de la base de donnée
	$query = "DELETE FROM plan_comptable 
						WHERE numero_compte = '".$this->numero_compte."' "; 
	$bdd->exec ($query);

	$this->favori = 0;
	return true;
}


// Active un compte
function active_compte () {
	global $bdd;

	if ($this->favori) { return false; }

	// *************************************************
	// MAJ de la base de donnée
	$query = "UPDATE plan_comptable 
						SET favori = 1
						WHERE numero_compte = '".$this->numero_compte."' "; 
	$bdd->exec ($query);

	$this->favori = 1;
	return true;
}

// Désactive un compte
function desactive_compte () {
	global $bdd;

	if (!$this->favori) { return false; }

	// *************************************************
	// Controle de la possibilité de désactiver ce compte 


	// *************************************************
	// MAJ de la base de donnée
	$query = "UPDATE plan_comptable 
						SET favori = 0
						WHERE numero_compte = '".$this->numero_compte."' "; 
	$bdd->exec ($query);

	$this->favori = 0;
	return true;
}



// *************************************************************************************************************
// FONCTIONS EXTERNES 
// *************************************************************************************************************


// Fonction permettant de charger tous les comptes du plan comptable ou uniquement les favoris
static function charger_comptes_plan_general ($favori = "") {
	global $bdd;

	$query_favori = "";
	if ($favori) { $query_favori = " && favori = ".$favori; }
	
	$comptes = array();
	$query = "SELECT numero_compte, lib_compte, favori
						FROM plan_comptable
						WHERE 1 ".$query_favori." 
						ORDER BY numero_compte ASC";
	$resultat = $bdd->query ($query);
	while ($tmp = $resultat->fetchObject()) { $comptes[] = $tmp; }

	return $comptes;
}


// *************************************************************************************************************
// FONCTIONS DE RESTITUTION DES DONNEES 
// *************************************************************************************************************

function getNumero_compte () {
	return $this->numero_compte;
}

function getLib_compte () {
	return $this->lib_compte;
}

function getFavori () {
	return $this->favori;
}



}





?>