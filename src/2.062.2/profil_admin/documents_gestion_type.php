<?php
// *************************************************************************************************************
// GESTION DES DOCUMENTS
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");


$infos_groupe = docs_type_groupes ($_REQUEST["id_type_groupe"]);
//liste des types de documents
$documents_type	= docs_infos_by_groupe($_REQUEST["id_type_groupe"]);
	
// *************************************************************************************************************
// AFFICHAGE
// -*************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_documents_gestion_type.inc.php");

?>