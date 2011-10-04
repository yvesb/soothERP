<?php
// *************************************************************************************************************
// MAJ DE L'ALERTE STOCK D'UN ARTICLE
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");

if (isset($_REQUEST['ref_article'])) {	

	$article = new article ($_REQUEST['ref_article']);
	$article-> add_stock_alerte ($_REQUEST['id_stock'], $_REQUEST['new_stock']);
	
}


?>
