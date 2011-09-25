<?php
// *************************************************************************************************************
// SUPRESSION D'UN NUMERO DE SERIE A UN LIGNE DE DOCUMENT
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");


if (isset($_REQUEST['ref_doc'])) {
// ouverture des infos du document et mise à jour
	document::del_line_nl ($_REQUEST['ref_doc_line'], $_REQUEST['nl'], $_REQUEST['qte_nl']);
}

?>