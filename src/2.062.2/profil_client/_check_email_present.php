<?php
// *************************************************************************************************************
// IDENTIFICATION DE L'UTILISATEUR CLIENT
// *************************************************************************************************************

$_PAGE['MUST_BE_LOGIN'] = 0;
require("_dir.inc.php");
require("_profil.inc.php");
require("_session.inc.php");


if(isset($_REQUEST["email"])){
	if($_SESSION['user']->getLogin()){	// Le user est loggé
		if($_SESSION['user']->getEmail() != $_REQUEST["email"])	// Si le mail est != alors on teste
		{			check_email_present($_REQUEST["email"]);}
		else{/*NE RIEN FAIRE*/}
	}else{	// Le user n'est pas loggé -> on teste
		check_email_present($_REQUEST["email"]);
	}
}else{	echo "l'adresse email n'est pas spécifiée";}

// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************
if (isset($GLOBALS['_ALERTES']['email_used'])) {
	echo "email dejà présent";
}
?>
