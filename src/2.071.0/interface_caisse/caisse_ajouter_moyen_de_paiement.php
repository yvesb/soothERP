<?php
// *************************************************************************************************************
// MAJ DE L'ETAT D'UN TICKET
// *************************************************************************************************************
	
	
	require ("_dir.inc.php");
	require ("_profil.inc.php");
	require ("_session.inc.php");

	if (!isset($_REQUEST['ref_ticket']) || $_REQUEST['ref_ticket'] == "") {
		echo "La référence du ticket n'est pas spécifiée";
		exit;
	}
	$ticket = open_doc($_REQUEST['ref_ticket']);
	
	if (!isset($_REQUEST['moyen_de_paiement']) || $_REQUEST['moyen_de_paiement'] == "") {
		echo "Le moyen de paiememnt n'est pas spécifié";
		exit;
	}
	$mdp = $_REQUEST['moyen_de_paiement'];
	
	$mdp_lib = ""; //@TODO Prendre les moyen de paiement dans la BD
	
	switch ($mdp){
		case "mdp_cheque": {
			$mdp_lib = "Chèque";
			break;
		}
		case "mdp_cb": {
			$mdp_lib = "Carte Bancaire";	
				break;
			}
		case "mdp_especes": {
				$mdp_lib = "Espèces";
				break;
			}
		case "mdp_compte": {
				$mdp_lib = "En Compte";
				break;
			}
	case "mdp_avoir": {
				$mdp_lib = "Avoir"; //@TODO mettre la provenance de cet avoir
				break;
			}
		default: {
			$mdp_lib = $mdp;
			break;
		}
	}
	
	
	$motant = round($ticket->getMontant_to_pay(),2);
	
// *************************************************************************************************************
// AFFICHAGE 
// *************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_caisse_ajouter_moyen_de_paiement.inc.php");

?>