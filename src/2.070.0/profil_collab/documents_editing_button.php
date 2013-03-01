<?php
// *************************************************************************************************************
// AAFFICHAGE DE L'EDITION D'UN DOCUMENT (partie boutons)
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");


//chargement des modes d'édition
$editions_modes	= liste_mode_edition();

if (isset($_REQUEST["ref_doc"])) {
	$document = open_doc ($_REQUEST['ref_doc']);
	$liste_modeles_pdf_valides = charger_modeles_pdf_valides ($document->getId_type_doc());
}

$filigrane_pdf = charger_filigranes ();

// *************************************************************************************************************
// AFFICHAGE
// -*************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_documents_editing_button.inc.php");




?>