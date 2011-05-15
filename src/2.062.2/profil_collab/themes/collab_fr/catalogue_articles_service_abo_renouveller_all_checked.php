<?php
// *************************************************************************************************************
// INVENTAIRE RAPIDE POUR UN ARTICLE SEUL
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");


//**************************************
// Controle

	if(!isset($_REQUEST["tab_ref_article"])) {
		echo "Les références des articles ne sont pas précisées";
		exit;
	}
	echo $_REQUEST["tab_ref_article"]."<br/>";
	$tab_ref_article = explode(";", $_REQUEST["tab_ref_article"]);
	
	if(!isset($_REQUEST["tab_id_abo"])) {
		echo "Les id des articles ne sont pas précisés";
		exit;
	}
	echo $_REQUEST["tab_id_abo"]."<br/>";
	$tab_id_abo = explode(";", $_REQUEST["tab_id_abo"]);
	
	if(!isset($_REQUEST["tab_ref_contact"])) {
		echo "Les reférences contacts ne sont pas précisées";
		exit;
	}
	echo $_REQUEST["tab_ref_contact"]."<br/>";
	$tab_ref_contact = explode(";", $_REQUEST["tab_ref_contact"]);
	
	$nb_id = count($tab_id_abo);
	$nb_ref_article = count($tab_ref_article);
	$nb_ref_contact = count($tab_ref_contact);
	
	if($nb_id != $nb_ref_article || $nb_id != $nb_ref_contact){
		echo "nb_ids != nb_ref_articles ou nb_id != nb_ref_contact";
		exit;
	}
	
	for ($i = 0; $i<$nb_id; $i++){
		$article = new article($tab_ref_article[$i]);
		if (!$article->getRef_article()) {
			echo "La référence de l'article est inconnue";
			exit;
		}
		
		$GLOBALS['_OPTIONS']['CREATE_ABO']['id_abo'] = $tab_id_abo[$i];
		$abonnement = $article->charger_abonnement($tab_id_abo[$i]);
		
		$document = create_doc ($LIVRAISON_CLIENT_ID_TYPE_DOC);

		$document->maj_contact ($tab_ref_contact[$i]);
		
		if ($abonnement->date_echeance != "0000-00-00 00:00:00") {
			$document->maj_date_creation ($abonnement->date_echeance);
		}
		
		$infos = array();
		$infos['type_of_line']	=	"article";
		$infos['sn'] = array();
		
		foreach ($_REQUEST as $variable => $valeur) {
			if (substr ($variable, 0, 7) != "art_sn_") {continue;}
			if ($valeur != "") {
				$infos['sn'][]					=	$valeur;
			}
		}
		$infos['ref_article'] =	$tab_ref_article[$i];
		$infos['qte'] =	$article->calcul_prorata_abonnement ($tab_ref_article[$i], 1);
	
	
		// gestion facturation immédiate ?
		$GLOBALS['_OPTIONS']['CREATE_DOC']['not_generer_facture'] = 1;
		$GLOBALS['_OPTIONS']['CREATE_DOC']['maj_etat_copie_doc'] = 18;
		if (($document->getRef_contact () && $document->getClient_facturation () == "immediate" ) || (!$document->getRef_contact () && $FACTURE_IMMEDIATE )) { unset($GLOBALS['_OPTIONS']['CREATE_DOC']['not_generer_facture']); }
		$document->add_line($infos);
		$document->maj_etat_doc(15);
		
	}
	// *************************************************************************************************************
	// AFFICHAGE
	// *************************************************************************************************************
			
	include ($DIR.$_SESSION['theme']->getDir_theme()."page_catalogue_articles_service_abo_renouveller_all_checked.inc.php");

?>