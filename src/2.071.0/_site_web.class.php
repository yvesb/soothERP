<?php
// *************************************************************************************************************
// CLASSE REGISSANT LES INFORMATIONS SUR UNE SITE WEB DE CONTACT 
// *************************************************************************************************************


final class site {
	private $ref_site;
	private $ref_contact;

	private $lib_site_web;
	
	private $url;
	private $login;
	private $pass;

	private $note;
	private $ordre;
	
	private $type;


function __construct($ref_site = "") {
	global $bdd;

	// Controle si la ref_site est précisée
	if (!$ref_site) { return false; }

	// Sélection des informations générales
	$query = "SELECT ref_contact, lib_site_web, url, login, pass, note, ordre, id_type_site_web
						FROM sites_web 
						WHERE ref_site = '".$ref_site."' ";
	$resultat = $bdd->query ($query);

	// Controle si la ref_site est trouvée
	if (!$site = $resultat->fetchObject()) { return false; }

	// Attribution des informations à l'objet
	$this->ref_site 		= $ref_site;
	$this->ref_contact 	= $site->ref_contact;
	$this->lib_site_web	= $site->lib_site_web;
	$this->url					= $site->url;
	$this->login	= $site->login;
	$this->pass		= $site->pass;
	$this->note		= $site->note;
	$this->ordre	= $site->ordre;
	$this->type		= $site->id_type_site_web;

	return true;
}



// *************************************************************************************************************
// FONCTIONS LIEES A LA CREATION D'UNE SITE 
// *************************************************************************************************************

final public function create ($ref_contact, $lib_site_web, $url, $login, $pass, $note, $type = 0, $ref_site = "") {
	global $bdd;

	$SITE_ID_REFERENCE_TAG = 7;		// Référence Tag utilisé dans la base de donnée

	// *************************************************
	// Controle des données transmises
	$this->ref_contact 	= $ref_contact;
	$this->lib_site_web = $lib_site_web;
	$this->url 		= $url;
	$this->login 	= $login;
	$this->pass	 	= $pass;
	$this->note		= $note;
	$this->type		= $type;
	
	// *************************************************
	// Si les valeurs reçues sont incorrectes
	if (0) {
		return false;
	}
	// Si aucune valeur, inutile de créer la coordonnée
	if (!$this->lib_site_web && !$this->url && !$this->login && !$this->pass && !$this->note) {
		return false;
	}

	// *************************************************
	// Création de la référence
	if(!$ref_site) {
		$reference = new reference ($SITE_ID_REFERENCE_TAG);
		$this->ref_site = $reference->generer_ref();
	} else {
		$this->ref_site = $ref_site;
	}
	
	// Ordre d'affichage
	$query = "SELECT MAX(ordre) ordre FROM sites_web WHERE ref_contact = '".$this->ref_contact."' ";
	$resultat = $bdd->query($query);
	$tmp = $resultat->fetchObject();
	$this->ordre = $tmp->ordre+1;
	unset ($query, $resultat, $tmp);

	// *************************************************
	// Insertion dans la base
	$query = "INSERT INTO sites_web (ref_site, ref_contact, lib_site_web, url, login, pass, note, ordre, id_type_site_web)
						VALUES ('".$this->ref_site."', '".$this->ref_contact."', '".addslashes($this->lib_site_web)."', 
										'".addslashes($this->url)."', '".addslashes($this->login)."', 
										'".addslashes($this->pass)."', '".addslashes($this->note)."', '".$this->ordre."', ".num_or_null($this->type).")";
	$bdd->exec($query);
	
	// *************************************************
	// Résultat positif de la création
	$GLOBALS['_INFOS']['Création_site_web'] = $this->ref_site;
	return true;
}



// *************************************************************************************************************
// FONCTIONS LIEES A LA MODIFICATION D'UNE SITE
// *************************************************************************************************************

final public function modification ($lib_site_web, $url, $login, $pass, $note, $type = 0) {
	global $bdd;
	
	// *************************************************
	// Controle des données transmises
	$this->lib_site_web = $lib_site_web;
	$this->url 		= $url;
	$this->login 	= $login;
	$this->pass	 	= $pass;
	$this->note		= $note;
	$this->type		= $type;

	// *************************************************
	// Si les valeurs reçues sont incorrectes
	if (count($GLOBALS['_ALERTES'])) {
		return false;
	}

	// *************************************************
	// Insertion dans la base
	$query = "UPDATE sites_web 
						SET lib_site_web = '".addslashes($this->lib_site_web)."', 
								url = '".addslashes($this->url)."', login = '".addslashes($this->login)."', 
								pass = '".addslashes($this->pass)."', note = '".addslashes($this->note)."',
								id_type_site_web = ".num_or_null($this->type)."
						WHERE ref_site = '".$this->ref_site."' ";
	$bdd->exec ($query);
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
	
	// Mise à jour des autres sites
	$query = "UPDATE sites_web
						SET ordre = ordre ".$variation." 1
						WHERE ref_contact = '".$this->ref_contact."' && 
									ordre ".$symbole1." '".$this->ordre."' && ordre ".$symbole2." '".$new_ordre."' ";
	$bdd->exec ($query);
	
	// Mise à jour de cette site
	$query = "UPDATE sites_web
						SET ordre = '".$new_ordre."'
						WHERE ref_site = '".$this->ref_site."'  ";
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
	// Suppression du site
	$query = "DELETE FROM sites_web 
						WHERE ref_site = '".$this->ref_site."' ";
	$bdd->exec ($query);
	
	// Changement de l'ordre des sites suivantes
	$query = "UPDATE sites_web 
						SET ordre = ordre -1
						WHERE ref_contact = '".$this->ref_contact."' && ordre > '".$this->ordre."'";
	$bdd->exec ($query);

	unset ($this);
	return true;
}

// *************************************************************************************************************
// FONCTIONS DIVERSES
// *************************************************************************************************************
// renvois de la ref site en fonction de l'ordre
static function getRef_site_from_ordre ($ref_contact, $ordre) {
	global $bdd;
	
	$site_web = "";
	$query = "SELECT ref_site
							FROM sites_web
						WHERE ref_contact = '".$ref_contact."' 
						AND ordre = ".$ordre." 
						LIMIT 1"	;
	$resultat = $bdd->query ($query);
	if ($site = $resultat->fetchObject()) { $site_web = $site->ref_site; }
	return $site_web;
}

//retourne une liste des ref_site en fonction d'un plage d'ordre (mise à jour de l'affichage des sites)
public function liste_ref_site_in_ordre () {
	global $bdd;
	
	$sites_web = array();
	$query = "SELECT ref_site
						FROM sites_web 
						WHERE ref_contact = '".$this->ref_contact."' 
						&& (ordre> ".$this->ordre." || ordre= ".$this->ordre."-1)";
	$resultat = $bdd->query ($query);
	while ($site = $resultat->fetchObject()) { $sites_web[] = $site; }

	return $sites_web;
}


// *************************************************************************************************************
// FONCTIONS DE LECTURE DES DONNEES 
// *************************************************************************************************************
function getRef_site () {
	return $this->ref_site;
}

function getRef_contact () {
	return $this->ref_contact;
}

function getLib_site_web () {
	return $this->lib_site_web;
}

function getUrl () {
	return $this->url;
}

function getLogin () {
	return $this->login;
}

function getPass () {
	return $this->pass;
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
	$query = "SELECT web_type FROM sites_web_types WHERE id_web_type = '".$this->type."' ";
	$retour = $bdd->query($query);
	if($ret = $retour->fetchObject()){
		return $ret->web_type;
	}
}

}

?>