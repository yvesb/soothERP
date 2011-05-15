<?php
// *************************************************************************************************************
// CLASSE REGISSANT LES INFORMATIONS GENERIQUE SUR UN PROFIL D'UTILISATEUR 
// *************************************************************************************************************
// Les classes de profils sont dérivées de celle-ci.


class profil {
	private $id_profil;

	private $lib_profil;
	private $code_profil;

	private $ordre;
	private $actif;
	private $niveau_secu;

	private $defaut_id_interface;						// Interface par défaut pour ce profil

	private $desc_publique;
	private $desc_interne;

	private $ref_user;
	private $ref_contact;


function __construct ($profil) {

	// Informations générales
	if (get_class($profil) == "stdClass") {
		// Il s'agit d'un objet issue d'une requete.
		$this->id_profil 			= $profil->id_profil;
		$this->lib_profil 		= $profil->lib_profil;
		$this->code_profil 		= $profil->code_profil;
		$this->ordre 					= $profil->ordre;
		$this->actif 					= $profil->actif;
		$this->niveau_secu 		= $profil->niveau_secu;
		$this->defaut_id_interface 	= $profil->defaut_id_interface;
	}
	else {
		// Il s'agit déjà d'un objet de classe "profil"
		$this->id_profil 			= $profil->getId_profil();
		$this->lib_profil 		= $profil->getLib_profil();
		$this->code_profil 		= $profil->getCode_profil();
		$this->ordre			 		= $profil->getOrdre();
		$this->actif 					= $profil->getActif();
		$this->niveau_secu		= $profil->getNiveau_secu();
		$this->defaut_id_interface 	= $profil->getDefaut_id_interface();
	}

	return true;
}




// *************************************************************************************************************
// Fonctions de modification
// *************************************************************************************************************
static public function maj_profil ($infos) {
	global $bdd;

	$query = "UPDATE profils 
 						SET actif = '".$infos['actif']."', niveau_secu = '".$infos['niveau_secu']."'
						WHERE id_profil = '".$infos['id_profil']."' ";
	$bdd->exec ($query);

	//on demande à ce que la session soit mise à jour lors de l'ouverture des prochaines pages
	serveur_maj_file();
	
	return true;
}



// *************************************************************************************************************
// Fonctions de réception de données supplémentaires
// *************************************************************************************************************
function set_user ($ref_user, $ref_contact) {
	$this->ref_user 		= $ref_user;
	$this->ref_contact	= $ref_contact;
}


// *************************************************************************************************************
// Fonctions d'accès aux données
// *************************************************************************************************************

// Retourne l'identifiant du profil
final public function getId_profil () {
	return $this->id_profil;
}

// Retourne le code du profil
final public function getCode_profil () {
	return $this->code_profil;
}

// Retourne le code du profil
final public function getDir_profil () {
	return "profil_".$this->code_profil."/";
}

// Retourne le libellé du profil
final public function getLib_profil () {
	return $this->lib_profil;
}

// Retourne le niveau d'acivité du profil
final public function getOrdre () {
	return $this->ordre;
}

// Retourne le niveau d'acivité du profil
final public function getActif () {
	return $this->actif;
}

// Retourne le niveau de sécurité demandé pour ce profil
final public function getNiveau_secu () {
	return $this->niveau_secu;
}

// Retourne l'interface par défaut
final public function getDefaut_id_interface() {
	return $this->defaut_id_interface;
}



}


//fonction retournant la liste de tous les profils
function getAll_profils () {
	global $bdd;
	
	$profils_liste	= array();
	$query = "SELECT id_profil, lib_profil, actif, niveau_secu, ordre, defaut_id_interface
						FROM profils
						ORDER BY lib_profil ASC";
	$resultat = $bdd->query ($query);
	while ($profils = $resultat->fetchObject()) { $profils_liste[] = $profils; }
	return $profils_liste;
}


function getLibProfil($id_profil){
	global $bdd;
	$query = "SELECT lib_profil FROM profils WHERE id_profil = '" . $id_profil . "';";
	$res = $bdd->query($query);
	return $res->fetchObject()->lib_profil;
} 
?>
