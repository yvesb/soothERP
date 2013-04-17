<?php
// *************************************************************************************************************
// DELIER D'UN REGLEMENT
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");

		
if (isset($_REQUEST["ref_reglement"])) {

	if (isset($_REQUEST["ref_doc"])) {

	$document = open_doc($_REQUEST["ref_doc"]);
	//supression du règlement
	$document->delier_reglement ($_REQUEST["ref_reglement"]);  
	}
	
}


// *************************************************************************************************************
// AFFICHAGE
// -*************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_compta_reglements_delier.inc.php");

?>