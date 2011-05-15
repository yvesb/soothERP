<?php
// *************************************************************************************************************
// IMPORT FICHIER ANNUAIRE CSV ETAPE 2 (après correspondance des colonnes et des valeurs du fichier)
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");



$import_annuaire = new import_annuaire_csv(); 
$import_annuaire->maj_limite($_REQUEST["limite"]);
?>