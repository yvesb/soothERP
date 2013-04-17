<?php
// *************************************************************************************************************
// MODIFICATION D'UNE ENSEIGNE
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");


if (isset($_REQUEST['id_mag_enseigne'])) {	
	magasin::supprimer_enseigne ($_REQUEST['id_mag_enseigne']);
}
// *************************************************************************************************************
// AFFICHAGE
// -*************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_catalogue_enseignes_sup.inc.php");

?>