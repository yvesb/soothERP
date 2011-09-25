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

$reponses[1] 	= "CA";
$valeures[1] 	= $_REQUEST["assistant_comm_val_step1_CA"];

$reponses["1a"] 	= "Mg";
$valeures["1a"] 	= $_REQUEST["assistant_comm_val_step1_Mg"];

	
if (isset($_REQUEST["assistant_comm_rep_step2"])) {
	switch ($_REQUEST["assistant_comm_rep_step2"]) {
		case "CDC":
			$reponses[2] 	= "CDC";
			break;
		case "FAC":
			$reponses[2] 	= "FAC";
			break;
		case "RGM":
			$reponses[2] 	= "RGM";
			break;
	}
}


$cellule_cible	=	$_REQUEST["assistant_comm_cellule"];

$formule = formule_comm::recept_formule ($reponses, $valeures);



	
// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_commission_formule.inc.php");

?>