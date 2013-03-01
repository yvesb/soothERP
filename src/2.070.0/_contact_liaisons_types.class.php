<?php
// *************************************************************************************************************
// CLASSE REGISSANT LES INFORMATIONS SUR UNE LIAISON TYPE ENTRE ARTICLES
// *************************************************************************************************************

class Contact_liaison_type {
	// Voir dans la BD la table : annuaire_liaisons_types

	private $id_liaison_type;		// BD : id_liaison_type [smallint(5) unsigned NOT NULL auto_increment]
	private $lib_liaison_type;	// BD : lib_liaison_type [varchar(64) NOT NULL]
	private $lib_liaison_vers;	// BD : lib_liaison_type_vers [varchar(64) NOT NULL]
	private $lib_liaison_depuis;// BD : lib_liaison_type_depuis [varchar(64) NOT NULL]
	private $ordre;							// BD : ordre [tinyint(3) unsigned NOT NULL]
	private $actif;							// BD : systeme [tinyint(3) unsigned NOT NULL default '0']

	private $contactLiaisonsVersAutresContacts;
	//$contactLiaisons[n]['contact'];
	//$contactLiaisons[n]['contact_lie'];
	//$contactLiaisons[n]['id_liaison_type'];
	private $contactLiaisonsDepuisAutresContacts;
	//$contactLiaisons[n]['contact'];
	//$contactLiaisons[n]['contact_lie'];
	//$contactLiaisons[n]['id_liaison_type'];
	
	private $contactLiaisons;
	//$contactLiaisons[n]['contact'];
	//$contactLiaisons[n]['contact_lie'];
	//$contactLiaisons[n]['id_liaison_type'];
	
	public function __construct ($id_liaison_type = 0) {
		global $bdd;
		
		// Controle si le id_liaison_type est précisé
		if (!$id_liaison_type) {	return false;}
		
		// Sélection des informations générales
		$query = "SELECT lib_liaison_type, lib_liaison_type_vers, lib_liaison_type_depuis, ordre, actif
							FROM annuaire_liaisons_types
							WHERE id_liaison_type = '".$id_liaison_type."' ";
		$resultat = $bdd->query ($query);
	
		// Controle si le id_liaison_type est trouvé
		if (!$liaison_type = $resultat->fetchObject()) {	return false;}
	
		// Attribution des informations à l'objet
		$this->id_liaison_type 		= $id_liaison_type;
		$this->lib_liaison_type		= $liaison_type->lib_liaison_type;
		$this->lib_liaison_vers		= $liaison_type->lib_liaison_type_vers;
		$this->lib_liaison_depuis = $liaison_type->lib_liaison_type_depuis;
		$this->ordre							= $liaison_type->ordre;
		$this->actif							= $liaison_type->actif;
		
		return true;
	}

	public static function _new_contact_liaison_type($lib_liaison_type, $lib_liaison_type_vers, $lib_liaison_type_depuis, $ordre, $actif) {
		global $bdd;
	
		if(	!isset($lib_liaison_type) 				|| $lib_liaison_type == "" ||
				!isset($lib_liaison_type_vers) 		|| $lib_liaison_type_vers == "" ||
				!isset($lib_liaison_type_depuis) 	|| $lib_liaison_type_depuis == "" ||   
				!isset($ordre) || $ordre == 0  		||!($actif == 0 || actif == 1))
		{		return false;}
		
		$query = "INSERT INTO annuaire_liaisons_types 
							(		lib_liaison_type, 										lib_liaison_type_vers, 										lib_liaison_type_depuis, 										ordre, 				actif) VALUES 
							('".addslashes($lib_liaison_type)."', '".addslashes($lib_liaison_type_vers)."', '".addslashes($lib_liaison_type_depuis)."', '".$ordre."',  '".$actif."')";
		$bdd->exec($query);
		
		return new Contact_liaison_type($bdd->lastInsertId());
	}

	// *************************************************************************************************************
	// GETTERS & SETTERS
	// *************************************************************************************************************
	
