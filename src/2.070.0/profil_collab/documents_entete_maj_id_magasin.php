<?php
// *************************************************************************************************************
// MAJ DE ID_MAGASIN D'UN DOCUMENT 
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");


if (isset($_REQUEST['ref_doc'])) {

// ouverture des infos du document et mise à jour
	$document = open_doc ($_REQUEST['ref_doc']);

	 
	$document->maj_id_magasin ($_REQUEST['id_magasin']);
}

?>k!