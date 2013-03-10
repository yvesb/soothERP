<?php
// *************************************************************************************************************
// ACCUEIL DE L'UTILISATEUR ADMINISTRATEUR
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");


// Controle


$reponses=array();
$valeures=array();

if (isset($_REQUEST["assistant_rep_step1"])) {
	switch ($_REQUEST["assistant_rep_step1"]) {
		case "AR":
			$reponses[1] 	= "AR";
			$valeures[1] 	= $_REQUEST["assistant_val_step1_arb"];
			break;
		case "PP":
			$reponses[1] 	= "PP";
			$valeures[1] 	= 0;
			break;
		case "PA":
			$reponses[1] 	= "PA";
			$valeures[1] 	= 0;
			break;
	}
} else {
			$reponses[1] 	= "AR";
			$valeures[1] 	= $_REQUEST["assistant_val_step1_arb"];
	}
	
	$champ_retour="assistant_val_step2_marge";
if (isset($_REQUEST["assistant_rep_step2"])) {
	switch ($_REQUEST["assistant_rep_step2"]) {
		case "MARGE":
			$reponses[2] 	= "MARGE";
			$valeures[2] 	= $_REQUEST["assistant_val_step2_marge"];
			$champ_retour =	"assistant_val_step2_marge";
			break;
		case "MULTI":
			$reponses[2] 	= "MULTI";
			$valeures[2] 	= $_REQUEST["assistant_val_step2_multi"];
			$champ_retour =	"assistant_val_step2_multi";
			break;
		case "ADD":
			$reponses[2] 	= "ADD";
			$valeures[2] 	= $_REQUEST["assistant_val_step2_addition"];
			$champ_retour =	"assistant_val_step2_addition";
			break;
		default:
			$reponses[2] 	= "ADD";
			$valeures[2] 	= "+0";
			break;
	}
	}
	else {
			$reponses[2] 	= "ADD";
			$valeures[2] 	= "+0";	
}
	
if (isset($_REQUEST["assistant_rep_step3_arrondi"])) {
			$reponses[3] 	= $_REQUEST["assistant_rep_step3_arrondi"];
			$valeures[3] 	= $_REQUEST["assistant_rep_step3_pas"];
			} else {
			$reponses[3] 	= "PAS";
			$valeures[3] 	= "0";
}
	 
if (isset($_REQUEST["assistant_rep_step4"])) {
			$reponses[4] 	= $_REQUEST["assistant_rep_step4"];
			} else {
			$reponses[4] 	= "";
}


$cellule_cible	=	$_REQUEST["assistant_cellule"];

$formule = formule_tarif::recept_formule ($reponses, $valeures);



	
// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_catalogue_liste_tarifs_formule.inc.php");

?>