<?php
// *************************************************************************************************************
// OUVERTURE D'UN DOCUMENT EN MODE CREATION 
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");

//permission (6) Accès Consulter les prix d’achat
if (!$_SESSION['user']->check_permission ("6") && isset($_REQUEST['id_type_doc']) && $_REQUEST['id_type_doc'] == $FACTURE_FOURNISSEUR_ID_TYPE_DOC) {
	//on indique l'interdiction et on stop le script
	echo "<br /><span style=\"font-weight:bolder;color:#FF0000;\">Vos droits  d'accés ne vous permettent pas de visualiser ce type de document</span>";
	exit();
}
		
		
if (isset($_REQUEST['id_type_doc']) && $_REQUEST['id_type_doc'] != "") {

	$id_type_doc = $_REQUEST['id_type_doc'];
	$id_type_groupe = document::Id_type_groupe($id_type_doc);
			if ( !($id_type_groupe == 1 && $_SESSION['user']->check_permission ("26",$id_type_doc)) && !($id_type_groupe == 2 && $_SESSION['user']->check_permission ("29",$id_type_doc)) && !($id_type_groupe == 3 && $_SESSION['user']->check_permission ("32",$id_type_doc)) ) {
	echo "<br /><span style=\"font-weight:bolder;color:#FF0000;\">Vos droits  d'accés ne vous permettent pas de créer ce type de document</span>";
	exit();
	}
	if (isset($_REQUEST['ref_contact'])) {$GLOBALS['_OPTIONS']['CREATE_DOC']['ref_contact'] =  $_REQUEST['ref_contact'];}
	
	$document = create_doc ($id_type_doc);
	
	if (is_object($document)) {
		if (isset($_REQUEST["ref_article"]) && isset($_REQUEST["qte"]) && ($id_type_doc == $FABRICATION_ID_TYPE_DOC || $id_type_doc == $DESASSEMBLAGE_ID_TYPE_DOC)) {
			if (isset($_REQUEST["fill_content"])) {
				$GLOBALS['_OPTIONS']['CREATE_DOC']['fill_content'] = 1;
			}
			$document->define_ref_article($_REQUEST["ref_article"], $_REQUEST["qte"]);
		}
		//si un montant est négatif
		$montant_negatif = false;
		$montant_positif = 1;
		if (isset($_REQUEST["montant_neg"])) { $montant_negatif = true; $montant_positif = -1;}
				
		if ($document->getACCEPT_REGMT() != 0) {
	
			//liste des reglements_modes
			$reglements_modes	= array();
	
			if (($document->getACCEPT_REGMT() == 1 && !$montant_negatif) || ($document->getACCEPT_REGMT() == -1 && $montant_negatif)) {
				$reglements_modes = getReglements_modes ("entrant");
			}
			if (($document->getACCEPT_REGMT() == -1 && !$montant_negatif) || ($document->getACCEPT_REGMT() == 1 && $montant_negatif)) {
				$reglements_modes = getReglements_modes ("sortant");
			}
		
			$liste_reglements = $document->getReglements ();
		}
		//liaisons du document
		$doc_liaisons_possibles = $document->getLiaisons_possibles ();
		$doc_liaisons = $document->getLiaisons ();
		
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
		
		//Echeances
		$echeances = $document->getEcheancier();
		$nb_echeances_restantes = $document->getNb_echeances_restantes ();
		$montant_acquite = 0;
		$liste_reglement_valide = array();		

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
		
		
		// *************************************************************************************************************
		// AFFICHAGE
		// -*************************************************************************************************************
	
		include ($DIR.$_SESSION['theme']->getDir_theme()."page_documents_edition.inc.php");
	}
}
?>