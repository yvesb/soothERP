<?php
// *************************************************************************************************************
// GESTION DES NEWSLETTERS
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");


//variable nécessaires aux newsletter
$mail_templates = charger_mail_templates();


// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_communication_mail_templates.inc.php");

?>