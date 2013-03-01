<?php
// *************************************************************************************************************
// ACCUEIL DE L'UTILISATEUR ADMINISTRATEUR
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");
require ($DIR.$_SESSION['theme']->getDir_theme()."_theme.config.php" );
require_once ($DIR."_article_liaisons_types.class.php");

if(!$_SESSION['user']->check_permission ("38")){
		echo "<br /><span style=\"font-weight:bolder;color:#FF0000;\">Vos droits  d'accés ne vous permettent pas de visualiser ce type de document</span>";
		exit();
}

//liste des lieux de stockage
$stocks_liste	= array();
$stocks_liste = $_SESSION['stocks'];	

// Charge les différents types de liaisons existants
$liaisons_type_liste = art_liaison_type::getLiaisons_type();
	
//liste des constructeurs
$constructeurs_liste = array();
$constructeurs_liste = get_constructeurs ();
	
// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_catalogue_articles.inc.php");

?>