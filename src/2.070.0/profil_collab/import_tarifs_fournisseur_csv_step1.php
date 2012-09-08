<?php
// *************************************************************************************************************
// IMPORT FICHIER tarifs_fournisseur CSV ETAPE 1 (après import du fichier)
// *************************************************************************************************************

require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");


$import_tarifs_fournisseur = new import_tarifs_fournisseur_csv();

$fournisseurs_import_tarifs = new fournisseurs_import_tarifs($import_tarifs_fournisseur->getRef_fournisseur());

// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************
include ($DIR.$_SESSION['theme']->getDir_theme()."/page_import_tarifs_fournisseur_csv_step1.inc.php");

?>