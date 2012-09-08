<?php
// *************************************************************************************************************
// CLASSE REGISSANT LES MODELES D'ECHEANCIERS 
// *************************************************************************************************************


final class modele_echeancier {
	protected $id_echeancier_modele;

	protected $lib_echeancier_modele;	
	
	protected $echeances = array();



public function __construct ($id_echeancier_modele = "") {
	global $bdd;
	
	if (!$id_echeancier_modele) { return false; }
	
	$query = "SELECT eme.id_echeancier_modele, em.lib_echeancier_modele, eme.type_reglement, eme.id_mode_reglement, eme.pourcentage, eme.jour
						FROM echeanciers_modeles em
							LEFT JOIN echeanciers_modeles_echeances eme ON eme.id_echeancier_modele = em.id_echeancier_modele
						WHERE eme.id_echeancier_modele = '".$id_echeancier_modele."' ";
	$resultat = $bdd->query ($query);
	$i = 1;
	while ($echeance = $resultat->fetchObject()) {

	$this->id_echeancier_modele	 = $id_echeancier_modele;
	$this->lib_echeancier_modele = $echeance->lib_echeancier_modele;
	
	$this->echeances[$i]["type_reglement"] = $echeance->type_reglement;
	$this->echeances[$i]["id_mode_reglement"] = $echeance->id_mode_reglement;
	$this->echeances[$i]["pourcentage"] = $echeance->pourcentage;
	$this->echeances[$i]["jour"] = $echeance->jour;
	$i++;
	}
	
	return true;
}


// *************************************************************************************************************
// FONCTIONS LIEES A LA CREATION D'UN MODELE D'ECHEANCIER
// *************************************************************************************************************

public function create_modele_echeancier ($infos) { 
	global $bdd;
	
	// *************************************************
	// Réception des données
	$this->lib_echeancier_modele = $infos['lib_echeancier_modele'];
	

	$this->echeances = $infos['echeances'];
	
	// *************************************************
	// Insertion dans la bdd
	$query = "INSERT INTO echeanciers_modeles (lib_echeancier_modele) VALUES ('".$this->lib_echeancier_modele."')";
	$bdd->exec ($query);
	$this->id_echeancier_modele = $bdd->lastInsertId();
	for($i=1;$i<=count($this->echeances);$i++){
		$query = "INSERT INTO echeanciers_modeles_echeances (id_echeancier_modele, type_reglement, id_mode_reglement, pourcentage, jour)
					VALUES ('".$this->id_echeancier_modele."','".$this->echeances[$i]['type_reglement']."','".$this->echeances[$i]['id_mode_reglement']."','".$this->echeances[$i]['pourcentage']."','".$this->echeances[$i]['jour']."')";
		$bdd->exec ($query);
	}
	return true;
}



// *************************************************************************************************************
// FONCTIONS DE MISE A JOUR DES DONNEES 
// *************************************************************************************************************
public function maj_modele_echeancier ($infos) {
	global $bdd;

	// *************************************************
	// Réception des données
	//_vardump($infos);
	
	$this->lib_echeancier_modele = $infos['lib_echeancier_modele'];
	
	$this->echeances = $infos['echeances'];

	// *************************************************
	// MAJ de la bdd
	$query = "UPDATE echeanciers_modeles 
						SET lib_echeancier_modele = '".$this->lib_echeancier_modele."'
						WHERE id_echeancier_modele = '".$this->id_echeancier_modele."' ";
	$bdd->exec ($query);
	$query = "DELETE FROM echeanciers_modeles_echeances WHERE id_echeancier_modele = '".$this->id_echeancier_modele."' ";
	$bdd->exec ($query);
	for($i=1;$i<=count($this->echeances);$i++){
		$query = "INSERT INTO echeanciers_modeles_echeances (id_echeancier_modele, type_reglement, id_mode_reglement, pourcentage, jour)
					VALUES ('".$this->id_echeancier_modele."','".$this->echeances[$i]['type_reglement']."','".$this->echeances[$i]['id_mode_reglement']."','".$this->echeances[$i]['pourcentage']."','".$this->echeances[$i]['jour']."')";
		$bdd->exec ($query);
	}

	return true;
}


// Suppression d'un modele d'echeancier
public function suppression () {
	global $bdd;

	// Suppression dans la BDD
	$query = "DELETE FROM echeanciers_modeles WHERE id_echeancier_modele = '".$this->id_echeancier_modele."' "; 
	$bdd->exec ($query);
	$query = "DELETE FROM echeanciers_modeles_echeances WHERE id_echeancier_modele = '".$this->id_echeancier_modele."' "; 
	$bdd->exec ($query);
	
	unset ($this);
	return true;
}



// *************************************************************************************************************
// FONCTIONS EXTERNES 
// *************************************************************************************************************


// Fonction permettant de charger tous les comptes bancaires
static function charger_modeles_echeances () {
	global $bdd;

	$modeles = array();
	$query = "SELECT id_echeancier_modele, lib_echeancier_modele 
						FROM echeanciers_modeles
						ORDER BY lib_echeancier_modele";
	$resultat = $bdd->query ($query);
	while ($tmp = $resultat->fetchObject()) { $modeles[] = $tmp; }

	return $modeles;
}

// *************************************************************************************************************
// FONCTIONS DE RESTITUTION DES DONNEES 
// *************************************************************************************************************

function getId_echeancier_modele () {
	return $this->id_echeancier_modele;
}

function getLib_echeancier_modele () {
	return $this->lib_echeancier_modele;
}

function getEcheances () {
	return $this->echeances;
}

}





?>