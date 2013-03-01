<?php
// *************************************************************************************************************
// IMPORT FICHIER tarifs_fournisseur CSV
// *************************************************************************************************************

require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");

ini_set("memory_limit","40M");
$contenu = array();
if (!empty($_FILES['fichier_csv']['tmp_name'])) {
	// Copie du fichier
	if (substr_count($_FILES["fichier_csv"]["name"], ".csv")) {
		$content = fopen($_FILES['fichier_csv']['tmp_name'], "r");
		$import_tarifs_fournisseur = new import_tarifs_fournisseur_csv();
		$import_tarifs_fournisseur->setRef_fournisseur($_REQUEST['ref_contact']);
		while (($data = fgetcsv($content, 0, ";")) !== FALSE) {
			$contenu[]=$data;
		}
		$import_tarifs_fournisseur->import($contenu);
	}
}

// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************
include ($DIR.$_SESSION['theme']->getDir_theme()."/page_import_tarifs_fournisseur_csv_done.inc.php");
?>