<?php
// *************************************************************************************************************
// RECHERCHE DES CONNEXIONS DES UTILISATEURS
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");

//liste des langages
$langages = getLangues ();

// *************************************************************************************************************
// TRAITEMENTS
// *************************************************************************************************************

if (isset($_REQUEST["ref_user"])) {

$utilisateur = new utilisateur($_REQUEST["ref_user"]);
$contact = new contact ($utilisateur->getRef_contact());


$liste_profils_contact = ($contact->getProfils ());
if (isset ($liste_profils_contact [$COLLAB_ID_PROFIL])) {
}

}
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


$ANNUAIRE_CATEGORIES	=	get_categories();

// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_utilisateur_details.inc.php");

?>