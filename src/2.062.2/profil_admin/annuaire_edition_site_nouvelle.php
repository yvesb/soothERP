<?php
// *************************************************************************************************************
// ACCUEIL DE L'UTILISATEUR ADMINISTRATEUR
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");


if (isset($_REQUEST['ref_idform'])) {
	if (isset($_REQUEST['ref_contact'.$_REQUEST['ref_idform']])) {	
	
		// on récupére la dernier ref site si existe pour la réactualiser (afin de rafraichir l'affiche des ordres
		$ordre_previous	=	getMax_ordre("sites_web", $_REQUEST['ref_contact'.$_REQUEST['ref_idform']]);
		if ($ordre_previous>0) {
			$ref_site_previous	= site::getRef_site_from_ordre ($_REQUEST['ref_contact'.$_REQUEST['ref_idform']], $ordre_previous);
		}
	
	
	
	
	
	
	
	
		// *************************************************
		// 
		$ref_contact =  $_REQUEST['ref_contact'.$_REQUEST['ref_idform']];
		$lib_site_web	= $_REQUEST['site_lib'.$_REQUEST['ref_idform']];
		$url = $_REQUEST['site_url'.$_REQUEST['ref_idform']];
		$login = $_REQUEST['site_login'.$_REQUEST['ref_idform']];
		$pass 	= $_REQUEST['site_pass'.$_REQUEST['ref_idform']];
		$note		= $_REQUEST['site_note'.$_REQUEST['ref_idform']];
		if (!empty($GEST_TYPE_COORD)){
                $type		= $_REQUEST['type_site'.$_REQUEST['ref_idform']];
                }
                else{
                    $type = 0;
                }
		$site = new site ();
		$site->create ($ref_contact, $lib_site_web, $url, $login, $pass, $note);
	}
	// *************************************************************************************************************
	// AFFICHAGE
	// -*************************************************************************************************************
	
	include ($DIR.$_SESSION['theme']->getDir_theme()."page_annuaire_edition_valid_site_nouvelle.inc.php");
}
?>