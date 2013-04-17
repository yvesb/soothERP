<?php
// *************************************************************************************************************
// ACCUEIL DE L'UTILISATEUR ADMINISTRATEUR
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");


$art_categs = new art_categ ($_REQUEST['ref_art_categ']);
$id_modele	=	$art_categs->getModele ();

//liste des lieux de stockage
$stocks_liste	= array();
$stocks_liste = $_SESSION['stocks'];

//******************************************************************************************************
// AFFICHAGE
//******************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_catalogue_articles_edition_new_modele_".$id_modele.".inc.php");

?>