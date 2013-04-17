<?php
// *************************************************************************************************************
// AAFFICHAGE DE L'EDITION D'UN DOCUMENT (partie boutons)
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");
require_once ($DIR."_article.class.php");

//chargement des modes d'édition
$editions_modes	= liste_mode_edition();

if (isset($_REQUEST["ref_article"])) {
	$liste_pdf_modeles = charge_modele_pdf_article ();
	$article = new article ($_REQUEST['ref_article']);
	$mod_defaut = 0;
	$liste_modeles_pdf_valides = getListeOnByCat($article->getRef_art_categ(), $mod_defaut);
}

//$filigrane_pdf = charger_filigranes ();

// *************************************************************************************************************
// AFFICHAGE
// -*************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_catalogue_articles_editing_button.inc.php");




?>