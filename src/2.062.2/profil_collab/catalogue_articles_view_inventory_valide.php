<?php
// *************************************************************************************************************
// INVENTAIRE RAPIDE POUR UN ARTICLE SEUL
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");


//**************************************
// Controle
	if (!isset($_REQUEST['ref_article_inventory'])) {
		echo "La référence de l'article n'est pas précisée";
		exit;
	}

	$article = new article ($_REQUEST['ref_article_inventory']);
	if (!$article->getRef_article()) {
		echo "La référence de l'article est inconnue";		exit;

	}
	$GLOBALS['_OPTIONS']['CREATE_DOC']['id_stock'] = $_REQUEST["id_stock_inventory"];
	$document = create_doc ($INVENTAIRE_ID_TYPE_DOC);
	
	
	$infos = array();
	$infos['type_of_line']	=	"article";
	$infos['sn']						= array();
	
	if ($article->getGestion_sn() == 1) {
		foreach ($_REQUEST as $variable => $valeur) {
			if (substr ($variable, 0, 7) != "art_sn_") {continue;}
			if ($valeur != "") {
				$infos['sn'][]					=	$valeur;
			}
		}
	}
	
	if ($article->getGestion_sn() == 2) {
		foreach ($_REQUEST as $variable => $valeur) {
			if (substr ($variable, 0, 7) != "art_nl_") {continue;}
			if ($valeur != "" && isset($_REQUEST[str_replace("art_", "qte_", $variable)]) && is_numeric($_REQUEST[str_replace("art_", "qte_", $variable)]) ) {
                                $infos['sn'][]	= array("nl"    =>  $_REQUEST[$variable],
                                                        "qte"   =>  $_REQUEST[str_replace("art_", "qte_", $variable)]);
			}
		}
	}
	$infos['ref_article']		=	$_REQUEST['ref_article_inventory'];
	$infos['qte']			=	$_REQUEST['qte_inventory'];
	$document->add_line ($infos);
	$document-> maj_etat_doc (46);

// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_catalogue_articles_view_inventory_valide.inc.php");

?>