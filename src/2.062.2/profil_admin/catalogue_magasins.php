<?php
// *************************************************************************************************************
// ACCUEIL DE L'UTILISATEUR ADMINISTRATEUR
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");

// liste des magasins
$magasins_liste	= charger_all_magasins ();

//liste des lieux de stockage
$stocks_liste	= array();
$stocks_liste = $_SESSION['stocks'];
		
//liste des tarifs
$tarifs_liste	= array();
$tarifs_liste = get_full_tarifs_listes ();

$liste_enseignes = charger_all_enseignes ();
	
//chargement de la liste des catalogues clients
$catalogues_clients = catalogue_client::charger_liste_catalogues_clients ();

// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_catalogue_magasins.inc.php");

?>