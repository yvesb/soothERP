<?php
require ("_dir.inc.php");
require ($DIR."_session.inc.php");
require_once $DIR.'config/config_mail.inc.php';

$etatDoc = 'vente';
if(!$articlesStock = article::getAllInsufStockByStock($etatDoc)){
	die();
}

switch ($etatDoc) {
	case 'vente':
		$libMessage = "dont les <span style='color:blue'>commandes en cours</span> soustraites au stock existant ne permettent pas de fournir tous vos clients.";
	 break;
	case 'prepa':
		$libMessage = "dont les <span style='color:blue'>livraison en préparation</span> soustraites au stock existant ne permettent pas de livrer tous vos clients.";
	 break;
	case 'attente':
		$libMessage = "dont les <span style='color:blue'>commandes en attente</span> soustraites au stock existant ne permettent pas de fournir tous vos clients.";
	 break;
	default:
		$libMessage = "";
	 break;
}
$mailer = new email();
$mailer->prepare_envoi(0,0);

foreach($articlesStock as $id_stock => $articles){
	$template = new template($TPL_MODELES_DIR."modele_verif_stock.tpl");
	$title = 'Alerte stock '.article::getLibStock($id_stock);
	$template->_assign_vars(array(
		"NBARTICLES"=>count($articles),
		'TITLE'=>$title,
		'LIBMESSAGE'=>$libMessage));
	$assignedArticle = array();
	foreach($articles as $ref_article =>$article){
		$art = new stdclass();
		$art->ref_article = $ref_article;
		$art->lib_article = article::getLibArticle($ref_article);
		$art->qteStock = $article['stock'];
		$art->qteSorties = $article['sorties'];
		$art->qteMini = $article['mini'];
		$assignedArticle[] = $art;
	}
	$template->_assign_block_vars("articles", $assignedArticle, true);
	$mail = $template->generate_html();
	$mailer->envoi($MAIL_ALERTE_STOCK, $title, $mail);
}
?>
