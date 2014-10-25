<?php
// *************************************************************************************************************
// GESTION des terminaux de paiement electronique et virtuels
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");

$comptes_tpes	= compte_tpe::charger_actif_comptes_tpes ();
$comptes_tpv	= compte_tpv::charger_comptes_tpv ();

// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_compta_gestion_terminaux.inc.php");

?>