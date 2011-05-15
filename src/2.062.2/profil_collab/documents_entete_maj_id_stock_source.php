<?php
// *************************************************************************************************************
// MISA A JOUR DU STOCK SOURCE POUR UN TRM
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");


if (isset($_REQUEST['ref_doc'])) {

// ouverture des infos du document et mise à jour
	$document = open_doc ($_REQUEST['ref_doc']);

	 
	$document->maj_id_stock_source ($_REQUEST['id_stock_source']);
}

?>k!