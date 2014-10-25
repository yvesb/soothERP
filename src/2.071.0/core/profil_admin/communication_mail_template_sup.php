<?php
// *************************************************************************************************************
// ACCUEIL DE L'UTILISATEUR ADMINISTRATEUR
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");

//ouverture de la class mail_template
$mail_template = new mail_template ($_REQUEST["id_mail_template"]);

//supression du template
$mail_template->suppression ();

// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************
include ($DIR.$_SESSION['theme']->getDir_theme()."page_communication_mail_template_sup.inc.php");

?>