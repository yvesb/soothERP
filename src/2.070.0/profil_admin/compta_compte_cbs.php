<?php
// *************************************************************************************************************
// ACCUEIL GESTION COMPTES CARTE BANCAIRE
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");


//chargement des comptes carte bancaire
$comptes_cbs	= compte_cb::charger_comptes_cbs();

//liste des comptes bancaires
$comptes_bancaires = compte_bancaire::charger_comptes_bancaires ("", 1);

//liste des types de cartes
$types_cbs = compte_cb::get_carte_bancaire_types () ;

//infos pour mini moteur de recherche contact
$profils_mini = array();
foreach ($_SESSION['profils'] as $profil) {
	if ($profil->getActif() != 1) { continue; }
	$profils_mini[] = $profil;
}
unset ($profil);
foreach ($_SESSION['profils'] as $profil) {
	if ($profil->getActif() != 2 ) { continue; }
	$profils_mini[] = $profil;
}
unset ($profil);

// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_compta_compte_cbs.inc.php");

?>