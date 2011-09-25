<?php
// *************************************************************************************************************
// MAJ DU CONTACT D'UN DOCUMENT 
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");



//liste des lieux de stockage
$stocks_liste	= array();
$stocks_liste = $_SESSION['stocks'];


if (isset($_REQUEST['ref_doc'])) {

	// ouverture des infos du document
	$document = open_doc ($_REQUEST['ref_doc']);
	
	//maj ref_contact
	$ref_contact = $_REQUEST['ref_contact'];

	$document->maj_contact ($ref_contact);
	
}
?>k