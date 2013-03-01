<?php
// *************************************************************************************************************
// LISTE DES SERVEURS D'IMPORT
// *************************************************************************************************************

// Incompatible SoothERP
/*
require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");

$version_file = array();
$version_file[0] = "0";
if ($ACTIVE_MAJ && @remote_file_exists ($MAJ_SERVEUR['url']."check_version.php?version_actuelle=".$_SERVER['VERSION'])) {
    $version_file = file ($MAJ_SERVEUR['url']."check_version.php?version_actuelle=".$_SERVER['VERSION']);
}


$erreur = "";
if (isset($version_file[0]) && $version_file[0] != "0") { 
	$ftp_id_connect 	= ftp_connect("ftp.lundimatin.fr");
	ftp_pasv($ftp_id_connect, true);
	$ftp_login_result 	= ftp_login($ftp_id_connect, "anonymous", ""); 

	// Vérification de la connexion
	if ((!$ftp_id_connect) || (!$ftp_login_result)) {
		$erreur = "La connexion FTP au serveur de mise à jour semble impossible actuellement"; 
	} else {
		//test du ftp_get
		restore_error_handler();
		error_reporting(0);
		if(!@ftp_get ($ftp_id_connect, "test.txt", "/__maj_serveur/test_connexion_maj.txt", FTP_BINARY)) {
			$erreur = "L'import de données via FTP semble impossible. Contacter votre administrateur réseaux ou rendez-vous sur <a href='http://www.lundimatin.fr/' target='_blank'>www.lundimatin.fr</a> pour plus d'informations";
		} else {
			@unlink("test.txt");
			//test si on autorise les maj
			if(!@ftp_get ($ftp_id_connect, "test2.txt", "/__maj_serveur/test_serveur_maj_dispo.txt", FTP_BINARY)) {
				//alors on ne propose pas les maj
				$version_file = array();
				@unlink("test2.txt");
			}
		}
	 	set_error_handler("error_handler");
	}
}

	
// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_import_maj_serveur.inc.php");
*/
?>