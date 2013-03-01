<?php
// *************************************************************************************************************
// CLASSE REGISSANT LES INFORMATIONS SUR L'IMPORT DE TARIFS FOURNISSEUR
// *************************************************************************************************************

class fournisseurs_import_tarifs {
	private $ref_fournisseur;
	private $id_ref_oem;
	private $id_ref_interne;
	private $id_ref_fournisseur;
	private $id_lib_fournisseur;
	private $id_pua_ht;

	public function __construct ($ref_fournisseur = null) {
		global $bdd;
		
		$this->id_ref_oem			= 0;
		$this->id_ref_interne		= 0;
		$this->id_ref_fournisseur	= 0;
		$this->id_lib_fournisseur	= 0;
		$this->id_pua_ht			= 0;
		
		if(!$ref_fournisseur){
			return false;
		}
	
		$this->ref_fournisseur = $ref_fournisseur;
	
		// *************************************************
		// Sélection dans la base
		$query = "SELECT * 
					FROM fournisseurs_import_tarifs 
					WHERE ref_fournisseur = '" . $ref_fournisseur . "';";
		$resultat = $bdd->query ($query);
		if (!$tmp = $resultat->fetchObject()) { return false; }
		
		$this->id_ref_oem			= $tmp->id_ref_oem;
		$this->id_ref_interne		= $tmp->id_ref_interne;
		$this->id_ref_fournisseur	= $tmp->id_ref_fournisseur;
		$this->id_lib_fournisseur	= $tmp->id_lib_fournisseur;
		$this->id_pua_ht			= $tmp->id_pua_ht;
	
		return true;
	}
	
	// *************************************************************************************************************
	// GETTERS
	// *************************************************************************************************************
	public function getRef_fournisseur () {
		return $this->ref_fournisseur;
	}
	
	public function getId_ref_oem () {
		return $this->id_ref_oem;
	}
	
	public function getId_ref_interne () {
		return $this->id_ref_interne;
	}
	
	public function getId_ref_fournisseur () {
	 return $this->id_ref_fournisseur;
	}
	
	public function getId_lib_fournisseur () {
		return $this->id_lib_fournisseur;
	}
	
	public function getId_pua_ht () {
		return $this->id_pua_ht;
	}
	
	// *************************************************************************************************************
	// SETTERS
	// *************************************************************************************************************
	public function setRef_fournisseur ($ref_fournisseur) {
		$this->ref_fournisseur = $ref_fournisseur;
	}
	
	public function setId_ref_oem ($id_ref_oem) {
		$this->id_ref_oem = $id_ref_oem;
	}
	
	public function setId_ref_interne ($id_ref_interne) {
		$this->id_ref_interne = $id_ref_interne;
	}
	
	public function setId_ref_fournisseur ($id_ref_fournisseur) {
		$this->id_ref_fournisseur = $id_ref_fournisseur;
	}
	
	public function setId_lib_fournisseur ($id_lib_fournisseur) {
		$this->id_lib_fournisseur = $id_lib_fournisseur;
	}
	
	public function setId_pua_ht ($id_pua_ht) {
		$this->id_pua_ht = $id_pua_ht;
	}
	
	/*
	 * Fonction permettant de sauvegarder en base
	 */
	public function save(){
		global $bdd;
		$query = "SELECT * 
					FROM fournisseurs_import_tarifs 
					WHERE ref_fournisseur = '" . $this->ref_fournisseur . "';";
		$resultat = $bdd->query($query);
		if($resultat->rowCount()){
			// Update
			$query = "UPDATE fournisseurs_import_tarifs 
						SET id_ref_oem = '" . $this->id_ref_oem . "', 
							id_ref_interne = '" . $this->id_ref_interne . "', 
							id_ref_fournisseur = '" . $this->id_ref_fournisseur . "', 
							id_lib_fournisseur = '" . $this->id_lib_fournisseur . "', 
							id_pua_ht = '" . $this->id_pua_ht . "'
						WHERE ref_fournisseur = '" . $this->ref_fournisseur . "';";
		}else{
			// Insert
			$query = "INSERT INTO fournisseurs_import_tarifs 
						VALUES('" . $this->ref_fournisseur . "', 
								'" . $this->id_ref_oem . "', 
								'" . $this->id_ref_interne . "', 
								'" . $this->id_ref_fournisseur . "', 
								'" . $this->id_lib_fournisseur . "', 
								'" . $this->id_pua_ht . "');";
		}
		$bdd->query($query);
		return true;
	}

}
?>