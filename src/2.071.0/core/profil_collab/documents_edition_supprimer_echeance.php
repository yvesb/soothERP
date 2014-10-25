<?php
// *************************************************************************************************************
// FUSION DE DOCUMENTS
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");

$ref_doc = $_REQUEST["ref_doc"];

global $bdd;

$query = "DELETE FROM `doc_echeanciers` WHERE `ref_doc` = '".$ref_doc."' ";
if($bdd->exec($query)){
// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_documents_edition_recharger_echeance.inc.php");
}
?>
