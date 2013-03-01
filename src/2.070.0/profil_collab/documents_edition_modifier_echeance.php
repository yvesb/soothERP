<?php
// *************************************************************************************************************
// RETOUR MODIFICATION D ECHEANCE
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");

$ref_doc = $_REQUEST["ref_doc"];
$montant_acquite = $_REQUEST["montant_acquite"];
$reglements_modes = getReglements_modes();
$modeles = modele_echeancier::charger_modeles_echeances();
// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_documents_edition_modifier_echeance.inc.php");

?>
