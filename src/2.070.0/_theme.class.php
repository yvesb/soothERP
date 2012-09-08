<?php
// *************************************************************************************************************
// CLASSE REGISSANT LES INFORMATIONS GENERIQUE SUR UN THEME D'AFFICHAGE 
// *************************************************************************************************************

class theme {
	private $id_theme;

	private $id_interface;
	private $lib_theme;
	private $code_theme;

	private $id_langage;
	private $actif;

	private $dir_theme;


function __construct ($id_theme) {
	global $DIR;
	global $bdd;

	$query = "SELECT id_theme, id_interface, lib_theme, code_theme, id_langage, actif
						FROM interfaces_themes
						WHERE id_theme = '".$id_theme."' ";
	$result = $bdd->query ($query);
	$theme = $result->fetchObject();
	
	// Thème non trouvé
	if (!isset($theme->id_theme)) {
		$erreur = "Tentative de chargement d'un thème inexistant (ID_THEME = ".$id_theme.")";
		alerte_dev ($erreur);
	}
	
	// Thème non actif
	if (!$theme->actif) {
		$erreur = "Tentative de chargement d'un thème non actif (ID_THEME = ".$id_theme.")";
		alerte_dev ($erreur);
	}
	
	$this->id_theme 	= $theme->id_theme;
	$this->id_interface 	= $theme->id_interface;
	$this->lib_theme 	= $theme->lib_theme;
	$this->code_theme = $theme->code_theme;
	$this->id_langage = $theme->id_langage;
	$this->actif 			= $theme->actif;
	
	return true;
}



// *************************************************************************************************************
// Fonctions d'accès aux données
// *************************************************************************************************************

// Retourne le répertoire du theme
final public function getDir_theme() {
	
	// Répertoire de ce thème
	$dir_theme = $_SESSION['interfaces'][$this->id_interface]->getDossier()."themes/".$this->code_theme."/";

	return $dir_theme;
}

// retourne d'identifiant du thème
final public function getId_theme() {
	return $this->id_theme;
}

// retourne le libellé du thème
final public function getLib_theme() {
	return $this->lib_theme;
}

// retourne le libellé du thème
final public function getCode_theme() {
	return $this->code_theme;
}


}
?>