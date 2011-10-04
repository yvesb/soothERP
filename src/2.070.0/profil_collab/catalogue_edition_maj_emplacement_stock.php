<?php
// *************************************************************************************************************
// MAJ DE L'EMPLACEMENT D'UN ARTICLE DANS LE STOCK
// *************************************************************************************************************

require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");

if (isset($_REQUEST['ref_article'])) {
	$article = new article ($_REQUEST['ref_article']);
	$article-> add_emplacement_stock ($_REQUEST['id_stock'], $_REQUEST['new_emplacement']);
}

?>