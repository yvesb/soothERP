<?php
// *************************************************************************************************************
// FONCTION DE REFERENCEMENT
// *************************************************************************************************************


// Retourne toutes les infos des grilles tarifaires
function get_reference ($nom_fichier = "") {
	global $bdd;
	
	$reference = array();
	$query = "SELECT nom_fichier, titre, meta_desc, meta_motscles
						FROM site_web_referencement ";
						
	if ($nom_fichier) { $query .="			WHERE nom_fichier = '".$nom_fichier."' ";}
	$query .="			ORDER BY titre ASC";
	$resultat = $bdd->query ($query);
	while ($tmp = $resultat->fetchObject()) { $reference[] = $tmp; }
	return $reference;
}

//enregistre une page dans le référencement
function add_reference ($nom_fichier, $titre, $meta_desc, $meta_motscles) {
	global $bdd;
	// Insertion de la page dans la bdd
	$query = "INSERT INTO site_web_referencement (nom_fichier, titre, meta_desc, meta_motscles)	
						VALUES ('".$nom_fichier."', '".addslashes($titre)."', '".addslashes($meta_desc)."', '".addslashes($meta_motscles)."' ) ";
	$bdd->exec ($query);
	
	return true;
}
//maj une page dans le référencement
function maj_reference ($nom_fichier, $titre, $meta_desc, $meta_motscles) {
	global $bdd;
	// Insertion de la page dans la bdd
	$query = "UPDATE site_web_referencement SET titre = '".addslashes($titre)."', meta_desc = '".addslashes($meta_desc)."', meta_motscles ='".addslashes($meta_motscles)."' 	
						WHERE  nom_fichier = '".$nom_fichier."'";
	$bdd->exec ($query);
	
	return true;
}
//suppression une page dans le référencement
function del_reference ($nom_fichier) {
	global $bdd;
	// suppression de la page dans la bdd
	$query = "DELETE FROM site_web_referencement
						WHERE  nom_fichier = '".$nom_fichier."'";
	$bdd->exec ($query);
	
	return true;
}
?>