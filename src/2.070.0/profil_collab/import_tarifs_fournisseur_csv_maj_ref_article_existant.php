<?php
// *************************************************************************************************************
// IMPORT FICHIER tarifs_fournisseur CSV
// *************************************************************************************************************
require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");

$ref_article_existant = "";

// On met à jour la référence (de l'article à importer) en base
if(isset($_POST['ref_article_existant']) && isset($_POST['id_ligne'])){
	$ref_article_existant = $_POST['ref_article_existant'];
	$id_ligne = $_POST['id_ligne'];
	
	$import_tarifs_fournisseur = new import_tarifs_fournisseur_csv();
	$id_colonne = $import_tarifs_fournisseur->getId_colonne_ref_article_existant();
	if(isset($id_colonne) && $id_colonne != ""){
		$donnee = new import_tarifs_fournisseur_csv_donnee();
		$donnee->setId_ligne($id_ligne);
		$donnee->setId_colonne($id_colonne);
		$donnee = $donnee->readLigneColonne();
		$donnee->setValeur($ref_article_existant);
		$donnee->update($donnee->getId(), $donnee->getValeur());
	}else{
		$GLOBALS['ALERTES']['erreur'] = "Problème de récupération de la colonne";
	}
	unset($query, $resultat, $tmp, $query2);
}else{
	$GLOBALS['ALERTES']['erreur'] = "Problème de récupération des données";
}

// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************
include ($DIR.$_SESSION['theme']->getDir_theme()."/page_import_tarifs_fournisseur_csv_maj_ref_article_existant.inc.php");
?>