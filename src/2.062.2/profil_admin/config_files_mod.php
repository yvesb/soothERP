<?php
// *************************************************************************************************************
// EDITION DES FICHIERS DE CONFIGURATION
// *************************************************************************************************************
// Variables nécessaires à l'affichage

require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");

$file_name = $_REQUEST['nom_fichier'];

//création du nouveau fichier
$new_file_id = fopen ($DIR."config/tmp_".$file_name, "w");
fwrite($new_file_id, $_REQUEST['new_text_file']);
fclose($new_file_id);

// Remplacement du fichier existant
unlink($DIR."config/".$file_name);
rename($DIR."config/tmp_".$file_name, $DIR."config/".$file_name);

// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

/*include ($DIR."profil_admin/smenu_configuration_config_files.php");*/

?>