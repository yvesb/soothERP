<?php
// *************************************************************************************************************
// Ajout d'un Rôle d'utilisateur
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");

// chargement de la class des fonctions
$fonction = new fonctions();

$permissions = array ();
foreach ($_REQUEST as $key => $value) {
	if (substr ($key, 0, 11) != "permission_") { continue; }
	$permissions[] = $value;
}

//création de la fonction
$fonction->create_fonction ($_REQUEST["lib_fonction"],	$_REQUEST["desc_fonction"],	$_REQUEST["id_fonction_parent"],	$_REQUEST["id_profil"]);

//$fonction->set_fonction_perms ($permissions);

// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_annuaire_gestion_users_fonctions_add.inc.php");

?>