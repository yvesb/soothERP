<?php
// *************************************************************************************************************
// ACCUEIL DE L'UTILISATEUR ADMINISTRATEUR
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");

// Fichier de configuration de ce profil
include_once ($CONFIG_DIR."profil_fournisseur.config.php");

// chargement de la class du profil
contact::load_profil_class($FOURNISSEUR_ID_PROFIL);

//suppression de la catégorie
contact_fournisseur::delete_infos_fournisseurs_categories ($_REQUEST["id_fournisseur_categ"]);

// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_annuaire_gestion_categories_fournisseur_sup.inc.php");

?>