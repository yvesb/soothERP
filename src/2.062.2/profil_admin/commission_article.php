<?php
// *************************************************************************************************************
// commissionnements des articles 
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");


if ($COMMERCIAL_ID_PROFIL != 0) {
	include ($CONFIG_DIR."profil_".$_SESSION['profils'][$COMMERCIAL_ID_PROFIL]->getCode_profil().".config.php"); 
	contact::load_profil_class($COMMERCIAL_ID_PROFIL);
	$liste_commissions_regles = contact_commercial::charger_commissions_regles ();
}

// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_commission_article.inc.php");

?>