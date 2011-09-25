<?php
// *************************************************************************************************************
// ACCUEIL GESTION COMPTE COMPTABLE PAR DEFAUT
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");



if (isset($_REQUEST["retour_value"]) && isset($_REQUEST["indent"])) {
	maj_configuration_file ("config_generale.inc.php", "maj_line", "\$".$_REQUEST["indent"]." =", "\$".$_REQUEST["indent"]." = \"".$_REQUEST["retour_value"]."\";", $CONFIG_DIR);
}

// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************


?>