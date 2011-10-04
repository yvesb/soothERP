<?php
// *************************************************************************************************************
// CLASSE REGISSANT LES INFORMATIONS SUR LES JOURNAUX DE BANQUE ET CAISSE
// *************************************************************************************************************


final class compta_journaux {

	protected $id_journal;
	protected $lib_journal;
	protected $desc_journal;
	protected $id_journal_parent;
	protected $id_journal_type;
	protected $contrepartie;


public function __construct ($id_journal = "", $id_journal_parent = "", $contrepartie = "") {
	global $bdd;
	
	$query = "SELECT id_journal, lib_journal, desc_journal, id_journal_parent, id_journal_type, contrepartie
						FROM compta_journaux
						WHERE ";
	
	//Retrouver l'id_journal à partir du parent et de la contreparte
	if ($id_journal_parent && $contrepartie) { 
	 	$query .= " id_journal_parent = ".$id_journal_parent." && contrepartie = '".$contrepartie."' ";
	}
	
	if (!$id_journal && !$id_journal_parent && !$contrepartie) { return false; }
	
	if ($id_journal) { 
		$query .= " id_journal = '".$id_journal."' ";
	}
	
	$resultat = $bdd->query ($query);
	if (!$journal = $resultat->fetchObject()) { return false; }

	$this->id_journal					= $journal->id_journal;
	$this->lib_journal				= $journal->lib_journal;
	$this->desc_journal				= $journal->desc_journal;
	$this->id_journal_parent	= $journal->id_journal_parent;
	$this->id_journal_type		= $journal->id_journal_type;
	$this->contrepartie				= $journal->contrepartie;
	
	return true;
}


// *************************************************************************************************************
// FONCTIONS LIEES A LA CREATION D'UN JOUNAL
// *************************************************************************************************************

public function create_journal ($infos) { 
	global $bdd;
	
	// *************************************************
	// Réception des données

	$query = "SELECT MAX(id_journal)  as id_journal 
						FROM compta_journaux ";
	$resultat = $bdd->query($query);
	if ($tmp = $resultat->fetchObject()) { $this->id_journal = $tmp->id_journal+1; }
	
	if (!$this->id_journal) {$GLOBALS['_ALERTES']['id_journal_erreur'] = 1; }
	
	if (count($GLOBALS['_ALERTES'])) {
		return false;
	}
	
	$this->lib_journal				=  $infos['lib_journal'];
	$this->desc_journal				=  $infos['desc_journal'];
	$this->id_journal_parent	=  $infos['id_journal_parent'];
	$this->id_journal_type		=  $infos['id_journal_type'];
	$this->contrepartie				=  $infos['contrepartie'];

	// *************************************************
	// Insertion dans la bdd
	$query = "INSERT INTO compta_journaux 
							(id_journal, lib_journal, desc_journal, id_journal_parent, id_journal_type, contrepartie)
						VALUES ('".$this->id_journal."', '".addslashes($this->lib_journal)."', '".addslashes($this->desc_journal)."', '".$this->id_journal_parent."', '".$this->id_journal_type."', '".addslashes($this->contrepartie)."')"; 

	$bdd->exec ($query);
	
	return true;
}

// création d'une opération de compte 
public function create_operation ($numero_compte, $montant, $ref_operation, $date_operation, $id_operation_type) { 
	global $bdd;
	
	$query = "INSERT INTO compta_journaux_opes 
								(id_journal, numero_compte, montant, ref_operation, date_operation, id_operation_type)
							VALUES ('".$this->id_journal."', '".addslashes($numero_compte)."', '".$montant."', '".addslashes($ref_operation)."', '".$date_operation."', '".$id_operation_type."')"; 

	$bdd->exec ($query);

	return true;
}
// *************************************************************************************************************
// FONCTIONS EXTERNES 
// *************************************************************************************************************


// Fonction permettant de charger tous les journaux
static function charger_compta_journaux ($id_journal_parent = "") {
	global $bdd;

	$query_id_journal_parent = "";
	if ($id_journal_parent) { $query_id_journal_parent = " && id_journal_parent = ".$id_journal_parent; }
	
	$journaux = array();
	$query = "SELECT id_journal, lib_journal, desc_journal, id_journal_parent, id_journal_type, contrepartie
						FROM compta_journaux
						WHERE 1 ".$query_id_journal_parent." 
						ORDER BY id_journal ASC";
	$resultat = $bdd->query ($query);
	while ($tmp = $resultat->fetchObject()) { $journaux[] = $tmp; }

	return $journaux;
}

// Fonction permettant de charger tous les journaux
static function check_exist_journaux ($id_journal_parent = "", $contrepartie = "") {
	global $bdd;
	
	$journal_test = new compta_journaux("", $id_journal_parent, $contrepartie);
	
	if (!$journal_test->getId_journal ()) {
		unset ($journal_test); 
		$parent_journal = new compta_journaux($id_journal_parent);
		
		$journal_test = new compta_journaux();
		$infos = array();
		$infos['lib_journal'] = $parent_journal->getLib_journal ();
		$infos['desc_journal'] = $parent_journal->getDesc_journal ();
		$infos['id_journal_parent'] = $parent_journal->getId_journal ();
		$infos['id_journal_type'] = $parent_journal->getId_journal_type ();
		$infos['contrepartie'] = $contrepartie;
		$journal_test->create_journal ($infos);

	}
	
	return $journal_test;
}

//fonction de suppression d'une opération (en cas de suppression d'un reglement )
static function suppression_operation ($ref_operation, $id_operation_type) { 
	global $bdd;
	
	$query = "DELETE FROM compta_journaux_opes 
						WHERE ref_operation = '".addslashes($ref_operation)."' && id_operation_type = '".$id_operation_type."' "; 
	$bdd->exec ($query);

	return true;
}

// *************************************************************************************************************
// FONCTIONS DE RESTITUTION DES DONNEES 
// *************************************************************************************************************

function getId_journal () {
	return $this->id_journal;
}

function getLib_journal () {
	return $this->lib_journal;
}

function getDesc_journal () {
	return $this->desc_journal;
}

function getId_journal_parent () {
	return $this->id_journal_parent;
}

function getId_journal_type () {
	return $this->id_journal_type;
}

function getContrepartie () {
	return $this->contrepartie;
}

}


function charger_liste_journaux_treso () {
	global $bdd;
	global $DEFAUT_ID_JOURNAL_BANQUES; // "9";
	global $DEFAUT_ID_JOURNAL_CAISSES; // "10";
	
	$liste_journaux = array();
	
	$query = "SELECT id_journal, lib_journal, desc_journal, id_journal_parent, id_journal_type, contrepartie
						FROM compta_journaux cj
						WHERE id_journal = '".$DEFAUT_ID_JOURNAL_BANQUES."' || id_journal = '".$DEFAUT_ID_JOURNAL_CAISSES."' || id_journal_parent = '".$DEFAUT_ID_JOURNAL_BANQUES."' || id_journal_parent = '".$DEFAUT_ID_JOURNAL_CAISSES."'
						ORDER BY id_journal_parent ASC, lib_journal DESC, contrepartie ASC
					
						";
	
	$resultat = $bdd->query ($query);
	while ($journaux = $resultat->fetchObject()) {
		$liste_journaux [] = $journaux;
	}
	return $liste_journaux;
}


?>