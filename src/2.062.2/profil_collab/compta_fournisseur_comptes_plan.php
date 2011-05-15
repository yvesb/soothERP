<?php
// *************************************************************************************************************
// ACCUEIL COMPTA FOURNISSEUR COMPTEES DU PLAN 
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");



if (!$_SESSION['user']->check_permission ("13")) {
	//on indique l'interdiction et on stop le script
	echo "<br /><span style=\"font-weight:bolder;color:#FF0000;\">Vos droits  d'accés ne vous permettent pas de visualiser ce type de page</span>";
	exit();
}

//profil affichés pour la recherche simple
$profils = array();
foreach ($_SESSION['profils'] as $profil) {
	if ($profil->getActif() != 1) { continue; }
	$profils[] = $profil;
}
unset ($profil);

//profil affichés pour la recherche avancee
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

	if ($CLIENT_ID_PROFIL != 0) {
		include ($CONFIG_DIR."profil_".$_SESSION['profils'][$FOURNISSEUR_ID_PROFIL]->getCode_profil().".config.php");
		contact::load_profil_class($FOURNISSEUR_ID_PROFIL);
		$liste_categories_fournisseur = contact_fournisseur::charger_fournisseurs_categories ();
	}

$ANNUAIRE_CATEGORIES	=	get_categories();


// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_compta_fournisseur_comptes_plan.inc.php");

?>