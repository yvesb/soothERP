<?php
// *************************************************************************************************************
// ACCUEIL DE L'UTILISATEUR ADMINISTRATEUR
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");


//ouverture de la class compte_caisse
	$compte_caisse = new compte_caisse ($_REQUEST["id_compte_caisse"]);
	
	
	//desactivation du compte
	$compte_caisse->desactive_compte ();


// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_compta_compte_caisse_desactive_compte.inc.php");
?>