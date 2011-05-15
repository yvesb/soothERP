<?php
// *************************************************************************************************************
// CLASSE REGISSANT LES INFORMATIONS SUR UN MAGASIN DE LA SOCIETE
// *************************************************************************************************************


final class magasin {
	private $id_magasin;

	private $lib_magasin;			// Nom du magasin
	private $abrev_magasin;		// Abréviation du Nom du magasin
	private $id_mag_enseigne;			// Enseigne utilisée
	private $id_stock;				// Stock utilisé
	private $id_tarif;				// Liste de prix par défaut
	private $mode_vente;			// Mode de vente par défaut: VPC ou VAC
	private $actif;						// Magasin actif ?

	private $lib_enseigne;
	private $lib_stock;
	private $ref_adr_stock;


function __construct ($id_magasin = 0, $infos_magasin = NULL) {
	global $bdd;

	// Controle si objet créé depuis une requete
	if (isset($infos_magasin)) {
		$this->charger_from_object($infos_magasin);
		return true;
	}

	// Controle si le id_magasin est précisé
	if (!$id_magasin) { return false; }

	// Sélection des informations générales
	$query = "SELECT m.id_magasin, m.lib_magasin, m.abrev_magasin, m.id_stock, m.id_tarif, m.mode_vente, m.actif,  
									 t.lib_tarif, s.lib_stock, s.ref_adr_stock, 
									 me.id_mag_enseigne, me.lib_enseigne
						FROM magasins m
							LEFT JOIN tarifs_listes t ON m.id_tarif = t.id_tarif
							LEFT JOIN stocks s ON m.id_stock = s.id_stock
							LEFT JOIN magasins_enseignes me ON me.id_mag_enseigne = m.id_mag_enseigne
						WHERE m.id_magasin = '".$id_magasin."'
						ORDER BY m.lib_magasin";
	$resultat = $bdd->query ($query);

	// Controle si le id_magasin est trouvé
	if (!$magasin = $resultat->fetchObject()) { return false; }

	// Attribution des informations à l'objet
	$this->id_magasin 	= $id_magasin;
	$this->lib_magasin	= $magasin->lib_magasin;
	$this->abrev_magasin	= $magasin->abrev_magasin;
	$this->id_mag_enseigne	= $magasin->id_mag_enseigne;
	$this->id_stock			= $magasin->id_stock;
	$this->id_tarif			= $magasin->id_tarif;
	$this->mode_vente		= $magasin->mode_vente;
	$this->actif				= $magasin->actif;
	$this->lib_enseigne		= $magasin->lib_enseigne;
	$this->lib_stock		= $magasin->lib_stock;
	$this->ref_adr_stock	= $magasin->ref_adr_stock;
	$this->lib_tarif		= $magasin->lib_tarif;

	return true;
}


function charger_from_object($magasin) {	
	// Attribution des informations 
	$this->id_magasin 	= $magasin->id_magasin;
	$this->lib_magasin	= $magasin->lib_magasin;
	$this->abrev_magasin= $magasin->abrev_magasin;
	$this->id_mag_enseigne	= $magasin->id_mag_enseigne;
	$this->id_stock			= $magasin->id_stock;
	$this->id_tarif			= $magasin->id_tarif;
	$this->mode_vente		= $magasin->mode_vente;
	$this->actif				= $magasin->actif;

	$this->lib_enseigne		= $magasin->lib_enseigne;
	$this->lib_stock		= $magasin->lib_stock;
	$this->ref_adr_stock	= $magasin->ref_adr_stock;
	$this->lib_tarif		= $magasin->lib_tarif;

	return true;
}

// *************************************************************************************************************
// FONCTIONS LIEES A LA CREATION D'UN MAGASIN
// *************************************************************************************************************

public function create ($lib_magasin, $abrev_magasin, $id_mag_enseigne, $id_stock, $id_tarif, $mode_vente, $actif) {
	global $bdd;
	global $BDD_MODE_VENTE;
	global $DEFAUT_MODE_VENTE;

	// *************************************************
	// Controle des données transmises
	$this->lib_magasin 	= $lib_magasin;
	if (!$this->lib_magasin) { 
		$GLOBALS['_ALERTES']['lib_magasin_vide'] = 1; 
	}
	
	$this->abrev_magasin = $abrev_magasin;
	if (!$this->abrev_magasin) { 
		$this->abrev_magasin = substr($this->lib_magasin , 0, 3);
	}
	
	$this->id_mag_enseigne = $id_mag_enseigne;
	$this->id_stock = $id_stock;
	$this->id_tarif = $id_tarif;
	$this->mode_vente = $mode_vente;
	if (!in_array($this->mode_vente, $BDD_MODE_VENTE)) {
		$this->mode_vente = $DEFAUT_MODE_VENTE;
	}
	$this->actif = $actif;
	// *************************************************
	// Si les valeurs reçues sont incorrectes
	if (count($GLOBALS['_ALERTES'])) {
		return false;
	}


	// *************************************************
	// Insertion dans la base
	$query = "INSERT INTO magasins (lib_magasin, abrev_magasin, id_mag_enseigne, id_stock, id_tarif, mode_vente,  actif)
						VALUES ('".addslashes($this->lib_magasin)."', '".addslashes($this->abrev_magasin)."', '".$this->id_mag_enseigne."', '".$this->id_stock."', '".$id_tarif."', '".$mode_vente."', '".$this->actif."')";
	$bdd->exec($query);
	$this->id_magasin = $bdd->lastInsertId();
	
	//on demande à ce que la session soit mise à jour lors de l'ouverture des prochaines pages
	serveur_maj_file();

	// *************************************************
	// Résultat positif de la création
	$GLOBALS['_INFOS']['Création_magasin'] = $this->id_magasin;

	return true;
}

// *************************************************************************************************************
// FONCTIONS LIEES A LA MODIFICATION D'UN MAGASIN
// *************************************************************************************************************

final public function modification ($lib_magasin, $abrev_magasin, $id_mag_enseigne, $id_stock, $id_tarif, $mode_vente, $actif) {
	global $bdd;
	global $BDD_MODE_VENTE;
	global $DEFAUT_MODE_VENTE;
	
	// *************************************************
	// Controle des données transmises
	$this->lib_magasin 	= $lib_magasin;
	if (!$this->lib_magasin) { 
		$GLOBALS['_ALERTES']['lib_magasin_vide'] = 1; 
	}
	
	$this->abrev_magasin= $abrev_magasin;
	if (!$this->abrev_magasin) { 
		$this->abrev_magasin = substr($this->lib_magasin , 0, 3);
	}
	
	$this->id_mag_enseigne = $id_mag_enseigne;

	// Vérification que le stock est bien actif (si Changement ou si Activation)
	if ( ($id_stock != $this->id_stock) || (!$this->actif && $actif) ) {
		$query = "SELECT actif FROM stocks WHERE id_stock = '".$id_stock."' ";
		$resultat	=	$bdd->query ($query);
		$stock = $resultat->fetchObject();
		if ($stock->actif != 1) {
			$GLOBALS['_ALERTES']['stock_not_actif'] = 1;
			return false;
		}
		$this->id_stock = $id_stock;
	}
	// Vérification que le tarif existe (si Changement ou si Activation)
	if ( ($id_tarif != $this->id_tarif) || (!$this->actif && $actif) ) {
		$query = "SELECT id_tarif FROM tarifs_listes WHERE id_tarif = '".$id_tarif."' ";
		$resultat = $bdd->query ($query);
		if (!$tarif = $resultat->fetchObject()) {
			$GLOBALS['_ALERTES']['tarif_not_existing'] = 1;
			return false;
		}
		$this->id_tarif = $id_tarif;
	}
	$this->mode_vente = $mode_vente;
	if (!in_array($this->mode_vente, $BDD_MODE_VENTE)) {
		$this->mode_vente = $DEFAUT_MODE_VENTE;
	}
	
	// Controle si Inactivation du magasin que ce ne soit pas le seul actif
	if ($this->actif && !$actif) {
		$query = "SELECT COUNT(id_magasin) nb_magasins FROM magasins WHERE actif = 1 ";
		$resultat	=	$bdd->query ($query);
		$magasin = $resultat->fetchObject();
		if ($magasin->nb_magasins <= 1) {
			$GLOBALS['_ALERTES']['last_active_magasin'] = 1;
			return false;
		}
	}
	// Controle si Inactivation du magasin que les caisses soient inactives
	if ($this->actif && !$actif) {
		$query = "SELECT COUNT(id_compte_caisse) nb_caisses FROM comptes_caisses WHERE id_magasin = '".$this->id_magasin."' && actif = 1 ";
		$resultat	=	$bdd->query ($query);
		$caisses = $resultat->fetchObject();
		if ($caisses->nb_caisses > 0) {
			$GLOBALS['_ALERTES']['active_magasin_caisses'] = 1;
			return false;
		}
	}
	$this->actif = $actif;


	// *************************************************
	// Si les valeurs reçues sont incorrectes
	if (count($GLOBALS['_ALERTES'])) {
		return false;
	}


	// *************************************************
	// Mise a jour de la base
	$query = "UPDATE magasins 
						SET lib_magasin = '".addslashes($this->lib_magasin)."', abrev_magasin = '".addslashes($this->abrev_magasin)."', id_mag_enseigne = '".addslashes($this->id_mag_enseigne)."', id_stock = '".addslashes($this->id_stock)."',
								id_tarif = '".addslashes($id_tarif)."', mode_vente = '".$this->mode_vente."', actif = '".$this->actif."'
						WHERE id_magasin = '".$this->id_magasin."' ";
	$bdd->exec ($query);

	//on demande à ce que la session soit mise à jour lors de l'ouverture des prochaines pages
	serveur_maj_file();
	// *************************************************
	// Résultat positif de la modification
	return true;
}


//ajout d'une enseigne
static function create_enseigne ($lib_enseigne) {
	global $bdd;
	
	if (!$lib_enseigne) { 
		$GLOBALS['_ALERTES']['lib_enseigne_vide'] = 1; 
	}
	// *************************************************
	// Si les valeurs reçues sont incorrectes
	if (count($GLOBALS['_ALERTES'])) {
		return false;
	}
	
	$query = "INSERT INTO magasins_enseignes (lib_enseigne)
							VALUES ('".addslashes($lib_enseigne)."')";
	$bdd->exec($query);
	
	return true;
}

//modification d'une enseigne
static function modifier_enseigne ($id_mag_enseigne, $lib_enseigne) {
	global $bdd;
	
	if (!$lib_enseigne) { 
		$GLOBALS['_ALERTES']['lib_enseigne_vide'] = 1; 
	}
	// *************************************************
	// Si les valeurs reçues sont incorrectes
	if (count($GLOBALS['_ALERTES'])) {
		return false;
	}
	
	$query = "UPDATE magasins_enseignes SET lib_enseigne = '".addslashes($lib_enseigne)."'
						WHERE id_mag_enseigne = '".$id_mag_enseigne."' ";
	$bdd->exec($query);
	
	return true;
}
//suppression d'une enseigne
static function supprimer_enseigne ($id_mag_enseigne) {
	global $bdd;
	
	// *************************************************
	// Si les valeurs reçues sont incorrectes
	if (count($GLOBALS['_ALERTES'])) {
		return false;
	}
	
	$query = "DELETE FROM magasins_enseignes 
						WHERE id_mag_enseigne = '".$id_mag_enseigne."' ";
	$bdd->exec($query);
	
	return true;
}


// *************************************************************************************************************
// FONCTIONS DE LECTURE DES DONNEES 
// *************************************************************************************************************
function getId_magasin () {
	return $this->id_magasin;
}

function getLib_magasin () {
	return $this->lib_magasin;
}

function getAbrev_magasin () {
	return $this->abrev_magasin;
}

function getId_mag_enseigne () {
 return $this->id_mag_enseigne;
}

function getId_stock () {
 return $this->id_stock;
}

function getId_tarif () {
	return $this->id_tarif;
}

function getMode_vente () {
	return $this->mode_vente;
}

function getActif () {
	return $this->actif;
}


function getLib_tarif () {
	return $this->lib_tarif;
}

function getLib_enseigne () {
	return $this->lib_enseigne;
}

function getLib_stock () {
	return $this->lib_stock;
}

function getRef_adr_stock () {
	return $this->ref_adr_stock;
}


}

//liste des magasins
function charger_all_magasins () {
	global $bdd;
	
	$magasins_liste	= array();
	$query = "SELECT id_magasin, lib_magasin, abrev_magasin, m.id_mag_enseigne, id_stock, id_tarif, mode_vente, actif, me.lib_enseigne
							FROM magasins m
							LEFT JOIN magasins_enseignes me ON me.id_mag_enseigne = m.id_mag_enseigne
						ORDER BY actif DESC, lib_magasin ASC";
	$resultat = $bdd->query ($query);
	while ($magasin = $resultat->fetchObject()) { $magasins_liste[] = $magasin; }
	
	return $magasins_liste;
}

//liste des enseignes
function charger_all_enseignes () {
	global $bdd;
	
	$mag_enseignes_liste	= array();
	$query = "SELECT id_mag_enseigne, lib_enseigne
							FROM magasins_enseignes 
						ORDER BY  id_mag_enseigne ASC";
	$resultat = $bdd->query ($query);
	while ($enseigne = $resultat->fetchObject()) { $mag_enseignes_liste[] = $enseigne; }
	
	return $mag_enseignes_liste;
}
?>