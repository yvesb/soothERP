<?php
// *************************************************************************************************************
// ACCUEIL DE L'UTILISATEUR ADMINISTRATEUR
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");
require_once ($DIR."_contact_liaisons_types.class.php");


// *************************************************
// Controle des données fournies par le formulaire

if(!$_REQUEST['ordre']){
	echo "la variable ordre n'est pas spécifiée";
	exit;
}
$new_ordre = $_REQUEST['ordre'];

if(!$_REQUEST['ordre_other']){
	echo "la variable ordre_other n'est pas spécifiée";
	exit;
}
$new_ordre_other = $_REQUEST['ordre_other'];

//on récupére fonction de l'ordre la premier ref
$id_liaison_type	= Contact_liaison_type::getId_liaison_type_from_ordre ($_REQUEST['ordre_other']);

//on récupére fonction de l'ordre la deuxième ref
$id_liaison_type_other	= Contact_liaison_type::getId_liaison_type_from_ordre ($_REQUEST['ordre']);

// *************************************************
// modification de l'ordre
$liaison_liste = new Contact_liaison_type($id_liaison_type);

if(!$liaison_liste->setOrdre($new_ordre)){
	$GLOBALS['_ALERTES']['bad_ordre'] = 1;
}

// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

//include ($DIR.$_SESSION['theme']->getDir_theme()."page_catalogue_liaisons_ordre.inc.php");
include ($DIR.$_SESSION['theme']->getDir_theme()."page_annuaire_gestion_liaisons_contact_ordre.inc.php");
?>