<?php

// *************************************************************************************************************
// CLASSES A CHARGER POUR LA GESTION DES MODULES
// *************************************************************************************************************
$modules = array ("import_annuaire_csv", "import_catalogue_csv");

foreach ($modules as $module) {
	require_once ($DIR."modules/_module_".$module.".class.php");
	require_once ($DIR."modules/_module_".$module.".config.php");
}

?>