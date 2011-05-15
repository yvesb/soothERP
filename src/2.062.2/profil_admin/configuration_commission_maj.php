<?php
// *************************************************************************************************************
// CONFIG DES COMMISSIONS COMMERCIAUX
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");


//mise à jour des données transmises

$gestion_comm_commerciaux = 0;
if (isset($_REQUEST["gestion_comm_commerciaux"]) && is_numeric($_REQUEST["gestion_comm_commerciaux"])) {
	$gestion_comm_commerciaux = 1;
}
	maj_configuration_file ("config_generale.inc.php", "maj_line", "\$GESTION_COMM_COMMERCIAUX = ", "\$GESTION_COMM_COMMERCIAUX = ".$gestion_comm_commerciaux.";", $CONFIG_DIR);

// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_configuration_commission_maj.inc.php");
?>