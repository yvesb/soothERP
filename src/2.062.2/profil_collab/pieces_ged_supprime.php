<?php
// *************************************************************************************************************
// SUPRESSION D'un FICHIER PIECE JOINTE
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");

//***********************************
$type_objet = $_REQUEST["type_objet"];
$ref_objet = $_REQUEST["ref_objet"];
if (isset ($_REQUEST["id_piece"]) && isset ($_REQUEST["fichier"])) {del_ged ($_REQUEST["id_piece"], $_REQUEST["fichier"]);}
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