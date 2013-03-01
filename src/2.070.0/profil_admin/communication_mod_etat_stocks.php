<?php
// *************************************************************************************************************
// GESTION DES PDF STATS
// *************************************************************************************************************

require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");

//variable nécessaires aux newsletter
$mail_templates = charger_mail_templates();

$liste_id_stats = 1;
$liste_pdf_modeles = stock::charge_modele_pdf();
$liste_pour_activation = stock::getListePdf();

// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_communication_mod_etat_stocks.inc.php");


?>