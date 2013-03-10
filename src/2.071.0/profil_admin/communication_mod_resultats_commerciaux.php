<?php
// *************************************************************************************************************
// GESTION DES PDF Résultats commerciaux
// *************************************************************************************************************

require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");

//variable nécessaires aux newsletter
$mail_templates = charger_mail_templates();

$liste_id_stats = 1;
$liste_pdf_modeles = charge_modele_pdf_res_com();
$liste_pour_activation = getListePdfResultatsCommerciaux();

// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_communication_mod_resultats_commerciaux.inc.php");


?>