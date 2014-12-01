<?php
//  ******************************************************
// IMPORT FICHIER ANNUAIRE CSV
//  ******************************************************

require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");

$import_annuaire = new import_annuaire_csv(); 
//  ******************************************************
// AFFICHAGE
//  ******************************************************
include ("themes/page_import_annuaire_csv.inc.php");

?>