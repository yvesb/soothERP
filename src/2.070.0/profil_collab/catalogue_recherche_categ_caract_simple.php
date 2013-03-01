<?php
// *************************************************************************************************************
// ACCUEIL DE L'UTILISATEUR ADMINISTRATEUR
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");



// Controle

	if (!isset($_REQUEST['ref_art_categ'])) {
		echo "La référence de la catégorie n'est pas précisée";
		exit;
	}

	$art_categ = new art_categ ($_REQUEST['ref_art_categ']);
	
	// on récupére la liste des caractéristiques

	$caracs= array();
	$query = "SELECT ref_carac, lib_carac, unite, allowed_values, default_value, moteur_recherche, variante, affichage, 
						acc.ref_carac_groupe, acc.ordre, accg.lib_carac_groupe
						FROM art_categs_caracs acc
						LEFT JOIN art_categs_caracs_groupes accg ON acc.ref_carac_groupe = accg.ref_carac_groupe
						WHERE acc.ref_art_categ = '".$_REQUEST['ref_art_categ']."' && moteur_recherche = 1 
						ORDER BY accg.ordre ASC, acc.ordre ASC";
	$resultat = $bdd->query ($query);
	while ($carac = $resultat->fetchObject()) { $caracs[] = $carac; }
	
	
	if (!$art_categ->getRef_art_categ()) {
		echo "La référence de la catégorie est inconnue";		exit;

	}

// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************


include ($DIR.$_SESSION['theme']->getDir_theme()."page_catalogue_recherche_categ_caract_simple.inc.php");

?>