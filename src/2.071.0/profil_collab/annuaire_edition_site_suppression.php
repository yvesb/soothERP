<?php
// *************************************************************************************************************
// ACCUEIL DE L'UTILISATEUR ADMINISTRATEUR
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");


if (isset($_REQUEST['site_ref'.$_REQUEST['ref_idform']])) {	
	// *************************************************
	// création d'une coordonnée
	$site_ref  = $_REQUEST['site_ref'.$_REQUEST['ref_idform']];
	
	
	$site = new site ($site_ref);
	
	// on récupére tout les réf_site qui sont aprés et celui juste avant la réf_site supprimée pour rafraichir l'affichage des ordres
	$sites = $site->liste_ref_site_in_ordre();

	$site->suppression();
}
// *************************************************************************************************************
// AFFICHAGE
// -*************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_annuaire_edition_valid_site_supprime.inc.php");

?>