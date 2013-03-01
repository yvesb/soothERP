<?php
// *************************************************************************************************************
// ACCUEIL GESTION TPV
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");


	$comptes_tpv	= compte_tpv::charger_comptes_tpv();
	$comptes_bancaires = compte_bancaire::charger_comptes_bancaires ("", 1);


// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_compta_compte_tpv.inc.php");

?>