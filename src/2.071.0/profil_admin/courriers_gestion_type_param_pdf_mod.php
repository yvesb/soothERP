<?php
// *************************************************************************************************************
// MODIFICATION DU PARAMETRAGE DE COURRIER PDF
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");

										
if (isset($_REQUEST["id_pdf_modele"])) {
	//chargement du modèle
	$modele_pdf = charge_modele_pdf ($_REQUEST["id_pdf_modele"]);
	
	//chargement des infos de configuration du modèle
	$config_files = file($PDF_MODELES_DIR."config/".$modele_pdf->code_pdf_modele.".config.php");
	
	$new_config_files= array();
	$meet_edit_param = 0;
	foreach ($config_files as $config_line) {
		if (substr_count($config_line, "\$CONFIGURATION=0;")) {$new_config_files[]="\$CONFIGURATION=1;\n"; continue;}
		if (substr_count($config_line, "// PARAMETRES MODIFIABLES")) {$new_config_files[]=$config_line; $meet_edit_param = 1; continue;}
		if (substr_count($config_line, "// FIN PARAMETRES MODIFIABLES")) {$new_config_files[]=$config_line; $meet_edit_param = 0; continue;}
		if (!$meet_edit_param) {$new_config_files[]=$config_line; continue;}
	
		// on vas recréer le contenu de la ligne	
		$tmp_maj_line = "";
		$tmp_infos = explode("//", str_replace("/n", "", $config_line));
		if (isset($_REQUEST[ urlencode(substr($tmp_infos[0], 0, strpos($tmp_infos[0], "=")))])) {
			$tmp_maj_line .= substr($tmp_infos[0], 0, strpos($tmp_infos[0], "="))."=";
			if (substr_count(substr($tmp_infos[0], strpos($tmp_infos[0], "=")+1, strpos($tmp_infos[0], ";")-strpos($tmp_infos[0], "=")-1) , "\"")) {
				$tmp_maj_line .= "\"".str_replace("\r\n", "\\n", $_REQUEST[ urlencode(substr($tmp_infos[0], 0, strpos($tmp_infos[0], "=")))])."\"";
			} else {
				$tmp_maj_line .= "".$_REQUEST[ urlencode(substr($tmp_infos[0], 0, strpos($tmp_infos[0], "=")))]."";
			}
			$tmp_maj_line .= ";";
			
			$tmp_maj_line .= "//";

			if (isset($tmp_infos[1])) {$tmp_maj_line .= $tmp_infos[1];}
			$tmp_maj_line .= "//";

			if (isset($tmp_infos[2])) {$tmp_maj_line .= $tmp_infos[2];}
			$tmp_maj_line .= "//";

			if (isset($tmp_infos[3])) {$tmp_maj_line .= $tmp_infos[3];}
			
			$new_config_files[]=$tmp_maj_line;
		}
	}
	// Création du nouveau fichier de coniguration
	$new_file_id = fopen ($PDF_MODELES_DIR."config/tmp_".$modele_pdf->code_pdf_modele.".config.php", "w");
	foreach ($new_config_files as $line) {
		fwrite($new_file_id, $line);
	}
	fclose($new_file_id);

	// Remplacement du fichier existant
	unlink($PDF_MODELES_DIR."config/".$modele_pdf->code_pdf_modele.".config.php");
	rename($PDF_MODELES_DIR."config/tmp_".$modele_pdf->code_pdf_modele.".config.php", $PDF_MODELES_DIR."config/".$modele_pdf->code_pdf_modele.".config.php");

	if (isset($_REQUEST["id_type_doc"]) && isset($_REQUEST["act"])) {
		active_doc_modele_pdf ($_REQUEST["id_type_doc"], $_REQUEST["id_pdf_modele"]);
	}
}


	
// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_documents_gestion_type_param_pdf_mod.inc.php");

?>