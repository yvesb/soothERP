<?php
// *************************************************************************************************************
// CLASSE REGISSANT LES INFORMATIONS SUR UN MODE DE LIVRAISON
// *************************************************************************************************************


final class code_promo {
	private $id_code_promo;			// Identifiant du mode de livraison
	private $ref_article;
	private $article;
	
	private $code;
	private $pourcentage;
	private $actif;


function __construct($id_code_promo = "") {
	global $bdd;

	if ($id_code_promo) {

		// Sélection des informations générales
		$query = "SELECT id_code_promo, ref_article, code, pourcentage, actif
							FROM codes_promo 
							WHERE id_code_promo = '".$id_code_promo."'";
		$resultat = $bdd->query ($query);
	
		// Controle si la id_art_modele est trouvée
		if ($code_promo = $resultat->fetchObject()) { 
	
			// Attribution des informations à l'objet
			$this->id_code_promo 				= $id_code_promo;
			$this->ref_article					= $code_promo->ref_article;
			$this->article						= new article($this->ref_article);
		
			$this->code							= $code_promo->code;
			$this->pourcentage					= $code_promo->pourcentage;
			$this->actif						= ($code_promo->actif)? true : false;
		}
	}
	
}


function create($lib_code_promo, $code, $pourcentage) {
	global $bdd;
	global $CODE_PROMO_ART_CATEG;
	global $MODELE_SPE_CODE_PROMO;

	if (!$lib_code_promo) {
		$GLOBALS['_ALERTES']['lib_code_promo_vide'] = 1;
	}
	if (!$code) {
		$GLOBALS['_ALERTES']['code_non_numeric'] = 1;
	}
	if (!is_numeric($pourcentage)) {
		$GLOBALS['_ALERTES']['pourcentage_vide'] = 1;
	}
	
	// *************************************************
	// Si les valeurs reçues sont incorrectes
	if (count($GLOBALS['_ALERTES'])) {
		return false;
	}

	//verification d'un art_categ définie par défaut pour le code promo
	if (!$CODE_PROMO_ART_CATEG) {
		$CODE_PROMO_ART_CATEG = $this->check_art_categ_code_promo_exist ();
	}
	
	//création de l'article
	$stocks_alertes = array();
	$code_barre = array();
	$infos_generales['modele']	=	"service";
	$infos_modele = array();

	$infos_generales['ref_art_categ'] 		= $CODE_PROMO_ART_CATEG;
	$infos_generales['lib_article'] 			= trim($lib_code_promo);
	$infos_generales['lib_ticket']				= "";
	$infos_generales['desc_courte'] 			= "";
	$infos_generales['desc_longue'] 			= "";
	$infos_generales['ref_interne'] 			= "";
	$infos_generales['ref_oem'] 					= "";
	$infos_generales['ref_constructeur'] 	= "";
	$infos_generales['variante'] 					= "";
	$infos_generales['id_valo'] 					= 1;
	$infos_generales['valo_indice'] 			= 1;
	$infos_generales['lot'] 							= 0;
	$infos_generales['gestion_sn'] 				= 0;
	$infos_generales['code_barre'] 				= $code_barre;
	$infos_generales['id_tva']						=	"";
	$infos_generales['tva'] 							= "";
	
	$infos_generales['date_debut_dispo'] 	= date("Y-m-d");;
	$infos_generales['date_fin_dispo'] 		= "2200/01/01";
	
	$infos_generales['prix_public_ht']	=	0;
	$infos_generales['prix_achat_ht']	= 0;			
	$infos_generales['paa_ht']	=	0;
	
	$formules_tarifs	=	array();
	$caracs	=	array();
	$liaisons	=	array();
	$composants	=	array();

	$this->article = new article ();
	$this->article->create($infos_generales, $infos_modele, $caracs, $formules_tarifs, $composants, $liaisons);
	$this->article->maj_article_modele_spe ($MODELE_SPE_CODE_PROMO);
	
	//création du code promo
	$query = "INSERT INTO codes_promo (ref_article, code, pourcentage )
						VALUES ('".$this->article->getRef_article()."', '".addslashes($code)."', '".$pourcentage."') ";
	$bdd->exec ($query);

	return true;
	
}



function modifier($lib_code_promo, $code, $pourcentage, $actif) {
	global $bdd;
	global $CODE_PROMO_MODE_ART_CATEG;
	global $MODELE_SPE_CODE_PROMO;
	global $CODE_PROMO_ART_CATEG;


	if (!$lib_code_promo) {
		$GLOBALS['_ALERTES']['lib_code_promo_vide'] = 1;
	}
	if (!is_numeric($pourcentage)) {
		$GLOBALS['_ALERTES']['pourcentage_non_numeric'] = 1;
	}
	if (!$code) {
		$GLOBALS['_ALERTES']['code_vide'] = 1;
	}
	// *************************************************
	// Si les valeurs reçues sont incorrectes
	if (count($GLOBALS['_ALERTES'])) {
		return false;
	}
	
	//verification d'un art_categ définie par défaut pour le code promo
	if (!$CODE_PROMO_ART_CATEG) {
		$CODE_PROMO_ART_CATEG = $this->check_art_categ_code_promo_exist ();
	}
	
	//mise à jour de l'article associé
	$infos_generales = array();
	$infos_generales['lib_article'] 			= trim($lib_code_promo);
	$infos_generales['lib_ticket']				= "";
	$infos_generales['ref_constructeur'] 	= "";

	$this->article->maj_art_spe($infos_generales);
	
	//mise a jour du code promo
	$query = "UPDATE codes_promo 
					SET code = '$code',
					pourcentage = '$pourcentage',
					actif = '".(($actif)?1:0)."'
				WHERE id_code_promo = ".$this->getId_code_promo()." ;";
	echo $query;
	$bdd->exec ($query);
	
	return true;
	
}

function supprimer() {
	global $bdd;
	
	$this->article->stop_article();
	
	$query = "DELETE FROM codes_promo 
						WHERE  id_code_promo = '".$this->getId_code_promo()."'  ";
	echo $query;
	$bdd->exec ($query);

	return true;
	
}

// *************************************************************************************************************
// FONCTIONS DIVERSES
// *************************************************************************************************************

function check_art_categ_code_promo_exist () {
	global $bdd;
	global $DIR;
	global $DEFAUT_ID_TVA;
	global $CODE_PROMO_ART_CATEG;
	global $MODELE_SPE_CODE_PROMO;

	$query = "SELECT ref_art_categ, lib_art_categ, modele, id_modele_spe, desc_art_categ, defaut_id_tva, duree_dispo, 
										defaut_numero_compte_vente, defaut_numero_compte_achat, ref_art_categ_parent
						FROM art_categs ac
						WHERE id_modele_spe = '".$CODE_PROMO_ART_CATEG."' ";
	$resultat = $bdd->query ($query);
	
	// Controle si la ref_art_categ est trouvée
	if (!$art_categ = $resultat->fetchObject()) { 
		//on cré alors la ref_art_categ
		
		$lib_art_categ				= "Codes promo";
		$modele 							= "service";
		$desc_art_categ				= "";
		$ref_art_categ_parent	=	"";
		$defaut_id_tva_art				=	"";
		
		$duree_dispo 					= 0;
		
		// *************************************************
		// Création de la catégorie
		$art_categ = new art_categ ();
		$art_categ->create ($lib_art_categ, $desc_art_categ, $ref_art_categ_parent, $modele, $defaut_id_tva_art, $duree_dispo);
		$art_categ->maj_art_categ_modele_spe ($MODELE_SPE_CODE_PROMO);
		
		$CODE_PROMO_ART_CATEG = $art_categ->getRef_art_categ();
		//mise à jour de la vairable systeme
		maj_configuration_file ("config_systeme.inc.php", "maj_line", "\$CODE_PROMO_ART_CATEG =", "\$CODE_PROMO_ART_CATEG = \"".$art_categ->getRef_art_categ()."\";", $DIR."config/");
	}
		
	return $CODE_PROMO_ART_CATEG;

}

//mise a jour de la remise
public function insert_code_promo_in_doc($document) {
	
    $lines = $document->getContenu();
    foreach($lines as $line){
        if( $line->type_of_line == 'article'){
            $document->maj_line_remise($line->ref_doc_line , $this->getPourcentage() );
        }
    }
}

//calcul de la valeur de code promo sur le document 
public function calcul_code_promo($document){
	global $bdd;
		
	$valeur_promo = 0;
	$valeur_promo = -($document->getMontant_ttc()*$this->pourcentage)/100;
	
	return $valeur_promo;

}


// *************************************************************************************************************
// FONCTIONS DE LECTURE DES DONNEES 
// *************************************************************************************************************
public function getId_code_promo () {
	return $this->id_code_promo;
}

public function getRef_article () {
	return $this->ref_article;
}

public function &getArticle () {
	return $this->article;
}

public function getCode () {
	return $this->code;
}

public function getPourcentage () {
	return $this->pourcentage;
}

/**
 * @return boolean
 */
public function isActif () {
	return $this->actif;
}


public static function &charger_codes_promo () {	
	global $bdd;

	$liste_codes_promo = array();
	// Sélection des informations générales
	$query = "SELECT id_code_promo
						FROM codes_promo 
						 ";
	$resultat = $bdd->query ($query);

	// Controle si la id_art_modele est trouvée
	while ($code_promo = $resultat->fetchObject()) { 
		$liste_codes_promo[] = new code_promo($code_promo->id_code_promo);
	}
	return $liste_codes_promo;
}

public static function getCode_promo($code){
	global $bdd;

	$query = "SELECT id_code_promo
						FROM codes_promo 
				WHERE code = '".addslashes($code)."' AND actif = '1'";
	$resultat = $bdd->query ($query);
	if(is_object($resultat) && $code_promo = $resultat->fetchObject()){
		return new code_promo($code_promo->id_code_promo);
	}
	return null;
}

}

?>
