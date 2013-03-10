<?php
// *************************************************************************************************************
// MODIFICATION D'UNE ENSEIGNE
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");


if (isset($_REQUEST['id_mag_enseigne'])) {	
	$lib_enseigne					= $_REQUEST['lib_enseigne_'.$_REQUEST['id_mag_enseigne']];
	magasin::modifier_enseigne ($_REQUEST['id_mag_enseigne'], $lib_enseigne);
}
// *************************************************************************************************************
// AFFICHAGE
// -*************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_catalogue_enseignes_mod.inc.php");

?>