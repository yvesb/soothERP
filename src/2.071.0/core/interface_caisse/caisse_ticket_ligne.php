<?php
//  ******************************************************
// LIGNE D'UN TICKET DE CAISSE
//  ******************************************************

require ("_dir.inc.php");
require ("_profil.inc.php");
require ("_session.inc.php");

//paramètres demandés
//id_ligne
//ref_article
//ref_doc
//qte_article
//num_serie -> optionnel

if (!isset($_REQUEST['id_ligne'])) {
	echo "La l'id de la ligne du ticket n'est pas précisé";
	exit;
}
$id_ligne = $_REQUEST['id_ligne'];

if (!isset($_REQUEST['ref_article'])) {
	echo "La référence de l'article n'est pas précisée";
	exit;
}
$ref_article = $_REQUEST['ref_article'];

if (!isset($_REQUEST['ref_doc'])) {
	echo "La référence du document n'est pas précisé";
	exit;
}
$document = $document = open_doc($_REQUEST['ref_doc']);

$qte_article = 1;
if ( isset($_REQUEST['qte_article']) && $_REQUEST['qte_article'] !=""){
	$qte_article = $_REQUEST['qte_article'];
}


//structure du tableau $infos
$infos = array();
$infos['type_of_line']	=	"article";
$infos['sn']						= array();
if (isset($_REQUEST['num_serie']) && $_REQUEST['num_serie'] != "") {
	$infos['sn'][]					=	$_REQUEST['num_serie'];
}
$infos['ref_article']		=	$ref_article;
$infos['qte']						=	$qte_article;

$document->add_line($infos);

$lignes = $document->getContenu();
$ligne = $lignes[count($lignes)-1]; //On prends la dernière ligne, donc, celle qui vient d'être créé
$article = new article($ref_article);

//  ******************************************************
// AFFICHAGE
//  ******************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_caisse_ticket_ligne.inc.php");

?>