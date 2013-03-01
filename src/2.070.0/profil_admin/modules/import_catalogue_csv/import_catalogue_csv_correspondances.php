<?php
// *************************************************************************************************************
// IMPORT FICHIER catalogue CSV correspondances avec les valeurs de colones
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");


$dao_csv_import_catalogue_ligne = new import_catalogue_csv_ligne();
$arrayLigne = array();
$listes_champs = array();
$lib_champ = "";
switch ($_REQUEST["lmb_col"]) {
	case "ref_art_categ":
		$lib_champ = "la catégorie d'article";
		$select_art_categ =	get_articles_categories();
		foreach ($select_art_categ  as $s_art_categ){
			$listes_champs[] = array("id"=>$s_art_categ->ref_art_categ, "lib"=>$s_art_categ->lib_art_categ);
		}
		$arrayLigne = $dao_csv_import_catalogue_ligne->readAllColonne($_REQUEST["csv_col"]);
	break;
	case "ref_constructeur":
		$lib_champ = "le constructeur";
		$liste_constructeurs= get_constructeurs();
		foreach ($liste_constructeurs as $constructeur) {
			$listes_champs[] = array("id"=>$constructeur->ref_contact, "lib"=>$constructeur->nom);
		}
		$arrayLigne = $dao_csv_import_catalogue_ligne->readAllColonne($_REQUEST["csv_col"]);
	break;
	case "gestion_sn":
		$lib_champ = "la gestion des sn";
		$listes_champs[] = array("id"=>"0", "lib"=>"Pas de gestion des sn");
		$listes_champs[] = array("id"=>"1", "lib"=>"Gestion des sn");
		$arrayLigne = $dao_csv_import_catalogue_ligne->readAllColonne($_REQUEST["csv_col"]);
	break;
	
	case "id_valo":
	
		$lib_champ = "le type de valorisation";
		foreach (get_valorisations() as $valorisation) {
			$listes_champs[] = array("id"=>$valorisation->id_valo, "lib"=>$valorisation->lib_valo);
		}
		$arrayLigne = $dao_csv_import_catalogue_ligne->readAllColonne($_REQUEST["csv_col"]);
	break;
	
	case "id_tarif":
	
		$dao_csv_import_catalogue_cols2 = new import_catalogue_csv_colonne();
		$arrayColonne = array();
				$arrayColonne = $dao_csv_import_catalogue_cols2->readAll();
	break;
	

}
// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************
include ($DIR."profil_".$_SESSION['profils'][$ID_PROFIL]->getCode_profil()."/modules/".$import_catalogue_csv['folder_name']."themes/".$_SESSION['theme']->getCode_theme()."/page_import_catalogue_csv_correspondances.inc.php");




?>