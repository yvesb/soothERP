<?php
// *************************************************************************************************************
// CONFIG DES DONNEES du logiciel
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");



//mise à jour des données transmises
if (isset($_REQUEST["session_lt"]) && is_numeric($_REQUEST["session_lt"])) {
	maj_configuration_file ("config_generale.inc.php", "maj_line", "\$SESSION_LT =", "\$SESSION_LT = ".($_REQUEST["session_lt"]*3600).";										// Durée de vie de la session Système", $CONFIG_DIR);
}
if (isset($_REQUEST["user_session_lt"]) && is_numeric($_REQUEST["user_session_lt"])) {
	maj_configuration_file ("config_generale.inc.php", "maj_line", "\$USER_SESSION_LT =", "\$USER_SESSION_LT = ".($_REQUEST["user_session_lt"]*60).";									// Durée de vie de la session Utilisateur", $CONFIG_DIR);
}




// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_configuration_divers_maj.inc.php");
?>