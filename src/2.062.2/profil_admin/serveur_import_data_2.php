<?php
// *************************************************************************************************************
// IMPORT DES ARTICLES
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");


$import_art_categs = array();
$import_art_categs_carac_groupe = array();
$import_art_categs_carac = array();
$import_serveur = new import_serveur ($_REQUEST["ref_serveur"]);
$import_infos = $import_serveur->charger_import_infos (2);

$presentes_art_categ =	get_articles_categories();
//si import_infos est vide c'est le premier import effectué, on génére alors la liste des art_categ importée depuis les art_categ dans la base
if ($import_infos == "") {
	foreach ($presentes_art_categ as $art_categ_imported) {
		if (substr ($art_categ_imported->ref_art_categ, 4, 6) != $_SERVER['REF_SERVEUR']) {
			$import_infos .= $art_categ_imported->ref_art_categ.";0000-00-00\n";
		}
	}
} else {
//ou on ajoute à la liste les art_categ qui n'auraient pas encore été mises à jours
	foreach ($presentes_art_categ as $art_categ_imported) {
		if (!substr_count ($import_infos, $art_categ_imported->ref_art_categ) ) {
			if (substr ($art_categ_imported->ref_art_categ, 4, 6) != $_SERVER['REF_SERVEUR']) {
				$import_infos .= $art_categ_imported->ref_art_categ.";0000-00-00\n";
			}
		}
	}
}

//on cré un fichier qui regroupe les art_categ déjà importées pour que le serveur de données récupére ces infos
	$new_file = fopen ($DIR."echange_lmb/tmp_art_categ_list.csv", "w");
	fwrite($new_file, $import_infos);
	fclose($new_file);
	
$fichier = $import_serveur->getUrl_serveur_import().$ECHANGE_LMB_DIR."export_articles_count_data.php?ref_serveur=".$_SERVER['REF_SERVEUR'];


$fp = fopen ($fichier, "r");
$contenu_fichier = fgets($fp, 1024);
$nombre_articles = 0;
if (is_numeric($contenu_fichier)) {
$nombre_articles = $contenu_fichier;
}
// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_serveur_import_data_2.inc.php");

?>