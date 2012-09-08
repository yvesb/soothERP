<?php
// *************************************************************************************************************
// PAGE DE LOGIN DE L'UTILISATEUR (PROFIL CLIENT)
// *************************************************************************************************************

$_INTERFACE['MUST_BE_LOGIN'] = 0;
require ("__dir.inc.php");
require ($DIR."_session.inc.php");


// Vérification de la page de provennance
if (isset ($_REQUEST['page_from']) && !substr_count($_REQUEST['page_from'], "__user_login.php")) {

// Vérification préalable de la validité de la variable $page_from pour éviter l'injection de donnée non voulues (faille Cross Site Scripting)
// Modifications par Yves Bourvon le 11/09/2011

// On commence par échapper les caractères spéciaux par précaution
	$page_from = htmlspecialchars($_REQUEST['page_from']);

// On vérifie que la donnée fournie correspond bien à un nom de page du dossier ou des sous-dossiers LMB (ce que l'on considère comme une "white list")
	$dir_iterator = new RecursiveDirectoryIterator("../");
	$iterator = new RecursiveIteratorIterator($dir_iterator, RecursiveIteratorIterator::SELF_FIRST);

	$validEntry=false;
	foreach ($iterator as $file)
	{
		// On ne vérifie que les fichiers avec l'extension .php
		if (preg_match("/\.php/", $file))
			{
			// La variable correspond à une entée ?
			if (substr_count($page_from, basename($file)) > 0)
				{
				// Oui, on valide la variable
				$validEntry=true;
				break;
				}
			}
	}

	// Aucune entrée valide trouvéee ?
	if (!$validEntry)
	{
		//Injection XSS, on refuse la variable entrée et on la force à ""
		$page_from = "";
	}

// Fin de modifications par Yves Bourvon le 11/09/2011
}

else {                                 $page_from = "";  }

//verification d'un rafraichissement de cache à faire
if (isset($_REQUEST["uncache"]) ) {		$uncache = "uncache=".$_REQUEST['uncache'];  }
else {                                $uncache = "";  }

// Identification de l'utilisateur
if (isset ($_REQUEST['login']) && isset ($_REQUEST['code'])) {

	$id_profil = NULL;
	if (isset ($_REQUEST['id_profil_force'])) {$id_profil = $_REQUEST['id_profil_force'];}
	
  $login_result = $_SESSION['user']->login ($_REQUEST['login'], $_REQUEST['code'], $page_from, $id_profil);
	
	$hash = "";
	if ($page_from || $uncache) {$hash .= "?";}
	if ($uncache) {$hash .= "&".$uncache;}
	if ($page_from) {$hash .= "&page_from=".$page_from;}
	
  if ($login_result) {
// *************************************************************************************************************
// BACKUP DE LA BASE DE DONNEES
// *************************************************************************************************************
if ($SESSION_START_BACKUP) 
	include($DIR."taches_auto/session_backup.php");

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





