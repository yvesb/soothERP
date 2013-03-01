<?php
// *************************************************************************************************************
// ACCUEIL COMPTA automatique TIERS Vente (catégories de clients)
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");



if (!$_SESSION['user']->check_permission ("13")) {
	//on indique l'interdiction et on stop le script
	echo "<br /><span style=\"font-weight:bolder;color:#FF0000;\">Vos droits  d'accés ne vous permettent pas de visualiser ce type de page</span>";
	exit();
}


include_once ($CONFIG_DIR."profil_client.config.php");
// chargement de la class du profil
contact::load_profil_class($CLIENT_ID_PROFIL);
// Préparations des variables d'affichage
$liste_categories = contact_client::charger_clients_categories ();

// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_compta_automatique_tiers_vente.inc.php");

?>