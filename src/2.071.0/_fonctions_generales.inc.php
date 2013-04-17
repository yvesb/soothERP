<?php

// *************************************************************************************************************
// FONCTIONS GENERALES
// *************************************************************************************************************


// Chargement dynamique d'une classe
function load_class ($class) {
	
	function __autoload($class) {
   	require_once ($class);
	}
	
	__autoload($class);

}	


// Classe objet fictive permettant de créer des objets à la volée sans erreur PHP
class objet_virtuel {
	function __construct() {}
}


// Import d'un fichier 
function import_file ($local_taxe_file, $distant_taxe_file) {
	// Copie le fichier distant en local
}
	
	
// Vérifie l'existence des variables pour l'affichage de la page.
function check_page_variables ($tab) {
	$not_defined = 0;

	foreach ($tab as $variable) {
		// Recherche du nom de la variable si il s'agit d'un élément de tableau
		$var_name = $variable;
		$var_component = "";
		if (strpos($variable, "[")) {
			$var_name = substr($variable, 0, strpos($variable, "["));
			$var_component = substr($variable, strpos($variable, "[")+2, strlen($variable)-strpos($variable, "]")-3);
		}
		
		global ${$var_name};
		if (!isset(${$variable}) && !isset(${$var_name}[$var_component])) { 
			$not_defined ++;
			break;
		}
	}

	if (!$not_defined) { 
		// Toutes les variables sont définies
		return true;
	}

	// Erreur : Au moins une variable non affichéey
	error_checking_page_variables ($tab);

	exit();
}



// Transmet les attributs d'un objet à un autre
function transfert_attributs (&$objet1, $objet2) {
	global $sql;
	
	if (!isset($objet2)) { return false; }
	
	foreach ($objet2 as $attribut => $valeur) {
		$objet1->{$attribut} = $valeur;
	}
	
	return true;
}


// Ordonne un tableau par référence d'objet parent
// Ajoute l'information "indentation" à chacun des objets du tableau
function order_by_parent (&$tab1, $tab2, $cle1, $cle2, $ref_cle_parent, $ref_cle_ignored = "") {
	static $tab1 = array();
	static $indentation = 0;

	for ($i=0; $i<count($tab2); $i++) {
		// Si la clé indiquant le parent n'est pas égale à ref_cle_parent, on passe a l'enregistrement suivant
		if ($tab2[$i]->{$cle2} != $ref_cle_parent) { continue; }
		
		// Si l'enregistrement a déjà été inséré dans le tableau, on passe au suivant
		if (isset($tab1[$tab2[$i]->{$cle1}])) { continue; }
		
		// Si l'enregistrement ne doit pas etre enregistré: on saute
		if ($tab2[$i]->{$cle1} == $ref_cle_ignored) { continue; }

		// Ajout de l'enregistrement en cours au tableau 1
		$tab1[$tab2[$i]->{$cle1}] = $tab2[$i];
		$tab1[$tab2[$i]->{$cle1}]->indentation = $indentation;

		// Ajout des enfant de l'enregistrement en cours au tableau 1
		$indentation++;
		$tab1 = order_by_parent ($tab1, $tab2, $cle1, $cle2, $tab2[$i]->{$cle1}, $ref_cle_ignored);
		$indentation--;
	}
	
	return $tab1;
}

// Ordonne un tableau par référence d'objet parent
// Ajoute l'information "indentation" à chacun des objets du tableau
function order_by_parent_bis (&$tab1_bis, $tab2_bis, $cle1_bis, $cle2_bis, $ref_cle_parent_bis, $ref_cle_ignored_bis = "") {
	static $tab1_bis = array();
	static $indentation_bis = 0;

	for ($i=0; $i<count($tab2_bis); $i++) {
		// Si la clé indiquant le parent n'est pas égale à ref_cle_parent, on passe a l'enregistrement suivant
		if ($tab2_bis[$i]->{$cle2_bis} != $ref_cle_parent_bis) { continue; }
		
		// Si l'enregistrement a déjà été inséré dans le tableau, on passe au suivant
		if (isset($tab1_bis[$tab2_bis[$i]->{$cle1_bis}])) { continue; }
		
		// Si l'enregistrement ne doit pas etre enregistré: on saute
		if ($tab2_bis[$i]->{$cle1_bis} == $ref_cle_ignored_bis) { continue; }

		// Ajout de l'enregistrement en cours au tableau 1
		$tab1_bis[$tab2_bis[$i]->{$cle1_bis}] = $tab2_bis[$i];
		$tab1_bis[$tab2_bis[$i]->{$cle1_bis}]->indentation = $indentation_bis;

		// Ajout des enfant de l'enregistrement en cours au tableau 1
		$indentation_bis++;
		$tab1 = order_by_parent_bis ($tab1_bis, $tab2_bis, $cle1_bis, $cle2_bis, $tab2_bis[$i]->{$cle1_bis}, $ref_cle_ignored_bis);
		$indentation_bis--;
	}
	
	return $tab1_bis;
}

// Fonction de transformation de chaines
function convert_numeric ($number) {
        $number=preg_replace('/\s/', '', $number);
	preg_match("#([0-9.,+-]*)#", $number, $reg);
	$number = str_replace(",", ".", $reg[1]);
	return $number;
}


function url_site(){
	$dir = str_replace("/", "", str_replace("..", "", $GLOBALS["THIS_DIR"]));
	$url_site = "http://" . $_SERVER['HTTP_HOST'] . substr($_SERVER['PHP_SELF'], 0, strpos($_SERVER['PHP_SELF'], $dir));
	return $url_site;
}


?>
