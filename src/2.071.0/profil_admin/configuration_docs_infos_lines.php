<?php
// *************************************************************************************************************
// CONFIG DES MODELES DE LIGNES D'INFORMATIONS DE DOCUMENTS
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");


$types_liste	= array();
$types_liste = $_SESSION['types_docs'];

$liste_modeles =  charge_docs_infos_lines ();

// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_configuration_docs_infos_lines.inc.php");

?>