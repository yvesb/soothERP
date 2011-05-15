<?php
// *************************************************************************************************************
// CHARGEMENT D'UN TICKET DE CAISSE 
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ("_session.inc.php");


if(!isset($_REQUEST['ref_ticket'])){
	echo "La référence du ticket n'est pas spécifiée";
	exit;	
}
$ref_ticket = $_REQUEST['ref_ticket'];

if(!isset($_REQUEST['ref_ligne'])){
	echo "La référence de la ligne n'est pas spécifiée";
	exit;	
}
$ref_ligne = $_REQUEST['ref_ligne'];

$document = open_doc($_REQUEST['ref_ticket']);


$ligne = null;
foreach ($document->getContenu() as $doc_line){
	if($doc_line->ref_doc_line == $ref_ligne){
		$ligne = $doc_line;
		break;
	}
}

/*
	structure d'une $doc_line
	object(stdClass)#158 (20) {
    ["ref_doc_line"]=> string(16) "RDL-000000-00048"
    ["ref_article"]=> string(14) "A-000000-00017"
    ["lib_article"]=> string(10) "article 01"
    ["desc_article"]=> string(34) "article complet avec description"
    ["qte"]=> string(1) "1"
    ["pu_ht"]=> float(12.86)
    ["remise"]=> string(1) "0"
    ["tva"]=> string(4) "19.6"
    ["ordre"]=> string(3) "100"
    ["ref_doc_line_parent"]=> NULL
    ["visible"]=> string(1) "1"
    ["ref_oem"]=> string(10) "1522455eom"
    ["ref_interne"]=> NULL
    ["id_valo"]=> string(1) "1"
    ["valo_indice"]=> string(1) "1"
    ["gestion_sn"]=> string(1) "0"
    ["modele"]=>string(8) "materiel"
    ["lot"]=> string(1) "0"
    ["abrev_valo"]=> string(3) "Qté"
    ["type_of_line"]=> string(7) "article"
*/

if(isset($_REQUEST['remise']) && $_REQUEST['remise']!= ""){
	$remise = $_REQUEST['remise'];
	$document->maj_line_remise($ref_ligne,$_REQUEST['remise']);
}else{$remise = $ligne->remise;}

if(isset($_REQUEST['qte']) && $_REQUEST['qte']!=""){
	$qte = $_REQUEST['qte'];
	if(1==2){
		$document = new doc_tic(0);
	}
	if($document->maj_line_qte($ref_ligne, $_REQUEST['qte']))
		echo "document->maj_line_qte(".$ref_ligne.", ".$_REQUEST['qte'].") : true\n";
	else
		echo "document->maj_line_qte(".$ref_ligne.", ".$_REQUEST['qte'].") : false\n";
	if ($document->getQuantite_locked())	
		echo "document->getQuantite_locked() : true\n";
	else
		echo "document->getQuantite_locked() : false\n";
	
	
}else{$qte = $ligne->qte;}

if(isset($_REQUEST['puttc']) && $_REQUEST['puttc']!= ""){
	$puttc = round($_REQUEST['puttc'],$CALCUL_TARIFS_NB_DECIMALS);
	$document->maj_line_pu_ht($ref_ligne, ttc2ht($_REQUEST['puttc'], $ligne->tva));
}else{
	$puttc = ht2ttc($ligne->pu_ht, $ligne->tva);
}

$montant_to_pay = $document->getMontant_to_pay();

$cell_QTE			= Icaisse::getTicket_cell_QTE($qte);
$cell_PUTTC		= Icaisse::getTicket_cell_PUTTC($puttc);
$cell_REMISE	= Icaisse::getTicket_cell_REMISE($remise);
$cell_PRIXTTC	= Icaisse::getTicket_cell_PRIXTTC($qte, $puttc, $remise);

include ($DIR.$_SESSION['theme']->getDir_theme()."page_caisse_maj_ligne.inc.php");

?>