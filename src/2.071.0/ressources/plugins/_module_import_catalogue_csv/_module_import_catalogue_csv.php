<?php
//  ******************************************************
// IMPORT FICHIER catalogue CSV
//  ******************************************************

require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");

$import_catalogue = new import_catalogue_csv(); 
//  ******************************************************
// AFFICHAGE
//  ******************************************************
include ("themes/page_import_catalogue_csv.inc.php");

?>