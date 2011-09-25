<?php
// *************************************************************************************************************
// CLASSE REGISSANT LES INFORMATIONS SUR LES LISTES DE TARIF DE LA SOCIETE
// *************************************************************************************************************


final class tarif_liste {
	private $id_tarif;

	private $lib_tarif;				// Nom de la liste de prix
	private $desc_tarif;			// Description de la liste de prix
	private $marge_moyenne;		// Marge minimum acceptable lors de la vente à un client soumit à cette grille de tarif.

	private $ordre;					// Ordre d'affichage

	
function __construct($id_tarif = 0) {
	global $bdd;

	// Controle si le id_tarif est précisé
	if (!$id_tarif) { return false; }

	// Sélection des informations générales
	$query = "SELECT lib_tarif, desc_tarif, marge_moyenne, ordre
						FROM tarifs_listes tl
						WHERE id_tarif = '".$id_tarif."' ";
	$resultat = $bdd->query ($query);

	// Controle si le id_tarif est trouvé
	if (!$tarif_liste = $resultat->fetchObject()) { return false; }

	// Attribution des informations à l'objet
	$this->id_tarif 			= $id_tarif;
	$this->lib_tarif			= $tarif_liste->lib_tarif;
	$this->desc_tarif			= $tarif_liste->desc_tarif;
	$this->marge_moyenne	= $tarif_liste->marge_moyenne;
	$this->ordre					= $tarif_liste->ordre;

	return true;
}



// *************************************************************************************************************
// FONCTIONS LIEES A LA CREATION D'UNE LISTE DE PRIX 
// *************************************************************************************************************

final public function create ($lib_tarif, $desc_tarif, $marge_moyenne) {
	global $bdd;

	// *************************************************
	// Controle des données transmises
	$this->lib_tarif 	= $lib_tarif;
	if (!$this->lib_tarif) {
		$GLOBALS['_ALERTES']['lib_tarif_vide'] = 1; 
	}
	$this->desc_tarif = $desc_tarif;
	$this->marge_moyenne = $marge_moyenne;
	if (!formule_tarif::check_formule($marge_moyenne)) { 
		$GLOBALS['_ALERTES']['bad_marge_moyenne'] = 1;
	}
	
	// *************************************************
	// Si les valeurs reçues sont incorrectes
	if (count($GLOBALS['_ALERTES'])) {
		return false;
	}

	// Ordre d'affichage
	$query = "SELECT MAX(ordre) ordre FROM tarifs_listes ";
	$resultat = $bdd->query($query);
	$tmp = $resultat->fetchObject();
	$this->ordre = $tmp->ordre+1;
	unset ($query, $resultat, $tmp);

	// *************************************************
	// Insertion dans la base
	$query = "INSERT INTO tarifs_listes (lib_tarif, desc_tarif, marge_moyenne, ordre)
						VALUES ('".addslashes($this->lib_tarif)."', '".addslashes($this->desc_tarif)."', 
										'".$this->marge_moyenne."', '".$this->ordre."')";
	$bdd->exec($query);
	$this->id_tarif = $bdd->lastInsertId();

	// Déclaration pour mise à jour globale du catalogue
	declare_articles_maj ($this->id_tarif, "ADD_TARIF_LISTE");

	// Rechargement des grilles de tarif
	get_tarifs_listes (1);

	//on demande à ce que la session soit mise à jour lors de l'ouverture des prochaines pages
	serveur_maj_file();
	// *************************************************
	// Résultat positif de la création
	$GLOBALS['_INFOS']['Création_tarif_liste'] = $this->id_tarif;

	return true;
}



// *************************************************************************************************************
// FONCTIONS LIEES A LA MODIFICATION D'UNE LISTE DE PRIX
// *************************************************************************************************************

final public function modification ($lib_tarif, $desc_tarif, $marge_moyenne) {
	global $bdd;

	$old_marge_moyenne = $this->marge_moyenne;

	// *************************************************
	// Controle des données transmises
	$this->lib_tarif 	= $lib_tarif;
	if (!$this->lib_tarif) {
		$GLOBALS['_ALERTES']['lib_tarif_vide'] = 1; 
	}
	$this->desc_tarif = $desc_tarif;
	$this->marge_moyenne = $marge_moyenne;
	if (!formule_tarif::check_formule($marge_moyenne)) { 
		$GLOBALS['_ALERTES']['bad_marge_moyenne'] = 1;
	}
	
	// *************************************************
	// Si les valeurs reçues sont incorrectes
	if (count($GLOBALS['_ALERTES'])) {
		return false;
	}

	// *************************************************
	// Mise a jour de la base
	$query = "UPDATE tarifs_listes 
						SET lib_tarif = '".addslashes($this->lib_tarif)."', desc_tarif = '".addslashes($this->desc_tarif)."',
								marge_moyenne = '".$marge_moyenne."'
						WHERE id_tarif = '".$this->id_tarif."' ";
	$bdd->exec ($query);

	if ($old_marge_moyenne != $this->marge_moyenne) {
		// Déclaration pour mise à jour globale du catalogue
		declare_articles_maj ($this->id_tarif, "MAJ_TARIF_LISTE");
	}
	// Rechargement des grilles de tarif
	get_tarifs_listes (1);

	//on demande à ce que la session soit mise à jour lors de l'ouverture des prochaines pages
	serveur_maj_file();
	// *************************************************
	// Résultat positif de la modification
	return true;
}


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
	
