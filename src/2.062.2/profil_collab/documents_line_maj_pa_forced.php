<?php
// *************************************************************************************************************
// MAJ LINE PA_HT et PA_FORCED D'UNE LIGNE D'UN DOCUMENT
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");

if (!empty($_REQUEST['ref_doc']) &&!empty($_REQUEST['ref_doc_line']) && isset($_REQUEST['pa_ht']) && isset($_REQUEST['indentation'])) {

// ouverture des infos du document et mise à  jour
        $new_pa_ht = (float)$_REQUEST['pa_ht'] ;
        $document = open_doc ($_REQUEST['ref_doc']);
        $document->maj_line_pa_ht ($_REQUEST['ref_doc_line'], $new_pa_ht);

include $DIR.$_SESSION['theme']->getDir_theme()."page_documents_line_maj_pa_forced.inc.php";
}


?>