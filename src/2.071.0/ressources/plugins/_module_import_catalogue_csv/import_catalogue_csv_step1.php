<?php
//  ******************************************************
// IMPORT FICHIER catalogue CSV ETAPE 1 (après import du fichier)
//  ******************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");



$import_catalogue = new import_catalogue_csv(); 

//  ******************************************************
// AFFICHAGE
//  ******************************************************

include ("themes/page_import_catalogue_csv_step1.inc.php");

?>