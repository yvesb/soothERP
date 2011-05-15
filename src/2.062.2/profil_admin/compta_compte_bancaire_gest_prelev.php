<?php
// *************************************************************************************************************
// ACCUEIL DE L'UTILISATEUR ADMINISTRATEUR
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");

$valeur = $_REQUEST['activ_prelev'];
maj_configuration_file ("config_generale.inc.php", "maj_line", "\$COMPTA_GEST_PRELEVEMENTS =", "\$COMPTA_GEST_PRELEVEMENTS = $valeur;", $CONFIG_DIR);
?>