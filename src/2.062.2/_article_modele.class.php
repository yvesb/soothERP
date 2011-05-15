<?php
// *************************************************************************************************************
// CLASSE REGISSANT LES INFORMATIONS SUR UN MODELE D'ARTICLE 
// *************************************************************************************************************


final class art_modele {
	private $id_art_modele;			// Identifiant du modele d'article
	private $code_art_modele;
	private $lib_modele;
	private $desc_interne;
	private $desc_publique;


function __construct($id_art_modele = "") {
	global $bdd;

	// Controle si la id_art_modele est précisée
	if (!$id_art_modele) { return false; }

	// Sélection des informations générales
	$query = "SELECT code_art_modele, lib_modele, desc_interne, desc_publique
						FROM art_modeles 
						WHERE id_art_modele = '".$id_art_modele."' ";
	$resultat = $bdd->query ($query);

	// Controle si la id_art_modele est trouvée
	if (!$art_modele = $resultat->fetchObject()) { return false; }

	// Attribution des informations à l'objet
	$this->id_art_modele 		= $id_art_modele;
	$this->code_art_modele	= $art_categ->code_art_modele;
	$this->lib_modele			= $art_categ->code_art_modele;
	$this->desc_interne		= $art_categ->desc_interne;
	$this->desc_publique	= $art_categ->desc_publique;

	return true;
}



// *************************************************************************************************************
// FONCTIONS DE LECTURE DES DONNEES 
// *************************************************************************************************************
function getId_art_modele () {
	return $this->id_art_modele;
}

function getCode_art_modele () {
	return $this->code_art_modele;
}

function getLib_modele () {
	return $this->lib_modele;
}

function getDesc_interne () {
	return $this->desc_interne;
}

function getdesc_publique () {
	return $this->desc_publique;
}



}

?>