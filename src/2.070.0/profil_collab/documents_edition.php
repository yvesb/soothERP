<?php
// *************************************************************************************************************
// OUVERTURE D'UN DOCUMENT EN MODE EDITION
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");


if (isset($_REQUEST["ref_doc"])) {

	$ref_doc= $_REQUEST["ref_doc"];
	$GLOBALS['_OPTIONS']['CREATE_DOC']['no_charge_all_sn'] = 1;
	$document = open_doc ($ref_doc);
	if (is_object($document)) {
	$id_type_doc = $document->getID_TYPE_DOC ();
		$id_type_groupe = $document->getId_type_groupe();
		if ( !($id_type_groupe == 1 && $_SESSION['user']->check_permission ("26",$id_type_doc)) && !($id_type_groupe == 2 && $_SESSION['user']->check_permission ("29",$id_type_doc)) && !($id_type_groupe == 3 && $_SESSION['user']->check_permission ("32",$id_type_doc)) && !($id_type_groupe == 0 && $_SESSION['user']->check_permission ("44")) ) {
			if ( !($id_type_groupe == 1 && $_SESSION['user']->check_permission ("25",$id_type_doc)) && !($id_type_groupe == 2 && $_SESSION['user']->check_permission ("28",$id_type_doc)) && !($id_type_groupe == 3 && $_SESSION['user']->check_permission ("31",$id_type_doc)) ) {
			 	echo "<br /><span style=\"font-weight:bolder;color:#FF0000;\">Vos droits  d'accés ne vous permettent pas de visualiser ce type de document</span>";
			 	exit;
			}else{
				?>
				<script type="text/javascript">
				window.location.replace("documents_editing.php?ref_doc=<?php echo $_REQUEST["ref_doc"]?>");
				</script>
				<?php 
			}
		}else{
				
			//permission (6) Accès Consulter les prix d'achat
			if (!$_SESSION['user']->check_permission ("6") && $id_type_doc == $FACTURE_FOURNISSEUR_ID_TYPE_DOC) {
					//on indique l'interdiction et on stop le script
					echo "<br /><span style=\"font-weight:bolder;color:#FF0000;\">Vos droits  d'accés ne vous permettent pas de visualiser ce type de document</span>";
					exit();
			}
				$ref_contact = $document->getRef_contact ();
				
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
		$echeances = $document->getEcheancier();
		$nb_echeances_restantes = $document->getNb_echeances_restantes ();
		$montant_acquite = 0;
		$liste_reglement_valide = array();		
		//liaisons du document
		$doc_liaisons_possibles = $document->getLiaisons_possibles ();
		$doc_liaisons = $document->getLiaisons ();
	
		$liste_commerciaux = $document->getCommerciaux ();
		
		// *************************************************************************************************************
		// AFFICHAGE
		// -*************************************************************************************************************
	
		include ($DIR.$_SESSION['theme']->getDir_theme()."page_documents_edition.inc.php");
		}
	}
}
?>