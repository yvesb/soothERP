<?php
// *************************************************************************************************************
// INSERTION D'UNE LIGNE D'ARTICLE DANS UN DOCUMENT
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");

$indentation_contenu = $_REQUEST["indentation_contenu"];
$line_insert = 1;

$contenu = new stdclass;
foreach ($_REQUEST as $variable => $valeur) {
	if ($variable == "sn") {
		$contenu->sn = array();
		$tmp = array();
		$tmp = explode (";", $valeur );
		foreach ($tmp as $sn_valeur) {
			$sn_serie = new stdclass;
			$sn_serie->numero_serie = $sn_valeur;
			$sn_serie->sn_qte = 1;
			$contenu->sn[] = $sn_serie;
		}
	} else {
		$contenu->$variable = $valeur;
	}
}

$document = open_doc($_REQUEST["ref_doc"]);
$nb_lignes_liees = $document->getNb_lignes_liees($contenu->ref_doc_line);

$id_type_doc = 0;
if (isset($contenu->id_type_doc)) {
	$id_type_doc = $contenu->id_type_doc;
}
// *************************************************************************************************************
// AFFICHAGE
// -*************************************************************************************************************
include ($DIR.$_SESSION['theme']->getDir_theme()."page_documents_line_".$_REQUEST['type_of_line'].".inc.php");

?>