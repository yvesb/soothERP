<?php
//  ******************************************************
// SUPPRESSION DE LA COORDONNEE D'UN CONTACT
//  ******************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");


if (isset($_REQUEST['coordonnee_ref'.$_REQUEST['ref_idform']])) {	
	// *************************************************
	// création d'une coordonnée
	$ref_coordonnee  = $_REQUEST['coordonnee_ref'.$_REQUEST['ref_idform']];
	
	$coordonnee = new coordonnee ($ref_coordonnee);
	
	// on récupére tout les réf_coord qui sont aprés la réf_coord supprimée pour rafraichir l'affichage des ordres
	$coords = $coordonnee->liste_ref_coord_in_ordre ();
	
	$coordonnee->suppression();
}
//  ******************************************************
// AFFICHAGE
// - ******************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_annuaire_edition_valid_coordonnee_supprime.inc.php");

?>