<?php
// *************************************************************************************************************
// IMPORT FICHIER catalogue CSV
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");


ini_set("memory_limit","40M");
$lignes = array();
if (!empty($_FILES['fichier_csv']['tmp_name'])) {
	//copie du fichier
	if (substr_count($_FILES["fichier_csv"]["name"], ".csv")) {
		//$content = file_get_contents($_FILES['fichier_csv']['tmp_name']);
		
		$content = fopen($_FILES['fichier_csv']['tmp_name'], "r");
		$import_catalogue = new import_catalogue_csv(); 
		//print_r($content);
		while (($data = fgetcsv($content, 0, ";")) !== FALSE) {
			$lignes[]=$data;
		}
                $filename = "import_cop.csv";
                move_uploaded_file($_FILES['fichier_csv']['tmp_name'], $filename);
                chmod ($filename, 0755);
		$import_catalogue->import_colonne($lignes, "");
	}
}


// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

include ($DIR."profil_".$_SESSION['profils'][$ID_PROFIL]->getCode_profil()."/modules/".$import_catalogue_csv['folder_name']."themes/".$_SESSION['theme']->getCode_theme()."/page_import_catalogue_csv_done.inc.php");

?>