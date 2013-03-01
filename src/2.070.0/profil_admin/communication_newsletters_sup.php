<?php
// *************************************************************************************************************
// ACCUEIL DE L'UTILISATEUR ADMINISTRATEUR
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");

//ouverture de la class newsletter
$newsletter = new newsletter ($_REQUEST["id_newsletter"]);

//supression du compte
$newsletter->suppression ();

// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************
include ($DIR.$_SESSION['theme']->getDir_theme()."page_communication_newsletters_sup.inc.php");

?>