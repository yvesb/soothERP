<?php
// *************************************************************************************************************
// CHARGEMENT D'UN TICKET DE CAISSE 
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ("_session.inc.php");


if(!isset($_REQUEST['ref_article'])){
	echo "La référence de l'article n'est pas spécifiée";
	exit;	
}
$ref_article = $_REQUEST['ref_article'];

$document = null;
if(isset( $_REQUEST['ref_ticket'] ) && $_REQUEST['ref_ticket'] != ""){
	$document = open_doc($_REQUEST['ref_ticket']);
}else{	//Nouveau Ticket de caisse

	// Par précotion, on efface toutes les variables de création de documents
	unset($GLOBALS['_OPTIONS']['CREATE_DOC']);

	$document = create_doc($TICKET_CAISSE_ID_TYPE_DOC);

	if (isset($_REQUEST['ref_contact']) && $_REQUEST['ref_contact'] != "") {
		$contact = new contact($_REQUEST['ref_contact']);
		$document->maj_contact($contact->getRef_contact());
		
		$adresses = $contact->getAdresses();
		if(count($adresses)>0)
			{$document->maj_adresse_contact($adresses[0]->getRef_adresse());}
		unset($contact, $adresses);
	}
}

//AJOUT D'UNE LIGNE
//structure du tableau $infos
$infos = array();
$infos['type_of_line']	=	"article";
$infos['sn']						= array();
if (isset($_REQUEST['num_serie']) && $_REQUEST['num_serie'] != "") {
	$infos['sn'][]					=	$_REQUEST['num_serie'];
}
$infos['ref_article']		=	$ref_article;
$infos['qte']						=	1;

unset($GLOBALS['_INFOS']['new_lines']);
$document->add_line($infos);

foreach ($GLOBALS['_INFOS']['new_lines'] as $new_line){
	if ($new_line->ref_doc_line_parent == null){//substr($new_line->ref_article, 0, 2) == "A-" && 
		$ligne = $new_line;
		break;
	}
}
unset($GLOBALS['_INFOS']['new_lines']);

$article = new article($ref_article);
document::maj_line_lib_article($ligne->ref_doc_line, $article->getLib_ticket());
$ligne->lib_article = $article->getLib_ticket(); 

unset($article);

$montant_to_pay = $document->getMontant_to_pay();

include ($DIR.$_SESSION['theme']->getDir_theme()."page_caisse_ajouter_article.inc.php");

?>