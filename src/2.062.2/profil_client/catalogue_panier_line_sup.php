<?php
// *************************************************************************************************************
// DELETE_LINE D'UNE LIGNE D'UN PANIER
// *************************************************************************************************************

$_PAGE['MUST_BE_LOGIN'] = 0;
require("_dir.inc.php");
require ("_profil.inc.php");
require ("_session.inc.php");

if (isset($_REQUEST['ref_article'])) {
	interface_del_line_panier($_REQUEST['ref_article']);
}


?>ok