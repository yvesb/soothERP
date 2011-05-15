<?php
// *************************************************************************************************************
// AJOUT D'UN SERVEUR D'IMPORT
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");


// utilisation du @ pour ne pas avoir de message d'erreur 
@ $fichier_dist	= fopen($_REQUEST["url_serveur_import"].$ECHANGE_LMB_DIR."export_serveur_add.php","r" );
@ $info_fichier = fgets($fichier_dist, 4096);
@ fclose($fichier_dist);

$liste_impex = array();
if (strlen($info_fichier)>0) {

	$import_serveur = new import_serveur ();
	$import_serveur->create ($_REQUEST["ref_serveur_import"], $_REQUEST["lib_serveur_import"], $_REQUEST["url_serveur_import"]);


	//récupération de la liste des impex choisis
	foreach ($_REQUEST as $variable => $valeur) {
		if (substr ($variable, 0, 14) != "id_impex_type_") { continue; }
		$i = count($liste_impex);
		$liste_impex[$i] =	$valeur;
	}

	foreach ($liste_impex as $impex) {
		//enregistrement de la liste des impex 
		$import_serveur->add_impex ($impex);
	
	}

} else {
		$GLOBALS['_ALERTES']['serveur_non_trouvé'] = 1;
}
// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_serveur_import_add.inc.php");

?>