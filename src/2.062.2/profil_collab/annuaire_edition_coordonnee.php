<?php
// *************************************************************************************************************
// MODIFICATION DE LA COORDONNEE D'UN CONTACT
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");


if (isset($_REQUEST['coordonnee_ref'.$_REQUEST['ref_idform']])) {	
	// *************************************************
	// création d'une coordonnée
	$ref_coord 		= $_REQUEST['coordonnee_ref'.$_REQUEST['ref_idform']];
	$lib_coord 		= $_REQUEST['coordonnee_lib'.$_REQUEST['ref_idform']];
	$tel1 			= $_REQUEST['coordonnee_tel1'.$_REQUEST['ref_idform']];
	$tel2 			= $_REQUEST['coordonnee_tel2'.$_REQUEST['ref_idform']];
	$fax 			= $_REQUEST['coordonnee_fax'.$_REQUEST['ref_idform']];
	$email			= $_REQUEST['coordonnee_email'.$_REQUEST['ref_idform']];
	$note				= $_REQUEST['coordonnee_note'.$_REQUEST['ref_idform']];
	if (!empty($GEST_TYPE_COORD)){
        $type				= $_REQUEST['type_coord'.$_REQUEST['ref_idform']];
        }
        else{
            $type = 0;
        }
	$ref_coord_parent	= "";

	$coordonnee = new coordonnee ($ref_coord);
	$coordonnee->modification ($lib_coord, $tel1, $tel2, $fax, $email, $note, $type, $ref_coord_parent);
}
// *************************************************************************************************************
// AFFICHAGE
// -*************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_annuaire_edition_valid_coordonnee.inc.php");

?>