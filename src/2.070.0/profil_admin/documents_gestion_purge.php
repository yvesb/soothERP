<?php
// *************************************************************************************************************
// DELESTAGE DES DOCUMENTS
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");


//délestage des types de documents
if (isset($_REQUEST["purge"])  ) {
	$type = "";
	if (isset($_REQUEST["id_type_doc"])) {$type = $_REQUEST["id_type_doc"];}
	$nb_docs_purged = purge_all_docs_annules ($type);
}



$documents_type	= fetch_all_types_docs();


// *************************************************************************************************************
// AFFICHAGE
// -*************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_documents_gestion_purge.inc.php");

?>