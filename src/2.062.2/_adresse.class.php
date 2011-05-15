<?php
// *************************************************************************************************************
// CLASSE REGISSANT LES INFORMATIONS SUR UNE ADRESSE DE CONTACT 
// *************************************************************************************************************


final class adresse {
	private $ref_adresse;
	
	private $ref_contact;

	private $lib_adresse;
	private $text_adresse;

	private $code_postal;
	private $ville;
	private $id_pays;
	private $pays;

	private $note;
	private $ordre;
	
	private $type;


function __construct($ref_adresse = "") {
	global $bdd;

	// Controle si la ref_adresse est précisée
	if (!$ref_adresse) { return false; }

	// Sélection des informations générales
	$query = "SELECT ref_contact, lib_adresse, text_adresse, code_postal, ville, a.id_pays, note, ordre, id_type_adresse, p.pays
						FROM adresses a
							LEFT JOIN pays p ON a.id_pays = p.id_pays
						WHERE ref_adresse = '".$ref_adresse."' ";
	$resultat = $bdd->query ($query);

	// Controle si la ref_adresse est trouvée
	if (!$adresse = $resultat->fetchObject()) { return false; }

	// Attribution des informations à l'objet
	$this->ref_adresse 				= $ref_adresse;
	$this->ref_contact 				= $adresse->ref_contact;
	$this->lib_adresse				= $adresse->lib_adresse;
	$this->text_adresse				= $adresse->text_adresse;
	$this->code_postal				= $adresse->code_postal;
	$this->ville						= $adresse->ville;
	$this->id_pays			 			= $adresse->id_pays;
	$this->pays			 				= $adresse->pays;
	$this->note							= $adresse->note;
	$this->ordre						= $adresse->ordre;
	$this->type						 	= $adresse->id_type_adresse;

	return true;
}



// *************************************************************************************************************
// FONCTIONS LIEES A LA CREATION D'UNE ADRESSE 
// *************************************************************************************************************

final public function create ($ref_contact, $lib_adresse, $text_adresse, $code_postal, $ville, $id_pays, $note, $type = 0, $ref_adresse = "") {
	global $bdd;
	global $DEFAUT_ID_PAYS;

	$ADRESSE_ID_REFERENCE_TAG = 5;		// Référence Tag utilisé dans la base de donnée

	// *************************************************
	// Controle des données transmises
	$this->ref_contact 	= $ref_contact;
	$this->lib_adresse 	= $lib_adresse;
	$this->text_adresse = $text_adresse;
	$this->code_postal 	= $code_postal;
	$this->ville 		= $ville;
	$this->id_pays 		= $id_pays;
	$this->note		 	= $note;
	$this->type			= $type;
	
	// *************************************************
	// Si les valeurs reçues sont incorrectes
	if (count($GLOBALS['_ALERTES'])) {
		return false;
	}
	// Si aucune valeur, inutile de créer l'adresse
	if (!$this->lib_adresse && !$this->text_adresse && !$this->code_postal && !$this->ville && !$this->note) {
		return false;
	}
	if (!$this->id_pays) {$this->id_pays = $DEFAUT_ID_PAYS;}

	// *************************************************
	// Création de la référence
	if (!$ref_adresse) {
		$reference = new reference ($ADRESSE_ID_REFERENCE_TAG);
		$this->ref_adresse = $reference->generer_ref();
	} else {
		$this->ref_adresse = $ref_adresse;
	}
	
	// Ordre d'affichage
	$query = "SELECT MAX(ordre) ordre FROM adresses WHERE ref_contact = '".$this->ref_contact."' ";
	$resultat = $bdd->query($query);
	$tmp = $resultat->fetchObject();
	$this->ordre = $tmp->ordre+1;
	unset ($query, $resultat, $tmp);

	// *************************************************
	// Insertion dans la base
	$query = "INSERT INTO adresses (ref_adresse, ref_contact, lib_adresse, text_adresse, code_postal, ville, id_pays, note, ordre, id_type_adresse)
						VALUES ('".$this->ref_adresse."', '".$this->ref_contact."', '".addslashes($this->lib_adresse)."', 
										'".addslashes($this->text_adresse)."', 
										'".$this->code_postal."', '".addslashes($this->ville)."', 
										".num_or_null($this->id_pays).", 
										'".addslashes($this->note)."', '".$this->ordre."', ".num_or_null($this->type).")";
	$bdd->exec($query);
	
	// *************************************************
	// Résultat positif de la création
	$GLOBALS['_INFOS']['Création_adresse'] = $this->ref_adresse;

	return true;
}



// *************************************************************************************************************
// FONCTIONS LIEES A LA MODIFICATION D'UNE ADRESSE
// *************************************************************************************************************

final public function modification ($lib_adresse, $text_adresse, $code_postal, $ville, $id_pays, $note, $type) {
	global $bdd;
	
	// *************************************************
	// Controle des données transmises
	$this->lib_adresse 	= $lib_adresse;
	$this->text_adresse = $text_adresse;
	$this->code_postal 	= $code_postal;
	$this->ville 		= $ville;
	$this->id_pays 	= $id_pays;
	$this->note		 	= $note;
	$this->type			= $type;
	
	// *************************************************
	// Si les valeurs reçues sont incorrectes
	if (count($GLOBALS['_ALERTES'])) {
		return false;
	}

	// *************************************************
	// Mise a jour de la base
	$query = "UPDATE adresses 
						SET lib_adresse = '".addslashes($this->lib_adresse)."', text_adresse = '".addslashes($this->text_adresse)."', 
								code_postal = '".$this->code_postal."', ville = '".addslashes($this->ville)."', id_pays = '".$this->id_pays."', 
								note = '".addslashes($this->note)."' , id_type_adresse = ".num_or_null($this->type)."
						WHERE ref_adresse = '".$this->ref_adresse."' ";
	$bdd->exec ($query);

	// *************************************************
	// Résultat positif de la modification
	return true;
}



final public function modifier_ordre ($new_ordre) {
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
	
	// Mise à jour des autres adresses
	$query = "UPDATE adresses
						SET ordre = ordre ".$variation." 1
						WHERE ref_contact = '".$this->ref_contact."' && 
									ordre ".$symbole1." '".$this->ordre."' && ordre ".$symbole2." '".$new_ordre."' ";
	$bdd->exec ($query);
	
	// Mise à jour de cette adresse
	$query = "UPDATE adresses
						SET ordre = '".$new_ordre."'
						WHERE ref_adresse = '".$this->ref_adresse."'  ";
	$bdd->exec ($query);
	
	$bdd->commit();	

	$this->ordre = $new_ordre;

	// *************************************************
	// Résultat positif de la modification
	return true;
}


final public function suppression () {
	global $bdd;

	// *************************************************
	// Controle à effectuer le cas échéant

	// *************************************************
	// Suppression de l'adresse
	$query = "DELETE FROM adresses 
						WHERE ref_adresse = '".$this->ref_adresse."' ";
	$bdd->exec ($query);
	
	// Changement de l'ordre des adresses suivantes
	$query = "UPDATE adresses 
						SET ordre = ordre -1
						WHERE ref_contact = '".$this->ref_contact."' && ordre > '".$this->ordre."'";
	$bdd->exec ($query);

	unset ($this);
	return true;
}


// *************************************************************************************************************
// FONCTIONS DIVERSES
// *************************************************************************************************************
// renvois de la ref adresse en fonction de l'ordre
static function getRef_adresse_from_ordre ($ref_contact, $ordre) {
	global $bdd;
	
	$adresse = "";
	$query = "SELECT ref_adresse
						FROM adresses 
						WHERE ref_contact = '".$ref_contact."' 
						AND ordre = ".$ordre." 
						LIMIT 1"	;
	$resultat = $bdd->query ($query);
	if ($adres = $resultat->fetchObject()) { $adresse = $adres->ref_adresse; }
	return $adresse;
}

//retourne une liste des ref_adresse en fonction d'un plage d'ordre (mise à jour de l'affichage des adresses)
public function liste_ref_adresse_in_ordre () {
	global $bdd;
	
	$adresses = array();
	$query = "SELECT ref_adresse
						FROM adresses 
						WHERE ref_contact = '".$this->ref_contact."' 
						&& (ordre> ".$this->ordre." || ordre= ".$this->ordre."-1)";
	$resultat = $bdd->query ($query);
	while ($adres = $resultat->fetchObject()) { $adresses[] = $adres; }

	return $adresses;
}

// *************************************************************************************************************
// FONCTIONS DE LECTURE DES DONNEES 
// *************************************************************************************************************
function getRef_adresse () {
	return $this->ref_adresse;
}

function getRef_contact () {
	return $this->ref_contact;
}

function getLib_adresse () {
	return $this->lib_adresse;
}

function getText_adresse () {
 return $this->text_adresse;
}

function getCode_postal () {
	return $this->code_postal;
}

function getVille () {
	return $this->ville;
}

function getId_pays () {
	return $this->id_pays;
}

function getPays () {
	return $this->pays;
}

function getNote () {
	return $this->note;
}

function getOrdre () {
	return $this->ordre;
}
function getType () {
	return $this->type;
}
function getTypeLib () {
	global $bdd;
	$query = "SELECT adresse_type FROM adresses_types WHERE id_adresse_type = '".$this->type."' ";
	$retour = $bdd->query($query);
	if($ret = $retour->fetchObject()){
		return $ret->adresse_type;
	}
}

}

?>