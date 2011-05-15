<?php
// *************************************************************************************************************
// PREVIEW DE MODELE DE MAIL
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");


 $envoi = charger_envoi_newsletter ($_REQUEST["id_envoi"]);

echo $envoi->entete.$envoi->contenu.$envoi->pied;
// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************
//include ($DIR.$_SESSION['theme']->getDir_theme()."page_communication_newsletters_gestion_envoi_preview.inc.php");

?>