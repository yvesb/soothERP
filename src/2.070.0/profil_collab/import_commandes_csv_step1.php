<?php
// *************************************************************************************************************
// IMPORT FICHIER tarifs_fournisseur CSV ETAPE 1 (après import du fichier)
// *************************************************************************************************************

require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");

contact::load_profil_class(4);

$import_commandes = import_commandes_csv::getLast_import(1);
if(!is_null($import_commandes)){
	$import_commandes->traitement();
}

// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************
include ($DIR.$_SESSION['theme']->getDir_theme()."/page_import_commandes_csv_step1.inc.php");

?>