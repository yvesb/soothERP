<?php
// *************************************************************************************************************
// GESTION DU PARAMETRAGE DE COURRIER PDF
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");

//chargement du modèle
$modele_pdf = charge_modele_pdf ($_REQUEST["id_pdf_modele"]);

//chargement des infos de configuration du modèle
$config_files = file($PDF_MODELES_DIR."config/".$modele_pdf->code_pdf_modele.".config.php");
	
// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_courriers_gestion_type_param_pdf.inc.php");

?>