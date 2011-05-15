<?php
// *************************************************************************************************************
// GESTION DES PDF STATS
// *************************************************************************************************************

require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");


//variable nécessaires aux newsletter
$mail_templates = charger_mail_templates();

$liste_id_results = 1;
$liste_export_modeles = charge_modele_export_result_commerciaux();
$liste_pour_activation = getListeExportResultatsCommerciaux();

// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_communication_mod_export_resultat_commerciaux.inc.php");

//include ($DIR.$_SESSION['theme']->getDir_theme()."page_articles_gestion_categ.inc.php");

?>