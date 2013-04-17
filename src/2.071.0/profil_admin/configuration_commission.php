<?php
// *************************************************************************************************************
// CONFIG DES COMMISSIONNEMENTS COMMERCIAUX
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");


if ($COMMERCIAL_ID_PROFIL != 0) {
	include ($CONFIG_DIR."profil_".$_SESSION['profils'][$COMMERCIAL_ID_PROFIL]->getCode_profil().".config.php"); 
	contact::load_profil_class($COMMERCIAL_ID_PROFIL);
	$liste_categories_commercial = contact_commercial::charger_commerciaux_categories ();
	$liste_commissions_regles = contact_commercial::charger_commissions_regles ();
}

$liste_commerciaux = charger_liste_commerciaux ();
//infos pour mini moteur de recherche contact
$profils_mini = array();
foreach ($_SESSION['profils'] as $profil) {
	if ($profil->getId_profil() == $COMMERCIAL_ID_PROFIL) {continue;}
	if ($profil->getActif() != 1 && $profil->getActif() != 2) { continue; }
	$profils_mini[] = $profil;
}
unset ($profil);

$ANNUAIRE_CATEGORIES	=	get_categories();

// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_configuration_commission.inc.php");

?>