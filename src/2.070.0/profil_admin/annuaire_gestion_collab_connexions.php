<?php
// *************************************************************************************************************
// RECHERCHE DES CONNEXIONS DES UTILISATEURS COLLAB
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");


// *************************************************************************************************************
// TRAITEMENTS
// *************************************************************************************************************

	// *************************************************
// Profils à afficher

$profils_avancees = array();
foreach ($_SESSION['profils'] as $profil) {
	if ($profil->getActif() != 1) { continue; }
	$profils_avancees[] = $profil;
}
unset ($profil);
foreach ($_SESSION['profils'] as $profil) {
	if ($profil->getActif() != 2 ) { continue; }
	$profils_avancees[] = $profil;
}
unset ($profil);
if (isset($_REQUEST["ref_contact"])) {
	$contact = new contact($_REQUEST["ref_contact"]);
	
	$ANNUAIRE_CATEGORIES	=	get_categories();
	
// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************
	
	include ($DIR.$_SESSION['theme']->getDir_theme()."page_annuaire_gestion_collab_connexions.inc.php");
}
?>