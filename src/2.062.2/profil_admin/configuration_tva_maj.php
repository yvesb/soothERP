<?php
// *************************************************************************************************************
// CONFIGURATION DES DONNÉES tarifs
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");


//mise à jour des données transmises

$assujetti_tva = 0;
if (isset($_REQUEST["assujetti_tva"]) && is_numeric($_REQUEST["assujetti_tva"])) {
	$assujetti_tva = 1;
}
	maj_configuration_file ("config_generale.inc.php", "maj_line", "\$ASSUJETTI_TVA				= ", "\$ASSUJETTI_TVA				= ".$assujetti_tva.";								// entreprise soumis à la tva", $CONFIG_DIR);


if (!$assujetti_tva) {
	maj_configuration_file ("config_generale.inc.php", "maj_line", "\$DEFAUT_ID_TVA				=", "\$DEFAUT_ID_TVA				= 0;								// Taux de TVA par défaut pour les catégories d'articles", $CONFIG_DIR);
}
// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_configuration_tva_maj.inc.php");
?>