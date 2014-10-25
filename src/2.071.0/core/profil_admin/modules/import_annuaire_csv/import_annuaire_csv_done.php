<?php
// *************************************************************************************************************
// IMPORT FICHIER ANNUAIRE CSV
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");

//
//ini_set("memory_limit","40M");
//
//if (!empty($_FILES['fichier_csv']['tmp_name'])) {
//	//copie du fichier
//	if (substr_count($_FILES["fichier_csv"]["name"], ".csv")) {
//	
//		$content = file_get_contents($_FILES['fichier_csv']['tmp_name']);
//		$import_annuaire = new import_annuaire_csv(); 
//		//	print_r($content);
//		$lignes = explode("\n",$content);
//		//print_r($lignes);
//		$import_annuaire->import_colonne($lignes, $_REQUEST["profil_import"]);
//	}
//	
//}

ini_set("memory_limit","40M");
$lignes = array();
if (!empty($_FILES['fichier_csv']['tmp_name'])) {
	//copie du fichier
	if (substr_count($_FILES["fichier_csv"]["name"], ".csv")) {
		//$content = file_get_contents($_FILES['fichier_csv']['tmp_name']);
		
		$content = fopen($_FILES['fichier_csv']['tmp_name'], "r");
		$import_annuaire = new import_annuaire_csv(); 
		//print_r($content);
		while (($data = fgetcsv($content, 0, ";")) !== FALSE) {
			$lignes[]=$data;
                        
		}
                $filename = "import_cop.csv";
                move_uploaded_file($_FILES['fichier_csv']['tmp_name'], $filename);
                chmod ($filename, 0755);
		$import_annuaire->import_colonne($lignes, $_REQUEST["profil_import"]);
	}
}


// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

include ($DIR."profil_".$_SESSION['profils'][$ID_PROFIL]->getCode_profil()."/modules/".$import_annuaire_csv['folder_name']."themes/".$_SESSION['theme']->getCode_theme()."/page_import_annuaire_csv_done.inc.php");

?>