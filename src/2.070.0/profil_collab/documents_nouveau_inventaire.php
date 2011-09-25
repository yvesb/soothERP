<?php
// *************************************************************************************************************
// OUVERTURE D'UN DOCUMENT EN MODE CREATION SPECIFIQUE POUR INVENTAIRE
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");


		
		
if (isset($_REQUEST['id_type_doc'])) {

	$id_type_doc = $_REQUEST['id_type_doc'];
	
	if (isset($_REQUEST['ref_contact'])) {$GLOBALS['_OPTIONS']['CREATE_DOC']['ref_contact'] =  $_REQUEST['ref_contact'];}
	
	//on envois en param la liste des art_categ séléectionnées
	$GLOBALS['_OPTIONS']['CREATE_DOC']['art_categs'] = array();
	foreach ($_REQUEST as $variable => $valeur) {
		if (substr ($variable, 0, 4) != "ins_") { continue; }
		$i = count($GLOBALS['_OPTIONS']['CREATE_DOC']['art_categs']);
		$GLOBALS['_OPTIONS']['CREATE_DOC']['art_categs'][$i] =	$valeur;
	}
	
	if (isset($_REQUEST["pre_remplir"])) {
		$GLOBALS['_OPTIONS']['CREATE_DOC']['pre_remplir'] = 1;
	}
	if (isset($_REQUEST["id_stock"])) {
		$GLOBALS['_OPTIONS']['CREATE_DOC']['id_stock'] = $_REQUEST["id_stock"];
		if (isset($_REQUEST["stock_error"])) {
			$erreurs_stock = $_SESSION['stocks'][$_REQUEST["id_stock"]]->erreurs_stock ();
		}
	}
	
	$document = create_doc ($id_type_doc);
	
	//si remplissage de l'inventaire par les articles en erreur de stock
	if (isset($erreurs_stock) && count($erreurs_stock)) {
	
		$infos = array();
		$infos['type_of_line']	=	"information";
		$infos['titre']	=	"Correction d'erreurs de stocks";
		$infos['texte']	=	"";
		$document->add_line ($infos);
			
		foreach ($erreurs_stock as $article_en_erreur) {
			$infos = array();
			$infos['type_of_line']	=	"article";
			$infos['ref_article']		=	$article_en_erreur->ref_article;
			$infos['qte']						=	"0";
			$document->add_line ($infos);
		}
	}
	//si un montant est négatif
	$montant_negatif = false;
	$montant_positif = 1;
	if (isset($_REQUEST["montant_neg"])) { $montant_negatif = true; $montant_positif = -1;}
			
	
}
//liste des types de documents
$types_liste	= array();
$types_liste = $_SESSION['types_docs'];


//liste des constructeurs
$constructeurs_liste = array();
$constructeurs_liste = get_constructeurs ();
	

//liste des lieux de stockage
$stocks_liste	= array();
$stocks_liste = $_SESSION['stocks'];

//liste des tarifs
get_tarifs_listes ();
$tarifs_liste	= array();
$tarifs_liste = $_SESSION['tarifs_listes'];	

//infos pour mini moteur de recherche contact
$profils_mini = array();
foreach ($_SESSION['profils'] as $profil) {
	if ($profil->getActif() != 1) { continue; }
	$profils_mini[] = $profil;
}
unset ($profil);
foreach ($_SESSION['profils'] as $profil) {
	if ($profil->getActif() != 2 ) { continue; }
	$profils_mini[] = $profil;
}
unset ($profil);


$ANNUAIRE_CATEGORIES	=	get_categories();

//liaisons du document
$doc_liaisons_possibles = $document->getLiaisons_possibles ();
$doc_liaisons = $document->getLiaisons ();

// *************************************************************************************************************
// AFFICHAGE
// -*************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_documents_edition.inc.php");

?>