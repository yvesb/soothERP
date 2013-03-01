<?php
// *************************************************************************************************************
// ACCUEIL COMPTA automatique des TPE et TPV
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");


if (!$_SESSION['user']->check_permission ("13")) {
	//on indique l'interdiction et on stop le script
	echo "<br /><span style=\"font-weight:bolder;color:#FF0000;\">Vos droits  d'accés ne vous permettent pas de visualiser ce type de page</span>";
	exit();
}

$comptes_tpes	= compte_tpe::charger_actif_comptes_tpes ();
$comptes_tpv	= compte_tpv::charger_comptes_tpv ();
// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_compta_automatique_tps.inc.php");

?>