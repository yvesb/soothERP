<?php
// *************************************************************************************************************
// ACCUEIL DE L'UTILISATEUR ADMINISTRATEUR
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");

// Préparations des variables d'affichage
$ANNUAIRE_CATEGORIES	=	get_categories();

$civilites = get_civilites ($ANNUAIRE_CATEGORIES[0]->id_categorie);


//liste des pays pour affichage dans select
$listepays = getPays_select_list ();

//liste des langages
$langages = getLangues ();

//infos pour mini moteur de recherche contact
$profils_mini = array();
foreach ($_SESSION['profils'] as $profil) {
	if ($profil->getActif() != 1 && $profil->getActif() != 2) { continue; }
	$profils_mini[] = $profil;
}
unset ($profil);

// *************************************************************************************************************
// AFFICHAGE
// -*************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_annuaire_nouvelle_fiche.inc.php");

?>