<?php
// *************************************************************************************************************
// CLASSE REGISSANT LES INFORMATIONS SUR LES LISTES DE COMMISSIONS DES COMMERCIAUX
// *************************************************************************************************************


final class commission_liste {
	private $id_commission_regle;

	private $lib_comm;				// Nom de la liste de prix
	private $desc_comm;			// Description de la liste de prix
	private $formule_comm;		// Marge minimum acceptable lors de la vente à un client soumit à cette grille de comm.

	private $defaut;					// defaut d'affichage

	
function __construct($id_commission_regle = 0) {
	global $bdd;

	// Controle si le id_commission_regle est précisé
	if (!$id_commission_regle) { return false; }

	// Sélection des informations générales
	$query = "SELECT lib_comm,  formule_comm, defaut
						FROM commissions_regles cr
						WHERE id_commission_regle = '".$id_commission_regle."' ";
	$resultat = $bdd->query ($query);

	// Controle si le id_commission_regle est trouvé
	if (!$comm_liste = $resultat->fetchObject()) { return false; }

	// Attribution des informations à l'objet
	$this->id_commission_regle 	= $id_commission_regle;
	$this->lib_comm							= $comm_liste->lib_comm;
	$this->formule_comm					= $comm_liste->formule_comm;
	$this->defaut								= $comm_liste->defaut;

	return true;
}



// *************************************************************************************************************
// FONCTIONS LIEES A LA CREATION D'UNE LISTE DE PRIX 
// *************************************************************************************************************

final public function create ($lib_comm, $formule_comm) {
	global $bdd;

	// *************************************************
	// Controle des données transmises
	$this->lib_comm 	= $lib_comm;
	if (!$this->lib_comm) {
		$GLOBALS['_ALERTES']['lib_comm_vide'] = 1; 
	}
	
	$this->formule_comm = $formule_comm;
	if (!formule_comm::check_formule($formule_comm) || !$formule_comm) { 
		$GLOBALS['_ALERTES']['bad_formule_comm'] = 1;
	}
	
	// *************************************************
	// Si les valeurs reçues sont incorrectes
	if (count($GLOBALS['_ALERTES'])) {
		return false;
	}
	
	$this->defaut = 0;
	
	// *************************************************
	// Insertion dans la base
	$query = "INSERT INTO commissions_regles (lib_comm,  formule_comm, defaut)
						VALUES ('".addslashes($this->lib_comm)."', '".$this->formule_comm."', '".$this->defaut."')";
	$bdd->exec($query);
	$this->id_commission_regle = $bdd->lastInsertId();


	// *************************************************
	// Résultat positif de la création
	$GLOBALS['_INFOS']['Création_comm_liste'] = $this->id_commission_regle;

	return true;
}



// *************************************************************************************************************
// FONCTIONS LIEES A LA MODIFICATION D'UNE GRILLE DE COMMISSION
// *************************************************************************************************************

final public function modification ($lib_comm, $formule_comm) {
	global $bdd;

	$old_formule_comm = $this->formule_comm;

	// *************************************************
	// Controle des données transmises
	$this->lib_comm 	= $lib_comm;
	if (!$this->lib_comm) {
		$GLOBALS['_ALERTES']['lib_comm_vide'] = 1; 
	}
	
	$this->formule_comm = $formule_comm;
	if (!formule_comm::check_formule($formule_comm) || !$formule_comm ) { 
		$GLOBALS['_ALERTES']['bad_formule_comm'] = 1;
	}
	
	// *************************************************
	// Si les valeurs reçues sont incorrectes
	if (count($GLOBALS['_ALERTES'])) {
		return false;
	}

	// *************************************************
	// Mise a jour de la base
	$query = "UPDATE commissions_regles 
						SET lib_comm = '".addslashes($this->lib_comm)."', formule_comm = '".$formule_comm."'
						WHERE id_commission_regle = '".$this->id_commission_regle."' ";
	$bdd->exec ($query);

	// *************************************************
	// Résultat positif de la modification
	return true;
}


final public function suppression ($id_commission_regle_remplacement) {
	global $bdd;

	// *************************************************
	// Controles du comm de substitution
	if ($this->id_commission_regle == $id_commission_regle_remplacement) {
		$GLOBALS['_ALERTES']['bad_id_commission_regle_remplacement'] = 1;
		return false;
	}
	// Controle si le nouveau comm existe réellement
	$query = "SELECT id_commission_regle, defaut FROM commissions_regles WHERE id_commission_regle = '".$id_commission_regle_remplacement."' ";
	$resultat = $bdd->query ($query);
	if (!$comm = $resultat->fetchObject()) {
		$GLOBALS['_ALERTES']['bad_id_commission_regle_remplacement'] = 1;
		return false;
	}

	// *************************************************
	// Suppression de la comm
	$bdd->beginTransaction();
	
	//la grille par defaut est transmise vers la nouvelle régle
	if ($this->defaut) {
	$query = "UPDATE commissions_regles SET defaut = '".$this->defaut."'
						WHERE id_commission_regle = '".$id_commission_regle_remplacement."' ";
	$bdd->exec ($query);
	}
	
	// Mise à jour des commerciaux et des groupes
	$query = "UPDATE annu_commercial SET id_commission_regle = '".$id_commission_regle_remplacement."'
						WHERE id_commission_regle = '".$this->id_commission_regle."' ";
	$bdd->exec ($query);
	
	$query = "UPDATE commerciaux_categories SET id_commission_regle = '".$id_commission_regle_remplacement."'
						WHERE id_commission_regle = '".$this->id_commission_regle."' ";
	$bdd->exec ($query);
	
	// Suppression du comm
	$query = "DELETE FROM commissions_regles 
						WHERE id_commission_regle = '".$this->id_commission_regle."' ";
	$bdd->exec ($query);

	$bdd->commit();	

	unset ($this);
}


// *************************************************************************************************************
// FONCTIONS DIVERSES
// *************************************************************************************************************
static function add_form_comm_art_categ ($id_commission_regle, $ref_art_categ, $formule_comm) {
	global $bdd;
	
	if (!formule_comm::check_formule($formule_comm) || !$formule_comm ) { 
		$GLOBALS['_ALERTES']['bad_formule_comm'] = 1;
	}
	
	// *************************************************
	// Si les valeurs reçues sont incorrectes
	if (count($GLOBALS['_ALERTES'])) {
		return false;
	}

	// *************************************************
	// Insertion dans la base
	$query = "INSERT INTO commissions_art_categ (id_commission_regle, ref_art_categ,  formule_comm)
						VALUES ('".$id_commission_regle."', '".$ref_art_categ."', '".$formule_comm."')";
	$bdd->exec($query);
	$query;
	
	return true;
	
}

static function mod_form_comm_art_categ ($id_commission_regle, $ref_art_categ, $formule_comm) {
	global $bdd;
	
	if (!formule_comm::check_formule($formule_comm) || !$formule_comm ) { 
		$GLOBALS['_ALERTES']['bad_formule_comm'] = 1;
	}
	
	// *************************************************
	// Si les valeurs reçues sont incorrectes
	if (count($GLOBALS['_ALERTES'])) {
		return false;
	}

	// *************************************************
	// Insertion dans la base
	$query = "UPDATE commissions_art_categ
						SET formule_comm = '".$formule_comm."'
						WHERE id_commission_regle = '".$id_commission_regle."' && ref_art_categ ='".$ref_art_categ."' ";
	$bdd->exec($query);
	return true;
	
}

static function del_form_comm_art_categ ($id_commission_regle, $ref_art_categ) {
	global $bdd;
	
	// *************************************************
	// Si les valeurs reçues sont incorrectes
	if (count($GLOBALS['_ALERTES'])) {
		return false;
	}

	// *************************************************
	// Insertion dans la base
	$query = "DELETE FROM commissions_art_categ
						WHERE id_commission_regle = '".$id_commission_regle."' && ref_art_categ ='".$ref_art_categ."' ";
	$bdd->exec($query);
	return true;
	
}
static function add_form_comm_article ($id_commission_regle, $ref_article, $formule_comm) {
	global $bdd;
	
	if (!formule_comm::check_formule($formule_comm) || !$formule_comm ) { 
		$GLOBALS['_ALERTES']['bad_formule_comm'] = 1;
	}
	
	// *************************************************
	// Si les valeurs reçues sont incorrectes
	if (count($GLOBALS['_ALERTES'])) {
		return false;
	}

	// *************************************************
	// Insertion dans la base
	$query = "INSERT INTO commissions_articles (id_commission_regle, ref_article,  formule_comm)
						VALUES ('".$id_commission_regle."', '".$ref_article."', '".$formule_comm."')";
	$bdd->exec($query);
	$query;
	
	return true;
	
}

static function mod_form_comm_article ($id_commission_regle, $ref_article, $formule_comm) {
	global $bdd;
	
	if (!formule_comm::check_formule($formule_comm) || !$formule_comm ) { 
		$GLOBALS['_ALERTES']['bad_formule_comm'] = 1;
	}
	
	// *************************************************
	// Si les valeurs reçues sont incorrectes
	if (count($GLOBALS['_ALERTES'])) {
		return false;
	}

	// *************************************************
	// Insertion dans la base
	$query = "UPDATE commissions_articles
						SET formule_comm = '".$formule_comm."'
						WHERE id_commission_regle = '".$id_commission_regle."' && ref_article ='".$ref_article."' ";
	$bdd->exec($query);
	return true;
	
}

static function del_form_comm_article ($id_commission_regle, $ref_article) {
	global $bdd;
	
	// *************************************************
	// Si les valeurs reçues sont incorrectes
	if (count($GLOBALS['_ALERTES'])) {
		return false;
	}

	// *************************************************
	// Insertion dans la base
	$query = "DELETE FROM commissions_articles
						WHERE id_commission_regle = '".$id_commission_regle."' && ref_article ='".$ref_article."' ";
	$bdd->exec($query);
	return true;
	
}


// *************************************************************************************************************
// FONCTIONS DE LECTURE DES DONNEES 
// *************************************************************************************************************
function getId_commission_regle () {
	return $this->id_commission_regle;
}

function getLib_comm () {
	return $this->lib_comm;
}

function getFormule_comm () {
	return $this->formule_comm;
}


}

