<?php
// *************************************************************************************************************
// ACCUEIL DE L'UTILISATEUR ADMINISTRATEUR
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");


if (isset($_REQUEST['id_tarif'])) {	
	// *************************************************
	// Controle des données fournies par le formulaire

	
	// *************************************************
	// Création de la catégorie
	$tarif_liste = new tarif_liste ($_REQUEST['id_tarif']);
	$tarif_liste->suppression ($_REQUEST['id_tarif_remplacement_'.$_REQUEST['id_tarif']]);
}

// *************************************************************************************************************
// AFFICHAGE
// -*************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_catalogue_liste_tarifs_sup.inc.php");

?>