	public function getId_liaison_type() {
		return $this->id_liaison_type;
	}

	public function getLib_liaison_type() {
		return $this->lib_liaison_type;
	}
	
	public function getLib_liaison_type_vers() {
		return $this->lib_liaison_vers;
	}
	
	public function getLib_liaison_type_depuis() {
		return $this->lib_liaison_depuis;
	}
	
	public function setLib_liaison_type($lib_liaison_type) {
		global $bdd;
		
		if(!isset($lib_liaison_type) || $lib_liaison_type == "")
		{		return false;}
		
		if($this->lib_liaison_type == $lib_liaison_type)
		{		return true;}
		
		$query = "UPDATE 	annuaire_liaisons_types 
							SET 		lib_liaison_type = '".addslashes($this->lib_liaison_type)."'
							WHERE 	id_liaison_type = '".$this->id_liaison_type."' ";
		$bdd->exec ($query);
		
		$this->$lib_liaison_type = $lib_liaison_type; 
		return true;
	}
	
	function getOrdre () {
	 return $this->ordre;
	}
	
	public function setOrdre($new_ordre = 0) {
		global $bdd;
		
		if(!isset($new_ordre) || !is_numeric($new_ordre) || $new_ordre<= 0)
		{		return false;}
		
		if ($this->ordre == $new_ordre){
			return true;
		} elseif ($new_ordre < $this->ordre) {
			$variation = "+";
			$symbole1 = "<";
			$symbole2 = ">=";
		} else {
			$variation = "-";
			$symbole1 = ">";
			$symbole2 = "<=";
		}
	
		$bdd->beginTransaction();{
			// Mise à jour des autres LIAISON TYPE
			$query = "UPDATE 	annuaire_liaisons_types
								SET 		ordre = ordre ".$variation." 1
								WHERE 	ordre ".$symbole1." '".$this->ordre."' && ordre ".$symbole2." '".$new_ordre."' ";
			$bdd->exec ($query);
			
			// Mise à jour de cette LIAISON TYPE
			$query = "UPDATE 	annuaire_liaisons_types
								SET 		ordre = '".$new_ordre."' 
								WHERE 	id_liaison_type = '".$this->id_liaison_type."'";
			$bdd->exec ($query);
		}$bdd->commit();
		
		$this->ordre = $new_ordre; 
		return true;
	}
	
	function getActif () {
		return $this->actif;
	}
	
	public function setActif() {
		global $bdd;

		$query = "UPDATE 	annuaire_liaisons_types 
							SET 		actif = 1
							WHERE 	id_liaison_type = '".$this->id_liaison_type."' ";
		$bdd->exec ($query);
		$this->actif = 1;
		return true;
	}
	
	public function setNo_actif() {
		global $bdd;

		$query = "UPDATE 	annuaire_liaisons_types 
							SET 		actif = 0
							WHERE 	id_liaison_type = '".$this->id_liaison_type."' ";
		$bdd->exec ($query);
		$this->actif = 0;
		return true;
	}

	
	public function getContact_liaisons($ref_contact = "", $actif = 1, $systeme = 0) {
		global $bdd;
		if(is_null($this->contactLiaisons)){
			if(!is_numeric($actif) || !($actif == 0 | $actif == 1))
				return null;
			if(!is_numeric($systeme) || !($systeme == 0 | $systeme == 1))
				return null;
		
			$this->contactLiaisons = array();
			$query = "SELECT 		al.ref_contact, al.ref_contact_lie, alt.id_liaison_type
								FROM 			annuaire_liaisons al
								LEFT JOIN annuaire_liaisons_types alt ON al.id_liaison_type = alt.id_liaison_type
								WHERE			al.id_liaison_type = '".$this->getId_liaison_type()."'
													&& alt.actif = ".$actif." && alt.systeme = ".$systeme;
			if($ref_contact != "")
			{		$query.="			&& ( ref_contact = '".$ref_contact."' || ref_contact_lie = '".$ref_contact."' )";}
			$resultat = $bdd->query ($query);
			while ($liaison = $resultat->fetchObject()) {
				$this->contactLiaisons[] = array("contact" => new contact($liaison->ref_contact), "contact_lie" =>  new contact($liaison->ref_contact_lie), "id_liaison_type" => $liaison->id_liaison_type);
			}
		}
		return $this->contactLiaisons;
	}
	
