<?php
// *************************************************************************************************************
// IMPORT FICHIER tarifs_fournisseur CSV
// *************************************************************************************************************

require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");

if (isset($_REQUEST["total_import"])) {
	$GLOBALS['_INFOS']['total_import'] = $_REQUEST["total_import"];
}
if (isset($_REQUEST["count_import"])) {
	$GLOBALS['_INFOS']['count_import'] = $_REQUEST["count_import"];
}
$import_tarifs_fournisseur = new import_tarifs_fournisseur_csv();

// On récupère les colonnes à importer
$query = "SELECT id_colonne, champ_equivalent FROM csv_import_tarifs_fournisseur_cols;";
$resultat = $bdd->query($query);
$array_retour = array();
while ($tmp = $resultat->fetchObject()) {
	$query2 = "SELECT id_ligne FROM csv_import_tarifs_fournisseur_donnees WHERE id_colonne = " . $tmp->id_colonne ; 
	$resultat2 = $bdd->query ($query2);
	while ($tmp2 = $resultat2->fetchObject()) {
		$liste_ligne[$tmp2->id_ligne] = $tmp2->id_ligne;
	}
	unset ($query2, $resultat2, $tmp2);
}
// Traitement de la liste des infos sélectionnées
$nb_fiches = 50;

if (!isset($GLOBALS['_INFOS']["total_import"])) {
	$GLOBALS['_INFOS']['total_import'] = count($liste_ligne);
}
if (count($liste_ligne) < $nb_fiches) {
	$nb_fiches = count($liste_ligne);
}

// On effectue l'import
$import_tarifs_fournisseur->create($liste_ligne);
// On vérifie s'il reste des lignes
$csv_donnee = new import_tarifs_fournisseur_csv_donnee();
$lignes = $csv_donnee->readAll();

// *************************************************************************************************************
// REDIRECT
// *************************************************************************************************************
include ($DIR.$_SESSION['theme']->getDir_theme()."/page_import_tarifs_fournisseur_csv_step2_done.inc.php");
?>