<?php
//  ******************************************************
// CLASSE REGISSANT LES INFORMATIONS SUR UN TYPE DE MESSAGE
//  ******************************************************


/**
 * @author Maxime HOEFFEL
 * @version 2.050
 *
 */
class msg_type {
	public static $nom_table = "msg_types";	// Le nom de la table dans la base de données
	
	private $id_msg_type;	// L'identifiant du type de message
	private $lib_msg_type;	// Le libellé du type de message
	
	/**
	 * Getter pour id_msg_type
	 * @return Int
	 */
	public function getId_msg_type(){
		return $this->id_msg_type;
	}
	
	/**
	 * Getter pour lib_msg_type
	 * @return String
	 */
	public function getLib_msg_type(){
		return $this->lib_msg_type;
	}
	
	/**
	 * Setter pour lib_msg_type
	 * @param String $lib_msg_type
	 * @return Boolean
	 */
	public function setLib_msg_type($lib_msg_type){
		if(!$lib_msg_type || $lib_msg_type == $this->lib_msg_type){
			return false;
		}
		$this->lib_msg_type = $lib_msg_type;
		return true;
	}
	
	/**
	 * Constructeur de la classe msg_type
	 * @param $id_msg_type L'identifiant du type de message
	 * @return Boolean
	 */
	public function __construct($id_msg_type = ""){
		global $bdd;
	
		// Controle si l'id_msg_type est précisé
		if (!$id_msg_type) {
			return false;
		}
	
		// Sélection des informations dans la base de données
		$query = "SELECT * 
					FROM " . self::$nom_table . " 
					WHERE id_msg_type = '" . $id_msg_type . "';";
		$resultat = $bdd->query ($query);
	
		// Controle si le type de message est trouvé en base
		if (!$msg_type = $resultat->fetchObject()) {
			return false;
		}
	
		// Attribution des informations à l'objet
		$this->id_msg_type		= $id_msg_type;
		$this->lib_msg_type		= $msg_type->lib_msg_type;
		
		return true;
	}
	
	/**
	 * Fonction permettant d'enregistrer l'objet en base de données
	 * @return Boolean
	 */
	public function save(){
		$query = "UPDATE " . self::$nom_table . " 
					SET lib_msg_type = '" . $this->lib_msg_type . "'
					WHERE id_msg_type = '" . $this->id_msg_type . "';";
		return $bdd->exec($query);
	}
	
	/* ***************************************
	 *        Fonctions statiques
	 * ****************************************/
	
	/**
	 * Fonction permettant de créer un msg_type
	 * @param String $lib_msg_type
	 * @return Boolean
	 */
	public final static function create($lib_msg_type = ""){
		global $bdd;
		if(!$lib_msg_type){
			return false;
		}
		// On vérifie qu'un type avec le même libellé n'existe pas déjà
		$query = "SELECT * 
					FROM " . self::$nom_table . " 
					WHERE lib_msg_type = '" . $lib_msg_type . "';";
		$res = $bdd->query($query);
		if($res->rowCount()){
			return false;
		}
		
		// Insertion des données en base
		$query = "INSERT INTO " . self::$nom_table . "(lib_msg_type)
					VALUES('" . $lib_msg_type . "');";
		if(!$bdd->query($query)){
			return false;
		}
		return new msg_type($bdd->lastInsertId());
	}
	
	/**
	 * Fonction permettant de supprimer un msg_type
	 * @param Int $id_msg_type
	 * @return boolean
	 */
	public final static function delete($id_msg_type){
		global $bdd;
		if(!$id_msg_type){
			return false;
		}
		// Suppression des données en base
		$query = "DELETE 
					FROM " . self::$nom_table . " 
					WHERE id_msg_type = '" . $id_msg_type . "';";
		return $bdd->query($query);
	}
	
	/**
	 * Fonction permettant de récupérer tous les types de message
	 * @return Array
	 */
	public final static function getAll_msg_types(){
		global $bdd;
		$query = "SELECT id_msg_type 
					FROM " . self::$nom_table . ";";
		$resultat = $bdd->query($query);
		$msg_types = array();
		while($enr = $resultat->fetchObject()){
			$msg_types[] = new msg_type($enr->id_msg_type);
		}
		return $msg_types;
	}
	
}

?>