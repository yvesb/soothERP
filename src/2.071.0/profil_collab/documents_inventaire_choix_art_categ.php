<?php
// *************************************************************************************************************
// CHOIX DES CATEGORIES POUR UN INVENTAIRE
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");



//liste des catégories d'articles
$list_art_categ =	get_articles_categories();
// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_documents_inventaire_choix_art_categ.inc.php");

?>