	public function getContact_liaisons_vers_autres_contacts($ref_contact, $actif = 1, $systeme = 0) {
		global $bdd;
		
		if(!is_string($ref_contact))
			return false;
		if(is_null($this->contactLiaisonsVersAutresContacts)){
			if(!is_numeric($actif) || !($actif == 0 | $actif == 1))
				return null;
			if(!is_numeric($systeme) || !($systeme == 0 | $systeme == 1))
				return null;
		
			$this->contactLiaisonsVersAutresContacts = array();
			$query = "SELECT 		al.ref_contact, al.ref_contact_lie, alt.id_liaison_type
								FROM 			annuaire_liaisons al
								LEFT JOIN annuaire_liaisons_types alt ON al.id_liaison_type = alt.id_liaison_type
								WHERE			al.id_liaison_type = '".$this->getId_liaison_type()."'
													&& alt.actif = ".$actif." && alt.systeme = ".$systeme."
													&& al.ref_contact = '".$ref_contact."'";
			$resultat = $bdd->query ($query);
			while ($liaison = $resultat->fetchObject()) {
				$this->contactLiaisonsVersAutresContacts[] = array("contact" => new contact($liaison->ref_contact), "contact_lie" =>  new contact($liaison->ref_contact_lie), "id_liaison_type" => $liaison->id_liaison_type);
			}
		}
		return $this->contactLiaisonsVersAutresContacts;
	}
	
	public function getContact_liaisons_depuis_autres_contacts($ref_contact, $actif = 1, $systeme = 0) {
		global $bdd;
		
		if(!is_string($ref_contact))
			return false;
		if(is_null($this->contactLiaisonsDepuisAutresContacts)){
			if(!is_numeric($actif) || !($actif == 0 | $actif == 1))
				return null;
			if(!is_numeric($systeme) || !($systeme == 0 | $systeme == 1))
				return null;
		
			$this->contactLiaisonsDepuisAutresContacts = array();
			$query = "SELECT 		al.ref_contact, al.ref_contact_lie, alt.id_liaison_type
								FROM 			annuaire_liaisons al
								LEFT JOIN annuaire_liaisons_types alt ON al.id_liaison_type = alt.id_liaison_type
								WHERE			al.id_liaison_type = '".$this->getId_liaison_type()."'
													&& alt.actif = ".$actif." && alt.systeme = ".$systeme."
													&& al.ref_contact_lie = '".$ref_contact."'";
			$resultat = $bdd->query ($query);
			while ($liaison = $resultat->fetchObject()) {
				$this->contactLiaisonsDepuisAutresContacts[] = array("contact" => new contact($liaison->ref_contact), "contact_lie" =>  new contact($liaison->ref_contact_lie), "id_liaison_type" => $liaison->id_liaison_type);
			}
		}
		return $this->contactLiaisonsDepuisAutresContacts;
	}

	// *************************************************************************************************************
	// FONCTIONS STATIQUES
	// *************************************************************************************************************