function charger_liste_commerciaux () {
	global $bdd;
	
	$liste_commerciaux = array();	
	$query = "SELECT ac.ref_contact, ac.id_commercial_categ, ac.id_commission_regle,
									 cr.lib_comm, cr.formule_comm,
									 cc.lib_commercial_categ,
									 a.nom
					FROM  annu_commercial ac
					LEFT JOIN commissions_regles cr ON cr.id_commission_regle = ac.id_commission_regle
					LEFT JOIN commerciaux_categories cc ON cc.id_commercial_categ = ac.id_commercial_categ
					LEFT JOIN annuaire a ON a.ref_contact = ac.ref_contact
					
					";	
	$resultat = $bdd->query ($query);
	while ($comm = $resultat->fetchObject()) {
		$liste_commerciaux[] = $comm;
	}
	
	return $liste_commerciaux;
}


function article_formule_comm ($ref_article, $ref_art_categ, $id_commission_regle) {
	global $bdd;

	$query = " SELECT ca.formule_comm 
							FROM commissions_articles   ca 
							WHERE ca.ref_article = '".$ref_article."' && ca.id_commission_regle = '".$id_commission_regle."' 
							 ";
	$resultat = $bdd->query ($query);
	if ($art_form = $resultat->fetchObject()) { return $art_form->formule_comm;}
	
	$query_categ = " SELECT cac.formule_comm 
							FROM commissions_art_categ   cac
							WHERE cac.ref_art_categ = '".$ref_art_categ."' && cac.id_commission_regle = '".$id_commission_regle."' 
							 ";
	$resultat_categ = $bdd->query ($query_categ);
	if ($art_categ_form = $resultat_categ->fetchObject()) { return $art_categ_form->formule_comm;}
	
	return false;
}
?>