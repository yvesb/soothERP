<?php
// *************************************************************************************************************
// CONFIG DES DONNEES du catalogue
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");


$tvas = get_tvas ($DEFAUT_ID_PAYS);

require_once ($DIR."_article_liaisons_types.class.php");

//on charge Toutes les liaisons existantes
	$liaisons_liste	= get_liaisons_types_exist();
// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_configuration_catalogue.inc.php");

?>