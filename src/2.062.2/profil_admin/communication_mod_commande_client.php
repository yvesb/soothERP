<?php
// *************************************************************************************************************
// GESTION DES PDF COMMANDE CLIENT
// *************************************************************************************************************

require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");

//variable nécessaires aux newsletter
$mail_templates = charger_mail_templates();

$liste_id_stats = 1;
$liste_pdf_modeles = charge_modele_pdf_commande_client();
$liste_pour_activation = getListePdfCommandeClient();

// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_communication_mod_commande_client.inc.php");


?>