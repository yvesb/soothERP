<?php
// *************************************************************************************************************
// AFFICHAGE DE L'EDITION (IMPRESSION ET ENVOIS) D'UN DOCUMENT
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");

$ref_doc = $_REQUEST["ref_doc"];
if (is_array($ref_doc)){
    $ref_doc_url = "";
    foreach($ref_doc as $doc){
        if ($ref_doc_url != ""){ $ref_doc_url .= "&"; }
        $ref_doc_url .= "ref_doc[]=$doc";
    }
}else{
    $ref_doc_url = "ref_doc=$ref_doc";
}
// *************************************************************************************************************
// AFFICHAGE
// -*************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_documents_editing.inc.php");
?>