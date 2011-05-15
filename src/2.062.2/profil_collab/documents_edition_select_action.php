<?php
// *************************************************************************************************************
// NOUVEAU DOCUMENT
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");


if (isset($_REQUEST['ref_doc'])) {

// ouverture des infos du document et mise à jour
	$lines = array();
	if (isset ($_REQUEST['lines'])) {
	$lines = $_REQUEST['lines'];
	}
	$document = open_doc ($_REQUEST['ref_doc']);
	switch ($_REQUEST['action']) {
		case "delete_multiples_lines" :
			$document->delete_multiples_lines ($lines);
		break;
		case 'generer_commande_client' :
			$document->generer_commande_client ($lines);
		break;
		case 'generer_bl_client'  :
			$document->generer_bl_client ($lines);
		break;
		case 'generer_fa_client'  :
			$document->generer_fa_client ();
		break;
		case 'generer_facture_avoir_client'  :
			$document->generer_facture_avoir_client ($lines);
		break;
		case 'generer_devis_client'  :
			$document->generer_devis_client ($lines);
		break;
		case 'generer_retour_client'  :
			$document->generer_retour_client ($lines);
		break;
		case 'reset_pu_ht'  :
			$document->reset_pu_ht ($lines);
		break;
		case 'set_pu_ht_to_id_tarif'  :
			$document->set_pu_ht_to_id_tarif ($lines, $_REQUEST['id_tarif']);
		break;
		case 'generer_fa_fournisseur'  :
			$document->generer_fa_fournisseur ($lines);
		break;
		case 'generer_br_fournisseur'  :
			$document->generer_br_fournisseur ($lines);
		break;
		case 'generer_retour_fournisseur'  :
			$document->generer_retour_fournisseur ($lines);
		break;
		case 'generer_commande_fournisseur'  :
			$document->generer_commande_fournisseur ($lines);
		break;
		case 'generer_devis_fournisseur'  :
			$document->generer_devis_fournisseur ($lines);
		break;
	}
}



include ($DIR.$_SESSION['theme']->getDir_theme()."page_documents_edition_select_action.inc.php");
?>