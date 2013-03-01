<?php
// *************************************************************************************************************
// AJOUT D'UN NUMERO DE SERIE A UN LIGNE DE DOCUMENT
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");



		
if (isset($_REQUEST['ref_doc'])) {
// ouverture des infos du document et mise à jour
	$document = open_doc ($_REQUEST['ref_doc']);
	//($_REQUEST['ref_doc_line'], $_REQUEST['sn']);
	$page_to_show	= 0;
	if (isset($_REQUEST["page_to_show"])) {
		$page_to_show	= $_REQUEST["page_to_show"]-1;
	}
	$query_limit	= "LIMIT ".(($page_to_show)*$DOC_AFF_QTE_SN).", ".$DOC_AFF_QTE_SN;
	
	$debut = (($page_to_show)*$DOC_AFF_QTE_SN);
	$liste_sn = array();
	$query = "SELECT dls.numero_serie , 
										(	SELECT COUNT(numero_serie)
											FROM stocks_articles_sn sas
											WHERE sas.numero_serie = dls.numero_serie)as sn_exist
						FROM docs_lines_sn dls
						WHERE dls.ref_doc_line = '".$_REQUEST['ref_doc_line']."'
						".$query_limit."
						";
	$resultat = $bdd->query ($query);
	while ($tmp = $resultat->fetchObject()) {	$liste_sn[] = $tmp;	}
	
	$infos_doc_line = $document->return_infos_from_ref_doc_line ($_REQUEST['ref_doc_line']);
	
	$count_aff_sn = $DOC_AFF_QTE_SN;
	
	if ((($page_to_show+1)*$DOC_AFF_QTE_SN) > $infos_doc_line->qte ) {
		if ($page_to_show > 0) {
			$count_aff_sn = ($infos_doc_line->qte - (($page_to_show)*$DOC_AFF_QTE_SN));
		} else {
			$count_aff_sn = $infos_doc_line->qte;
		}
	}
// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_documents_line_article_sn_list.inc.php");
}

?>