<?php
// *************************************************************************************************************
// OUVERTURE D'UN DOCUMENT EN MODE EDITION
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");

				
if (isset($_REQUEST["ref_doc"])) {
	
	$devis = open_doc($_REQUEST["ref_doc"]);
	$devis->maj_etat_doc ($_REQUEST["maj_etat"]);

 header('location:documents_edition.php?ref_doc='.$_REQUEST["ref_doc"]);
 exit;
 }