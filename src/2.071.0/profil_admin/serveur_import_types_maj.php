<?php
// *************************************************************************************************************
// MODIFICATION DE L'IMPEX POUR UN SERVEUR D'IMPORT
// *************************************************************************************************************

$_PAGE['MUST_BE_LOGIN'] = 0;
require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");


$import_serveur = new import_serveur ($_REQUEST["ref_serveur_import"]);
if ($_REQUEST["autorise"]) {
$import_serveur->add_impex ($_REQUEST["id_impex_type"]);
} else {
$import_serveur->del_impex ($_REQUEST["id_impex_type"]);
}


// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

	include ($DIR.$_SESSION['theme']->getDir_theme()."page_serveur_import_types_maj.inc.php");
?>