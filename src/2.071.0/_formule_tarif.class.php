<?php
// *************************************************************************************************************
// CLASSE REGISSANT LES INFORMATIONS SUR UNE FORMULE DE TARIF 
// *************************************************************************************************************


final class formule_tarif {
	public $formule;
	public $tarifs;
	

function __construct($formule = "") {
	$this->formule = str_replace(",", ".", $formule);

	return true;
}


function __toString () {
	return $this->formule;
}



// *************************************************************************************************************
// CALCUL DU TARIF D'APRES UNE FORMULE
// *************************************************************************************************************
function calcul_tarif_article ($qte, $PA, $PP, $tva) {
	global $CALCUL_TARIFS_NB_DECIMALS;

	if ($qte <= 0) { $qte = 1; }

	// *************************************************
	// Recherche de la première partie : Résultat du calcul
	$debut 	= 0;
	$fin 		= strpos($this->formule, "=");
	$resultat = substr($this->formule, $debut, $fin); 

	// Recherche de l'utilisation ou non d'une formule
	$debut 	= strpos($this->formule, "=") + 1;
	$fin = strlen ($this->formule);
	if (strpos($this->formule, "[")) { $fin = strpos($this->formule, "[") - strpos($this->formule, "=") - 1; }
	$formule 	= substr($this->formule, $debut, $fin); 

	// Recherche de l'arrondi
	$debut 	= strpos($this->formule, "[") + 1;
	$fin = 0;
	if ($debut != 1) { $fin = strpos($this->formule, "]") - strpos($this->formule, "[") - 1; }
	$arrondi 	= substr($this->formule, $debut, $fin);

	// *************************************************
	// Calcul d'un tarif (celui défini par la formule)
	if (is_numeric($formule)) {
		// Défini arbritrairement
		$tarif[$resultat] = $formule;
	}
	else {
		// Calculé
		$base = substr ($formule, 0, 2);
		if (substr($resultat, 3, strlen($resultat)) == "TTC") {
			${$base} *= (1+$tva/100);
		}
		
		if (strpos($formule, "%")) {
			$action = "marge";
			$valeur = substr ($formule, 3, strpos($formule, "%"));
		}
		elseif (substr ($formule, 2, 1) == "*") {
			$action = "multi";
			$valeur = substr ($formule, 3, strlen($formule));
		}
		else {
			$action = "add";
			$valeur = substr ($formule, 2, strlen($formule));
		}

		switch ($action) {
			case "marge":
				$tarif[$resultat] = (${$base} * 100) / (100 - $valeur);
				break;
			case "multi":
				$tarif[$resultat] = ${$base} * $valeur;
				break;
			case "add":
				$tarif[$resultat] = ${$base} + $valeur;
				break;
		}

		// ************************************************* 
		// Calcul de la valeur arrondie 
		if ($arrondi) {
			$signe = substr($arrondi, 0, 1);
			$precision = substr($arrondi, 1);
			if ($precision == 0) {$precision = 1;}
			$diviseur = $tarif[$resultat] / $precision;

			switch($signe) {
				case "=": $tarif[$resultat] = $precision * round($diviseur); 	break;
				case "<": $tarif[$resultat] = $precision * floor($diviseur); 	break;
				case ">": $tarif[$resultat] = $precision * ceil($diviseur);		break;
			}
		}
	} // Fin du calcul de la formule


	// Calcul des autres tarifs
	switch ($resultat) {
		case "PU_HT":
			$tarif['PU_TTC'] 	= $tarif['PU_HT'] 	* (1+$tva/100);
			break;
		case "PU_TTC":
			$tarif['PU_HT'] 	= $tarif['PU_TTC'] 	/ (1+$tva/100);
			break;
	}
	
	$this->tarifs = $tarif;
	
	return true;
}


// Défini le tarif a afficher pour l'utilisateur
function define_affichage_tarif () {
	global $MONNAIE;

	$debut 	= 0;
	$fin 		= strpos($this->formule, "=");
	$resultat = substr($this->formule, $debut, $fin);
	
	if (substr($resultat, 1, 1) == "U" && substr($resultat, 3, 1) == "H") {
		return "PU_HT";
	}
	elseif (substr($resultat, 1, 1) == "U" && substr($resultat, 3, 1) == "T") {
		return "PU_TTC";
	} /*
	elseif (substr($resultat, 1, 1) == "T" && substr($resultat, 3, 1) == "H") {
		return "PT_HT";
	}
	elseif (substr($resultat, 1, 1) == "T" && substr($resultat, 3, 1) == "T") {
		return "PT_TTC";
	} */
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
	if (!in_array($reponses[1], array("AR","PA","PP"))) 					{ $GLOBALS['_ALERTES']['bad_reponse_1'] = 1; }
	if (!in_array($reponses[2], array("MARGE","MULTI","ADD"))) 		{ $GLOBALS['_ALERTES']['bad_reponse_2'] = 1; }
	if (!in_array($reponses[3], array("PAS","SUP","INF","PRO")))	{ $GLOBALS['_ALERTES']['bad_reponse_3'] = 1; }
	if (!in_array($reponses[4], array("PU_HT","PU_TTC")))					{ $GLOBALS['_ALERTES']['bad_reponse_4'] = 1; }

	// Vérification de la validité des valeures
	if (isset($valeures[1]) && !is_numeric($valeures[1])) 				{ $GLOBALS['_ALERTES']['bad_valeur_1'] = 1; }
	if (isset($valeures[2]) && !is_numeric($valeures[2]))  				{ $GLOBALS['_ALERTES']['bad_valeur_2']	= 1; }
	if (isset($valeures[3]) && !is_numeric($valeures[3]))  				{ $GLOBALS['_ALERTES']['bad_valeur_3']	= 1; }


	if (isset($valeures[2]) && $reponses[2] == "MARGE" && $valeures[2] >= 100) { $GLOBALS['_ALERTES']['bad_valeur_2']	= 1; }
	// *************************************************
	// Si les valeurs reçues sont incorrectes
	if (count($GLOBALS['_ALERTES'])) { 
		return false;
	}

	// *************************************************
	// Création de la formule a partir des réponses
	// Q4
	$formule = $reponses[4]."=";

	// Q1
	if ($reponses[1] == "AR") {
			$formule .= $valeures[1];
			return $formule;
	}
	// Si utilisation d'une formule plus complexe
	$formule .= $reponses[1];
  
	// Q2
	if ($reponses[2] == "MARGE") {
		if ($valeures[2] >=0 && !strpos($valeures[2], "+")) { $formule .= "+"; }
		$formule .= $valeures[2]."%";
	}
	elseif ($reponses[2] == "MULTI") {
		$formule .= "*".$valeures[2];
	}
	else { // Addition
		if ($valeures[2] > 0) { 
			if ($valeures[2] >=0 && !strpos($valeures[2], "+")) { $formule .= "+"; }
			$formule .= $valeures[2];
		}
		elseif ($valeures[2] < 0) {
			$formule .= $valeures[2];
		}
	}

	// Q3
	if ($reponses[3] == "PAS") { return $formule; }
	$formule .= "[";
	if ($reponses[3] == "INF") {
		$formule .= "<".$valeures[3];
	}
	elseif ($reponses[3] == "SUP") {
		$formule .= ">".$valeures[3];
	}
	else {
		$formule .= "=".$valeures[3];
	}
	$formule .= "]";

	/* Quelques exemples de resultats :
	PT_HT=15.5
	PU_TTC=17,9
	PU_HT=PA*1,5[>0,05]
	PU_TTC=PA+20%
	PU_HT=PPC-12%[>0,10]	
	*/
	
	return $formule;
}



// Vérifie la formule de prix
static function check_formule ($formule) {
	if (!$formule) {return false;}
	return true;
}


}

?>