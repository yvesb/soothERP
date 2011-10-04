<?php
// *************************************************************************************************************
// MAJ des lignes de relance
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");
require_once ($DIR."_document_duree_abo.class.php");

$ref_article  = $_REQUEST['ref_article'];
$ref_doc_line = $_REQUEST['ref_doc_line'];
$date_deb_abo = $_REQUEST['date_deb_abo'];
$duree_mois_abo = $_REQUEST['duree_mois_abo'];
$duree_jours_abo = $_REQUEST['duree_jours_abo'];
$indentation = $_REQUEST['indentation'];

//Récupération des informations
$duree_abo = new duree_abo($ref_doc_line);
$ref_doc_line_abo = $duree_abo->getRef_doc_line();

if (!empty($ref_doc_line_abo))
    $duree_abo->maj_duree_abo($ref_doc_line,$date_deb_abo,$duree_mois_abo,$duree_jours_abo);
else
    $duree_abo->create_duree_abo($ref_doc_line, $date_deb_abo, $duree_mois_abo, $duree_jours_abo);

// *************************************************************************************************************
// AFFICHAGE
// -*************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_documents_line_article_calcul_modification_duree.inc.php");

?>