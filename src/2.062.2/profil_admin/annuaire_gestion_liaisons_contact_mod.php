<?php
// *************************************************************************************************************
// ACCUEIL DE L'UTILISATEUR ADMINISTRATEUR
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");
require_once ($DIR."_contact_liaisons_types.class.php");


if(!$_REQUEST['id_liaison_type']){
	echo "la variable id_liaison_type n'est pas spécifiée";
	exit;
}
$id_liaison_type = $_REQUEST['id_liaison_type'];

if(	isset($_REQUEST['actif_'.$_REQUEST['id_liaison_type']]) || 
	( isset($_REQUEST['systeme_'.$_REQUEST['id_liaison_type']]) && $_REQUEST['systeme_'.$_REQUEST['id_liaison_type']] == "1")){
	$liaison_liste = new Contact_liaison_type($id_liaison_type);
	if(!$liaison_liste->setActif())
	{		$GLOBALS['_ALERTES']['mod_actif_failed'] = 1;}
}else{
	$liaison_liste = new Contact_liaison_type($id_liaison_type);
	if(!$liaison_liste->setNo_actif())
	{		$GLOBALS['_ALERTES']['mod_actif_failed'] = 1;}
}

// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

//include ($DIR.$_SESSION['theme']->getDir_theme()."page_catalogue_liaisons_mod.inc.php");
include ($DIR.$_SESSION['theme']->getDir_theme()."page_annuaire_gestion_liaisons_contact_mod.inc.php");

?>