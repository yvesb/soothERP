<?php
// *************************************************************************************************************
// IDENTIFICATION DE L'UTILISATEUR CLIENT
// *************************************************************************************************************

$_PAGE['MUST_BE_LOGIN'] = 0;
require("_dir.inc.php");
require("_profil.inc.php");
require("_session.inc.php");


//$interface = new interfaces ($ID_INTERFACE);

// Vérification de la page de provennance
if (isset ($_REQUEST['page_from']) && !substr_count($_REQUEST['page_from'], "_user_login.php")) {  $page_from = $_REQUEST['page_from'];  }
else {                                 $page_from = "";  }

//verification d'un rafraichissement de cache à faire
$uncache = "";

// Identification de l'utilisateur
if (isset ($_REQUEST['login'])) { 

	$id_profil = NULL;
	if (isset ($_REQUEST['id_profil_force'])) {$id_profil = $_REQUEST['id_profil_force'];}
	
  $login_result = $_SESSION['user']->login ($_REQUEST['login'], $_REQUEST['code'], $page_from, $id_profil);
	
	$hash = "";
	if ($page_from || $uncache) {$hash .= "?";}
	if ($uncache) {$hash .= "&".$uncache;}
	
  if ($login_result) {
		if ($page_from) {header ("Location: ".$page_from); exit();}
  	header ("Location: ".urldecode($_INFOS['redirection']).$hash);
  	exit();
  }
}


gestion_panier();
$liste_contenu = $_SESSION["panier_interface_".$_INTERFACE['ID_INTERFACE']]["contenu"];

// *************************************************************************************************************
// TRAITEMENTS 
// *************************************************************************************************************

$users = "";

// REF_USER ou LOGIN si prédéfini
$predefined_user = array("");


$message = "";


//chargement du nom de l'entreprise

	$contact_entreprise = new contact($REF_CONTACT_ENTREPRISE);
	$nom_entreprise = str_replace (CHR(13), " " ,str_replace (CHR(10), " " , $contact_entreprise->getNom()));


// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_user_login.inc.php");

?>