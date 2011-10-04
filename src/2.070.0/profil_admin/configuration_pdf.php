<?php
// *************************************************************************************************************
// CONFIG DES DONNEES pdf
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");


$liste_type_docs = fetch_all_types_docs ();

$liste_pdf_modeles = charge_modele_pdf_document();

$liste_filigranes = charger_filigranes ();
// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_configuration_pdf.inc.php");

?>