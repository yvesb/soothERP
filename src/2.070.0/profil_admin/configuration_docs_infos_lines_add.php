<?php
// *************************************************************************************************************
// AJOUT D'UN MODELE DE LIGNE D'INFORMATION DE DOCUMENTS
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");

$tmp_id_type = array();
if (isset($_REQUEST["id_type_doc"]) ) {
	$tmp_id_type = implode(";", $_REQUEST["id_type_doc"]);
}

add_doc_info_line ($tmp_id_type, $_REQUEST["lib_line"], $_REQUEST["desc_line"], $_REQUEST["desc_line_interne"]);
// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_configuration_docs_infos_lines_add.inc.php");

?>