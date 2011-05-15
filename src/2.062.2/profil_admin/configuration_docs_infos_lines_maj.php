<?php
// *************************************************************************************************************
// MAJ D'UN MODELE DE LIGNE D'INFORMATION DE DOCUMENTS
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");


$tmp_id_type = array();
if (isset($_REQUEST["id_type_doc_".$_REQUEST["id_doc_info_line"]]) ) {
	$tmp_id_type = implode(";", $_REQUEST["id_type_doc_".$_REQUEST["id_doc_info_line"]]);
}

maj_doc_info_line ($_REQUEST["id_doc_info_line"], $tmp_id_type, $_REQUEST["lib_line_".$_REQUEST["id_doc_info_line"]], $_REQUEST["desc_line_".$_REQUEST["id_doc_info_line"]], $_REQUEST["desc_line_interne_".$_REQUEST["id_doc_info_line"]]);

// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_configuration_docs_infos_lines_maj.inc.php");

?>