<?php
// *************************************************************************************************************
// CLASSE REGISSANT LES INFORMATIONS SUR UNE FORMULE DE TARIF 
// *************************************************************************************************************


final class formule_comm {
	public $formule;

function __construct($formule = "") {
	$this->formule = str_replace(",", ".", $formule);

	return true;
}


function __toString () {
	return $this->formule;
}



// *************************************************************************************************************
// CALCUL DE  LA COMMISSION D'APRES UNE FORMULE
// *************************************************************************************************************
function calcul_commission ($CA, $Mg) {
	global $CALCUL_TARIFS_NB_DECIMALS;


	// *************************************************
	// Recherche de la première partie : CA
	preg_match('#([0-9\.]*)%CA\+([0-9\.]*)%Mg#i', $this->formule, $result);

	$pc_CA = $result[1]; 
	// Recherche de la Mg
	$pc_Mg 	= $result[2]; 

	$commission_ca = $CA*($pc_CA/100);
	$commission_mg = $Mg*($pc_Mg/100);

	$commission = $commission_ca + $commission_mg;
	
	return $commission;
}



// *************************************************************************************************************
// FONCTIONS DE VERIFICATION ET DE RECEPTION
// *************************************************************************************************************
// Réception d'un formulaire pour créer la formule correspondante
static function recept_formule ($reponses, $valeures) {
	$formule = "";

	// Remplacement des , par des . pour que PHP calcul bien.
	for ($i=0; $i<count($valeures); $i++) {
		if (!isset($valeures[$i])) { continue; }
		$valeures[$i] = str_replace(",", ".", $valeures[$i]);
	}
	
	// Vérification de la validité des réponses
	if (!in_array($reponses[2], array("CDC","FAC","RGM"))) 				{ $GLOBALS['_ALERTES']['bad_reponse_2'] = 1; }

	// Vérification de la validité des valeures
	if (isset($valeures[1]) && !is_numeric($valeures[1])) 				{ $GLOBALS['_ALERTES']['bad_valeur_1'] = 1; }
	if (isset($valeures["1a"]) && !is_numeric($valeures["1a"])) 				{ $GLOBALS['_ALERTES']['bad_valeur_1a'] = 1; }


	if (isset($valeures[1])  && $valeures[1] >= 100) { $GLOBALS['_ALERTES']['bad_valeur_1']	= 1; }
	
	// *************************************************
	// Si les valeurs reçues sont incorrectes
	if (count($GLOBALS['_ALERTES'])) { 
		return false;
	}

	// *************************************************
	// Création de la formule a partir des réponses
	$formule = $valeures[1]."%".$reponses[1]."+".$valeures["1a"]."%".$reponses["1a"];

	
	$formule .= "(".$reponses[2].")";
  

	/* Quelques exemples de resultats :
	15%CA(CDC)
	20%Mg(RGM)	
	*/
	
	return $formule;
}



// Vérifie la formule de comm
static function check_formule ($formule) {
	if (!$formule) {return false;}
	return true;
}


}

?>