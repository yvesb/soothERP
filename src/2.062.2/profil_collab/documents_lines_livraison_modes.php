<?php
// *************************************************************************************************************
// MAJ DE L'ETAT D'UN DOCUMENT et ouverture d'un nouveau document
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");



if (isset($_REQUEST['ref_doc'])) {
// ouverture des infos du document et mise à jour
	$ref_doc= $_REQUEST['ref_doc'];
	$document = open_doc ($ref_doc);
	
	
	
	$livraison_modes = charger_livraisons_modes();
	
	foreach ($livraison_modes as $liv_mod) {
		$tmp_livraison_mode = new livraison_modes ($liv_mod->id_livraison_mode);
		$tmp_livraison_mode->contenu_calcul_frais_livraison($document);
		$liv_mod->nd = 0;
		if (isset($GLOBALS['_INFOS']['calcul_livraison_mode_ND']) || isset($GLOBALS['_INFOS']['calcul_livraison_mode_nozone']) || isset($GLOBALS['_INFOS']['calcul_livraison_mode_impzone'])) {
			$liv_mod->nd = 1;
			unset($GLOBALS['_INFOS']['calcul_livraison_mode_ND'], $GLOBALS['_INFOS']['calcul_livraison_mode_nozone'], $GLOBALS['_INFOS']['calcul_livraison_mode_impzone']);
		}
	}
	sort($livraison_modes);
	

// *************************************************************************************************************
// AFFICHAGE
// -*************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_documents_lines_livraison_modes.inc.php");
}


?>
