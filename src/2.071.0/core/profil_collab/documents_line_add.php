<?php
// *************************************************************************************************************
// AJOUT DE LIGNES AU DOCUMENT
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");


if (isset($_REQUEST['ref_doc'])) {

// ouverture des infos du document
	$document = open_doc ($_REQUEST['ref_doc']);
	
}
$infos = array();
	switch ($_REQUEST['type_of_line']) {
		case "article":
			$infos['type_of_line']	=	"article";
			$infos['sn']						= array();
			if (isset($_REQUEST['num_serie']) && $_REQUEST['num_serie'] != "") {
				$infos['sn'][]					=	$_REQUEST['num_serie'];
			}
			$infos['ref_article']		=	$_REQUEST['ref_article'];
			$infos['qte']						=	$_REQUEST['qte_article'];
			break;
			
		case "taxe":
			$infos['type_of_line']	=	"taxe";
			break;
			
		case "information":
		
			$infos['type_of_line']	=	"information";
			$infos['titre']	=	"";
			$infos['texte']	=	"";
			if (isset($_REQUEST['id_doc_info_line']) && $_REQUEST['id_doc_info_line'] != "") {
				$ligne_modele = charge_doc_info_line ($_REQUEST['id_doc_info_line']);
				if (is_object($ligne_modele)) {
					$infos['titre']	=	$ligne_modele->lib_line;
					$infos['texte']	=	$ligne_modele->desc_line;
				}
			}
			
			break;
			
		case "sous-total":
			$infos['type_of_line']	=	"soustotal";
			break;
	}
if (!$document->getQuantite_locked ()) {
$document->add_line ($infos);

}
// *************************************************************************************************************
// AFFICHAGE
// -*************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_documents_line_add.inc.php");
?>