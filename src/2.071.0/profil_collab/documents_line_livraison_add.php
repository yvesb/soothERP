<?php
// *************************************************************************************************************
// AJOUT DE LIGNES de FRAIS DE PORT AU DOCUMENT
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");


if (isset($_REQUEST['ref_doc'])) {
	// ouverture des infos du document
	$document = open_doc ($_REQUEST['ref_doc']);

	$document->maj_id_livraison_mode ($_REQUEST['id_livraison_mode']) ;

}
// *************************************************************************************************************
// AFFICHAGE
// -*************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_documents_line_livraison_add.inc.php");
?>