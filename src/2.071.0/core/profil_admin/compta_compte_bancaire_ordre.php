<?php
// *************************************************************************************************************
// ACCUEIL DE L'UTILISATEUR ADMINISTRATEUR
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");


//ouverture de la class compte_bancaire
	$compte_bancaire = new compte_bancaire ($_REQUEST["id_compte_bancaire"]);

	
	
	//modifier ordre du compte
	$compte_bancaire->modifier_ordre ($_REQUEST["new_ordre"]);

// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_compta_compte_bancaire_ordre.inc.php");

?>