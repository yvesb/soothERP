<?php
// *************************************************************************************************************
// SUPRESSION D'UN NUMERO DE SERIE A UN ARTICLE FABRIQUE
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");


if (isset($_REQUEST['ref_doc'])) {
// ouverture des infos du document et mise à jour
	$document = open_doc ($_REQUEST['ref_doc']);
	$document->del_fab_nl ($_REQUEST['nl'], $_REQUEST['qte']);
}

?>