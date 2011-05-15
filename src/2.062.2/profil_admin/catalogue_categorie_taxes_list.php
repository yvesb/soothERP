<?php
// *************************************************************************************************************
// LISTE DES TAXES 
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");



if (!isset($_REQUEST['ref_art_categs'])) {
	echo "La référence de la catégorie n'est pas précisée";
	exit;
}

$art_categ = new art_categ ($_REQUEST['ref_art_categs']);
if (!$art_categ->getRef_art_categ()) {
	echo "La référence de la catégorie est inconnue";		exit;

}
	
$taxes = taxes_pays($_REQUEST['taxe_id_pays']);

// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************


include ($DIR.$_SESSION['theme']->getDir_theme()."page_catalogue_categorie_taxes_list.inc.php");

?>