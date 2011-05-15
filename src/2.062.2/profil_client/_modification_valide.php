<?php
// *************************************************************************************************************
// MODIFICATION DE L'UTILISATEUR CLIENT
// *************************************************************************************************************

$_PAGE['MUST_BE_LOGIN'] = 0;

require("_dir.inc.php");
require("_profil.inc.php");
require("_session.inc.php");


// exemple : http://lmb8/LMB9/profil_client/_modification_valide.php?id_contact_tmp=ID&code_validation=CODE&modification_allowed=INT

if(!isset($_REQUEST["id_contact_tmp"])){
	echo "l'id_contact_tmp n'est pas spécifié";
	exit;
}
$id_contact_tmp = $_REQUEST["id_contact_tmp"];

if(!isset($_REQUEST["code_validation"])){
	echo "le code de validation n'est pas spécifié";
	exit;
}
$code_validation = $_REQUEST["code_validation"];


require_once ("_inscription_profil_client.class.php");

if(isset($_REQUEST['modification_allowed']) && is_numeric($_REQUEST['modification_allowed'])){
	$modificationAllowed = $_REQUEST['modification_allowed'];
}
else{	$modificationAllowed = $MODIFICATION_ALLOWED;}

$modification = new Modification_profil_client($_INTERFACE['ID_INTERFACE'], $modificationAllowed);

$resultat = $modification->contact_confirme_sa_modification($id_contact_tmp, $code_validation);

// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

if($resultat)
{		include ($DIR.$_SESSION['theme']->getDir_theme()."page_modification_valide.inc.php");}
else
{		header ("Location: _user_infos.php");}

?>