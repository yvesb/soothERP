<?php
// *************************************************************************************************************
// Modification ordre TPE
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");


//ouverture de la class compte_tpe
	$compte_tpe = new compte_tpe ($_REQUEST["id_compte_tpe"]);

	//modification de l'ordre du compte
	$compte_tpe->modifier_ordre ($_REQUEST["new_ordre"]);

// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_compta_compte_tpes_ordre.inc.php");

?>