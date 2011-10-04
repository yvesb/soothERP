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
	
	$id_type_doc = $document->getID_TYPE_DOC ();
	$ref_contact = $document->getRef_contact ();

	$liste_contenu = $document->getContenu ();
	
	
	$liste_articles = array();
	$liste_categories = array();
	$liste_modele = array();
	$calcul_total = array("pa_ht"=>0, "ptt_ht"=>0);
	foreach ($liste_contenu as $contenu) {
		if ($contenu->ref_doc_line_parent != "" || $contenu->type_of_line != "article" || !$contenu->visible) {continue;}
		$tmp_article = new article ($contenu->ref_article);
		//on ajoute le pa de l'article dans la ligne
		if(!empty($contenu->pa_ht)){
			$pa_article = $contenu->pa_ht ;
		} else {
			$pa_article = $tmp_article->getPaa_ht ();
			if ( $tmp_article->getPrix_achat_ht ()) {
				$pa_article = $tmp_article->getPrix_achat_ht ();
			}
		}
		
		
		if (!isset($liste_articles[$tmp_article->getRef_article()]["pa_ht"])) {$liste_articles[$tmp_article->getRef_article()]["pa_ht"] = 0; $liste_articles[$tmp_article->getRef_article()]["pt_ht"] = 0;}
		$liste_articles[$tmp_article->getRef_article()]["lib_article"] = $contenu->lib_article;
		$liste_articles[$tmp_article->getRef_article()]["pa_ht"] += round ($pa_article * $contenu->qte, $CALCUL_TARIFS_NB_DECIMALS);
		$liste_articles[$tmp_article->getRef_article()]["pt_ht"] += round ($contenu->pu_ht * $contenu->qte * (1-$contenu->remise/100), $CALCUL_TARIFS_NB_DECIMALS);
		
		if (!isset($liste_modele[$tmp_article->getModele()]["pa_ht"])) {$liste_modele[$tmp_article->getModele()]["pa_ht"] = 0; $liste_modele[$tmp_article->getModele()]["pt_ht"] = 0;}
		$liste_modele[$tmp_article->getModele()]["modele"] = $tmp_article->getModele();
		$liste_modele[$tmp_article->getModele()]["pa_ht"] += round ($pa_article * $contenu->qte, $CALCUL_TARIFS_NB_DECIMALS);
		$liste_modele[$tmp_article->getModele()]["pt_ht"] += round ($contenu->pu_ht * $contenu->qte * (1-$contenu->remise/100), $CALCUL_TARIFS_NB_DECIMALS);
		
		if (!isset($liste_categories[$tmp_article->getRef_art_categ()]["pa_ht"])) {$liste_categories[$tmp_article->getRef_art_categ()]["pa_ht"] = 0; $liste_categories[$tmp_article->getRef_art_categ ()]["pt_ht"] = 0;}
		$liste_categories[$tmp_article->getRef_art_categ()]["lib_categ"] = $tmp_article->getLib_art_categ ();
		$liste_categories[$tmp_article->getRef_art_categ ()]["pa_ht"] += round ($pa_article * $contenu->qte, $CALCUL_TARIFS_NB_DECIMALS);
		$liste_categories[$tmp_article->getRef_art_categ ()]["pt_ht"] += round ($contenu->pu_ht * $contenu->qte * (1-$contenu->remise/100), $CALCUL_TARIFS_NB_DECIMALS);
		
		
		$calcul_total["pa_ht"] += round ($pa_article * $contenu->qte, $CALCUL_TARIFS_NB_DECIMALS);
		$calcul_total["ptt_ht"] += round ($contenu->pu_ht * $contenu->qte * (1-$contenu->remise/100), $CALCUL_TARIFS_NB_DECIMALS);
	}
	$count_deg = count($liste_articles)+count($liste_modele)+count($liste_categories)+1;
	$degrader = rainbowDegrader($count_deg, array('240','191','58'), array('0','74','153'));

	
	// *************************************************************************************************************
	// AFFICHAGE
	// *************************************************************************************************************
	include ($DIR.$_SESSION['theme']->getDir_theme()."page_documents_marges.inc.php");
}

?>