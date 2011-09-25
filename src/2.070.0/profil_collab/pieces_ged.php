<?php
// *************************************************************************************************************
// CHARGEMENTS DES PIECES JOINTES D'UN OBJET
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");


//**************************************
// Controle

$type_objet = $_REQUEST["type_objet"];
$ref_objet = $_REQUEST["ref_objet"];
$pieces = charger_ged ($type_objet, $ref_objet);
$types = charger_types_ged();

$fichiers_tmp = array();
$folder = "../fichiers/ged_tmp";
$dossier = opendir($folder);
while ($Fichier = readdir($dossier)) {
  if ($Fichier != "." && $Fichier != ".." && $Fichier != "grand_format") {
    $fichiers_tmp[] = $Fichier;
  }
}
closedir($dossier);
// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_pieces_ged.inc.php");

?>