<?php
//  ******************************************************
// EDITION DES FICHIERS DE CONFIGURATION
//  ******************************************************
// Variables nécessaires à l'affichage

require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");

$file_name = $_REQUEST['nom_fichier'];

//création du nouveau fichier
$new_file_id = fopen ($CONFIG_DIR."tmp_".$file_name, "w");
fwrite($new_file_id, $_REQUEST['new_text_file']);
fclose($new_file_id);

// Remplacement du fichier existant
unlink($$CONFIG_DIR.$file_name);
rename($$CONFIG_DIR."tmp_".$file_name, $DIR."config/".$file_name);

//  ******************************************************
// AFFICHAGE
//  ******************************************************

include ($CORE_DIR."profil_admin/smenu_configuration_config_files.php");

?>