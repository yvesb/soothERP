<?php
// *************************************************************************************************************
// MAJ LINE_QTE D'UNE LIGNE D'UN DOCUMENT
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");

$stocks_qte = 0;
if (isset($_REQUEST['ref_doc'])) {

	// ouverture des infos du document et mise à jour
	$document = open_doc ($_REQUEST['ref_doc']);
	
	
	// *************************************************
	// maj auto du pu en fonction des quantités
	$line_infos0 = $document->getInfos_line ($_REQUEST['ref_doc_line']);
	$ref_article 	= $line_infos0->ref_article;
	$article = new article ($ref_article);
	if ( ($_REQUEST['qte_article'] == 1 && $line_infos0->qte == 0) || ($_REQUEST['qte_article'] == 0 && $line_infos0->qte == 1)) {
	//si la quantité passe de zéro à un ou inversement, on touche pas au pu
	} else {
		if ($article->getRef_article() && (count($article->getFormules_tarifs ()) > 1 || $document->select_article_pcotation ($article, $_REQUEST['qte_article'])) ) {
			// on test combien de grilles on a, si 1 ou moins, on n'a pas besoin de faire de maj pu
		
			$qte = $_REQUEST['qte_article'];
			$old_qte = $line_infos0->qte;
			$pu_ht = $document->select_article_pu ($article, $qte);//  nouveau pu / id_tarif
			$defaut_pu_ht = $document->select_article_pu ($article, $old_qte);  // ancien tarif / if_tarif
			//
			if ($pu_ht != $defaut_pu_ht && $pu_ht != $line_infos0->pu_ht) {
				$document-> maj_line_pu_ht ($_REQUEST['ref_doc_line'], $pu_ht);
				$new_pu_ht = $pu_ht;
			}
		}
	}
	
	$document-> maj_line_qte ($_REQUEST['ref_doc_line'], $_REQUEST['qte_article']);
	$id_type_doc = $document->getID_TYPE_DOC ();
	$line_infos = $document->getInfos_line ($_REQUEST['ref_doc_line']);
	
	if ($id_type_doc == $COMMANDE_CLIENT_ID_TYPE_DOC || $id_type_doc == $LIVRAISON_CLIENT_ID_TYPE_DOC || $id_type_doc == $INVENTAIRE_ID_TYPE_DOC) {
	$id_stock = $document->getId_Stock ();
	}
	if ($id_type_doc == $TRANSFERT_ID_TYPE_DOC) {
	$id_stock = $document->getId_stock_source ();
	}
	if($id_type_doc == $COMMANDE_CLIENT_ID_TYPE_DOC){
		$stocks_res = $article->getStocks_rsv();
		if (isset($stocks_res[$id_stock])){
			$stocks_res = $stocks_res[$id_stock]->qte;
		}else{
			$stocks_res = 0;
		}
	}
	if ($id_type_doc == $COMMANDE_CLIENT_ID_TYPE_DOC || $id_type_doc == $LIVRAISON_CLIENT_ID_TYPE_DOC || $id_type_doc == $TRANSFERT_ID_TYPE_DOC || $id_type_doc == $INVENTAIRE_ID_TYPE_DOC) {
		$stocks = getArticle_qte_instock ($_REQUEST['ref_article'], $id_stock);
		$stocks_qte = 0;
		if (isset($stocks->qte)) {$stocks_qte = $stocks->qte;}
	}
// *************************************************************************************************************
// AFFICHAGE
// -*************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_documents_line_maj_qte.inc.php");
}
?>