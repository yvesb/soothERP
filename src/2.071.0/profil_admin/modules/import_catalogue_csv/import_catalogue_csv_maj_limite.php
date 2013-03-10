<?php
// *************************************************************************************************************
// IMPORT FICHIER catalogue CSV ETAPE 2 (après correspondance des colonnes et des valeurs du fichier)
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");



$import_catalogue = new import_catalogue_csv(); 
$import_catalogue->maj_limite($_REQUEST["limite"]);
?>