<?php 



require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");


global $bdd;

if (isset($_REQUEST["ref_article"])){
	
	$ref_article = $_REQUEST["ref_article"];
	$article = new article($ref_article);
	$liste_cotations_article = array();
	
		$query = "SELECT ref_contact,id_type_doc,id_etat_doc,d.ref_doc,ref_article,qte,pu_ht,date_creation_doc,date_echeance
							FROM documents d
							RIGHT JOIN docs_lines dl ON d.ref_doc = dl.ref_doc
							RIGHT JOIN doc_cot dc ON d.ref_doc = dc.ref_doc
							WHERE date_echeance>= CURDATE() AND id_type_doc=16 AND id_etat_doc=64 AND ref_article = '".$ref_article."'
							ORDER BY date_creation_doc asc, ref_contact ASC, qte DESC; ";	
		$resultat = $bdd->query($query);
		while ($tmp = $resultat->fetchObject()) {
			$liste_cotations_article[] = $tmp;
		}
	

// *************************************************************************************************************
// AFFICHAGE
// **************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_catalogue_articles_view_cotations.inc.php");	
	
}

?>