	// Mise à jour des autres listes de prix
	$query = "UPDATE tarifs_listes
						SET ordre = ordre ".$variation." 1
						WHERE ordre ".$symbole1." '".$this->ordre."' && ordre ".$symbole2." '".$new_ordre."' ";
	$bdd->exec ($query);
	
	// Mise à jour de cette liste de prix
	$query = "UPDATE tarifs_listes
						SET ordre = '".$new_ordre."' 
						WHERE id_tarif = '".$this->id_tarif."'";
	$bdd->exec ($query);
	
	$bdd->commit();	

	// Rechargement des grilles de tarif
	get_tarifs_listes (1);

	// *************************************************
	// Résultat positif de la modification
	return true;
}



final public function suppression ($id_tarif_remplacement) {
	global $bdd;

	// *************************************************
	// Controles du tarif de substitution
	if ($this->id_tarif == $id_tarif_remplacement) {
		$GLOBALS['_ALERTES']['bad_id_tarif_remplacement'] = 1;
		return false;
	}
	// Controle si le nouveau tarif existe réellement
	$query = "SELECT id_tarif FROM tarifs_listes WHERE id_tarif = '".$id_tarif_remplacement."' ";
	$resultat = $bdd->query ($query);
	if (!$tarif = $resultat->fetchObject()) {
		$GLOBALS['_ALERTES']['bad_id_tarif_remplacement'] = 1;
		return false;
	}

	// *************************************************
	// Suppression de la liste de prix
	$bdd->beginTransaction();

	// Mise à jour des Catégories de Client
	$query = "UPDATE clients_categories SET id_tarif = '".$id_tarif_remplacement."'
						WHERE id_tarif = '".$this->id_tarif."' ";
	$bdd->exec ($query);

	// Mise à jour des Clients
	$query = "UPDATE annu_client SET id_tarif = '".$id_tarif_remplacement."'
						WHERE id_tarif = '".$this->id_tarif."' ";
	$bdd->exec ($query);

	// Mise à jour des Magasin
	$query = "UPDATE magasins SET id_tarif = '".$id_tarif_remplacement."'
						WHERE id_tarif = '".$this->id_tarif."' ";
	$bdd->exec ($query);

	// Suppression du tarif
	$query = "DELETE FROM tarifs_listes 
						WHERE id_tarif = '".$this->id_tarif."' ";
	$bdd->exec ($query);

	// Changement de l'ordre des tarifs suivants
	$query = "UPDATE tarifs_listes 
						SET ordre = ordre -1
						WHERE ordre > '".$this->ordre."'";
	$bdd->exec ($query);

	$bdd->commit();	

	// Rechargement des grilles de tarif
	get_tarifs_listes (1);

	//on demande à ce que la session soit mise à jour lors de l'ouverture des prochaines pages
	serveur_maj_file();
	
	unset ($this);
}


// *************************************************************************************************************
// FONCTIONS DIVERSES
// *************************************************************************************************************

// *************************************************************************************************************
// FONCTIONS DE LECTURE DES DONNEES 
// *************************************************************************************************************
function getId_tarif () {
	return $this->id_tarif;
}

function getLib_tarif () {
	return $this->lib_tarif;
}

function getDesc_tarif () {
 return $this->desc_tarif;
}

function getMarge_moyenne () {
	return $this->marge_moyenne;
}


}
// renvois de l id_tarif en fonction de l'ordre
function getId_tarif_from_ordre ($ordre) {
	global $bdd;
	
	$id_tarif = "";
	$query = "SELECT id_tarif
						FROM tarifs_listes 
						WHERE ordre= ".$ordre." 
						LIMIT 1"	;
	$resultat = $bdd->query ($query);
	if ($tarif = $resultat->fetchObject()) { $id_tarif = $tarif->id_tarif; }
	return $id_tarif;
}
?>