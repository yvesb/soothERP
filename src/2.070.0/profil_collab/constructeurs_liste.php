<?php
// *************************************************************************************************************
// [COLLABORRATEUR] RECHERCHE D'UN ARTICLE CATALOGUE
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");


// *************************************************************************************************************
// TRAITEMENTS
// *************************************************************************************************************

$ref_art_categ = "";

if (isset($_REQUEST["ref_art_categ"])) { $ref_art_categ = $_REQUEST["ref_art_categ"];}

//liste des constructeurs
$constructeurs_liste = array();
$constructeurs_liste = get_constructeurs ($ref_art_categ);


// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************
// on boucle sur tous les éléments
	$result = Array();
	if (count($constructeurs_liste)) {
	$result[] = "=Tous";
	$result[] = "0=Sans constructeur";
	foreach ($constructeurs_liste as $constructeur) {
    $result[] = $constructeur->ref_contact."=".($constructeur->nom);
  }
	} else {
	$result[] = "=Tous";
	}
  print implode(";", $result);

?>