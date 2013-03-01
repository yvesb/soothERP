<?php
// *************************************************************************************************************
// ACCUEIL DE L'UTILISATEUR ADMINISTRATEUR
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");
require ($DIR.$_SESSION['theme']->getDir_theme()."_theme.config.php" );



// Controle

	if (!isset($_REQUEST['ref_art_categs'])) {
		echo "La référence de la catégorie n'est pas précisée";
		exit;
	}
	
	$art_categ = new art_categ ($_REQUEST['ref_art_categs']);
	if (!$art_categ->getRef_art_categ()) {
		echo "La référence de la catégorie est inconnue";		exit;

	}

// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

	
$tarifs_liste	= array();
$tarifs_liste = get_tarifs_listes_formules ($_REQUEST['ref_art_categs']);
	

//liste des taxes du pays par defaut
$taxes = taxes_pays($DEFAUT_ID_PAYS);

//liste des tvas du pays par defaut
$tvas = get_tvas ($DEFAUT_ID_PAYS);

unset($query, $resultat);

include ($DIR.$_SESSION['theme']->getDir_theme()."page_catalogue_categorie_inc_mod.inc.php");

?>