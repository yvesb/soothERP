<?php
// *************************************************************************************************************
// ONGLET DES MARGES DU DOCUMENT
// *************************************************************************************************************

require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");
require ($DIR.$_SESSION['theme']->getDir_theme()."_theme.config.php");


if (isset($_REQUEST["ref_doc"])) {
	$ref_doc= $_REQUEST["ref_doc"];
	$document = open_doc ($ref_doc);

	//chargement de la liste des commerciaux
	$liste_commerciaux = $document->getCommerciaux ();

	// *************************************************************************************************************
	// AFFICHAGE
	// -*************************************************************************************************************
	include ($DIR.$_SESSION['theme']->getDir_theme()."page_documents_commercial.inc.php");
}
?>