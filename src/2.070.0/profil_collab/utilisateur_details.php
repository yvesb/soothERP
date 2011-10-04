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


$profils 	= $contact->getProfils();
}
//permission (7) Gestion des collaborateurs permission (8) Gestion des administrateurs
if ((!$_SESSION['user']->check_permission ("7") && isset($profils[$COLLAB_ID_PROFIL])) || (!$_SESSION['user']->check_permission ("8") && isset($profils[$ADMIN_ID_PROFIL]))) { 
	echo "<br /><span style=\"font-weight:bolder;color:#FF0000;\">Vos droits  d'accés ne vous permettent pas de visualiser ces informations</span>"; 
} else {

	$users = $utilisateur->liste_ref_user_actif();
	
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
}
?>