<?php
// *************************************************************************************************************
// GESTION CATEGORIE COMMERCIAL
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");

// Fichier de configuration de ce profil
include_once ($CONFIG_DIR."profil_commercial.config.php");

// chargement de la class du profil
contact::load_profil_class($COMMERCIAL_ID_PROFIL);

//suppression de la catégorie
contact_commercial::delete_infos_commerciaux_categories ($_REQUEST["id_commercial_categ"]);

// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_annuaire_gestion_categories_commercial_sup.inc.php");

?>