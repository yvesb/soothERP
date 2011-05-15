<?php
// *************************************************************************************************************
// MODIFICATION DU COMPTE PAR DEFAUT D'UNE CATEGORIE D'ARTICLE
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");


if (isset($_REQUEST['retour_ref_art_categ'])) {	
	// *************************************************
	// Controle des données fournies par le formulaire

	$defaut_numero_compte				= $_REQUEST['retour_value'];
	
		$compte_plan_general = new compta_plan_general ($defaut_numero_compte);
		$compte_plan_general->active_compte ();
	// *************************************************
	// Création de la catégorie
	$art_categ = new art_categ ($_REQUEST['retour_ref_art_categ']);
	$art_categ->maj_defaut_numero_compte ($defaut_numero_compte);
}

// *************************************************************************************************************
// AFFICHAGE
// -*************************************************************************************************************


?>