<?php
// *************************************************************************************************************
// IMPORT FICHIER tarifs_fournisseur CSV ETAPE 3 (après import)
// *************************************************************************************************************

require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");

$import_tarifs_fournisseur = new import_tarifs_fournisseur_csv(); 
$import_tarifs_fournisseur->maj_etape(3);
// Stockage des paramètres de l'import pour utilisation ultérieure
$import_tarifs_fournisseur->save_import_params();
$import_tarifs_fournisseur->erase();

$fournisseur = new contact($import_tarifs_fournisseur->getRef_fournisseur());
// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************
include ($DIR.$_SESSION['theme']->getDir_theme()."/page_import_tarifs_fournisseur_csv_step3.inc.php");
?>