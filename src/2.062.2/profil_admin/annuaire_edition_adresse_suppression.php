<?php
// *************************************************************************************************************
// SUPPRESSION DE L'ADRESSE D'UN CONTACT
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");


if (isset($_REQUEST['adresse_ref'.$_REQUEST['ref_idform']])) {	
	// *************************************************
	// Suppression de l'adresse
	$adresse = new adresse ($_REQUEST['adresse_ref'.$_REQUEST['ref_idform']]);
	
	// on récupére tout les réf_adresse qui sont aprés la réf_adresse supprimée pour rafraichir l'affichage des ordres
	$adress = $adresse->liste_ref_adresse_in_ordre ();
	
	$adresse->suppression();
}
// *************************************************************************************************************
// AFFICHAGE
// -*************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_annuaire_edition_valid_adresse_supprime.inc.php");

?>