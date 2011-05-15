<?php
// *************************************************************************************************************
// AFFICHAGE DE L'EDITION D'UN DOCUMENT (partie document pdf)
// *************************************************************************************************************

$_INTERFACE['MUST_BE_LOGIN'] = 0;
require ("__dir.inc.php");
require ($DIR."_session.inc.php");




if (isset($_REQUEST["ref_doc"])) {
	$document = open_doc ($_REQUEST['ref_doc']);
	if (isset($_REQUEST["code_file"]) && $document->getCode_file() == $_REQUEST["code_file"]) {
		header ("Location: ".$FICHIERS_DIR."doc_tmp/".$document->getRef_doc()."_".$document->getCode_file().".pdf");
		exit(); 
	}else {
		echo "Document introuvable";
	}
}

?>