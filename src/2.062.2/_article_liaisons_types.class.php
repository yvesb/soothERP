<?php
// *************************************************************************************************************
// CLASSE REGISSANT LES INFORMATIONS SUR UNE LIAISON TYPE ENTRE ARTICLES
// *************************************************************************************************************

final class art_liaison_type {
	private $id_liaison_type;

	private $lib_liaison_type;	// Nom de la liaison
	private $lib_liaison_type_vers;
	private $lib_liaison_type_depuis;
	private $ordre;							// Ordre d'affichage
	private $actif;							// Type actif
	private $systeme;

function __construct ($id_liaison_type = 0) {
	global $bdd;

	// Controle si le id_liaison_type est précisé
	if (!$id_liaison_type) { return false; }

	// Sélection des informations générales
	$query = "SELECT alt.id_liaison_type, alt.lib_liaison_type, alt.lib_liaison_type_vers, alt.lib_liaison_type_depuis, alt.ordre, alt.actif, alt.systeme
						FROM art_liaisons_types alt
						WHERE id_liaison_type = '".$id_liaison_type."' ";
	$resultat = $bdd->query ($query);

	// Controle si le id_liaison_type est trouvé
	if (!$liaison_type = $resultat->fetchObject()) { return false; }

	// Attribution des informations à l'objet
	$this->id_liaison_type 				= $liaison_type->id_liaison_type;
	$this->lib_liaison_type				= $liaison_type->lib_liaison_type;
	$this->lib_liaison_type_vers	= $liaison_type->lib_liaison_type_vers;
	$this->lib_liaison_type_depuis= $liaison_type->lib_liaison_type_depuis;
	$this->ordre									= $liaison_type->ordre;
	$this->actif									= $liaison_type->actif;
	$this->systeme								= $liaison_type->systeme;
	return true;
}


// *************************************************************************************************************
// FONCTIONS LIEES A LA CREATION D'UNE LIAISON TYPE 
// *************************************************************************************************************

final public function create ($lib_liaison_type, $ordre, $actif) {
	global $bdd;

	// *************************************************
	// Controle des données transmises
	$this->lib_liaison_type 	= $lib_liaison_type;
	if (!$this->lib_liaison_type) { 
		$GLOBALS['_ALERTES']['lib_liaison_type_vide'] = 1; 
	}
	$this->ordre = $ordre;
	$this->actif = $actif;
	
	// *************************************************
	// Si les valeurs reçues sont incorrectes
	if (count($GLOBALS['_ALERTES'])) {
		return false;
	}

	// *************************************************
	// Insertion dans la base
	$query = "INSERT INTO art_liaisons_types (lib_liaison_type, ordre, actif)
						VALUES ('".addslashes($this->lib_liaison_type)."', 
										'".$this->ordre."',  '".$actif."')";
	$bdd->exec($query);
	$this->id_liaison_type = $bdd->lastInsertId();
	
	// *************************************************
	// Résultat positif de la création
	$GLOBALS['_INFOS']['Création_liaisons_types'] = $this->id_liaison_type;

	return true;
}



// *************************************************************************************************************
// FONCTIONS LIEES A LA MODIFICATION D'UNE LIAISON TYPE
// *************************************************************************************************************

final public function modification ($lib_liaison_type, $ordre, $actif) {
	global $bdd;
	
	// *************************************************
	// Controle des données transmises
	$this->lib_liaison_type 	= $lib_liaison_type;
	if (!$this->lib_liaison_type) { 
		$GLOBALS['_ALERTES']['lib_liaison_type_vide'] = 1; 
	}
	$this->ordre = $ordre;
	$this->actif = $actif;
	
	// *************************************************
	// Si les valeurs reçues sont incorrectes
	if (count($GLOBALS['_ALERTES'])) {
		return false;
	}

	// *************************************************
	// Mise a jour de la base
	$query = "UPDATE art_liaisons_types 
						SET lib_liaison_type = '".addslashes($this->lib_liaison_type)."', ordre = '".addslashes($this->ordre)."',
								actif = '".$actif."'
						WHERE id_liaison_type = '".$this->id_liaison_type."' ";
	$bdd->exec ($query);

	// *************************************************
	// Résultat positif de la modification
	return true;
}


// Activation / desactivation
final public function modifier_actif ($actif) {
	global $bdd;
	
	// *************************************************
	// Controle des données transmises
	$this->actif = $actif;
	
	// *************************************************
	// Si les valeurs reçues sont incorrectes
	if (count($GLOBALS['_ALERTES'])) {
		return false;
	}

	// *************************************************
	// Mise a jour de la base
	$query = "UPDATE art_liaisons_types 
						SET actif = '".$actif."'
						WHERE id_liaison_type = '".$this->id_liaison_type."' ";
	$bdd->exec ($query);

	// *************************************************
	// Résultat positif de la modification
	return true;
}



//**************************************************************************************************************
// MODIFICATION DE L'ORDRE POUR UNE LIAISON TYPE
// *************************************************************************************************************

final public function modifier_ordre ($new_ordre) {
	global $bdd;

	if (!is_numeric($new_ordre)) {
		$GLOBALS['_ALERTES']['bad_ordre'] = 1;
	}
	
	// *************************************************
	// Si les valeurs reçues sont incorrectes
	if (count($GLOBALS['_ALERTES'])) {
		return false;
	}

	if ($new_ordre == $this->ordre) { return true; }
	elseif ($new_ordre < $this->ordre) {
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
	
	// Mise à jour des autres LIAISON TYPE
	$query = "UPDATE art_liaisons_types
						SET ordre = ordre ".$variation." 1
						WHERE ordre ".$symbole1." '".$this->ordre."' && ordre ".$symbole2." '".$new_ordre."' ";
	$bdd->exec ($query);
	
	// Mise à jour de cette LIAISON TYPE
	$query = "UPDATE art_liaisons_types
						SET ordre = '".$new_ordre."' 
						WHERE id_liaison_type = '".$this->id_liaison_type."'";
	$bdd->exec ($query);
	
	$bdd->commit();	

	// *************************************************
	// Résultat positif de la modification
	return true;
}


//fonction qui retourne le id_liaison type en fonction de l'ordre
static function getId_liaison_type_from_ordre ($ordre) {
	global $bdd;
	
	$ref_liaison = "";
	$query = "SELECT id_liaison_type
						FROM art_liaisons_types
						WHERE ordre= ".$ordre." 
						LIMIT 1 ";
	$resultat = $bdd->query ($query);
	if ($liaison_type = $resultat->fetchObject()) { $ref_liaison = $liaison_type->id_liaison_type; }
	return	$ref_liaison;
}

// *************************************************************************************************************
// GETTERS & SETTERS 
// *************************************************************************************************************
	function getId_liaison_type () {
		return $this->id_liaison_type;
	}

	public function getLib_liaison_type() {
		return $this->lib_liaison_type;
	}
	
	public function getLib_liaison_type_vers() {
		return $this->lib_liaison_type_vers;
	}
	
	public function getLib_liaison_type_depuis() {
		return $this->lib_liaison_type_depuis;
	}

	function getOrdre () {
	 return $this->ordre;
	}

	function getActif () {
		return $this->actif;
	}





	private $articleLiaisonsDepuisAutresArticles;
	private $articleLiaisonsVersAutresArticles;
	
	
	public function getArticle_liaisons_vers_autres_articles($ref_article, $actif = 1, $systeme = 0) {
		global $bdd;
		
		if(!is_string($ref_article))
			return false;
		if(is_null($this->articleLiaisonsVersAutresArticles)){
			if(!is_numeric($actif) || !($actif == 0 | $actif == 1))
				return null;
			if(!is_numeric($systeme) || !($systeme == 0 | $systeme == 1))
				return null;
		
			$this->articleLiaisonsVersAutresArticles = array();
			$query = "SELECT 		al.ref_article, al.ref_article_lie, al.ratio, alt.id_liaison_type
								FROM 			articles_liaisons al
								LEFT JOIN art_liaisons_types alt ON al.id_liaison_type = alt.id_liaison_type
								WHERE			al.id_liaison_type = '".$this->getId_liaison_type()."'
													&& alt.actif = ".$actif." && alt.systeme = ".$systeme."
													&& al.ref_article = '".$ref_article."'";
			$resultat = $bdd->query ($query);
			while ($liaison = $resultat->fetchObject()) {
				$this->articleLiaisonsVersAutresArticles[] = array(
					"article" => new article($liaison->ref_article), 
					"article_lie" =>  new article($liaison->ref_article_lie), 
					"id_liaison_type" => $liaison->id_liaison_type,
					"ratio" => $liaison->ratio);
			}
		}
		return $this->articleLiaisonsVersAutresArticles;
	}
	


	public function getArticle_liaisons_depuis_autres_articles($ref_article, $actif = 1, $systeme = 0) {
		global $bdd;
		
		if(!is_string($ref_article))
			return false;
		if(is_null($this->articleLiaisonsDepuisAutresArticles)){
			if(!is_numeric($actif) || !($actif == 0 | $actif == 1))
				return null;
			if(!is_numeric($systeme) || !($systeme == 0 | $systeme == 1))
				return null;
		
			$this->articleLiaisonsDepuisAutresArticles = array();
			$query = "SELECT 		al.ref_article, al.ref_article_lie, al.ratio, alt.id_liaison_type
								FROM 			articles_liaisons al
								LEFT JOIN art_liaisons_types alt ON al.id_liaison_type = alt.id_liaison_type
								WHERE			al.id_liaison_type = '".$this->getId_liaison_type()."'
													&& alt.actif = ".$actif." && alt.systeme = ".$systeme."
													&& al.ref_article_lie = '".$ref_article."'";
			$resultat = $bdd->query ($query);
			while ($liaison = $resultat->fetchObject()) {
				$this->articleLiaisonsDepuisAutresArticles[] = array(
					"article" => new article($liaison->ref_article_lie), 
					"article_lie" =>  new article($liaison->ref_article), 
					"id_liaison_type" => $liaison->id_liaison_type,
					"ratio" => $liaison->ratio);
			}
		}
		return $this->articleLiaisonsDepuisAutresArticles;
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
							FROM 		art_liaisons_types
							WHERE 	actif = ".$actif." && systeme = ".$systeme."
							ORDER BY ordre ASC";
		$resultat = $bdd->query ($query);
		while ($liaison = $resultat->fetchObject()) {
			$liaisons_type[] = new art_liaison_type($liaison->id_liaison_type);
		}
		
		return $liaisons_type;
	}

}
?>