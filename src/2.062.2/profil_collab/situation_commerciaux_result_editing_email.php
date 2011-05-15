<?php
// *************************************************************************************************************
// ENVOI D'UN DOCUMENT PAR EMAIL
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");


	$liste_email = array();
	
	$contact_entreprise = new contact($REF_CONTACT_ENTREPRISE);
	
	

// *************************************************************************************************************
// AFFICHAGE
// -*************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_situation_commerciaux_result_editing_email.inc.php");

?>