<?php
// *************************************************************************************************************
// GESTION DES DOCUMENTS (Suppression d'un modele pdf)
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");

if (isset ($_REQUEST["id_pdf_modele"])) {
	//récupération du modele pdf choisi
	$model_infos = charge_modele_pdf ($_REQUEST["id_pdf_modele"]);
	$config_file_url = $PDF_MODELES_DIR."config/".$model_infos->code_pdf_modele.".config.php";
	$class_file_url = $PDF_MODELES_DIR.$model_infos->code_pdf_modele.".class.php";
	// On supprime dans la base de données
	supprime_art_modele_pdf ($_REQUEST["id_pdf_modele"]) ;	
	// On supprime les deux fichiers liés au modèle
	unlink($config_file_url);
	unlink($class_file_url);
}
// *************************************************************************************************************
// AFFICHAGE
// -*************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_communication_mod_fiche_art_sup.inc.php");

?>