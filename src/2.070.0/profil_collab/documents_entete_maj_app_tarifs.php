<?php
// *************************************************************************************************************
// MAJ DE L'APP_TARIFS D'UN DOCUMENT
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");


if (isset($_REQUEST['ref_doc'])) {

// mise à jour de l'app_tarif
	 
	$ref_doc= $_REQUEST["ref_doc"];
	$document = open_doc ($ref_doc);
	$document->maj_app_tarifs ($_REQUEST['new_app_tarifs']);
}


?>k!