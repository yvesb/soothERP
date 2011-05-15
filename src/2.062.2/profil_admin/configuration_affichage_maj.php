<?php
// *************************************************************************************************************
// CONFIGURATION DES DONNÉES d'affichage
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");



//mise à jour des données transmises
if (isset($_REQUEST["annuaire_recherche_showed_fiches"]) && is_numeric($_REQUEST["annuaire_recherche_showed_fiches"])) {
	maj_configuration_file ("config_generale.inc.php", "maj_line", "\$ANNUAIRE_RECHERCHE_SHOWED_FICHES =", "\$ANNUAIRE_RECHERCHE_SHOWED_FICHES = ".$_REQUEST["annuaire_recherche_showed_fiches"]."; ", $CONFIG_DIR);
}


if (isset($_REQUEST["catalogue_recherche_showed_fiches"]) && is_numeric($_REQUEST["catalogue_recherche_showed_fiches"])) {
	maj_configuration_file ("config_generale.inc.php", "maj_line", "\$CATALOGUE_RECHERCHE_SHOWED_FICHES =", "\$CATALOGUE_RECHERCHE_SHOWED_FICHES = ".$_REQUEST["catalogue_recherche_showed_fiches"]."; ", $CONFIG_DIR);
}
if (isset($_REQUEST["stock_move_recherche_showed"]) && is_numeric($_REQUEST["catalogue_recherche_showed_fiches"])) {
	maj_configuration_file ("config_generale.inc.php", "maj_line", "\$STOCK_MOVE_RECHERCHE_SHOWED =", "\$STOCK_MOVE_RECHERCHE_SHOWED = ".$_REQUEST["stock_move_recherche_showed"]."; ", $CONFIG_DIR);
}


if (isset($_REQUEST["document_recherche_showed_fiches"]) && is_numeric($_REQUEST["document_recherche_showed_fiches"])) {
	maj_configuration_file ("config_generale.inc.php", "maj_line", "\$DOCUMENT_RECHERCHE_SHOWED_FICHES =", "\$DOCUMENT_RECHERCHE_SHOWED_FICHES = ".$_REQUEST["document_recherche_showed_fiches"]."; ", $CONFIG_DIR);
}

$aff_montant_result = 0;
if (isset($_REQUEST["document_recherche_montant_total"]) && is_numeric($_REQUEST["document_recherche_montant_total"])) {
$aff_montant_result = 1;
}
	maj_configuration_file ("config_generale.inc.php", "maj_line", "\$DOCUMENT_RECHERCHE_MONTANT_TOTAL =", "\$DOCUMENT_RECHERCHE_MONTANT_TOTAL = ".$aff_montant_result."; ", $CONFIG_DIR);


// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_configuration_affichage_maj.inc.php");
?>