<?php
// *************************************************************************************************************
// CONFIGURATION DES DONNÉES DES DOCUMENTS
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");



//mise à jour des données transmises
if (isset($_REQUEST["document_recherche_showed_fiches"]) && is_numeric($_REQUEST["document_recherche_showed_fiches"])) {
	maj_configuration_file ("config_generale.inc.php", "maj_line", "\$DOCUMENT_RECHERCHE_SHOWED_FICHES =", "\$DOCUMENT_RECHERCHE_SHOWED_FICHES = ".$_REQUEST["document_recherche_showed_fiches"]."; ", $CONFIG_DIR);
}


if (isset($_REQUEST["aff_remises"]) && $_REQUEST["aff_remises"] == "1") {
	maj_configuration_file ("config_generale.inc.php", "maj_line", "\$AFF_REMISES	=", "\$AFF_REMISES	= 1;", $CONFIG_DIR);
} else {
	maj_configuration_file ("config_generale.inc.php", "maj_line", "\$AFF_REMISES	=", "\$AFF_REMISES	= 0;", $CONFIG_DIR);
}



// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_configuration_documents_maj.inc.php");
?>