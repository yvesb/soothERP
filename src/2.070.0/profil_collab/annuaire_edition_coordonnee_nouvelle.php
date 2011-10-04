<?php
// *************************************************************************************************************
// AJOUT DE LA COORDONNEE D'UN CONTACT
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");

if (isset($_REQUEST['ref_contact'.$_REQUEST['ref_idform']])) {	

	// on récupére la dernier ref coord si existe pour la réactualiser (afin de rafraichir l'affiche des ordres
	$ordre_previous	=	getMax_ordre("coordonnees", $_REQUEST['ref_contact'.$_REQUEST['ref_idform']]);
	if ($ordre_previous>0) {
		$ref_coord_previous	= coordonnee::getRef_coord_from_ordre ($_REQUEST['ref_contact'.$_REQUEST['ref_idform']], $ordre_previous);
	}


	// *************************************************
	// création d'une coordonnée
	$ref_contact =  $_REQUEST['ref_contact'.$_REQUEST['ref_idform']];
	$lib_coord 	= $_REQUEST['coordonnee_lib'.$_REQUEST['ref_idform']];
	$tel1 = $_REQUEST['coordonnee_tel1'.$_REQUEST['ref_idform']];
	$tel2 = $_REQUEST['coordonnee_tel2'.$_REQUEST['ref_idform']];
	$fax 	= $_REQUEST['coordonnee_fax'.$_REQUEST['ref_idform']];
	$email	= $_REQUEST['coordonnee_email'.$_REQUEST['ref_idform']];
	$note		= $_REQUEST['coordonnee_note'.$_REQUEST['ref_idform']];
	if (!empty($GEST_TYPE_COORD)){
        $type		= $_REQUEST['type_coord'.$_REQUEST['ref_idform']];
        }
        else{
            $type = 0;
        }
	$ref_coord_parent	= "";
	$email_user_creation = 0;
	if (isset($_REQUEST['email_user_creation'.$_REQUEST['ref_idform']])) { $email_user_creation = $_REQUEST['email_user_creation'.$_REQUEST['ref_idform']]; }
	

	$coordonnee = new coordonnee ();
	$coordonnee->create($ref_contact, $lib_coord, $tel1, $tel2, $fax,  $email, $note, $ref_coord_parent, $email_user_creation, $type);
	if($email_user_creation){
		$coordonnee->envoi_mail_invitation();
	}
	
}
	
	
// *************************************************************************************************************
// AFFICHAGE
// -*************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_annuaire_edition_valid_coordonnee_nouvelle.inc.php");

?>
