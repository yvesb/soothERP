<?php
// *************************************************************************************************************
// affichage ar de fonds pour caisse 
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");


if (isset($_REQUEST["id_compte_caisse"])) {
	$compte_caisse	= new compte_caisse($_REQUEST["id_compte_caisse"]);
	$compte_caisse_ar = $compte_caisse->charger_ar_caisse ($_REQUEST["id_compte_caisse_ar"]);
	// *************************************************************************************************************
	// AFFICHAGE
	// *************************************************************************************************************
	include ($DIR.$_SESSION['theme']->getDir_theme()."page_compta_ar_fonds_caisse_affiche.inc.php");
}
?>