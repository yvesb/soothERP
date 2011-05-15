<?php
// *************************************************************************************************************
// MAJ DES EVENTS D'UN DOCUMENT
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");


if (isset($_REQUEST["ref_doc"])) {

	$ref_doc= $_REQUEST["ref_doc"];
	$document = open_doc ($ref_doc);
	$document->maj_event ($_REQUEST["ref_doc_event"], $_REQUEST["date_event"], $_REQUEST["id_event_type"], $_REQUEST["d_event"]);
	
	
}



?>