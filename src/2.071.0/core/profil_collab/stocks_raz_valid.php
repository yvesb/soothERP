<?php
// *************************************************************************************************************
// REMISE A ZERO D'UN STOCK
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");


if (isset($_REQUEST["id_stock"])) {
$stock	= $_SESSION['stocks'][$_REQUEST["id_stock"]];


	$id_type_doc = $INVENTAIRE_ID_TYPE_DOC;
	
	
	//inventaire des art_categ
	$list_art_categ =	get_articles_categories();
	$GLOBALS['_OPTIONS']['CREATE_DOC']['art_categs'] = array();
	foreach ($list_art_categ as $art_categ) {
		$i = count($GLOBALS['_OPTIONS']['CREATE_DOC']['art_categs']);
		$GLOBALS['_OPTIONS']['CREATE_DOC']['art_categs'][$i] =	$art_categ->ref_art_categ;
	}
	
	if (isset($_REQUEST["id_stock"])) {
		$GLOBALS['_OPTIONS']['CREATE_DOC']['id_stock'] = $_REQUEST["id_stock"];

	}
	
	$document = create_doc ($id_type_doc);

	$infos = array();
	$infos['type_of_line']	=	"information";
	$infos['titre']	=	"RAZ du stock";
	$infos['texte']	=	"";
	$document->add_line ($infos);
	
	$document->define_art_categ ($GLOBALS['_OPTIONS']['CREATE_DOC']['art_categs']);

	$document->maj_etat_doc (46);



// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_stocks_raz_valid.inc.php");
}
?>