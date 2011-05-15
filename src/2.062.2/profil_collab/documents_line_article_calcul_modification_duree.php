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

global $bdd;
	$query_test = "SELECT ref_doc_line, date_debut, duree
					FROM doc_line_duree
					WHERE ref_doc_line = '".$ref_doc_line."' ";
	
	$resultat = $bdd->query ($query_test);
	//$duree_abo = new duree_abo($ref_doc_line);
	if ($duree_abo = $resultat->fetchObject())
	{
		//$duree_abo->maj_duree_abo($ref_doc_line,$date_deb_abo,$duree_mois_abo,$duree_jours_abo);
		
		$query = "UPDATE `doc_line_duree`
					SET `date_debut` = str_to_date('".$date_deb_abo."','%d/%m/%Y'),
						`duree` = '".$duree_mois_abo."M".$duree_jours_abo."J'
					WHERE `ref_doc_line` = '".$ref_doc_line."' ";
		$bdd->exec ($query);
	}
	else
	{
		//$duree_abo = new duree_abo($ref_doc_line,$date_deb_abo,$duree_mois_abo,$duree_jours_abo);
		$query = "INSERT INTO `doc_line_duree` (`ref_doc_line`,`date_debut`,`duree`)
			 VALUES ('".$ref_doc_line."',str_to_date('".$date_deb_abo."','%d/%m/%Y'),'".$duree_mois_abo."M".$duree_jours_abo."J')";
		$bdd->exec ($query);
	}

// *************************************************************************************************************
// AFFICHAGE
// -*************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_documents_line_article_calcul_modification_duree.inc.php");

?>