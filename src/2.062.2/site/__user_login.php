<?php
// *************************************************************************************************************
// PAGE DE LOGIN DE L'UTILISATEUR (PROFIL CLIENT)
// *************************************************************************************************************

$_INTERFACE['MUST_BE_LOGIN'] = 0;
require ("__dir.inc.php");
require ($DIR."_session.inc.php");


// Vérification de la page de provennance
if (isset ($_REQUEST['page_from']) && !substr_count($_REQUEST['page_from'], "__user_login.php")) {  $page_from = $_REQUEST['page_from'];  }
else {                                 $page_from = "";  }

//verification d'un rafraichissement de cache à faire
if (isset($_REQUEST["uncache"]) ) {		$uncache = "uncache=".$_REQUEST['uncache'];  }
else {                                $uncache = "";  }

// Identification de l'utilisateur
if (isset ($_REQUEST['login'])) { 

	$id_profil = NULL;
	if (isset ($_REQUEST['id_profil_force'])) {$id_profil = $_REQUEST['id_profil_force'];}
	
  $login_result = $_SESSION['user']->login ($_REQUEST['login'], $_REQUEST['code'], $page_from, $id_profil);
	
	$hash = "";
	if ($page_from || $uncache) {$hash .= "?";}
	if ($uncache) {$hash .= "&".$uncache;}
	if ($page_from) {$hash .= "&page_from=".$page_from;}
	
  if ($login_result) {
  	header ("Location: ".urldecode($_INFOS['redirection']).$hash);
  	exit();
  }
}



// *************************************************************************************************************
// TRAITEMENTS 
// *************************************************************************************************************

// Liste des utilisateurs en cas d'identification via un champs SELECT
if ($MODE_IDENTIFICATION == "SELECT") {
	$query = "SELECT ref_user, pseudo
						FROM users
						WHERE actif = 1 
						ORDER BY pseudo";
	$result = $bdd->query($query);
	while ($var = $result->fetchObject()) { $users[] = $var; } 
}
else { $users = ""; }


// REF_USER ou LOGIN si prédéfini
if (isset($_COOKIE['predefined_user'])) {
		$pred_user = array();
		$pred_user = explode(";", $_COOKIE['predefined_user']); 
		foreach($pred_user as $p_user) {
			$tmp_p_users = array ();
			$tmp_p_users = explode("--", $p_user ); 
			$predefined_user[]= $tmp_p_users[0];
		}
}
else {
	$predefined_user = array("");
}

$message = "";


//chargement du nom de l'entreprise

	$contact_entreprise = new contact($REF_CONTACT_ENTREPRISE);
	$nom_entreprise = str_replace (CHR(13), " " ,str_replace (CHR(10), " " , $contact_entreprise->getNom()));
	
// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************
include ($DIR.$_SESSION['theme']->getDir_theme()."page_user_login.inc.php");


?>





