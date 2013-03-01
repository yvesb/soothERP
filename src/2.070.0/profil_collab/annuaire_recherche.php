<?php
// *************************************************************************************************************
// [ADMINISTRATEUR] RECHERCHE D'UNE FICHE DE CONTACT
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");


// *************************************************************************************************************
// TRAITEMENTS
// *************************************************************************************************************

	// *************************************************
// Profils à afficher

$allowed_profils=explode(",",$_SESSION['user']->check_permission ("22"));

//liste des pays pour affichage dans select
$listepays = getPays_select_list ();


//profil affichés pour la recherche simple
$profils = array();
foreach ($_SESSION['profils'] as $key => $profil) {
	if ($profil->getActif() != 1 || (!in_array($key,$allowed_profils) && !in_array("ALL",$allowed_profils))) { continue; }
	$profils[] = $profil;
}
unset ($profil,$key);

//profil affichés pour la recherche avancee
$profils_avancees = array();
foreach ($_SESSION['profils'] as $key => $profil) {
	if ($profil->getActif() != 1 || (!in_array($key,$allowed_profils) && !in_array("ALL",$allowed_profils))) { continue; }
	$profils_avancees[] = $profil;
}
unset ($profil,$key);
foreach ($_SESSION['profils'] as $key => $profil) {
	if ($profil->getActif() != 2 || (!in_array($key,$allowed_profils) && !in_array("ALL",$allowed_profils))) { continue; }
	$profils_avancees[] = $profil;
}
unset ($profil,$key);

	if ($CLIENT_ID_PROFIL != 0) {
		include ($CONFIG_DIR."profil_".$_SESSION['profils'][$CLIENT_ID_PROFIL]->getCode_profil().".config.php");
		contact::load_profil_class($CLIENT_ID_PROFIL);
		$liste_categories_client = contact_client::charger_clients_categories ();
	}

$ANNUAIRE_CATEGORIES	=	get_categories();

// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_annuaire_recherche.inc.php");

?>