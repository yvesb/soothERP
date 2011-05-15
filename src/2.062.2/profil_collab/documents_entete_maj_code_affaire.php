<?php
// *************************************************************************************************************
// MAJ DU CODE_AFFAIRE D'UN DOCUMENT 
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");


if (isset($_REQUEST['ref_doc'])) {

	// Ouverture des infos du document et mise à jour
	$document = open_doc ($_REQUEST['ref_doc']); 	 
	$document->maj_code_affaire (urldecode($_REQUEST['info_content']));
}

?>