	//$contactLiaisons[n]['contact'];
	//$contactLiaisons[n]['contact_lie'];
	//$contactLiaisons[n]['id_liaison_type'];
	public static function getContact_liaisons_all_type($ref_contact = "", $actif = 1, $systeme = 0) {
		global $bdd;
		
		if(!is_numeric($actif) || !($actif == 0 | $actif == 1))
			return null;
		if(!is_numeric($systeme) || !($systeme == 0 | $systeme == 1))
			return null;
		
		$contactLiaisons = array();
			
		$query = "SELECT 		al.ref_contact, al.ref_contact_lie, alt.id_liaison_type
							FROM 			annuaire_liaisons al
							LEFT JOIN annuaire_liaisons_types alt ON al.id_liaison_type = alt.id_liaison_type
							WHERE			alt.actif = ".$actif." && alt.systeme = ".$systeme;
		if($ref_contact != "")
		{		$query.="				&& ( ref_contact = '".$ref_contact."' || ref_contact_lie = '".$ref_contact."' )";}
		
		$resultat = $bdd->query ($query);
		while ($liaison = $resultat->fetchObject()) {
			$contactLiaisons[] = array("contact" => new contact($liaison->ref_contact), "contact_lie" =>  new contact($liaison->ref_contact_lie), "id_liaison_type" => $liaison->id_liaison_type);
		}
		return $contactLiaisons;
	}
		
	//fonction qui retourne le id_liaison type en fonction de l'ordre
	public static function getId_liaison_type_from_ordre ($ordre) {
		global $bdd;
		
		$query = "SELECT id_liaison_type
							FROM annuaire_liaisons_types
							WHERE ordre= ".$ordre." 
							LIMIT 1 ";
		$resultat = $bdd->query ($query);
		if ($liaison_type = $resultat->fetchObject())
		{ 		return $liaison_type->id_liaison_type; }
		else{	return null;}
	}
	
	//retourne un tableau contenant des objets Contact_liaison_type 
	public static function getLiaisons_type($actif = 1, $systeme = 0) {
		if(!is_numeric($actif) || !($actif == 0 | $actif == 1))
			return null;
		if(!is_numeric($systeme) || !($systeme == 0 | $systeme == 1))
			return null;
		
		global $bdd;
	
		$liaisons_type = array();
		$query = "SELECT 	id_liaison_type
							FROM 		annuaire_liaisons_types
							WHERE 	actif = ".$actif." && systeme = ".$systeme."
							ORDER BY ordre ASC";
		$resultat = $bdd->query ($query);
		while ($liaison = $resultat->fetchObject()) {
			$liaisons_type[] = new Contact_liaison_type($liaison->id_liaison_type);
		}
		
		return $liaisons_type;
	}
	/*
	//retourne un tableau contenant des objets Contact_liaison_type 
	public static function getLiaisons_type_vers_autre_contact($actif = 1, $systeme = 0) {
		if(!is_numeric($actif) || !($actif == 0 | $actif == 1))
			return null;
		if(!is_numeric($systeme) || !($systeme == 0 | $systeme == 1))
			return null;
		
		global $bdd;
	
		$liaisons_type = array();
		$query = "SELECT 	id_liaison_type
							FROM 		annuaire_liaisons_types
							WHERE 	actif = ".$actif." && systeme = ".$systeme."
							ORDER BY ordre ASC";
		$resultat = $bdd->query ($query);
		while ($liaison = $resultat->fetchObject()) {
			$liaisons_type[] = new Contact_liaison_type($liaison->id_liaison_type);
		}
		
		return $liaisons_type;
	}
	
	//retourne un tableau contenant des objets Contact_liaison_type 
	public static function getLiaisons_type_depuis_autre_contact($actif = 1, $systeme = 0) {
		if(!is_numeric($actif) || !($actif == 0 | $actif == 1))
			return null;
		if(!is_numeric($systeme) || !($systeme == 0 | $systeme == 1))
			return null;
		
		global $bdd;
	
		$liaisons_type = array();
		$query = "SELECT 	id_liaison_type
							FROM 		annuaire_liaisons_types
							WHERE 	actif = ".$actif." && systeme = ".$systeme."
							ORDER BY ordre ASC";
		$resultat = $bdd->query ($query);
		while ($liaison = $resultat->fetchObject()) {
			$liaisons_type[] = new Contact_liaison_type($liaison->id_liaison_type);
		}
		
		return $liaisons_type;
	}
	*/
}

// *************************************************************************************************************
// LIBRAIRIE
// *************************************************************************************************************

?>