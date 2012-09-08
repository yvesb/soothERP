<?php
// *************************************************************************************************************
// CONFIGURATION DES  options 
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");



//mise à jour des données transmises

if (isset($_REQUEST["view_bt_iti"])) {
	maj_configuration_file ("config_generale.inc.php", "maj_line", "\$VIEW_BT_ITI =", "\$VIEW_BT_ITI = \"1\"; //voir le bouton itinéraire", $CONFIG_DIR);
} else {
	maj_configuration_file ("config_generale.inc.php", "maj_line", "\$VIEW_BT_ITI =", "\$VIEW_BT_ITI = \"0\"; //voir le bouton itinéraire", $CONFIG_DIR);
}

if (isset($_REQUEST["view_bt_map"])) {
	maj_configuration_file ("config_generale.inc.php", "maj_line", "\$VIEW_BT_MAP =", "\$VIEW_BT_MAP = \"1\"; //voir le bouton carte", $CONFIG_DIR);
} else {
	maj_configuration_file ("config_generale.inc.php", "maj_line", "\$VIEW_BT_MAP =", "\$VIEW_BT_MAP = \"0\"; //voir le bouton carte", $CONFIG_DIR);
}
// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_configuration_entreprise_options_maj.inc.php");
?>