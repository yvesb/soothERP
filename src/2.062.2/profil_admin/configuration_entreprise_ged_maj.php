<?php
// *************************************************************************************************************
// Modification des types de pièces jointes
// *************************************************************************************************************

require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");

//mise à jour des données transmises
if(isset($_REQUEST['id_type_piece'])){
	$lib_type = $_REQUEST['lib_type_'.$_REQUEST['id_type_piece']];
	$abrev_type = $_REQUEST['abrev_type_'.$_REQUEST['id_type_piece']];
	$actif = 0;
	if(isset($_REQUEST['actif_'.$_REQUEST['id_type_piece']])){
		$actif = 1;
	}
	maj_types_ged($_REQUEST['id_type_piece'], $lib_type, $abrev_type, $actif);
}


// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_configuration_entreprise_ged_maj.inc.php");
?>