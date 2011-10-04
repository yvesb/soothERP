<?php
// *************************************************************************************************************
// MAJ D'UN NUMERO DE SERIE A UN LIGNE DE DOCUMENT
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");


if (isset($_REQUEST['ref_doc'])) {

// ouverture des infos du document et mise à jour
	$document = open_doc ($_REQUEST['ref_doc']);
	$document->maj_line_nl ($_REQUEST['ref_doc_line'], $_REQUEST['nl'],  $_REQUEST['new_nl'], $_REQUEST['old_qte_nl'],  $_REQUEST['new_qte_nl']);
	$id_type_doc = $document->getID_TYPE_DOC ();
	
	if ($id_type_doc == $LIVRAISON_CLIENT_ID_TYPE_DOC || $id_type_doc == $TRANSFERT_ID_TYPE_DOC || $id_type_doc == $INVENTAIRE_ID_TYPE_DOC) {
		$sn_qte_en_stock = 0;
		$query="SELECT sas.sn_qte
						FROM stocks_articles_sn sas
						RIGHT JOIN stocks_articles sa ON sa.ref_stock_article = sas.ref_stock_article
						RIGHT JOIN docs_lines dl ON dl.ref_article = sa.ref_article
						WHERE dl.ref_doc_line = '".addslashes($_REQUEST['ref_doc_line'])."';
		";
		if($resultat = $bdd->query($query)){
			if($res_qte = $resultat->fetchObject()){
				$sn_qte_en_stock = $res_qte->sn_qte;
			}
		}
	}	
	
// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_documents_line_maj_nl.inc.php");
}

?>