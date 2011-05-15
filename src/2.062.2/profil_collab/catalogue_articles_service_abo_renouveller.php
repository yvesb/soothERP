<?php
// *************************************************************************************************************
// INVENTAIRE RAPIDE POUR UN ARTICLE SEUL
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");


//**************************************
// Controle

	if (!isset($_REQUEST['ref_article_service_renouveller_'.$_REQUEST["id_abo"]])) {
		echo "La référence de l'article n'est pas précisée";
		exit;
	}

	$ref_contact = $_REQUEST['ref_contact_service_renouveller_'.$_REQUEST["id_abo"]];
	
	$id_abo = $_REQUEST["id_abo"];
					
	$article = new article ($_REQUEST['ref_article_service_renouveller_'.$_REQUEST["id_abo"]]);
	
	
	if (!$article->getRef_article()) {
		echo "La référence de l'article est inconnue";
		exit;
	}
	
	$GLOBALS['_OPTIONS']['CREATE_ABO']['id_abo'] = $_REQUEST["id_abo"];
	$abonnement = $article->charger_abonnement($_REQUEST["id_abo"]);
	
	$document = create_doc ($LIVRAISON_CLIENT_ID_TYPE_DOC);
	
	
	$document->maj_contact ($_REQUEST['ref_contact_service_renouveller_'.$_REQUEST["id_abo"]]);
	
	if ($abonnement->date_echeance != "0000-00-00 00:00:00") {
		$document->maj_date_creation ($abonnement->date_echeance);
	}
	
	$infos = array();
	$infos['type_of_line']	=	"article";
	$infos['sn']						= array();
	
	foreach ($_REQUEST as $variable => $valeur) {
		if (substr ($variable, 0, 7) != "art_sn_") {continue;}
		if ($valeur != "") {
			$infos['sn'][]					=	$valeur;
		}
	}
	$infos['ref_article']		=	$_REQUEST['ref_article_service_renouveller_'.$_REQUEST["id_abo"]];
	$infos['qte']						=	$article->calcul_prorata_abonnement ($_REQUEST["id_abo"], $_REQUEST['reconduction_service_renouveller_'.$_REQUEST["id_abo"]]);


	// gestion facturation immédiate ?
	$GLOBALS['_OPTIONS']['CREATE_DOC']['not_generer_facture'] = 1;
	$GLOBALS['_OPTIONS']['CREATE_DOC']['maj_etat_copie_doc'] = 18;
	if (($document->getRef_contact () && $document->getClient_facturation () == "immediate" ) || (!$document->getRef_contact () && $FACTURE_IMMEDIATE )) { unset($GLOBALS['_OPTIONS']['CREATE_DOC']['not_generer_facture']); }
	$document->add_line($infos);
	$document->maj_etat_doc(15);

	
	if(isset($_REQUEST["source"])) {
		$source = $_REQUEST["source"];
	}
	if(isset($_REQUEST["cibles_a_Updater"])) {
		$cibles_a_Updater = unserialize($_REQUEST["cibles_a_Updater"]);
	}

// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_catalogue_articles_service_abo_renouveller.inc.php");

?>