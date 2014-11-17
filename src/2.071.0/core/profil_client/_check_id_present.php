<?php
//  ******************************************************
// IDENTIFICATION DE L'UTILISATEUR CLIENT
//  ******************************************************

$_PAGE['MUST_BE_LOGIN'] = 0;
require("_dir.inc.php");
require("_profil.inc.php");
require("_session.inc.php");


//$interface = new interfaces ($ID_INTERFACE);

if(isset($_REQUEST["pseudo"])){
	if($_SESSION['user']->getLogin()){	// Le user est loggé
		if($_SESSION['user']->getPseudo() != $_REQUEST["pseudo"])	// Si le pseudo est != alors on teste
		{			check_pseudo_present($_REQUEST["pseudo"]);}
		else{/*NE RIEN FAIRE*/}
	}else{	// Le user n'est pas loggé -> on teste
		check_pseudo_present($_REQUEST["pseudo"]);
	}
}else{	echo "Le pseudo n'est pas spécifié";}

//  ******************************************************
// AFFICHAGE
//  ******************************************************

if(isset($GLOBALS['_ALERTES']['pseudo_used']))
{		echo "identifiant dejà présent";}
?>