<?php
// *************************************************************************************************************
// IMPORT FICHIER catalogue CSV ETAPE 3 (après correspondance des colonnes et des valeurs du fichier)
// *************************************************************************************************************

require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");


$import_catalogue = new import_catalogue_csv(); 
$import_catalogue->maj_etape(3);
if (file_exists("import_cop.csv"))
    unlink("import_cop.csv");
// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************
include ($DIR."profil_".$_SESSION['profils'][$ID_PROFIL]->getCode_profil()."/modules/".$import_catalogue_csv['folder_name']."themes/".$_SESSION['theme']->getCode_theme()."/page_import_catalogue_csv_step3.inc.php");

?>