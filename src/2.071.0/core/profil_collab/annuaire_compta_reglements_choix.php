<?php
// *************************************************************************************************************
// NOUVEAU DOCUMENT
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");




//liste des lieux de stockage
$stocks_liste	= array();
$stocks_liste = $_SESSION['stocks'];

$ref_contact = $_REQUEST['ref_contact'];

//liste des reglements_modes
$reglements_modes	= array();
$reglements_modes = getReglements_modes ($_REQUEST['mode']);


// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_annuaire_compta_reglements_choix.inc.php");

?>