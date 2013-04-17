<?php
// *************************************************************************************************************
// Modification des commissions
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");


if (isset($_REQUEST['id_commission_regle'])) {	
	// *************************************************
	// Controle des données fournies par le formulaire
	$lib_comm				= $_REQUEST['lib_comm_'.$_REQUEST['id_commission_regle']];
	$formule_comm		= $_REQUEST['formule_comm_'.$_REQUEST['id_commission_regle']];


	// *************************************************
	// Création de la catégorie
	$commission_liste = new commission_liste ($_REQUEST['id_commission_regle']);
	$commission_liste->modification ($lib_comm, $formule_comm);
}

// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_commission_mod.inc.php");

?>