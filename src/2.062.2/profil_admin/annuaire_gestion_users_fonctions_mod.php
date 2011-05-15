<?php
// *************************************************************************************************************
// MODIFICATION D'UN ROLE D'UTILISATEUR
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");

// chargement de la class des fonctions
$fonction = new fonctions($_REQUEST["id_fonction"]);

//modification de la fonction
$fonction->maj_fonction ($_REQUEST["lib_fonction_".$_REQUEST["id_fonction"]],	$_REQUEST["desc_fonction_".$_REQUEST["id_fonction"]],	$_REQUEST["id_fonction_parent_".$_REQUEST["id_fonction"]],	$_REQUEST["id_profil_".$_REQUEST["id_fonction"]]);


//maj des permissions users
if (isset($_REQUEST["maj_user_perms_".$_REQUEST["id_fonction"]]) && $_REQUEST["maj_user_perms_".$_REQUEST["id_fonction"]] == "1") {
	$fonction->maj_fonction_user_permissions ();
}

// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_annuaire_gestion_users_fonctions_mod.inc.php");

?>