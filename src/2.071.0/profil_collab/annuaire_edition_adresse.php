<?php
// *************************************************************************************************************
// MODIFICATION DE L'ADRESSE D'UN CONTACT
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");


if (isset($_REQUEST['adresse_ref'.$_REQUEST['ref_idform']])) {	
	// *************************************************
	// Suppression de l'adresse
	$ref_adresse	=	$_REQUEST['adresse_ref'.$_REQUEST['ref_idform']];
	$lib_adresse 	= $_REQUEST['adresse_lib'.$_REQUEST['ref_idform']];
	$text_adresse = $_REQUEST['adresse_adresse'.$_REQUEST['ref_idform']];
	$code_postal	= $_REQUEST['adresse_code'.$_REQUEST['ref_idform']];
	$ville		= $_REQUEST['adresse_ville'.$_REQUEST['ref_idform']];
	$id_pays	= $_REQUEST['adresse_id_pays'.$_REQUEST['ref_idform']];
	$note			= $_REQUEST['adresse_note'.$_REQUEST['ref_idform']];
	if (!empty($GEST_TYPE_COORD)){
        $type			= $_REQUEST['type_adresse'.$_REQUEST['ref_idform']];
        }
        else{
            $type = 0;
        }
	// *************************************************
	// Création de l'adresse
	$adresse = new adresse ($ref_adresse);
	$adresse->modification($lib_adresse, $text_adresse,  $code_postal, $ville, $id_pays, $note, $type);
	
}
// *************************************************************************************************************
// AFFICHAGE
// -*************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_annuaire_edition_valid_adresse.inc.php");

?>