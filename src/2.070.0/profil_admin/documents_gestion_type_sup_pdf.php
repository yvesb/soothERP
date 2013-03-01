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
	echo $model_infos->code_pdf_modele.'<br/>';
	if($model_infos->code_pdf_modele != 'doc_standard'){
		$config_file_url = $PDF_MODELES_DIR."config/".$model_infos->code_pdf_modele.".config.php";
		$class_file_url = $PDF_MODELES_DIR.$model_infos->code_pdf_modele.".class.php";

		// On supprime les deux fichiers liés au modèle
		unlink($config_file_url);
		unlink($class_file_url);
	// On supprime dans la base de données
		supprime_doc_modele_pdf ($_REQUEST["id_pdf_modele"]);
	}
}
// *************************************************************************************************************
// AFFICHAGE
// -*************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_documents_gestion_type_mod.inc.php");

?>