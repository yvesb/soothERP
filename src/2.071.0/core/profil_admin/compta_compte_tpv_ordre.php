<?php
// *************************************************************************************************************
// Modification ordre TPV
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");


//ouverture de la class compte_tpv
	$compte_tpv = new compte_tpv ($_REQUEST["id_compte_tpv"]);

	//modification de l'ordre du compte
	$compte_tpv->modifier_ordre ($_REQUEST["new_ordre"]);

// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_compta_compte_tpv_ordre.inc.php");

?>